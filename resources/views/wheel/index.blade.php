<x-layouts.main title="Skagesundvegen 63 - Wheel of Chores">
    <main class="max-w-3xl m-auto mt-5 pt-5">

        <x-ui.primary-box class="wheel-header flex justify-between items-center">

            <div>

                <h1 class="text-3xl">Wheel of chores</h1>
                <p>Spin the wheel to get a task assigned</p>

            </div>

            <div class="create-task w-50">
                <x-ui.primary-button id="new-task" type="button">Nytt gjøremål</x-ui.primary-btn>
            </div>

        </x-ui.primary-box>

        <div x-data="wheelOfChores({{ count($tasks) }})" class="woc-wrapper p-14">

            <ul
                class="wheel-of-chores"
                :style="`transform: rotate(${currentRotation}deg); transition: transform 4s ease-out; --_items: {{ count($tasks) }}`"
                @transitionend.self="finishSpin"
            >

                @foreach ($tasks as $index => $task)
                    <li style="--_idx: {{ $loop->iteration }}">
                        <p>{{ $task->title }}</p>

                        <template id="task-template-{{ $index }}">
                            <div class="text-center">
                                <x-ui.primary-box class="bg-green-50 p-4 border border-green-200">
                                    <h3 class="text-xl font-bold mb-2">{{ $task->title }}</h3>
                                    <div class="prose mb-4">
                                        {!! $task->content ?? 'No description.' !!}
                                    </div>
                                    <p class="text-sm text-gray-500">Assigned to: {{ $task->assignee->name ?? 'Unassigned' }}</p>
                                </x-ui.primary-box>
                            </div>
                        </template>
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
        {{--
        <div class="woc-wrapper p-14">

            <ul class="wheel-of-chores">

                @foreach ($tasks as $task)

                    <li
                        style="--_idx: {{ $loop->iteration }}"
                        data-title="{{ $task->title }}"
                        data-creator="{{ $task->user->name ?? 'Unknown' }}"
                        data-assignee="{{ $task->assignee->name ?? 'Unassigned' }}"
                        data-content="{{ $task->content ?? 'No description provided.' }}"
                    >
                        <p>{{ $task->title }}</p>
                    </li>
                @endforeach

            </ul>

            <button type="button">SPIN</button>


        </div>
        --}}
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
    --_items: {{ count($tasks) }};
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
    background: deepskyblue;
    display: grid;
    font-size: 5cqi;
    grid-area: 1 / -1;
    list-style: none;
    padding-left: 1ch;
    transform-origin: center right;
    width: 50cqi;
    rotate: calc(360deg / var(--_items) * calc(var(--_idx) - 1));
    background: hsl(calc(360deg / var(--_items) * calc(var(--_idx))), 100%, 75%);
    height: calc((2 * pi * 50cqi) / var(--_items));
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

.woc-result {
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 1.5rem;
    height: 2em;
}

</style>

@endpush

@push('bodyScripts')
<script>

document.addEventListener('alpine:init', () => {
    Alpine.data('wheelOfChores', (totalItems) => ({
        currentRotation: 0,
        isSpinning: false,
        sliceAngle: 360 / totalItems,
        winnerIndex: 0,

        spin () {
            if (this.isSpinning || totalItems === 0) return;

            this.isSpinning = true;

            const winningIndex = Math.floor(Math.random() * totalItems);

            const sliceCenterOffset = this.sliceAngle / 2;
            const targetSliceCenter = (winningIndex * this.sliceAngle) + sliceCenterOffset;

            const targetRotation = 105 - targetSliceCenter;

            const minSpin = 1800;
            const currentMod = this.currentRotation % 360;
            const distance = minSpin + (targetRotation - currentMod);

            this.currentRotation += distance;
            this.winnerIndex = winningIndex;
        },

        finishSpin () {
            this.isSpinning = false;
            const template = document.getElementById(`task-template-${this.winnerIndex}`);

            if (template) {
                const contentHtml = template.innerHTML;
                AppModal.open({
                    title: "We have a winner!",
                    content: contentHtml,
                    actions: [
                        { label: 'Yay!', onClick: () => AppModal.close() }
                    ]
                });
            }
        }
    }));
});

</script>
@endpush

</x-layouts.main>

