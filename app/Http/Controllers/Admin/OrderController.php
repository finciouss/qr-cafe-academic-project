<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::whereIn('status', ['pending', 'processing'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

   
    public function history(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $paymentMethod = $request->get('payment_method');
        $date = $request->get('date');

        $orders = Order::query()
            ->when($search, function ($query, $search) {
                return $query->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($paymentMethod, function ($query, $paymentMethod) {
                return $query->where('payment_method', $paymentMethod);
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistics
        $stats = [
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
        ];

        return view('admin.orders.history', compact('orders', 'search', 'status', 'paymentMethod', 'date', 'stats'));
    }

  
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.detail', compact('order'));
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'processing';
        $order->save();

        return back()->with('success', 'Pesanan berhasil dikonfirmasi');
    }

   
    public function complete($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'completed';
        $order->save();

        return back()->with('success', 'Pesanan berhasil diselesaikan');
    }

  
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Pesanan dibatalkan');
    }

    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return back()->with('success', 'Pesanan berhasil dihapus');
    }
}
