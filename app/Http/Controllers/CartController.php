<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class CartController extends Controller
{
   
  public function index()
{
    $cart = session()->get('cart', []);
    $subtotal = 0;
    
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    $discount = 0; 
    $total = $subtotal - $discount;

    return view('cart', compact('cart', 'subtotal', 'discount', 'total'));
}


    public function add(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);
        
        $quantity = $request->input('quantity', 1);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => count($cart)
        ]);
    }


public function update(Product $product, Request $request)
{
    $cart = session()->get('cart', []);
    $action = $request->input('action');
    
    if (isset($cart[$product->id])) {
        if ($action === 'increase') {
            $cart[$product->id]['quantity']++;
        } elseif ($action === 'decrease') {
            if ($cart[$product->id]['quantity'] > 1) {
                $cart[$product->id]['quantity']--;
            } else {
                
                unset($cart[$product->id]);
            }
        }
        
        session()->put('cart', $cart);
    }
    

    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $discount = 0;
    $total = $subtotal - $discount;
    
    return response()->json([
        'success' => true,
        'cart' => $cart,
        'cart_count' => count($cart),
        'subtotal' => $subtotal,
        'total' => $total
    ]);
}


  
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }


public function proceedToConfirmation(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'table_number' => 'required|integer|min:1',
        'whatsapp' => 'required|string|max:20',
    ]);

    
    session()->put('order_data', $validated);
    
    
    return redirect()->route('order.confirmation');
}


public function confirmation()
{
    $cart = session()->get('cart', []);
    $orderData = session()->get('order_data');
    
    if (empty($cart)) {
        return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
    }
    
    if (!$orderData) {
        return redirect()->route('cart')->with('error', 'Data pesanan tidak lengkap');
    }
    
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $discount = 0;
    $total = $subtotal - $discount;
    

    return view('order-confirmation', compact('cart', 'subtotal', 'discount', 'total', 'orderData'));
}


    public function proceedToPayment(Request $request)
{
    $cart = session()->get('cart', []);
    $orderData = session()->get('order_data');
    
    if (empty($cart)) {
        return redirect()->route('cart')->with('error', 'Keranjang belanja kosong');
    }
    
    if (!$orderData) {
        return redirect()->route('cart')->with('error', 'Data pesanan tidak lengkap');
    }
    
    return redirect()->route('payment.detail');
}

    public function paymentDetail()
    {
        $cart = session()->get('cart', []);
        $orderData = session()->get('order_data');
        
        if (empty($cart) || !$orderData) {
            return redirect()->route('cart')->with('error', 'Data pesanan tidak lengkap');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('payment-detail', compact('cart', 'orderData', 'total'));
    }


    public function processPayment(Request $request)
    {
        try {
            
            $validated = $request->validate([
                'payment_method' => 'required|in:credit_card,digital_wallet,cash',
            ]);

            $cart = session()->get('cart', []);
            $orderData = session()->get('order_data');

           
            \Log::info('=== PROCESS PAYMENT START ===');
            \Log::info('Cart:', $cart);
            \Log::info('Order Data:', $orderData);
            \Log::info('Payment Method:', $validated);

            // Validate session data
            if (empty($cart)) {
                \Log::error('Cart is empty');
                return response()->json([
                    'success' => false,
                    'message' => 'Keranjang belanja kosong. Silakan mulai pesanan baru.'
                ], 400);
            }

            if (!$orderData) {
                \Log::error('Order data not found');
                return response()->json([
                    'success' => false,
                    'message' => 'Data pesanan tidak ditemukan. Silakan ulangi dari awal.'
                ], 400);
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $total = $subtotal;

            // Map payment method
            $paymentMethodMap = [
                'credit_card' => 'Kartu Kredit',
                'digital_wallet' => 'QR Code',
                'cash' => 'Tunai'
            ];

            $paymentMethod = $paymentMethodMap[$validated['payment_method']] ?? 'Tunai';

            \Log::info('Payment Method Mapped:', ['method' => $paymentMethod]);

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $orderData['customer_name'],
                'table_number' => $orderData['table_number'],
                'whatsapp' => $orderData['whatsapp'],
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $total,
                'items' => $cart,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
            ]);

            \Log::info('Order Created:', [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'payment_method' => $order->payment_method
            ]);

            // Clear session
            session()->forget(['cart', 'order_data']);

            \Log::info('=== PROCESS PAYMENT SUCCESS ===');

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'payment_method' => $order->payment_method
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Silakan pilih metode pembayaran'
            ], 422);

        } catch (\Exception $e) {
            \Log::error('=== PROCESS PAYMENT ERROR ===');
            \Log::error('Error Message:', ['message' => $e->getMessage()]);
            \Log::error('Error File:', ['file' => $e->getFile()]);
            \Log::error('Error Line:', ['line' => $e->getLine()]);
            \Log::error('Stack Trace:', ['trace' => $e->getTraceAsString()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
