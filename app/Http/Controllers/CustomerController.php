<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\DataTables\CustomersDataTable;
use Spatie\Permission\Traits\HasRoles;
use DataTables;

class CustomerController extends Controller
{
  use HasRoles;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(CustomersDataTable $dataTable)
  {
    $salesmans = User::role('sales')->orderBy('name', 'asc')->get(['id', 'name', 'active']);
    $customertypes = CustomerType::all();
    $user_id = Auth::id();
    return $dataTable->with('user_id', $user_id)
      ->render('pages.customer.index', compact('salesmans', 'customertypes'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $salesman = User::where('role', 'Sales')->get(['id', 'name']);
    $customertype = CustomerType::all();
    return view('pages.customer.create')->with('salesman', $salesman)->with('customertype', $customertype);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    Customer::create([
      'name' => $request->name,
      'type' => $request->type,
      'phone' => $request->phone,
      'existing' => $request->existing,
      'salesman_previous' => $request->salesman_previous,
      'salesman_current' => $request->salesman_current,
      'notes' => $request->notes,
      'user_id' => $request->user_id,
    ]);

    return Redirect::route('customer.create')->with('status', 'customer-created');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function show(Customer $customer)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function edit(Customer $customer)
  {
    $customer = Customer::where('id', $customer->id)->first();
    $salesman = User::where('role', 'Sales')->get(['id', 'name']);
    $customertype = CustomerType::all();
    return view('pages.customer.edit')->with('customer', $customer)->with('salesman', $salesman)->with('customertype', $customertype);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Customer $customer)
  {
    $data = [
      'name' => $request->name,
      'type' => $request->type,
      'phone' => $request->phone,
      'existing' => $request->existing,
      'salesman_previous' => $request->salesman_previous,
      'salesman_current' => $request->salesman_current,
      'notes' => $request->notes,
    ];

    Customer::where('id', $customer->id)->update($data);

    return Redirect::route('customer.edit', $customer->id)->with('status', 'customer-updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Customer  $customer
   * @return \Illuminate\Http\Response
   */
  public function destroy(Customer $customer)
  {
    Customer::where('id', $customer->id)->delete();

    return Redirect::route('customer.index')->with('status', 'customer-deleted');
  }
}
