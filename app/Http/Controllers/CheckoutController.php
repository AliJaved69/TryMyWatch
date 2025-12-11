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

        if ($validated['payment_method'] === 'card') {
            Stripe::setApiKey(config('services.stripe.secret'));

            try {
                $payment = PaymentIntent::create([
                    'amount' => intval($validated['total_price'] * 100),  // amount in cents
                    'currency' => 'usd',
                    'payment_method' => $validated['payment_method_id'],
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                ]);

                if ($payment->status !== "succeeded") {
                    return redirect()->back()->with('error', 'Payment failed. Please try again.');
                }

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Payment Error: ' . $e->getMessage());
            }
        }

        // Save order data
        $order = Order::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'items' => $validated['items'],
            'total_price' => $validated['total_price'],
            'payment_method' => $validated['payment_method'],
        ]);

        // Send confirmation email
        Mail::to($validated['email'])->send(new OrderConfirmationMail($order));

        // Redirect to success page with message
        if ($validated['payment_method'] === 'card') {
            return redirect()->route('checkout.success')->with('success', 'Payment successful! Your order has been placed.');
        } else {
            return redirect()->route('checkout.success')->with('success', 'Order placed successfully with Cash on Delivery!');
        }
    }

    public function success()
    {
        return view('checkout_success');
    }
}
