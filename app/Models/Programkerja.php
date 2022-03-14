<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programkerja extends Model
{
    use HasFactory;
    protected $table = 'programkerjas';
    protected $fillable = ['programkerja_code', 'programkerja_name', 'deskripsi_programkerja', 'type_programkerja', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getDetailbiayaproker(){
        return $this->hasMany('App\Models\Detailbiayaproker')->orderBy('no_seq', 'ASC');
    }
}
