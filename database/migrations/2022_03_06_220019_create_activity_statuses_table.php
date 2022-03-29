<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.p
   *
   * @return void
   */
  public function up()
  {
    Schema::create('activity_statuses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('activity_id');
      $table->string('status');
      $table->foreignId('created_by')->nullable();
      $table->foreignId('updated_by')->nullable();
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
    Schema::dropIfExists('activity_statuses');
  }
};