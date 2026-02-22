@extends('layouts.app')
@section('title', 'Happy Mother\'s Day')
@section('audio_src', asset('images/mothers.mp3'))

@section('styles')
<style>
    body { background-color: #fdf2f8; } /* pink-50 */
    .dark body { background-color: #831843; } /* pink-900 */
    .floral-bg {
        background-image: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" stroke="rgba(236,72,153,0.1)" stroke-width="2" fill="none"/><path d="M50 10 Q60 50 50 90 Q40 50 50 10" fill="none" stroke="rgba(236,72,153,0.1)" stroke-width="2"/></svg>');
        background-size: 150px;
    }
    
    .flower {
        display: inline-block;
        transition: transform 0.5s ease;
    }
    .bloom:hover .flower {
        transform: scale(1.5) rotate(15deg);
    }
    .petal {
        position: fixed;
        top: -20px;
        opacity: 0.8;
        transform-origin: center;
    }
</style>
@endsection

@section('content')
<div class="absolute inset-0 floral-bg pointer-events-none z-0"></div>

<div class="relative z-10 w-full min-h-screen flex flex-col md:flex-row p-6 gap-8 max-w-6xl mx-auto mt-16 md:mt-0 items-center justify-center text-pink-900 dark:text-pink-100">
    
    <!-- Left: Title and Actions -->
    <div class="flex-1 flex flex-col items-center md:items-start text-center md:text-left">
        <div class="bloom cursor-pointer mb-4">
            <span class="text-7xl flower filter drop-shadow-[0_0_15px_rgba(244,114,182,0.8)]">🌸</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-rose-400 mb-6 drop-shadow-sm">
            Happy Mother's Day
        </h1>
        <p class="text-xl md:text-2xl font-light mb-8 max-w-md">
            To the most beautiful person, inside and out. Thank you for everything.
        </p>

        <button id="send-flower-btn" class="px-8 py-4 bg-gradient-to-r from-pink-400 to-rose-400 text-white rounded-full shadow-lg shadow-pink-300 hover:shadow-pink-500 hover:scale-105 transition-all text-xl font-semibold bloom group relative overflow-hidden">
            <span class="relative z-10 flex items-center gap-2">Send a Flower <span class="flower group-hover:scale-125">🌺</span></span>
        </button>
    </div>

    <!-- Right: Card Generator -->
    <div class="flex-1 w-full max-w-md bg-white/60 dark:bg-pink-950/40 backdrop-blur-md p-8 rounded-3xl border border-pink-200 dark:border-pink-800 shadow-2xl">
        <h3 class="text-2xl font-bold mb-4 text-pink-700 dark:text-pink-300 flex items-center gap-2">
            Create a Card ✨
        </h3>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold mb-1 text-pink-900/60 dark:text-pink-100/60">To:</label>
                <input type="text" id="card-to" placeholder="Mom" class="w-full p-3 rounded-lg bg-white/50 dark:bg-pink-900/50 border border-pink-200 dark:border-pink-700 outline-none focus:border-pink-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1 text-pink-900/60 dark:text-pink-100/60">Message:</label>
                <textarea id="card-msg" rows="3" placeholder="You are the best!" class="w-full p-3 rounded-lg bg-white/50 dark:bg-pink-900/50 border border-pink-200 dark:border-pink-700 outline-none focus:border-pink-500 transition-colors"></textarea>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1 text-pink-900/60 dark:text-pink-100/60">From:</label>
                <input type="text" id="card-from" placeholder="Your Name" class="w-full p-3 rounded-lg bg-white/50 dark:bg-pink-900/50 border border-pink-200 dark:border-pink-700 outline-none focus:border-pink-500 transition-colors">
            </div>
        </div>

        <div class="mt-8 p-6 bg-gradient-to-br from-pink-100 to-white dark:from-pink-900 dark:to-pink-950 rounded-xl min-h-[200px] shadow-inner text-center relative overflow-hidden" id="live-card">
            <!-- decorative corners -->
            <div class="absolute top-2 left-2 text-pink-300 dark:text-pink-600 opacity-50">❀</div>
            <div class="absolute top-2 right-2 text-pink-300 dark:text-pink-600 opacity-50">❀</div>
            <div class="absolute bottom-2 left-2 text-pink-300 dark:text-pink-600 opacity-50">❀</div>
            <div class="absolute bottom-2 right-2 text-pink-300 dark:text-pink-600 opacity-50">❀</div>
            
            <h4 class="text-lg font-bold mt-4 text-pink-600 dark:text-pink-300 font-serif" id="preview-to">Dearest Mom,</h4>
            <p class="mt-4 text-pink-800 dark:text-pink-200 italic font-serif leading-relaxed" id="preview-msg">You are the best!</p>
            <p class="mt-6 text-sm font-bold text-pink-500 dark:text-pink-400" id="preview-from">Love, Your Name</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Live preview interactions
        const toInput = document.getElementById('card-to');
        const msgInput = document.getElementById('card-msg');
        const fromInput = document.getElementById('card-from');
        
        const preTo = document.getElementById('preview-to');
        const preMsg = document.getElementById('preview-msg');
        const preFrom = document.getElementById('preview-from');

        const updatePreview = () => {
            gsap.to([preTo, preMsg, preFrom], { opacity: 0, duration: 0.2, onComplete: () => {
                preTo.innerText = toInput.value ? `Dearest ${toInput.value},` : 'Dearest Mom,';
                preMsg.innerText = msgInput.value || 'You are the best!';
                preFrom.innerText = fromInput.value ? `Love, ${fromInput.value}` : 'Love, Your Name';
                gsap.to([preTo, preMsg, preFrom], { opacity: 1, duration: 0.5 });
            }});
        };

        toInput.addEventListener('input', updatePreview);
        msgInput.addEventListener('input', updatePreview);
        fromInput.addEventListener('input', updatePreview);

        // Falling petals
        document.getElementById('send-flower-btn').addEventListener('click', () => {
            const petalColors = ['#f472b6', '#fb7185', '#fbcfe8', '#fda4af'];
            const numberOfPetals = 30;

            for(let i=0; i<numberOfPetals; i++) {
                const petal = document.createElement('div');
                petal.classList.add('petal');
                petal.style.left = Math.random() * 100 + 'vw';
                petal.style.backgroundColor = petalColors[Math.floor(Math.random() * petalColors.length)];
                
                // Petal shape via clip-path
                petal.style.width = '15px';
                petal.style.height = '30px';
                petal.style.borderRadius = '50% 0 50% 0';
                petal.style.boxShadow = 'inset 0 0 5px rgba(0,0,0,0.1)';

                document.body.appendChild(petal);

                gsap.to(petal, {
                    y: window.innerHeight + 100,
                    x: "+=" + ((Math.random() - 0.5) * 200),
                    rotation: Math.random() * 720,
                    duration: 3 + Math.random() * 3,
                    ease: "sine.inOut",
                    onComplete: () => petal.remove()
                });
            }
        });
    });
</script>
@endsection
