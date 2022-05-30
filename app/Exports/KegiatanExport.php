<?php

namespace App\Exports;


use Session;
use App\Models\Coa;
use App\Models\Unitkerja;
use App\Models\Transaction;
use App\Models\Potensipendapatan;
use App\Models\Settingpagupendapatan;
use App\Models\Kegiatan;
use App\Models\Detailbiayakegiatan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class KegiatanExport implements FromView, WithStyles
{ 

    protected $request;

    function __construct($request) {
            $this->request = $request;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(4, 'px');
        $sheet->getColumnDimension('B')->setWidth(10, 'px');
        $sheet->getColumnDimension('C')->setWidth(3, 'px');
        $sheet->getColumnDimension('D')->setWidth(3, 'px');
        $sheet->getColumnDimension('E')->setWidth(400, 'px');
        $sheet->getColumnDimension('F')->setWidth(150, 'px');
        $sheet->getColumnDimension('G')->setWidth(200, 'px');
        $sheet->getColumnDimension('H')->setWidth(200, 'px');
        

        // $sheet->getStyle('A6:C6')->getFill()
        //       ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        //       ->getStartColor()->setRGB('d2e1ff');

        return [
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            2    => ['font' => ['bold' => true, 'size' => 13], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            3    => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            4    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            5    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            6    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            7    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            8    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center', 'vertical' => 'center']],
            

            'A6:H7' => ['borders' => ['allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ]]],
            'G:H' => 
                ['numberFormat' => ['formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
            ]]
        ];
    }

    public function view(): View
    {
        $tahun_periode = date("Y");
        if(isset($this->request->search["tahun_periode"])){
            $tahun_periode = $this->request->search["tahun_periode"];
        }
        $potensipendapatan = Settingpagupendapatan::where("settingpagupendapatans.tahun", $tahun_periode)
        ->leftJoin("potensipendapatans", "potensipendapatans.parent_id", "=", "settingpagupendapatans.id")
        ->leftJoin("coas", "potensipendapatans.coa", "=", "coas.id")
        ->whereNotNull("potensipendapatans.id")
        ->select(["coas.coa_label", "coas.coa_name", "coas.coa_code", "potensipendapatans.nominalpendapatan"])->orderBy("coas.coa_code")->get();

        $detailbiayakegiatan = Coa::leftJoin(DB::Raw("(SELECT kegiatans.kegiatan_name, detailbiayakegiatans.coa, detailbiayakegiatans.nominalbiaya FROM detailbiayakegiatans 
        INNER JOIN kegiatans ON kegiatans.id = detailbiayakegiatans.parent_id
        WHERE kegiatans.tanggal between '".$tahun_periode."-01-01' AND '".$tahun_periode."-12-31'
        ) as detailbiayakegiatans"), function($join){
           $join->on('coas.id', '=', 'detailbiayakegiatans.coa');
        })
        ->leftJoin(DB::Raw("(SELECT plafon_kegiatans.kegiatan_name, plafon_kegiatans.coa, SUM(plafon_kegiatans.plafon) as plafon FROM plafon_kegiatans 
        WHERE plafon_kegiatans.tahun = '".$tahun_periode."'
        GROUP BY plafon_kegiatans.coa, plafon_kegiatans.kegiatan_name
        ) as plafon_kegiatans"), function($join){
           $join->on('coas.id', '=', 'plafon_kegiatans.coa');
        })
        ->where(function($q){
            $q->whereNotNull("detailbiayakegiatans.coa")->orWhereNotNull("plafon_kegiatans.coa");
        })
        ->select(["coas.coa_label", "detailbiayakegiatans.kegiatan_name as coa_name", "plafon_kegiatans.kegiatan_name as coa_name2", "coas.coa_code", "nominalbiaya", "plafon"])
        ->orderBy("coas.coa_code")->get();

        $output = array(
            "potensipendapatan" => $potensipendapatan,
            "detailbiayakegiatan" => $detailbiayakegiatan
        );

        return view('plafon_kegiatan.excel', [
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
}