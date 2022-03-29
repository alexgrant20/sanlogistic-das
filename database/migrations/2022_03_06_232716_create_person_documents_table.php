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
    Schema::create('person_documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('person_id');
      $table->string('type');
      $table->foreignId('specialID')->nullable();
      $table->string('number');
      $table->string('address')->nullable();
      $table->string('image');
      $table->date('expire')->nullable();
      $table->tinyInteger('active')->default(1);
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
    Schema::dropIfExists('person_documents');
  }
};