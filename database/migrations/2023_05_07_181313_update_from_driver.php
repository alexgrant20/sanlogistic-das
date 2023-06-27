<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->foreignId('last_location_id')->nullable()->references('id')->on('addresses')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign(['last_location_id']);
            $table->dropColumn(['last_location_id']);
        });
    }
};
