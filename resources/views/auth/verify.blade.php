<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ - Verify Email</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <a href="/" class="flex items-center gap-3 mb-3">
                <img src="/logo.png" alt="HomiQ Logo" class="h-12 w-12 object-contain filter drop-shadow-[0_4px_6px_rgba(26,68,124,0.3)]">
            </a>
            <h2 class="text-3xl font-extrabold text-white tracking-tight">HomiQ</h2>
            <p class="text-sm text-slate-400 mt-1">Rent Spaces, List Properties Seamlessly</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800 rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-white mb-2">Verify Your Email</h3>
            <p class="text-xs text-slate-400 mb-6">We've sent a 6-digit OTP code to <span class="text-slate-200 font-semibold">{{ Auth::user()->email }}</span>. Enter it below to unlock your dashboard.</p>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-950/40 text-rose-300 border border-rose-900/60 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="mb-5 p-4 bg-emerald-950/40 text-emerald-300 border border-emerald-900/60 rounded-2xl text-xs font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="/verify-email" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="otp" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">6-Digit Verification Code</label>
                    <input type="text" name="otp" id="otp" required placeholder="000000" maxlength="6" pattern="[0-9]{6}" autocomplete="off"
                        class="w-full px-4 py-3.5 bg-slate-950/80 border border-slate-800 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:border-steelAzure transition text-center text-lg font-bold tracking-widest">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-steelAzure hover:bg-steelAzure/90 text-white font-bold rounded-xl shadow-lg shadow-steelAzure/20 transition duration-150 text-sm">
                        Verify Email Address
                    </button>
                </div>
            </form>

            <div class="mt-6 flex justify-between items-center text-xs">
                <form action="/verify-email/resend" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="text-seaGreen hover:underline font-semibold">Resend OTP Code</button>
                </form>

                <form action="/logout" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to sign out?');">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:underline">Log Out</button>
                </form>
            </div>
        </div>

        <p class="text-center text-xs text-slate-600 mt-8">
            &copy; 2026 HomiQ Inc. Verify portal.
        </p>
    </div>

</body>
</html>
