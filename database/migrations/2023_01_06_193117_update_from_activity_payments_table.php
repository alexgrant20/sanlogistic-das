<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
  {
    Schema::table('activity_payments', function (Blueprint $table) {
      $table->integer('transport_amount')->nullable()->default(0);
      $table->integer('courier_amount')->nullable()->default(0);
      $table->text('description')->nullable();
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
      $table->foreignId('created_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
      $table->foreignId('updated_by')->nullable()->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
    });
  }

  public function down()
  {
    Schema::table('activity_payments', function (Blueprint $table) {
      $table->dropForeign(['created_by']);
      $table->dropForeign(['updated_by']);
      $table->dropColumn([
        'transport_amount', 'courier_amount', 'description', 'created_at', 'updated_at', 'created_by', 'updated_by'
      ]);
    });
  }
};