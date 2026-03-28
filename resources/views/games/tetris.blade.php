<x-layouts.main title="Skagesundvegen 63 - Tetris">
<main class="max-w-3xl m-auto mt-5 pt-5">

    {{-- Header --}}
    <x-ui.primary-box class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <x-ui.primary-button :link="route('games.index')" bg="bg-dark-compliment">&larr; Tilbake</x-ui.primary-button>
            <h1 class="text-2xl font-bold">Tetris</h1>
        </div>
        {{-- Mobile stats bar --}}
        <div class="flex gap-4 text-sm font-semibold md:hidden">
            <span>P: <span data-stat="score">0</span></span>
            <span>N: <span data-stat="level">1</span></span>
            <span>L: <span data-stat="lines">0</span></span>
        </div>
    </x-ui.primary-box>

    {{-- Game --}}
    <x-ui.primary-box class="flex flex-col items-center gap-4">

        <div class="tetris-layout">

            {{-- Board canvas + overlays --}}
            <div class="tetris-board-wrap">
                <canvas id="board-canvas" width="300" height="600"></canvas>

                <div id="overlay-idle" class="tetris-overlay">
                    <p class="text-white text-xl font-bold drop-shadow">Trykk for å starte</p>
                    <p class="text-white/70 text-sm drop-shadow">Piltaster &bull; Space = hard drop &bull; P = pause</p>
                </div>

                <div id="overlay-paused" class="tetris-overlay hidden">
                    <p class="text-white text-2xl font-bold drop-shadow">Pause</p>
                    <button onclick="togglePause()" class="mt-3 px-5 py-2 bg-compliment text-main-dark font-semibold rounded-xl hover:bg-dark-compliment cursor-pointer">
                        Fortsett
                    </button>
                </div>

                <div id="overlay-gameover" class="tetris-overlay hidden">
                    <p class="text-amber-300 text-2xl font-bold drop-shadow">Game Over</p>
                    <p class="text-white text-lg drop-shadow">Poeng: <span id="final-score">0</span></p>
                    <button onclick="restartGame()" class="mt-3 px-5 py-2 bg-compliment text-main-dark font-semibold rounded-xl hover:bg-dark-compliment cursor-pointer">
                        Prøv igjen
                    </button>
                </div>
            </div>

            {{-- Side panel (desktop only) --}}
            <div class="tetris-side">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Neste</p>
                    <canvas id="next-canvas" width="120" height="120" class="rounded-lg"></canvas>
                </div>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Poeng</p>
                        <p class="text-2xl font-bold" data-stat="score">0</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Nivå</p>
                        <p class="text-2xl font-bold" data-stat="level">1</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Linjer</p>
                        <p class="text-2xl font-bold" data-stat="lines">0</p>
                    </div>
                </div>

                <button onclick="togglePause()" class="px-4 py-2 bg-main-dark text-main-light rounded-lg text-sm hover:opacity-80 cursor-pointer">
                    Pause (P)
                </button>

            </div>

        </div>

        {{-- Mobile controls --}}
        <div class="tetris-controls md:hidden">
            <div class="flex gap-3 justify-center">
                <button class="ctrl-btn" id="btn-left"   aria-label="Venstre">&#9664;</button>
                <button class="ctrl-btn" id="btn-rotate" aria-label="Roter">&#8635;</button>
                <button class="ctrl-btn" id="btn-right"  aria-label="Høyre">&#9654;</button>
            </div>
            <div class="flex gap-3 justify-center mt-3">
                <button class="ctrl-btn ctrl-btn-wide" id="btn-down" aria-label="Sakte ned">&#9660; Sakte</button>
                <button class="ctrl-btn ctrl-btn-wide" id="btn-drop" aria-label="Hard drop">&#8681; Drop</button>
            </div>
        </div>

        <p class="hidden md:block text-sm text-gray-500">
            Piltaster &bull; &#8593; / Z = roter &bull; Space = hard drop &bull; P = pause
        </p>

    </x-ui.primary-box>

    {{-- Highscores --}}
    <x-ui.primary-box>
        <h2 class="text-xl font-bold mb-4">Toppliste</h2>

        @if ($scores->isEmpty())
            <p class="text-sm text-gray-500">Ingen resultater ennå. Vær den første!</p>
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
                        <span class="font-bold text-lg">{{ number_format($entry->score) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </x-ui.primary-box>

</main>

@push('styles')
<style>
.tetris-layout {
    display: flex;
    gap: 20px;
    justify-content: center;
    align-items: flex-start;
}
.tetris-board-wrap {
    position: relative;
    flex-shrink: 0;
}
#board-canvas {
    display: block;
    width: 250px;
    height: auto;
    border-radius: 0.5rem;
    image-rendering: pixelated;
}
@media (min-width: 640px) {
    #board-canvas { width: 300px; }
}
.tetris-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    border-radius: 0.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.tetris-overlay.hidden { display: none; }
.tetris-side {
    display: none;
    flex-direction: column;
    gap: 20px;
    padding-top: 4px;
}
@media (min-width: 640px) {
    .tetris-side { display: flex; }
}
#next-canvas {
    display: block;
    image-rendering: pixelated;
}
.ctrl-btn {
    background: var(--color-main-dark);
    color: var(--color-main-light);
    border: none;
    border-radius: 10px;
    width: 64px;
    height: 64px;
    font-size: 22px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    touch-action: manipulation;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    gap: 4px;
    font-weight: 600;
    font-size: 14px;
    transition: background 0.1s;
}
.ctrl-btn-wide { width: 108px; }
.ctrl-btn:active { background: var(--color-dark-compliment); }
</style>
@endpush

