<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePencairanrkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pencairanrkas', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->integer("no_seq")->nullable();
            $table->integer("kegiatan");
            $table->string("kegiatan_label")->nullable();
            $table->double('nominalbiaya', 8, 0);
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
        Schema::dropIfExists('pencairanrkas');
    }
}
