<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'Car Wash Booking') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], } } }
            }
        </script>
    @endif
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Admin Panel
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-600 hidden sm:block">Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header & Filters -->
    <header class="bg-white py-6 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h1 class="text-2xl font-bold text-slate-900 leading-tight">Bookings</h1>
            </div>
        </div>
    </header>

    <!-- Main Table Area -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto border-x-0">
                <table class="w-full text-left text-sm text-slate-600 border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-900 text-xs uppercase font-semibold">
                        <tr>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap">Customer Info</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap">Date & Time</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap">Status</th>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $booking->name }}</div>
                                    <div class="text-slate-500 mt-0.5 text-xs sm:text-sm flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $booking->phone_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium {{ \Carbon\Carbon::parse($booking->booking_date)->isToday() ? 'text-blue-600' : 'text-slate-900' }}">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                        @if(\Carbon\Carbon::parse($booking->booking_date)->isToday())
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-800 ml-2">Today</span>
                                        @endif
                                    </div>
                                    <div class="text-slate-500 mt-0.5 font-mono text-sm bg-slate-100 px-2 py-0.5 rounded inline-block">
                                        {{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-50 text-amber-700 border-amber-200 ring-amber-500/10',
                                            'confirmed' => 'bg-blue-50 text-blue-700 border-blue-200 ring-blue-500/10',
                                            'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-emerald-500/10',
                                            'cancelled' => 'bg-red-50 text-red-700 border-red-200 ring-red-500/10',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$booking->status] }} uppercase tracking-wider">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if(in_array($booking->status, ['pending', 'confirmed']))
                                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button title="Mark Completed" class="p-2 text-emerald-600 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition-colors border border-emerald-100 focus:ring-2 focus:ring-emerald-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button title="Cancel Booking" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors border border-red-100 focus:ring-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to cancel this booking? Slot will become available again.')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400 italic">No actions available</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        No bookings found.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </main>

</body>
</html>
