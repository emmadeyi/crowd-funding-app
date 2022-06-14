<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" class="text-yellow-400" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" class="text-yellow-400" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center text-yellow-400">
                    <x-jet-checkbox id="remember_me" class="text-yellow-400" name="remember" />
                    <span class="ml-2 text-sm text-yellow-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-yellow-400 hover:text-yellow-300" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4 text-yellow-400 bg-gray-700">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
        <p class="my-5 font-light text-sm text-gray-700 text-right">
            <a href="{{route('register')}}" class="text-yellow-400 underline">Don't have an account? Creat One</a>
        </p>
    </x-jet-authentication-card>
</x-guest-layout>
