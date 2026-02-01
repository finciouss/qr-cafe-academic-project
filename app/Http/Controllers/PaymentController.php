<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Log::info("MIDTRANS SERVER KEY LOADED", [
            'key' => config('midtrans.server_key'),
            'env' => config('midtrans.is_production') ? 'production' : 'sandbox'
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::find($request->order_id);

        if ($order->snap_token) {
            return response()->json(['snap_token' => $order->snap_token]);
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number, // Treat order_number as Midtrans order_id
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'phone' => $order->whatsapp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $order->snap_token = $snapToken;
            $order->save();

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Init Error: ' . $e->getMessage());
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Log every webhook call
        Log::info('Midtrans Webhook:', [
            'order_id' => $orderId,
            'transaction_status' => $transaction,
            'payment_type' => $type,
        ]);

        // Find order by order_number (which corresponds to Midtrans order_id)
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error('Order not found for Webhook ID: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->status = 'challenge';
                } else {
                    $order->status = 'paid';
                }
            }
        } else if ($transaction == 'settlement') {
            $order->status = 'paid';
        } else if ($transaction == 'pending') {
            $order->status = 'pending';
        } else if ($transaction == 'deny') {
            $order->status = 'cancelled';
        } else if ($transaction == 'expire') {
            $order->status = 'cancelled';
        } else if ($transaction == 'cancel') {
            $order->status = 'cancelled';
        }

        $order->transaction_id = $notif->transaction_id;
        $order->transaction_status = $transaction;
        $order->save();

        return response()->json(['message' => 'Payment status updated']);
    }
}
