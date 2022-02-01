<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $table = 'approvals';
    protected $fillable =  ['parent_id', 'no_seq', 'role', 'role_label', 'jenismenu', 'user', 'user_label', 'komentar', 'status_approval', 'status_approval_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getKegiatan(){
        return $this->hasOne('App\Models\Kegiatan');
    }
}
