<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get dates for the last 7 days
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        // Aggregate bookings per day for the last 7 days
        $bookingCounts = Booking::whereIn('booking_date', $dates)
            ->selectRaw('booking_date, count(*) as count')
            ->groupBy('booking_date')
            ->pluck('count', 'booking_date');

        // Prepare chart data
        $chartLabels = $dates->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();

        $chartData = $dates->map(function ($date) use ($bookingCounts) {
            return $bookingCounts[$date] ?? 0;
        })->toArray();

        $bookings = Booking::orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->paginate(15);

        $showCreateModal = $request->has('create');

        $editBooking = null;
        if ($request->has('edit')) {
            $editBooking = Booking::find($request->query('edit'));
        }

        $deleteBooking = null;
        if ($request->has('delete')) {
            $deleteBooking = Booking::find($request->query('delete'));
        }

        return view('admin.dashboard', compact(
            'bookings',
            'chartLabels',
            'chartData',
            'showCreateModal',
            'editBooking',
            'deleteBooking'
        ));
    }

    public function create()
    {
        return view('admin.bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i:s',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        Booking::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i:s',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Booking deleted permanently.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Booking status updated successfully.');
    }
}
