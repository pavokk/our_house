<x-layouts.main title="Skagesundvegen 63 - Mine oppgaver">
    <main class="max-w-3xl m-auto mt-5 pt-5">

        <x-ui.primary-box class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl">Mine oppgaver</h1>
                <p>Oppgaver tildelt deg</p>
            </div>
            <div>
                <x-ui.primary-button :link="route('wheel.index')" bg="bg-dark-compliment">Tilbake til hjulet</x-ui.primary-button>
            </div>
        </x-ui.primary-box>

        @if ($tasks->isEmpty())

            <x-ui.primary-box class="text-center py-12">
                <p class="text-lg text-gray-500">Du har ingen oppgaver tildelt deg.</p>
            </x-ui.primary-box>

        @else

            @php
                $grouped = $tasks->groupBy(fn($t) => $t->status->value);
                $order   = ['in_progress', 'todo', 'done'];
            @endphp

            @foreach ($order as $status)
                @if ($grouped->has($status))

                    <x-ui.primary-box class="mt-5">
                        <h2 class="text-lg font-semibold mb-3">
                            <span class="task-status-badge status-{{ $status }}">
                                {{ ['todo' => 'Å gjøre', 'in_progress' => 'Pågår', 'done' => 'Ferdig'][$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </h2>

                        <div class="flex flex-col">
                            @foreach ($grouped[$status] as $task)
                                <div class="py-4 border-b border-gray-100 last:border-0">

                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-lg">{{ $task->title }}</p>

                                            @if ($task->content)
                                                <div class="text-sm text-gray-600 mt-1">{!! $task->content !!}</div>
                                            @endif

                                            <p class="text-xs text-gray-400 mt-2">
                                                Opprettet av {{ $task->user->name ?? 'Ukjent' }}
                                                @if ($task->due_date)
                                                    &mdash; Frist {{ $task->due_date->format('d.m.Y') }}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="flex gap-2 shrink-0 mt-1">
                                            @if ($status !== 'done')
                                                <form method="POST" action="{{ route('task.status', $task) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="done">
                                                    <button type="submit" class="text-sm px-3 py-1.5 bg-compliment text-main-dark rounded-lg hover:bg-dark-compliment">
                                                        Marker som ferdig
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('task.status', $task) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="todo">
                                                    <input type="hidden" name="clear_assignee" value="1">
                                                    <button type="submit" class="text-sm px-3 py-1.5 bg-secondary text-main-dark rounded-lg hover:bg-dark-compliment">
                                                        Gjenåpne
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </x-ui.primary-box>

                @endif
            @endforeach

        @endif

    </main>

@push('styles')
<style>
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

</x-layouts.main>
