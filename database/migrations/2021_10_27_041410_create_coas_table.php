<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->string('coa_code', 20);
            $table->string('coa_name', 255);
            $table->string('level_coa', 4)->default("1");
            $table->integer('coa')->nullable();
            $table->string('coa_label', 255)->nullable();
            $table->enum('category', ['aset', 'hutang', 'modal', 'pendapatan', 'biaya', 'biaya_lainnya', 'pendapatan_lainnya']);
            $table->string('category_label', 255)->nullable();
            $table->string('fheader')->nullable();
            $table->string('factive')->nullable();
            $table->integer('prodi')->nullable();
            $table->string('prodi_label', 255)->nullable();
            $table->integer('jenisbayar')->nullable();
            $table->string('jenisbayar_label', 255)->nullable();
            $table->string('jeniscoa', 255)->nullable();
            $table->integer('unitkerja')->nullable();
            $table->string('unitkerja_label', 255)->nullable();
            $table->string('jenis_aktivitas', 255)->nullable();
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
        Schema::dropIfExists('coas');
    }
}
