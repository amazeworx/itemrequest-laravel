<div class="edit-user-modal">
  <input type="checkbox" id="edit-user" class="modal-toggle" />
  <div class="modal modal-bottom md:modal-middle z-40">
    <div class="modal-box p-0 relative">
      <label for="edit-user" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-4 sm:p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Edit User') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="edit-user-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="edit_user_id" />

          <div>
            <x-input-label for="edit_user_name" :value="__('Nama')" />
            <x-forms.text-input id="edit_user_name" type="text" class="mt-1 block w-full" />
            <x-forms.input-error id="error_edit_user_name"></x-forms.input-error>
          </div>

          <div>
            <x-input-label for="edit_user_email" :value="__('Email')" />
            <x-forms.text-input id="edit_user_email" type="email" class="mt-1 block w-full" />
            <div id="error_edit_user_email" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="edit_user_username" :value="__('Username')" />
            <x-forms.text-input id="edit_user_username" type="text" class="mt-1 block w-full" />
            <div id="error_edit_user_username" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="edit_user_whatsapp" :value="__('WhatsApp')" />
            <x-forms.text-input id="edit_user_whatsapp" type="number" class="mt-1 block w-full" />
            <div id="error_edit_user_whatsapp" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div class="mt-4">
            <x-input-label for="edit_user_role" :value="__('Role')" />
            <x-forms.select id="edit_user_role" class="block mt-1 w-full">
              <option value="" disabled selected>-- Select Role --</option>
              <option value="2">Sales</option>
              <option value="3">Purchasing</option>
              <option value="1">Super Admin</option>
            </x-forms.select>
            <div id="error_edit_user_role" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div class="mt-4">
            <x-input-label for="edit_user_status" :value="__('Status')" />
            <x-forms.select id="edit_user_status" class="block mt-1 w-full">
              <option value="" disabled selected>-- Select Status --</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </x-forms.select>
            <div id="error_edit_user_status" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="edit_password" :value="__('Password')" />
            <x-forms.text-input id="edit_password" class="block mt-1 w-full" type="password" />
            <div id="error_password" class="text-xs text-red-500 mt-1" style="display:none"></div>
            <div id="error_edit_password" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="edit_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="edit_password_confirmation" class="block mt-1 w-full" type="password" />
          </div>

          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <button id="btn-cancel-edit-user" type="button" class="btn btn-ghost hover:bg-slate-200">{{
                __('Cancel') }}</button>
              <button id="btn-submit-edit-user" type="button" class="btn btn-primary">{{ __('Save')
                }}</button>
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
    $(document).on("click", "#btn-edit-user", function(e) {
      $('#view-user').prop('checked', false);
      $('#edit-user').prop('checked', true);
      $('#edit_user_name').removeClass('input-error');
      $('#edit_user_email').removeClass('input-error');
      $('#edit_user_username').removeClass('input-error');
      $('#edit_user_whatsapp').removeClass('input-error');
      $('#edit_user_role').removeClass('input-error');
      $('#edit_password').removeClass('input-error');
    });
    $(document).on("click", "#btn-cancel-edit-user", function(e) {
      $('#edit-user').prop('checked', false);
    });
    $(document).on("click", "#btn-submit-edit-user", function(e) {
      let user_id = $('#edit_user_id').val();
      console.log(user_id);
      let name = $('#edit_user_name').val();
      let email = $('#edit_user_email').val();
      let username = $('#edit_user_username').val();
      let whatsapp = $('#edit_user_whatsapp').val();
      let role = $('#edit_user_role').val();
      let status = $('#edit_user_status').val();
      let password = $('#edit_password').val();
      let password_confirmation = $('#edit_password_confirmation').val();
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
        url: `/api/user/${user_id}`,
        type: "PUT",
        cache: false,
        data: {
          "name": name,
          "email": email,
          "username": username,
          "whatsapp": whatsapp,
          "role": role,
          "active": status,
          "password": password,
          "password_confirmation": password_confirmation,
          "_token": token
        },
        success: function(response) {
          $('#edit-user').prop('checked', false);
          $('#edit_user_name').removeClass('input-error');
          $('#edit_user_email').removeClass('input-error');
          $('#edit_user_username').removeClass('input-error');
          $('#edit_user_whatsapp').removeClass('input-error');
          $('#edit_user_role').removeClass('input-error');
          $('#edit_password').removeClass('input-error');
          $('#table-users').DataTable().ajax.reload();
          //console.log(response);
          //window.location.href = "{{url('/user?status=user-edited')}}";
        },
        error: function(error) {
          //...
          console.log(error);
          //$('#edit-user-error-message').show();
          if(error.responseJSON.name) {
            $('#edit_user_name').addClass('input-error');
            $('#error_edit_user_name').text(error.responseJSON.name).show();
          } else {
            $('#edit_user_name').removeClass('input-error');
            $('#error_edit_user_name').hide();
          }
          if(error.responseJSON.email) {
            $('#edit_user_email').addClass('input-error');
            $('#error_edit_user_email').text(error.responseJSON.email).show();
          } else {
            $('#edit_user_email').removeClass('input-error');
            $('#error_edit_user_email').hide();
          }
          if(error.responseJSON.username) {
            $('#edit_user_username').addClass('input-error');
            $('#error_edit_user_username').text(error.responseJSON.username).show();
          } else {
            $('#edit_user_username').removeClass('input-error');
            $('#error_edit_user_username').hide();
          }
          if(error.responseJSON.role) {
            $('#edit_user_role').addClass('input-error');
            $('#error_edit_user_role').text(error.responseJSON.role).show();
          } else {
            $('#edit_user_role').removeClass('input-error');
            $('#error_edit_user_role').hide();
          }
          if(error.responseJSON.password) {
            $('#edit_password').addClass('input-error');
            $('#error_edit_password').text(error.responseJSON.password).show();
          } else {
            $('#password').removeClass('input-error');
            $('#error_edit_password').hide();
          }
        }
      });
    });
  });
</script>
@endpush