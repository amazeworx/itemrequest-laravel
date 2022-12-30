<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

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

    $item = Product::where('id', $product)->first();

    $data = [
      'id' => $item->id,
      'name' => $item->name,
      'sku' => $item->sku,
      'brand' => $item->brand,
      'year' => $item->year,
      'cc' => $item->cc,
      'engine' => $item->engine,
      'price_buy' => $item->price_buy,
      'price_resell' => $item->price_resell,
      'price_retail' => $item->price_retail,
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
      'message' => 'Detail Data Product',
      'data'    => $data
    ]);
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
    $validator = Validator::make($request->all(), [
      'name' => 'required',
    ]);

    //check if validation fails
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    // update product
    $product->update([
      'name' => $request->name,
      'sku' => $request->sku,
      'brand' => $request->brand,
      'year' => $request->year,
      'cc' => $request->cc,
      'engine' => $request->engine,
      'price_buy' => $request->price_buy,
      'price_resell' => $request->price_resell,
      'price_retail' => $request->price_retail,
      'notes' => $request->notes,
    ]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Product berhasil disimpan.',
      'data'    => $product
    ]);
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

  public function import(Request $request)
  {

    $user_id = $request->user_id;

    $data = array();

    if ($request->file('file')) {

      $import = Excel::import(new ProductsImport($user_id), $request->file('file'));

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
