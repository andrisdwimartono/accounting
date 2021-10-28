<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitkerja extends Model
{
    use HasFactory;
    protected $table = 'unitkerjas';
    protected $fillable = ['unitkerja_code', 'unitkerja_name', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
