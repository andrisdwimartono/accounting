<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikus', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->enum('jenis_iku', ['Visi Misi', 'Tata Pamong', 'Mahasiswa', 'Sumber Daya Manusia', 'Keuangan dan Sarpras', 'Pendidikan', 'Penelitian', 'Pengabdian Masyarakat', 'Luaran dan Capaian Tridharma', 'Jati Diri']);
            $table->string('jenis_iku_label', 255)->nullable();
            $table->string('iku_name');
            $table->string('unit_pelaksana');
            $table->string('unit_pelaksana_label');
            $table->string('tahun');
            $table->integer('unit_pendukung')->nullable();
            $table->string('unit_pendukung_label', 255)->nullable();
            $table->enum('nilai_standar_opt', ['>=', '>', '==', '<', '<=', '!='])->default('>=');
            $table->string('nilai_standar_opt_label', 255)->nullable();
            $table->double('nilai_standar');
            $table->enum('satuan_nilai_standar', ['percent', 'rp'])->nullable();
            $table->string('satuan_nilai_standar_label', 255)->nullable();
            $table->enum('nilai_baseline_opt', ['>=', '>', '==', '<', '<=', '!='])->default('>=');
            $table->string('nilai_baseline_opt_label', 255)->nullable();
            $table->double('nilai_baseline');
            $table->enum('satuan_nilai_baseline', ['percent', 'rp'])->nullable();
            $table->string('satuan_nilai_baseline_label', 255)->nullable();
            $table->enum('nilai_renstra_opt', ['>=', '>', '==', '<', '<=', '!='])->default('>=');
            $table->string('nilai_renstra_opt_label', 255)->nullable();
            $table->double('nilai_renstra');
            $table->enum('satuan_nilai_renstra', ['percent', 'rp'])->nullable();
            $table->string('satuan_nilai_renstra_label', 255)->nullable();
            $table->enum('nilai_target_tahunan_opt', ['>=', '>', '==', '<', '<=', '!='])->default('>=');
            $table->string('nilai_target_tahunan_opt_label', 255)->nullable();
            $table->double('nilai_target_tahunan');
            $table->enum('satuan_nilai_target_tahunan', ['percent', 'rp'])->nullable();
            $table->string('satuan_nilai_target_tahunan_label', 255)->nullable();
            $table->string('keterangan', 1000)->nullable();
            $table->string('sumber_data', 1000)->nullable();
            $table->string('rujukan')->nullable();
            $table->string('upload_detail')->nullable();
            $table->string('is_ikt')->nullable();
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
        Schema::dropIfExists('ikus');
    }
}
