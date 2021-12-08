<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpencloseperiodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opencloseperiodes', function (Blueprint $table) {
            $table->id();
            $table->enum('bulan_open', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
            $table->string('bulan_open_label', 255)->nullable();
            $table->string('tahun_open');
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('opencloseperiodes');
    }
}
