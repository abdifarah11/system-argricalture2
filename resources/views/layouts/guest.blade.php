<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1503264116251-35a269479413?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-button {
            background: linear-gradient(to right, #06b6d4, #3b82f6);
        }

        .gradient-button:hover {
            background: linear-gradient(to right, #3b82f6, #06b6d4);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen font-sans antialiased text-gray-900">

    <div class="glass-card w-full max-w-md p-8 shadow-lg text-white">
        <div class="flex items-center gap-2 mb-6">
            <div class="bg-blue-400 w-8 h-8 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v2a6 6 0 0012 0V8a6 6 0 00-6-6zm-3 8V8a3 3 0 016 0v2a3 3 0 01-6 0z"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold">Log In to your account</h2>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-200">Email address</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 mt-1 rounded-md bg-transparent border border-gray-300 text-white focus:outline-none focus:border-blue-400" />
            </div>

            <div>
                <label class="block text-sm text-gray-200">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 mt-1 rounded-md bg-transparent border border-gray-300 text-white focus:outline-none focus:border-blue-400" />
            </div>

            <div class="flex items-center justify-between text-sm text-gray-300">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="accent-blue-500" />
                    Keep me logged in
                </label>
                <a href="{{ route('password.request') }}" class="text-blue-300 hover:underline">Forgot Password?</a>
            </div>

            <button type="submit"
                class="w-full py-2 rounded-md gradient-button text-white font-medium mt-4 hover:shadow-lg transition">
                Sign In
            </button>
        </form>
    </div>

</body>

</html>
