<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomiQ Admin - Sign In</title>
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
            background-color: #0f172a;
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <div class="h-12 w-12 bg-steelAzure rounded-lg flex items-center justify-center font-bold text-2xl text-white shadow-lg mb-3">
                H
            </div>
            <h2 class="text-2xl font-bold text-white tracking-tight">HomiQ Systems</h2>
            <p class="text-xs text-slate-500 mt-1 uppercase font-semibold tracking-widest">Administrative Hub</p>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-8 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6">Sign In</h3>

            @if ($errors->any())
                <div class="mb-5 p-4 bg-rose-950/40 text-rose-300 border border-rose-900/60 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-xs font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="/admin/login" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" id="email" required placeholder="admin@homiq.com" value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-slate-950 border border-slate-800 rounded-lg text-white placeholder-slate-600 focus:outline-none focus:border-steelAzure transition text-sm">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Security Password</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                        class="w-full px-4 py-3 bg-slate-950 border border-slate-200 focus:outline-none focus:border-steelAzure transition text-sm rounded-lg text-white">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-steelAzure hover:bg-steelAzure/90 text-white font-bold rounded-lg shadow-lg transition duration-150 text-sm">
                        Verify Credentials
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-slate-600 mt-8">
            &copy; 2026 HomiQ Inc. Protected area.
        </p>
    </div>

</body>
</html>
