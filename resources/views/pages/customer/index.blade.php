@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Customers') }}
      </h2>
      @can('create customers')
      <label for="create-customer" class="btn btn-primary hidden md:inline-flex">{{ __('Add Customer')
        }}</label>
      <div class="fixed right-4 bottom-4 z-30 md:hidden">
        <label for="create-customer"
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

  {{-- Create Customer Modal --}}
  @include('pages.customer.modal.create-customer')

  {{-- View Customer Modal --}}
  @include('pages.customer.modal.view-customer')

  {{-- Edit Customer Modal --}}
  @include('pages.customer.modal.edit-customer')

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
      if (status == 'customer-created') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Customer berhasil dibuat',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "customer");
        });
      }
      if (status == 'customer-edited') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Customer berhasil diubah',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "customer");
        });
      }
      if (status == 'customer-deleted') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Customer berhasil dihapus',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "customer");
        });
      }
      if (status == 'customer-imported') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Customer berhasil diimport',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "customer");
        });
      }

    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  @endpush
</x-app-layout>