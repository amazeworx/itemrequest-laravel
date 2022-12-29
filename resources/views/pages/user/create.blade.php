<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Users') }}
      </h2>
      <x-buttons.button-link-primary :href="route('user.create')">{{ __('Add User') }}
      </x-buttons.button-link-primary>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'user-created')
      <div id="alert-success" class="flex p-4 mb-4 bg-green-100 rounded-lg dark:bg-green-200" role="alert">
        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-green-700 dark:text-green-800" fill="currentColor"
          viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
            clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Info</span>
        <div class="ml-3 text-sm font-medium text-green-700 dark:text-green-800">
          {{ __('User successfully created.') }}
        </div>
        <button type="button"
          class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 dark:bg-green-200 dark:text-green-600 dark:hover:bg-green-300"
          data-dismiss-target="#alert-success" aria-label="Close">
          <span class="sr-only">Close</span>
          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <form method="POST" action="{{ route('user.store') }}">
          @csrf

          <!-- Name -->
          <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
              autofocus />
          </div>

          <!-- Email Address -->
          <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
              required />
          </div>

          <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
              required autofocus />
          </div>

          <div class="mt-4">
            <x-input-label for="whatsapp" :value="__('WhatsApp')" />
            <x-text-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" :value="old('whatsapp')"
              required autofocus />
          </div>

          <!-- Password -->
          <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
              autocomplete="new-password" />
          </div>

          <!-- Confirm Password -->
          <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
              name="password_confirmation" required />
          </div>

          <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <x-forms.select name="role" class="block mt-1 w-full" required>
              <option value="" disabled selected>-- Select Role --</option>
              <option value="2">Sales</option>
              <option value="3">Purchasing</option>
              <option value="1">Super Admin</option>
            </x-forms.select>
          </div>

          <div class="flex items-center mt-6">
            <x-buttons.button-primary>
              {{ __('Add New User') }}
            </x-buttons.button-primary>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</x-app-layout>