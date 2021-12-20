<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;
    protected $table = 'fakultass';
    protected $fillable = ['fakultas_name', 'fakultas_code', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
