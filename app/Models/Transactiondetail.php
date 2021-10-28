<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactiondetail extends Model
{
    use HasFactory;
    protected $table = 'transactiondetails';
    protected $fillable = ['parent_id', 'no_seq', 'coa', 'coa_label', 'description', 'debet', 'credit', 'va_code', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getTransaction(){
        return $this->hasOne('App\Models\Transaction');
    }
}
