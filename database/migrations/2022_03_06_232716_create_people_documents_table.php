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
    Schema::create('people_documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('people_id');
      $table->string('document');
      $table->string('type');
      $table->string('number');
      $table->string('address');
      $table->string('image');
      $table->date('expire')->nullable();
      $table->boolean('active');
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
    Schema::dropIfExists('people_documents');
  }
};