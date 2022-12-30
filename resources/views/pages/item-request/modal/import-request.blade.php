<div class="import-modal">
  <input type="checkbox" id="import-item-request" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="import-item-request" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Import CSV Item Request') }}</h3>
        <div class="mt-6 space-y-4">
          <div>
            <input
              class="block w-full text-sm p-2 text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
              id="import_csv_file" type="file">
          </div>
          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <label for="import-item-request" class="btn btn-ghost hover:bg-slate-200">{{ __('Cancel') }}</label>
              <button id="btn-import-item-request" type="button" class="btn btn-primary">{{ __('Import') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>