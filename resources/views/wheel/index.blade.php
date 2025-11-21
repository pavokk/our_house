<x-layouts.main title="Skagesundvegen 63 - Wheel of Chores">
    <main class="max-w-3xl m-auto mt-5 pt-5">

        <x-ui.primary-box class="wheel-header flex justify-between items-center">

            <div>

                <h1 class="text-3xl">Wheel of chores</h1>
                <p>Spin the wheel to get a task assigned</p>

            </div>

            <div class="create-task w-50">
                <x-ui.primary-button type="button">Nytt gjøremål</x-main-btn>
            </div>

        </x-ui>

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

        <div class="woc-result" role="status" aria-live="polite"></div>

        <x-wheel.task-modal />

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
function wheelOfFortune(selector) {
    const node = document.querySelector(selector);
    if (!node) return;

    const wheel = node.querySelector('ul');
    const spin = node.querySelector('button');
    const result = document.querySelector('.woc-result');

    const items = wheel.querySelectorAll('li');
    const itemCount = items.length;
    if (itemCount === 0) return;

    // Calculate the angle for each slice
    const sliceAngle = 360 / itemCount;
    const sliceCenterOffset = sliceAngle / 2;

    let animation;
    let previousEndDegree = 0;

    spin.addEventListener('click', () => {

        // Disable UI
        spin.disabled = true;
        result.textContent = '';
        if (animation) {
            animation.cancel();
        }

        // Pick random winner before we spin
        const winningIndex = Math.floor(Math.random() * itemCount);
        const winner = items[winningIndex].textContent;

        // Calculate target angle
        const targetSliceCenter = (winningIndex * sliceAngle) + sliceCenterOffset;
        const targetRotation = 105 - targetSliceCenter; // Adjusting so the target ends up on top
        const minSpinDegrees = 1800; // Spin minimum 5 times:
        const cycles = Math.ceil((previousEndDegree + minSpinDegrees) / 360); // How many times round
        const newEndDegree = (cycles * 360) + targetRotation;

        // Run animation
        animation = wheel.animate([
            { transform: `rotate(${previousEndDegree}deg)` },
            { transform: `rotate(${newEndDegree}deg)` }
        ], {
            duration: 4000,
            direction: 'normal',
            easing: 'ease-out', // Starts fast, slows to a stop
            fill: 'forwards',
            iterations: 1
        });

        // Reveal winner when wheel has stopped spinning
        animation.onfinish = () => {
            previousEndDegree = newEndDegree;
            spin.disabled = false;
            result.textContent = `Winner: ${winner}!`;
        };
    });
}

wheelOfFortune('.woc-wrapper');

function setupTaskModal(modalSelector) {
    const modal = document.getElementById(modalSelector);
    if (!modal) return;

    const items = document.querySelectorAll('.wheel-of-chores li');
    const closeBtn = modal.querySelector('.task-modal-close');

    const titleEl = modal.querySelector('#modal-title');
    const bodyEl = modal.querySelector('#modal-body');
    const creatorEl = modal.querySelector('#modal-creator');
    const assigneeEl = modal.querySelector('#modal-assignee');

    items.forEach(item => {
        item.addEventListener('click', () => {
            const data = item.dataset;

            console.log(data);

            titleEl.textContent = data.title;
            bodyEl.innerHTML = data.content;
            creatorEl.textContent = data.creator;
            assigneeEl.textContent = data.assignee;

            // --- CHANGED LINE ---
            modal.classList.remove('hidden'); // Show the modal
        });
    });

    const closeModal = () => {
        // --- CHANGED LINE ---
        modal.classList.add('hidden'); // Hide the modal
    };

    closeBtn.addEventListener('click', closeModal);

    // This listens for clicks on the dark backdrop
    modal.addEventListener('click', (event) => {
        // If the click is on the backdrop (the modal itself)
        // and NOT on the content box, close it.
        if (event.target === modal) {
            closeModal();
        }
    });
}

setupTaskModal('task-modal');

</script>
@endpush

</x-layouts.main>

