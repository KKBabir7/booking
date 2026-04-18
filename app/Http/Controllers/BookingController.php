<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CurrencyService;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected $currencyService;
    protected $sslService;

    public function __construct(CurrencyService $currencyService, \App\Services\SslCommerzService $sslService)
    {
        $this->currencyService = $currencyService;
        $this->sslService = $sslService;
    }

    public function store(Request $request)
    {
        $type = $request->input('type', 'room');

        if ($type === 'room') {
            return $this->storeRoom($request);
        } elseif ($type === 'restaurant') {
            return $this->storeRestaurant($request);
        } elseif ($type === 'conference') {
            return $this->storeConference($request);
        }

        return back()->withErrors(['type' => 'Invalid booking type.']);
    }

    protected function storeRoom(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'stay_period' => 'required|string',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'pets' => 'nullable|integer|min:0',
            'payment_percentage' => 'required|integer|min:1|max:100',
            'amount_to_pay' => 'required|numeric|min:0',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Parse stay_period: "YYYY-MM-DD to YYYY-MM-DD"
        $dates = explode(' to ', $request->stay_period);
        if (count($dates) !== 2) {
            return back()->withErrors(['stay_period' => 'Invalid stay period selected.']);
        }

        $checkIn = Carbon::parse($dates[0]);
        $checkOut = Carbon::parse($dates[1]);
        $days = $checkIn->diffInDays($checkOut);

        if ($days <= 0) {
            return back()->withErrors(['stay_period' => 'Checkout must be after check-in.']);
        }

        // Prevent date overlap
        $overlap = Booking::active()
            ->where('room_id', $room->id)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut->copy()->subDay()])
                    ->orWhereBetween('check_out', [$checkIn->copy()->addDay(), $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                    });
            })->exists();

        if ($overlap) {
            return back()->withErrors(['stay_period' => 'please try another date slot to booking ,this date slot this room is booking.']);
        }

        $subtotal = $room->price * $days;
        $serviceFee = round($subtotal * 0.05);
        $totalPrice = $subtotal + $serviceFee;

        $activeCurrency = $this->currencyService->getCurrentCurrency();
        $transaction_id = 'SSLCZ_' . uniqid();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'type' => 'room',
            'title' => $room->name,
            'room_id' => $room->id,
            'transaction_id' => $transaction_id,
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'infants' => $request->infants ?? 0,
            'pets' => $request->pets ?? 0,
            'guests' => $request->adults + ($request->children ?? 0),
            'total_price' => $totalPrice,
            'amount_paid' => $request->amount_to_pay,
            'payment_percentage' => $request->payment_percentage,
            'payment_method' => 'sslcommerz',
            'currency_code' => $activeCurrency->code,
            'exchange_rate' => $activeCurrency->exchange_rate,
            'status' => 'payment_pending',
            'payment_status' => 'pending',
        ]);

        // Initiate SSLCommerz Payment
        $paymentUrl = $this->sslService->initiatePayment($booking, $request->amount_to_pay);

        if ($paymentUrl) {
            return redirect()->to($paymentUrl);
        }

        // Deletion logic if initiation fails
        $booking->delete();

        return back()->withErrors(['payment' => 'Could not initiate payment gateway. Please try again.']);
    }

    protected function storeRestaurant(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'guests' => 'required|integer|min:1',
        ]);

        $restaurant = \App\Models\Restaurant::findOrFail($request->restaurant_id);

        // Simple availability check: limit total guests per slot
        $totalGuestsInSlot = Booking::active()
            ->where('type', 'restaurant')
            ->where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->sum('guests');

        if ($totalGuestsInSlot + $request->guests > 50) { // arbitrary limit of 50 per slot
            return back()->withErrors(['time_slot' => 'Sorry, this time slot is fully booked.']);
        }

        $transaction_id = 'SSLCZ_' . uniqid();
        $activeCurrency = $this->currencyService->getCurrentCurrency();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'type' => 'restaurant',
            'title' => 'Restaurant Table (' . $restaurant->name . ')',
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'guests' => $request->guests,
            'total_price' => $restaurant->advance_amount,
            'amount_paid' => $restaurant->advance_amount,
            'payment_percentage' => 100,
            'payment_method' => 'sslcommerz',
            'transaction_id' => $transaction_id,
            'currency_code' => $activeCurrency->code,
            'exchange_rate' => $activeCurrency->exchange_rate,
            'status' => 'payment_pending',
            'payment_status' => 'pending',
        ]);

        // Initiate SSLCommerz Payment
        $paymentUrl = $this->sslService->initiatePayment($booking, $booking->amount_paid);

        if ($paymentUrl) {
            return redirect()->to($paymentUrl);
        }

        // Deletion logic if initiation fails
        $booking->delete();

        return back()->withErrors(['payment' => 'Could not initiate payment gateway. Please try again.']);
    }

    protected function storeConference(Request $request)
    {
        $request->validate([
            'hall_id' => 'required|exists:conference_halls,id',
            'date' => 'required|date|after_or_equal:today',
            'duration' => 'required|string',
            'guests' => 'required|integer|min:1',
        ]);

        // Enhanced Conflict check to handle range bookings
        $targetDate = $request->date;
        $conflict = Booking::active()
            ->where('type', 'conference')
            ->where('hall_id', $request->hall_id)
            ->where(function($q) use ($targetDate) {
                $q->where(function($sq) use ($targetDate) {
                    // Check against multi-day bookings (Range)
                    $sq->whereNotNull('check_in')
                       ->where('check_in', '<=', $targetDate)
                       ->where('check_out', '>=', $targetDate);
                })->orWhere(function($sq) use ($targetDate) {
                    // Check against single-day legacy bookings
                    $sq->whereNull('check_in')
                       ->where('date', $targetDate);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['date' => 'Security Alert: This hall is already reserved for corporate events on the selected date. Please choose another date or hall.']);
        }

        $hall = \App\Models\ConferenceHall::find($request->hall_id);

        $activeCurrency = $this->currencyService->getCurrentCurrency();
        $transaction_id = 'SSLCZ_' . uniqid();

        // Calculate total price accurately
        $totalPrice = $hall->price ?? 0;
        $amountToPay = $request->amount_to_pay ?? $totalPrice;
        $percentage = $request->payment_percentage ?? 100;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'type' => 'conference',
            'title' => $hall->name,
            'hall_id' => $request->hall_id,
            'date' => $request->date,
            'duration' => $request->duration,
            'guests' => $request->guests,
            'total_price' => $totalPrice,
            'amount_paid' => $amountToPay,
            'payment_percentage' => $percentage,
            'payment_method' => 'sslcommerz',
            'transaction_id' => $transaction_id,
            'currency_code' => $activeCurrency->code,
            'exchange_rate' => $activeCurrency->exchange_rate,
            'status' => 'payment_pending',
            'payment_status' => 'pending',
        ]);

        // Initiate SSLCommerz Payment
        $paymentUrl = $this->sslService->initiatePayment($booking, $amountToPay);

        if ($paymentUrl) {
            return redirect()->to($paymentUrl);
        }

        // Deletion logic if initiation fails
        $booking->delete();

        return back()->withErrors(['payment' => 'Could not initiate payment gateway. Please try again.']);
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending' || $booking->amount_paid > 0) {
            return back()->withErrors(['status' => 'Bookings with existing payments cannot be cancelled directly. Please contact support for a refund.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
