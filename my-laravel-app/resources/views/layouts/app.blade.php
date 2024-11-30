<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    
    <!-- Replace Vite with direct CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    @include('Components.navBar')
    
    <main>
        @yield('content')
    </main>

    <!-- Replace Vite with direct JS -->
   
    @yield('scripts')
</body>
</html> 