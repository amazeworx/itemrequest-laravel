<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ItemRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

//Route::delete('product/{product}', [ProductController::class, 'destroy']);
//Route::delete('customer/{customer}', [CustomerController::class, 'destroy']);
//Route::delete('item_request/{item_request}', [ItemRequestController::class, 'destroy']);

Route::apiResource('item_request', ItemRequestController::class, ['as' => 'api']);
Route::apiResource('product', ProductController::class, ['as' => 'api']);
Route::apiResource('customer', CustomerController::class, ['as' => 'api']);

Route::get('search/product', [ProductController::class, 'search'])->name('api.search.product');
Route::get('search/customer', [CustomerController::class, 'search'])->name('api.search.customer');

Route::post('import/item_request', [ItemRequestController::class, 'import'])->name('api.import.item_request');

// Route::post('import/item_request', function () {
//   Excel::import(new ItemRequestsImport, request()->file('file'));
//   return redirect()->back()->with('success','Data Imported Successfully');
// });