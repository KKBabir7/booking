<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Services\SslCommerzService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use App\Mail\AdminBookingNotification;

class SslCommerzPaymentController extends Controller
{
    protected $sslService;

    public function __construct(SslCommerzService $sslService)
    {
        $this->sslService = $sslService;
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $booking = Booking::where('transaction_id', $tran_id)->first();

        if ($booking) {
            // In a real scenario, you'd validate the amount and currency via SslCommerz API
            if ($this->sslService->validatePayment($request)) {
                $booking->update([
                    'payment_status' => 'success',
                    'status' => ($booking->status === 'payment_pending') ? 'pending' : $booking->status,
                    'deposit_amount' => $amount, // Store initial payment as permanent deposit
                    'amount_paid' => $amount
                ]);

                // Fix: Manually login the user to restore session after redirect
                Auth::loginUsingId($booking->user_id);

                // Send Confirmation Emails
                try {
                    Mail::to($booking->user->email)->send(new BookingConfirmed($booking));
                    Mail::to(config('mail.from.address'))->send(new \App\Mail\AdminBookingNotification($booking));
                } catch (\Exception $e) {
                    Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
                }

                return redirect()->route('payment.success.view', ['tran_id' => $tran_id])->with('success', 'Payment Successful!');
            }
        }

        return redirect()->to(route('account.index') . '?tab=bookings&type=room')->with('error', 'Payment validation failed.');
    }

    public function viewSuccess($tran_id)
    {
        $booking = Booking::where('transaction_id', $tran_id)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'success')
            ->firstOrFail();

        return view('payments.success', compact('booking'));
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $booking = Booking::where('transaction_id', $tran_id)->first();

        if ($booking) {
            // Fix: Restore session for redirect
            Auth::loginUsingId($booking->user_id);

            // Delete the booking record as requested
            $booking->delete();
        }

        return redirect()->to(route('account.index') . '?tab=bookings&type=room')->with('error', 'Payment Failed. Please try again.');
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $booking = Booking::where('transaction_id', $tran_id)->first();

        if ($booking) {
            // Fix: Restore session for redirect
            Auth::loginUsingId($booking->user_id);

            // Delete the booking record as requested
            $booking->delete();
        }

        return redirect()->to(route('account.index') . '?tab=bookings&type=room')->with('warning', 'Payment Canceled.');
    }

    public function ipn(Request $request)
    {
        // Handle Server-to-Server Instant Payment Notification
        Log::info('SSLCommerz IPN Received', $request->all());

        $tran_id = $request->input('tran_id');
        $booking = Booking::where('transaction_id', $tran_id)->first();

        if ($booking && $booking->payment_status !== 'success') {
            if ($this->sslService->validatePayment($request)) {
                $booking->update([
                    'payment_status' => 'success',
                    'deposit_amount' => $request->input('amount'),
                    'amount_paid' => $request->input('amount')
                ]);

                // Send Confirmation Emails via IPN if not already sent
                try {
                    Mail::to($booking->user->email)->send(new BookingConfirmed($booking));
                    Mail::to(config('mail.from.address'))->send(new \App\Mail\AdminBookingNotification($booking));
                } catch (\Exception $e) {
                    Log::error('IPN: Failed to send booking confirmation email: ' . $e->getMessage());
                }
            }
        }
    }
}
