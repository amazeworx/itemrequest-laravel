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
    Permission::create(['name' => 'edit own request']);
    Permission::create(['name' => 'delete own request']);
    Permission::create(['name' => 'create supplier requests']);
    Permission::create(['name' => 'edit supplier requests']);

    Permission::create(['name' => 'view products']);
    Permission::create(['name' => 'create products']);
    Permission::create(['name' => 'edit products']);
    Permission::create(['name' => 'delete products']);
    Permission::create(['name' => 'export products']);
    Permission::create(['name' => 'import products']);
    Permission::create(['name' => 'view product retail price']);
    Permission::create(['name' => 'create product retail price']);
    Permission::create(['name' => 'edit product retail price']);
    Permission::create(['name' => 'view product resell price']);
    Permission::create(['name' => 'create product resell price']);
    Permission::create(['name' => 'edit product resell price']);
    Permission::create(['name' => 'view product buy price']);
    Permission::create(['name' => 'create product buy price']);
    Permission::create(['name' => 'edit product buy price']);
    Permission::create(['name' => 'edit own product']);
    Permission::create(['name' => 'delete own product']);

    Permission::create(['name' => 'view customers']);
    Permission::create(['name' => 'create customers']);
    Permission::create(['name' => 'edit customers']);
    Permission::create(['name' => 'delete customers']);
    Permission::create(['name' => 'export customers']);
    Permission::create(['name' => 'import customers']);
    Permission::create(['name' => 'edit own customer']);
    Permission::create(['name' => 'delete own customer']);

    Permission::create(['name' => 'view users']);
    Permission::create(['name' => 'create users']);
    Permission::create(['name' => 'edit users']);
    Permission::create(['name' => 'delete users']);
    Permission::create(['name' => 'export users']);
    Permission::create(['name' => 'import users']);

    $superadminRole = Role::create(['name' => 'super-admin']);
    // gets all permissions via Gate::before rule

    //create roles and assign existing permissions
    $salesRole = Role::create(['name' => 'sales']);
    $salesRole->givePermissionTo('view requests');
    $salesRole->givePermissionTo('update status requests');
    $salesRole->givePermissionTo('create requests');
    $salesRole->givePermissionTo('edit own request');
    $salesRole->givePermissionTo('view products');
    $salesRole->givePermissionTo('create products');
    $salesRole->givePermissionTo('edit products');
    $salesRole->givePermissionTo('view customers');
    $salesRole->givePermissionTo('create customers');
    $salesRole->givePermissionTo('edit customers');

    $purchasingRole = Role::create(['name' => 'purchasing']);
    $purchasingRole->givePermissionTo('view requests');
    $purchasingRole->givePermissionTo('update status requests');
    $purchasingRole->givePermissionTo('create supplier requests');
    $purchasingRole->givePermissionTo('edit supplier requests');
    $purchasingRole->givePermissionTo('view products');
    $purchasingRole->givePermissionTo('create products');
    $purchasingRole->givePermissionTo('edit products');
    $purchasingRole->givePermissionTo('view product retail price');
    $purchasingRole->givePermissionTo('create product retail price');
    $purchasingRole->givePermissionTo('edit product retail price');
    $purchasingRole->givePermissionTo('view product resell price');
    $purchasingRole->givePermissionTo('create product resell price');
    $purchasingRole->givePermissionTo('edit product resell price');
    $purchasingRole->givePermissionTo('view product buy price');
    $purchasingRole->givePermissionTo('create product buy price');
    $purchasingRole->givePermissionTo('edit product buy price');
    $purchasingRole->givePermissionTo('view customers');
    $purchasingRole->givePermissionTo('create customers');
    $purchasingRole->givePermissionTo('edit customers');

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
