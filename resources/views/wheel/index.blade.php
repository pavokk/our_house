<x-layouts.main title="Skagesundvegen 63 - Wheel of Chores">
    <main class="max-w-3xl m-auto mt-5 pt-5">

        <x-ui.primary-box class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl">Gjøremålshjulet</h1>
                <p>Snurr hjulet for å få tildelt en oppgave</p>
            </div>
            <div class="flex gap-2">
                <x-ui.primary-button :link="route('wheel.my-tasks')" bg="bg-dark-compliment">Mine oppgaver</x-ui.primary-button>
                <x-ui.primary-button id="new-task-btn" type="button">Nytt gjøremål</x-ui.primary-button>
            </div>
        </x-ui.primary-box>

        @if ($wheelTasks->isNotEmpty())

            <div x-data="wheelOfChores({{ count($wheelTasks) }}, {{ $wheelTasks->pluck('id')->toJson() }})" class="woc-wrapper p-14">

                <div class="wheel-pointer" aria-hidden="true"></div>

                <ul
                    class="wheel-of-chores"
                    :style="`transform: rotate(${currentRotation}deg); transition: ${isSpinning ? 'transform 4s ease-out' : 'none'}; --_items: {{ count($wheelTasks) }}`"
                    @transitionend.self="finishSpin"
                >
                    @foreach ($wheelTasks as $task)
                        <li
                            style="--_idx: {{ $loop->iteration }}"
                            @click="openModalForId({{ $task->id }}, 'Oppgavedetaljer', 'Lukk')"
                            class="cursor-pointer"
                        >
                            <p>{{ $task->title }}</p>
                        </li>
                    @endforeach
                </ul>

                <button
                    type="button"
                    @click="spin"
                    :disabled="isSpinning"
                    class="z-10"
                >
                    SPIN
                </button>

            </div>

        @else

            <x-ui.primary-box class="text-center py-12">
                <p class="text-lg text-gray-500 mb-4">Ingen oppgaver å spinne med.</p>
                <button id="new-task-btn-empty" type="button" class="px-6 py-2 bg-main-dark text-main-light rounded-lg hover:opacity-90 cursor-pointer">
                    Legg til den første oppgaven
                </button>
            </x-ui.primary-box>

        @endif

        {{-- Task detail + edit templates for ALL tasks (keyed by task ID) --}}
        @foreach ($allTasks as $task)

            <template id="task-template-{{ $task->id }}">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="task-status-badge status-{{ $task->status->value }}">
                            {{ ['todo' => 'Å gjøre', 'in_progress' => 'Pågår', 'done' => 'Ferdig'][$task->status->value] ?? ucfirst(str_replace('_', ' ', $task->status->value)) }}
                        </span>
                        @if ($task->due_date)
                            <span class="text-sm text-gray-500">Frist: {{ $task->due_date->format('d.m.Y') }}</span>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold mb-2">{{ $task->title }}</h3>

                    @if ($task->content)
                        <div class="mb-4">{!! $task->content !!}</div>
                    @endif

                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Opprettet av:</strong> {{ $task->user->name ?? 'Ukjent' }}</p>
                            <p><strong>Tildelt til:</strong> {{ $task->assignee->name ?? 'Ikke tildelt' }}</p>
                        </div>

                        <div class="flex gap-2">
                            @auth
                                @if (!$task->assignee)
                                    <button
                                        onclick="assignTask({{ $task->id }}, this)"
                                        class="px-3 py-1.5 bg-compliment text-main-dark rounded-lg text-sm hover:bg-dark-compliment"
                                    >Ta oppgaven</button>
                                @elseif ($task->assignee_id === auth()->id() && $task->status !== \App\Enums\TaskStatus::DONE)
                                    <form method="POST" action="{{ route('task.status', $task) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="done">
                                        <button type="submit" class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">
                                            Marker som ferdig
                                        </button>
                                    </form>
                                @endif

                                @if ($task->user_id === auth()->id())
                                    <button
                                        onclick="openEditTask({{ $task->id }})"
                                        class="px-3 py-1.5 bg-secondary text-main-dark rounded-lg text-sm hover:bg-dark-compliment"
                                    >Rediger</button>
                                    <form method="POST" action="{{ route('task.destroy', $task) }}" onsubmit="return confirm('Slette denne oppgaven?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">
                                            Slett
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </template>

            @if ($task->user_id === auth()->id())
                <template id="edit-task-template-{{ $task->id }}">
                    <form method="POST" action="{{ route('task.update', $task) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tittel</label>
                            <input
                                type="text"
                                name="title"
                                value="{{ $task->title }}"
                                required
                                class="border-gray-300 rounded-md shadow-sm bg-main-light h-10 px-3 w-full"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Beskrivelse</label>
                            <textarea
                                name="content"
                                rows="4"
                                class="border-gray-300 rounded-md shadow-sm bg-main-light px-3 py-2 w-full resize-none"
                            >{{ strip_tags($task->content ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Frist</label>
                            <input
                                type="date"
                                name="due_date"
                                value="{{ $task->due_date?->format('Y-m-d') }}"
                                class="border-gray-300 rounded-md shadow-sm bg-main-light h-10 px-3 w-full"
                            >
                        </div>
                        <button type="submit" class="w-full bg-main-dark text-main-light py-2 rounded-lg hover:opacity-90 cursor-pointer">
                            Lagre endringer
                        </button>
                    </form>
                </template>
            @endif

        @endforeach

        {{-- New task form template --}}
        <template id="new-task-template">
            <form method="POST" action="{{ route('task.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tittel</label>
                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="F.eks. Rydd kjøkkenet"
                        class="border-gray-300 rounded-md shadow-sm bg-main-light h-10 px-3 w-full"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Beskrivelse</label>
                    <textarea
                        name="content"
                        rows="4"
                        placeholder="Valgfri beskrivelse..."
                        class="border-gray-300 rounded-md shadow-sm bg-main-light px-3 py-2 w-full resize-none"
                    ></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Frist</label>
                    <input
                        type="date"
                        name="due_date"
                        class="border-gray-300 rounded-md shadow-sm bg-main-light h-10 px-3 w-full"
                    >
                </div>
                <button type="submit" class="w-full bg-main-dark text-main-light py-2 rounded-lg hover:opacity-90 cursor-pointer">
                    Opprett oppgave
                </button>
            </form>
        </template>

        {{-- Task list --}}
        <x-ui.primary-box class="mt-5">
            <h2 class="text-xl font-bold mb-4">Alle oppgaver</h2>

            @if ($allTasks->isEmpty())
                <p class="text-sm text-gray-500">Ingen oppgaver ennå. Opprett en ovenfor!</p>
            @else
                <div class="flex flex-col">
                    @foreach ($allTasks as $task)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0 gap-3">

                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <span class="task-status-badge status-{{ $task->status->value }} shrink-0">
                                    {{ ['todo' => 'Å gjøre', 'in_progress' => 'Pågår', 'done' => 'Ferdig'][$task->status->value] ?? ucfirst(str_replace('_', ' ', $task->status->value)) }}
                                </span>
                                <div class="min-w-0">
                                    <p class="font-medium truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $task->assignee->name ?? 'Ikke tildelt' }}
                                        @if ($task->due_date)
                                            &mdash; Frist {{ $task->due_date->format('d.m.Y') }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            @auth
                                <div class="flex gap-2 shrink-0">
                                    @if ($task->assignee_id === auth()->id() && $task->status !== \App\Enums\TaskStatus::DONE)
                                        <form method="POST" action="{{ route('task.status', $task) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="text-xs px-2 py-1 bg-compliment text-main-dark rounded hover:bg-dark-compliment">
                                                Ferdig
                                            </button>
                                        </form>
                                    @endif

                                    @if ($task->status === \App\Enums\TaskStatus::DONE && ($task->user_id === auth()->id() || $task->assignee_id === auth()->id()))
                                        <form method="POST" action="{{ route('task.status', $task) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="todo">
                                            <input type="hidden" name="clear_assignee" value="1">
                                            <button type="submit" class="text-xs px-2 py-1 bg-secondary text-main-dark rounded hover:bg-dark-compliment">
                                                Gjenåpne
                                            </button>
                                        </form>
                                    @endif

                                    <button
                                        onclick="openModalForId({{ $task->id }}, 'Oppgavedetaljer', 'Lukk')"
                                        class="text-xs px-2 py-1 bg-secondary text-main-dark rounded hover:bg-dark-compliment"
                                    >Vis</button>

                                    @if ($task->user_id === auth()->id())
                                        <form method="POST" action="{{ route('task.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                Slett
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth

                        </div>
                    @endforeach
                </div>
            @endif
        </x-ui.primary-box>

    </main>

@push('styles')
<style>

.woc-wrapper {
    display: grid;
    place-items: center;
}

.woc-wrapper > * {
    grid-area: 1 / -1;
}

:where(.wheel-of-chores) {
    --_items: {{ count($wheelTasks) }};
    all: unset;
    aspect-ratio: 1 / 1;
    background: crimson;
    container-type: inline-size;
    direction: ltr;
    display: grid;
    place-content: center start;
    clip-path: inset(0 0 0 0 round 50%);
    width: 100%;
}

.wheel-of-chores li {
    align-content: center;
    display: grid;
    grid-area: 1 / -1;
    list-style: none;
    padding-left: 1ch;
    transform-origin: center right;
    width: 50cqi;
    rotate: calc(360deg / var(--_items) * calc(var(--_idx) - 1));
    background: hsl(calc(360deg / var(--_items) * calc(var(--_idx))), 100%, 75%);
    height: calc(2 * tan(180deg / var(--_items)) * 50cqi);
    clip-path: polygon(0% -2%, 100% 50%, 0% 102%);
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s ease-out, filter 0.2s ease-out;
}

.wheel-of-chores li:hover {
    filter: brightness(1.1);
    transform: scale(1.05);
    z-index: 9;
}

.wheel-of-chores li p {
    padding-left: 10px;
}

.woc-wrapper button {
    aspect-ratio: 1 / 1;
    background: hsla(0, 0%, 100%, .8);
    border: 0;
    border-radius: 50%;
    cursor: pointer;
    font-size: 2.5cqi;
    place-self: center;
    width: 10cqi;
    box-shadow: 0px 0px 15px 1px;
    z-index: 10;
}

.wheel-pointer {
    align-self: start;
    justify-self: center;
    z-index: 20;
    pointer-events: none;
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 18px solid var(--color-main-dark);
    margin-top: -14px;
}

.task-status-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.status-todo        { background: var(--color-secondary); color: var(--color-main-dark); }
.status-in_progress { background: #fef3c7; color: #92400e; }
.status-done        { background: var(--color-compliment); color: var(--color-main-dark); }

</style>
@endpush

@push('bodyScripts')
<script>

document.addEventListener('alpine:init', () => {
    Alpine.data('wheelOfChores', (totalItems, taskIds) => ({
        currentRotation: 0,
        isSpinning: false,
        sliceAngle: 360 / totalItems,
        winnerIndex: 0,
        winnerId: null,

        spin () {
            if (this.isSpinning || totalItems === 0) return;

            this.isSpinning = true;

            const winningIndex = Math.floor(Math.random() * totalItems);
            this.winnerIndex = winningIndex;
            this.winnerId = taskIds[winningIndex];

            // Bring the winning slice's midline to the top (12 o'clock).
            // Unrotated, each slice midline starts at 9 o'clock (270°).
            // Rotating by (90 - winningIndex * sliceAngle) brings it to 0° (12 o'clock).
            const targetRotation = 90 - (winningIndex * this.sliceAngle);
            const minSpin = 1800;
            const currentMod = this.currentRotation % 360;
            const distance = minSpin + (targetRotation - currentMod);

            this.currentRotation += distance;
        },

        async finishSpin () {
            this.isSpinning = false;

            try {
                await fetch(`/wheel/${this.winnerId}/assign`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });
            } catch {
                // still show the modal even if the request fails
            }

            const template = document.getElementById(`task-template-${this.winnerId}`);
            if (template) {
                AppModal.open({
                    title: 'Vi har en vinner! Du må herved gjennomføre denne oppgaven:',
                    content: template.innerHTML,
                    actions: [{ label: 'Lukk', onClick: () => { AppModal.close(); window.location.reload(); } }],
                });
                AppModal.bodyEl.querySelector('[onclick^="assignTask"]')?.remove();
            }
        },
    }));
});

function openModalForId (taskId, title, buttonLabel) {
    const template = document.getElementById(`task-template-${taskId}`);
    if (template) {
        AppModal.open({
            title,
            content: template.innerHTML,
            actions: buttonLabel ? [{ label: buttonLabel, onClick: () => AppModal.close() }] : [],
        });
    }
}

function openEditTask (taskId) {
    const template = document.getElementById(`edit-task-template-${taskId}`);
    if (template) {
        AppModal.open({ title: 'Rediger oppgave', content: template.innerHTML });
    }
}

function openNewTaskModal () {
    const template = document.getElementById('new-task-template');
    AppModal.open({ title: 'Ny oppgave', content: template.innerHTML });
}

async function assignTask (taskId, button) {
    button.disabled = true;
    button.textContent = 'Tildeler…';

    try {
        const response = await fetch(`/wheel/${taskId}/assign`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (data.success) {
            button.textContent = 'Tatt!';
            setTimeout(() => window.location.reload(), 800);
        } else {
            button.textContent = 'Ta oppgaven';
            button.disabled = false;
        }
    } catch {
        button.textContent = 'Ta oppgaven';
        button.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('new-task-btn')?.addEventListener('click', openNewTaskModal);
    document.getElementById('new-task-btn-empty')?.addEventListener('click', openNewTaskModal);
});

</script>
@endpush

</x-layouts.main>
