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
      $table->foreignId('vehicle_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('maintenance_type_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->date('request_date')->nullable();
      $table->string('description')->nullable();
      $table->dateTime('work_order_date')->nullable();
      $table->dateTime('finish_date')->nullable();
      $table->boolean('finish')->default(false);
      $table->text('note')->nullable();
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
    Schema::dropIfExists('vehicle_maintenances');
  }
};