<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('globalsettings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi', 255);
            $table->string('logo_instansi')->nullable();
            $table->enum('bulan_tutup_tahun', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
            $table->string('bulan_tutup_tahun_label', 255)->nullable();
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
        Schema::dropIfExists('globalsettings');
    }
}
