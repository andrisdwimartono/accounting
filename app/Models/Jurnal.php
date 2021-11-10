<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = 'jurnals';
    protected $fillable = ['unitkerja', 'unitkerja_label', 'no_jurnal', 'tanggal_jurnal', 'keterangan', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }


    function getTransaction(){
        return $this->hasMany('App\Models\Transaction')->orderBy('no_seq', 'ASC');
    }
}
