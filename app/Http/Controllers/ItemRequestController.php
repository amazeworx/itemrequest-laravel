<?php

namespace App\Http\Controllers;

use App\Models\ItemRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\StatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\DataTables\ItemRequestsDataTable;
//use Yajra\DataTables\Facades\DataTables;
use DataTables;

class ItemRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(ItemRequestsDataTable $dataTable)
  {
    $item_requests = ItemRequest::orderBy('request_date', 'desc')->orderBy('id', 'desc')->get();
    $products = Product::all();
    $salesmans = User::role('sales')->orderBy('name', 'asc')->get(['id', 'name', 'active']);
    $customers = Customer::all();
    $customertypes = CustomerType::all();
    $statuses = StatusRequest::all();
    $user_id = Auth::id();

    return $dataTable->with('user_id', $user_id)
      ->render('pages.item-request.index-datatable', compact('item_requests', 'products', 'salesmans', 'customers', 'customertypes', 'statuses'));

    // if (request()->ajax()) {
    //   //$itemRequests = ItemRequest::query();
    //   $itemRequests = ItemRequest::with(['product', 'customer', 'salesman', 'status']);
    //   return DataTables::eloquent($itemRequests)
    //     ->addColumn('request_date', function (ItemRequest $itemRequest) {
    //       return date('d-m-Y', strtotime($itemRequest->request_date));
    //     })
    //     ->addColumn('request_code', function (ItemRequest $itemRequest) {
    //       return $itemRequest->request_code;
    //     })
    //     ->addColumn('product', function (ItemRequest $itemRequest) {
    //       return $itemRequest->product->name;
    //     })
    //     ->addColumn('customer', function (ItemRequest $itemRequest) {
    //       return $itemRequest->customer->name;
    //     })
    //     ->addColumn('salesman', function (ItemRequest $itemRequest) {
    //       return $itemRequest->salesman->name;
    //     })
    //     ->addColumn('status', function (ItemRequest $itemRequest) {
    //       return $itemRequest->status->name;
    //     })
    //     ->addColumn('action', function (ItemRequest $itemRequest) {
    //       $actionBtn = '<div class="inline-flex gap-x-2"><a href="#!" data-id="' . $itemRequest->id . '"
    //                   class="view_item_request link link-primary link-hover">View</a>
    //                 <a href="#!" data-id="' . $itemRequest->id . '"
    //                   class="edit_item_request link link-primary link-hover">Edit</a>
    //                 <a href="#!" data-id="' . $itemRequest->id . '"
    //                   class="delete_item_request link link-primary link-hover">Delete</a></div>';
    //       return $actionBtn;
    //     })
    //     ->rawColumns(['action'])
    //     //->make();
    //     ->toJson();
    // }

    // return view('pages.item-request.index')->with('item_requests', $item_requests)->with('salesmans', $salesmans)->with('customers', $customers)->with('products', $products)->with('statuses', $statuses);

    // return view('pages.item-request.index')->with('item_requests', $item_requests)->with('salesmans', $salesmans)->with('customers', $customers)->with('products', $products)->with('statuses', $statuses);
    //return $dataTable->render('pages.item-request.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $products = Product::all();
    $salesmans = User::where('role', 'Sales')->get(['id', 'name']);
    $customers = Customer::all();
    return view('pages.item-request.create')->with('salesmans', $salesmans)->with('customers', $customers)->with('products', $products);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    ItemRequest::create([
      'request_date' => $request->request_date,
      'salesman_id' => $request->user_id,
      'customer_id' => $request->customer_id,
      'product_id' => $request->product_id,
      'status_id' => '1',
      'notes' => $request->notes,
      'user_id' => $request->user_id,
    ]);

    return Redirect::route('item_request.create')->with('status', 'item_request-created');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\ItemRequest  $itemRequest
   * @return \Illuminate\Http\Response
   */
  public function show(ItemRequest $itemRequest)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\ItemRequest  $itemRequest
   * @return \Illuminate\Http\Response
   */
  public function edit(ItemRequest $itemRequest)
  {
    $item_request = ItemRequest::where('id', $itemRequest->id)->first();
    $products = Product::all();
    $customers = Customer::all();
    $statutes = StatusRequest::all();
    return view('pages.item-request.edit')->with('item_request', $item_request)->with('products', $products)->with('customers', $customers)->with('statutes', $statutes);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\ItemRequest  $itemRequest
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ItemRequest $itemRequest)
  {
    $data = [
      'customer_id' => $request->customer_id,
      'product_id' => $request->product_id,
      'status_id' => $request->status_id,
      'notes' => $request->notes,
    ];

    ItemRequest::where('id', $itemRequest->id)->update($data);

    return Redirect::route('item_request.edit', $itemRequest->id)->with('status', 'item_request-updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\ItemRequest  $itemRequest
   * @return \Illuminate\Http\Response
   */
  public function destroy(ItemRequest $itemRequest)
  {
    ItemRequest::where('id', $itemRequest->id)->delete();

    return Redirect::route('item_request.index')->with('status', 'item_request-deleted');
  }
}
