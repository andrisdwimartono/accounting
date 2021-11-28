<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('prodi', function (Blueprint $table) {
    $table->id();
    $table->string('kode');
    $table->string('nama');
    $table->integer('user_creator_id')->nullable();
    $table->integer('user_updater_id')->nullable();
    $table->timestamps();
});