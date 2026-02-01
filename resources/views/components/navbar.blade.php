<nav class="bg-white shadow-sm py-4 px-6 fixed w-full top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
            </svg>
            <a href="{{ route('home') }}" class="text-xl font-semibold">Cafe No-Limit</a>
        </div>
        
        <div class="hidden md:flex items-center space-x-6">
            <a href="{{ route('cart') }}" class="px-4 py-2 bg-gray-100 rounded-md hover:bg-gray-200 transition relative">
                Keranjang 🛒
                @if(session('cart') && count(session('cart')) > 0)
                <span id="cart-badge" class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ count(session('cart')) }}
                </span>
                @endif
            </a>
            <a href="{{ route('about') }}" class="hover:text-orange-500 transition">Tentang Kami</a>
            <a href="{{ route('contact') }}" class="hover:text-orange-500 transition">Kontak</a>
            <a href="{{ route('menu') }}" class="hover:text-orange-500 transition">Menu</a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden" onclick="toggleMobileMenu()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden mt-4 space-y-2">
        <a href="{{ route('cart') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Keranjang 🛒</a>
        <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Tentang Kami</a>
        <a href="{{ route('contact') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Kontak</a>
        <a href="{{ route('menu') }}" class="block px-4 py-2 hover:bg-gray-100 rounded">Menu</a>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
