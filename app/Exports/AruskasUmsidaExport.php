<?php

namespace App\Exports;


use Session;
use App\Models\Coa;
use App\Models\Unitkerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class AruskasExport implements FromView, WithStyles
{ 

    protected $request;

    function __construct($request) {
            $this->request = $request;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(40, 'px');
        $sheet->getColumnDimension('B')->setWidth(40, 'px');
        $sheet->getColumnDimension('C')->setWidth(40, 'px');
        $sheet->getColumnDimension('D')->setWidth(40, 'px');
        $sheet->getColumnDimension('E')->setWidth(400, 'px');
        $sheet->getColumnDimension('F')->setWidth(120, 'px');
        $sheet->getColumnDimension('G')->setWidth(120, 'px');
        $sheet->getColumnDimension('H')->setWidth(120, 'px');

        $sheet->getStyle('B2:H4')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setRGB('002060');

        $sheet->getStyle('B6:H6')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setRGB('002060');

        return [
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2    => ['font' => ['bold' => true, 'size' => 16, 'color' => array('rgb' => 'FFFFFF')], 'alignment' => ['horizontal' => 'center']],
            3    => ['font' => ['bold' => true, 'size' => 16, 'color' => array('rgb' => 'FFFFFF')], 'alignment' => ['horizontal' => 'center']],
            4    => ['font' => ['bold' => true, 'size' => 16, 'color' => array('rgb' => 'FFFFFF')], 'alignment' => ['horizontal' => 'center']],
            6    => ['font' => ['bold' => true, 'size' => 14, 'color' => array('rgb' => 'FFFFFF')], 'alignment' => ['horizontal' => 'center']],            
        ];
    }

    public function view(): View
    {
        $bulan_periode = 1;
        if(isset($this->request->search["bulan_periode"])){
            $bulan_periode = $this->request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($this->request->search["tahun_periode"])){
            $tahun_periode = $this->request->search["tahun_periode"];
        }
        $unitkerja = 0;
        if(isset($this->request->search["unitkerja"])){
            $unitkerja = $this->request->search["unitkerja"];
        }

        $dt = array();
        $no = 0;
        $yearopen = Session::get('global_setting');
        
        $jenis_aktivitas = "";
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.category", "coas.coa", DB::raw("2 as level_coa"), "coas.fheader", DB::raw("SUM(aruskass.debet) as debet"), DB::raw("SUM(aruskass.credit) as credit"), "coas.jenis_aktivitas"])
        ->leftJoin('aruskass', 'coas.id', '=', 'aruskass.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("aruskass.debet","!=",0)->orWhere("aruskass.credit","!=",0);
            });
        })
        ->where(function($q){
            $q->where(function($q){
                $q->whereNotNull("coas.jenis_aktivitas")->orWhere("coas.jenis_aktivitas","!=","");
            });
        })->whereNull("coas.fheader")
        ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("aruskass.unitkerja", $unitkerja);
            }
        })
        ->where("bulan_periode",  $bulan_periode)->where("tahun_periode", $tahun_periode)
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", "coas.jenis_aktivitas"])
        ->orderBy("coas.jenis_aktivitas", "asc")
        ->orderBy("coas.id", "asc")
          ->get() as $aruskas){
            if($jenis_aktivitas != $aruskas->jenis_aktivitas){
                array_push($dt, array(0, "", $aruskas->jenis_aktivitas, "", "", 0, 1, "on", $aruskas->jenis_aktivitas));
                $jenis_aktivitas = $aruskas->jenis_aktivitas;
            }
            
            $coa_name_debet = "";
            $coa_name_credit = "";
            if(in_array($aruskas->category, array("aset", "biaya", "biaya_lainnya"))){
                if(in_array($aruskas->category, array("aset"))){
                    $coa_name_debet = "Penerimaan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengeluaran ".$aruskas->coa_name;
                }else{
                    $coa_name_debet = "Penambahan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengurangan ".$aruskas->coa_name;
                }
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
            }else{
                $coa_name_debet = "Pengurangan ".$aruskas->coa_name;
                $coa_name_credit = "Penambahan ".$aruskas->coa_name;
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
            }
        }

        $uk = null;
        if($unitkerja != null && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }

        $saldo_awal = $this->get_saldo_awal();
        array_unshift($dt, array(0, "SALDO AWAL", "SALDO AWAL", $saldo_awal, 0, "", null, ""));

        $output = array(
            "draw" => intval($this->request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt,
            "bulan" => $this->convertBulan($bulan_periode), 
            "tahun" => $tahun_periode,
            "unitkerja" => $unitkerja, 
            "unitkerja_label" => $uk?$uk->unitkerja_name:""
        );

        return view('aruskas.excel', [
            'transactions' => $output
        ]);
    }

    function get_saldo_awal()
    {
        $bulan_periode = 1;
        if(isset($this->request->search["bulan_periode"])){
            $bulan_periode = $this->request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($this->request->search["tahun_periode"])){
            $tahun_periode = $this->request->search["tahun_periode"];
        }
        $unitkerja = 0;
        if(isset($this->request->search["unitkerja"])){
            $unitkerja = $this->request->search["unitkerja"];
        }

        $dt = array();
        $no = 0;
        $yearopen = Session::get('global_setting');
        
        $nominal_saldo_awal = 0;
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.category", "coas.coa", DB::raw("2 as level_coa"), "coas.fheader", DB::raw("SUM(aruskass.debet) as debet"), DB::raw("SUM(aruskass.credit) as credit"), "coas.jenis_aktivitas"])
        ->leftJoin('aruskass', 'coas.id', '=', 'aruskass.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("aruskass.debet","!=",0)->orWhere("aruskass.credit","!=",0);
            });
        })
        ->where(function($q){
            $q->where(function($q){
                $q->whereNotNull("coas.jenis_aktivitas")->orWhere("coas.jenis_aktivitas","!=","");
            });
        })->whereNull("coas.fheader")
        ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("aruskass.unitkerja", $unitkerja);
            }
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", "coas.jenis_aktivitas"])
        ->orderBy("coas.jenis_aktivitas", "asc")
        ->orderBy("coas.id", "asc")
        ->get() as $aruskas){
            if(in_array($aruskas->category, array("aset", "biaya", "biaya_lainnya"))){
                if($aruskas->debet != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+$aruskas->debet;
                }
                if($aruskas->credit != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->credit*(-1));
                }
            }else{
                if($aruskas->debet != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->debet*(-1));
                }
                if($aruskas->credit != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->credit*(-1));
                }
            }
        }

        return $nominal_saldo_awal;
    }

    public function convertBulan($bulan){
        $nmb = "";
        switch(date("F", mktime(0, 0, 0, $bulan, 10)))
        {
            case 'January':     $nmb="Januari";     break; 
            case 'February':    $nmb="Februari";    break; 
            case 'March':       $nmb="Maret";       break; 
            case 'April':       $nmb="April";       break; 
            case 'May':         $nmb="Mei";         break; 
            case 'June':        $nmb="Juni";        break; 
            case 'July':        $nmb="Juli";        break;
            case 'August':      $nmb="Agustus";     break;
            case 'September':   $nmb="September";   break;
            case 'October':     $nmb="Oktober";     break;
            case 'November':    $nmb="November";    break;
            case 'December':    $nmb="Desember";    break;
        }
        return $nmb;
    }

    public function convertCode($data, $level){
        $val = substr($data,0,1) . "-" . substr($data,1,2) . "-" . substr($data,3,2) . "-" . substr($data,5);
        $padd = (((int) $level-1)*2);
        $html = str_repeat(' ',strval($padd))." ".$val;        
        return $html;
    }
}