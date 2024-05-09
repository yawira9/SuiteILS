<x-guest-layout>
    @section('title') {{ 'Iniciar sesión' }} @endsection

    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-6 py-4 sm:py-12">
        <div class="max-w-4xl w-full grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-0 login-container" style="opacity: 0; transition: opacity 0.5s ease-in-out;">
            <div class="flex justify-center items-center">
                <img src="https://www.cotecmar.com/sites/default/files/media/imagenes/2023-12/CotecmarLogo.png" alt="Cotecmar Logo" class="object-contain h-20 sm:h-60" draggable="false">
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex justify-center items-center" x-data="{ showPassword: false }">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
<div class="mt-4 relative">
    <x-label for="password" value="{{ __('Contraseña') }}" />
    <x-input x-bind:type="showPassword ? 'text' : 'password'" id="password" class="block mt-1 w-full pl-3 pr-10" name="password" required autocomplete="current-password" />
    <div class="absolute inset-y-0 right-0 pr-3 flex items-center translate-y-3">
        <span class="h-full flex items-center cursor-pointer" @click="showPassword = !showPassword">
            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 .394-.997.899-1.926 1.507-2.76M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3-9c4.478 0 8.268 2.943 9.542 7-.394.997-.899 1.926-1.507 2.76M10.5 5.275A10.05 10.05 0 0112 5c1.661 0 3.203.44 4.5 1.175" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 100-6 3 3 0 000 6z" />
            </svg>
        </span>
    </div>
</div>
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                        <x-button class="ms-4">
                            {{ __('Entrar') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginContainer = document.querySelector('.login-container');
            setTimeout(function () {
                loginContainer.style.opacity = '1';
            }, 100);
        });
    </script>
    @endpush
</x-guest-layout>
