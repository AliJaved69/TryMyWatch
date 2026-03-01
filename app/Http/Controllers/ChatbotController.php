<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->input('message'));
        
        // 1. Check for OpenAI API Key
        $apiKey = env('OPENAI_API_KEY');
        
        if ($apiKey && $this->shouldUseAI($message)) {
            return $this->chatWithOpenAI($message, $apiKey);
        }

        // 2. Fallback to Rule-Based Logic
        $response = "I'm still learning! Please contact us via the contact form for specific inquiries.";

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

    private function shouldUseAI($message)
    {
        // Simple heuristic: If it's a long question or doesn't match basic keywords, try AI.
        $keywords = ['hello', 'hi', 'price', 'cost', 'shipping', 'delivery', 'return', 'refund', 'contact'];
        foreach ($keywords as $keyword) {
            if (str_contains($message, $keyword)) {
                return false; // Use local rule
            }
        }
        return true;
    }

    private function chatWithOpenAI($message, $apiKey)
    {
        try {
            $client = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ]);

            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant for TryMyWatch, a luxury watch e-commerce store. Answer briefly and professionally.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'max_tokens' => 100,
            ]);

            if ($response->successful()) {
                return response()->json(['response' => $response->json()['choices'][0]['message']['content']]);
            }
        } catch (\Exception $e) {
            // Fallback if API fails
        }
        
        return response()->json(['response' => "I'm having trouble connecting to my brain right now. Please try again later."]);
    }
}
