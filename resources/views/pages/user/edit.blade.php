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

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <form method="POST" action="{{ route('user.update', $user) }}">
          @csrf
          @method('PUT')

          <!-- Name -->
          <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)"
              required autofocus />
          </div>

          <!-- Email Address -->
          <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
              :value="old('email', $user->email)" required />
          </div>

          <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
              :value="old('username', $user->username)" required autofocus />
          </div>

          <div class="mt-4">
            <x-input-label for="whatsapp" :value="__('WhatsApp')" />
            <x-text-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp"
              :value="old('whatsapp', $user->whatsapp)" required autofocus />
          </div>

          <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <x-forms.select name="role" class="block mt-1 w-full" required autofocus>
              <option value="" @if(!$user->roles->pluck('id')[0]) selected @endif disabled>-- Select Role --
              </option>
              <option value="2" @if($user->roles->pluck('id')[0] == "2") selected @endif>Sales</option>
              <option value="3" @if($user->roles->pluck('id')[0] == "3") selected @endif>Purchasing</option>
              <option value="1" @if($user->roles->pluck('id')[0] == "1") selected @endif>Super Admin</option>
            </x-forms.select>
          </div>

          <div class="flex items-center mt-6 gap-x-4">
            <x-buttons.button-primary>
              {{ __('Save') }}
            </x-buttons.button-primary>
            @if (session('status') === 'user-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
              class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</x-app-layout>