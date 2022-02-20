<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outputrka extends Model
{
    use HasFactory;
    protected $table = 'outputrkas';
    protected $fillable = ['parent_id', 'no_seq', 'iku', 'iku_label', 'indikator', 'keterangan', 'target', 'satuan_target', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getKegiatan(){
        return $this->hasOne('App\Models\Kegiatan');
    }
}
