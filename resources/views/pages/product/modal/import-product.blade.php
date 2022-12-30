<div class="import-product-modal">
  <input type="checkbox" id="import-product" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="import-product" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Import CSV Product') }}</h3>
        <div class="mt-6 space-y-4">
          <div>
            <input
              class="block w-full text-sm p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
              id="import_csv_file" type="file">
          </div>
          <div class="flex justify-between items-center">
            <div>
              <a href="/storage/sample_import_products.csv" class="text-xs link link-primary"
                download>sample_import_products.csv</a>
            </div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <label for="import-product" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
              <button id="btn-import-product" type="button" class="btn btn-primary">{{ __('Import') }}</button>
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
       * Import Product
       */
      //$('#import-product').prop('checked', true);
      $(document).on("click", "#btn-import-product", function(e) {
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
            url: `/api/import/product`,
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
              //console.log(response);
              $('#import-product').prop('checked', false);
              window.location.href = "{{url('/item_request?status=product-imported')}}";
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