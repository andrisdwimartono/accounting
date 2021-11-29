<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('coas', function (Blueprint $table) {
    $table->integer('prodi');
    $table->string('prodi_label');
    $table->integer('jenisbayar');
    $table->string('jenisbayar_label');
});