<div class="create-user-modal">
  <input type="checkbox" id="create-user" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="create-user" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">
        <h3 class="mb-4 text-xl font-medium text-gray-900">{{ __('Add New User') }}</h3>
        <div class="mt-6 space-y-4">

          <div id="create-user-error-message" class="hidden">
            <div class="inline-flex space-x-2 items-center text-xs text-error">
              <span class="flex-none inline-block w-5 h-3 rounded border border-solid border-error"></span>
              <span class="inline-block">Wajib diisi</span>
            </div>
          </div>

          <input type="hidden" id="create_user_id" value="{{ $current_user_id }}" />

          <div>
            <x-input-label for="create_user_name" :value="__('Nama')" />
            <x-forms.text-input id="create_user_name" type="text" class="mt-1 block w-full" />
            <x-forms.input-error id="error_create_user_name"></x-forms.input-error>
          </div>

          <div>
            <x-input-label for="create_user_email" :value="__('Email')" />
            <x-forms.text-input id="create_user_email" type="email" class="mt-1 block w-full" />
            <div id="error_create_user_email" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="create_user_username" :value="__('Username')" />
            <x-forms.text-input id="create_user_username" type="text" class="mt-1 block w-full" />
            <div id="error_create_user_username" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="create_user_whatsapp" :value="__('WhatsApp')" />
            <x-forms.text-input id="create_user_whatsapp" type="number" class="mt-1 block w-full" />
            <div id="error_create_user_whatsapp" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div class="mt-4">
            <x-input-label for="create_user_role" :value="__('Role')" />
            <x-forms.select id="create_user_role" class="block mt-1 w-full">
              <option value="" disabled selected>-- Select Role --</option>
              <option value="2">Sales</option>
              <option value="3">Purchasing</option>
              <option value="1">Super Admin</option>
            </x-forms.select>
            <div id="error_create_user_role" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-forms.text-input id="password" class="block mt-1 w-full" type="password" />
            <div id="error_password" class="text-xs text-red-500 mt-1" style="display:none"></div>
          </div>

          <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" />
          </div>

          <div>
            <div class="flex justify-end items-center gap-2 pt-2">
              <button id="btn-cancel-create-user" type="button" class="btn btn-ghost hover:bg-slate-200">{{
                __('Cancel') }}</button>
              <button id="btn-submit-create-user" type="button" class="btn btn-primary">{{ __('Add User')
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
    $(document).on("click", "#btn-cancel-create-user", function(e) {
      $('#create-user').prop('checked', false);
    });
    $(document).on("click", "#btn-submit-create-user", function(e) {
      $('#create_user_name').removeClass('input-error');
      $('#create_user_email').removeClass('input-error');
      $('#create_user_username').removeClass('input-error');
      $('#create_user_whatsapp').removeClass('input-error');
      $('#password').removeClass('input-error');
      $('#create_user_role').removeClass('input-error');

      let name = $('#create_user_name').val();
      let email = $('#create_user_email').val();
      let username = $('#create_user_username').val();
      let whatsapp = $('#create_user_whatsapp').val();
      let password = $('#password').val();
      let password_confirmation = $('#password_confirmation').val();
      let role = $('#create_user_role').val();
      let active = 1;
      let token   = $("meta[name='csrf-token']").attr("content");

      $.ajax({
        url: `/api/user`,
        type: "POST",
        cache: false,
        data: {
          "name": name,
          "email": email,
          "username": username,
          "whatsapp": whatsapp,
          "password": password,
          "password_confirmation": password_confirmation,
          "role": role,
          "active": active,
          "_token": token
        },
        success: function(response) {
          $('#create-user').prop('checked', false);
          window.location.href = "{{url('/user?status=user-created')}}";
        },
        error: function(error) {
          //...
          console.log(error);
          //$('#create-user-error-message').show();
          if(error.responseJSON.name) {
            $('#create_user_name').addClass('input-error');
            $('#error_create_user_name').text(error.responseJSON.name).show();
          } else {
            $('#create_user_name').removeClass('input-error');
            $('#error_create_user_name').hide();
          }
          if(error.responseJSON.email) {
            $('#create_user_email').addClass('input-error');
            $('#error_create_user_email').text(error.responseJSON.email).show();
          } else {
            $('#create_user_email').removeClass('input-error');
            $('#error_create_user_email').hide();
          }
          if(error.responseJSON.username) {
            $('#create_user_username').addClass('input-error');
            $('#error_create_user_username').text(error.responseJSON.username).show();
          } else {
            $('#create_user_username').removeClass('input-error');
            $('#error_create_user_username').hide();
          }
          if(error.responseJSON.password) {
            $('#password').addClass('input-error');
            $('#error_password').text(error.responseJSON.password).show();
          } else {
            $('#password').removeClass('input-error');
            $('#error_password').hide();
          }
          if(error.responseJSON.role) {
            $('#create_user_role').addClass('input-error');
            $('#error_create_user_role').text(error.responseJSON.role).show();
          } else {
            $('#create_user_role').removeClass('input-error');
            $('#error_create_user_role').hide();
          }
        }
      });
    });
  });
</script>
@endpush