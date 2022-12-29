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
    Schema::create('item_requests', function (Blueprint $table) {
      $table->id()->from(23001);
      $table->timestamp('request_date');
      $table->string('request_code')->nullable();
      $table->foreignId('salesman_id')->constrained('users');
      $table->foreignId('customer_id')->constrained('customers');
      $table->foreignId('product_id')->constrained('products');
      $table->text('notes')->nullable();
      $table->foreignId('status_id')->constrained('status_requests');
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
    Schema::dropIfExists('item_requests');
  }
};
