<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailbiayapjksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailbiayapjks', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->integer('coa');
            $table->string('coa_label', 255)->nullable();
            $table->string('deskripsibiaya')->nullable();
            $table->double('nominalbiaya', 8, 0);
            $table->integer("kegiatan_id");
            $table->integer("detailbiayakegiatan_id")->nullable();
            $table->string("status_detail")->nullable();
            $table->string("desc_detail")->nullable();
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
        Schema::dropIfExists('detailbiayapjks');
    }
}
