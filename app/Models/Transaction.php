<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['unitkerja', 'unitkerja_label', 'journal_number', 'anggaran_name', 'transaction_date', 'description', 'transaction_type', 'transaction_type_label', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getUnitkerja(){
        return $this->hasOne('App\Models\Unitkerja')->orderBy('no_seq', 'ASC');
    }


    function getTransactiondetail(){
        return $this->hasMany('App\Models\Transactiondetail')->orderBy('no_seq', 'ASC');
    }
}
