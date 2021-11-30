<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankva extends Model
{
    use HasFactory;
    protected $table = 'bankvas';
    protected $fillable = ['kode_va', 'coa', 'coa_label', 'updated_at'];

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }
}
