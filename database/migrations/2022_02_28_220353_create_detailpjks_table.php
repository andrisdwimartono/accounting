<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailpjksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpjks', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("kegiatan_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->string('detailbiayaproker_name');
            $table->string('deskripsibiaya')->nullable();
            $table->double('volume', 8, 0)->default(0);
            $table->integer('satuan')->nullable();
            $table->string('satuan_label', 255)->nullable();
            $table->double('standarbiaya', 8, 0)->default(0);
            $table->string("status_detail")->nullable();
            $table->string("desc_detail")->nullable();
            $table->string('status')->nullable();
            $table->string('komentarrevisi')->nullable();
            $table->string('isarchived')->nullable();
            $table->string('archivedby')->nullable();
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
        Schema::dropIfExists('detailpjks');
    }
}
