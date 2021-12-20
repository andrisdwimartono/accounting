<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodis';
    protected $fillable = ['prodi_name', 'kode', 'fakultas', 'fakultas_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getFakultas(){
        return $this->hasOne('App\Models\Fakultas')->orderBy('no_seq', 'ASC');
    }
}
