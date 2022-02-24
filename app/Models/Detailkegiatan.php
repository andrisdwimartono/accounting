<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailkegiatan extends Model
{
    use HasFactory;
    protected $table = 'detailkegiatans';
    protected $fillable = ['parent_id', 'no_seq', 'detailbiayaproker_name', 'deskripsibiaya', 'standarbiaya', 'satuan', 'satuan_label', 'status', 'komentarrevisi', 'isarchived', 'archivedby', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getKegiatan(){
        return $this->hasOne('App\Models\Kegiatan');
    }
}
