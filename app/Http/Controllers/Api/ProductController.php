<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

  /**
   * Query a listing of select2 search.
   *
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    $products = [];
    if ($request->has('q')) {
      $search = $request->q;
      $products = Product::select("id", "name")
        ->where('name', 'LIKE', "%$search%")
        ->get();
    }
    return response()->json($products);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $products = Product::orderBy('name', 'asc')->get();
    return response()->json($products);
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

    //create product
    $product = Product::create([
      'name' => $request->name,
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
    ]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Produk berhasil dibuat.',
      'data'    => $product
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($product)
  {
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
  public function update(Request $request, Product $product)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    Product::where('id', $product->id)->delete();

    return response()->json("Product Deleted");
  }
}
