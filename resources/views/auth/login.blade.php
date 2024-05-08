<x-guest-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-6 py-4 sm:py-12">

        <div class="max-w-4xl w-full grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-0 login-container" style="opacity: 0; transition: opacity 0.5s ease-in-out;">

            <div class="flex justify-center items-center">
                <img src="https://www.cotecmar.com/sites/default/files/media/imagenes/2023-12/CotecmarLogo.png" alt="Cotecmar Logo" class="object-contain h-20 sm:h-60">
            </div>

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex justify-center items-center">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>
                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
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