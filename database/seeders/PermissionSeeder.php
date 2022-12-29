<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // reset cached roles and permission
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions
    Permission::create(['name' => 'view requests']);
    Permission::create(['name' => 'create requests']);
    Permission::create(['name' => 'update status requests']);
    Permission::create(['name' => 'edit requests']);
    Permission::create(['name' => 'delete requests']);
    Permission::create(['name' => 'export requests']);
    Permission::create(['name' => 'import requests']);

    $superadminRole = Role::create(['name' => 'super-admin']);
    // gets all permissions via Gate::before rule

    //create roles and assign existing permissions
    $salesRole = Role::create(['name' => 'sales']);
    $salesRole->givePermissionTo('view requests');
    $salesRole->givePermissionTo('update status requests');
    $salesRole->givePermissionTo('create requests');
    $salesRole->givePermissionTo('edit requests');
    $salesRole->givePermissionTo('delete requests');

    $purchasingRole = Role::create(['name' => 'purchasing']);
    $purchasingRole->givePermissionTo('view requests');
    $purchasingRole->givePermissionTo('update status requests');
    //$purchasingRole->givePermissionTo('create requests');
    //$purchasingRole->givePermissionTo('edit requests');
    //$purchasingRole->givePermissionTo('delete requests');

    // create demo users
    $user = User::factory()->create([
      'name' => 'John Wick',
      'username' => 'johnwick',
      'email' => 'johnwick@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Super Admin',
      'active' => 1,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($superadminRole);

    $user = User::factory()->create([
      'name' => 'Bruce Wayne',
      'username' => 'brucewayne',
      'email' => 'brucewayne@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Sales',
      'active' => 1,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($salesRole);

    $user = User::factory()->create([
      'name' => 'Clark Kent',
      'username' => 'clarkkent',
      'email' => 'clarkkent@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Sales',
      'active' => 1,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($salesRole);

    $user = User::factory()->create([
      'name' => 'Tony Stark',
      'username' => 'tonystark',
      'email' => 'tonystark@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Sales',
      'active' => 0,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($salesRole);

    $user = User::factory()->create([
      'name' => 'Peter Parker',
      'username' => 'peterparker',
      'email' => 'peterparker@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Sales',
      'active' => 0,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($salesRole);

    $user = User::factory()->create([
      'name' => 'Gal Gadot',
      'username' => 'galgadot',
      'email' => 'galgadot@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Purchasing',
      'active' => 1,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($purchasingRole);

    $user = User::factory()->create([
      'name' => 'Black Widow',
      'username' => 'blackwidow',
      'email' => 'blackwidow@yopmail.com',
      'whatsapp' => '08123456789',
      'role' => 'Purchasing',
      'active' => 1,
      'password' => bcrypt('11223344')
    ]);
    $user->assignRole($purchasingRole);
  }
}
