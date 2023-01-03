<div class="view-request-modal">
  <input type="checkbox" id="view-item-request" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative !max-w-3xl">
      <label for="view-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Item Request Detail') }}</h3>

        <input type="hidden" id="view_item_id">

        <div class="border-l border-t border-b">
          <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="px-4 py-2 sm:p-4 border-r border-b">
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">No Request</div>
              <div id="view--data-request_code" class="font-bold text-sm sm:text-base"></div>
            </div>
            <div class="px-4 py-2 sm:p-4 border-r border-b col-span-2">
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Status</div>
              <div id="view--display-status" class="flex gap-x-4">
                <div id="view--data-status" class="font-bold text-sm sm:text-base"></div>
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
          <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="px-4 py-2 sm:p-4 border-r border-b">
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Tanggal Request</div>
              <div id="view--data-request_date" class="font-bold text-sm sm:text-base"></div>
            </div>
            <div class="px-4 py-2 sm:p-4 border-r border-b">
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Customer</div>
              <div>
                <span id="view--data-customer_name" class="font-bold text-sm sm:text-base"></span> <span
                  class="text-slate-500 text-sm">(<span id="view--data-cutomer_type"></span>)</span>
              </div>
            </div>
            <div class="px-4 py-2 sm:p-4 border-r border-b">
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Sales</div>
              <div>
                <span id="view--data-salesman_name" class="font-bold text-sm sm:text-base"></span> <span
                  class="text-slate-500 text-sm">(<span id="view--data-salesman_whatsapp"></span>)</span>
              </div>
            </div>
          </div>
          <div class="px-4 py-2 sm:p-4 border-r border-b">
            <div>
              <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Nama Barang</div>
              <div id="view--data-product_name" class="font-bold text-base sm:text-xl"></div>
            </div>
            <ul class="text-xs sm:text-sm mt-2">
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
          <div class="px-4 py-2 sm:p-4 border-r border-b">
            <div class="font-medium text-xs md:text-sm text-slate-500 uppercase sm:mb-1">Notes</div>
            <div id="view--data-notes" class="text-sm sm:text-base min-h-[50px] sm:min-h-[100px]">
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

    const load_item_request = (id) => {
      $.ajax({
        url: `api/item_request/` + id,
        type: "GET",
        cache: false,
        success:function(response){
          //console.log(response);
          //open modal
          let request_date = response.data.request_date.split(' ')[0];
          let request_date_reverse = request_date.split("-").reverse().join("-");
          let request_code = response.data.request_code;
          let status_id = response.data.status.id;
          let status = response.data.status.name;
          let customer_name = response.data.customer.name;
          let customer_type = response.data.customer.customer_type.name;
          let salesman_name = response.data.salesman.name;
          let salesman_whatsapp = response.data.salesman.whatsapp;
          let product_name = response.data.product.name;
          let product_sku = response.data.product.sku;
          let product_brand = response.data.product.brand;
          let product_year = response.data.product.year;
          let product_cc = response.data.product.cc;
          let product_engine = response.data.product.engine;
          let notes = response.data.notes;
          $('#view--data-status').text(status);
          $('#view--select-update-status').val(status_id);
          $('#view--data-request_date').text(request_date_reverse);
          $('#view--data-request_code').text(request_code);
          $('#view--data-customer_name').text(customer_name);
          $('#view--data-cutomer_type').text(customer_type);
          $('#view--data-salesman_name').text(salesman_name);
          $('#view--data-salesman_whatsapp').text(salesman_whatsapp);
          $('#view--data-product_name').text(product_name);
          if (product_sku) {
            $('#view-product_sku').show();
            $('#view--data-product_sku').text(product_sku);
          }
          if (product_brand) {
            $('#view-product_brand').show();
            $('#view--data-product_brand').text(product_brand);
          }
          if (product_year) {
            $('#view-product_year').show();
            $('#view--data-product_year').text(product_year);
          }
          if (product_cc) {
            $('#view-product_cc').show();
            $('#view--data-product_cc').text(product_cc);
          }
          if (product_engine) {
            $('#view-product_engine').show();
            $('#view--data-product_engine').text(product_engine);
          }
          if (notes) {
            $('#view--data-notes').text(notes);
          }
          $('#view-item-request').prop('checked', true);

        }
      });
    }
    // let item_request_id = '23012';
    // $("#view_item_id").val('23012');
    // load_item_request(item_request_id);
    /*
    * View Item Request
    */
    $(document).on("click", "#table-item-request tbody tr td:not(:last-child):not(.dtr-control)", function(e) {
      e.preventDefault();
      let item_request_id = $(this).closest('tr').attr("id");
      $("#view_item_id").val($(this).closest('tr').attr("id"));
      load_item_request(item_request_id);
    });
    $(document).on("click", ".view_item_request", function(e) {
      e.preventDefault();
      let item_request_id = $(this).data("id");
      $("#view_item_id").val($(this).data("id"));
      $.ajax({
        url: `api/item_request/${item_request_id}`,
        type: "GET",
        cache: false,
        success:function(response){
          //console.log(response);
          //open modal
          let request_date = response.data.request_date.split(' ')[0];
          let request_date_reverse = request_date.split("-").reverse().join("-");
          let request_code = response.data.request_code;
          let status_id = response.data.status.id;
          let status = response.data.status.name;
          let customer_name = response.data.customer.name;
          let customer_type = response.data.customer.customer_type.name;
          let salesman_name = response.data.salesman.name;
          let salesman_whatsapp = response.data.salesman.whatsapp;
          let product_name = response.data.product.name;
          let product_sku = response.data.product.sku;
          let product_brand = response.data.product.brand;
          let product_year = response.data.product.year;
          let product_cc = response.data.product.cc;
          let product_engine = response.data.product.engine;
          let notes = response.data.notes;
          $('#view--data-status').text(status);
          $('#view--select-update-status').val(status_id);
          $('#view--data-request_date').text(request_date_reverse);
          $('#view--data-request_code').text(request_code);
          $('#view--data-customer_name').text(customer_name);
          $('#view--data-cutomer_type').text(customer_type);
          $('#view--data-salesman_name').text(salesman_name);
          $('#view--data-salesman_whatsapp').text(salesman_whatsapp);
          $('#view--data-product_name').text(product_name);
          if (product_sku) {
            $('#view-product_sku').show();
            $('#view--data-product_sku').text(product_sku);
          }
          if (product_brand) {
            $('#view-product_brand').show();
            $('#view--data-product_brand').text(product_brand);
          }
          if (product_year) {
            $('#view-product_year').show();
            $('#view--data-product_year').text(product_year);
          }
          if (product_cc) {
            $('#view-product_cc').show();
            $('#view--data-product_cc').text(product_cc);
          }
          if (product_engine) {
            $('#view-product_engine').show();
            $('#view--data-product_engine').text(product_engine);
          }
          if (notes) {
            $('#view--data-notes').text(notes);
          }
          $('#view-item-request').prop('checked', true);

        }
      });
    });

    $(document).on("click", "#view--btn-show-select-status", function(e) {
      e.preventDefault();
      $('#view--display-status').hide();
      $('#view--update-status').show();
    });

    $('#view--btn-submit-update-status').click(function (e) {
      e.preventDefault();
      let view_item_id = $("#view_item_id").val();
      let status_id = $('#view--select-update-status').val();
      let token   = $("meta[name='csrf-token']").attr("content");
      //console.log(status_id);
      $.ajax({
        url: `/api/item_request/${view_item_id}`,
        type: "PUT",
        cache: false,
        data: {
          "action" : "update-status",
          "status_id": status_id,
          "_token": token
        },
        success: function(response) {
          //$('#edit-item-request').prop('checked', false);
          window.location.href = "{{url('/item_request?status=item_request-edited')}}";
        },
        error: function(error) {
          //...
        }
      });
    });

    $(document).on("click", "#view--btn-cancel-update-status", function(e) {
      e.preventDefault();
      $('#view--display-status').show();
      $('#view--update-status').hide();
    });

    $(document).on("click", ".btn-update-status", function(e) {
      e.preventDefault();
      let item_id = $(this).data("id");
      let status_id = $('input[name="radio-status-' + item_id + '"]:checked').val();
      let token   = $("meta[name='csrf-token']").attr("content");
      //console.log(status_id);
      $.ajax({
        url: `/api/item_request/${item_id}`,
        type: "PUT",
        cache: false,
        data: {
          "action" : "update-status",
          "status_id": status_id,
          "_token": token
        },
        success: function(response) {
          //$('#edit-item-request').prop('checked', false);
          window.location.href = "{{url('/item_request?status=item_request-edited')}}";
        },
        error: function(error) {
          //...
        }
      });
    });
  });
</script>

@endpush