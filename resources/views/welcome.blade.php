<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Car Wash Booking') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

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
                            brandDark: '#122659', /* Adjusted to a nice rich dark blue from reference */
                            brandAccent: '#6df5b4', /* Mint Green from reference */
                            brandAccentHover: '#5ce09f',
                        },
                        keyframes: {
                            wave: {
                                '0%': { transform: 'translate3d(-90px, 0, 0)' },
                                '100%': { transform: 'translate3d(85px, 0, 0)' },
                            }
                        }
                    }
                }
            }
        </script>
    @endif

</head>

<body
    class="min-h-screen antialiased selection:bg-brandAccent selection:text-brandDark relative overflow-x-hidden font-sans bg-[#122659] text-white [&_::-webkit-calendar-picker-indicator]:invert [&_::-webkit-calendar-picker-indicator]:opacity-70 [&_::-webkit-calendar-picker-indicator]:hover:opacity-100 [&_::-webkit-calendar-picker-indicator]:cursor-pointer">

    <!-- Big Background Text (CARWASH) -->
    <div class="absolute text-[22vw] font-extrabold text-transparent whitespace-nowrap top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-0 pointer-events-none select-none"
        style="-webkit-text-stroke: 1.5px rgba(255, 255, 255, 0.04);">CARWASH</div>

    <div class="relative z-10 bg-brandDark/40 min-h-screen border-t-[8px] border-brandDark">
        <!-- Navigation -->
        <nav class="container mx-auto px-6 py-6 lg:py-8 flex justify-between items-center relative z-20">
            <!-- Logo -->
            <div class="text-2xl font-bold tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border-2 border-brandAccent flex items-center justify-center">
                    <svg class="w-5 h-5 text-brandAccent" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2" />
                        <circle cx="7" cy="17" r="2" />
                        <path d="M9 17h6" />
                        <circle cx="17" cy="17" r="2" />
                    </svg>
                </div>
                <div class="leading-none flex flex-col items-start gap-0.5">
                    <span class="block text-[13px] font-bold text-white leading-none">FRESHWAVE</span>
                </div>
            </div>

            <!-- Admin Login Link -->
            <div class="flex items-center text-[13px] font-bold tracking-wide text-white uppercase">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/admin/dashboard') }}"
                            class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all backdrop-blur-sm border border-white/10">Admin
                            Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all backdrop-blur-sm border border-white/10">Admin
                            Login</a>
                    @endauth
                @endif
            </div>
        </nav>



        <!-- Main Content -->
        <main
            class="container mx-auto px-6 pt-6 pb-20 lg:pt-14 flex flex-col lg:flex-row gap-16 lg:gap-8 items-center justify-between relative z-20">

            <!-- Left Side: Copy & Info -->
            <div class="w-full lg:w-6/12 relative z-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-0.5 bg-brandAccent"></div>
                    <span class="text-brandAccent text-[12px] font-bold tracking-widest uppercase">FRESHWAVE</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-bold leading-[1.1] mb-6 text-white tracking-tight">
                    We help keep <br>
                    your car clean <br>
                </h1>

                <p class="text-lg text-slate-300 mb-10 leading-relaxed max-w-lg font-medium">
                    Skip the line. Book your spot in seconds and bring your car in at the exact time. We guarantee a
                    spot waiting just for you.
                </p>

            </div>

            <!-- Right Side: Booking Form -->
            <div class="w-full lg:w-5/12 max-w-lg relative z-20">

                @if(session('error'))
                    <div
                        class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/50 text-red-100 flex items-start gap-3 backdrop-blur-md">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <div
                    class="bg-white/[0.03] backdrop-blur-[20px] border border-white/[0.08] shadow-[0_25px_50px_-12px_rgba(0,0,0,0.3)] rounded-[32px] p-8 lg:p-10 relative overflow-hidden">
                    <!-- Subtle glow inside the card -->
                    <div
                        class="absolute -top-32 -right-32 w-64 h-64 bg-brandAccent/10 rounded-full blur-[60px] pointer-events-none">
                    </div>

                    <h2 class="text-[22px] font-bold mb-8 text-white relative z-10 flex items-center gap-3">
                        <svg class="w-6 h-6 text-brandAccent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Book your appointment
                    </h2>

                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" class="relative z-10">
                        @csrf

                        <!-- Step 1: Date -->
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wide">Select
                                Date</label>
                            <input type="date" id="booking_date" name="booking_date" required min="{{ date('Y-m-d') }}"
                                value="{{ old('booking_date', date('Y-m-d')) }}"
                                class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/10 text-white font-medium focus:outline-none focus:ring-1 focus:ring-brandAccent focus:border-brandAccent transition-all shadow-inner">
                            @error('booking_date') <span
                            class="text-xs text-red-400 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Step 2: Time Slots -->
                        <div class="mb-7 relative" id="time-container">
                            <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wide">Available
                                Times</label>

                            <!-- Loading State -->
                            <div id="time-loading"
                                class="absolute inset-x-0 bottom-0 top-6 bg-brandDark/60 backdrop-blur-md z-10 flex items-center justify-center rounded-xl hidden">
                                <div
                                    class="w-7 h-7 border-[3px] border-brandAccent/30 border-t-brandAccent rounded-full animate-spin">
                                </div>
                            </div>

                            <div id="slots-grid" class="grid grid-cols-3 gap-3">
                                <!-- Slots will be injected here via JS -->
                            </div>
                            <input type="hidden" name="booking_time" id="booking_time" value="{{ old('booking_time') }}"
                                required>
                            @error('booking_time') <span
                            class="text-xs text-red-400 mt-1.5 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Step 3: Details -->
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wide">Your
                                Details</label>
                            <div class="space-y-3">
                                <div>
                                    <input type="text" name="name" placeholder="Full Name" required
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/10 text-white font-medium placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brandAccent focus:border-brandAccent transition-all shadow-inner">
                                    @error('name') <span
                                        class="text-xs text-red-400 mt-1.5 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="tel" name="phone_number" placeholder="WhatsApp / Phone Number" required
                                        value="{{ old('phone_number') }}"
                                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/10 text-white font-medium placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-brandAccent focus:border-brandAccent transition-all shadow-inner">
                                    @error('phone_number') <span
                                        class="text-xs text-red-400 mt-1.5 block font-medium">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" disabled
                            class="w-full py-4 rounded-xl bg-brandAccent hover:bg-brandAccentHover text-[#122659] font-bold text-base shadow-[0_0_20px_rgba(109,245,180,0.2)] hover:shadow-[0_0_25px_rgba(109,245,180,0.4)] transition-all focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none uppercase tracking-wide">
                            Submit Booking
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- Ocean Waves Background -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-0 pointer-events-none opacity-40">
        <svg class="relative block w-[calc(100%+1.3px)] h-[15vh] min-h-[100px] max-h-[150px]"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="waves">
                <use href="#gentle-wave" x="48" y="0" fill="rgba(109, 245, 180, 0.7)"
                    class="animate-[wave_7s_cubic-bezier(.55,.5,.45,.5)_infinite] [-webkit-animation-delay:-2s] [animation-delay:-2s]" />
                <use href="#gentle-wave" x="48" y="3" fill="rgba(109, 245, 180, 0.5)"
                    class="animate-[wave_10s_cubic-bezier(.55,.5,.45,.5)_infinite] [-webkit-animation-delay:-3s] [animation-delay:-3s]" />
                <use href="#gentle-wave" x="48" y="5" fill="rgba(109, 245, 180, 0.3)"
                    class="animate-[wave_13s_cubic-bezier(.55,.5,.45,.5)_infinite] [-webkit-animation-delay:-4s] [animation-delay:-4s]" />
                <use href="#gentle-wave" x="48" y="7" fill="#6df5b4"
                    class="animate-[wave_20s_cubic-bezier(.55,.5,.45,.5)_infinite] [-webkit-animation-delay:-5s] [animation-delay:-5s]" />
            </g>
        </svg>
    </div>

    <!-- Script to handle dynamic slots fetching -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('booking_date');
            const slotsGrid = document.getElementById('slots-grid');
            const timeInput = document.getElementById('booking_time');
            const submitBtn = document.getElementById('submitBtn');
            const loadingOverlay = document.getElementById('time-loading');

            // Format time helper (e.g. 08:00:00 -> 08:00 AM)
            function formatTime(timeString) {
                const [hour, minute] = timeString.split(':');
                const h = parseInt(hour);
                const ampm = h >= 12 ? 'pm' : 'am';
                const formattedHour = h % 12 || 12;
                return `${formattedHour}:${minute} ${ampm}`;
            }

            function fetchSlots(date) {
                loadingOverlay.classList.remove('hidden');

                fetch(`/api/available-slots?date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        slotsGrid.innerHTML = '';
                        timeInput.value = ''; // Reset selected time
                        submitBtn.disabled = true;

                        if (data.available_slots && data.available_slots.length > 0) {
                            data.available_slots.forEach(slot => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className = 'time-slot py-2.5 px-2 text-center text-[13px] rounded-xl cursor-pointer focus:outline-none shadow-sm transition-all duration-200 ease-in-out bg-white/5 text-slate-300 border border-white/10 hover:border-brandAccent hover:text-white [&.selected]:bg-brandAccent [&.selected]:text-brandDark [&.selected]:border-brandAccent [&.selected]:font-semibold';
                                btn.innerHTML = formatTime(slot);
                                btn.dataset.time = slot;

                                // Re-select if previously selected
                                if ("{{ old('booking_time') }}" === slot) {
                                    btn.classList.add('selected');
                                    timeInput.value = slot;
                                    submitBtn.disabled = false;
                                }

                                btn.addEventListener('click', function () {
                                    // Remove selected class from all
                                    document.querySelectorAll('.time-slot').forEach(b => {
                                        b.classList.remove('selected');
                                    });

                                    // Add to clicked
                                    this.classList.add('selected');

                                    // Set hidden input
                                    timeInput.value = this.dataset.time;

                                    // Enable submit
                                    submitBtn.disabled = false;
                                });

                                slotsGrid.appendChild(btn);
                            });
                        } else {
                            slotsGrid.innerHTML = '<div class="col-span-full py-6 text-center text-slate-400 text-sm bg-white/5 rounded-xl border border-white/10 font-medium">No slots available for this date.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching slots:', error);
                        slotsGrid.innerHTML = '<div class="col-span-full py-4 text-center text-red-400 text-sm font-medium">Failed to load time slots. Please try again.</div>';
                    })
                    .finally(() => {
                        loadingOverlay.classList.add('hidden');
                    });
            }

            // Initial load
            if (dateInput.value) {
                fetchSlots(dateInput.value);
            }

            // On Date change
            dateInput.addEventListener('change', function () {
                if (this.value) {
                    fetchSlots(this.value);
                }
            });
        });
    </script>
</body>

</html>