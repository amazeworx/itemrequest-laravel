<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('products')->insert([
      'name' => 'Shockbreaker',
      'sku' => 'P0001',
      'brand' => 'Toyota Innova',
      'year' => '2019',
      'cc' => '2400',
      'engine' => 'Diesel',
      'user_id' => '1',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('products')->insert([
      'name' => 'Filter AC',
      'sku' => 'P0002',
      'brand' => 'Toyota Avanza',
      'year' => '2018',
      'cc' => '1500',
      'engine' => 'Bensin',
      'user_id' => '2',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('products')->insert([
      'name' => 'Kopling Set',
      'sku' => 'P0003',
      'brand' => 'Mitsubishi Xpander',
      'year' => '2017',
      'cc' => '1500',
      'engine' => 'Bensin',
      'user_id' => '3',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('products')->insert([
      'name' => 'Kampas Rem',
      'sku' => 'P0004',
      'brand' => 'Honda HRV',
      'year' => '2020',
      'cc' => '1800',
      'engine' => 'Bensin',
      'user_id' => '1',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('products')->insert([
      'name' => 'Transmisi',
      'sku' => 'P0005',
      'brand' => 'Mitsubishi Outlander',
      'year' => '2018',
      'cc' => '2400',
      'engine' => 'Bensin',
      'user_id' => '2',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('products')->insert([
      'name' => 'Busi Set',
      'sku' => 'P0006',
      'brand' => 'Mazda CX-5',
      'year' => '2021',
      'cc' => '2400',
      'engine' => 'Bensin',
      'user_id' => '3',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
