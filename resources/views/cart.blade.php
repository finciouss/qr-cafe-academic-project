@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24">
    <h1 class="text-4xl font-bold mb-8">Keranjang Belanja</h1>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            @if(!empty($cart))
                @foreach($cart as $id => $item)
                <div id="cart-item-{{ $id }}" class="flex items-center gap-4 bg-white p-4 rounded-lg mb-4 shadow-sm">
                    <!-- Product Image -->
                    <img src="{{ asset('storage/products/' . $item['image']) }}" 
                         alt="{{ $item['name'] }}" 
                         class="w-20 h-20 object-cover rounded-lg"
                         onerror="this.src='https://via.placeholder.com/80'">
                    
                    <!-- Product Info -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $item['name'] }}</h3>
                        <p class="text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    
                    <!-- Quantity Controls -->
                    <div class="flex items-center gap-3">
                        <button onclick="updateQuantity({{ $id }}, 'decrease')" 
                                class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                            <span class="text-xl">-</span>
                        </button>
                        <span id="quantity-{{ $id }}" class="font-semibold min-w-[30px] text-center">
                            {{ $item['quantity'] }}
                        </span>
                        <button onclick="updateQuantity({{ $id }}, 'increase')" 
                                class="w-8 h-8 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center">
                            <span class="text-xl">+</span>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="bg-gray-100 p-8 rounded-lg text-center">
                    <p class="text-gray-500 mb-4">Keranjang belanja Anda kosong</p>
                    <a href="{{ route('menu') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">
                        Lihat Menu
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Summary & Form -->
        <div class="lg:col-span-1">
            <!-- Summary -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h2 class="font-bold text-xl mb-4">Ringkasan</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span id="subtotal-display" class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diskon</span>
                        <span class="font-semibold">Rp {{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-bold">Total</span>
                        <span id="total-display" class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            @if(!empty($cart))
            <div class="bg-gray-50 p-6 rounded-lg">
                <h2 class="font-bold text-xl mb-4">Data Pemesan</h2>
                
                <form action="{{ route('proceed.confirmation') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Pemesan -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2">Nama Pemesan</label>
                        <input type="text" 
                               name="customer_name" 
                               placeholder="Masukkan Nama Anda" 
                               value="{{ old('customer_name') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                               required>
                        @error('customer_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Meja -->
                    <div class="mb-4">
                        <label class="block font-medium mb-2">Nomor Meja</label>
                        <input type="text" 
                               name="table_number" 
                               placeholder="Contoh : 12" 
                               value="{{ old('table_number') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                               required>
                        @error('table_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor WhatsApp -->
                    <div class="mb-6">
                        <label class="block font-medium mb-2">Nomor WhatsApp</label>
                        <input type="tel" 
                               name="whatsapp" 
                               placeholder="08xxxxxxxx" 
                               value="{{ old('whatsapp') }}"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-orange-500"
                               required>
                        @error('whatsapp')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-4 rounded-lg transition">
                        Lanjutkan Pembayaran
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, action) {
    fetch(`/cart/update/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ action: action })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Check if item still exists in cart
            if(data.cart[productId]) {
                // Update quantity display
                const quantityEl = document.getElementById(`quantity-${productId}`);
                quantityEl.textContent = data.cart[productId].quantity;
            } else {
                // Item removed, hide the item
                const itemEl = document.getElementById(`cart-item-${productId}`);
                if(itemEl) {
                    itemEl.remove();
                }
                
                // If cart is empty, reload page
                if(data.cart_count === 0) {
                    location.reload();
                }
            }
            
            // Update totals
            document.getElementById('subtotal-display').textContent = 
                'Rp ' + new Intl.NumberFormat('id-ID').format(data.subtotal);
            document.getElementById('total-display').textContent = 
                'Rp ' + new Intl.NumberFormat('id-ID').format(data.total);
            
            // Update cart count in navbar
            updateCartCount(data.cart_count);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal mengupdate keranjang');
    });
}

function updateCartCount(count) {
    const cartBadge = document.getElementById('cart-badge');
    if(cartBadge) {
        if(count > 0) {
            cartBadge.textContent = count;
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.classList.add('hidden');
        }
    }
}
</script>
@endsection
