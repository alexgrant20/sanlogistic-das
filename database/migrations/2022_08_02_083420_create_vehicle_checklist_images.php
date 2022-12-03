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
    Schema::create('vehicle_checklist_images', function (Blueprint $table) {
      $table->id();
      $table->foreignId('vehicle_checklist_id')->nullable()->references('id')->on('vehicle_checklists')->restrictOnDelete()->cascadeOnUpdate();
      $table->string('image');
      $table->string('description')->nullable();
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
    Schema::dropIfExists('vehicle_checklist_images');
  }
};
