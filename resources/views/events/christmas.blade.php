@extends('layouts.app')
@section('title', 'Merry Christmas')
@section('audio_src', asset('images/christmas.mp3'))

@section('styles')
<style>
    body { background-color: #0f172a; } /* slate-900 */
    .bg-winter {
        background: linear-gradient(180deg, #020617 0%, #172554 40%, #1e3a8a 80%, #93c5fd 100%);
    }
    
    /* Snowflake particle */
    .snowflake {
        position: absolute;
        top: -10vh;
        color: white;
        font-size: 1.5em;
        text-shadow: 0 0 5px rgba(255,255,255,0.8);
        user-select: none;
        z-index: 1000;
        animation: fall linear infinite;
    }
    @keyframes fall {
        0% { transform: translateY(-10vh) translateX(0) scale(1) rotate(0); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(110vh) translateX(50px) scale(0.5) rotate(360deg); opacity: 0; }
    }

    /* Twinkling Lights */
    .lights-container {
        pointer-events: none;
        position: fixed; top: 0; left: 0; right: 0; height: 30px;
        z-index: 50;
        display: flex; justify-content: space-between; overflow: hidden;
    }
    .bulb {
        width: 15px; height: 30px; border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        margin-top: -10px; position: relative;
        animation: flash 1s alternate infinite;
    }
    .bulb::before { /* string connection */
        content:""; position: absolute; background:#111; width: 6px; height: 10px; border-radius: 2px;
        top: -8px; left: 5px;
    }
    .bulb:nth-child(odd) { background: #ef4444; animation-delay: 0.5s; }
    .bulb:nth-child(even) { background: #efc344; animation-delay: 0s; }
    .bulb:nth-child(3n) { background: #10b981; animation-delay: 0.25s; }
    .bulb:nth-child(4n) { background: #3b82f6; animation-delay: 0.75s; }

    @keyframes flash {
        0% { opacity: 0.5; box-shadow: 0 0 5px currentColor; }
        100% { opacity: 1; box-shadow: 0 0 20px currentColor; }
    }
    
    /* Sleigh Animation */
    .sleigh {
        position: fixed; top: 20%; left: -20%; font-size: 4rem; z-index: 40; filter: drop-shadow(5px 5px 15px rgba(255,255,255,0.4));
        animation: flySleigh 15s linear infinite; pointer-events: none;
    }
    @keyframes flySleigh {
        0% { transform: translateX(0) translateY(0) scale(0.5); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateX(120vw) translateY(-20vh) scale(1); opacity: 0; }
    }

    .gift-box { transition: all 0.3s ease; }
    .gift-box:hover { transform: scale(1.05); filter: drop-shadow(0 0 20px #ef4444); }
</style>
@endsection

@section('content')
<!-- Ambient background layer -->
<div class="fixed inset-0 bg-winter z-0"></div>

<!-- Snow Container -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-10" id="snow-layer"></div>

<div class="lights-container w-full" id="lights">
    <!-- Intentionally added via JS but we can add some HTML base -->
    @for($i=0; $i<40; $i++)
        <div class="bulb hidden md:block" style="margin-left: {{ rand(10,30) }}px; margin-right: {{ rand(10,30) }}px"></div>
    @endfor
</div>

<div class="sleigh">🎅🛷🦌🦌🦌</div>

<!-- Main UI -->
<div class="relative z-20 w-full min-h-screen flex flex-col items-center justify-center p-6 text-center text-white">
    <div class="mb-8 mt-16 group cursor-pointer" id="present-btn">
        <h1 class="text-6xl md:text-8xl font-black bg-clip-text text-transparent bg-gradient-to-r from-red-500 via-yellow-300 to-green-500 mb-6 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)] filter">
            Merry Christmas
        </h1>
        <p class="text-xl md:text-3xl text-blue-100 font-serif italic max-w-2xl mx-auto tracking-wide mb-12">
             "May your days be merry and bright."
        </p>

        <!-- The Present -->
        <div class="relative w-48 h-48 mx-auto mt-8 perspective-1000 transform transition-transform duration-500 hover:rotate-3">
             <div class="absolute inset-0 bg-red-600 rounded-lg shadow-2xl border-4 border-red-800 flex items-center justify-center gift-box overflow-hidden" id="present-base">
                 <!-- Ribbons -->
                 <div class="absolute w-full h-8 bg-yellow-400 opacity-90 shadow-sm top-1/2 -translate-y-1/2"></div>
                 <div class="absolute h-full w-8 bg-yellow-400 opacity-90 shadow-sm left-1/2 -translate-x-1/2"></div>
                 <div class="absolute w-12 h-12 border-4 border-yellow-400 rounded-full top-2 left-1/2 -translate-x-[110%] ml-4 bg-red-600"></div>
                 <div class="absolute w-12 h-12 border-4 border-yellow-400 rounded-full top-2 right-1/2 translate-x-[110%] mr-4 bg-red-600"></div>
                 <span class="z-10 text-xl font-bold text-red-900 mt-2 bg-yellow-200/90 px-3 py-1 rounded-sm shadow-md animate-pulse">Open Present</span>
             </div>
        </div>
    </div>

    <!-- Hidden Message Container -->
    <div id="christmas-msg" class="glass hidden mt-12 p-8 rounded-3xl w-full max-w-2xl text-center bg-red-900/60 shadow-2xl border border-red-500/30 backdrop-blur-md opacity-0 scale-50 transition-all duration-700">
         <h2 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-yellow-200 to-yellow-500 mb-4 font-serif">
             Warmest Greetings
         </h2>
         <p class="text-xl text-red-100 font-light leading-relaxed">
             Wishing you a magical holiday season filled with joy, love, and laughter. May the upcoming year bring you prosperity and peace!
         </p>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Snow Parallax
        const layer = document.getElementById('snow-layer');
        const flakeChars = ['❄', '❆', '❅', '♦'];

        const createFlake = () => {
            const f = document.createElement('div');
            f.classList.add('snowflake');
            f.innerText = flakeChars[Math.floor(Math.random() * flakeChars.length)];
            f.style.left = Math.random() * 100 + 'vw';
            f.style.animationDuration = Math.random() * 5 + 5 + 's';
            f.style.opacity = Math.random();
            f.style.fontSize = (Math.random() * 1.5 + 0.5) + 'em';
            
            layer.appendChild(f);
            setTimeout(() => f.remove(), 10000);
        };
        setInterval(createFlake, 200); // Snowfall rate

        // Open present interaction
        const presentBtn = document.getElementById('present-btn');
        const presentBase = document.getElementById('present-base');
        const msg = document.getElementById('christmas-msg');

        presentBtn.addEventListener('click', () => {
            if(!msg.classList.contains('hidden')) return; // Already open

            // Shake present
            gsap.to(presentBase, { x: 10, duration: 0.1, yoyo: true, repeat: 5 });
            
            setTimeout(() => {
                // Fly present away
                gsap.to(presentBase, { 
                    y: -500, scale: 0, opacity: 0, rotation: 180, duration: 1, ease: "power2.in" 
                });
                
                // Show message
                msg.classList.remove('hidden');
                setTimeout(() => {
                    msg.classList.remove('opacity-0', 'scale-50');
                    msg.classList.add('opacity-100', 'scale-100');
                    
                    // Trigger confetti explosion
                    confetti({
                        particleCount: 200,
                        spread: 120,
                        origin: { y: 0.5 },
                        colors: ['#ef4444', '#10b981', '#f59e0b']
                    });
                }, 500);

            }, 600);
        });
    });
</script>
@endsection
