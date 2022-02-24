<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendapatanpmbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendapatanpmbs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rekening')->nullable();
            $table->double('nominal', 8, 0)->default(0);
            $table->string('noformuir')->nullable();
            $table->string('notes')->nullable();
            $table->string('nimsementara')->nullable();
            $table->string('nama')->nullable();
            $table->string('kode_prodi')->nullable();
            $table->string('bank')->nullable();
            $table->integer('jurnal_id')->nullable();
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
        Schema::dropIfExists('pendapatanpmbs');
    }
}