@push('bodyScripts')
<script>
const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// ── Constants ──────────────────────────────────────────────────────────────────

const BOARD_W = 10;
const BOARD_H = 20;
const CELL    = 30;

const PIECES = [
    { shape: [[1,1,1,1]],           color: '#00f0f0' }, // I
    { shape: [[1,1],[1,1]],          color: '#f0f000' }, // O
    { shape: [[0,1,0],[1,1,1]],      color: '#a000f0' }, // T
    { shape: [[0,1,1],[1,1,0]],      color: '#00f000' }, // S
    { shape: [[1,1,0],[0,1,1]],      color: '#f00000' }, // Z
    { shape: [[1,0,0],[1,1,1]],      color: '#0000f0' }, // J
    { shape: [[0,0,1],[1,1,1]],      color: '#f0a000' }, // L
];

// ── State ──────────────────────────────────────────────────────────────────────

let board, piece, nextPiece, bag, score, level, lines, gameState, dropTimer;

// ── DOM ───────────────────────────────────────────────────────────────────────

const boardCanvas = document.getElementById('board-canvas');
const nextCanvas  = document.getElementById('next-canvas');
const boardCtx    = boardCanvas.getContext('2d');
const nextCtx     = nextCanvas.getContext('2d');

// ── Piece factory ─────────────────────────────────────────────────────────────

function refillBag() {
    bag = [...PIECES].sort(() => Math.random() - 0.5);
}

function nextFromBag() {
    if (!bag || bag.length === 0) refillBag();
    const p = bag.pop();
    return { shape: p.shape.map(r => [...r]), color: p.color };
}

function spawnPiece() {
    const p  = { ...nextPiece, shape: nextPiece.shape.map(r => [...r]) };
    nextPiece = nextFromBag();
    p.x = Math.floor((BOARD_W - p.shape[0].length) / 2);
    p.y = 0;
    drawNext();

    if (collides(p, 0, 0)) {
        gameState = 'gameover';
        clearTimeout(dropTimer);
        submitScore();
        document.getElementById('final-score').textContent = score;
        showOverlay('gameover');
    }
    return p;
}

// ── Collision ─────────────────────────────────────────────────────────────────

function collides(p, dx, dy, shape) {
    shape = shape || p.shape;
    for (let r = 0; r < shape.length; r++) {
        for (let c = 0; c < shape[r].length; c++) {
            if (!shape[r][c]) continue;
            const nx = p.x + c + dx;
            const ny = p.y + r + dy;
            if (nx < 0 || nx >= BOARD_W || ny >= BOARD_H) return true;
            if (ny >= 0 && board[ny][nx])                  return true;
        }
    }
    return false;
}

// ── Rotation ──────────────────────────────────────────────────────────────────

function rotateMatrix(s) {
    return s[0].map((_, c) => s.map(r => r[c]).reverse());
}

function rotatePiece() {
    if (gameState !== 'playing') return;
    const rotated = rotateMatrix(piece.shape);
    for (const kick of [0, -1, 1, -2, 2]) {
        if (!collides(piece, kick, 0, rotated)) {
            piece.shape = rotated;
            piece.x += kick;
            drawBoard();
            return;
        }
    }
}

// ── Movement ──────────────────────────────────────────────────────────────────

function move(dx) {
    if (gameState !== 'playing') return;
    if (!collides(piece, dx, 0)) { piece.x += dx; drawBoard(); }
}

function softDrop() {
    if (gameState !== 'playing') return;
    if (!collides(piece, 0, 1)) {
        piece.y++;
        score++;
        updateStats();
        resetDrop();
    } else {
        lock();
    }
    drawBoard();
}

function hardDrop() {
    if (gameState !== 'playing') return;
    let n = 0;
    while (!collides(piece, 0, 1)) { piece.y++; n++; }
    score += n * 2;
    updateStats();
    lock();
}

// ── Drop timer ────────────────────────────────────────────────────────────────

