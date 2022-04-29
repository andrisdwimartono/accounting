<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlafonKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plafon_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun')->nullable();
            $table->string('tahun_label', 255)->nullable();
            $table->integer('programkerja')->nullable();
            $table->string('programkerja_label', 255)->nullable();
            $table->integer('unit_pelaksana');
            $table->string('unit_pelaksana_label', 255)->nullable();
            $table->string('kegiatan_name');
            $table->string('deskripsi')->nullable();
            $table->integer('coa')->nullable();
            $table->string('coa_label', 255)->nullable();
            $table->double('plafon', 8, 0)->default(0);
            $table->integer('user_creator_id')->nullable();
            $table->integer('user_updater_id')->nullable();
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
        Schema::dropIfExists('plafon_kegiatans');
    }
}
