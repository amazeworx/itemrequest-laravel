<div class="create-modal">
  <input type="checkbox" id="create-item-request" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="create-item-request" class="btn btn-sm btn-circle absolute right-2 top-2 z-50">✕</label>
      <div id="create-item-request-form" class="relative">
        <div class="p-6">
          <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New Item Request') }}</h3>
          <div class="mt-6 space-y-4">

            <div id="create-form-error-message" class="hidden">
              <div class="inline-flex space-x-2 items-center text-xs text-error">
                <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
                <span class="inline-block">Wajib diisi</span>
              </div>
            </div>

            <input type="hidden" id="create_user_id" value="{{ $current_user_id }}" />

            <input type="hidden" id="create_salesman_id" value="{{ $current_user_id }}" />

            <input type="hidden" id="create_status_id" value="1" />

            <div>
              <x-forms.input-label for="create_request_date" :value="__('Tanggal')" />
              <x-flat-pickr id="create_request_date" name="create_request_date" value="{{ date('d-m-Y') }}"
                format="dd-mm-yyyy"
                :options="['enableTime' => 'false', 'dateFormat' => 'd-m-Y', 'altFormat' => 'd-m-Y', 'time_24hr' => 'true']" />
            </div>

            <div>
              <x-forms.input-label :value="__('Nama Barang')" />
              <div class="flex gap-x-3">
                <div class="grow">
                  <select id="create_product_id" placeholder="Select a product" class="w-full">
                    <option></option>
                  </select>
                </div>
                <div class="flex-none">
                  <button type="button" id="create-product-btn" class="btn btn-square text-xl leading-none"><i
                      class="uil uil-plus"></i></button>
                </div>
              </div>
            </div>

            <div>
              <x-forms.input-label :value="__('Customer')" />
              <div class="flex gap-x-3">
                <div class="grow">
                  <select id="create_customer_id" placeholder="Select a customer" class="w-full">
                    <option></option>
                  </select>
                </div>
                <div class="flex-none">
                  <button type="button" id="create-customer-btn" class="btn btn-square text-xl leading-none"><i
                      class="uil uil-plus"></i></button>
                </div>
              </div>
            </div>

            <div>
              <x-forms.input-label for="create_notes" :value="__('Catatan')" />
              <x-forms.text-area id="create_notes" rows="4" class="text-sm" />
            </div>

            <div>
              <div class="flex justify-end items-center gap-2 pt-2">
                <label for="create-item-request" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
                <button id="btn-submit-item-request" type="button" class="btn btn-primary">{{ __('Submit')
                  }}</button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>