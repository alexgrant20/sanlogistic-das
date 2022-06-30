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
      $table->foreignId('activity_status_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->integer('bbm_amount')->nullable()->default(0);
      $table->integer('toll_amount')->nullable()->default(0);
      $table->integer('parking_amount')->nullable()->default(0);
      $table->integer('retribution_amount')->nullable()->default(0);
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