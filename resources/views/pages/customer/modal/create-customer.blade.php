<div class="create-customer-modal">
  <input type="checkbox" id="create-customer" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="create-customer" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New Customer') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="create-customer-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="create_customer_user_id" value="{{ $current_user_id }}" />

          <div>
            <x-input-label for="create_customer_name" :value="__('Nama Customer')" />
            <x-text-input id="create_customer_name" type="text" class="mt-1 block w-full" />
          </div>

          <div>
            <x-input-label for="create_customer_phone" :value="__('Phone')" />
            <x-text-input id="create_customer_phone" type="number" class="mt-1 block w-full" />
          </div>

          <div>
            <x-input-label for="create_customer_type" :value="__('Jenis Customer')" />
            <div class="flex gap-x-4 mt-2">
              @foreach ($customertypes as $key => $type )
              <div class="flex items-center">
                <input id="create_customer_type-option-{{ $type->id }}" type="radio" name="create_customer_type_id"
                  value="{{ $type->id }}" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" {{ ($type->id
                == '1' ) ?
                "checked" : "" }}>
                <label for="create_customer_type-option-{{ $type->id }}"
                  class="block ml-2 text-sm font-medium text-gray-900">
                  {{ $type->name }}
                </label>
              </div>
              @endforeach
            </div>
          </div>

          <div>
            <x-input-label for="create_customer_existing" :value="__('Langganan')" />
            <div class="flex gap-x-4 mt-2">
              <div class="flex items-center">
                <input id="create_customer_existing-false" type="radio" name="create_customer_existing" value="0"
                  class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300" checked>
                <label for="create_customer_existing-false" class="block ml-2 text-sm font-medium text-gray-900">
                  Belum Langganan
                </label>
              </div>
              <div class="flex items-center">
                <input id="create_customer_existing-true" type="radio" name="create_customer_existing" value="1"
                  class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300">
                <label for="create_customer_existing-true" class="block ml-2 text-sm font-medium text-gray-900">
                  Sudah Langganan
                </label>
              </div>
            </div>
          </div>

          <div>
            <x-input-label for="create_customer_salesman_current" :value="__('Sales Sekarang')" />
            <select id="create_customer_salesman_current"
              class="block mt-1 w-full border-gray-300 focus:ring-indigo-500 rounded-md shadow-sm">
              <option value="">-- Pilih Salesman --</option>
              @foreach ($salesmans as $sales)
              <option value="{{ $sales->id }}" {{ ($sales->id == $current_user_id) ? 'selected' : '' }} {{
                ($sales->active == 0 ) ? 'disabled' : '' }}>{{
                $sales->name }}</option>
              @endforeach
            </select>
          </div>

          <div id="create_customer_salesman_previous_container" style="display: none">
            <x-input-label for="create_customer_salesman_previous" :value="__('Sales Sebelumnya')" />
            <x-text-input id="create_customer_salesman_previous" type="text" class="mt-1 block w-full" />
          </div>

          <div>
            <x-input-label for="create_customer_notes" :value="__('Catatan')" />
            <x-forms.text-area id="create_customer_notes" rows="3" class="mt-1 block w-full text-sm" />
          </div>

          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <button id="btn-cancel-create-customer" type="button" class="btn btn-ghost hover:bg-slate-200">{{
                __('Cancel') }}</button>
              <button id="btn-submit-create-customer" type="button" class="btn btn-primary">{{ __('Add Customer')
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
    $("input[name=create_customer_existing]").change(function() {
      if ($("#create_customer_existing-true").is(':checked')) {
        $("#create_customer_salesman_previous_container").show();
      } else {
        $("#create_customer_salesman_previous").val('');
        $("#create_customer_salesman_previous_container").hide();
      }
    });
    $(document).on("click", "#btn-cancel-create-customer", function(e) {
      $('#create-customer').prop('checked', false);
    });
    $(document).on("click", "#btn-submit-create-customer", function(e) {
        let name = $('#create_customer_name').val();
        let phone = $('#create_customer_phone').val();
        let customer_type_id = $('input[name="create_customer_type_id"]:checked').val();
        let existing = $('input[name="create_customer_existing"]:checked').val();
        let current_salesman_id = $('#create_customer_salesman_current').val();
        let previous_salesman = $('#create_customer_salesman_previous').val();
        let notes = $('#create_customer_notes').val();
        let user_id = $('#create_customer_user_id').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        $.ajax({
          url: `/api/customer`,
          type: "POST",
          cache: false,
          data: {
            "name": name,
            "phone": phone,
            "customer_type_id": customer_type_id,
            "existing": existing,
            "current_salesman_id": current_salesman_id,
            "previous_salesman": previous_salesman,
            "notes": notes,
            "user_id": user_id,
            "_token": token
          },
          success: function(response) {
            $('#create-customer').prop('checked', false);
            window.location.href = "{{url('/customer?status=customer-created')}}";
          },
          error: function(error) {
            //...
            //console.log(error);
            $('#create-customer-error-message').show();
            if(error.responseJSON.name) {
              $('#create_customer_name').addClass('input-error');
            } else {
              $('#create_customer_name').removeClass('input-error');
            }
          }
        });
      });
  });
</script>
@endpush