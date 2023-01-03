<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-14 h-14 text-primary sm:w-20 sm:h-20" />
      </a>
    </x-slot>

    <h2 class="font-semibold text-2xl text-gray-800 leading-tight mb-6">
      {{ __('Register') }}
    </h2>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <!-- Name -->
      <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
          autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="username" :value="__('Username')" />
        <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
          required autofocus />
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
      </div>

      <div class="mt-4">
        <x-input-label for="whatsapp" :value="__('WhatsApp')" />
        <x-text-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" :value="old('whatsapp')"
          required autofocus />
        <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
          autocomplete="new-password" />

        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
          required />

        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <input type="hidden" name="role" value="{{request()->get('role')}}">

      <div class="flex flex-col justify-center items-center mt-6">
        <x-buttons.button-primary class="w-full">
          {{ __('Register') }}
        </x-buttons.button-primary>
        <a class="underline inline-block mt-4 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          href="{{ route('login') }}">
          {{ __('Already registered?') }}
        </a>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>