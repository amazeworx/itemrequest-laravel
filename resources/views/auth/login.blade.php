<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-14 h-14 text-primary sm:w-20 sm:h-20" />
      </a>
    </x-slot>

    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6 sm:hidden">
      {{ __('Login') }}
    </h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Username -->
      <div>
        <x-input-label for="login" :value="__('Username / Email')" />
        <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required
          autofocus />
        <x-input-error :messages="$errors->get('login')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
          autocomplete="current-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Remember Me -->
      <div class="block mt-4">
        <label for="remember_me" class="inline-flex items-center">
          <input id="remember_me" type="checkbox"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
          <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>

      <div class="flex flex-col justify-center items-center mt-6">
        <button class="btn btn-primary w-full text-center">{{ __('Log in') }}</button>
        @if (Route::has('password.request'))
        <a class="underline inline-block mt-4 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{ route('password.request') }}">
          {{ __('Forgot your password?') }}
        </a>
        @endif
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>