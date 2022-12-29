<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('customers')->insert([
      'name' => 'Dominic Toretto',
      'customer_type_id' => '1',
      'phone' => '08123456789',
      'existing' => 1,
      'previous_salesman_id' => '4',
      'current_salesman_id' => '3',
      'user_id' => '1',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('customers')->insert([
      'name' => 'Brian Conner',
      'customer_type_id' => '2',
      'phone' => '08123456789',
      'existing' => 1,
      'previous_salesman_id' => '5',
      'current_salesman_id' => '2',
      'user_id' => '2',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('customers')->insert([
      'name' => 'Letty Ortiz',
      'customer_type_id' => '3',
      'phone' => '08123456789',
      'existing' => 1,
      'previous_salesman_id' => '5',
      'current_salesman_id' => '3',
      'user_id' => '3',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('customers')->insert([
      'name' => 'Roman Pearce',
      'customer_type_id' => '1',
      'phone' => '08123456789',
      'existing' => 0,
      'previous_salesman_id' => NULL,
      'current_salesman_id' => '2',
      'user_id' => '1',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('customers')->insert([
      'name' => 'Luke Hobbs',
      'customer_type_id' => '2',
      'phone' => '08123456789',
      'existing' => 0,
      'previous_salesman_id' => NULL,
      'current_salesman_id' => '3',
      'user_id' => '2',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('customers')->insert([
      'name' => 'Tej Parker',
      'customer_type_id' => '3',
      'phone' => '08123456789',
      'existing' => 0,
      'previous_salesman_id' => NULL,
      'current_salesman_id' => '2',
      'user_id' => '3',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
