<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'satuans';
    protected $fillable = ['satuan_name', 'satuan_katerangan', 'type_satuan', 'type_satuan_label', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
