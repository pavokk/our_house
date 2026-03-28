<x-layouts.main title="Skagesundvegen 63 - Snake">
<main class="max-w-3xl m-auto mt-5 pt-5">

    {{-- Header --}}
    <x-ui.primary-box class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <x-ui.primary-button :link="route('games.index')" bg="bg-dark-compliment">&larr; Tilbake</x-ui.primary-button>
            <h1 class="text-2xl font-bold">Snake</h1>
        </div>
        <div class="text-xl font-bold">
            Poeng: <span id="score-display">0</span>
        </div>
    </x-ui.primary-box>

    {{-- Game --}}
    <x-ui.primary-box class="flex flex-col items-center gap-5">

        {{-- Canvas wrapper --}}
        <div class="snake-wrapper">
            <canvas id="snake-canvas" width="400" height="400"></canvas>

            {{-- Idle overlay --}}
            <div id="overlay-idle" class="snake-overlay">
                <p class="text-white text-xl font-bold drop-shadow">Trykk for å starte</p>
                <p class="text-white/70 text-sm mt-1 drop-shadow">Piltaster eller D-pad</p>
            </div>

            {{-- Game over overlay --}}
            <div id="overlay-gameover" class="snake-overlay hidden">
                <p class="text-amber-300 text-2xl font-bold drop-shadow">Game Over</p>
                <p class="text-white text-lg mt-1 drop-shadow">Poeng: <span id="final-score">0</span></p>
                <button onclick="restartGame()" class="mt-4 px-5 py-2 bg-compliment text-main-dark font-semibold rounded-xl hover:bg-dark-compliment cursor-pointer">
                    Prøv igjen
                </button>
            </div>
        </div>

        {{-- Mobile D-pad (hidden on md+) --}}
        <div class="dpad md:hidden" aria-label="Retningskontroller">
            <div class="dpad-grid">
                <div></div>
                <button class="dpad-btn" id="dpad-up" aria-label="Opp">&#9650;</button>
                <div></div>
                <button class="dpad-btn" id="dpad-left" aria-label="Venstre">&#9664;</button>
                <div class="dpad-center"></div>
                <button class="dpad-btn" id="dpad-right" aria-label="Høyre">&#9654;</button>
                <div></div>
                <button class="dpad-btn" id="dpad-down" aria-label="Ned">&#9660;</button>
                <div></div>
            </div>
        </div>

        {{-- Desktop hint --}}
        <p class="hidden md:block text-sm text-gray-500">Bruk piltastene for å styre</p>

    </x-ui.primary-box>

    {{-- Highscore table --}}
    <x-ui.primary-box>
        <h2 class="text-xl font-bold mb-4">Toppliste</h2>

        @if ($scores->isEmpty())
            <p class="text-sm text-gray-500">Ingen resultater ennå. Spill det første spillet!</p>
        @else
            <div class="flex flex-col gap-2">
                @foreach ($scores as $i => $entry)
                    <div class="flex items-center gap-3 py-2 {{ $loop->last ? '' : 'border-b border-black/10' }}">
                        <span class="w-8 text-center font-bold text-lg {{ $i === 0 ? 'text-amber-500' : ($i === 1 ? 'text-gray-400' : ($i === 2 ? 'text-amber-700' : 'text-gray-500')) }}">
                            {{ $i + 1 }}
                        </span>
                        <div class="w-9 h-9 rounded-full overflow-hidden shrink-0">
                            @if ($entry->user->image)
                                <img src="{{ asset('storage/' . $entry->user->image->image) }}" alt="{{ $entry->user->name }}" class="w-full h-full object-cover">
                            @else
                                <x-svg.placeholder-profile color="var(--color-main-dark)" width="36px" height="36px" />
                            @endif
                        </div>
                        <span class="flex-1 font-medium">{{ $entry->user->name }}</span>
                        <span class="font-bold text-lg">{{ $entry->score }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </x-ui.primary-box>

</main>

@push('styles')
<style>
.snake-wrapper {
    position: relative;
    width: 100%;
    max-width: 440px;
}
#snake-canvas {
    display: block;
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
    image-rendering: pixelated;
}
.snake-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.55);
    border-radius: 0.5rem;
}
.snake-overlay.hidden {
    display: none;
}
.dpad-grid {
    display: grid;
    grid-template-columns: repeat(3, 64px);
    grid-template-rows: repeat(3, 64px);
    gap: 6px;
}
.dpad-btn {
    background: var(--color-main-dark);
    color: var(--color-main-light);
    border: none;
    border-radius: 10px;
    font-size: 22px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    touch-action: manipulation;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: background 0.1s;
}
.dpad-btn:active {
    background: var(--color-dark-compliment);
}
.dpad-center {
    background: var(--color-secondary);
    border-radius: 50%;
    width: 28px;
    height: 28px;
    margin: auto;
}
</style>
@endpush

@push('bodyScripts')
<script>
const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

const COLS = 20;
const ROWS = 20;

let snake, dir, nextDir, food, score, gameState, loopId;

const canvas  = document.getElementById('snake-canvas');
const ctx     = canvas.getContext('2d');
const scoreEl = document.getElementById('score-display');

// ── Init ──────────────────────────────────────────────────────────────────────

