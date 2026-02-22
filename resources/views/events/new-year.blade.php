@extends('layouts.app')
@section('title', 'Happy New Year')
@section('audio_src', asset('images/newyear.mp3'))

@section('styles')
<style>
    body { background-color: #020617; } /* slate-950 */
    .star {
        position: absolute;
        border-radius: 50%;
        background-color: white;
        animation: twinkle linear infinite;
    }
    @keyframes twinkle {
        0%, 100% { opacity: 0; transform: scale(0.5); }
        50% { opacity: 1; transform: scale(1.5); box-shadow: 0 0 10px white; }
    }
    .countdown-flip {
        display: inline-block;
        padding: 1rem 2rem;
        background: linear-gradient(to bottom, #1e293b, #0f172a);
        border: 2px solid #eab308;
        border-radius: 12px;
        box-shadow: 0 0 30px rgba(234, 179, 8, 0.4);
        margin: 0 0.5rem;
        transform-style: preserve-3d;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .flip-active { transform: rotateX(-180deg); }
    .gold-text {
        background: linear-gradient(135deg, #fef08a 0%, #eab308 50%, #ca8a04 100%);
        -webkit-background-clip: text; color: transparent;
    }
    
    .particle { pointer-events: none; position: fixed; bottom: 10%; z-index: 100; font-size: 2rem; }
</style>
@endsection

@section('content')
<!-- Starry bg -->
<div class="fixed inset-0 pointer-events-none z-0" id="stars-layer"></div>
<!-- Fireworks Canvas -->
<canvas class="fixed inset-0 w-full h-full pointer-events-none z-10" id="fireworks-canvas"></canvas>

<div class="relative z-20 w-full min-h-screen flex flex-col items-center justify-center p-6 text-center text-slate-100">
    
    <div class="glass p-10 rounded-[3rem] border border-yellow-600/50 shadow-[0_0_50px_rgba(234,179,8,0.2)] bg-slate-900/60 backdrop-blur-xl max-w-5xl w-full">
        <h1 class="text-7xl md:text-9xl font-black mb-6 tracking-tighter gold-text filter drop-shadow-[0_0_10px_#eab308]">
            <span id="current-year">2026</span>
        </h1>
        <p class="text-3xl text-yellow-200/80 mb-12 font-light">
            New Year <span class="text-yellow-500 font-bold hidden md:inline">•</span> New Beginnings <span class="text-yellow-500 font-bold hidden md:inline">•</span> New Goals
        </p>

        <!-- Countdown -->
        <div class="flex flex-wrap items-center justify-center mb-12" id="countdown">
            <div class="flex flex-col items-center">
                <div class="countdown-flip text-5xl md:text-7xl font-bold font-mono text-yellow-500" id="days">00</div>
                <span class="text-sm text-yellow-300 mt-2 tracking-widest uppercase">Days</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="countdown-flip text-5xl md:text-7xl font-bold font-mono text-yellow-500" id="hours">00</div>
                <span class="text-sm text-yellow-300 mt-2 tracking-widest uppercase">Hrs</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="countdown-flip text-5xl md:text-7xl font-bold font-mono text-yellow-500" id="mins">00</div>
                <span class="text-sm text-yellow-300 mt-2 tracking-widest uppercase">Min</span>
            </div>
            <div class="flex flex-col items-center">
                <div class="countdown-flip text-5xl md:text-7xl font-bold font-mono text-yellow-500" id="secs">00</div>
                <span class="text-sm text-yellow-300 mt-2 tracking-widest uppercase">Sec</span>
            </div>
        </div>

        <button id="make-wish-btn" class="px-10 py-5 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-full text-slate-900 font-bold text-2xl hover:scale-105 hover:from-yellow-400 hover:to-yellow-500 transition-all uppercase shadow-[0_0_20px_rgba(234,179,8,0.6)]">
            Make A Wish ✨
        </button>
    </div>
</div>

<!-- Modal for Wish -->
<div id="wish-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/90 backdrop-blur-sm hidden">
    <div class="glass p-8 rounded-3xl w-full max-w-md flex flex-col items-center border border-yellow-500/50 bg-slate-900 shadow-2xl">
        <h3 class="text-3xl font-bold gold-text mb-4 text-center">My Wish For Next Year</h3>
        <textarea id="wish-text" class="w-full bg-slate-800 text-yellow-100 p-4 rounded-xl border border-yellow-700/50 focus:outline-none focus:border-yellow-400 min-h-[150px]" placeholder="I hope to..."></textarea>
        <div class="flex gap-4 mt-6 w-full">
            <button onclick="document.getElementById('wish-modal').classList.add('hidden')" class="flex-1 py-3 rounded-xl border border-yellow-500/30 text-yellow-500 hover:bg-yellow-500/10 transition font-bold">Cancel</button>
            <button id="send-wish" class="flex-1 py-3 bg-yellow-500 rounded-xl text-slate-900 font-black hover:bg-yellow-400 shadow-lg shadow-yellow-500/50 transition">Send to the Stars ✨</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Stars background
        const starsLayer = document.getElementById('stars-layer');
        for(let i=0; i<150; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            star.style.width = Math.random() * 3 + 'px';
            star.style.height = star.style.width;
            star.style.left = Math.random() * 100 + 'vw';
            star.style.top = Math.random() * 100 + 'vh';
            star.style.animationDuration = Math.random() * 3 + 1 + 's';
            star.style.animationDelay = Math.random() * 2 + 's';
            starsLayer.appendChild(star);
        }

        // Set current year
        const currentYear = new Date().getFullYear();
        document.getElementById('current-year').innerText = "Happy " + currentYear;

        // Countdown Timer
        const targetDate = new Date(`Jan 1, ${currentYear + 1} 00:00:00`).getTime();
        
        const updateTimer = () => {
            const now = new Date().getTime();
            const dist = targetDate - now;

            if (dist < 0) {
                document.getElementById('countdown').innerHTML = "<h2 class='text-5xl md:text-7xl font-bold gold-text'>IT'S TIME!</h2>";
                return;
            }

            const days = Math.floor(dist / (1000 * 60 * 60 * 24));
            const hours = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const mins = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
            const secs = Math.floor((dist % (1000 * 60)) / 1000);

            const updateFlip = (id, val) => {
                const el = document.getElementById(id);
                const valStr = val < 10 ? '0'+val : val;
                if(el.innerText !== valStr) {
                    el.innerText = valStr;
                    // Flip anim
                    el.classList.add('flip-active');
                    setTimeout(() => el.classList.remove('flip-active'), 300);
                }
            };

            updateFlip('days', days);
            updateFlip('hours', hours);
            updateFlip('mins', mins);
            updateFlip('secs', secs);
        };
        setInterval(updateTimer, 1000);
        updateTimer();

        // Fireworks Confetti on load
        var duration = 15 * 1000;
        var animationEnd = Date.now() + duration;
        var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };
        
        function randomInRange(min, max) { return Math.random() * (max - min) + min; }

        var interval = setInterval(function() {
            var timeLeft = animationEnd - Date.now();
            if (timeLeft <= 0) { return clearInterval(interval); }
            var particleCount = 50 * (timeLeft / duration);
            confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } });
            confetti({ ...defaults, particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } });
        }, 250);

        // Make Wish
        const wishBtn = document.getElementById('make-wish-btn');
        const modal = document.getElementById('wish-modal');
        const sendWish = document.getElementById('send-wish');

        wishBtn.addEventListener('click', () => { modal.classList.remove('hidden'); });

        sendWish.addEventListener('click', () => {
            if(!document.getElementById('wish-text').value.trim()) return;
            modal.classList.add('hidden');
            document.getElementById('wish-text').value = '';

            // Particles rising up
            for(let i=0; i<30; i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                p.innerHTML = ['✨', '🌟', '💫', '🎆'][Math.floor(Math.random() * 4)];
                p.style.left = Math.random() * 100 + 'vw';
                document.body.appendChild(p);

                gsap.to(p, {
                    y: -window.innerHeight - 200,
                    x: "+=" + ((Math.random() - 0.5) * 300),
                    rotation: Math.random() * 360,
                    scale: Math.random() * 2,
                    opacity: 0,
                    duration: 3 + Math.random() * 4,
                    ease: "power2.inOut",
                    onComplete: () => p.remove()
                });
            }

            // Big star pop
            const msg = document.createElement('div');
            msg.className = "fixed inset-0 flex items-center justify-center z-[150] pointer-events-none";
            msg.innerHTML = `<h2 class="text-6xl md:text-8xl font-black gold-text filter drop-shadow-[0_0_20px_#eab308]">Wish Sent!</h2>`;
            document.body.appendChild(msg);

            gsap.fromTo(msg, 
                { scale: 0, opacity: 0 }, 
                { scale: 1.2, opacity: 1, duration: 1, ease: "back.out(1.5)" }
            );
            gsap.to(msg, { scale: 2, opacity: 0, duration: 1, delay: 1.5, onComplete: () => msg.remove() });
        });
    });
</script>
@endsection
