<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::table('activity_payments', function (Blueprint $table) {
      $table->renameColumn('retribution_amount', 'load_amount');
      $table->integer('unload_amount')->nullable()->default(0);
      $table->integer('maintenance_amount')->nullable()->default(0);
    });
  }

  public function down()
  {
    Schema::table('activity_payments', function (Blueprint $table) {
      $table->renameColumn('load_amount', 'retribution_amount');
      $table->dropColumn(['maintenance_amount', 'unload_amount']);
    });
  }
};