function dropInterval() {
    return Math.max(100, 800 - (level - 1) * 70);
}

function scheduleDrop() {
    clearTimeout(dropTimer);
    dropTimer = setTimeout(gravityTick, dropInterval());
}

function resetDrop() { scheduleDrop(); }

function gravityTick() {
    if (gameState !== 'playing') return;
    if (!collides(piece, 0, 1)) { piece.y++; drawBoard(); }
    else lock();
    scheduleDrop();
}

// ── Locking ───────────────────────────────────────────────────────────────────

function lock() {
    for (let r = 0; r < piece.shape.length; r++) {
        for (let c = 0; c < piece.shape[r].length; c++) {
            if (!piece.shape[r][c]) continue;
            if (piece.y + r >= 0) board[piece.y + r][piece.x + c] = piece.color;
        }
    }
    clearLines();
    piece = spawnPiece();
    if (gameState === 'playing') { scheduleDrop(); drawBoard(); }
}

function clearLines() {
    let cleared = 0;
    for (let r = BOARD_H - 1; r >= 0; ) {
        if (board[r].every(c => c !== null)) {
            board.splice(r, 1);
            board.unshift(Array(BOARD_W).fill(null));
            cleared++;
        } else { r--; }
    }
    if (cleared) {
        score += [0, 100, 300, 500, 800][cleared] * level;
        lines += cleared;
        level  = Math.floor(lines / 10) + 1;
        updateStats();
    }
}

// ── Ghost piece ───────────────────────────────────────────────────────────────

function ghostRow() {
    let gy = piece.y;
    while (!collides(piece, 0, gy - piece.y + 1)) gy++;
    return gy;
}

// ── Game flow ─────────────────────────────────────────────────────────────────

function init() {
    clearTimeout(dropTimer);
    bag       = [];
    board     = Array.from({ length: BOARD_H }, () => Array(BOARD_W).fill(null));
    score     = 0; level = 1; lines = 0;
    gameState = 'idle';
    nextPiece = nextFromBag();
    piece     = spawnPiece();
    gameState = 'idle'; // spawnPiece might set gameover; force idle
    updateStats();
    showOverlay('idle');
    drawBoard();
    drawNext();
}

function startGame() {
    if (gameState !== 'idle') return;
    gameState = 'playing';
    hideOverlays();
    scheduleDrop();
    drawBoard();
}

function togglePause() {
    if (gameState === 'playing') {
        gameState = 'paused';
        clearTimeout(dropTimer);
        showOverlay('paused');
    } else if (gameState === 'paused') {
        gameState = 'playing';
        hideOverlays();
        scheduleDrop();
    }
}

function restartGame() { init(); }

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
            body: JSON.stringify({ game: 'tetris', score }),
        });
    } catch {}
}

// ── Stats ─────────────────────────────────────────────────────────────────────

function updateStats() {
    document.querySelectorAll('[data-stat="score"]').forEach(el => el.textContent = score.toLocaleString());
    document.querySelectorAll('[data-stat="level"]').forEach(el => el.textContent = level);
    document.querySelectorAll('[data-stat="lines"]').forEach(el => el.textContent = lines);
}

// ── Overlays ──────────────────────────────────────────────────────────────────

function showOverlay(name) {
    ['idle','paused','gameover'].forEach(n =>
        document.getElementById(`overlay-${n}`).classList.toggle('hidden', n !== name)
    );
}

function hideOverlays() {
    ['idle','paused','gameover'].forEach(n =>
        document.getElementById(`overlay-${n}`).classList.add('hidden')
    );
}

// ── Drawing ───────────────────────────────────────────────────────────────────

function drawCell(ctx, cx, cy, color, cs) {
    ctx.fillStyle = color;
    ctx.fillRect(cx * cs + 1, cy * cs + 1, cs - 2, cs - 2);
    // Top/left shine
    ctx.fillStyle = 'rgba(255,255,255,0.25)';
    ctx.fillRect(cx * cs + 1, cy * cs + 1, cs - 2, 4);
    ctx.fillRect(cx * cs + 1, cy * cs + 1, 4, cs - 2);
    // Bottom/right shadow
    ctx.fillStyle = 'rgba(0,0,0,0.2)';
    ctx.fillRect(cx * cs + 1, cy * cs + cs - 4, cs - 2, 3);
    ctx.fillRect(cx * cs + cs - 4, cy * cs + 1, 3, cs - 2);
}

