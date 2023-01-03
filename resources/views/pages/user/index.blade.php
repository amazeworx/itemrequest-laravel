@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
      </h2>
      @can('create users')
      <label for="create-user" class="btn btn-primary hidden md:inline-flex">{{ __('Add User')
        }}</label>
      <div class="fixed right-4 bottom-4 z-30 md:hidden">
        <label for="create-user"
          class="btn btn-circle btn-primary btn-lg font-normal font-mono !text-3xl leading-none shadow-md">+</label>
      </div>
      @endcan
    </div>
  </x-slot>

  <div class="pt-0 lg:pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow sm:rounded-lg">
        <div class="text-gray-900 px-4 py-4 sm:p-6">

          {{-- Table --}}
          {{ $dataTable->table() }}

        </div>
      </div>

    </div>
  </div>

  <input type="hidden" id="current_user_id" value="{{ $current_user_id }}" />

  {{-- Create User Modal --}}
  @include('pages.user.modal.create-user')

  {{-- View User Modal --}}
  @include('pages.user.modal.view-user')

  {{-- Edit User Modal --}}
  @include('pages.user.modal.edit-user')

  @push('scripts')
  <script type="text/javascript">
    $(function () {

      /*
      * Helpers
      */
      function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split("&"),
          sParameterName,
          i

        for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split("=")

          if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined
              ? true
              : decodeURIComponent(sParameterName[1])
          }
        }
        return false
      }

      /*
       * Show toast on status
       */
      let status = getUrlParameter('status');
      //console.log('Status:', status);
      if (status == 'user-created') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'User berhasil dibuat',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "user");
        });
      }
      if (status == 'user-edited') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'User berhasil diubah',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "user");
        });
      }
      if (status == 'user-deleted') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'User berhasil dihapus',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "user");
        });
      }
    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  @endpush
</x-app-layout>