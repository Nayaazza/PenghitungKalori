<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data di bawah untuk mendaftar.</p>
        </div>

        <div class="relative mb-4">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <x-text-input id="name" class="block w-full ps-10" type="text" name="name" :value="old('name')"
                required autofocus placeholder="Nama Lengkap" />
        </div>
        <x-input-error :messages="$errors->get('name')" class="-mt-2 mb-4" />

        <div class="relative mb-4">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path d="M3 4a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm12 2-7 4.5L5 6h10z" />
                </svg>
            </div>
            <x-text-input id="email" class="block w-full ps-10" type="email" name="email" :value="old('email')"
                required placeholder="Email" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="-mt-2 mb-4" />

        <div class="relative mb-4">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <x-text-input id="password" class="block w-full ps-10" type="password" name="password" required
                autocomplete="new-password" placeholder="Password" />
        </div>
        <x-input-error :messages="$errors->get('password')" class="-mt-2 mb-4" />

        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <x-text-input id="password_confirmation" class="block w-full ps-10" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password" />
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <div class="mt-6">
            <x-primary-button class="w-full flex justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a class="font-semibold text-orange-600 hover:text-orange-800" href="{{ route('login') }}">
                    Login di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
