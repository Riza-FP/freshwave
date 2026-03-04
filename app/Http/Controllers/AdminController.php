<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $bookings = Booking::orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->paginate(15);

        return view('admin.dashboard', compact('bookings'));
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
