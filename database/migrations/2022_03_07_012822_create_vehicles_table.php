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
    Schema::create('vehicles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('project_id')->nullable();
      $table->foreignId('area_id');
      $table->foreignId('vehicle_variety_id');
      $table->foreignId('address_id');
      $table->foreignId('owner_id');
      $table->foreignId('vehicle_towing_id');
      $table->string('last_do_number');
      $table->date('last_do_date');
      $table->string('license_plate');
      $table->string('license_plate_color');
      $table->string('frame_number');
      $table->string('registration_number');
      $table->string('engine_number');
      $table->string('modification');
      $table->string('internal_code');
      $table->string('status');
      $table->string('capacity');
      $table->string('wheel');
      $table->integer('odo');
      $table->year('registration_year');
      $table->boolean('is_maintenance');
      $table->text('catatan')->nullable();
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
    Schema::dropIfExists('vehicles');
  }
};