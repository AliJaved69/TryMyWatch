<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->input('message'));
        $response = "I'm still learning! Please contact us via the contact form for specific inquiries.";

        // Basic Rules
        if (str_contains($message, 'hello') || str_contains($message, 'hi')) {
            $response = "Hello! Welcome to TryMyWatch. How can I help you today?";
        } elseif (str_contains($message, 'price') || str_contains($message, 'cost')) {
            $response = "Our watches range from affordable luxury to premium collections. Check out our Shop page!";
        } elseif (str_contains($message, 'shipping') || str_contains($message, 'delivery')) {
            $response = "We offer free shipping on all orders over $500.";
        } elseif (str_contains($message, 'return') || str_contains($message, 'refund')) {
            $response = "You can return any watch within 30 days if it's in original condition.";
        } elseif (str_contains($message, 'contact')) {
            $response = "You can reach us at support@trymywatch.com or use the Contact form.";
        }

        return response()->json(['response' => $response]);
    }
}
