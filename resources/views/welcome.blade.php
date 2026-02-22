@extends('layouts.app')
@section('title', 'HappyDay - Choose Your Occasion')
@section('audio_src', 'https://archive.org/download/UpbeatAndHappyBackgroundMusic/Upbeat%20and%20Happy%20Background%20Music.mp3')
@section('styles')
<style>
    .card:hover .icon-animate {
        transform: scale(1.2) rotate(10deg);
        transition: transform 0.3s ease-out;
    }
    .icon-animate {
        transition: transform 0.3s ease-out;
    }
    
    #bg-layer {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        pointer-events: none;
        z-index: 0;
        transition: background-color 1s ease, opacity 0.5s ease;
        overflow: hidden;
    }
    
    .floating-item {
        position: absolute;
        bottom: -50px;
        animation: floatUp 5s linear infinite;
        opacity: 0.7;
    }

    @keyframes floatUp {
        to {
            transform: translateY(-110vh) rotate(360deg);
            opacity: 0;
        }
    }
</style>
@endsection

@section('content')
<div id="bg-layer" class="bg-gray-900 transition-colors duration-1000"></div>

<!-- Lottie / Canvas Container for BG -->
<canvas id="confetti-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-10"></canvas>

<div class="relative z-20 w-full flex flex-col items-center justify-center min-h-screen p-6 mt-[60px]">
    <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 mb-4 text-center header-anim">
        Celebrate With Us
    </h1>
    <p class="text-xl md:text-2xl text-gray-300 mb-12 text-center max-w-2xl px-4 subhead-anim">
        Choose an occasion below to spread the joy and make someone's day special.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl cards-container">
        <!-- Valentines -->
        <a href="{{ route('valentines') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-pink-500/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="valentines">
            <div class="absolute inset-0 bg-gradient-to-br from-pink-600/20 to-rose-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">💖</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Valentine's Day</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Send romantic love and hearts</p>
        </a>

        <!-- Fathers -->
        <a href="{{ route('fathers-day') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-blue-500/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="fathers">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-cyan-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">👔</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Father's Day</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Classic vintage appreciation</p>
        </a>

        <!-- Mothers -->
        <a href="{{ route('mothers-day') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-pink-300/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="mothers">
            <div class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-fuchsia-400/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">🌸</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Mother's Day</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Beautiful floral greetings</p>
        </a>

        <!-- Birthday -->
        <a href="{{ route('birthday') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-yellow-500/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="birthday">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/20 to-orange-500/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">🎂</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Happy Birthday</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Balloons, confetti and fun</p>
        </a>

        <!-- Christmas -->
        <a href="{{ route('christmas') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-green-500/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="christmas">
            <div class="absolute inset-0 bg-gradient-to-br from-red-600/20 to-green-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">🎄</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Merry Christmas</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Snowy & sparkling wishes</p>
        </a>

        <!-- New Year -->
        <a href="{{ route('new-year') }}" class="card glass rounded-3xl p-8 flex flex-col items-center justify-center gap-4 hover:shadow-2xl hover:shadow-purple-500/50 hover:-translate-y-2 transition-all duration-300 relative group overflow-hidden border border-white/10" data-theme="newyear">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-800/20 to-indigo-800/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <span class="text-7xl icon-animate relative z-10">🎆</span>
            <h2 class="text-3xl font-bold text-white relative z-10">Happy New Year</h2>
            <p class="text-center text-gray-300 relative z-10 opacity-80 group-hover:opacity-100">Glitter effects & fireworks</p>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // GSAP Intro
    gsap.from(".header-anim", { y: -50, opacity: 0, duration: 1, ease: "back.out(1.7)" });
    gsap.from(".subhead-anim", { y: 30, opacity: 0, duration: 1, delay: 0.3, ease: "power3.out" });
    gsap.from(".card", { 
        y: 100, opacity: 0, duration: 0.8, 
        stagger: 0.1, 
        ease: "power3.out",
        clearProps: "all"
    });

    const body = document.body;
    const bgLayer = document.getElementById('bg-layer');
    const cards = document.querySelectorAll('.card');
    
    let particleInterval = null;

    const spawnParticles = (emoji) => {
        const item = document.createElement("div");
        item.classList.add("floating-item", "text-3xl");
        item.innerText = emoji;
        item.style.left = Math.random() * 100 + "vw";
        item.style.animationDuration = Math.random() * 3 + 3 + "s";
        bgLayer.appendChild(item);
        
        setTimeout(() => { item.remove(); }, 6000);
    };

    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const theme = card.getAttribute('data-theme');
            clearInterval(particleInterval);
            
            bgLayer.innerHTML = ''; // clear old
            let emoji = '';
            
            switch(theme) {
                case 'valentines':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-rose-900 via-pink-900 to-black transition-colors duration-1000';
                    emoji = '💖';
                    document.getElementById('bgm-audio').src = "{{ asset('images/valentines.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    particleInterval = setInterval(() => spawnParticles(emoji), 300);
                    break;
                case 'fathers':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-blue-900 via-slate-800 to-black transition-colors duration-1000';
                    emoji = '👔';
                    document.getElementById('bgm-audio').src = "{{ asset('images/fathers.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    particleInterval = setInterval(() => spawnParticles(emoji), 500);
                    break;
                case 'mothers':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-fuchsia-900 via-pink-800 to-black transition-colors duration-1000';
                    emoji = '🌸';
                    document.getElementById('bgm-audio').src = "{{ asset('images/mothers.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    particleInterval = setInterval(() => spawnParticles(emoji), 400);
                    break;
                case 'birthday':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-amber-900 via-orange-900 to-black transition-colors duration-1000';
                    document.getElementById('bgm-audio').src = "{{ asset('images/birthday.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    confetti({ particleCount: 50, spread: 70, origin: { y: 0.6 } });
                    break;
                case 'christmas':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-green-900 via-emerald-900 to-black transition-colors duration-1000';
                    emoji = '❄️';
                    document.getElementById('bgm-audio').src = "{{ asset('images/christmas.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    particleInterval = setInterval(() => spawnParticles(emoji), 200);
                    break;
                case 'newyear':
                    bgLayer.className = 'absolute inset-0 bg-gradient-to-b from-indigo-900 via-purple-900 to-black transition-colors duration-1000';
                    emoji = '✨';
                    document.getElementById('bgm-audio').src = "{{ asset('images/newyear.mp3') }}";
                    document.getElementById('bgm-audio').play().catch(e => {});
                    particleInterval = setInterval(() => spawnParticles(emoji), 200);
                    break;
            }
        });

        card.addEventListener('mouseleave', () => {
             clearInterval(particleInterval);
             bgLayer.className = 'absolute inset-0 bg-gray-900 transition-colors duration-1000';
             document.getElementById('bgm-audio').src = "@yield('audio_src')";
             document.getElementById('bgm-audio').play().catch(e => {});
             setTimeout(() => bgLayer.innerHTML = '', 1000); // fade out items smoothly? Let them animate
        });
    });
});
</script>
@endsection
