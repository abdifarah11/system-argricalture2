<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-no-repeat bg-center px-4 py-10"
         style="background-image: url('{{ asset('img/login-bg.jpg') }}');">

        <div class="w-full max-w-md bg-white bg-opacity-90 backdrop-blur-md border border-gray-200 shadow-xl rounded-xl p-8 sm:p-10">
            
            <!-- Heading -->
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
                {{ __('Welcome Back!') }}
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email"
                        class="block mt-1 w-full" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password"
                        class="block mt-1 w-full" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mt-4">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <label for="remember_me" class="ms-2 text-sm text-gray-600">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-indigo-600 hover:underline">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3 px-6 py-2">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
