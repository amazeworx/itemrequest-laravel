<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Item Request') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'item_request-updated')
      <x-alert alert-id="alert-success" type="success" :icon="true" :dismiss="true">
        {{ __('Item Request successfully updated.') }}
      </x-alert>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Item Request') }}
          </h2>

          <form method="post" action="{{ route('item_request.update', $item_request) }}" class="mt-6 space-y-4">
            @csrf

            @method('PUT')

            <div>
              <x-forms.input-label for="request_date" :value="__('Tanggal')" />
              <x-forms.datepicker id="request_date" name="request_date" class="mt-1 block w-full"
                value="{{ old('request_date', date('d-m-Y', strtotime($item_request->request_date))) }}" required
                disabled />
            </div>

            <div>
              <x-forms.input-label for="status_id" :value="__('Status')" />
              <x-forms.select id="status_id" name="status_id" class="mt-1 block w-full" required>
                <option value="" disabled selected>Select</option>
                @foreach ($statutes as $status)
                <option value="{{ $status->id }}" {{ ($item_request->status_id == $status->id) ? "selected" : ""
                  }}>{{ $status->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-forms.input-label for="product_id" :value="__('Nama Barang')" />
              <x-forms.select id="product_id" name="product_id" class="mt-1 block w-full" required>
                <option value="" disabled selected>Select</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ ($item_request->product_id == $product->id) ? "selected" : ""
                  }}>{{ $product->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-forms.input-label for="customer_id" :value="__('Customer')" />
              <x-forms.select id="customer_id" name="customer_id" class="mt-1 block w-full" required>
                <option value="" disabled selected>Select</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ ($item_request->customer_id == $customer->id) ? "selected" : ""
                  }}>{{ $customer->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-input-label for="notes" :value="__('Catatan')" />
              <x-forms.text-area id="notes" name="notes" rows="4" class="mt-1 block w-full text-sm" autofocus>
                {{ old('notes', $item_request->notes) }}
              </x-forms.text-area>
            </div>

            <div>
              <div class="flex items-center justify-between pt-4 gap-x-4">
                <div class="flex items-center gap-x-4">
                  <x-buttons.button-primary>{{ __('Save') }}</x-buttons.button-primary>
                  @if (session('status') === 'item_request-updated')
                  <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Item Request Saved') }}</p>
                  @endif
                </div>
                <div class="-mr-6">
                  <x-buttons.button-link id="delete_item_request" href="#!" data-id="{{ $item_request->id }}"
                    style="text" theme="red" icon="">Delete</x-buttons.button-link>
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
      $('#delete_item_request').click(function (e) {
        e.preventDefault();
        const item_request_id = $(this).data("id");
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
        }).then(function (e) {
          if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: 'DELETE',
              url: "{{url('/api/item_request')}}/" + item_request_id,
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
                window.location.href = "{{url('/item_request?status=item_request-deleted')}}";
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