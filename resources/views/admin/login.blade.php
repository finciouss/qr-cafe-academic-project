<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Cafe No-Limit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-4">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
            <!-- Header -->
            <div class="text-center mb-8 pb-6 border-b">
                <h1 class="text-3xl font-bold mb-2">Cafe No-Limit</h1>
                <p class="text-gray-600">Admin Dashboard Login</p>
            </div>

            <!-- Error Message -->
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                
                <!-- Username/Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Username</label>
                    <input type="email" 
                           name="email" 
                           placeholder="Masukkan Username"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-black transition"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" 
                           name="password" 
                           placeholder="Masukkan Password"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-black transition"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-black hover:bg-gray-800 text-white font-semibold py-4 rounded-lg transition">
                    Login Admin
                </button>
            </form>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-500 text-sm">
                    ← Kembali ke Homepage
                </a>
            </div>
        </div>
    </div>
</body>
</html>
