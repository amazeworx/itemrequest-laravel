<div class="create-request-modal">
  <input type="checkbox" id="create-item-request" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative">
      <label for="create-item-request" class="btn btn-sm btn-circle absolute right-2 top-2 z-50">✕</label>
      <div id="create-item-request-form" class="relative">
        <div class="p-4 sm:p-6">
          <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New Item Request') }}</h3>
          <div class="mt-6 space-y-4">

            {{-- <div id="create-form-error-message" class="hidden">
              <div class="inline-flex space-x-2 items-center text-xs text-error">
                <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
                <span class="inline-block">Wajib diisi</span>
              </div>
            </div> --}}

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
              <x-forms.input-label for="create_comment" :value="__('Comment')" />
              <x-forms.text-area id="create_comment" rows="4" class="text-sm" />
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

@push('scripts')
<script type="text/javascript">
  $(function () {
    /*
     * Create Item Request
     */
    // Load Select Product Options
    var $create_product_id = $('#create_product_id').selectize({
      maxItems: 1,
      valueField: 'id',
      labelField: 'name',
      searchField: 'name',
      options: [],
      create: false
    });
    var create_product_id = $create_product_id[0].selectize;
    const getProductOptions = () => {
      $.ajax({
        url: `/api/product`,
        type: "GET",
        cache: false,
        success: function(response) {
          //resolve(response);
          //console.log(response)
          create_product_id.addOption(response);
        },
        error: function(error) {
          //reject(error);
          console.log(error)
        }
      });
    };
    getProductOptions();
    // Create Product
    //$('#create-product').prop('checked', true);
    $(document).on("click", "#create-product-btn", function(e) {
      $('#create-item-request').prop('checked', false);
      $('#create-product').prop('checked', true);
    });
    $(document).on("click", "#btn-cancel-create-product", function(e) {
      $('#create-product').prop('checked', false);
      $('#create-item-request').prop('checked', true);
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
          create_product_id.addOption({
            id: response.data.id,
            name: response.data.name,
          });
          create_product_id.setValue(response.data.id);
          setTimeout(() => {
            $('#create-product').prop('checked', false);
            $('#create-item-request').prop('checked', true);
            $('#create_product_name').val('');
            $('#create_product_sku').val('');
            $('#create_product_brand').val('');
            $('#create_product_cc').val('');
            $('#create_product_engine').val('');
            $('#create_product_price_buy').val('');
            $('#create_product_price_resell').val('');
            $('#create_product_price_retail').val('');
            $('#create_product_notes').val('');
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              text: 'Produk berhasil dibuat',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
            });
          }, 500);

        },
        error: function(error) {
          console.log(error);
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

    // Load Select Customer Options
    var $create_customer_id = $('#create_customer_id').selectize({
      maxItems: 1,
      valueField: 'id',
      labelField: 'name',
      searchField: 'name',
      options: [],
      create: false
    });
    var create_customer_id = $create_customer_id[0].selectize;
    const getCustomerOptions = () => {
      $.ajax({
        url: `/api/customer`,
        type: "GET",
        cache: false,
        success: function(response) {
          //resolve(response);
          //console.log(response)
          create_customer_id.addOption(response);
        },
        error: function(error) {
          //reject(error);
          console.log(error)
        }
      });
    };
    getCustomerOptions();
    // Create Customer
    //$('#create-customer').prop('checked', true);
    $(document).on("click", "#create-customer-btn", function(e) {
      $('#create-item-request').prop('checked', false);
      $('#create-customer').prop('checked', true);
    });
    $(document).on("click", "#btn-cancel-create-customer", function(e) {
      $('#create-customer').prop('checked', false);
      $('#create-item-request').prop('checked', true);
    });
    if ($("#create_customer_existing-true").is(':checked')) {
      $("#create_customer_salesman_previous_container").show();
    } else {
      $("#create_customer_salesman_previous").val('');
      $("#create_customer_salesman_previous_container").hide();
    }
    $("input[name=create_customer_existing]").change(function() {
      if ($("#create_customer_existing-true").is(':checked')) {
        $("#create_customer_salesman_previous_container").show();
      } else {
        $("#create_customer_salesman_previous").val('');
        $("#create_customer_salesman_previous_container").hide();
      }
    });
    $(document).on("click", "#btn-submit-create-customer", function(e) {
      let name = $('#create_customer_name').val();
      let phone = $('#create_customer_phone').val();
      let customer_type_id = $('input[name="create_customer_type_id"]:checked').val();
      let existing = $('input[name="create_customer_existing"]:checked').val();
      let current_salesman_id = $('#create_customer_salesman_current').val();
      let previous_salesman_id = $('#create_customer_salesman_previous').val();
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
          "previous_salesman_id": previous_salesman_id,
          "notes": notes,
          "user_id": user_id,
          "_token": token
        },
        success: function(response) {
          create_customer_id.addOption({
            id: response.data.id,
            name: response.data.name,
          });
          create_customer_id.setValue(response.data.id);
          setTimeout(() => {
            $('#create-customer').prop('checked', false);
            $('#create-item-request').prop('checked', true);
            $('#create_customer_name').val('');
            $('#create_customer_phone').val('');
            $('#create_customer_type-option-1').prop("checked", true);
            $('#create_customer_existing-false').prop("checked", true);
            $('#create_customer_salesman_current').val(user_id);
            $('#create_customer_salesman_previous').val('');
            $('#create_customer_notes').val('');
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              text: 'Customer berhasil dibuat',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
              iconColor: 'white',
              customClass: {
                popup: 'colored-toast'
              },
            });
          }, 500);
        },
        error: function(error) {
          //...
          //console.log(error);
          //$('#create-customer-error-message').show();
          if(error.responseJSON.name) {
            $('#create_customer_name').addClass('input-error');
            $('#error_create_customer_name').text(error.responseJSON.name).show();
          } else {
            $('#create_customer_name').removeClass('input-error');
            $('#error_create_customer_name').hide();
          }
          if(error.responseJSON.phone) {
            $('#create_customer_phone').addClass('input-error');
            $('#error_create_customer_phone').text(error.responseJSON.phone).show();
          } else {
            $('#create_customer_phone').removeClass('input-error');
            $('#error_create_customer_phone').hide();
          }
          if(error.responseJSON.current_salesman_id) {
            $('#create_customer_salesman_current').addClass('input-error');
            $('#error_create_customer_salesman_current').text(error.responseJSON.current_salesman_id).show();
          } else {
            $('#create_customer_salesman_current').removeClass('input-error');
            $('#error_create_customer_salesman_current').hide();
          }
          if(error.responseJSON.previous_salesman) {
            $('#create_customer_salesman_previous').addClass('input-error');
            $('#error_create_customer_salesman_previous').text(error.responseJSON.previous_salesman).show();
          } else {
            $('#create_customer_salesman_previous').removeClass('input-error');
            $('#error_create_customer_salesman_previous').hide();
          }
        }
      });
    });

    //$('#create-item-request').prop('checked', true);
    //  Submit Item Request
    $(document).on("click", "#btn-submit-item-request", function(e) {
      let request_date = $('#create_request_date').val().split("-").reverse().join("-");
      let salesman_id = $('#create_salesman_id').val();
      let customer_id = $('#create_customer_id').val();
      let product_id = $('#create_product_id').val();
      let status_id = $('#create_status_id').val();
      let comment = $('#create_comment').val();
      let user_id = $('#create_user_id').val();
      let token   = $("meta[name='csrf-token']").attr("content");
      //console.log(request_date);
      //return;
      $.ajax({
        url: `/api/item_request`,
        type: "POST",
        cache: false,
        data: {
          "request_date": request_date,
          "salesman_id": salesman_id,
          "customer_id": customer_id,
          "product_id": product_id,
          "status_id": status_id,
          "comment": comment,
          "user_id": user_id,
          "_token": token
        },
        success: function(response) {
          $('#create-item-request').prop('checked', false);
          window.location.href = "{{url('/item_request?status=item_request-created')}}";
        },
        error: function(error) {
          //...
          //console.log(error);
          //$('#create-form-error-message').show();
          if(error.responseJSON.product_id) {
            $('#create_product_id').addClass('select-error');
          } else {
            $('#create_product_id').removeClass('select-error');
          }
          if(error.responseJSON.customer_id) {
            $('#create_customer_id').addClass('select-error');
          } else {
            $('#create_customer_id').removeClass('select-error');
          }
        }
      });
    });
  });
</script>

@endpush