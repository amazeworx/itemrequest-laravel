<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('description')->nullable();
      $table->string('sku')->nullable();
      $table->string('brand')->nullable();
      $table->string('year')->nullable();
      $table->string('cc')->nullable();
      $table->string('engine')->nullable();
      $table->decimal('price_buy', $precision = 10, $scale = 2)->nullable();
      $table->decimal('price_resell', $precision = 10, $scale = 2)->nullable();
      $table->decimal('price_retail', $precision = 10, $scale = 2)->nullable();
      $table->text('notes')->nullable();
      $table->foreignId('user_id')->constrained('users');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
};
