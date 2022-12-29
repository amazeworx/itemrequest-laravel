<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add Item Request') }}
      </h2>
    </div>
  </x-slot>

  @php
  $current_user_id = auth()->user()->id;
  @endphp

  <div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'item_request-created')
      <x-alert alert-id="alert-success" type="success" :icon="true" :dismiss="true">
        {{ __('Item Request successfully created.') }}
      </x-alert>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add New Item Request') }}
          </h2>
          <form method="post" action="{{ route('item_request.store') }}" class="mt-6 space-y-4">
            @csrf

            <input type="hidden" name="user_id" class="mt-1 block w-full" value="{{ $current_user_id }}" />

            <div>
              <x-forms.input-label for="request_date" :value="__('Tanggal')" />
              <x-forms.datepicker id="request_date" name="request_date" class="mt-1 block w-full"
                value="{{ date('d-m-Y') }}" placeholder="Select date" required />
            </div>

            <div>
              <x-forms.input-label for="product_id" :value="__('Nama Barang')" />
              <x-forms.select id="product_id" name="product_id" class="mt-1 block w-full" required>
                <option value="" disabled selected>Select</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-forms.input-label for="customer_id" :value="__('Customer')" />
              <x-forms.select id="customer_id" name="customer_id" class="mt-1 block w-full" required>
                <option value="" disabled selected>Select</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-input-label for="notes" :value="__('Catatan')" />
              <x-forms.text-area id="notes" name="notes" rows="4" class="mt-1 block w-full text-sm" autofocus
                autocomplete="notes" />
            </div>

            <div>
              <div class="flex items-center pt-4 gap-4">
                <x-buttons.button-primary>{{ __('Submit') }}</x-buttons.button-primary>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
</x-app-layout>