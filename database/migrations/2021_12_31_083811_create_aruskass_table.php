<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAruskassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aruskass', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_periode');
            $table->integer('bulan_periode');
            $table->integer('coa');
            $table->string('coa_label', 255)->nullable();
            $table->integer('jenisbayar');
            $table->string('jenisbayar_label', 255)->nullable();
            $table->string('jenis_aktivitas', 255)->nullable();
            $table->string('fheader')->nullable();
            $table->double('debet', 8, 0);
            $table->double('credit', 8, 0);
            $table->integer('unitkerja');
            $table->string('unitkerja_label', 255)->nullable();
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
        Schema::dropIfExists('aruskass');
    }
}
