<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvalsettings', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->string('role')->nullable();
            $table->string('role_label', 255)->nullable();
            $table->string('jenismenu');
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
        Schema::dropIfExists('approvalsettings');
    }
}
