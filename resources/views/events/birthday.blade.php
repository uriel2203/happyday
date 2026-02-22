@extends('layouts.app')
@section('title', 'Happy Birthday!')
@section('audio_src', asset('images/birthday.mp3'))

@section('styles')
<style>
    body { background-color: #fef08a; } /* yellow-200 */
    .dark body { background-color: #713f12; } /* yellow-900 */
    
    .flame {
        animation: flicker 1s ease-in-out infinite alternate;
        transform-origin: bottom center;
    }
    .flame-blown {
        animation: blowOut 0.5s forwards;
    }
    
    @keyframes flicker {
        0% { transform: scale(1) skewX(2deg); opacity: 0.9; }
        100% { transform: scale(1.1) skewX(-2deg); opacity: 1; filter: drop-shadow(0 0 10px #f59e0b); }
    }
    @keyframes blowOut {
        to { transform: scale(0) translateY(-20px); opacity: 0; }
    }

    .balloon {
        position: absolute;
        bottom: -150px;
        animation: floatUpBalloon 10s linear infinite;
        opacity: 0.8;
        filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.2));
    }
    @keyframes floatUpBalloon {
        to { transform: translateY(-120vh) translateX(50px) rotate(15deg); }
    }
</style>
@endsection

@section('content')
<!-- Animated Balloons Background -->
<div class="fixed inset-0 overflow-hidden pointer-events-none z-0" id="balloon-bg">
    <!-- Balloons will be injected via JS -->
</div>

<div class="relative z-10 w-full min-h-screen flex flex-col items-center justify-center p-6 text-center">
    
    <div class="glass p-12 rounded-[3rem] border border-yellow-300 dark:border-yellow-700 shadow-2xl relative w-full max-w-4xl bg-orange-100/40 dark:bg-yellow-950/40 backdrop-blur-xl">
        <h1 class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-pink-400 to-indigo-400 mb-4 animate-pulse">
            Happy Birthday!
        </h1>
        <p class="text-2xl text-orange-800 dark:text-yellow-100 mb-12 font-semibold tracking-wide">
            Make a wish and blow out the candle!
        </p>

        <!-- Cake & Candle -->
        <div class="relative w-48 h-48 mx-auto flex flex-col items-center justify-end mb-12">
            <!-- Candle Flame -->
            <div id="flame" class="w-8 h-12 bg-gradient-to-t from-orange-400 to-yellow-200 rounded-full flame absolute top-[-30px] shadow-[0_0_20px_#fbbf24] cursor-pointer" onclick="blowCandle()"></div>
            <!-- Candle Stick -->
            <div class="w-4 h-20 bg-gradient-to-r from-teal-200 to-teal-400 rounded-sm mb-[-2px] relative z-10 border-x-2 border-teal-500/30">
                <!-- Stripes -->
                <div class="absolute w-full h-[2px] bg-red-400 top-2 rotate-12"></div>
                <div class="absolute w-full h-[2px] bg-red-400 top-8 rotate-12"></div>
                <div class="absolute w-full h-[2px] bg-red-400 top-14 rotate-12"></div>
            </div>
            <!-- Cake Base -->
            <div class="w-32 h-16 bg-gradient-to-b from-pink-300 to-pink-500 rounded-xl rounded-t-lg border-2 border-pink-600/20 shadow-xl relative z-20 overflow-hidden flex items-start justify-center">
                 <!-- Icing Dribbles -->
                 <div class="absolute top-0 w-8 h-8 bg-white rounded-full -left-2 shadow-sm"></div>
                 <div class="absolute top-0 w-8 h-8 bg-white rounded-full left-4 shadow-sm"></div>
                 <div class="absolute top-0 w-8 h-8 bg-white rounded-full left-12 shadow-sm"></div>
                 <div class="absolute top-0 w-8 h-8 bg-white rounded-full right-4 shadow-sm"></div>
                 <div class="absolute top-0 w-8 h-8 bg-white rounded-full -right-2 shadow-sm"></div>
                 <div class="mt-8 text-2xl">🍰</div>
            </div>
        </div>

        <!-- Hidden Surprise message -->
        <div id="surprise-msg" class="absolute inset-0 z-50 bg-white dark:bg-yellow-900 rounded-[3rem] p-8 flex flex-col items-center justify-center hidden opacity-0 shadow-2xl overflow-hidden scale-90 border-4 border-indigo-500">
            <span class="text-8xl mb-4 animate-bounce">🎁</span>
            <h2 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-blue-500 mb-4">You did it!</h2>
            <p class="text-xl text-emerald-800 dark:text-emerald-100 font-bold bg-emerald-100 dark:bg-emerald-900 p-4 rounded-xl shadow-inner relative z-10">
                 "Wishing you a day filled with happiness and a year filled with joy."
            </p>
            <button onclick="window.location.reload()" class="mt-8 px-6 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-full font-bold shadow-lg relative z-10">Play Again</button>
            <canvas id="surprise-confetti" class="absolute inset-0 w-full h-full pointer-events-none"></canvas>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Init balloons
        const balloonBg = document.getElementById('balloon-bg');
        const balloonColors = ['bg-red-400', 'bg-blue-400', 'bg-green-400', 'bg-yellow-400', 'bg-purple-400', 'bg-pink-400'];

        for(let i=0; i<15; i++) {
            const b = document.createElement('div');
            b.classList.add('balloon', 'rounded-[50%_50%_50%_50%_/_60%_60%_40%_40%]', 'w-16', 'h-24', 'shadow-inner');
            b.classList.add(balloonColors[Math.floor(Math.random() * balloonColors.length)]);
            b.style.left = Math.random() * 100 + 'vw';
            b.style.animationDuration = Math.random() * 5 + 8 + 's';
            b.style.animationDelay = Math.random() * 5 + 's';

            // knot
            const knot = document.createElement('div');
            knot.className = `w-4 h-4 mt-24 ml-6 rotate-45 ${b.className.match(/bg-\w+-400/)[0]}`;
            b.appendChild(knot);
            
            // string
            const str = document.createElement('div');
            str.className = "w-0.5 h-32 bg-gray-300 ml-8 -mt-2 opacity-50";
            b.appendChild(str);

            balloonBg.appendChild(b);
        }
    });

    const blowCandle = () => {
        const flame = document.getElementById('flame');
        if(flame.classList.contains('flame-blown')) return;
        
        // Blow animation
        flame.classList.remove('flame');
        flame.classList.add('flame-blown');

        // Trigger confetti burst
        confetti({
            particleCount: 150,
            spread: 100,
            origin: { y: 0.6 },
            colors: ['#26ccff', '#a25afd', '#ff5e7e', '#88ff5a', '#fcff42', '#ffa62d', '#ff36ff']
        });

        // Show surprise after 1s
        setTimeout(() => {
            const surprise = document.getElementById('surprise-msg');
            surprise.classList.remove('hidden');
            gsap.to(surprise, {
                opacity: 1,
                scale: 1,
                duration: 1.5,
                ease: "elastic.out(1, 0.5)"
            });

            // continuous confetti for surprise
            const myConfetti = confetti.create(document.getElementById('surprise-confetti'), { resize: true, useWorker: true });
            const duration = 5 * 1000;
            const end = Date.now() + duration;

            (function frame() {
              myConfetti({ particleCount: 5, angle: 60, spread: 55, origin: { x: 0 }, colors: ['#ff0', '#0f0'] });
              myConfetti({ particleCount: 5, angle: 120, spread: 55, origin: { x: 1 }, colors: ['#f0f', '#0ff'] });
              if (Date.now() < end) requestAnimationFrame(frame);
            }());
        }, 800);
    };
</script>
@endsection
