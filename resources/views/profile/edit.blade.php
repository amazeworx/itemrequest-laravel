<x-app-layout>
  <x-slot name="header">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 ">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profile') }}
      </h2>
    </div>
  </x-slot>

  <div class="pt-0 pb-6 lg:pb-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="px-4 py-5 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          @include('profile.partials.update-profile-information-form')
        </div>
      </div>

      <div class="px-4 py-5 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          @include('profile.partials.update-password-form')
        </div>
      </div>

      <div class="px-4 py-5 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          @include('profile.partials.delete-user-form')
        </div>
      </div>
    </div>
  </div>
</x-app-layout>