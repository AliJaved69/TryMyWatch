<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function track(Request $request)
    {
        $trackingId = $request->query('tracking_id');
        $order = null;
        $error = null;

        if ($trackingId) {
            $order = Order::where('order_number', trim($trackingId))->first();
            if (!$order) {
                $error = 'No order found with the provided tracking ID.';
            }
        }

        return view('track_order', compact('order', 'trackingId', 'error'));
    }
}
