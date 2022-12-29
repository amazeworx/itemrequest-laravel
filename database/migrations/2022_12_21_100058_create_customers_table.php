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
    Schema::create('customers', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('phone')->nullable();
      $table->boolean('existing')->nullable();
      $table->foreignId('customer_type_id')->nullable()->constrained('customer_types');
      $table->foreignId('current_salesman_id')->nullable()->constrained('users');
      $table->foreignId('previous_salesman_id')->nullable()->constrained('users');
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
    Schema::dropIfExists('customers');
  }
};
