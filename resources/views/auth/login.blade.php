<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Login ke Akun Anda</h2>
            <p class="text-sm text-gray-500 mt-1">Masukkan detail akun untuk melanjutkan.</p>
        </div>

        <div class="relative mb-4">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path d="M3 4a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm12 2-7 4.5L5 6h10z" />
                </svg>
            </div>
            <x-text-input id="email" class="block w-full ps-10" type="email" name="email" :value="old('email')"
                required autofocus placeholder="Email" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="-mt-2 mb-4" />


        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <x-text-input id="password" class="block w-full ps-10" type="password" name="password" required
                placeholder="Password" />
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <div class="text-right mt-2">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Log In') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-orange-600 hover:text-orange-800">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
