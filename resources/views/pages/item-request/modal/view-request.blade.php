<div class="view-request-modal">
  <input type="checkbox" id="view-item-request" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative !max-w-3xl">
      <label for="view-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-semibold text-gray-900">{{ __('Item Request Detail') }}</h3>

        <input type="hidden" id="view_item_id">
        <input type="hidden" id="view_product_id">

        <div>
          <div class="border-t py-3">
            <div class="grid grid-cols-1">
              <div>
                <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase mb-1">Nama Barang</div>
                <div id="view--data-product_name" class="font-bold text-lg sm:text-xl"></div>
              </div>
              <div class="grid grid-cols-2 md:grid-cols-3 text-xs sm:text-sm mt-2 gap-x-2 gap-y-1">
                <div id="view-product_sku">
                  <div class="text-slate-400 uppercase font-semibold text-xs sm:text-xs">SKU</div>
                  <div id="view--data-product_sku"></div>
                </div>
                <div id="view-product_brand">
                  <div class="text-slate-400 uppercase font-semibold text-xs sm:text-xs">Merek Mobil</div>
                  <div id="view--data-product_brand"></div>
                </div>
                <div id="view-product_year">
                  <div class="text-slate-400 uppercase font-semibold text-xs sm:text-xs">Tahun</div>
                  <div id="view--data-product_year"></div>
                </div>
                <div id="view-product_cc">
                  <div class="text-slate-400 uppercase font-semibold text-xs sm:text-xs">CC</div>
                  <div id="view--data-product_cc"></div>
                </div>
                <div id="view-product_engine">
                  <div class="text-slate-400 uppercase font-semibold text-xs sm:text-xs">Mesin</div>
                  <div id="view--data-product_engine"></div>
                </div>
              </div>
            </div>
          </div>

          @can('view product buy price')
          <div>
            <div class="py-3 border-t">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Harga Beli</div>
              <div id="view--display-product_price_buy">
                <div class="flex">
                  <div id="view--data-product_price_buy" class="font-bold text-sm sm:text-base mr-4"
                    style="display: none">
                  </div>
                  @can('create product buy price')
                  <button type="button" id="view--btn-show-update-product_buy_price"
                    class="link link-primary text-xs">Set Harga
                    Beli</button>
                  @endcan
                </div>
              </div>
              <div id="view--update-product_price_buy" class="hidden">
                <x-forms.text-input id="view--input-product_price_buy" type="text" class="mt-1 block w-full max-w-xs" />
                <x-forms.input-error id="error_product_price_buy"></x-forms.input-error>
                <div class="flex gap-2 mt-2">
                  <button type="button" id="view--btn-submit-update-product_price_buy"
                    class="btn btn-primary btn-sm">Update</button>
                  <button type="button" id="view--btn-cancel-update-product_price_buy"
                    class="btn btn-ghost btn-sm">Cancel</button>
                </div>
              </div>

            </div>
          </div>
          @endcan

          @canany(['view product resell price','view product retail price'])
          <div class="py-3 border-t">
            <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase mb-1  sm:mb-1">Harga Jual</div>
            <div id="view--display-product_price_sell">
              <div id="view--data-product_price_resell" class="font-bold text-sm sm:text-base" style="display: none">
              </div>
              <div id="view--data-product_price_retail" class="font-bold text-sm sm:text-base" style="display: none">
              </div>
              @canany(['create product resell price', 'create product retail price'])
              <button type="button" id="view--btn-show-update-product_price_sell" class="link link-primary text-xs">Set
                Harga
                Jual</button>
              @endcan
            </div>
            <div id="view--update-product_price_sell" class="py-2 hidden">
              <div class="flex gap-x-3">
                <div class="w-1/2">
                  <x-forms.input-label :value="__('Harga Jual Toko')" />
                  <x-forms.text-input id="view--input-product_price_resell" type="text"
                    class="mt-1 block w-full max-w-xs" />
                </div>
                <div class="w-1/2">
                  <x-forms.input-label :value="__('Harga Jual End User')" />
                  <x-forms.text-input id="view--input-product_price_retail" type="text"
                    class="mt-1 block w-full max-w-xs" />
                </div>
              </div>
              <x-forms.input-error id="error_product_price_sell"></x-forms.input-error>
              <div class="flex gap-2 mt-2">
                <button type="button" id="view--btn-submit-update-product_price_sell"
                  class="btn btn-primary btn-sm">Update</button>
                <button type="button" id="view--btn-cancel-update-product_price_sell"
                  class="btn btn-ghost btn-sm">Cancel</button>
              </div>
            </div>
          </div>
          @endcanany

          <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="py-3 border-t md:pr-2">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Status</div>
              <div id="view--display-status" class="flex gap-x-4">
                <div id="view--data-status" class="font-bold text-sm sm:text-base"></div>
                @can('update status requests')
                <button type="button" id="view--btn-show-select-status" class="link link-primary text-xs">Change
                  Status</button>
                @endcan
              </div>
              @can('update status requests')
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
              @endcan
            </div>
            @can('view customers')
            <div class="py-3 border-t md:pl-2">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Customer</div>
              <div>
                <span id="view--data-customer_name" class="font-bold text-sm sm:text-base"></span> <span
                  class="text-slate-400 text-sm">(<span id="view--data-cutomer_type"></span>)</span>
              </div>
            </div>
            @endcan
            @role('purchasing')
            <div class="py-3 border-t md:pl-2">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Sales</div>
              <div>
                <span id="view--data-salesman_name" class="font-bold text-sm sm:text-base"></span> <span
                  class="text-slate-400 text-sm">(<span id="view--data-salesman_whatsapp"></span>)</span>
              </div>
            </div>
            @endrole
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="py-3 border-t">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">No Request</div>
              <div id="view--data-request_code" class="font-bold text-sm sm:text-base"></div>
            </div>
            <div class="py-3 border-t">
              <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Tanggal Request</div>
              <div id="view--data-request_date" class="font-bold text-sm sm:text-base"></div>
            </div>
          </div>
          <div id="view-product_notes" class="py-3 border-t" style="display: none">
            <div class="font-semibold text-xs md:text-sm text-slate-400 uppercase sm:mb-1">Notes</div>
            <div id="view--data-notes" class="text-sm sm:text-base">
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
          let product_id = response.data.product.id;
          let product_name = response.data.product.name;
          let product_sku = response.data.product.sku;
          let product_brand = response.data.product.brand;
          let product_year = response.data.product.year;
          let product_cc = response.data.product.cc;
          let product_price_buy = response.data.product.price_buy;
          let product_price_resell = response.data.product.price_resell;
          let product_price_retail = response.data.product.price_retail;
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
          $("#view_product_id").val(product_id);
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
          if (product_price_buy) {
            $('#view--input-product_price_buy').val(Math.round(product_price_buy));
            $('#view--data-product_price_buy').html('Rp' + new Intl.NumberFormat('id-ID').format(product_price_buy)).show();
          }
          if (product_price_resell) {
            $('#view--input-product_price_resell').val(Math.round(product_price_resell));
            $('#view--data-product_price_resell').html('Rp' + new Intl.NumberFormat('id-ID').format(product_price_resell) + ' <span class="text-xs text-slate-500 font-normal"> (Harga Toko)</span>').show();
          }
          if (product_price_retail) {
            $('#view--input-product_price_retail').val(Math.round(product_price_retail));
            $('#view--data-product_price_retail').html('Rp' + new Intl.NumberFormat('id-ID').format(product_price_retail) + ' <span class="text-xs text-slate-500 font-normal">(Harga User)</span>').show();
          }
          if (notes) {
            $('#view--data-notes').text(notes);
          }
          $('#view-item-request').prop('checked', true);

        }
      });
    }
    // let item_request_id = '23001';
    // $("#view_item_id").val('23001');
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

    $(document).on("click", "#view--btn-show-update-product_buy_price", function(e) {
      e.preventDefault();
      $('#view--display-product_price_buy').hide();
      $('#view--update-product_price_buy').show();
      $('#view--input-product_price_buy').focus();
    });
    $(document).on("click", "#view--btn-cancel-update-product_price_buy", function(e) {
      e.preventDefault();
      $('#view--display-product_price_buy').show();
      $('#view--update-product_price_buy').hide();
    });
    $('#view--btn-submit-update-product_price_buy').click(function (e) {
      e.preventDefault();
      let view_product_id = $("#view_product_id").val();
      let product_price_buy = $('#view--input-product_price_buy').val();
      let token   = $("meta[name='csrf-token']").attr("content");
      //console.log(status_id);
      $.ajax({
        url: `/api/product/${view_product_id}`,
        type: "PUT",
        cache: false,
        data: {
          "action" : "update-price-buy",
          "price_buy": product_price_buy,
          "_token": token
        },
        success: function(response) {
          //$('#edit-item-request').prop('checked', false);
          window.location.href = "{{url('/item_request?status=item_request-edited')}}";
        },
        error: function(error) {
          console.log(error);
          if(error.responseJSON.price_buy) {
            $('#view--input-product_price_buy').addClass('input-error');
            $('#error_product_price_buy').text(error.responseJSON.price_buy).show();
          } else {
            $('#view--input-product_price_buy').removeClass('input-error');
            $('#error_product_price_buy').hide();
          }
        }
      });
    });

    $(document).on("click", "#view--btn-show-update-product_price_sell", function(e) {
      e.preventDefault();
      $('#view--display-product_price_sell').hide();
      $('#view--update-product_price_sell').show();
      $('#view--input-product_price_resell').focus();
    });
    $(document).on("click", "#view--btn-cancel-update-product_price_sell", function(e) {
      e.preventDefault();
      $('#view--display-product_price_sell').show();
      $('#view--update-product_price_sell').hide();
    });
    $('#view--btn-submit-update-product_price_sell').click(function (e) {
      e.preventDefault();
      let view_product_id = $("#view_product_id").val();
      let product_price_resell = $('#view--input-product_price_resell').val();
      let product_price_retail = $('#view--input-product_price_retail').val();
      let token   = $("meta[name='csrf-token']").attr("content");
      //console.log(status_id);
      $.ajax({
        url: `/api/product/${view_product_id}`,
        type: "PUT",
        cache: false,
        data: {
          "action" : "update-price-sell",
          "price_resell": product_price_resell,
          "price_retail": product_price_retail,
          "_token": token
        },
        success: function(response) {
          //$('#edit-item-request').prop('checked', false);
          window.location.href = "{{url('/item_request?status=item_request-edited')}}";
        },
        error: function(error) {
          console.log(error);
          if(error.responseJSON.price_resell) {
            $('#view--input-product_price_resell').addClass('input-error');
            $('#view--input-product_price_retail').addClass('input-error');
            $('#error_product_price_sell').text(error.responseJSON.price_resell).show();
          } else {
            $('#view--input-product_price_resell').removeClass('input-error');
            $('#view--input-product_price_retail').removeClass('input-error');
            $('#error_product_price_sell').hide();
          }
          if(error.responseJSON.price_retail) {
            $('#view--input-product_price_resell').addClass('input-error');
            $('#view--input-product_price_retail').addClass('input-error');
            $('#error_product_price_sell').text(error.responseJSON.price_retail).show();
          } else {
            $('#view--input-product_price_resell').removeClass('input-error');
            $('#view--input-product_price_retail').removeClass('input-error');
            $('#error_product_price_sell').hide();
          }
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