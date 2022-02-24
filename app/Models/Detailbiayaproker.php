<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailbiayaproker extends Model
{
    use HasFactory;
    protected $table = 'detailbiayaprokers';
    protected $fillable = ['parent_id', 'no_seq', 'detailbiayaproker_name', 'deskripsibiaya', 'standarbiaya', 'satuan', 'satuan_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getProgramkerja(){
        return $this->hasOne('App\Models\Programkerja');
    }
}
