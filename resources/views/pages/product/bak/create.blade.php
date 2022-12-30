<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Add Product') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'product-created')
      <x-alert alert-id="alert-success" type="success" :icon="true" :dismiss="true">
        {{ __('Product successfully created.') }}
      </x-alert>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add New Product') }}
          </h2>
          <form method="post" action="{{ route('product.store') }}" class="mt-6 space-y-4">
            @csrf

            <input type="hidden" name="user_id" class="mt-1 block w-full" value="{{ auth()->user()->id }}" />

            <div>
              <x-input-label for="product_name" :value="__('Nama Barang')" />
              <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="product_name" />
            </div>

            <div>
              <x-input-label for="sku" :value="__('Kode Barang / SKU')" />
              <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" autofocus autocomplete="sku" />
            </div>

            <div>
              <x-input-label for="brand" :value="__('Merek Mobil')" />
              <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" autofocus
                autocomplete="brand" />
            </div>

            <div>
              <x-input-label for="year" :value="__('Tahun Mobil')" />
              <x-text-input id="year" name="year" type="text" class="mt-1 block w-full" autofocus autocomplete="year" />
            </div>

            <div>
              <x-input-label for="cc" :value="__('CC Mobil')" />
              <x-text-input id="cc" name="cc" type="text" class="mt-1 block w-full" autofocus autocomplete="cc" />
            </div>

            <div>
              <x-input-label for="engine" :value="__('Tipe Mesin')" />
              <x-text-input id="engine" name="engine" type="text" class="mt-1 block w-full" autofocus
                autocomplete="engine" />
            </div>

            <div>
              <x-input-label for="price_buy" :value="__('Harga Beli')" />
              <x-text-input id="price_buy" name="price_buy" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_buy" />
            </div>

            <div>
              <x-input-label for="price_resell" :value="__('Harga Toko')" />
              <x-text-input id="price_resell" name="price_resell" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_resell" />
            </div>

            <div>
              <x-input-label for="price_retail" :value="__('Harga User')" />
              <x-text-input id="price_retail" name="price_retail" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_retail" />
            </div>

            <div>
              <x-input-label for="description" :value="__('Deskripsi Produk')" />
              <x-forms.text-area id="description" name="description" rows="4" placeholder=""
                class="mt-1 block w-full text-sm" autofocus autocomplete="description" />
            </div>

            <div>
              <x-input-label for="notes" :value="__('Catatan')" />
              <x-forms.text-area id="notes" name="notes" rows="4" class="mt-1 block w-full text-sm" autofocus
                autocomplete="notes" />
            </div>

            <div>
              <div class="flex items-center pt-4 gap-4">
                <x-buttons.button-primary>{{ __('Add Product') }}</x-buttons.button-primary>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
</x-app-layout>