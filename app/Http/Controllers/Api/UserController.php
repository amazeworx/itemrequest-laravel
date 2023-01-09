<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
  use HasRoles;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
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
    $validator = Validator::make($request->all(), [
      'name' => ['required', 'string', 'max:255'],
      'username' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'role' => ['required'],
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'username' => $request->username,
      'whatsapp' => $request->whatsapp,
      'password' => Hash::make($request->password),
      'active' => $request->active,
    ]);

    $role = $request->role;
    if ($role == '1') {
      $role = 'super-admin';
    } else if ($role == '2') {
      $role = 'sales';
    } else if ($role == '3') {
      $role = 'purchasing';
    }
    $user->assignRole($role);

    return response()->json([
      'success' => true,
      'message' => 'User berhasil dibuat.',
      'data'    => $user
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($user)
  {
    //return $user;

    $item = User::where('id', $user)->with('roles')->first();

    return response()->json($item);

    $data = [
      'id' => $item->id,
      'name' => $item->name,
      'whatsapp' => $item->whatsapp,
      'username' => $item->username,
      'email' => $item->email,
      'active' => $item->active,
      'role' => [
        'id' => $item->role->id,
        'name' => $item->role->name
      ],
      'created_at' => $item->created_at,
      'updated_at' => $item->updated_at,
      'deleted_at' => $item->deleted_at
    ];
    //return response
    return response()->json([
      'success' => true,
      'message' => 'Detail Data User',
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
  public function update(Request $request, User $user)
  {
    if ($request->password) {
      $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'role' => ['required'],
        'password' => ['confirmed', Rules\Password::defaults()],
      ]);
    } else {
      $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255'],
        'role' => ['required'],
      ]);
    }

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $role = $request->role;
    if ($role == 1) {
      $role = 'super-admin';
    } else if ($role == 2) {
      $role = 'sales';
    } else if ($role == 3) {
      $role = 'purchasing';
    }

    $user->update([
      'name' => $request->name,
      'email' => $request->email,
      'username' => $request->username,
      'whatsapp' => $request->whatsapp,
      'active' => $request->active,
    ]);

    if ($request->password) {
      $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'whatsapp' => $request->whatsapp,
        'active' => $request->active,
        'password' => Hash::make($request->password),
      ]);
    } else {
      $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'username' => $request->username,
        'whatsapp' => $request->whatsapp,
        'active' => $request->active,
      ]);
    }

    $user->syncRoles([$role]);

    //return response
    return response()->json([
      'success' => true,
      'message' => 'User berhasil disimpan.',
      'data'    => $user
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    User::where('id', $user->id)->delete();

    return response()->json("User Deleted");
  }
}
