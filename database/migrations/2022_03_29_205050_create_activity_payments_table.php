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
    Schema::create('activity_payments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('activity_status_id');
      $table->integer('bbm_amount');
      $table->integer('toll_amount');
      $table->integer('parking_amount');
      $table->integer('retribution_amount');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('activity_payments');
  }
};