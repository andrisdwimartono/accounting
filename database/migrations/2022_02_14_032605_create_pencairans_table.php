<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePencairansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pencairans', function (Blueprint $table) {
            $table->id();
            $table->date("tanggal_pencairan")->nullable();
            $table->string("catatan")->nullable();
            $table->integer("jurnal")->nullable();
            $table->string("status")->nullable();
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
        Schema::dropIfExists('pencairans');
    }
}
