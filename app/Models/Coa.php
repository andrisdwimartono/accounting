<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;
    protected $table = 'coas';
    protected $fillable = ['coa_code', 'coa_name', 'level_coa', 'coa', 'coa_label', 'category', 'category_label', 'fheader', 'factive', 'prodi', 'prodi_label', 'jenisbayar', 'jenisbayar_label', 'kode_jenisbayar', 'jeniscoa', 'unitkerja', 'unitkerja_label', 'jenis_aktivitas', 'user_creator_id', 'user_updater_id', 'updated_at'];

    //each category might have one parent
    public function parent() {
        return $this->belongsToOne(static::class, 'coa');
    }

    //each category might have multiple children
    public function children() {
        return $this->hasMany(static::class, 'coa')->orderBy('coa_code', 'asc');
    }

    public function neracas()
    {
        return $this->hasMany('App\Models\Neraca','coa','id');
    }

    function getCoa(){
        return $this->hasOne('App\Models\Coa')->orderBy('no_seq', 'ASC');
    }

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }
}
