<?php

namespace App\Exports;


use Session;
use App\Models\Coa;
use App\Models\Unitkerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class LabarugiUmsidaExport implements FromView, WithStyles, WithDrawings
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

    public function drawings()
    {
        $gs = Session::get('global_setting');

        $drawing = new Drawing();
        $drawing->setName($gs->nama_instansi);
        $drawing->setDescription($gs->nama_lengkap_instansi);
        $drawing->setPath(public_path('/logo_instansi/'.$gs->logo_instansi));
        $drawing->setHeight(70);
        $drawing->setCoordinates('C2');

        return $drawing;
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
        $child_level = 1;
        if(isset($this->request->search["child_level"])){
            $child_level = $this->request->search["child_level"];
        }
        $unitkerja = 0;
        if(isset($this->request->search["unitkerja"])){
            $unitkerja = $this->request->search["unitkerja"];
        }
        
        $dt = array();
        $no = 0;
        $yearopen = Session::get('global_setting');
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", DB::raw("SUM(labarugis.debet) as debet"), DB::raw("SUM(labarugis.credit) as credit")]) //"neracas.debet", "neracas.credit"])//DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")])
        ->leftJoin('labarugis', 'coas.id', '=', 'labarugis.coa')
        ->whereIn('coas.category',["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])
        ->where(function($q){
            $q->where(function($q){
                $q->where("labarugis.debet","!=",0)->orWhere("labarugis.credit","!=",0);
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });  
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })
        ->where(function($q) use ($unitkerja){
            $q->where(function($q) use ($unitkerja){
                if($unitkerja != null && $unitkerja != 0){
                    $q->where("labarugis.unitkerja", $unitkerja);
                }else{
                    $q->whereNull("coas.fheader");
                }
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });
        })
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader"])
        ->orderBy("coas.level_coa", "desc")
          ->get() as $neraca){    
            $no = $no+1;
            $coa_code = $this->patokanUrutan($neraca->coa_code."");
            $dt[$neraca->id] = array($neraca->id, $neraca->coa_code, $neraca->coa_name, $neraca->debet, $neraca->credit, $neraca->coa, $neraca->level_coa, $neraca->fheader, $coa_code);
        }

        // get nominal
        $iter = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0) && ($dt[7] != "on");
        });
        
        // sum nominal to header
        foreach($iter as $key => $item){
            $d = $item;
            $deb = $item[3];
            $cre = $item[4];
            for($i=$d[6] ; $i>1 ; $i--){
                for($i=$d[6] ; $i>1 ; $i--){
                    if(array_key_exists(5, $d) && array_key_exists($d[5], $dt) && array_key_exists(3, $dt[$d[5]]) && array_key_exists(4, $dt[$d[5]])){
                        $dt[$d[5]][3] = (int) $dt[$d[5]][3] + $deb;
                        $dt[$d[5]][4] = (int) $dt[$d[5]][4] + $cre;
                        $d = $dt[$d[5]];
                    }
                }
            }
        }
        // remove null value
        $dt = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0);
            // return $dt;
        });
        // leveling
        if($child_level==0){
            $dt = array_filter($dt, function ($dt) use ($child_level) {
                return ((int)$dt[6] <= 1);
            });
        }
        
        // sort by code
        // $columns = array_column($dt, 1);
        // array_multisort($columns, SORT_ASC, $dt);
        
        // // convert array
        // $dt = array_values($dt);
        usort($dt, function($a, $b) {
            return (int)$a[8] <=> (int)$b[8];
        });
        
        // re-formatting
        $deb_total = 0;
        $cre_total = 0;
        foreach($dt as $key => $data){
            $dt[$key][1] = $this->convertCode($data[1], $data[6]);


            // total
            if($data[6]==1){
                $deb_total += (int) $data[3];
                $cre_total += (int) $data[4];
            }

            // format nominal
            if($child_level==1){
                $dt[$key][3] = $data[3];
                $dt[$key][4] = $data[4];
                if($data[7]=="on"){
                    $dt[$key][3] = "";
                    $dt[$key][4] = "";
                }    
            } else {
                $dt[$key][3] = $data[3];
                $dt[$key][4] = $data[4];
                if($data[7]!="on"){
                    $dt[$key][3] = "";
                    $dt[$key][4] = "";
                }
            }
        }
        
        $uk = null;
        if($unitkerja != null && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }

        $output = array(
            "draw" => intval($this->request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt,
            "deb" => $deb_total,
            "cre" => $cre_total,
            "bulan" => $this->convertBulan($bulan_periode), 
            "tahun" => $tahun_periode,
            "unitkerja" => $unitkerja, 
            "unitkerja_label" => $uk?$uk->unitkerja_name:""
        );

        return view('labarugi.excelumsida', [
            'transactions' => $output
        ]);
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

    public function patokanUrutan($coa_code){
        for($i = 0; $i < 12-strlen($coa_code); $i++){
            $coa_code .= '0';
        }

        return $coa_code;
    }
}