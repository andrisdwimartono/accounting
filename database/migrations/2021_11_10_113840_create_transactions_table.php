<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->integer('unitkerja');
            $table->string('unitkerja_label', 255)->nullable();
            $table->integer('anggaran')->nullable();
            $table->string('anggaran_label', 255)->nullable();
            $table->string('no_jurnal')->nullable();
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->string('jenis_transaksi')->nullable();
            $table->integer('coa');
            $table->string('coa_label', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->integer('jenisbayar')->nullable();
            $table->string('jenisbayar_label', 255)->nullable();
            $table->string('nim')->nullable();
            $table->string('kode_va')->nullable();
            $table->string('fheader')->nullable();
            $table->double('debet', 8, 0)->default(0);
            $table->double('credit', 8, 0)->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
