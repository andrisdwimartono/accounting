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
            $table->integer('unitkerja');
            $table->string('unitkerja_label', 255)->nullable();
            $table->string('journal_number', 25);
            $table->string('anggaran_name', 255)->nullable();
            $table->date('transaction_date');
            $table->string('description', 255)->nullable();
            $table->enum('transaction_type', ['jt1', 'jt2', 'jt3'])->nullable();
            $table->string('transaction_type_label', 255)->nullable();
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
