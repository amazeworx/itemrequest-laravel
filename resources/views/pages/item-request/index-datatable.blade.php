@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Item Requests') }}
      </h2>
      @can('create requests')
      <label for="create-item-request" class="btn btn-primary hidden md:inline-flex">{{ __('Add Item Request')
        }}</label>
      <div class="fixed right-4 bottom-4 z-30 md:hidden">
        <label for="create-item-request"
          class="btn btn-circle btn-primary btn-lg font-normal font-mono !text-3xl leading-none shadow-md">+</label>
      </div>
      @endcan
    </div>
  </x-slot>

  {{-- Main Content --}}
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
    $(function () {
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
      if (status == 'item_request-deleted') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Item Request berhasil dihapus',
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
      if (status == 'comment-created') {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          text: 'Berhasil menambahkan komentar',
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

  {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}
  @endpush
</x-app-layout>