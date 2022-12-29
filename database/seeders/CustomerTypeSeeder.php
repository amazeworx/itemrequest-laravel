<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('customer_types')->insert([
      'name' => 'End User',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('customer_types')->insert([
      'name' => 'Toko',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('customer_types')->insert([
      'name' => 'Bengkel',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
