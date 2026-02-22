<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HappyDay - Choose Your Occasion')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
        .dark .glass { background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255,255,255,0.1); }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-500 overflow-x-hidden min-h-screen flex flex-col">
    
    <!-- Navbar / Controls -->
    <nav class="fixed top-0 w-full z-50 p-4 flex justify-between items-center mix-blend-difference text-white">
        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wider hover:scale-105 transition-transform">
            HappyDay
        </a>
        <div class="flex gap-4">
            <button id="bgm-toggle" class="p-2 rounded-full glass hover:bg-white/20 transition cursor-pointer" title="Mute/Unmute">🔊</button>
            <button id="theme-toggle" class="p-2 rounded-full glass hover:bg-white/20 transition cursor-pointer">🌓</button>
        </div>
    </nav>
    <audio id="bgm-audio" loop autoplay src=""></audio>

    <main class="flex-grow flex relative w-full h-full">
        @yield('content')
    </main>

    <div class="fixed bottom-4 right-4 z-50 flex gap-3 flex-col sm:flex-row id='share-buttons'">
        <button onclick="shareAction('twitter')" class="p-3 rounded-full glass hover:bg-[#1DA1F2]/80 hover:scale-110 hover:-translate-y-1 hover:shadow-lg transition-all shadow-[#1DA1F2]/50 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.054 10.054 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
        </button>
        <button onclick="shareAction('facebook')" class="p-3 rounded-full glass hover:bg-[#1877F2]/80 hover:scale-110 hover:-translate-y-1 hover:shadow-lg transition-all shadow-[#1877F2]/50 text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </button>
        <button onclick="shareAction('copy')" class="p-3 rounded-full glass hover:bg-emerald-500/80 hover:scale-110 hover:-translate-y-1 hover:shadow-lg transition-all shadow-emerald-500/50 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        </button>
    </div>

    <script>
        const shareAction = (type) => {
            const url = window.location.href;
            const text = "Check out this beautiful card from HappyDay! 🌟 %0A";
            if(type === 'twitter') {
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            } else if(type === 'facebook') {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
            } else if(type === 'copy') {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Link copied to clipboard!');
                });
            }
        };

        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });

        const bgmAudio = document.getElementById('bgm-audio');
        const bgmToggle = document.getElementById('bgm-toggle');
        
        @if(View::hasSection('audio_src'))
            bgmAudio.src = "@yield('audio_src')";
            bgmAudio.volume = 0.5; // Set smooth default volume
            
            // Try explicit immediate play request safely
            const playAudio = () => {
                if (!bgmAudio.paused) return; // Prevent overlapping play calls
                bgmAudio.play().then(() => {
                    bgmToggle.innerText = '🔊';
                    // clean up active global triggers once successful
                    document.body.removeEventListener('click', playAudio);
                    document.body.removeEventListener('keydown', playAudio);
                    document.body.removeEventListener('touchstart', playAudio);
                }).catch(e => {
                    // Browser blocked explicit autoplay; await first user interaction silently
                });
            };

            // Aggressive but safe triggers that are trusted by browsers (removed mousemove limits)
            document.body.addEventListener('click', playAudio);
            document.body.addEventListener('keydown', playAudio);
            document.body.addEventListener('touchstart', playAudio);

            // Initial auto-attempt
            playAudio();
            
        @else
            bgmToggle.style.display = 'none';
        @endif
        
        // Manual mute / unmute toggle logic explicitly clicked by user
        bgmToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            if (bgmAudio.muted || bgmAudio.paused) {
                bgmAudio.muted = false;
                bgmAudio.play();
                bgmToggle.innerText = '🔊';
                bgmToggle.setAttribute('title', 'Mute Music');
            } else {
                bgmAudio.muted = true;
                bgmToggle.innerText = '🔇';
                bgmToggle.setAttribute('title', 'Unmute Music');
            }
        });

        // Entrance animation
        gsap.from("nav", { y: -50, opacity: 0, duration: 1, ease: "power3.out" });
    </script>
    @yield('scripts')
</body>
</html>
