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
      $table->foreignId('activity_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->string('status');
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
      $table->foreignId('created_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('updated_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
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