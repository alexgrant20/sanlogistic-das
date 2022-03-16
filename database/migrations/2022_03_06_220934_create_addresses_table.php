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
    Schema::create('addresses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('address_type_id');
      $table->foreignId('area_id');
      $table->foreignId('subdistrict_id');
      $table->foreignId('pool_type_id');
      $table->string('name')->unique();
      $table->text('full_address');
      $table->double('longitude');
      $table->double('latitude');
      $table->string('post_number');
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
    Schema::dropIfExists('addresses');
  }
};