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
    Schema::table('users', function (Blueprint $table) {
      $table->foreignId('created_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('updated_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('last_activity_id')->unique()->nullable()->references('id')->on('activities')->restrictOnDelete()->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      //
    });
  }
};