<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Define operational hours (e.g., 8:00 AM to 5:00 PM)
    private $operationalHours = [
        '08:00:00',
        '09:00:00',
        '10:00:00',
        '11:00:00',
        '12:00:00',
        '13:00:00',
        '14:00:00',
        '15:00:00',
        '16:00:00',
        '17:00:00'
    ];

    public function index()
    {
        return view('welcome');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = $request->date;

        // Get all booked time slots for the selected date
        // Only get slots that are 'pending' or 'confirmed'
        // Cancelled slots are available again
        $bookedSlots = Booking::where('booking_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_time')
            ->toArray();

        // If checking today's date, remove slots that have already passed
        $availableSlots = $this->operationalHours;

        if (Carbon::parse($date)->isToday()) {
            $currentTime = Carbon::now()->format('H:i:s');
            $availableSlots = array_filter($availableSlots, function ($slot) use ($currentTime) {
                return $slot > $currentTime;
            });
        }

        // Remove booked slots
        $availableSlots = array_values(array_diff($availableSlots, $bookedSlots));

        return response()->json([
            'available_slots' => $availableSlots
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|date_format:H:i:s',
        ]);

        // Double check no one booked it while they were filling the form
        $isBooked = Booking::where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        // Also check if the time is valid operational hour
        if (!in_array($request->booking_time, $this->operationalHours)) {
            return back()->with('error', 'Invalid time slot selected.')->withInput();
        }

        if ($isBooked) {
            return back()->with('error', 'Sorry, this time slot has just been booked. Please choose another one.')->withInput();
        }

        $booking = Booking::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.success')->with('booking_id', $booking->id);
    }

    public function success()
    {
        $bookingId = session('booking_id');

        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = Booking::findOrFail($bookingId);

        return view('booking-success', compact('booking'));
    }
}
