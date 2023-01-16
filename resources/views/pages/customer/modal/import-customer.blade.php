<div class="import-customer-modal">
  <input type="checkbox" id="import-customer" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative">
      <label for="import-customer" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Import CSV customer') }}</h3>
        <div class="mt-6 space-y-4">
          <div>
            <input
              class="block w-full text-sm p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
              id="import_csv_file" type="file">
            <div class="mt-1">
              <a href="/storage/sample_import_customers.csv" class="text-xs link link-primary"
                download>sample_import_customers.csv</a>
            </div>
          </div>

          <div class="flex justify-end items-center">
            <div class="flex justify-end items-center gap-2 pt-2">
              <label for="import-customer" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
              <button id="btn-import-customer" type="button" class="btn btn-primary">{{ __('Import') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  jQuery(document).ready(function ($) {
      /*
       * Import customer
       */
      //$('#import-customer').prop('checked', true);
      $(document).on("click", "#btn-import-customer", function(e) {
        let import_csv_file = $('#import_csv_file')[0].files;
        if (import_csv_file.length > 0) {
          let token   = $("meta[name='csrf-token']").attr("content");
          let user_id = $('#current_user_id').val();

          var fd = new FormData()
          // Append data
          fd.append("file", import_csv_file[0])
          fd.append("user_id", user_id)
          fd.append("_token", token)

          $.ajax({
            url: `/api/import/customer`,
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
              //console.log(response);
              $('#import-customer').prop('checked', false);
              window.location.href = "{{url('/customer?status=customer-imported')}}";
            },
            error: function(response) {
              console.log("error : " + JSON.stringify(response))
            }
          });
        } else {
          alert("Please select a file.")
        }

      });
    });
</script>
@endpush