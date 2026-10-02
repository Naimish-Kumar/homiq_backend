<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Admin Authentication</title>
    <link rel="icon" type="image/png" href="/logo.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNavy: '#0A2540',
                        brandNavyDeep: '#061826',
                        brandNavySurface: '#0F2942',
                        brandEmerald: '#10B981',
                        brandEmeraldDark: '#059669',
                        brandEmeraldLight: '#34D399',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Outfit', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            background: radial-gradient(circle at top right, #0F2942 0%, #0A2540 50%, #061826 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-slate-100 selection:bg-emerald-500 selection:text-white relative overflow-hidden">

    <!-- Ambient background glow elements -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        
        <!-- Brand Header & Logo -->
        <div class="flex flex-col items-center mb-8 text-center">
            <div class="h-16 w-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 p-0.5 shadow-2xl shadow-emerald-500/20 mb-4">
                <div class="w-full h-full bg-[#0A2540] rounded-[14px] flex items-center justify-center">
                    <img src="/logo.png" alt="HomiQ Logo" class="h-10 w-auto object-contain">
                </div>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Homi<span class="text-emerald-400">Q</span> Admin</h1>
            <p class="text-xs text-slate-400 mt-1 font-medium">Verified Administrative Control Center</p>
        </div>

        <!-- Login Form Glass Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-white">Sign In to Dashboard</h2>
                <p class="text-xs text-slate-400 mt-0.5">Please enter your authorized administrator credentials.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-500/10 text-rose-300 border border-rose-500/20 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-semibold flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span> {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form action="/admin/login" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" id="email" required placeholder="admin@homiq.com" value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition text-sm">
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/25 transition duration-200 text-sm flex items-center justify-center gap-2">
                        <span>Access Admin Console</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-[11px] text-slate-500 mt-6">
            &copy; 2026 HomiQ Inc. Protected area.
        </p>
    </div>

</body>
</html>