function init() {
    clearInterval(loopId);
    const mid = Math.floor(COLS / 2);
    snake     = [{ x: mid, y: mid }];
    dir       = { x: 0, y: 0 };
    nextDir   = { x: 1, y: 0 };
    food      = spawnFood();
    score     = 0;
    gameState = 'idle';
    scoreEl.textContent = '0';
    showOverlay('idle');
    draw();
}

// ── Food ──────────────────────────────────────────────────────────────────────

function spawnFood() {
    let pos;
    do {
        pos = { x: Math.floor(Math.random() * COLS), y: Math.floor(Math.random() * ROWS) };
    } while (snake.some(s => s.x === pos.x && s.y === pos.y));
    return pos;
}

// ── Direction ─────────────────────────────────────────────────────────────────

function setDir(x, y) {
    if (gameState === 'gameover') return;
    if (dir.x !== 0 && x !== 0) return;
    if (dir.y !== 0 && y !== 0) return;
    nextDir = { x, y };
    if (gameState === 'idle') startGame();
}

// ── Game loop ─────────────────────────────────────────────────────────────────

function startGame() {
    gameState = 'playing';
    hideOverlays();
    scheduleLoop();
}

function getInterval() {
    return Math.max(70, 150 - Math.floor(score / 5) * 10);
}

function scheduleLoop() {
    clearInterval(loopId);
    loopId = setInterval(tick, getInterval());
}

function tick() {
    if (gameState !== 'playing') return;

    dir = { ...nextDir };

    const head = { x: snake[0].x + dir.x, y: snake[0].y + dir.y };

    if (head.x < 0 || head.x >= COLS || head.y < 0 || head.y >= ROWS ||
        snake.some(s => s.x === head.x && s.y === head.y)) {
        clearInterval(loopId);
        gameState = 'gameover';
        submitScore();
        showOverlay('gameover');
        draw();
        return;
    }

    snake.unshift(head);

    if (head.x === food.x && head.y === food.y) {
        score++;
        scoreEl.textContent = score;
        food = spawnFood();
        scheduleLoop();
    } else {
        snake.pop();
    }

    draw();
}

function restartGame() {
    init();
}

// ── Score submission ───────────────────────────────────────────────────────────

async function submitScore() {
    if (!isAuthenticated || score === 0) return;
    try {
        await fetch('/games/highscore', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ game: 'snake', score }),
        });
    } catch {}
}

// ── Overlays ──────────────────────────────────────────────────────────────────

function showOverlay(type) {
    document.getElementById('overlay-idle').classList.toggle('hidden', type !== 'idle');
    document.getElementById('overlay-gameover').classList.toggle('hidden', type !== 'gameover');
    if (type === 'gameover') {
        document.getElementById('final-score').textContent = score;
    }
}

function hideOverlays() {
    document.getElementById('overlay-idle').classList.add('hidden');
    document.getElementById('overlay-gameover').classList.add('hidden');
}

// ── Drawing ───────────────────────────────────────────────────────────────────

function draw() {
    const cs = canvas.width / COLS;
    const W  = canvas.width;
    const H  = canvas.height;

    // Background
    ctx.fillStyle = '#313E2C';
    ctx.fillRect(0, 0, W, H);

    // Subtle grid
    ctx.strokeStyle = 'rgba(255,255,255,0.04)';
    ctx.lineWidth = 0.5;
    for (let i = 0; i <= COLS; i++) {
        ctx.beginPath(); ctx.moveTo(i * cs, 0); ctx.lineTo(i * cs, H); ctx.stroke();
        ctx.beginPath(); ctx.moveTo(0, i * cs); ctx.lineTo(W, i * cs); ctx.stroke();
    }

    // Food
    ctx.fillStyle = '#FFC44D';
    ctx.beginPath();
    ctx.arc(food.x * cs + cs / 2, food.y * cs + cs / 2, cs / 2 - 2, 0, Math.PI * 2);
    ctx.fill();

    // Snake body
    snake.forEach((seg, i) => {
        ctx.fillStyle = i === 0 ? '#BCD4BF' : '#8D9E8F';
        const pad = i === 0 ? 1 : 2;
        ctx.fillRect(seg.x * cs + pad, seg.y * cs + pad, cs - pad * 2, cs - pad * 2);
    });
}

// ── Controls ──────────────────────────────────────────────────────────────────

document.addEventListener('keydown', e => {
    const map = {
        ArrowUp:    [0, -1],
        ArrowDown:  [0,  1],
        ArrowLeft:  [-1, 0],
        ArrowRight: [ 1, 0],
    };
    if (map[e.key]) {
        e.preventDefault();
        setDir(...map[e.key]);
    }
});

document.getElementById('dpad-up')?.addEventListener('click',    () => setDir(0, -1));
document.getElementById('dpad-down')?.addEventListener('click',  () => setDir(0,  1));
document.getElementById('dpad-left')?.addEventListener('click',  () => setDir(-1, 0));
document.getElementById('dpad-right')?.addEventListener('click', () => setDir(1,  0));

canvas.addEventListener('click', () => {
    if (gameState === 'idle')     startGame();
    else if (gameState === 'gameover') init();
});

// ── Start ─────────────────────────────────────────────────────────────────────

init();
</script>
@endpush

</x-layouts.main>
