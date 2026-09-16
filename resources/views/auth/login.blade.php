<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Sign In</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNavy: '#0A2540',
                        brandEmerald: '#10B981',
                        steelAzure: '#0A2540',
                        seaGreen: '#10B981',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-white flex flex-col md:flex-row antialiased">

    <!-- Left Side: Theme Image (Split screen) -->
    <div class="hidden md:flex md:w-1/2 relative bg-slate-950 items-center justify-center p-12 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=1600&q=80" alt="Luxury Architecture" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-900/40"></div>
        
        <div class="relative z-10 text-white flex flex-col items-center text-center max-w-md">
            <a href="/" class="inline-block mb-8 p-3 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 hover:bg-white/20 transition-all shadow-xl">
                <img src="/logo.png" alt="HomiQ Logo" class="h-14 w-auto object-contain">
            </a>
            
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider mb-4 border border-emerald-500/30">
                <span class="material-symbols-outlined text-[15px]">verified</span>
                Verified Marketplace
            </span>

            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Elevate Your<br>Property Journey.</h1>
            <p class="text-slate-300 text-sm leading-relaxed mb-8">Access your personalized dashboard, manage your properties, and connect directly with verified owners with zero brokerage fees.</p>

            <div class="w-full bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 flex items-center gap-4 text-left">
                <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-white text-[20px]">shield_person</span>
                </div>
                <div>
                    <p class="text-white text-sm font-bold leading-tight">100% On-Site Audited</p>
                    <p class="text-slate-300 text-xs mt-0.5">Government ID &amp; title deeds verified</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-16 min-h-screen">
        <div class="w-full max-w-md">
            <!-- Mobile Brand Header (visible on mobile only) -->
            <div class="flex flex-col items-center mb-8 md:hidden">
                <a href="/" class="flex items-center gap-3 mb-2 p-2 rounded-2xl bg-slate-50 border border-slate-200 shadow-sm">
                    <img src="/logo.png" alt="HomiQ Logo" class="h-10 w-auto object-contain">
                </a>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome Back</h2>
                <p class="text-sm font-medium text-slate-500">Enter your credentials to access your account.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 text-rose-800 border border-rose-100 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-semibold flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-rose-600">error</span>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-2xl text-xs font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px] text-emerald-600">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email Address</label>
                    <input type="email" name="email" id="email" required placeholder="name@company.com" value="{{ old('email') }}"
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brandNavy focus:bg-white focus:ring-2 focus:ring-brandNavy/10 transition text-sm">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-brandNavy hover:text-emerald-600 font-bold transition">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-brandNavy focus:bg-white focus:ring-2 focus:ring-brandNavy/10 transition text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-brandNavy hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-brandNavy/15 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 text-sm flex justify-center items-center gap-2">
                        <span>Sign In to Dashboard</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </form>

            <!-- Social Login -->
            <div class="relative flex py-6 items-center">
                <div class="flex-grow border-t border-slate-200"></div>
                <span class="flex-shrink mx-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">or continue with</span>
                <div class="flex-grow border-t border-slate-200"></div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <button type="button" onclick="handleGoogleLogin()" class="flex justify-center items-center py-3.5 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition-all shadow-xs font-bold text-slate-700 text-sm gap-3">
                    <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114A5.99 5.99 0 018 12.5a5.99 5.99 0 015.99-6.015c1.49 0 2.843.551 3.882 1.455l3.226-3.226C19.167 2.87 16.782 2 13.99 2A10.5 10.5 0 003.5 12.5a10.5 10.5 0 0010.49 10.5c5.78 0 10.51-4.18 10.51-10.5 0-.705-.083-1.39-.236-2.045H12.24z"/></svg>
                    <span>Sign in with Google</span>
                </button>
            </div>

            <div class="mt-8 text-center text-xs text-slate-500 font-medium">
                Don't have an account? 
                <a href="/register" class="text-brandNavy hover:text-emerald-600 font-bold ml-1 transition underline decoration-brandNavy/30 hover:decoration-emerald-600">Create an Account</a>
            </div>
        </div>
    </div>

    <!-- Firebase Google Auth Script -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
        import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
        
        const firebaseConfig = {
            apiKey: "AIzaSyAnqwXHefxx3v7-dsxfLnzYXnTGU6sRg_M",
            authDomain: "homiq2025.firebaseapp.com",
            projectId: "homiq2025",
            storageBucket: "homiq2025.firebasestorage.app",
            messagingSenderId: "243121732675",
            appId: "1:243121732675:web:66709cb651bbe9af0268f6",
            measurementId: "G-DG38QCFMZV"
        };
        
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();
        
        window.handleGoogleLogin = async function() {
            try {
                const result = await signInWithPopup(auth, provider);
                const user = result.user;
                
                const response = await fetch('/auth/firebase-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: user.displayName,
                        email: user.email,
                        photo: user.photoURL,
                        uid: user.uid
                    })
                });
        
                const data = await response.json();
                if (data.success) {
                    window.location.href = data.redirect || (data.is_admin ? '/admin' : '/dashboard');
                }
            } catch (error) {
                console.error("Error signing in with Google", error);
            }
        }
    </script>
</body>
</html>
