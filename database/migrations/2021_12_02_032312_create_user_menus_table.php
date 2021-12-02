<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_menus', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("menu_id");
            $table->string("is_granted")->nullable();
            $table->integer("mp_sequence");
            $table->integer("m_sequence");
            $table->string("menu_name");
            $table->string("url");
            $table->string("menu_icon")->nullable();
            $table->integer("parent_id")->nullable();
            $table->string("is_group_menu")->nullable();
            $table->string("is_shown_at_side_menu")->nullable();
            $table->string("is_view")->nullable();
            $table->string("mainmenu")->nullable();
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
        Schema::dropIfExists('user_menus');
    }
}
