<div class="create-product-modal">
  <input type="checkbox" id="create-product" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative !max-w-2xl">
      <label for="create-product" class="btn btn-sm btn-circle absolute right-2 top-2 z-50">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New Product') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="create-product-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="create_product_user_id" value="{{ $current_user_id }}" />

          <div class="flex flex-wrap gap-4 md:flex-nowrap">
            <div class="w-full md:w-2/3">
              <x-input-label for="create_product_name" :value="__('Nama Barang')" />
              <x-forms.text-input id="create_product_name" type="text" placeholder="" class="mt-1 block w-full" />
              <x-forms.input-error id="error_create_product_name"></x-forms.input-error>
            </div>
            <div class="w-full md:w-1/3">
              <x-input-label for="create_product_sku" :value="__('Kode Barang / SKU')" />
              <x-forms.text-input id="create_product_sku" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-x-4 gap-y-4 md:grid-cols-4">
            <div>
              <x-input-label for="create_product_brand" :value="__('Merek Mobil')" />
              <x-forms.text-input id="create_product_brand" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_year" :value="__('Tahun Mobil')" />
              <x-forms.text-input id="create_product_year" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_cc" :value="__('CC Mobil')" />
              <x-forms.text-input id="create_product_cc" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_engine" :value="__('Tipe Mesin')" />
              <x-forms.text-input id="create_product_engine" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
          </div>

          <div class="flex flex-wrap gap-4 md:flex-nowrap md:gap-x-4">
            @can('create product buy price')
            <div class="w-full">
              <x-input-label for="create_product_price_buy" :value="__('Harga Beli')" />
              <x-forms.text-input id="create_product_price_buy" type="number" placeholder=""
                class="mt-1 block w-full" />
            </div>
            @endcan

            @can('create product resell price')
            <div class="w-full md:w-1/2">
              <x-input-label for="create_product_price_resell" :value="__('Harga Jual Toko')" />
              <x-forms.text-input id="create_product_price_resell" type="number" placeholder=""
                class="mt-1 block w-full" />
            </div>
            @endcan

            @can('create product retail price')
            <div class="w-full md:w-1/2">
              <x-input-label for="create_product_price_retail" :value="__('Harga Jual User')" />
              <x-forms.text-input id="create_product_price_retail" type="number" placeholder=""
                class="mt-1 block w-full" />
            </div>
            @endcan
          </div>

          <div>
            <x-input-label for="create_product_notes" :value="__('Catatan')" />
            <x-forms.text-area id="create_product_notes" rows="4" placeholder="" class="mt-1 block w-full text-sm" />
          </div>

          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <button id="btn-cancel-create-product" type="button" class="btn btn-ghost hover:bg-slate-200">{{
                __('Cancel') }}</button>
              <button id="btn-submit-create-product" type="button" class="btn btn-primary">{{ __('Add Product')
                }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  $(function () {
    /*
      * Create Product
      */
    //$('#create-product').prop('checked', true);
    $(document).on("click", "#btn-cancel-create-product", function(e) {
      $('#create-product').prop('checked', false);
    });
    $(document).on("click", "#btn-submit-create-product", function(e) {
      let name = $('#create_product_name').val();
      let sku = $('#create_product_sku').val();
      let brand = $('#create_product_brand').val();
      let year = $('#create_product_year').val();
      let cc = $('#create_product_cc').val();
      let engine = $('#create_product_engine').val();
      let price_buy = $('#create_product_price_buy').val();
      let price_resell = $('#create_product_price_resell').val();
      let price_retail = $('#create_product_price_retail').val();
      let notes = $('#create_product_notes').val();
      let user_id = $('#create_product_user_id').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
        url: `/api/product`,
        type: "POST",
        cache: false,
        data: {
          "name": name,
          "sku": sku,
          "brand": brand,
          "year": year,
          "cc": cc,
          "engine": engine,
          "price_buy": price_buy,
          "price_resell": price_resell,
          "price_retail": price_retail,
          "notes": notes,
          "user_id": user_id,
          "_token": token
        },
        success: function(response) {
          $('#create-product').prop('checked', false);
          $('#create_product_name').val('');
          $('#create_product_sku').val('');
          $('#create_product_brand').val('');
          $('#create_product_cc').val('');
          $('#create_product_engine').val('');
          $('#create_product_price_buy').val('');
          $('#create_product_price_resell').val('');
          $('#create_product_price_retail').val('');
          $('#create_product_notes').val('');
          window.location.href = "{{url('/product?status=product-created')}}";
        },
        error: function(error) {
          //console.log(error);
          //$('#create-product-error-message').show();
          if(error.responseJSON.name) {
            $('#create_product_name').addClass('input-error');
            $('#error_create_product_name').text(error.responseJSON.name).show();
          } else {
            $('#create_product_name').removeClass('input-error');
            $('#error_create_product_name').hide();
          }
        }
      });
    });
  });
</script>
@endpush