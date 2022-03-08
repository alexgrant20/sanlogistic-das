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
    Schema::create('vehicles_documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('vehicle_id');
      $table->string('type');
      $table->string('number');
      $table->string('image');
      $table->date('expire');
      $table->boolean('active');
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
    Schema::dropIfExists('vehicles_documents');
  }
};