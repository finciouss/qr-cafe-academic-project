<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Cafe No-Limit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Admin Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                    </svg>
                    <span class="text-xl font-semibold">Cafe No-Limit</span>
                </div>

                <!-- Nav Menu -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-500 transition {{ request()->routeIs('admin.dashboard') ? 'text-orange-500 font-semibold' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.menu') }}" class="hover:text-orange-500 transition {{ request()->routeIs('admin.menu*') ? 'text-orange-500 font-semibold' : '' }}">
                        Menu
                    </a>
                    <a href="{{ route('admin.orders') }}" class="hover:text-orange-500 transition {{ request()->routeIs('admin.orders') && !request()->routeIs('admin.orders.history') ? 'text-orange-500 font-semibold' : '' }}">
                        Pesanan
                    </a>
                    <a href="{{ route('admin.orders.history') }}" class="hover:text-orange-500 transition {{ request()->routeIs('admin.orders.history') ? 'text-orange-500 font-semibold' : '' }}">
                        Riwayat Pesanan
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <img src="{{ asset('images/admin.jpg') }}" 
                                 alt="Admin" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF6B35&color=fff'">
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                            <div class="px-4 py-2 border-b">
                                <p class="font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-gray-500">Admin</p>
                            </div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Alpine.js for dropdown -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
