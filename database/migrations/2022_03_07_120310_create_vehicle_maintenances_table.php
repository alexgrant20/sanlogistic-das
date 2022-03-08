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
    Schema::create('vehicle_maintenances', function (Blueprint $table) {
      $table->id();
      $table->foreignId('vehicle_id');
      $table->foreignId('request_date');
      $table->foreignId('maintenance_type');
      $table->string('description');
      $table->dateTime('work_order_date');
      $table->dateTime('finish_date')->nullable();
      $table->boolean('finish')->default(false);
      $table->text('note')->nullable();
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
    Schema::dropIfExists('vehicle_maintenances');
  }
};