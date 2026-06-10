<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Sign In</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;850&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        steelAzure: '#1A447C',
                        seaGreen: '#328B60',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-white flex flex-col md:flex-row">

    <!-- Left Side: Theme Image (Split screen) -->
    <div class="hidden md:flex md:w-1/2 relative bg-slate-900 items-center justify-center p-12">
        <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80" alt="Modern Room Layout" class="absolute inset-0 w-full h-full object-cover opacity-75">
        <div class="absolute inset-0 bg-slate-950/40"></div>
        <div class="relative z-10 text-white text-center flex flex-col items-center max-w-md">
            <a href="/" class="inline-block mb-6">
                <img src="/logo.png" alt="HomiQ Logo" class="h-20 w-auto object-contain">
            </a>
            <h1 class="text-4xl font-extrabold tracking-tight mb-4 leading-tight">Join Our Space Network.</h1>
            <p class="text-slate-200 text-sm leading-relaxed">Create an account to securely list properties, check limits, and lease verified rooms.</p>
        </div>
    </div>

    <!-- Right Side: Simple Login Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-8 md:p-16">
        <div class="w-full max-w-md">
            <!-- Mobile Brand Header (only visible on mobile) -->
            <div class="flex flex-col items-center mb-8 md:hidden">
                <a href="/" class="flex items-center gap-3 mb-2">
                    <img src="/logo.png" alt="HomiQ Logo" class="h-12 w-auto object-contain">
                </a>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">HomiQ</h2>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Welcome Back</h2>
                <p class="text-sm text-slate-400">Sign in to manage listings, subscriptions, and book spaces.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 text-rose-800 border border-rose-100 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 border border-emerald-100 rounded-2xl text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" id="email" required placeholder="name@domain.com" value="{{ old('email') }}"
                        class="w-full px-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-steelAzure focus:bg-white transition text-sm">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-steelAzure hover:underline font-semibold">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3.5 bg-slate-50/50 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-steelAzure focus:bg-white transition text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-steelAzure hover:bg-steelAzure/90 text-white font-bold rounded-xl shadow-lg shadow-steelAzure/10 transition-all duration-150 text-sm">
                        Verify Credentials
                    </button>
                </div>
            </form>

            <!-- Social Logins -->
            <div class="relative flex py-6 items-center">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink mx-4 text-[10px] font-bold text-slate-400 uppercase tracking-wider">or sign in with</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <div class="grid grid-cols-1 gap-3">
                <button type="button" onclick="alert('Google Social Sign-In option configured')" class="flex justify-center items-center py-3 bg-slate-50 hover:bg-slate-100/80 border border-slate-100 rounded-xl transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24"><path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114A5.99 5.99 0 018 12.5a5.99 5.99 0 015.99-6.015c1.49 0 2.843.551 3.882 1.455l3.226-3.226C19.167 2.87 16.782 2 13.99 2A10.5 10.5 0 003.5 12.5a10.5 10.5 0 0010.49 10.5c5.78 0 10.51-4.18 10.51-10.5 0-.705-.083-1.39-.236-2.045H12.24z"/></svg>
                </button>
            </div>

            <div class="mt-6 text-center text-xs text-slate-500">
                Don't have an account? 
                <a href="/register" class="text-seaGreen hover:underline font-semibold ml-1">Create an Account</a>
            </div>
        </div>
    </div>

</body>
</html>
