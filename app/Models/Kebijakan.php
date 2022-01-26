<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebijakan extends Model
{
    use HasFactory;
    protected $table = 'kebijakans';
    protected $fillable = ['roa','roi','roe', 'deskripsi', 'user_creator_id', 'user_updater_id', 'updated_at'];
}
