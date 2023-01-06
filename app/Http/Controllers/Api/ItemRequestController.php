<?php

namespace App\Http\Controllers\Api;

use App\Models\ItemRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\StatusRequest;
use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemRequestsImport;

class ItemRequestController extends Controller
{

  /**
   * store
   *
   * @param  mixed $request
   * @return void
   */
  public function store(Request $request)
  {
    //define validation rules
    $validator = Validator::make($request->all(), [
      'request_date' => 'required',
      'customer_id' => 'required',
      'product_id' => 'required',
      'status_id' => 'required',
    ]);

    //check if validation fails
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    //create itemRequest
    $item_request = ItemRequest::create([
      'request_date' => $request->request_date,
      'salesman_id' => $request->salesman_id,
      'customer_id' => $request->customer_id,
      'product_id' => $request->product_id,
      'status_id' => $request->status_id,
      'user_id' => $request->user_id,
      'notes' => $request->notes,
    ]);

    $request_id = $item_request->id;

    $request_code = 'RQ_' . str_pad($request_id, 5, "0", STR_PAD_LEFT);

    $itemRequest = ItemRequest::where('id', $request_id)->update([
      'request_code' => $request_code,
    ]);

    $comment = $request->comment;
    if ($comment) {
      Comment::create([
        'comment' => $request->comment,
        'item_request_id' => $request_id,
        'user_id' => $request->user_id,
      ]);
    }

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Item Request berhasil dibuat.',
      'data'    => $itemRequest
    ]);
  }

  /**
   * show
   *
   * @param  mixed $item_request
   * @return void
   */
  public function show($item_request)
  {
    $item = ItemRequest::where('id', $item_request)->withTrashed()->first();
    $product = Product::where('id', $item->product_id)->withTrashed()->first();
    $customer = Customer::where('id', $item->customer_id)->withTrashed()->first();
    $customer_type = CustomerType::where('id', $customer->customer_type_id)->first();
    $salesman = User::where('id', $item->salesman_id)->withTrashed()->first();
    $current_salesman = User::where('id', $customer->current_salesman_id)->withTrashed()->first();
    $previous_salesman = User::where('id', $customer->previous_salesman_id)->first();
    $user = User::where('id', $item->user_id)->first();
    $status = StatusRequest::where('id', $item->status_id)->first();
    $comments = Comment::where('item_request_id', $item_request)->with('user')->get();

    $previous_salesman_id = NULL;
    $previous_salesman_name = NULL;
    $previous_salesman_phone = NULL;
    if ($customer->previous_salesman_id) {
      $previous_salesman = User::where('id', $customer->previous_salesman_id)->first();
      $previous_salesman_id = $previous_salesman->id;
      $previous_salesman_name = $previous_salesman->name;
      $previous_salesman_phone = $previous_salesman->phone;
    }

    $data = [
      'id' => $item->id,
      'request_code' => $item->request_code,
      'request_date' => $item->request_date,
      'salesman' => [
        'id' => $item->salesman_id,
        'name' => $salesman->name,
        'whatsapp' => $salesman->whatsapp,
      ],
      'customer' => [
        'id' => $item->customer_id,
        'name' => $customer->name,
        'phone' => $customer->phone,
        'existing' => $customer->existing,
        'customer_type' => [
          'id' => $customer->customer_type_id,
          'name' => $customer_type->name,
        ],
        'current_salesman' => [
          'id' => $customer->current_salesman_id,
          'name' => $current_salesman->name,
          'phone' => $current_salesman->phone,
        ],
        'previous_salesman' => [
          'id' => $previous_salesman_id,
          'name' => $previous_salesman_name,
          'phone' => $previous_salesman_phone,
        ],
        'notes' => $customer->notes,
      ],
      'product' => [
        'id' => $item->product_id,
        'name' => $product->name,
        'description' => $product->description,
        'sku' => $product->sku,
        'brand' => $product->brand,
        'year' => $product->year,
        'cc' => $product->cc,
        'engine' => $product->engine,
        'price_buy' => $product->price_buy,
        'price_resell' => $product->price_resell,
        'price_retail' => $product->price_retail,
        'notes' => $product->notes,
      ],
      'status' => [
        'id' => $item->status_id,
        'name' => $status->name,
      ],
      'user' => [
        'id' => $item->user_id,
        'name' => $user->name,
      ],
      'comments' => $comments,
      'created_at' => $item->created_at,
      'updated_at' => $item->updated_at,
      'deleted_at' => $item->deleted_at
    ];

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Detail Data Item Request',
      'data'    => $data
    ]);
  }

  /**
   * update
   *
   * @param  mixed $request
   * @param  mixed $itemRequest
   * @return void
   */
  public function update(Request $request, ItemRequest $itemRequest)
  {
    $action = $request->action;

    if ($action == 'update-status') {
      $itemRequest->update([
        'status_id' => $request->status_id,
      ]);
    } else {
      //define validation rules
      $validator = Validator::make($request->all(), [
        'request_date' => 'required',
        'customer_id' => 'required',
        'product_id' => 'required',
        'status_id' => 'required',
      ]);

      //check if validation fails
      if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      }

      //create itemRequest
      $itemRequest->update([
        'request_date' => $request->request_date,
        'salesman_id' => $request->salesman_id,
        'customer_id' => $request->customer_id,
        'product_id' => $request->product_id,
        'status_id' => $request->status_id,
        'user_id' => $request->user_id,
      ]);
    }


    //return response
    return response()->json([
      'success' => true,
      'message' => 'Item Request berhasil disimpan.',
      'data'    => $itemRequest
    ]);
  }

  /**
   * destroy
   *
   * @param  mixed $itemRequest
   * @return void
   */
  public function destroy(ItemRequest $itemRequest)
  {
    ItemRequest::where('id', $itemRequest->id)->delete();

    return response()->json("Item Request Deleted");
  }

  public function import(Request $request)
  {

    $data = array();

    if ($request->file('file')) {

      $import = Excel::import(new ItemRequestsImport, $request->file('file'));

      // Response
      $data['success'] = 1;
      $data['message'] = 'Uploaded Successfully!';
      $data['data'] = $import;
    } else {
      // Response
      $data['success'] = 2;
      $data['message'] = 'File not uploaded.';
    }

    return response()->json($data);

    $validator = Validator::make($request->all(), [
      'file' => 'required|mimes:png,jpg,jpeg,csv,txt,pdf|max:2048'
    ]);

    if ($validator->fails()) {

      $data['success'] = 0;
      $data['error'] = $validator->errors()->first('file'); // Error response

    } else {
      if ($request->file('file')) {

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        // File extension
        $extension = $file->getClientOriginalExtension();

        // File upload location
        $location = 'files';

        // Upload file
        $file->move($location, $filename);

        // File path
        $filepath = url('files/' . $filename);

        // Response
        $data['success'] = 1;
        $data['message'] = 'Imported Successfully!';
      } else {
        // Response
        $data['success'] = 2;
        $data['message'] = 'File not uploaded.';
      }
    }

    return response()->json($data);

    $import = Excel::import(new ItemRequestsImport, $request->file('file'));

    return response()->json([
      'success' => true,
      'message' => 'Item Request data has been imported',
      'data'    => $import
    ]);
  }
}
