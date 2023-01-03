<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomersImport;

class CustomerController extends Controller
{

  /**
   * Query a listing of select2 search.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    $customers = [];
    if ($request->has('q')) {
      $search = $request->q;
      $customers = Customer::select("id", "name")
        ->where('name', 'LIKE', "%$search%")
        ->get();
    }
    return response()->json($customers);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $customers = Customer::orderBy('name', 'asc')->get();
    return response()->json($customers);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //define validation rules
    $rules = [
      'name' => 'required',
      'phone' => 'required',
      'current_salesman_id' => 'required',
      'previous_salesman' => 'required_if:existing,==,1'
    ];
    $messages = [
      'name.required' => 'Nama wajib diisi',
      'phone.required' => 'Phone wajib diisi',
      'current_salesman_id.required' => 'Sales sekarang wajib diisi',
      'previous_salesman.required_if' => 'Sales sebelumnya wajib diisi'
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    //check if validation fails
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    //create customer
    $customer = Customer::create([
      'name' => $request->name,
      'phone' => $request->phone,
      'customer_type_id' => $request->customer_type_id,
      'existing' => $request->existing,
      'current_salesman_id' => $request->current_salesman_id,
      'previous_salesman' => $request->previous_salesman,
      'notes' => $request->notes,
      'user_id' => $request->user_id,
    ]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Customer berhasil dibuat.',
      'data'    => $customer
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $item = Customer::where('id', $id)->first();

    $data = [
      'id' => $item->id,
      'name' => $item->name,
      'phone' => $item->phone,
      'customer_type' => [
        'id' => $item->customer_type_id,
        'name' => $item->customertype->name
      ],
      'existing' => $item->existing,
      'current_salesman' => [
        'id' => $item->current_salesman_id,
        'name' => $item->currentsalesman->name
      ],
      'previous_salesman' => $item->previous_salesman,
      'notes' => $item->notes,
      'user' => [
        'id' => $item->user_id,
        'name' => $item->user->name,
      ],
      'created_at' => $item->created_at,
      'updated_at' => $item->updated_at,
      'deleted_at' => $item->deleted_at
    ];
    //return response
    return response()->json([
      'success' => true,
      'message' => 'Detail Data Customer',
      'data'    => $data
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Customer $customer)
  {

    $rules = [
      'name' => 'required',
      'phone' => 'required',
      'current_salesman_id' => 'required',
      'previous_salesman' => 'required_if:existing,==,1'
    ];
    $messages = [
      'name.required' => 'Nama wajib diisi',
      'phone.required' => 'Phone wajib diisi',
      'current_salesman_id.required' => 'Sales sekarang wajib diisi',
      'previous_salesman.required_if' => 'Sales sebelumnya wajib diisi'
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    //check if validation fails
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $customer->update([
      'name' => $request->name,
      'phone' => $request->phone,
      'customer_type_id' => $request->customer_type_id,
      'existing' => $request->existing,
      'current_salesman_id' => $request->current_salesman_id,
      'previous_salesman' => $request->previous_salesman,
      'notes' => $request->notes,
    ]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Customer berhasil disimpan.',
      'data'    => $customer
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Customer $customer)
  {
    Customer::where('id', $customer->id)->delete();

    return response()->json("Customer Deleted");
  }

  public function import(Request $request)
  {

    $user_id = $request->user_id;

    $data = array();

    if ($request->file('file')) {

      $import = Excel::import(new CustomersImport($user_id), $request->file('file'));

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
  }
}