function drawBoard() {
    const cs = CELL;
    const W  = boardCanvas.width;
    const H  = boardCanvas.height;

    boardCtx.fillStyle = '#1a1a2e';
    boardCtx.fillRect(0, 0, W, H);

    // Grid lines
    boardCtx.strokeStyle = 'rgba(255,255,255,0.04)';
    boardCtx.lineWidth = 0.5;
    for (let i = 0; i <= BOARD_W; i++) {
        boardCtx.beginPath(); boardCtx.moveTo(i*cs,0); boardCtx.lineTo(i*cs,H); boardCtx.stroke();
    }
    for (let i = 0; i <= BOARD_H; i++) {
        boardCtx.beginPath(); boardCtx.moveTo(0,i*cs); boardCtx.lineTo(W,i*cs); boardCtx.stroke();
    }

    // Locked cells
    for (let r = 0; r < BOARD_H; r++)
        for (let c = 0; c < BOARD_W; c++)
            if (board[r][c]) drawCell(boardCtx, c, r, board[r][c], cs);

    if (gameState === 'playing' || gameState === 'paused') {
        // Ghost piece
        const gy = ghostRow();
        for (let r = 0; r < piece.shape.length; r++) {
            for (let c = 0; c < piece.shape[r].length; c++) {
                if (!piece.shape[r][c]) continue;
                boardCtx.strokeStyle = piece.color + '66';
                boardCtx.lineWidth = 1.5;
                boardCtx.strokeRect((piece.x+c)*cs+2, (gy+r)*cs+2, cs-4, cs-4);
            }
        }

        // Active piece
        for (let r = 0; r < piece.shape.length; r++)
            for (let c = 0; c < piece.shape[r].length; c++)
                if (piece.shape[r][c]) drawCell(boardCtx, piece.x+c, piece.y+r, piece.color, cs);
    }
}

function drawNext() {
    const cs = 24;
    const W  = nextCanvas.width;
    const H  = nextCanvas.height;

    nextCtx.fillStyle = '#1a1a2e';
    nextCtx.fillRect(0, 0, W, H);

    if (!nextPiece) return;
    const s    = nextPiece.shape;
    const rows = s.length, cols = s[0].length;
    const ox   = Math.floor((W / cs - cols) / 2);
    const oy   = Math.floor((H / cs - rows) / 2);

    for (let r = 0; r < rows; r++)
        for (let c = 0; c < cols; c++)
            if (s[r][c]) drawCell(nextCtx, ox + c, oy + r, nextPiece.color, cs);
}

// ── Keyboard ──────────────────────────────────────────────────────────────────

document.addEventListener('keydown', e => {
    const gameKeys = ['ArrowLeft','ArrowRight','ArrowDown','ArrowUp','Space','KeyZ','KeyX','KeyP'];
    if (gameKeys.includes(e.code)) e.preventDefault();

    if (gameState === 'idle')     { startGame(); return; }
    if (gameState === 'gameover') { init();      return; }

    switch (e.code) {
        case 'ArrowLeft':  move(-1);       break;
        case 'ArrowRight': move(1);        break;
        case 'ArrowDown':  softDrop();     break;
        case 'ArrowUp':
        case 'KeyZ':
        case 'KeyX':       rotatePiece(); break;
        case 'Space':      hardDrop();    break;
        case 'KeyP':       togglePause(); break;
    }
});

// ── Mobile controls (with autorepeat on hold) ──────────────────────────────────

function makeHold(fn) {
    let timer;
    function onStart(e) {
        e.preventDefault();
        if (gameState === 'idle') startGame();
        fn();
        timer = setInterval(fn, 80);
    }
    function onEnd(e) { e.preventDefault(); clearInterval(timer); }
    return { onStart, onEnd };
}

const holdLeft   = makeHold(() => move(-1));
const holdRight  = makeHold(() => move(1));
const holdDown   = makeHold(softDrop);

function bindCtrl(id, onStart, onEnd) {
    const el = document.getElementById(id);
    if (!el) return;
    if (onEnd) {
        el.addEventListener('touchstart', onStart, { passive: false });
        el.addEventListener('touchend',   onEnd,   { passive: false });
    } else {
        el.addEventListener('touchstart', e => { e.preventDefault(); onStart(); }, { passive: false });
    }
    el.addEventListener('click', () => { if (gameState === 'idle') startGame(); onStart.call ? onStart() : onStart(new Event('click')); });
}

bindCtrl('btn-left',   holdLeft.onStart,  holdLeft.onEnd);
bindCtrl('btn-right',  holdRight.onStart, holdRight.onEnd);
bindCtrl('btn-down',   holdDown.onStart,  holdDown.onEnd);
bindCtrl('btn-rotate', () => { if (gameState === 'idle') startGame(); rotatePiece(); });
bindCtrl('btn-drop',   () => { if (gameState === 'idle') startGame(); hardDrop(); });

boardCanvas.addEventListener('click', () => {
    if (gameState === 'idle')     startGame();
    else if (gameState === 'gameover') init();
});

// ── Go ────────────────────────────────────────────────────────────────────────

init();
</script>
@endpush

</x-layouts.main>
