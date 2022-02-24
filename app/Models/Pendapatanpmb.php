<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatanpmb extends Model
{
    use HasFactory;
    protected $table = 'pendapatanpmbs';
    protected $fillable = ['kode_rekening', 'nominal', 'noformuir', 'notes' , 'nimsementara', 'nama', 'kode_prodi', 'bank', 'jurnal_id', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
