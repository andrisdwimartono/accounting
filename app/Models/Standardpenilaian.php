<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standardpenilaian extends Model
{
    use HasFactory;
    protected $table = 'standardpenilaians';
    protected $fillable = ['category', 'category_label', 'tahun', 'bulan', 'smallest_value', 'median_value', 'biggest_value', 'keputusan_1', 'keputusan_2', 'keputusan_3', 'keputusan_4', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
