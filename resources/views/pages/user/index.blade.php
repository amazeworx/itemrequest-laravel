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
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="text-gray-900 dark:text-gray-100">

          <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 border-b dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                <tr>
                  <th scope="col" class="py-3 px-6">
                    Nama
                  </th>
                  <th scope="col" class="py-3 px-6">
                    Email
                  </th>
                  <th scope="col" class="py-3 px-6">
                    WhatsApp
                  </th>
                  <th scope="col" class="py-3 px-6">
                    Role
                  </th>
                  <th scope="col" class="py-3 px-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $user)
                <tr
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $user->name }}
                  </th>
                  <td class="py-4 px-6">
                    {{ $user->email }}
                  </td>
                  <td class="py-4 px-6">
                    {{ $user->whatsapp }}
                  </td>
                  <td class="py-4 px-6">
                    {{ $user->roles->pluck('name')[0] }}
                  </td>
                  <td class="py-4 px-6 text-right">
                    <a href="/user/{{ $user->id }}/edit"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>