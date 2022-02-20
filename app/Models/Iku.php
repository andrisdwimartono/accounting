<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    use HasFactory;
    protected $table = 'ikus';
    protected $fillable = ['no_seq', 'misi', 'bidang', 'sasaran_bidang', 'strategi', 'tahun', 'unit_pelaksana', 'unit_pelaksana_label', 'iku_name', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getIkuunitkerja(){
        return $this->hasOne('App\Models\Ikuunitkerja');
    }

}
