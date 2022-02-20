<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputlpjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outputlpjs', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->integer('iku');
            $table->string('iku_label', 255)->nullable();
            $table->string('Indikator');
            $table->string('keterangan');
            $table->double('target', 8, 0)->default(0);
            $table->string('satuan_target');
            $table->double('realisasi', 8, 0)->default(0)->nullable();
            $table->string('satuan_realisasi')->nullable();
            $table->string('file_bukti')->nullable();
            $table->string('link_bukti')->nullable();
            $table->double('hasil_pencapaian', 8, 0)->default(0)->nullable();
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
        Schema::dropIfExists('outputlpjs');
    }
}
