<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\DataTables\ProductsDataTable;
//use Yajra\DataTables\Facades\DataTables;
use DataTables;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(ProductsDataTable $dataTable)
  {
    $user_id = Auth::id();
    return $dataTable->with('user_id', $user_id)
      ->render('pages.product.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.product.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    Product::create([
      'name' => $request->product_name,
      'sku' => $request->sku,
      'brand' => $request->brand,
      'year' => $request->year,
      'cc' => $request->cc,
      'engine' => $request->engine,
      'price_buy' => $request->price_buy,
      'price_resell' => $request->price_resell,
      'price_retail' => $request->price_retail,
      'notes' => $request->notes,
      'user_id' => $request->user_id,
    ]);

    return Redirect::route('product.create')->with('status', 'product-created');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function show(Product $product)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function edit(Product $product)
  {
    $data = Product::where('id', $product->id)->first();
    return view('pages.product.edit')->with('product', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Product $product)
  {
    $data = [
      'name' => $request->product_name,
      'description' => $request->description,
      'sku' => $request->sku,
      'brand' => $request->brand,
      'year' => $request->year,
      'cc' => $request->cc,
      'engine' => $request->engine,
      'price_buy' => $request->price_buy,
      'price_resell' => $request->price_resell,
      'price_retail' => $request->price_retail,
      'notes' => $request->notes,
      'user_id' => $request->user_id,
    ];

    Product::where('id', $product->id)->update($data);

    return Redirect::route('product.edit', $product->id)->with('status', 'product-updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    Product::where('id', $product->id)->delete();

    return Redirect::route('product.index')->with('status', 'product-deleted');
  }
}
