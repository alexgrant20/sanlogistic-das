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
      $table->foreignId('project_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('area_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('vehicle_variety_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('address_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('owner_id')->references('id')->on('companies')->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('vehicle_towing_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->foreignId('vehicle_license_plate_color_id')->constrained()->restrictOnDelete()->cascadeOnUpdate()->nullable();
      $table->string('last_do_number')->nullable();
      $table->date('last_do_date')->nullable();
      $table->string('license_plate')->unique();
      $table->string('frame_number')->nullable();
      $table->string('registration_number')->nullable();
      $table->string('engine_number')->nullable();
      $table->string('modification')->nullable();
      $table->string('internal_code')->nullable();
      $table->string('status')->default("active");
      $table->string('capacity')->nullable();
      $table->string('wheel')->nullable();
      $table->integer('odo')->nullable();
      $table->year('registration_year')->nullable();
      $table->tinyInteger('is_maintenance')->nullable()->default(0);
      $table->text('note')->nullable();
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
    Schema::dropIfExists('vehicles');
  }
};