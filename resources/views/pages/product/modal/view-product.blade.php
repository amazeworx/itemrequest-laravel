<div class="view-product-modal">
  <input type="checkbox" id="view-product" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="view-product" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">

        <div class="flex gap-x-4 items-baseline mb-4">
          <h3 class="text-xl font-medium text-gray-900">{{ __('Product Detail') }}</h3>
        </div>

        <input type="hidden" id="view_product_id">

        <div>
          <div id="view-product_name" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Nama Barang</div>
              <div id="view--data-product_name" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-product_sku" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">SKU</div>
              <div id="view--data-product_sku" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-product_brand" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Merek Mobil</div>
              <div id="view--data-product_brand" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-product_year" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Tahun</div>
              <div id="view--data-product_year" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-product_cc" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">CC</div>
              <div id="view--data-product_cc" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-product_engine" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Mesin</div>
              <div id="view--data-product_engine" class="w-2/3"></div>
            </div>
          </div>

          @can('view product buy price')
          <div id="view-price_buy" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Harga Beli</div>
              <div id="view--data-price_buy" class="w-2/3"></div>
            </div>
          </div>
          @endcan

          @can('view product resell price')
          <div id="view-price_resell" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Harga Jual Toko</div>
              <div id="view--data-price_resell" class="w-2/3"></div>
            </div>
          </div>
          @endcan

          @can('view product retail price')
          <div id="view-price_retail" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Harga Jual User</div>
              <div id="view--data-price_retail" class="w-2/3"></div>
            </div>
          </div>
          @endcan

          <div id="view-product_notes" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Catatan</div>
              <div id="view--data-product_notes" class="w-2/3"></div>
            </div>
          </div>

        </div>

        @canany('edit products|delete products')
        <div>
          <div class="flex justify-end items-center gap-2 pt-2 mt-4">
            @can('edit products')
            <button id="btn-edit-product" type="button" class="btn btn-sm btn-outline btn-primary">{{
              __('Edit')
              }}</button>
            @endcan
            @can('delete products')
            <button id="btn-delete-product" type="button" class="btn btn-sm btn-ghost hover:bg-slate-200">{{
              __('Delete') }}</button>
            @endcan
          </div>
        </div>
        @endcanany

      </div>
    </div>
  </div>
</div>