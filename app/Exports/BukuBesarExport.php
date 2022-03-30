<?php

namespace App\Exports;

use App\Models\Coa;
use App\Models\Transaction;
use App\Models\Unitkerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuBesarExport implements FromView, WithStyles
{ 

    protected $request;

    function __construct($request) {
            $this->request = $request;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(100, 'px');
        $sheet->getColumnDimension('B')->setWidth(100, 'px');
        $sheet->getColumnDimension('C')->setWidth(200, 'px');
        $sheet->getColumnDimension('D')->setWidth(200, 'px');
        $sheet->getColumnDimension('E')->setWidth(150, 'px');
        $sheet->getColumnDimension('F')->setWidth(150, 'px');

        $sheet->getStyle('A7:F7')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setRGB('d2e1ff');

        return [
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2    => ['font' => ['bold' => true, 'size' => 13], 'alignment' => ['horizontal' => 'center']],
            3    => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center']],
            4    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center']],
            7    => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],

            'A7:F100' => ['borders' => ['allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ]]],
        ];
    }

    public function view(): View
    {
        $coa = null;
        $list_column = array("id","tanggal", "coa_code", "no_jurnal", "deskripsi", "keterangan", "debet", "kredit");
        
        $keyword = null;
        
        if(isset($this->request->search["value"])){
            $keyword = $this->request->search["value"];
        }
        if(isset($this->request->search["coa_code"])){
            $coa = $this->request->search["coa_code"];
        }
        $bulan_periode = 1;
        if(isset($this->request->search["bulan_periode"])){
            $bulan_periode = $this->request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($this->request->search["tahun_periode"])){
            $tahun_periode = $this->request->search["tahun_periode"];
        }
        $tanggal_jurnal_from = date('Y-m-d');
        if(isset($this->request->search["tanggal_jurnal_from"])){
            $tanggal_jurnal_from = $this->request->search["tanggal_jurnal_from"];
        }
        $tanggal_jurnal_to = date('Y-m-d');
        if(isset($this->request->search["tanggal_jurnal_to"])){
            $tanggal_jurnal_to = $this->request->search["tanggal_jurnal_to"];
        }

        $unitkerja = 0;
        if(isset($this->request->search["unitkerja"])){
            $unitkerja = $this->request->search["unitkerja"];
        }

        $dt = array();
        $dc = "";
        $no = 0;
        $deb_total = 0;
        $cre_total = 0;
        $sal_deb = "";
        $sal_cre = "";
        $cat = $coa[0];

        foreach((Coa::where("id", (int) $coa)->get()) as $coas){
            $dc = $coas->coa_code ." - ". $coas->coa_name;
        }

        foreach((Transaction::where("coa", (int) $coa)
          ->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })
            ->whereBetween("tanggal", [$tanggal_jurnal_from, $tanggal_jurnal_to])
          ->whereNull('isdeleted')
          ->where(function($q) use ($unitkerja){
            if($unitkerja != 'null' && $unitkerja != 0){
                $q->where("unitkerja", $unitkerja);
            }
        })
          ->get(["id", "tanggal", "no_jurnal", "deskripsi", "keterangan", "debet", "credit"])) as $bukubesar){
        
            $no = $no+1;
            $deb = $bukubesar->debet;
            $cre = $bukubesar->credit;
            array_push($dt, array($bukubesar->id, $bukubesar->tanggal, $bukubesar->no_jurnal, $bukubesar->deskripsi, $bukubesar->keterangan, $deb, $cre));
            $deb_total += (int) $bukubesar->debet;
            $cre_total += (int) $bukubesar->credit;
        }

        if($cat == 1 || $cat == 5|| $cat == 6){
            $saldo = $deb_total-$cre_total;
            if($saldo>0) $sal_cre = $saldo;
            else $sal_deb = $saldo;
          } else {
            $saldo = $cre_total-$deb_total;
            if($saldo>0) $sal_deb = $saldo;
            else $sal_cre = $saldo;
          }

        $uk = null;
        if($unitkerja != 'null' && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }

        $output = array(
            "draw" => intval($this->request->draw),
            "recordsTotal" => Transaction::where("coa", $coa)
                                ->where(function($q) {
                                    $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                                }),
            "recordsFiltered" => 0,
            "data" => $dt,
            "deb" => (int) $deb_total,
            "cre" => (int) $cre_total,
            "sal_deb" => (int) $sal_deb,
            "sal_cre" => (int) $sal_cre,
            "bulan" => $tanggal_jurnal_from . ' - ', 
            "tahun" => $tanggal_jurnal_to, 
            "unitkerja" => $unitkerja, 
            "unitkerja_label" => $uk?$uk->unitkerja_name:"",
            "coa" => $dc, 
        );

        return view('bukubesar.excel', [
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
}