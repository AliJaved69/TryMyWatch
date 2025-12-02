<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'items' => 'required',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:card,cod',
            'payment_method_id' => 'nullable|string'
        ]);

        // ---------- CARD PAYMENT ----------
        if ($validated['payment_method'] === 'card') {
            
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


            try {
                $payment = PaymentIntent::create([
                    'amount' => intval($validated['total_price'] * 100),
                    'currency' => 'usd',
                    'payment_method' => $validated['payment_method_id'],
                    'confirm' => true
                ]);

                if ($payment->status !== "succeeded") {
                    return back()->withErrors("Payment failed. Try again.");
                }

            } catch (\Exception $e) {
                return back()->withErrors("Payment Error: ".$e->getMessage());
            }
        }

        // ---------- SAVE ORDER ----------
        $order = Order::create($validated);

        Mail::to($validated['email'])->send(new OrderConfirmationMail($order));

        return redirect()->route("checkout.success")->with("message", "Order placed successfully.");
    }

    public function success()
    {
        return view("checkout_success");
    }
}
