<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed - {{ config('app.name', 'Car Wash Booking') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS (via Vite) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback CDN for development if Vite isn't running -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            brandDark: '#122659',
                            brandAccent: '#6df5b4',
                            brandAccentHover: '#5ce09f',
                        }
                    }
                }
            }
        </script>
    @endif
</head>

<body
    class="bg-[#122659] min-h-screen flex items-center justify-center p-6 text-white antialiased relative selection:bg-brandAccent selection:text-brandDark">

    <!-- Background Decor -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div
            class="absolute top-[40%] left-[50%] -translate-x-1/2 -translate-y-1/2 w-[80%] max-w-3xl h-[60%] rounded-full bg-brandAccent/10 blur-[120px]">
        </div>
    </div>

    <!-- Success Card -->
    <div
        class="relative z-10 w-full max-w-md bg-white/[0.03] backdrop-blur-[20px] rounded-3xl p-8 sm:p-10 text-center shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] border border-white/[0.08]">

        <!-- Animated Success Icon -->
        <div
            class="mx-auto w-20 h-20 bg-brandAccent/20 text-brandAccent rounded-full flex items-center justify-center mb-6 shadow-inner border border-brandAccent/30">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-white mb-3 tracking-tight">Booking Confirmed!</h1>
        <p class="text-slate-300 mb-8 leading-relaxed text-sm sm:text-base font-medium">
            Your time slot has been successfully reserved. We look forward to seeing you and making your car shine!
        </p>

        @if(isset($booking))
            <!-- Booking Details Card -->
            <div
                class="bg-white/5 rounded-2xl p-6 mb-8 text-left border border-white/10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-brandAccent"></div>

                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Reservation Details</h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                        <span class="text-sm font-medium text-slate-400">Name</span>
                        <span class="text-sm font-bold text-white">{{ $booking->name }}</span>
                    </div>

                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                        <span class="text-sm font-medium text-slate-400">Phone</span>
                        <span class="text-sm font-bold text-white">{{ $booking->phone_number }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-white/10">
                        <span class="text-sm font-medium text-slate-400">Date</span>
                        <span
                            class="text-sm font-bold text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, M jS, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-400">Time</span>
                        <span
                            class="text-sm font-bold text-brandDark bg-brandAccent px-3 py-1 rounded-full">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <a href="{{ route('home') }}"
            class="inline-flex w-full justify-center items-center gap-2 py-4 rounded-xl bg-brandAccent hover:bg-brandAccentHover text-[#122659] font-bold text-base shadow-[0_0_20px_rgba(109,245,180,0.2)] hover:shadow-[0_0_25px_rgba(109,245,180,0.4)] transition-all focus:outline-none uppercase tracking-wide">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Return to Homepage
        </a>
    </div>

</body>

</html>