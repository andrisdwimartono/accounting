<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jurnal;
use App\Models\Unitkerja;
use App\Models\Transaction;
use App\Models\Anggaran;
use App\Models\Coa;
use App\Models\Jenisbayar;
use App\Models\Neracasaldo;
use App\Models\Neraca;

class OpencloseperiodeController extends Controller
{
    public function openperiode($open_month, $open_year){
        $neracasaldos = $this->getLastNeracaSaldo($open_month, $open_year);
        foreach($neracasaldos as $neracasaldo){
            $coa = Coa::where("id", $neracasaldo->coa)->first();
            Neracasaldo::create([
                "tahun_periode" => $open_year, 
                "bulan_periode" => $open_month, 
                "coa" => $neracasaldo->coa, 
                "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                "debet" => $neracasaldo->debet, 
                "credit" => $neracasaldo->credit, 
                "user_creator_id" => Auth::user()->id,
                "jenisbayar" => 0,
                "jenisbayar_label" => ""
            ]);
        }
        
        $neracas = $this->getLastNeraca($open_month, $open_year);
        foreach($neracas as $neraca){
            $coa = Coa::where("id", $neraca->coa)->first();
            Neraca::create([
                "tahun_periode" => $open_year, 
                "bulan_periode" => $open_month, 
                "coa" => $neraca->coa, 
                "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                "debet" => $neraca->debet, 
                "credit" => $neraca->credit, 
                "user_creator_id" => Auth::user()->id
            ]);
        }
    }

    public function getLastNeracaSaldo($open_month, $open_year){
        $month = $open_month-1;
        $year = $open_year;
        if($open_month == 1){
            $month = 12;
            $year = $open_year-1;
        }
        $neracasaldo = Neracasaldo::where("bulan_periode", $month)->where("tahun_periode", $year)->orderBy("bulan_periode", "desc")->get();
        return $neracasaldo;
    }

    public function getLastNeraca($open_month, $open_year){
        $month = $open_month-1;
        $year = $open_year;
        if($open_month == 1){
            $month = 12;
            $year = $open_year-1;
        }
        $neraca = Neraca::where("bulan_periode", $month)->where("tahun_periode", $year)->orderBy("bulan_periode", "desc")->get();
        return $neraca;
    }
}
