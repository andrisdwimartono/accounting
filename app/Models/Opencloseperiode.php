<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opencloseperiode extends Model
{
    use HasFactory;
    protected $table = 'opencloseperiodes';
    protected $fillable = ['bulan_open', 'bulan_open_label', 'tahun_open', 'catatan', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
