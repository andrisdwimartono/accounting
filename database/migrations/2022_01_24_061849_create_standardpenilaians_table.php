<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandardpenilaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standardpenilaians', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['pendapatan', 'pengeluaran', 'pendapatan_lainnya', 'pengeluaran_lainnya']);
            $table->string('category_label', 255)->nullable();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->double('smallest_value', 8, 0)->default(0);
            $table->double('median_value', 8, 0)->default(0);
            $table->double('biggest_value', 8, 0)->default(0);
            $table->string('keputusan_1')->nullable();
            $table->string('keputusan_2')->nullable();
            $table->string('keputusan_3')->nullable();
            $table->string('keputusan_4')->nullable();
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
        Schema::dropIfExists('standardpenilaians');
    }
}
