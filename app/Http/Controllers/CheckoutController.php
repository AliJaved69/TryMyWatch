<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        $cart = json_decode(request()->cookie('cart'), true) ?? [];
        
        if (empty($cart)) {
            return redirect('/')->with('error', 'Your cart is empty.');
        }

        $total = array_reduce($cart, function($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        return view('checkout', compact('cart', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'card_number' => 'required|string|max:20',
            'expiry_date' => 'required|string|max:7',
            'cvv' => 'required|string|max:4',
            'name_on_card' => 'required|string|max:255'
        ]);

        try {
            // Process payment (in real app, integrate with payment gateway)
            $paymentSuccess = $this->processPayment($validated);
            
            if ($paymentSuccess) {
                // Clear the cart
                $cookie = Cookie::make('cart', json_encode([]), 0);
                
                return response()
                    ->view('checkout', ['success' => true, 'cart' => [], 'total' => 0])
                    ->withCookie($cookie);
            }
            
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during checkout. Please try again.');
        }

        return back()->with('error', 'Payment failed. Please try again.');
    }

    private function processPayment($paymentData)
    {
        // Simulate payment processing
        sleep(2);
        return true; // Always success for demo
    }
}