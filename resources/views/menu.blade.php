@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-24">
    <!-- Page Title -->
    <h1 class="text-4xl font-bold mb-8">Menu</h1>

    <!-- Category Filter -->
    <div class="flex space-x-6 mb-8 border-b border-gray-200">
        <a href="{{ route('menu', ['category' => 'all']) }}" 
           class="pb-3 px-1 {{ $selectedCategory === 'all' ? 'border-b-2 border-black font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
            All
        </a>
        @foreach($categories as $category)
        <a href="{{ route('menu', ['category' => $category->slug]) }}" 
           class="pb-3 px-1 {{ $selectedCategory === $category->slug ? 'border-b-2 border-black font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
            {{ $category->name }}
        </a>
        @endforeach
    </div>

    <!-- Products Grid -->
    @foreach($products as $categoryName => $categoryProducts)
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6">{{ $categoryName }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categoryProducts as $product)
            <div class="bg-white rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Product Image -->
                <div class="relative group">
                    <img src="{{ $product->image_url }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover">
                    
                    <!-- Add to Cart Button (appears on hover) -->
                    <button onclick="addToCart({{ $product->id }})" 
                            class="absolute bottom-4 right-4 bg-gray-800 text-white p-3 rounded-full opacity-0 group-hover:opacity-100 transition-opacity hover:bg-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-800 font-medium">{{ $product->formatted_price }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    @if($products->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">Tidak ada produk tersedia saat ini.</p>
    </div>
    @endif
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300">
    <p id="toast-message">Produk ditambahkan ke keranjang!</p>
</div>

<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            showToast(data.message);
            updateCartCount(data.cart_count);
        }
    })
    .catch(error => console.error('Error:', error));
}

function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    toastMessage.textContent = message;
    
    toast.classList.remove('translate-x-full');
    
    setTimeout(() => {
        toast.classList.add('translate-x-full');
    }, 3000);
}

function updateCartCount(count) {
    // Update cart badge if exists
    const cartBadge = document.getElementById('cart-badge');
    if(cartBadge) {
        cartBadge.textContent = count;
    }
}
</script>
@endsection
