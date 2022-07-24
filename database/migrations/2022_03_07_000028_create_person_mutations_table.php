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
    Schema::create('person_mutations', function (Blueprint $table) {
      $table->id();
      $table->foreignId('person_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('created_by')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
      $table->date('date')->nullable();
      $table->string('mutation_number')->nullable();
      $table->string('employee_number')->nullable();
      $table->string('mutation_type')->nullable();
      $table->date('apply_date')->nullable();
      $table->text('description')->nullable();
      $table->string('prob_sallary')->nullable();
      $table->string('prob_allowance')->nullable();
      $table->string('sallary')->nullable();
      $table->string('allowance')->nullable();
      $table->string('status')->nullable();
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
    Schema::dropIfExists('person_mutations');
  }
};