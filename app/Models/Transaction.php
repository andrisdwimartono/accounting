<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['parent_id', 'no_seq', 'unitkerja', 'unitkerja_label', 'anggaran', 'anggaran_label', 'no_jurnal', 'tanggal', 'keterangan', 'jenis_transaksi', 'coa', 'coa_label', 'deskripsi', 'jenisbayar', 'jenisbayar_label', 'nim', 'kode_va', 'fheader', 'debet', 'credit', 'user_creator_id', 'user_updater_id', 'updated_at'];

    function getJurnal(){
        return $this->hasOne('App\Models\Jurnal');
    }
}
