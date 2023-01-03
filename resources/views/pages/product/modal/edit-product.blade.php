<div class="edit-product-modal">
  <input type="checkbox" id="edit-product" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative !max-w-2xl">
      <label for="edit-product" class="btn btn-sm btn-circle absolute right-2 top-2 z-50">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Edit Product') }}</h3>
        <div class="mt-6 space-y-4">

          <input type="hidden" id="edit_product_id">

          <div id="edit-product-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <div class="flex flex-wrap gap-4 md:flex-nowrap">
            <div class="w-full md:w-2/3">
              <x-input-label for="edit_product_name" :value="__('Nama Barang')" />
              <x-forms.text-input id="edit_product_name" type="text" placeholder="" class="mt-1 block w-full" />
              <x-forms.input-error id="error_edit_product_name"></x-forms.input-error>
            </div>
            <div class="w-full md:w-1/3">
              <x-input-label for="edit_product_sku" :value="__('Kode Barang / SKU')" />
              <x-forms.text-input id="edit_product_sku" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-x-4 gap-y-4 md:grid-cols-4">
            <div>
              <x-input-label for="edit_product_brand" :value="__('Merek Mobil')" />
              <x-forms.text-input id="edit_product_brand" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="edit_product_year" :value="__('Tahun Mobil')" />
              <x-forms.text-input id="edit_product_year" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="edit_product_cc" :value="__('CC Mobil')" />
              <x-forms.text-input id="edit_product_cc" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
            <div>
              <x-input-label for="edit_product_engine" :value="__('Tipe Mesin')" />
              <x-forms.text-input id="edit_product_engine" type="text" placeholder="" class="mt-1 block w-full" />
            </div>
          </div>

          @canany('edit product buy price|edit product resell price|edit product retail price')
          <div class="flex flex-wrap gap-4 md:flex-nowrap md:gap-x-4">
            @else
            <div class="hidden">
              @endcanany

              @can('edit product buy price')
              <div class="w-full">
                @else
                <div class="hidden">
                  @endcan
                  <x-input-label for="edit_product_price_buy" :value="__('Harga Beli')" />
                  <x-forms.text-input id="edit_product_price_buy" type="number" placeholder=""
                    class="mt-1 block w-full" />
                </div>

                @can('edit product resell price')
                <div class="w-full md:w-1/2">
                  @else
                  <div class="hidden">
                    @endcan
                    <x-input-label for="edit_product_price_resell" :value="__('Harga Jual Toko')" />
                    <x-forms.text-input id="edit_product_price_resell" type="number" placeholder=""
                      class="mt-1 block w-full" />
                  </div>

                  @can('edit product retail price')
                  <div class="w-full md:w-1/2">
                    @else
                    <div class="hidden">
                      @endcan
                      <x-input-label for="edit_product_price_retail" :value="__('Harga Jual User')" />
                      <x-forms.text-input id="edit_product_price_retail" type="number" placeholder=""
                        class="mt-1 block w-full" />
                    </div>

                  </div>

                  <div>
                    <x-input-label for="edit_product_notes" :value="__('Catatan')" />
                    <x-forms.text-area id="edit_product_notes" rows="4" placeholder=""
                      class="mt-1 block w-full text-sm" />
                  </div>

                  <div>
                    <div class="flex justify-end items-center gap-2 pt-2">
                      <button id="btn-cancel-edit-product" type="button" class="btn btn-ghost hover:bg-slate-200">{{
                        __('Cancel') }}</button>
                      <button id="btn-submit-edit-product" type="button" class="btn btn-primary">{{ __('Save Product')
                        }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>