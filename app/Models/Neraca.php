<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neraca extends Model
{
    use HasFactory;
    protected $table = 'neracas';
    protected $fillable = ['tahun_periode', 'bulan_periode', 'coa', 'coa_label', 'fheader', 'debet', 'credit', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }
}
