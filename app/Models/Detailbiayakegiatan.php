<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailbiayakegiatan extends Model
{
    use HasFactory;
    protected $table = 'detailbiayakegiatans';
    protected $fillable = ['parent_id', 'no_seq', 'coa', 'coa_label', 'deskripsibiaya', 'nominalbiaya', 'status', 'komentarrevisi', 'user_creator_id', 'user_updater_id', 'updated_at', 'status'];
    
    function getKegiatan(){
        return $this->hasOne('App\Models\Kegiatan');
    }
}
