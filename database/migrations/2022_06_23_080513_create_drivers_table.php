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
    Schema::create('drivers', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('last_activity_id')->unique()->nullable()->references('id')->on('activities')->restrictOnDelete()->cascadeOnUpdate();
      $table->smallInteger('total_cust_trip')->default(0);
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('drivers');
  }
};