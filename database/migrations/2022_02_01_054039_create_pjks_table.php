<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePjksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pjks', function (Blueprint $table) {
            $table->id();
            $table->integer('kegiatan_id');
            $table->integer('unit_pelaksana');
            $table->string('unit_pelaksana_label', 255)->nullable();
            $table->enum('tahun', ['2020', '2021', '2022', '2023']);
            $table->string('tahun_label', 255)->nullable();
            $table->integer('iku');
            $table->string('iku_label', 255)->nullable();
            $table->string('kegiatan_name');
            $table->string('Deskripsi')->nullable();
            $table->string('output')->nullable();
            $table->string('proposal')->nullable();
            $table->string('status')->nullable();
            $table->string('desc_pjk')->nullable();
            $table->string('laporan_pjk')->nullable();
            $table->integer('user_pjk')->nullable();
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
        Schema::dropIfExists('pjks');
    }
}
