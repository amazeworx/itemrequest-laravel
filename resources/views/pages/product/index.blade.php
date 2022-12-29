<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Products') }}
      </h2>
      <x-buttons.button-link-primary :href="route('product.create')">{{ __('Add Product') }}
      </x-buttons.button-link-primary>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      @if (session('status') === 'product-deleted' || request("status") === 'product-deleted')
      <x-alert alert-id="alert-success" :icon="true" :dismiss="true">
        {{ __('Product successfully deleted.') }}
      </x-alert>
      @endif

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="text-gray-900 dark:text-gray-100">

          <div class="overflow-x-auto relative">
            <table class="w-full text-sm text-left text-gray-500">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                  <th scope="col" class="py-3 px-6">
                    Nama Barang
                  </th>
                  <th scope="col" class="py-3 px-6">
                    SKU
                  </th>
                  <th scope="col" class="py-3 px-6">
                    Brand
                  </th>
                  <th scope="col" class="py-3 px-6">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $product)
                <tr class="bg-white border-b hover:bg-gray-50 ">
                  <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $product->name }}
                  </th>
                  <td class="py-4 px-6">
                    {{ $product->sku }}
                  </td>
                  <td class="py-4 px-6">
                    {{ $product->brand }}
                  </td>
                  <td class="py-4 px-6 text-right space-x-3">
                    <a href="/product/{{ $product->id }}/edit"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    <a href="/product/{{ $product->id }}/edit"
                      class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#!" data-id="{{ $product->id }}"
                      class="delete_product font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(function () {
      $('.delete_product').click(function (e) {
        e.preventDefault();
        //console.log('clicked');
        const product_id = $(this).data("id");
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
</x-app-layout>