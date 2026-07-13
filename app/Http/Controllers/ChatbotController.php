<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->input('message'));
        
        // 1. Check for Gemini API Key
        $apiKey = env('GEMINI_API_KEY');
        
        if ($apiKey && $this->shouldUseAI($message)) {
            return $this->chatWithGemini($message, $apiKey);
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

    private function chatWithGemini($message, $apiKey)
    {
        try {
            // 1. Fetch available watches in catalog dynamically
            $products = \App\Models\Product::limit(15)->get(['id', 'title', 'price', 'brand']);
            $catalog = "Available Watches in Our Catalog:\n";
            foreach ($products as $p) {
                $brand = $p->brand ?? 'Unknown Brand';
                $price = number_format($p->price, 2);
                $catalog .= "- " . $p->title . " by " . $brand . " (Price: $" . $price . "). Product Link: " . route('product.show', $p->id) . "\n";
            }

            // 2. Build the system instruction detailing the store identity, VTO features, policies, and product catalog
            $systemInstruction = "You are a helpful, professional, and knowledgeable AI assistant for 'TryMyWatch', a luxury watch e-commerce store. "
                . "Answer briefly (2-3 sentences max) and professionally. "
                . "Use the following context to help customers:\n\n"
                . "Try-On Features:\n"
                . "- Real-time AR Try-On: Customers can view watches on their wrist using their web camera in real-time. Instruct them to visit any watch's product page and click 'View in AR (Camera)'.\n"
                . "- AI Static Try-On: Customers can upload a photo of their wrist to see how a watch fits. Direct them to visit the AI Static Try-On page: " . route('static.index') . "\n\n"
                . "Policies:\n"
                . "- Shipping: Free shipping on all orders over $500.\n"
                . "- Returns: 30-day return policy for any watch in original condition.\n"
                . "- Contact: support@trymywatch.com or via the Contact Form: " . route('contact') . "\n\n"
                . $catalog . "\n"
                . "Instructions:\n"
                . "Always recommend specific watches from our catalog when asked about watch options, recommendations, styles, or prices, and supply their exact clickable Product Link. Keep answers engaging and polite.";

            // 3. Call the Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $message]
                        ]
                    ]
                ],
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemInstruction]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    $reply = trim($data['candidates'][0]['content']['parts'][0]['text']);
                    return response()->json(['response' => $reply]);
                }
            } else {
                Log::warning('Gemini API request failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error connecting to Gemini API: ' . $e->getMessage());
        }
        
        return response()->json(['response' => "I'm having trouble connecting to my brain right now. Please try again later."]);
    }
}
