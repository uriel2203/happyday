@extends('layouts.app')
@section('title', 'Happy Valentine\'s Day')
@section('audio_src', asset('images/valentines.mp3'))

@section('styles')
<style>
    body { background-color: #4c0519; }
    .heart-bg {
        position: absolute; width: 100%; height: 100%; top: 0; left: 0; pointer-events: none; overflow: hidden;
    }
    .heart {
        position: absolute; bottom: -50px; opacity: 0.5; color: #ff4d6d;
        animation: floatHeart 6s linear infinite; font-size: 2rem;
    }
    @keyframes floatHeart {
        0% { transform: translateY(0) scale(1) rotate(0); opacity: 0; }
        50% { opacity: 0.8; }
        100% { transform: translateY(-120vh) scale(1.5) rotate(45deg); opacity: 0; }
    }
    .quote-box { transition: opacity 1s ease-in-out; }
</style>
@endsection

@section('content')
<!-- Ambient background layer -->
<div class="absolute inset-0 bg-gradient-to-br from-rose-900 via-pink-900 to-black z-0"></div>

<!-- Floating hearts container -->
<div class="heart-bg z-0" id="heart-container"></div>

<div class="relative z-10 flex flex-col items-center justify-start min-h-screen text-center p-4 pt-24 w-full max-w-4xl mx-auto">
    
    <div class="valentine-items animate-bounce mb-2">
         <span class="text-6xl drop-shadow-[0_0_20px_rgba(255,20,147,0.8)]">💖</span>
    </div>

    <h1 class="text-4xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-pink-300 mb-8 filter drop-shadow-md">
        Happy Valentine's Day
    </h1>

    <!-- Will you be my Valentine Section -->
    <div class="glass p-8 rounded-3xl w-full max-w-lg mb-8 relative flex flex-col items-center justify-center border border-pink-500/30 transition-all duration-500" id="valentine-question-card">
        <h2 class="text-3xl font-bold text-pink-200 mb-4 drop-shadow-md text-center">Will you be my Valentine?</h2>
        <img id="valentine-img" src="{{ asset('images/1.jpg') }}" class="w-40 h-auto rounded-xl mb-6 shadow-[0_0_15px_rgba(236,72,153,0.8)] filter drop-shadow-xl object-contain bg-white" alt="Cute pleading face" />
        <div class="flex items-center justify-center gap-6 w-full h-[50px]" id="valentine-btn-container">
            <button id="btn-yes" class="px-8 py-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full text-white font-bold text-xl hover:scale-110 shadow-[0_0_20px_rgba(16,185,129,0.5)] transition-transform z-10 relative">
                Yes! 🥰
            </button>
            <button id="btn-no" class="px-8 py-3 bg-gradient-to-r from-red-400 to-rose-500 rounded-full text-white font-bold text-xl shadow-[0_0_20px_rgba(244,63,94,0.5)] relative z-50 transition-all duration-200 cursor-pointer">
                No 😢
            </button>
        </div>
    </div>

    <!-- Floating Action Buttons on Left -->
    <div class="fixed bottom-6 left-6 flex flex-col gap-4 z-40">
        <button id="send-heart" class="px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full text-white font-bold text-lg hover:scale-105 shadow-[0_0_20px_rgba(236,72,153,0.5)] transition-all flex items-center gap-2">
            <span>Send Heart</span> 💘
        </button>
        <button onclick="document.getElementById('msg-modal').classList.remove('hidden')" class="px-6 py-3 bg-transparent border border-pink-400 bg-pink-950/40 backdrop-blur-md rounded-full text-pink-300 font-bold text-lg hover:bg-pink-900/80 hover:scale-105 transition-all flex items-center gap-2">
            <span>Write Note</span> ✍️
        </button>
    </div>
</div>

<!-- Modal for message -->
<div id="msg-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden">
    <div class="glass p-8 rounded-3xl w-full max-w-md flex flex-col items-center">
        <h3 class="text-2xl text-pink-300 mb-4 font-bold">Write a Love Note</h3>
        <textarea id="personal-msg" class="w-full bg-pink-950/50 text-white p-4 rounded-xl border border-pink-500/50 focus:outline-none focus:border-pink-300 min-h-[120px]" placeholder="My dearest..."></textarea>
        <div class="flex gap-4 mt-6">
            <button onclick="document.getElementById('msg-modal').classList.add('hidden')" class="px-6 py-2 rounded-full text-gray-300 hover:text-white">Cancel</button>
            <button id="submit-msg" class="px-6 py-2 bg-pink-500 rounded-full text-white font-bold hover:bg-pink-400 hover:shadow-[0_0_15px_rgba(236,72,153,0.8)]">Seal with a Kiss 💋</button>
        </div>
    </div>
</div>

<!-- Overlay for animated msg -->
<div id="msg-overlay" class="fixed inset-0 z-50 flex items-center justify-center hidden pointer-events-none">
    <div id="animated-text" class="text-4xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-pink-300 text-center drop-shadow-2xl px-6"></div>
</div>

@endsection

@section('scripts')
<script>
    // Dodging "No" button logic
    const noBtn = document.getElementById('btn-no');
    const yesBtn = document.getElementById('btn-yes');
    const valImg = document.getElementById('valentine-img');
    const valTitle = document.querySelector('#valentine-question-card h2');

    let dodgeCount = 0;
    const dodgeNo = () => {
        dodgeCount++;

        if (dodgeCount === 1) {
            valImg.src = "{{ asset('images/2.jpg') }}";
        } else if (dodgeCount === 2) {
            valImg.src = "{{ asset('images/5.webp') }}";
        } else if (dodgeCount >= 3) {
            // GSAP Fly away effect
            gsap.to(noBtn, {
                x: window.innerWidth,
                y: -window.innerHeight,
                rotation: 1080,
                opacity: 0,
                scale: 0.2,
                duration: 1.5,
                ease: "power2.in",
                onComplete: () => noBtn.style.display = 'none'
            });
            return;
        }

        // Apply absolute positioning relative to the card container
        noBtn.style.position = 'absolute';
        const card = document.getElementById('valentine-question-card');
        
        let newLeft, newTop;
        let overlap = true;
        let attempts = 0;
        
        // Find all buttons specifically inside the card to avoid overlapping the Yes button
        const allButtons = card.querySelectorAll('button');
        const buffer = 20;

        while (overlap && attempts < 100) {
            // Keep strictly inside the card dimensions with a small buffer padding
            newLeft = 20 + Math.random() * (card.offsetWidth - noBtn.offsetWidth - 40);
            newTop = 20 + Math.random() * (card.offsetHeight - noBtn.offsetHeight - 40);
            
            overlap = false;
            for (let btn of allButtons) {
                if (btn === noBtn) continue; // ignore self
                
                const rectNode = btn.getBoundingClientRect();
                const cardRect = card.getBoundingClientRect();
                
                const btnNodeLeft = rectNode.left - cardRect.left;
                const btnNodeTop = rectNode.top - cardRect.top;

                // Collision detection comparing new coordinate bounds vs existing internal button bounds
                if (
                    newLeft + noBtn.offsetWidth > btnNodeLeft - buffer &&
                    newLeft < btnNodeLeft + rectNode.width + buffer &&
                    newTop + noBtn.offsetHeight > btnNodeTop - buffer &&
                    newTop < btnNodeTop + rectNode.height + buffer
                ) {
                    overlap = true;
                    break;
                }
            }
            attempts++;
        }

        noBtn.style.left = newLeft + 'px';
        noBtn.style.top = newTop + 'px';
    };

    noBtn.addEventListener('mouseover', dodgeNo);
    noBtn.addEventListener('click', dodgeNo); // For mobile touch

    yesBtn.addEventListener('click', () => {
        valTitle.innerText = "YAY! I love you! 💕";
        // cute bear hugging
        valImg.src = "{{ asset('images/6.gif') }}";
        
        // Dynamically double the image size when 6.gif is showing
        valImg.classList.remove('w-40');
        valImg.classList.add('w-72', 'max-w-full', 'md:w-96');

        noBtn.style.display = 'none';
        yesBtn.classList.add('hidden');
        
        // Show big heart explode
        for(let i=0; i<40; i++) {
            const h = document.createElement('div');
            h.innerHTML = Math.random() > 0.5 ? '💖' : '💕';
            h.style.position = 'fixed';
            h.style.left = window.innerWidth / 2 + 'px';
            h.style.top = window.innerHeight / 2 + 'px';
            h.style.fontSize = Math.random() * 2 + 1.5 + 'rem';
            h.style.zIndex = '200';
            document.body.appendChild(h);

            gsap.to(h, {
                x: (Math.random() - 0.5) * window.innerWidth * 0.8,
                y: (Math.random() - 0.5) * window.innerHeight * 0.8,
                opacity: 0,
                rotation: Math.random() * 360,
                scale: Math.random() * 2 + 1,
                duration: 2 + Math.random() * 2,
                ease: "power3.out",
                onComplete: () => h.remove()
            });
        }
    });

    // Initial background hearts
    const heartContainer = document.getElementById('heart-container');
    const spawnBgHeart = () => {
        const heart = document.createElement('div');
        heart.classList.add('heart');
        heart.innerHTML = ['💖', '💕', '💗', '💓', '💞'][Math.floor(Math.random() * 5)];
        heart.style.left = Math.random() * 100 + 'vw';
        heart.style.animationDuration = Math.random() * 4 + 4 + 's';
        heartContainer.appendChild(heart);
        setTimeout(() => heart.remove(), 7000);
    };
    setInterval(spawnBgHeart, 500);

    // Send Heart Interaction
    document.getElementById('send-heart').addEventListener('click', (e) => {
        const bigHeart = document.createElement('div');
        bigHeart.innerHTML = '💘';
        bigHeart.style.position = 'fixed';
        bigHeart.style.left = e.clientX + 'px';
        bigHeart.style.top = e.clientY + 'px';
        bigHeart.style.fontSize = '3rem';
        bigHeart.style.pointerEvents = 'none';
        bigHeart.style.zIndex = '100';
        document.body.appendChild(bigHeart);

        gsap.to(bigHeart, {
            y: -500,
            x: (Math.random() - 0.5) * 200,
            scale: 3,
            opacity: 0,
            rotation: 45,
            duration: 2,
            ease: "power2.out",
            onComplete: () => bigHeart.remove()
        });
        
        // Extra sparkles
        for(let i=0; i<5; i++) {
            const spark = document.createElement('div');
            spark.innerHTML = '✨';
            spark.style.position = 'fixed';
            spark.style.left = e.clientX + 'px';
            spark.style.top = e.clientY + 'px';
            spark.style.zIndex = '99';
            document.body.appendChild(spark);
            gsap.to(spark, {
                y: (Math.random() - 0.5) * 300 - 100,
                x: (Math.random() - 0.5) * 300,
                opacity: 0,
                duration: 1.5,
                ease: "power2.out",
                onComplete: () => spark.remove()
            });
        }
    });

    // Write message
    document.getElementById('submit-msg').addEventListener('click', () => {
        const text = document.getElementById('personal-msg').value;
        if(text.trim() === '') return;
        document.getElementById('msg-modal').classList.add('hidden');
        
        const overlay = document.getElementById('msg-overlay');
        const textEl = document.getElementById('animated-text');
        overlay.classList.remove('hidden');
        textEl.innerText = text;

        gsap.fromTo(textEl, 
            { scale: 0, opacity: 0, rotation: -10 }, 
            { scale: 1, opacity: 1, rotation: 0, duration: 1.5, ease: "elastic.out(1, 0.5)" }
        );

        // Explode hearts around text
        for(let i=0; i<20; i++) {
            const h = document.createElement('div');
            h.innerHTML = '💖';
            h.style.position = 'absolute';
            h.style.fontSize = '2rem';
            overlay.appendChild(h);

            gsap.fromTo(h,
                { x: 0, y: 0, opacity: 1, scale: 0.5 },
                { 
                    x: (Math.random() - 0.5) * innerWidth, 
                    y: (Math.random() - 0.5) * innerHeight, 
                    opacity: 0, 
                    scale: 2,
                    duration: 2 + Math.random(),
                    ease: "power3.out",
                    onComplete: () => h.remove()
                }
            );
        }

        setTimeout(() => {
            gsap.to(textEl, { opacity: 0, y: -100, duration: 1, onComplete: () => {
                overlay.classList.add('hidden');
                document.getElementById('personal-msg').value = '';
            }});
        }, 4000);
    });
</script>
@endsection
