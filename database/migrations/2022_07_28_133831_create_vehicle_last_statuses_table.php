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
    Schema::table('vehicle_last_statuses', function (Blueprint $table) {
      $table->text('lamp_notes')->nullable();
      $table->text('glass_notes')->nullable();
      $table->text('tire_notes')->nullable();
      $table->text('equipment_notes')->nullable();
      $table->text('gear_notes')->nullable();
      $table->text('other_notes')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('vehicle_last_statuses', function (Blueprint $table) {
      $table->dropColumn([
        'glass_notes',
        'tire_notes',
        'equipment_notes',
        'gear_notes',
        'other_notes'
      ]);
    });
  }
};