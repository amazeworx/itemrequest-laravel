<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
  /**
   * store
   *
   * @param  mixed $request
   * @return void
   */
  public function store(Request $request)
  {

    $rules = [
      'comment' => 'required',
    ];
    $messages = [
      'comment.required' => 'Anda belum mengisi komentar',
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    //check if validation fails
    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    //create Comment
    $comment = Comment::create([
      'item_request_id' => $request->item_request_id,
      'user_id' => $request->user_id,
      'comment' => $request->comment,
    ]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'Komentar berhasil dibuat.',
      'data'    => $comment
    ]);
  }
}
