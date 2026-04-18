<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use App\Models\ConferenceHall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusUpdated;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room', 'conferenceHall'])
            ->where('status', '!=', 'payment_pending');

        // Filtering
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(15);

        // Mark all unread bookings as checked when viewing the list
        Booking::where('is_checked', false)->update(['is_checked' => true]);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking (Offline/Walk-in).
     */
    public function create()
    {
        $rooms = Room::all();
        $halls = ConferenceHall::all();
        $users = User::where('role', 'user')->latest()->get();
        $restaurants = \App\Models\Restaurant::where('is_active', true)->get();

        return view('admin.bookings.create', compact('rooms', 'halls', 'users', 'restaurants'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_type' => 'required|in:room,conference,restaurant',
            'user_id' => 'nullable|exists:users,id',
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_email' => 'required_without:user_id|email',
            'guest_phone' => 'nullable|string|max:20',
            // Room/Conference Dates
            'check_in' => 'required_if:booking_type,room,conference|date|nullable',
            'check_out' => 'required_if:check_in,!=,null|date|after_or_equal:check_in|nullable',
            // Restaurant Dates
            'date' => 'required_if:booking_type,restaurant|date|nullable',
            'time_slot' => 'required_if:booking_type,restaurant|string|nullable',
            // Selection IDs
            'room_id' => 'required_if:booking_type,room|exists:rooms,id|nullable',
            'hall_id' => 'required_if:booking_type,conference|exists:conference_halls,id|nullable',
            'restaurant_title' => 'required_if:booking_type,restaurant|string|nullable',
            // Amounts
            'total_price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        // 1. Handle User (Select Existing or Create New Guest Account)
        $userId = $request->user_id;
        if (!$userId) {
            // Check if user already exists by email
            $existingUser = User::where('email', $request->guest_email)->first();
            if ($existingUser) {
                $userId = $existingUser->id;
            } else {
                // Create a temporary "Guest" user account
                $newUser = User::create([
                    'name' => $request->guest_name,
                    'email' => $request->guest_email,
                    'phone' => $request->guest_phone,
                    'password' => Hash::make(Str::random(12)),
                    'role' => 'user'
                ]);
                $userId = $newUser->id;
            }
        }

        // 2. Overlap Security Check (Same as online booking)
        if ($request->booking_type === 'room') {
            $exists = Booking::where('room_id', $request->room_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->where(function ($q) use ($request) {
                    $q->whereBetween('check_in', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                        ->orWhere(function ($sub) use ($request) {
                            $sub->where('check_in', '<=', $request->check_in)
                                ->where('check_out', '>=', $request->check_out);
                        });
                })->exists();
            if ($exists) {
                return back()->withInput()->withErrors(['check_in' => 'This room is already booked for the selected dates.']);
            }
        } elseif ($request->booking_type === 'conference') {
            $exists = Booking::where('hall_id', $request->hall_id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->where(function ($q) use ($request) {
                    $q->whereBetween('check_in', [$request->check_in, $request->check_out])
                        ->orWhereBetween('check_out', [$request->check_in, $request->check_out]);
                })->exists();
            if ($exists) {
                return back()->withInput()->withErrors(['check_in' => 'This hall is already booked for the selected dates.']);
            }
        }

        // 3. Create Booking
        $booking = new Booking();
        $booking->user_id = $userId;
        $booking->type = $request->booking_type;
        $booking->status = 'confirmed';
        $booking->total_price = $request->total_price;
        $booking->amount_paid = $request->amount_paid;
        $booking->payment_percentage = ($request->total_price > 0) ? round(($request->amount_paid / $request->total_price) * 100) : 0;
        $booking->payment_status = ($request->amount_paid >= $request->total_price) ? 'success' : 'pending';
        $booking->payment_method = 'cash'; // Default for offline
        $booking->is_checked = true;

        if ($request->booking_type === 'room') {
            $room = Room::find($request->room_id);
            $booking->room_id = $room->id;
            $booking->title = $room->name;
            $booking->check_in = $request->check_in;
            $booking->check_out = $request->check_out;
        } elseif ($request->booking_type === 'conference') {
            $hall = ConferenceHall::find($request->hall_id);
            $booking->hall_id = $hall->id;
            $booking->title = $hall->name;
            $booking->check_in = $request->check_in;
            $booking->check_out = $request->check_out;
        } else {
            $booking->title = $request->restaurant_title;
            $booking->date = $request->date;
            $booking->time_slot = $request->time_slot;
        }

        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Offline booking created successfully.');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'room', 'conferenceHall']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Generate a printable invoice for the booking.
     */
    public function invoice(Booking $booking)
    {
        $booking->load(['user', 'room', 'conferenceHall']);
        return view('admin.bookings.invoice', compact('booking'));
    }

    /**
     * Update the booking status and notes.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:pending,success,failed',
            'amount_paid' => 'required|numeric|min:0',
            'admin_notes' => 'nullable|string',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after_or_equal:check_in',
            'date' => 'nullable|date',
        ]);

        // Security: Prevent tampering with payments if service is already complete
        if ($booking->status === 'completed' && $booking->payment_status === 'success' && !auth()->user()->isSuperAdmin()) {
            unset($validated['amount_paid'], $validated['payment_status']);
        }

        // Security: Prevent decreasing the paid amount (Anti-theft)
        if ($request->amount_paid < $booking->amount_paid && !auth()->user()->isSuperAdmin()) {
            return back()->withErrors(['amount_paid' => 'The paid amount cannot be decreased. Previous amount: ' . $booking->amount_paid]);
        }

        // Security: Check for Date Overlaps (Double Booking Protection)
        if ($request->filled(['check_in', 'check_out']) || $request->filled('date')) {
            $newIn = $request->check_in ?? $request->date;
            $newOut = $request->check_out ?? ($request->date ?? $request->check_in);
            
            $overlapQuery = Booking::where('id', '!=', $booking->id)
                ->whereIn('status', ['confirmed', 'pending', 'pending_review']);

            if ($booking->type === 'room') {
                $overlapQuery->where('room_id', $booking->room_id)
                      ->where(function($q) use ($newIn, $newOut) {
                          $q->where('check_in', '<', $newOut)
                            ->where('check_out', '>', $newIn);
                      });
            } else {
                $overlapQuery->where('hall_id', $booking->hall_id)
                      ->where(function($q) use ($newIn, $newOut) {
                          $q->where(function($sq) use ($newIn, $newOut) {
                              // Overlap with multi-day bookings
                              $sq->whereNotNull('check_in')
                                 ->where('check_in', '<', $newOut)
                                 ->where('check_out', '>', $newIn);
                          })->orWhere(function($sq) use ($newIn, $newOut) {
                              // Overlap with single-day legacy/default bookings
                              $sq->whereNull('check_in')
                                 ->where('date', '>=', $newIn)
                                 ->where('date', '<=', $newOut);
                          });
                      });
            }

            if ($overlapQuery->exists()) {
                $conflict = $overlapQuery->first();
                $conflictStart = $conflict->check_in ?? $conflict->date;
                $conflictEnd = $conflict->check_out ?? $conflict->date;
                return back()->withErrors(['date' => "Security Alert: Occupied from $conflictStart to $conflictEnd. Update rejected."]);
            }
        }

        $statusChanged = $booking->status !== $validated['status'];
        $paymentStatusChanged = $booking->payment_status !== $validated['payment_status'];
        $amountPaidChanged = $booking->amount_paid != $validated['amount_paid'];
        
        $dateChanged = false;
        if ($booking->type === 'restaurant') {
            $dateChanged = $booking->date != ($validated['date'] ?? $booking->date);
        } else {
            $dateChanged = ($booking->check_in != ($validated['check_in'] ?? $booking->check_in)) || 
                          ($booking->check_out != ($validated['check_out'] ?? $booking->check_out));
        }

        $booking->fill($validated);

        // Recalculate Total Price for Rooms & Conferences if dates changed
        if ($request->filled(['check_in', 'check_out'])) {
            $startDate = \Carbon\Carbon::parse($request->check_in);
            $endDate = \Carbon\Carbon::parse($request->check_out);
            $days = $startDate->diffInDays($endDate);
            $days = $days > 0 ? $days : 1;
            
            $rate = 0;
            if ($booking->type === 'room') {
                $room = \App\Models\Room::find($booking->room_id);
                $rate = $room ? $room->price : 0;
            } elseif ($booking->type === 'conference') {
                $hall = \App\Models\ConferenceHall::find($booking->hall_id);
                $rate = $hall ? $hall->price : 0;
            }
            
            if ($rate > 0) {
                $subtotal = $rate * $days;
                $serviceFee = round($subtotal * 0.05);
                $booking->total_price = $subtotal + $serviceFee;
            }
        }

        // Restaurant Pricing Update (Deposit + Food Bill)
        if ($booking->type === 'restaurant' && $request->filled('food_bill')) {
            $deposit = $booking->deposit_amount ?: 500;
            $booking->total_price = $deposit + (float) $request->food_bill;
        }

        // Automatic Full Payment Settlement for Restaurant
        if ($booking->type === 'restaurant' && $request->boolean('confirm_full_payment')) {
            $booking->amount_paid = $booking->total_price;
            $booking->payment_status = 'success';
        } 
        // Manual Payment Update Protection: Only Super Admin can override manually
        elseif ($request->has('amount_paid')) {
            if (auth()->user()->isSuperAdmin()) {
                $booking->amount_paid = (float) $request->amount_paid;
            }
        }

        $booking->save();

        if (($statusChanged || $dateChanged || $paymentStatusChanged || $amountPaidChanged) && $booking->user) {
            try {
                Mail::to($booking->user->email)->send(new BookingStatusUpdated($booking));
            } catch (\Exception $e) {
                \Log::error('Admin: Failed to send status update email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
