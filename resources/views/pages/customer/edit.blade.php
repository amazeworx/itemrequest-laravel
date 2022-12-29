<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Products') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'customer-updated')
      <x-alert alert-id="alert-success" type="success" :icon="true" :dismiss="true">
        {{ __('Customer successfully updated.') }}
      </x-alert>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Customer') }}
          </h2>

          <form method="post" action="{{ route('customer.update', $customer) }}" class="mt-6 space-y-4">
            @csrf

            @method('PUT')

            <div>
              <x-input-label for="name" :value="__('Nama')" />
              <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                autocomplete="name" :value="old('name', $customer->name)" />
            </div>

            <div>
              <x-input-label for="phone" :value="__('Phone')" />
              <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" autofocus autocomplete="phone"
                :value="old('phone', $customer->phone)" />
            </div>

            <div>
              <x-input-label for="type" :value="__('Jenis Customer')" />
              <div class="flex gap-x-4 mt-2">
                @foreach ($customertype as $key => $type )
                <div class="flex items-center">
                  <input id="type-option-{{ $type->id }}" type="radio" name="type" value="{{ $type->id }}"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                    {{ ($customer->customer_type_id == $type->id ) ? "checked" : "" }}>
                  <label for="type-option-{{ $type->id }}"
                    class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    {{ $type->name }}
                  </label>
                </div>
                @endforeach
              </div>
            </div>

            <div>
              <x-input-label for="existing" :value="__('Langganan')" />
              <div class="flex gap-x-4 mt-2">
                <div class="flex items-center">
                  <input id="existing-false" type="radio" name="existing" value="0"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                    {{ ($customer->existing == "0") ? "checked" : "" }}>
                  <label for="existing-false" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Belum Langganan
                  </label>
                </div>
                <div class="flex items-center">
                  <input id="existing-true" type="radio" name="existing" value="1"
                    class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                    {{ ($customer->existing == "1") ? "checked" : "" }}>
                  <label for="existing-true" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Sudah Langganan
                  </label>
                </div>
              </div>
            </div>

            <div>
              <x-input-label for="salesman_current" :value="__('Sales Sekarang')" />
              <select name="salesman_current" class="block mt-1 w-full border-gray-300 dark:border-gray-700
                dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="" disabled>-- Pilih Salesman --</option>
                @foreach ($salesman as $sales)
                <option value="{{ $sales->id }}" {{ ($customer->current_salesman_id == $sales->id) ? "selected" : ""
                  }}>{{
                  $sales->name }}</option>
                @endforeach
              </select>
            </div>

            <div id="salesman_previous" style="display: none">
              <x-input-label for="salesman_previous" :value="__('Sales Sebelumnya')" />
              <select name="salesman_previous" class="block mt-1 w-full border-gray-300 dark:border-gray-700
                dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500
                dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="" disabled selected>-- Pilih Salesman --</option>
                @foreach ($salesman as $sales)
                <option value="{{ $sales->id }}" {{ ($customer->previous_salesman_id == $sales->id) ? "selected" : ""
                  }}>{{
                  $sales->name }}</option>
                @endforeach
              </select>
            </div>

            <div>
              <x-input-label for="notes" :value="__('Catatan')" />
              <x-forms.text-area id="notes" name="notes" rows="4" class="mt-1 block w-full text-sm" autofocus>
                {{ old('notes', $customer->notes) }}
              </x-forms.text-area>
            </div>

            <div>
              <div class="flex items-center justify-between pt-4 gap-x-4">
                <div class="flex items-center gap-x-4">
                  <x-buttons.button-primary>{{ __('Save') }}</x-buttons.button-primary>
                  @if (session('status') === 'customer-updated')
                  <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Customer Saved') }}</p>
                  @endif
                </div>
                <div class="-mr-6">
                  <x-buttons.button-link id="delete_customer" href="#!" data-id="{{ $customer->id }}" style="text"
                    theme="red" icon="">Delete</x-buttons.button-link>
                </div>
              </div>

            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
  <script type="text/javascript">
    $(function () {
      if ($("#existing-true").is(':checked')) {
        $("#salesman_previous").show();
      } else {
        $("#salesman_previous select").val('');
        $("#salesman_previous").hide();
      }
      $("input[name=existing]").change(function() {
        if ($("#existing-true").is(':checked')) {
          $("#salesman_previous").show();
        } else {
          $("#salesman_previous select").val('');
          $("#salesman_previous").hide();
        }
      });
      $('#delete_customer').click(function (e) {
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