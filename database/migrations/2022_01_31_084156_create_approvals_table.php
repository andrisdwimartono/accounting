<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->integer("parent_id")->nullable();
            $table->integer("no_seq")->nullable();
            $table->string('role')->nullable();
            $table->string('role_label', 255)->nullable();
            $table->string('jenismenu');
            $table->integer('user')->nullable();
            $table->string('user_label', 255)->nullable();
            $table->string('komentar')->nullable();
            $table->enum('status_approval', ['approve', 'revise', 'reject'])->nullable();
            $table->string('status_approval_label', 255)->nullable();
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
        Schema::dropIfExists('approvals');
    }
}
