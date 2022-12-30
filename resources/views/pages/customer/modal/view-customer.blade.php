<div class="view-customer-modal">
  <input type="checkbox" id="view-customer" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="view-customer" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">

        <div class="flex gap-x-4 items-baseline mb-4">
          <h3 class="text-xl font-medium text-gray-900">{{ __('Customer Detail') }}</h3>
        </div>

        <input type="hidden" id="view_customer_id">

        <div>
          <div id="view-name" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Nama Customer</div>
              <div id="view--data-name" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-phone" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Phone</div>
              <div id="view--data-phone" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-customer_type" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Tipe</div>
              <div id="view--data-customer_type" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-current_salesman" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Sales Sekarang</div>
              <div id="view--data-current_salesman" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-previous_salesman" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Sales Sebelumnya</div>
              <div id="view--data-previous_salesman" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-existing" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Langganan</div>
              <div id="view--data-existing" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-notes" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Catatan</div>
              <div id="view--data-notes" class="w-2/3"></div>
            </div>
          </div>

          <div id="view-user" style="display: none">
            <div class="flex gap-x-4 py-2 border-b">
              <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Created by</div>
              <div id="view--data-user" class="w-2/3"></div>
            </div>
          </div>

        </div>

        @canany('edit customers|delete customers')
        <div>
          <div class="flex justify-end items-center gap-2 pt-2 mt-4">
            @can('edit customers')
            <button id="btn-edit-customer" type="button" class="btn btn-sm btn-outline btn-primary">{{
              __('Edit')
              }}</button>
            @endcan
            @can('delete customers')
            <button id="btn-delete-customer" type="button" class="btn btn-sm btn-ghost hover:bg-slate-200">{{
              __('Delete') }}</button>
            @endcan
          </div>
        </div>
        @endcanany

      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  jQuery(document).ready(function ($) {
    /*
     * View Customer
     */
    $(document).on("click", "#table-customers tbody tr td:not(:last-child):not(.dtr-control)", function(e) {
      e.preventDefault();
      let customer_id = $(this).closest('tr').attr("id");
      $("#view_customer_id").val($(this).closest('tr').attr("id"));
      $.ajax({
        url: `api/customer/${customer_id}`,
        type: "GET",
        cache: false,
        success:function(response){
          console.log(response);
          //open modal
          let customer_id = response.data.id;
          let name = response.data.name;
          let phone = response.data.phone;
          let existing = response.data.existing;
          let customer_type_id = response.data.customer_type.id;
          let customer_type = response.data.customer_type.name;
          let current_salesman_id = response.data.current_salesman.id;
          let current_salesman = response.data.current_salesman.name;
          let previous_salesman = response.data.previous_salesman;
          let notes = response.data.notes;
          let user = response.data.user.name;

          // view product
          $('#view_customer_id').val(customer_id);
          if (name) {
            $('#view-name').show();
            $('#view--data-name').text(name);
          }
          if (phone) {
            $('#view-phone').show();
            $('#view--data-phone').text(phone);
          }
          if (customer_type) {
            $('#view-customer_type').show();
            $('#view--data-customer_type').text(customer_type);
          }
          if (existing != 'NULL') {
            if (existing == 1) {
              existing_text = 'Ya'
            } else {
              existing_text = 'Tidak';
            }
            $('#view-existing').show();
            $('#view--data-existing').text(existing_text);
          }
          if (current_salesman) {
            $('#view-current_salesman').show();
            $('#view--data-current_salesman').text(current_salesman);
          }
          if (previous_salesman) {
            $('#view-previous_salesman').show();
            $('#view--data-previous_salesman').text(previous_salesman);
          }
          if (notes) {
            $('#view-notes').show();
            $('#view--data-notes').text(notes);
          }
          // if (user) {
          //   $('#view-user').show();
          //   $('#view--data-user').text(user);
          // }
          $('#view-customer').prop('checked', true);

          // edit customer
          $('#edit_customer_id').val(customer_id);
          $('#edit_customer_name').val(name);
          $('#edit_customer_phone').val(phone);
          //$('#edit_customer_type').val(customer_type);
          $("input[name=edit_customer_type_id][value='" + customer_type_id + "']").prop("checked",true);
          //$('#edit_customer_existing').val(existing);
          $("input[name=edit_customer_existing][value='" + existing + "']").prop("checked",true);
          $('#edit_customer_salesman_current').val(current_salesman_id);
          $('#edit_customer_salesman_previous').val(previous_salesman);
          $('#edit_customer_notes').val(notes);

        }
      });
    });

    /*
      * Delete Customer
      */
    $(document).on("click", "#btn-delete-customer", function(e) {
      e.preventDefault();
      //console.log('clicked');
      const customer_id = $('#view_customer_id').val();
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
            url: "{{url('/api/customer')}}/" + customer_id,
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (results) {
              //console.log(results);
              window.location.href = "{{url('/customer?status=customer-deleted')}}";
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

@endpush