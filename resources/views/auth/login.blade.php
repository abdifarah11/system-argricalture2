<x-guest-layout>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Tailwind CSS --}}
    
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #0f172a;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .background {
            background: url("/img/login-bg.jpg") no-repeat center center;
            background-size: cover;
            position: fixed;
            inset: 0;
            z-index: 0;
            opacity: 0.8;
            filter: brightness(0.6) blur(2px);
        }

        .form-container {
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .form-container input:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.4);
        }

        .glow-button {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.6);
        }

        .glow-button:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen relative text-white">

    <div class="background"></div>

    <div class="w-full max-w-md p-8 rounded-2xl shadow-2xl form-container glass">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-white tracking-wide">Welcome Back</h2>
            <p class="text-sm text-gray-300 mt-2">Sign in to access your dashboard</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
           <div>
    <label for="email" class="block text-sm font-medium text-white">Email</label>
    <input
        id="email"
        type="email"
        name="email"
        value="{{ old('email') }}"
        required
        autofocus
        autocomplete="username"
        class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-600 focus:border-indigo-500"
    >
    {{-- @if ($errors->has('email'))
        <p class="mt-1 text-sm text-red-400">{{ $errors->first('email') }}</p>
    @endif --}}
</div>


            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                              class="mt-1 block w-full rounded-md bg-gray-800 text-white border border-gray-600 focus:border-indigo-500" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center text-sm">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-500 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-gray-200">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-300 hover:text-indigo-400" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div>
                <button type="submit"
                        class="w-full py-2 px-4 rounded-md glow-button transition duration-300 ease-in-out">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>

    @if (session('error'))
        <div class="absolute bottom-5 text-center w-full text-red-500 font-medium">
            {{ session('error') }}
        </div>
    @endif

</body>
</html>
</x-guest-layout>
