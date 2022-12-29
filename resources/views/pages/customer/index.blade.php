<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Customers') }}
      </h2>
      <x-buttons.button-link-primary :href="route('customer.create')">{{ __('Add Customer') }}
      </x-buttons.button-link-primary>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'customer-deleted' || request("status") === 'customer-deleted')
      <x-alert alert-id="alert-success" :icon="true" :dismiss="true">
        {{ __('Customer successfully deleted.') }}
      </x-alert>
      @endif

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
                    Jenis
                  </th>
                  <th scope="col" class="py-3 px-6">
                    Phone
                  </th>
                  <th scope="col" class="py-3 px-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $customer)
                <tr
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $customer->name }}
                  </th>
                  <td class="py-4 px-6">
                    {{ $customer->customertype->name }}
                  </td>
                  <td class="py-4 px-6">
                    {{ $customer->phone }}
                  </td>
                  <td class="py-4 px-6 text-right space-x-3">
                    <a href="/customer/{{ $customer->id }}/edit"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a href="/customer/{{ $customer->id }}/edit"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#!" data-id="{{ $customer->id }}"
                      class="delete_customer font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
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

  <script type="text/javascript">
    $(function () {
      $('.delete_customer').click(function (e) {
        e.preventDefault();
        //console.log('clicked');
        const customer_id = $(this).data("id");
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
        }).then(function (e) {
          //console.log(e);
          if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: 'DELETE',
              url: "{{url('/api/customer')}}/" + customer_id,
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
                //console.log(results);
                window.location.href = "{{url('/customer?status=customer-deleted')}}";
              }
            });
          } else {
            e.dismiss;
          }
        }, function (dismiss) {
          return false;
        })
      });
    });
  </script>
</x-app-layout>