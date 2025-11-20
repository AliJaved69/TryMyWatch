<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

use Stripe\Stripe;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        return view('checkout'); 
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
            'items' => 'required|string',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|string|in:card,cod',
            'payment_method_id' => 'nullable|string',
        ]);

        // ----------- CARD PAYMENT -----------
        if ($validated['payment_method'] === 'card') {

            if (empty($validated['payment_method_id'])) {
                return back()->withErrors('Payment method ID is required for card payments.');
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            try {
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => intval($validated['total_price'] * 100),
                    'currency' => 'usd',
                    'payment_method' => $validated['payment_method_id'],
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'receipt_email' => $validated['email'],
                ]);

                if ($paymentIntent->status !== 'succeeded') {
                    return back()->withErrors('Payment failed. Please try again.');
                }

            } catch (\Exception $e) {
                return back()->withErrors('Payment Error: ' . $e->getMessage());
            }
        }

        // ----------- SAVE ORDER ----------
        $order = Order::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'items' => $validated['items'],
            'total_price' => $validated['total_price'],
            'payment_method' => $validated['payment_method'],
        ]);

        // ----------- SEND CONFIRMATION EMAIL -----------
        Mail::to($order->email)->send(new OrderConfirmationMail($order));

        return redirect()->route('checkout.success')
            ->with('message', 'Order placed successfully!');
    }

    public function success()
    {
        return view('checkout_success');
    }
}
