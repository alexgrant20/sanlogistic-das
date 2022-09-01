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
    Schema::table('vehicle_last_statuses', function (Blueprint $table) {
      $table->unsignedSmallInteger('lampu_besar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_kota')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_rem')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_sein')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_mundur')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('exhaust_brake')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('spion')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('wiper')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ban_depan')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ban_belakang_dalam')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ban_belakang_luar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ban_serep')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tekanan_angin_ban_depan')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tekanan_angin_ban_belakang_dalam')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tekanan_angin_ban_belakang_luar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tekanan_angin_ban_serep')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('velg_ban_depan')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('velg_ban_belakang_dalam')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('velg_ban_belakang_luar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('velg_ban_serep')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tangki_bahan_bakar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tutup_tangki_bahan_bakar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tutup_radiator')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('accu')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('oli_mesin')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('minyak_rem')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('minyak_kopling')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('oli_hidraulic')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('klakson')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kaca_depan')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kaca_samping')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kaca_belakang')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_kabin')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('panel_speedometer')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('panel_bahan_bakar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('sunvisor')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('jok')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('air_conditioner')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('dongkrak')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kunci_roda')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('stang_kunci_roda')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('pipa_bantu')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ganjal_ban')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kotak_p3k')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('apar')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('emergency_triangle')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tool_kit')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('seragam')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('safety_shoes')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('driver_license')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('kartu_keur')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('stnk')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('helmet')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('tatakan_menulis')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('ballpoint')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('lampu_senter')->nullable()->default(0)->change();
      $table->unsignedSmallInteger('straples')->nullable()->default(0)->change();
      $table->dropColumn('catatan');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // Schema::dropIfExists('vehicle_last_statuses');
  }
};