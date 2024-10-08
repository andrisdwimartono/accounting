<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Globalsetting extends Model
{
    use HasFactory;
    protected $table = 'globalsettings';
    protected $fillable = ['nama_instansi', 'nama_lengkap_instansi', 'logo_instansi', 'logo_sia','nama_sia','main_background', 'bulan_tutup_tahun', 'bulan_tutup_tahun_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getBankva(){
        return $this->hasMany('App\Models\Bankva')->orderBy('no_seq', 'ASC');
    }
}
