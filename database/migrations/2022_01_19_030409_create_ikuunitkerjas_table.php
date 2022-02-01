<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIkuunitkerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ikuunitkerjas', function (Blueprint $table) {
            $table->id();
            $table->integer('iku_tahun');
            $table->string('iku_tahun_label', 255)->nullable();
            $table->integer('iku_unit_pelaksana');
            $table->string('iku_unit_pelaksana_label', 255)->nullable();
            $table->string('upload_dokumen')->nullable();
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
        Schema::dropIfExists('ikuunitkerjas');
    }
}
