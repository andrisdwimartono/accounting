<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairanrka extends Model
{
    use HasFactory;
    protected $table = 'pencairanrkas';
    protected $fillable = ['parent_id', 'no_seq', 'kegiatan', 'kegiatan_label' , 'nominalbiaya', 'user_creator_id', 'user_updater_id', 'updated_at'];
    
    function getPencairan(){
        return $this->hasOne('App\Models\Pencairan');
    }
}
