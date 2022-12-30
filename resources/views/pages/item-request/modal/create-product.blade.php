<div class="create-product-modal">
  <input type="checkbox" id="create-product" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative max-w-2xl">
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New Product') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="create-product-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="create_product_user_id" value="{{ $current_user_id }}" />

          <div class="flex gap-x-4">
            <div class="w-2/3">
              <x-input-label for="create_product_name" :value="__('Nama Barang')" />
              <x-text-input id="create_product_name" type="text" class="mt-1 block w-full" />
            </div>
            <div class="w-1/3">
              <x-input-label for="create_product_sku" :value="__('Kode Barang / SKU')" />
              <x-text-input id="create_product_sku" type="text" class="mt-1 block w-full" />
            </div>
          </div>

          <div class="flex gap-x-4">
            <div>
              <x-input-label for="create_product_brand" :value="__('Merek Mobil')" />
              <x-text-input id="create_product_brand" type="text" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_year" :value="__('Tahun Mobil')" />
              <x-text-input id="create_product_year" type="text" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_cc" :value="__('CC Mobil')" />
              <x-text-input id="create_product_cc" type="text" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="create_product_engine" :value="__('Tipe Mesin')" />
              <x-text-input id="create_product_engine" type="text" class="mt-1 block w-full" />
            </div>
          </div>

          <div class="flex gap-x-4" style="display: none">
            <div class="w-1/3">
              <x-input-label for="create_product_price_buy" :value="__('Harga Beli')" />
              <x-text-input id="create_product_price_buy" type="number" class="mt-1 block w-full" />
            </div>

            <div class="w-1/3">
              <x-input-label for="create_product_price_resell" :value="__('Harga Toko')" />
              <x-text-input id="create_product_price_resell" type="number" />
            </div>

            <div class="w-1/3">
              <x-input-label for="create_product_price_retail" :value="__('Harga User')" />
              <x-text-input id="create_product_price_retail" type="number" class="mt-1 block w-full" />
            </div>
          </div>

          <div>
            <x-input-label for="create_product_notes" :value="__('Catatan')" />
            <x-forms.text-area id="create_product_notes" rows="4" class="mt-1 block w-full text-sm" />
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