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
      $table->foreignId('city_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('company_type_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->string('name')->unique();
      $table->string('phone_number')->nullable();
      $table->string('email')->nullable();
      $table->text('note')->nullable();
      $table->string('website')->nullable();
      $table->string('director')->nullable();
      $table->string('npwp')->nullable();
      $table->string('fax')->nullable();
      $table->string('full_address')->nullable();
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
      $table->softDeletes();
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