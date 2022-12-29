<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = User::with('roles')->get();
    return view('pages.user.index')->with('data', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('pages.user.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'username' => $request->username,
      'whatsapp' => $request->whatsapp,
      'password' => Hash::make($request->password),
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

    return Redirect::route('user.create')->with('status', 'user-created');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function edit(User $user)
  {
    $data = User::where('id', $user->id)->with('roles')->first();
    return view('pages.user.edit')->with('user', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {

    $data = [
      'name' => $request->name,
      'username' => $request->username,
      'email' => $request->email,
      'whatsapp' => $request->whatsapp,
    ];
    User::where('id', $user->id)->update($data);
    $user->removeRole('super-admin');
    $user->removeRole('sales');
    $user->removeRole('purchasing');
    $user->assignRole($request->role);

    return Redirect::route('user.edit', $user->id)->with('status', 'user-updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    //
  }
}
