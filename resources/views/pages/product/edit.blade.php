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

      @if (session('status') === 'product-updated')
      <x-alert alert-id="alert-success" type="success" :icon="true" :dismiss="true">
        {{ __('Product successfully updated.') }}
      </x-alert>
      @endif

      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <div class="max-w-xl">
          <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Product') }}
          </h2>
          <form method="post" action="{{ route('product.update', $product) }}" class="mt-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
              <x-input-label for="product_name" :value="__('Nama Barang')" />
              <x-text-input id="product_name" name="product_name" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="product_name" :value="old('product_name', $product->name)" />
            </div>

            <div>
              <x-input-label for="sku" :value="__('Kode Barang / SKU')" />
              <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" autofocus autocomplete="sku"
                :value="old('sku', $product->sku)" />
            </div>

            <div>
              <x-input-label for="brand" :value="__('Merek Mobil')" />
              <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full" autofocus autocomplete="brand"
                :value="old('brand', $product->brand)" />
            </div>

            <div>
              <x-input-label for="year" :value="__('Tahun Mobil')" />
              <x-text-input id="year" name="year" type="text" class="mt-1 block w-full" autofocus autocomplete="year"
                :value="old('year', $product->year)" />
            </div>

            <div>
              <x-input-label for="cc" :value="__('CC Mobil')" />
              <x-text-input id="cc" name="cc" type="text" class="mt-1 block w-full" autofocus autocomplete="cc"
                :value="old('cc', $product->cc)" />
            </div>

            <div>
              <x-input-label for="engine" :value="__('Tipe Mesin')" />
              <x-text-input id="engine" name="engine" type="text" class="mt-1 block w-full" autofocus
                autocomplete="engine" :value="old('engine', $product->engine)" />
            </div>

            <div>
              <x-input-label for="price_buy" :value="__('Harga Beli')" />
              <x-text-input id="price_buy" name="price_buy" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_buy" :value="old('price_buy', $product->price_buy)" />
            </div>

            <div>
              <x-input-label for="price_resell" :value="__('Harga Toko')" />
              <x-text-input id="price_resell" name="price_resell" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_resell" :value="old('price_resell', $product->price_resell)" />
            </div>

            <div>
              <x-input-label for="price_retail" :value="__('Harga User')" />
              <x-text-input id="price_retail" name="price_retail" type="number" class="mt-1 block w-full" autofocus
                autocomplete="price_retail" :value="old('price_retail', $product->price_retail)" />
            </div>

            <div>
              <x-input-label for="description" :value="__('Deskripsi Produk')" />
              <x-forms.text-area id="description" name="description" rows="4" placeholder=""
                class="mt-1 block w-full text-sm" autofocus autocomplete="description">
                {{ old('description', $product->description) }}
              </x-forms.text-area>
            </div>

            <div>
              <x-input-label for="notes" :value="__('Catatan')" />
              <x-forms.text-area id="notes" name="notes" rows="4" class="mt-1 block w-full text-sm" autofocus>
                {{ old('notes', $product->notes) }}
              </x-forms.text-area>
            </div>

            <div>
              <div class="flex items-center justify-between pt-4 gap-x-4">
                <div class="flex items-center gap-x-4">
                  <x-buttons.button-primary>{{ __('Save') }}</x-buttons.button-primary>
                  @if (session('status') === 'product-updated')
                  <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Product Saved') }}</p>
                  @endif
                </div>
                <div class="-mr-6">
                  <x-buttons.button-link id="delete_product" href="#!" data-id="{{ $product->id }}" style="text"
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
      $('#delete_product').click(function (e) {
        e.preventDefault();
        //console.log('clicked');
        const product_id = $(this).data("id");
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
              url: "{{url('/api/product')}}/" + product_id,
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
                //console.log(results);
                window.location.href = "{{url('/product?status=product-deleted')}}";
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