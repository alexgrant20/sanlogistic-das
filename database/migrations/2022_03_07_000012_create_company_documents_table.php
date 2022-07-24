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
    Schema::create('company_documents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('company_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->string('type');
      $table->string('number')->nullable();
      $table->string('image')->nullable();
      $table->date('expire')->nullable();
      $table->boolean('active')->nullable();
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
    Schema::dropIfExists('company_documents');
  }
};