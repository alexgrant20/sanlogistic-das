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
    Schema::create('vehicles_checklists', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->foreignId('vehicle_id');
      $table->foreignId('address_id');
      $table->integer('odo');
      $table->smallInteger('lampu_besar');
      $table->smallInteger('lampu_kota');
      $table->smallInteger('lampu_rem');
      $table->smallInteger('lampu_sein');
      $table->smallInteger('lampu_mundur');
      $table->smallInteger('exhaust_brake');
      $table->smallInteger('spion');
      $table->smallInteger('wiper');
      $table->smallInteger('ban_depan');
      $table->smallInteger('ban_belakang_dalam');
      $table->smallInteger('ban_belakang_luar');
      $table->smallInteger('ban_serep');
      $table->smallInteger('tekanan_angin_ban_depan');
      $table->smallInteger('tekanan_angin_ban_belakang_dalam');
      $table->smallInteger('tekanan_angin_ban_belakang_luar');
      $table->smallInteger('tekanan_angin_ban_serep');
      $table->smallInteger('velg_ban_depan');
      $table->smallInteger('velg_ban_belakang_dalam');
      $table->smallInteger('velg_ban_belakang_luar');
      $table->smallInteger('velg_ban_serep');
      $table->smallInteger('tangki_bahan_bakar');
      $table->smallInteger('tutup_tangki_bahan_bakar');
      $table->smallInteger('tutup_radiator');
      $table->smallInteger('accu');
      $table->smallInteger('oli_mesin');
      $table->smallInteger('minyak_rem');
      $table->smallInteger('minyak_kopling');
      $table->smallInteger('oli_hidraulic');
      $table->smallInteger('klakson');
      $table->smallInteger('kaca_depan');
      $table->smallInteger('kaca_samping');
      $table->smallInteger('kaca_belakang');
      $table->smallInteger('lampu_kabin');
      $table->smallInteger('panel_speedometer');
      $table->smallInteger('panel_bahan_bakar');
      $table->smallInteger('sunvisor');
      $table->smallInteger('jok');
      $table->smallInteger('air_conditioner');
      $table->smallInteger('dongkrak');
      $table->smallInteger('kunci_roda');
      $table->smallInteger('stang_kunci_roda');
      $table->smallInteger('pipa_bantu');
      $table->smallInteger('ganjal_ban');
      $table->smallInteger('kotak_p3k');
      $table->smallInteger('apar');
      $table->smallInteger('emergency_triangle');
      $table->smallInteger('tool_kit');
      $table->smallInteger('seragam');
      $table->smallInteger('safety_shoes');
      $table->smallInteger('driver_license');
      $table->smallInteger('kartu_keur');
      $table->smallInteger('stnk');
      $table->smallInteger('helmet');
      $table->smallInteger('tatakan_menulis');
      $table->smallInteger('ballpoint');
      $table->smallInteger('lampu_senter');
      $table->smallInteger('straples');
      $table->text('catatan');
      $table->string('status');
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
    Schema::dropIfExists('vehicles_checklists');
  }
};