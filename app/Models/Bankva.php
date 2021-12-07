<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankva extends Model
{
    use HasFactory;
    protected $table = 'bankvas';
    protected $fillable = ['parent_id', 'no_seq', 'kode_va', 'coa', 'coa_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }

    function getGlobalsetting(){
        return $this->hasOne('App\Models\Globalsetting');
    }
}
