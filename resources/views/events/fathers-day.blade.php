@extends('layouts.app')
@section('title', 'Happy Father\'s Day')
@section('audio_src', asset('images/fathers.mp3'))

@section('styles')
<style>
    body { background-color: #1e3a8a; } /* blue-900 */
    .bg-vintage {
        background-image: radial-gradient(circle, #3b82f6 0%, #172554 100%);
        box-shadow: inset 0 0 100px rgba(0,0,0,0.5);
    }
    .dad-joke-slide { 
        transform: translateX(-100vw);
    }
    .gift-box-cover {
        transition: transform 1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        transform-origin: bottom;
    }
</style>
@endsection

@section('content')
<div class="absolute inset-0 bg-vintage z-0"></div>

<!-- Floating dad objects -->
<div class="absolute inset-0 overflow-hidden pointer-events-none z-0 opacity-20" id="dad-objects">
    <div class="absolute text-5xl top-20 left-10 animate-bounce delay-100 hover:animate-spin">👔</div>
    <div class="absolute text-5xl top-1/3 right-20 animate-bounce delay-300 hover:rotate-12 hover:scale-110 transition-transform">⌚</div>
    <div class="absolute text-5xl bottom-1/4 left-32 animate-bounce delay-500 hover:-rotate-12 hover:scale-110 transition-transform">🎩</div>
    <div class="absolute text-5xl bottom-10 right-1/3 animate-bounce delay-700 hover:rotate-45 hover:scale-110 transition-transform">🛠️</div>
</div>

<div class="relative z-10 w-full flex flex-col md:flex-row items-center justify-center min-h-screen text-center md:text-left p-6 gap-12 max-w-6xl mx-auto mt-12 md:mt-0">
    
    <!-- Left column: Header & Gift -->
    <div class="flex-1 flex flex-col items-center md:items-start gap-8 z-20">
        <h1 class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-blue-300 to-amber-600 filter drop-shadow-[0_4px_4px_rgba(0,0,0,0.8)]">
            World's<br>Greatest<br>Dad
        </h1>
        
        <p class="text-xl text-blue-200 ml-2 font-light tracking-wide">
            Celebrating the anchor of our lives.
        </p>

        <!-- Send a Gift Button -->
        <div class="mt-4 relative group cursor-pointer" id="gift-btn">
            <div class="relative w-48 h-48 flex items-center justify-center">
                <!-- Gift Box Base -->
                <div class="absolute bottom-0 w-32 h-24 bg-gradient-to-br from-blue-800 to-blue-900 rounded-lg shadow-2xl border-2 border-blue-400/30 flex items-center justify-center overflow-hidden">
                    <span id="gift-msg" class="text-xs text-amber-300 font-bold opacity-0 transition-opacity duration-500 text-center px-2">
                        You're my hero, Dad! 🏆
                    </span>
                </div>
                <!-- Gift Box Cover -->
                <div class="absolute bottom-20 w-36 h-10 bg-gradient-to-b from-amber-600 to-amber-800 rounded-md shadow-lg border-2 border-amber-400 gift-box-cover flex items-center justify-center group-hover:-translate-y-4 shadow-amber-900/50" id="gift-lid">
                    <div class="w-8 h-8 rounded-full border-4 border-amber-300 absolute -top-4 shadow-sm"></div>
                    <span class="text-xs text-amber-100 font-bold">Open Me</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right column: Dad Jokes Timeline -->
    <div class="flex-1 flex flex-col gap-6 w-full max-w-sm" id="timeline">
        <div class="flex items-center justify-between border-b border-amber-700/50 pb-2 mb-2">
            <h3 class="text-2xl font-bold text-amber-500 text-center md:text-left">Classic Dad Jokes</h3>
            <button id="refresh-jokes" class="px-3 py-1 bg-amber-600 hover:bg-amber-500 rounded text-sm text-white font-bold transition flex items-center gap-1 shadow-md">
                <span>🔄</span> Refresh
            </button>
        </div>
        
        <div class="glass p-5 rounded-xl border-l-4 border-amber-500 dad-joke-slide bg-blue-900/60 shadow-xl opacity-0" id="joke1">
            <span class="text-xl" id="icon1">🛠️</span>
            <p class="text-blue-100 mt-2 italic" id="text1">"I told my wife she was drawing her eyebrows too high. She looked surprised."</p>
        </div>

        <div class="glass p-5 rounded-xl border-l-4 border-amber-500 dad-joke-slide bg-blue-900/60 shadow-xl opacity-0" id="joke2">
            <span class="text-xl" id="icon2">🥩</span>
            <p class="text-blue-100 mt-2 italic" id="text2">"Hi Hungry, I'm Dad."</p>
        </div>

        <div class="glass p-5 rounded-xl border-l-4 border-amber-500 dad-joke-slide bg-blue-900/60 shadow-xl opacity-0" id="joke3">
            <span class="text-xl" id="icon3">👞</span>
            <p class="text-blue-100 mt-2 italic" id="text3">"What do you call a fake noodle? An impasta."</p>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // large db of 50 jokes
        const allJokes = [
            { i: "✏️", t: "I told my wife she was drawing her eyebrows too high. She looked surprised." },
            { i: "🥩", t: "Hi Hungry, I'm Dad." },
            { i: "👞", t: "What do you call a fake noodle? An impasta." },
            { i: "🍞", t: "Why do fathers take an extra pair of socks when they go golfing? In case they get a hole in one!" },
            { i: "🧊", t: "Singing in the shower is fun until you get soap in your mouth. Then it's a soap opera." },
            { i: "⏰", t: "What do a tick and the Eiffel Tower have in common? They're both Paris sites." },
            { i: "🌊", t: "What do you call a fish wearing a bowtie? Sofishticated." },
            { i: "🐙", t: "How does a penguin build its house? Igloos it together." },
            { i: "👻", t: "Why did the scarecrow win an award? Because he was outstanding in his field!" },
            { i: "✂️", t: "I'm on a seafood diet. I see food and I eat it." },
            { i: "🧀", t: "What do you call cheese that isn't yours? Nacho cheese." },
            { i: "🥚", t: "Why couldn't the bicycle stand up by itself? It was two tired." },
            { i: "🍎", t: "I ordered a chicken and an egg from Amazon. I'll let you know..." },
            { i: "🧦", t: "What do you call a factory that makes okay products? A satisfactory." },
            { i: "🍬", t: "Did you hear about the guy who invented Life Savers? They say he made a mint." },
            { i: "🦷", t: "What time did the man go to the dentist? Tooth hurt-y." },
            { i: "🔥", t: "I used to play piano by ear, but now I use my hands." },
            { i: "🕳️", t: "Why did the math book look sad? Because of all of its problems!" },
            { i: "🚪", t: "My boss told me to have a good day... so I went home." },
            { i: "🔨", t: "I would avoid the sushi if I was you. It’s a little fishy." },
            { i: "🧱", t: "Want to hear a joke about construction? I'm still working on it." },
            { i: "🌶️", t: "What do you call a nosy pepper? Jalapeño business." },
            { i: "🐎", t: "What do you call a pony with a cough? A little horse." },
            { i: "🎈", t: "I used to hate facial hair, but then it grew on me." },
            { i: "💼", t: "I told my doctor that I broke my arm in two places. He told me to stop going to those places." },
            { i: "🔋", t: "I got a new pair of gloves today, but they're both 'lefts', which on the one hand is great, but on the other, it's just not right." },
            { i: "🎨", t: "I’m afraid for the calendar. Its days are numbered." },
            { i: "🌲", t: "Why do trees seem suspicious on sunny days? Dunno, they're just a bit shady." },
            { i: "🪑", t: "Don't trust atoms. They make up everything!" },
            { i: "💡", t: "Did you hear about the restaurant on the moon? Great food, no atmosphere." },
            { i: "🧹", t: "I asked my dog what's on top of the house. He said, 'Roof!'" },
            { i: "🧲", t: "How do you organize a space party? You planet." },
            { i: "🪞", t: "You know what they say about cliffhangers..." },
            { i: "⏳", t: "What do you call an elephant that doesn't matter? An irrelephant." },
            { i: "🌧️", t: "Why do meteorologists make good friends? Because they are weather companions." },
            { i: "📏", t: "What did the zero say to the eight? That belt looks good on you." },
            { i: "🪙", t: "Why did the invisible man turn down the job offer? He couldn't see himself doing it." },
            { i: "🔑", t: "I'm so good at sleeping I can do it with my eyes closed." },
            { i: "🚲", t: "What do you call two monkeys sharing an Amazon account? Prime mates." },
            { i: "📦", t: "A skeleton walks into a bar and says, 'Hey, bartender. I'll have one beer and a mop.'" },
            { i: "📚", t: "My wife is really mad at the fact that I have no sense of direction. So I packed up my stuff and right!" },
            { i: "🖼️", t: "Can February March? No, but April May." },
            { i: "🧵", t: "Why don't skeletons fight each other? They don't have the guts." },
            { i: "🎵", t: "I'm only familiar with 25 letters in the English language. I don't know why." },
            { i: "🎹", t: "What do you call a man with a rubber toe? Roberto." },
            { i: "🎳", t: "What happens when you go to the bathroom in France? European." },
            { i: "🪓", t: "How many apples grow on a tree? All of them." },
            { i: "🛋️", t: "If you want a job in the moisturizer industry, the best advice I can give is to apply daily." },
            { i: "🚿", t: "Spring is here! I got so excited I wet my plants." },
            { i: "🗝️", t: "What did the left eye say to the right eye? Between us, something smells!" }
        ];

        const shuffleJokes = () => {
             // grab 3 random jokes
             let pool = [...allJokes];
             let picked = [];
             for(let i=0; i<3; i++) {
                 let idx = Math.floor(Math.random() * pool.length);
                 picked.push(pool.splice(idx, 1)[0]);
             }
             
             // animate out
             gsap.to([".dad-joke-slide"], { opacity: 0, x: 20, duration: 0.3, onComplete: () => {
                 // update content
                 document.getElementById('icon1').innerText = picked[0].i;
                 document.getElementById('text1').innerText = picked[0].t;
                 
                 document.getElementById('icon2').innerText = picked[1].i;
                 document.getElementById('text2').innerText = picked[1].t;
                 
                 document.getElementById('icon3').innerText = picked[2].i;
                 document.getElementById('text3').innerText = picked[2].t;
                 
                 // slide back in from the left
                 gsap.fromTo("#joke1", { x: -50, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, delay: 0.1, ease: "back.out(1.5)" });
                 gsap.fromTo("#joke2", { x: -50, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, delay: 0.3, ease: "back.out(1.5)" });
                 gsap.fromTo("#joke3", { x: -50, opacity: 0 }, { x: 0, opacity: 1, duration: 0.8, delay: 0.5, ease: "back.out(1.5)" });
             }});
        };

        // Attach to refresh button
        document.getElementById('refresh-jokes').addEventListener('click', shuffleJokes);

        // Timeline jokes Initial slide in
        gsap.to("#joke1", { x: 0, opacity: 1, duration: 1, delay: 0.5, ease: "back.out(1.5)" });
        gsap.to("#joke2", { x: 0, opacity: 1, duration: 1, delay: 1.5, ease: "back.out(1.5)" });
        gsap.to("#joke3", { x: 0, opacity: 1, duration: 1, delay: 2.5, ease: "back.out(1.5)" });

        // Gift Box logic
        const giftBtn = document.getElementById('gift-btn');
        const giftLid = document.getElementById('gift-lid');
        const giftMsg = document.getElementById('gift-msg');
        let giftOpened = false;

        giftBtn.addEventListener('click', () => {
            if(giftOpened) return;
            giftOpened = true;

            // Slide lid off and rotate
            gsap.to(giftLid, {
                y: -100,
                x: 100,
                rotation: 45,
                opacity: 0,
                duration: 1.5,
                ease: "power2.inOut"
            });

            // Reveal msg
            setTimeout(() => {
                giftMsg.style.opacity = '1';
                gsap.fromTo(giftMsg, 
                    { scale: 0.5, y: 20 }, 
                    { scale: 1.2, y: -20, duration: 2, ease: "elastic.out(1, 0.4)" }
                );
                
                // Pop some confetti tools out
                const icons = ['🔧', '🍺', '👞', '⚾'];
                for(let i=0; i<8; i++) {
                    const icon = document.createElement('div');
                    icon.innerHTML = icons[Math.floor(Math.random() * icons.length)];
                    icon.style.position = 'absolute';
                    icon.style.fontSize = '1.5rem';
                    icon.style.left = '50%';
                    icon.style.top = '50%';
                    giftBtn.appendChild(icon);
                    
                    gsap.to(icon, {
                        x: (Math.random() - 0.5) * 300,
                        y: -150 - Math.random() * 150,
                        rotation: Math.random() * 360,
                        opacity: 0,
                        duration: 1.5,
                        ease: "power2.out",
                        onComplete: () => icon.remove()
                    });
                }
            }, 500);
        });
    });
</script>
@endsection
