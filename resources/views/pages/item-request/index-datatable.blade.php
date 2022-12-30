@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Item Requests') }}
      </h2>
      @can('create requests')
      <label for="create-item-request" class="btn btn-primary">{{ __('Add Item Request') }}</label>
      @endcan
    </div>
  </x-slot>

  {{-- Main Content --}}
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="text-gray-900 dark:text-gray-100 p-6">

          {{-- Table --}}
          {{ $dataTable->table() }}

        </div>
      </div>
    </div>
  </div>

  {{-- Create Item Request Modal --}}
  @include('pages.item-request.modal.create-request')

  {{-- Create Product Modal --}}
  @include('pages.item-request.modal.create-product')

  {{-- Create Customer Modal --}}
  @include('pages.item-request.modal.create-customer')

  {{-- View Modal --}}
  @include('pages.item-request.modal.view-request')

  {{-- Edit Modal --}}
  @include('pages.item-request.modal.edit-request')

  {{-- Import Modal --}}
  @include('pages.item-request.modal.import-request')

  @push('scripts')

  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      /*
       * Import Item Request
       */
      //$('#import-item-request').prop('checked', true);
      $(document).on("click", "#btn-import-item-request", function(e) {
        let import_csv_file = $('#import_csv_file')[0].files;
        if (import_csv_file.length > 0) {
          let token   = $("meta[name='csrf-token']").attr("content");

          var fd = new FormData()

          // Append data
          fd.append("file", import_csv_file[0])
          fd.append("_token", token)

          $.ajax({
            url: `/api/import/item_request`,
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
              console.log(response);
              $('#import-item-request').prop('checked', false);
              window.location.href = "{{url('/item_request?status=item_request-imported')}}";
            },
            error: function(response) {
              console.log("error : " + JSON.stringify(response))
            }
          });
        } else {
          alert("Please select a file.")
        }

      });

      /*
       * Load Select Options
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

      /*
       * Helpers
       */
      function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split("&"),
          sParameterName,
          i

        for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split("=")

          if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined
              ? true
              : decodeURIComponent(sParameterName[1])
          }
        }
        return false
      }

      /*
       * Show toast on status
       */
      let status = getUrlParameter('status');
      //console.log('Status:', status);
      if (status == 'item_request-created') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Item Request berhasil dibuat',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "item_request");
        });
      }
      if (status == 'item_request-edited') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Item Request berhasil diubah',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "item_request");
        });
      }
      if (status == 'item_request-imported') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Item Request berhasil diimport',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "item_request");
        });
      }

      /*
       * Create Item Request
       */
      //$('#create-item-request').prop('checked', true);

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
            $('#create-product-error-message').show();
            if(error.responseJSON.name) {
              $('#create_product_name').addClass('input-error');
            } else {
              $('#create_product_name').removeClass('input-error');
            }
          }
        });
      });

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
            $('#create-customer-error-message').show();
            if(error.responseJSON.name) {
              $('#create_customer_name').addClass('input-error');
            } else {
              $('#create_customer_name').removeClass('input-error');
            }
          }
        });
      });

      //  Submit Item Request
      $(document).on("click", "#btn-submit-item-request", function(e) {
        let request_date = $('#create_request_date').val().split("-").reverse().join("-");
        let salesman_id = $('#create_salesman_id').val();
        let customer_id = $('#create_customer_id').val();
        let product_id = $('#create_product_id').val();
        let status_id = $('#create_status_id').val();
        let notes = $('#create_notes').val();
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
            "notes": notes,
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
            $('#create-form-error-message').show();
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

      /*
       * View Item Request
       */
      $(document).on("click", "#table-item-request tbody tr td:not(:last-child):not(.dtr-control)", function(e) {
        e.preventDefault();
        let item_request_id = $(this).closest('tr').attr("id");
        $("#view_item_id").val($(this).closest('tr').attr("id"));
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

      /*
       * Fetch Edit Item Request
       */
      $(document).on("click", ".edit_item_request", function(e) {
        e.preventDefault();
        let item_request_id = $(this).data("id");

        //fetch detail item request with ajax
        $.ajax({
          url: `api/item_request/${item_request_id}`,
          type: "GET",
          cache: false,
          success:function(response){
            //fill data to form
            //console.log(response);
            $('#edit_item_id').val(response.data.id);
            let request_date = response.data.request_date.split(' ')[0];
            let request_date_reverse = request_date.split("-").reverse().join("-")
            $('#edit_request_date').val(request_date_reverse);
            $('#edit_user_id').val(response.data.user.id);
            $('#edit_salesman_id').val(response.data.salesman.id);
            $('#edit_customer_id').val(response.data.customer.id);
            $('#edit_product_id').val(response.data.product.id);
            $('#edit_notes').val(response.data.notes);
            $('#edit_status_id').val(response.data.status.id);

            //open modal
            $('#edit-item-request').prop('checked', true);

          }
        });
      });

      /*
       * Submit Edit Item Request
       */
      $(document).on("click", "#btn-edit-item-request", function(e) {
        e.preventDefault();

        let edit_item_id = $('#edit_item_id').val();
        let request_date = $('#edit_request_date').val().split("-").reverse().join("-");
        let salesman_id = $('#edit_salesman_id').val();
        let customer_id = $('#edit_customer_id').val();
        let product_id = $('#edit_product_id').val();
        let status_id = $('#edit_status_id').val();
        let notes = $('#edit_notes').val();
        let user_id = $('#edit_user_id').val();
        let token   = $("meta[name='csrf-token']").attr("content");

        $.ajax({
          url: `/api/item_request/${edit_item_id}`,
          type: "PUT",
          cache: false,
          data: {
            "request_date": request_date,
            "salesman_id": salesman_id,
            "customer_id": customer_id,
            "product_id": product_id,
            "status_id": status_id,
            "notes": notes,
            "user_id": user_id,
            "_token": token
          },
          success: function(response) {
            $('#edit-item-request').prop('checked', false);
            window.location.href = "{{url('/item_request?status=item_request-edited')}}";
          },
          error: function(error) {
            //...
            //console.log(error);
            $('#edit-form-error-message').show();
            if(error.responseJSON.product_id) {
              $('#edit_product_id').addClass('select-error');
            } else {
              $('#edit_product_id').removeClass('select-error');
            }
            if(error.responseJSON.customer_id) {
              $('#edit_customer_id').addClass('select-error');
            } else {
              $('#edit_customer_id').removeClass('select-error');
            }
          }
        });

      });

      /*
       * Delete Item Request
       */
      $(document).on("click", ".delete_item_request", function(e) {
        e.preventDefault();
        //console.log('clicked');
        let item_request_id = $(this).data("id");
        //console.log(item_request_id);
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
        }).then(function (e) {
          //console.log(e);
          if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
              type: 'DELETE',
              url: `/api/item_request/` + item_request_id,
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
                $('#table-item-request #row-' + item_request_id).remove();
                Swal.fire({
                  toast: true,
                  position: 'center',
                  icon: 'success',
                  text: 'Item Request berhasil dihapus',
                  showConfirmButton: false,
                  timerProgressBar: true,
                  timer: 3000,
                  iconColor: 'white',
                  customClass: {
                    popup: 'colored-toast'
                  },
                })
              }
            });
          } else {
            e.dismiss;
          }
        });
      });

    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  @endpush
</x-app-layout>