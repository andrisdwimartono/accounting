<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankvas', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->string("kode_va", 255);
            $table->integer('coa');
            $table->string('coa_label', 255)->nullable();
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
        Schema::dropIfExists('bankvas');
    }
}
