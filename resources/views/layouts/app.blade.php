<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Cafe No-Limit' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-overlay {
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3));
        }
    </style>
</head>                   
<body class="bg-gray-50">
    @include('components.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
</body>
</html>
