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
    Schema::create('companies', function (Blueprint $table) {
      $table->id();
      $table->foreignId('address_id');
      $table->string('name');
      $table->string('type');
      $table->string('phone_number');
      $table->string('email');
      $table->text('catatan');
      $table->string('website');
      $table->string('director');
      $table->string('npwp');
      $table->string('fax');
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
    Schema::dropIfExists('companies');
  }
};