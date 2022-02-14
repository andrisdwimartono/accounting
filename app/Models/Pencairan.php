<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencairan extends Model
{
    use HasFactory;
    protected $table = 'pencairans';
    protected $fillable = ['tanggal_pencairan', 'catatan', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
