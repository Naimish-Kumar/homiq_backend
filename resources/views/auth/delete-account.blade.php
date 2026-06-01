<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Delete Account</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;850;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        steelAzure: '#1A447C',
                        seaGreen: '#328B60',
                        warningRed: '#EF4444',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-900 flex items-center justify-center p-4 md:p-8 relative overflow-hidden">
    <!-- Abstract background glow elements -->
    <div class="absolute top-0 -left-4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-pulse delay-75"></div>

    <div class="w-full max-w-lg bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-8 md:p-12 shadow-2xl relative z-10">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <a href="/" class="mb-4 transition transform hover:scale-105">
                <img src="/logo.png" alt="HomiQ Logo" class="h-16 w-auto object-contain">
            </a>
            <h2 class="text-xs font-black text-steelAzure tracking-widest uppercase mb-1">Account Control</h2>
            <h1 class="text-2xl font-black text-white text-center leading-tight">Delete Account Request</h1>
            <p class="text-xs text-slate-400 text-center mt-2 max-w-sm">This action will delete all your listed properties, active contracts, account details, and cannot be undone.</p>
        </div>

        @if (session('success'))
            <!-- Success Message Card -->
            <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-6 text-center animate-fade-in">
                <div class="h-12 w-12 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Request Processed</h3>
                <p class="text-sm text-emerald-300/90 mb-6">{{ session('success') }}</p>
                <a href="/" class="inline-block px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-md">
                    Return to Homepage
                </a>
            </div>
        @else
            <!-- Error messages list -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-500/15 text-rose-300 border border-rose-500/30 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Form -->
            <form action="/delete-account" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Registered Email</label>
                    <input type="email" name="email" id="email" required placeholder="your.name@example.com" value="{{ old('email') }}"
                        class="w-full px-4 py-3.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-warningRed focus:bg-slate-900 transition text-sm">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Confirm Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-warningRed focus:bg-slate-900 transition text-sm">
                </div>

                <div class="pt-2 flex flex-col gap-3">
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to permanently delete your HomiQ account? This action is irreversible.');"
                            class="w-full py-4 bg-warningRed hover:bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-warningRed/10 transition-all duration-150 text-sm">
                        Permanently Delete Account
                    </button>
                    <a href="/" class="w-full py-4 bg-slate-700 hover:bg-slate-650 text-slate-200 font-bold rounded-xl text-center transition text-sm">
                        Cancel & Go Back
                    </a>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
