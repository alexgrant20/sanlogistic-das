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
        Schema::create('activity_incentives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->references('id')->on('activities')->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('total_distance');
            $table->foreignId('trip_type_id')->references('id')->on('trip_types')->restrictOnDelete()->cascadeOnUpdate();
            $table->decimal('incentive');
            $table->decimal('incentive_with_deposit');
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
        Schema::dropIfExists('activity_incentives');
    }
};
