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
    Schema::create('product_logs', function (Blueprint $table) {
      $table->id();
      $table->foreignId('product_id')->constrained('products');
      $table->string('name')->nullable();
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
      $table->text('log')->nullable();
      $table->string('user')->nullable();
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
    Schema::dropIfExists('product_logs');
  }
};
