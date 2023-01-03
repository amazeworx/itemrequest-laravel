@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Products') }}
      </h2>
      @can('create products')
      <label for="create-product" class="btn btn-primary hidden md:inline-flex">{{ __('Add Product')
        }}</label>
      <div class="fixed right-4 bottom-4 z-30 md:hidden">
        <label for="create-product"
          class="btn btn-circle btn-primary btn-lg font-normal font-mono !text-3xl leading-none shadow-md">+</label>
      </div>
      @endcan
    </div>
  </x-slot>

  <div class="pt-0 lg:pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow sm:rounded-lg">
        <div class="text-gray-900 px-4 py-4 sm:p-6">

          {{-- Table --}}
          {{ $dataTable->table() }}

        </div>
      </div>

    </div>
  </div>

  <input type="hidden" id="current_user_id" value="{{ $current_user_id }}" />

  {{-- Create Product Modal --}}
  @include('pages.product.modal.create-product')

  {{-- View Product Modal --}}
  @include('pages.product.modal.view-product')

  {{-- Edit Product Modal --}}
  @include('pages.product.modal.edit-product')

  {{-- Import Product Modal --}}
  @include('pages.product.modal.import-product')

  @push('scripts')
  <script type="text/javascript">
    jQuery(document).ready(function ($) {

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
      if (status == 'product-created') {
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
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "product");
        });
      }
      if (status == 'product-edited') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Produk berhasil diubah',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "product");
        });
      }
      if (status == 'product-deleted') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Produk berhasil dihapus',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "product");
        });
      }
      if (status == 'product-imported') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Produk berhasil diimport',
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000,
          iconColor: 'white',
          customClass: {
            popup: 'colored-toast'
          },
        }).then(function (e) {
          //console.log(e);
          window.history.replaceState({}, document.title, "/" + "product");
        });
      }

      /*
       * View Product
       */
      $(document).on("click", "#table-products tbody tr td:not(:last-child):not(.dtr-control)", function(e) {
        e.preventDefault();
        let product_id = $(this).closest('tr').attr("id");
        $("#view_product_id").val($(this).closest('tr').attr("id"));
        $.ajax({
          url: `api/product/${product_id}`,
          type: "GET",
          cache: false,
          success:function(response){
            //console.log(response);
            //open modal
            let product_id = response.data.id;
            let product_name = response.data.name;
            let product_sku = response.data.sku;
            let product_brand = response.data.brand;
            let product_year = response.data.year;
            let product_cc = response.data.cc;
            let product_engine = response.data.engine;
            let price_buy = response.data.price_buy;
            let price_resell = response.data.price_resell;
            let price_retail = response.data.price_retail;
            let notes = response.data.notes;
            let user = response.data.user.name;

            // view product
            $('#view_product_id').val(product_id);
            if (product_name) {
              $('#view-product_name').show();
              $('#view--data-product_name').text(product_name);
            }
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
            if (price_buy) {
              $('#view-price_buy').show();
              $('#view--data-price_buy').text(new Intl.NumberFormat('id-ID').format(price_buy));
            }
            if (price_resell) {
              $('#view-price_resell').show();
              $('#view--data-price_resell').text(new Intl.NumberFormat('id-ID').format(price_resell));
            }
            if (price_retail) {
              $('#view-price_retail').show();
              $('#view--data-price_retail').text(new Intl.NumberFormat('id-ID').format(price_retail));
            }
            if (notes) {
              $('#view-product_notes').show();
              $('#view--data-product_notes').text(notes);
            }
            $('#view-product').prop('checked', true);

            // edit product
            $('#edit_product_id').val(product_id);
            $('#edit_product_name').val(product_name);
            $('#edit_product_sku').val(product_sku);
            $('#edit_product_brand').val(product_brand);
            $('#edit_product_year').val(product_year);
            $('#edit_product_cc').val(product_cc);
            $('#edit_product_engine').val(product_engine);
            $('#edit_product_price_buy').val(price_buy);
            $('#edit_product_price_resell').val(price_resell);
            $('#edit_product_price_retail').val(price_retail);
            $('#edit_product_notes').val(notes);

          }
        });
      });

      /*
       * Edit Product
       */
      //$('#edit-product').prop('checked', true);
      $(document).on("click", "#btn-edit-product", function(e) {
        $('#view-product').prop('checked', false);
        $('#edit-product').prop('checked', true);
      });
      $(document).on("click", "#btn-cancel-edit-product", function(e) {
        $('#edit-product').prop('checked', false);
      });
      $(document).on("click", "#btn-submit-edit-product", function(e) {
        let product_id = $('#edit_product_id').val();
        let name = $('#edit_product_name').val();
        let sku = $('#edit_product_sku').val();
        let brand = $('#edit_product_brand').val();
        let year = $('#edit_product_year').val();
        let cc = $('#edit_product_cc').val();
        let engine = $('#edit_product_engine').val();
        let price_buy = $('#edit_product_price_buy').val();
        let price_resell = $('#edit_product_price_resell').val();
        let price_retail = $('#edit_product_price_retail').val();
        let notes = $('#edit_product_notes').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
          url: `api/product/${product_id}`,
          type: "PUT",
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
            "_token": token
          },
          success: function(response) {
            $('#edit-product').prop('checked', false);
            $('#edit_product_name').val('');
            $('#edit_product_sku').val('');
            $('#edit_product_brand').val('');
            $('#edit_product_cc').val('');
            $('#edit_product_engine').val('');
            $('#edit_product_price_buy').val('');
            $('#edit_product_price_resell').val('');
            $('#edit_product_price_retail').val('');
            $('#edit_product_notes').val('');
            window.location.href = "{{url('/product?status=product-edited')}}";
          },
          error: function(error) {
            //$('#edit-product-error-message').show();
            if(error.responseJSON.name) {
              $('#edit_product_name').addClass('input-error');
              $('#error_edit_product_name').text(error.responseJSON.name).show();
            } else {
              $('#edit_product_name').removeClass('input-error');
              $('#error_edit_product_name').hide();
            }
          }
        });
      });

      /*
       * Delete Product
       */
      $(document).on("click", "#btn-delete-product", function(e) {
        e.preventDefault();
        //console.log('clicked');
        const product_id = $('#view_product_id').val();
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
              url: "{{url('/api/product')}}/" + product_id,
              data: {_token: CSRF_TOKEN},
              dataType: 'JSON',
              success: function (results) {
                //console.log(results);
                window.location.href = "{{url('/product?status=product-deleted')}}";
              }
            });
          } else {
            e.dismiss;
          }
        }, function (dismiss) {
          return false;
        })
      });
    });
  </script>

  {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
  @endpush
</x-app-layout>