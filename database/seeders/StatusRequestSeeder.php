<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusRequestSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('status_requests')->insert([
      'name' => 'New Request',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('status_requests')->insert([
      'name' => 'Checking',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('status_requests')->insert([
      'name' => 'Ready',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('status_requests')->insert([
      'name' => 'Unavailable',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('status_requests')->insert([
      'name' => 'Deal',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
    DB::table('status_requests')->insert([
      'name' => 'Cancel',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}
