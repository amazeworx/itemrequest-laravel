@php
$current_user_id = auth()->user()->id;
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Item Request') }}
      </h2>
      <label for="create-item-request" class="btn btn-primary">{{ __('Add Item Request') }}</label>
    </div>
  </x-slot>

  {{-- Main Content --}}
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="text-gray-900 dark:text-gray-100 p-6">

          {{-- Table --}}
          <table id="table-item-request"
            class="table table-compact w-full [&>thead>tr>th]:px-3 [&>thead>tr>th]:py-3 [&>tbody>tr>td]:px-3 [&>tbody>tr>td]:py-2.5">
            <thead class="[&>tr>th]:bg-white [&>tr>th]:border-b-2 [&>tr>th]:border-gray-200 [&>tr>th]:text-xs">
              <tr>
                <th scope="col">
                  Tanggal
                </th>
                <th scope="col">
                  No Request
                </th>
                <th scope="col">
                  Nama Barang
                </th>
                <th scope="col">
                  Customer
                </th>
                <th scope="col">
                  Sales
                </th>
                <th scope="col">
                  Status
                </th>
                <th scope="col">
                  <span class="sr-only">Action</span>
                </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>

  {{-- Modal --}}
  <div class="create-modal">
    <input type="checkbox" id="create-item-request" class="modal-toggle" />
    <div class="modal z-40">
      <div class="modal-box p-0 relative">
        <label for="create-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
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
              <x-forms.input-label for="create_product_id" :value="__('Tanggal')" />
              <x-flat-pickr id="create_request_date" name="create_request_date" value="{{ date('d-m-Y') }}"
                format="dd-mm-yyyy"
                :options="['enableTime' => 'false', 'dateFormat' => 'd-m-Y', 'altFormat' => 'd-m-Y', 'time_24hr' => 'true']" />
            </div>

            <div>
              <x-forms.input-label for="create_product_id" :value="__('Nama Barang')" />
              <x-forms.select id="create_product_id">
                <option value="" disabled selected>Select</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-forms.input-label for="create_customer_id" :value="__('Customer')" />
              <x-forms.select id="create_customer_id">
                <option value="" disabled selected>Select</option>
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
              </x-forms.select>
            </div>

            <div>
              <x-forms.input-label for="create_notes" :value="__('Catatan')" />
              <x-forms.text-area id="create_notes" rows="4" class="text-sm" />
            </div>

            <div>
              <div class="flex items-center gap-2">
                <button id="btn-submit-item-request" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
                <label for="create-item-request" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

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
                    <button type="button" id="view--btn-cancel-update-status"
                      class="btn btn-ghost btn-sm">Cancel</button>
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

  <div class="edit-modal">
    <input type="checkbox" id="edit-item-request" class="modal-toggle" />
    <div class="modal z-40">
      <div class="modal-box p-0 relative">
        <label for="edit-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
        <div class="p-6">
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
              <div class="flex items-center gap-2">
                <button id="btn-edit-item-request" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
                <label for="edit-item-request" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
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
       * Generate DataTable
       */
      var table = $('#table-item-request').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ url()->current() }}',
        //sScrollX: "100%",
        columns: [
          { data: 'request_date', name: 'request_date' },
          { data: 'request_code', name: 'request_code' },
          { data: 'product', name: 'product.name' },
          { data: 'customer', name: 'customer.name' },
          { data: 'salesman', name: 'salesman.name' },
          { data: 'status', name: 'status.name' },
          {
              data: 'action',
              name: 'action',
              orderable: true,
              searchable: true
          },
        ],
        dom: 'Bfrtip',
        buttons: [
          'excel',
        ]
      });

      /*
       * Show toast on status
       */
      let status = getUrlParameter('status');
      //console.log('Status:', status);
      if (status == 'item_request-created') {
        Swal.fire({
          toast: true,
          position: 'center',
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
          position: 'center',
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

      /*
       * Submit Item Request
       */
      $('#btn-submit-item-request').click(function(e) {
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
  @endpush
</x-app-layout>