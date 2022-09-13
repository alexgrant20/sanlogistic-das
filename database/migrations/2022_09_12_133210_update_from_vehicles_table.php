<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::table('vehicles', function (Blueprint $table) {
      $table->date('maintenance_date')->nullable();
      $table->unsignedInteger('maintenance_odo')->nullable();
    });
  }

  public function down()
  {
    Schema::table('vehicles', function (Blueprint $table) {
      $table->dropColumn(['maintenance_date', 'maintenance_odo']);
    });
  }
};
