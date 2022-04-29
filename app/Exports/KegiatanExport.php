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
            

            'A6:G7' => ['borders' => ['allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ]]],
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
        ->select(["coas.coa_label", "coas.coa_name", "coas.coa_code", "potensipendapatans.nominalpendapatan"])->get();

        $detailbiayakegiatan = Kegiatan::whereBetween("kegiatans.tanggal", [$tahun_periode."-01-01", $tahun_periode."-12-31"])
        ->leftJoin("detailbiayakegiatans", "detailbiayakegiatans.parent_id", "=", "kegiatans.id")
        ->leftJoin("coas", "detailbiayakegiatans.coa", "=", "coas.id")
        ->whereNotNull("detailbiayakegiatans.id")
        ->select(["coas.coa_label", "coas.coa_name", "coas.coa_code", "detailbiayakegiatans.nominalbiaya"])->get();
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