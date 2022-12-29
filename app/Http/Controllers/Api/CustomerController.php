<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    $validator = Validator::make($request->all(), [
      'name' => 'required',
    ]);

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
      'previous_salesman_id' => $request->previous_salesman_id,
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
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
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
}
