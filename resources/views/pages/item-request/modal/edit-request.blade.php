<div class="edit-request-modal">
  <input type="checkbox" id="edit-item-request" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative">
      <label for="edit-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Edit Item Request') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="edit-form-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="edit_item_id">

          <input type="hidden" id="edit_user_id" />

          <input type="hidden" id="edit_salesman_id" />

          <input type="hidden" id="edit_status_id" />

          <div>
            <x-forms.input-label for="edit_request_date" :value="__('Tanggal')" />
            <x-flat-pickr id="edit_request_date" name="edit_request_date" format="dd-mm-yyyy"
              :options="['enableTime' => 'false', 'dateFormat' => 'd-m-Y', 'altFormat' => 'd-m-Y', 'time_24hr' => 'true']" />
          </div>

          <div>
            <x-forms.input-label for="edit_product_id" :value="__('Nama Barang')" />
            <x-forms.select id="edit_product_id">
              <option value="" disabled selected>Select</option>
              @foreach ($products as $product)
              <option value="{{ $product->id }}">{{ $product->name }}</option>
              @endforeach
            </x-forms.select>
          </div>

          <div>
            <x-forms.input-label for="edit_customer_id" :value="__('Customer')" />
            <x-forms.select id="edit_customer_id">
              <option value="" disabled selected>Select</option>
              @foreach ($customers as $customer)
              <option value="{{ $customer->id }}">{{ $customer->name }}</option>
              @endforeach
            </x-forms.select>
          </div>

          <div>
            <x-forms.input-label for="edit_notes" :value="__('Catatan')" />
            <x-forms.text-area id="edit_notes" rows="4" class="text-sm" />
          </div>

          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <label for="edit-item-request" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
              <button id="btn-edit-item-request" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>