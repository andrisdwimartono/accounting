<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailpjk extends Model
{
    use HasFactory;
    protected $table = 'detailpjks';
    protected $fillable = ['parent_id', 'no_seq', 'kegiatan_id', 'detailbiayaproker_name', 'deskripsibiaya', 'standarbiaya', 'volume', 'satuan', 'satuan_label', 'status_detail', 'desc_detail', 'status', 'komentarrevisi', 'isarchived', 'archivedby', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getKegiatan(){
        return $this->hasOne('App\Models\Pjk');
    }
}
