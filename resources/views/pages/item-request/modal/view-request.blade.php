<div class="view-modal">
  <input type="checkbox" id="view-item-request" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative max-w-3xl">
      <label for="view-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Item Request Detail') }}</h3>

        <input type="hidden" id="view_item_id">

        <div class="border-l border-t border-b">
          <div class="grid grid-cols-3">
            <div class="p-4 border-r border-b">
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">No Request</div>
              <div id="view--data-request_code" class="font-bold"></div>
            </div>
            <div class="p-4 border-r border-b col-span-2">
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">Status</div>
              <div id="view--display-status" class="flex gap-x-4">
                <div id="view--data-status" class="font-bold"></div>
                <button type="button" id="view--btn-show-select-status" class="link link-primary text-sm">Change
                  Status</button>
              </div>
              <div id="view--update-status" class="hidden">
                <x-forms.select id="view--select-update-status">
                  @foreach ($statuses as $status)
                  <option value="{{ $status->id }}">{{ $status->name }}</option>
                  @endforeach
                </x-forms.select>
                <div class="flex gap-2 mt-2">
                  <button type="button" id="view--btn-submit-update-status"
                    class="btn btn-primary btn-sm">Update</button>
                  <button type="button" id="view--btn-cancel-update-status" class="btn btn-ghost btn-sm">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-3">
            <div class="p-4 border-r border-b">
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">Tanggal Request</div>
              <div id="view--data-request_date" class="font-bold"></div>
            </div>
            <div class="p-4 border-r border-b">
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">Customer</div>
              <div>
                <span id="view--data-customer_name" class="font-bold"></span> <span
                  class="text-slate-500 text-sm">(<span id="view--data-cutomer_type"></span>)</span>
              </div>
            </div>
            <div class="p-4 border-r border-b">
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">Sales</div>
              <div>
                <span id="view--data-salesman_name" class="font-bold"></span> <span
                  class="text-slate-500 text-sm">(<span id="view--data-salesman_whatsapp"></span>)</span>
              </div>
            </div>
          </div>
          <div class="p-4 border-r border-b">
            <div>
              <div class="font-medium text-sm text-slate-500 uppercase mb-1">Nama Barang</div>
              <div id="view--data-product_name" class="font-bold text-xl"></div>
            </div>
            <ul class="text-sm mt-2">
              <li id="view-product_sku"><span class="text-slate-500 uppercase font-medium">SKU :</span> <span
                  id="view--data-product_sku"></span></li>
              <li id="view-product_brand"><span class="text-slate-500 uppercase font-medium">Merek Mobil :</span>
                <span id="view--data-product_brand"></span>
              </li>
              <li id="view-product_year"><span class="text-slate-500 uppercase font-medium">Tahun :</span> <span
                  id="view--data-product_year"></span>
              </li>
              <li id="view-product_cc"><span class="text-slate-500 uppercase font-medium">CC :</span> <span
                  id="view--data-product_cc"></span></li>
              <li id="view-product_engine"><span class="text-slate-500 uppercase font-medium">Mesin :</span> <span
                  id="view--data-product_engine"></span>
              </li>
            </ul>
          </div>
          <div class="p-4 border-r border-b">
            <div class="font-medium text-sm text-slate-500 uppercase mb-1">Notes</div>
            <div id="view--data-notes" class="min-h-[100px]">
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>