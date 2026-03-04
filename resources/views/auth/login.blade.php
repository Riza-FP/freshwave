<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name', 'Car Wash Booking') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } } } }
        </script>
    @endif
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 text-slate-800 antialiased">

    <!-- Background Decor -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-[10%] -right-[5%] w-[40%] h-[40%] rounded-full bg-blue-400/20 blur-[100px]"></div>
    </div>

    <!-- Login Card -->
    <div
        class="relative z-10 w-full max-w-sm bg-white/95 backdrop-blur-xl rounded-3xl p-8 lg:p-10 shadow-2xl shadow-slate-200/50 border border-slate-100">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900 flex items-center justify-center gap-2 mb-2">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
                Admin Login
            </h1>
            <p class="text-sm text-slate-500">Sign in to manage bookings</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-sm">
            </div>

            <button type="submit"
                class="w-full py-3.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold shadow-lg shadow-slate-900/20 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 mt-4">
                Sign In
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}"
                class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Homepage
            </a>
        </div>
    </div>

</body>

</html>