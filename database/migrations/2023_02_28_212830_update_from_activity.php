<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('arrival_odo')->nullable()->change();
            $table->dateTime('arrival_date')->nullable()->change();
            $table->string('do_image')->nullable()->change();
            $table->string('do_number')->nullable()->change();
            $table->date('do_date')->nullable()->change();
            $table->unsignedBigInteger('project_id')->nullable()->change();
            $table->unsignedBigInteger('vehicle_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->unsignedBigInteger('arrival_odo')->nullable(false)->change();
            $table->dateTime('arrival_date')->nullable(false)->change();
            $table->string('do_image')->nullable(false)->change();
            $table->string('do_number')->nullable(false)->change();
            $table->date('do_date')->nullable(false)->change();
            $table->unsignedBigInteger('project_id')->nullable(false)->change();
            $table->unsignedBigInteger('vehicle_id')->nullable(false)->change();
        });
    }
};
