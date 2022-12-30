<div class="view-user-modal">
  <input type="checkbox" id="view-user" class="modal-toggle" />
  <div class="modal z-40">
    <div class="modal-box p-0 relative">
      <label for="view-user" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
      <div class="p-6">

        <div class="flex gap-x-4 items-baseline mb-4">
          <h3 class="text-xl font-medium text-gray-900">{{ __('User Detail') }}</h3>
        </div>

        <input type="hidden" id="view_user_id">

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Nama</div>
            <div id="view--data-name" class="w-2/3"></div>
          </div>
        </div>

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Email</div>
            <div id="view--data-email" class="w-2/3"></div>
          </div>
        </div>

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Username</div>
            <div id="view--data-username" class="w-2/3"></div>
          </div>
        </div>

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">WhatsApp</div>
            <div id="view--data-whatsapp" class="w-2/3"></div>
          </div>
        </div>

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Role</div>
            <div id="view--data-role" class="w-2/3 capitalize"></div>
          </div>
        </div>

        <div>
          <div class="flex gap-x-4 py-2 border-b">
            <div class="w-1/3 font-medium text-sm leading-6 text-slate-500 uppercase">Status</div>
            <div id="view--data-status" class="w-2/3"></div>
          </div>
        </div>

        @canany('edit users|delete users')
        <div>
          <div class="flex justify-end items-center gap-2 pt-2 mt-4">
            @can('edit users')
            <button id="btn-edit-user" type="button" class="btn btn-sm btn-outline btn-primary">{{
              __('Edit')
              }}</button>
            @endcan
            @can('delete user')
            <button id="btn-delete-user" type="button" class="btn btn-sm btn-ghost hover:bg-slate-200">{{
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
    $(document).on("click", "#table-users tbody tr td:not(:last-child):not(.dtr-control)", function(e) {
      e.preventDefault();
      let user_id = $(this).closest('tr').attr("id");
      $("#view_user_id").val($(this).closest('tr').attr("id"));
      $.ajax({
        url: `api/user/${user_id}`,
        type: "GET",
        cache: false,
        success:function(response){
          console.log(response);
          //open modal
          let user_id = response.id;
          let name = response.name;
          let username = response.username;
          let email = response.email;
          let whatsapp = response.whatsapp;
          let status = response.active;
          let role_id = response.roles[0].id;
          let role = response.roles[0].name;

          // view product
          $('#view_user_id').val(user_id);
          if (name) {
            $('#view--data-name').text(name);
          }
          if (username) {
            $('#view--data-username').text(username);
          }
          if (email) {
            $('#view--data-email').text(email);
          }
          if (whatsapp) {
            $('#view--data-whatsapp').text(whatsapp);
          }
          if (role) {
            $('#view--data-role').text(role);
          }
          let status_text;
          if (status != 'NULL') {
            if (status == 1) {
              status_text = 'Active'
            } else {
              status_text = 'Inactive';
            }
            $('#view--data-status').text(status_text);
          }
          $('#view-user').prop('checked', true);

          // edit user
          $('#edit_user_id').val(user_id);
          $('#edit_user_name').val(name);
          $('#edit_user_whatsapp').val(whatsapp);
          $('#edit_user_email').val(email);
          $('#edit_user_username').val(username);
          $('#edit_user_role').val(role_id);
          $('#edit_user_status').val(status);

        }
      });
    });

    /*
      * Delete User
      */
    $(document).on("click", "#btn-delete-user", function(e) {
      e.preventDefault();
      //console.log('clicked');
      const user_id = $('#view_user_id').val();
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
            url: "{{url('/api/user')}}/" + user_id,
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (results) {
              //console.log(results);
              window.location.href = "{{url('/user?status=user-deleted')}}";
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