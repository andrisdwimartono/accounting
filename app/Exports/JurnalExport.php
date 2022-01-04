<?php

namespace App\Exports;


use Session;
use App\Models\Jurnal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class JurnalExport implements FromView, WithStyles
{ 

    protected $request;

    function __construct($request) {
            $this->request = $request;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setWidth(100, 'px');
        $sheet->getColumnDimension('B')->setWidth(100, 'px');
        $sheet->getColumnDimension('C')->setWidth(150, 'px');
        $sheet->getColumnDimension('D')->setWidth(200, 'px');
        $sheet->getColumnDimension('E')->setWidth(100, 'px');
        $sheet->getColumnDimension('F')->setWidth(100, 'px');

        $sheet->getStyle('A6:F6')->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setRGB('d2e1ff');

        return [
            1    => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            2    => ['font' => ['bold' => true, 'size' => 13], 'alignment' => ['horizontal' => 'center']],
            3    => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center']],
            4    => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center']],
            6    => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],

            'A6:F100' => ['borders' => ['allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ]]],
        ];
    }

    public function view(): View
    {
        $list_column = array("id", "keterangan", "no_jurnal", "tanggal_jurnal", "id");
        
        $dt = array();
        $no = 0;
        $request = $this->request;

        $query = [];
        if(isset($request->search['jurnal_type'])){
            $query = Jurnal::where(function($q) use ($request) {
                $q->where("no_jurnal", "LIKE", "%" . $request->search['no_jurnal_search']. "%");
            })->where("no_jurnal", "LIKE", $request->search['jurnal_type']. "%")->whereNull("isdeleted")->whereBetween("tanggal_jurnal", [$request->search['tanggal_jurnal_from'], $request->search['tanggal_jurnal_to']])->orderBy("no_jurnal", $request->search['ordering'])->get(["id", "keterangan", "no_jurnal", "tanggal_jurnal"]);
        } else {
            $query = Jurnal::where(function($q) use ($request) {
                $q->where("jurnals.no_jurnal", "LIKE", "%" . $request->search['no_jurnal_search']. "%");
            })->whereNull("jurnals.isdeleted")->whereBetween("jurnals.tanggal_jurnal", [$request->search['tanggal_jurnal_from'], $request->search['tanggal_jurnal_to']])
            ->leftJoin('transactions', 'jurnals.no_jurnal', '=', 'transactions.no_jurnal')
            ->orderBy("no_jurnal", $request->search['ordering'])
            ->get(["jurnals.id", "jurnals.no_jurnal", "jurnals.tanggal_jurnal", "transactions.coa_label", "transactions.deskripsi", "transactions.debet", "transactions.credit"]);
        }

        foreach($query as $jurnal){
            $no = $no+1;
            $tanggal = $jurnal->tanggal_jurnal;
            $deb = $jurnal->debet;
            $cre = $jurnal->credit;
            // $tanggal = $this->tgl_indo($jurnal->tanggal_jurnal,"-",2,1,0);        
            array_push($dt, array($jurnal->id, $tanggal, $jurnal->no_jurnal, $jurnal->coa_label, $jurnal->deskripsi, $deb, $cre));
        }

        $tanggal_jurnal = $this->tgl_indo($this->request->search['tanggal_jurnal_from'],"/",0,1,2). " - " . $this->tgl_indo($this->request->search['tanggal_jurnal_to'],"/",0,1,2);

        $output = array(
            "draw" => intval($this->request->draw),
            "recordsTotal" => Jurnal::get()->count(),
            "recordsFiltered" => intval(Jurnal::where(function($q) use ($request) {
                $q->where("no_jurnal", "LIKE", "%" . $request->no_jurnal_search. "%");
            })->whereBetween("tanggal_jurnal", [$request->tanggal_jurnal_from, $request->tanggal_jurnal_to])->orderBy("tanggal_jurnal", "asc")->get()->count()),
            "data" => $dt,
            "tanggal" => $tanggal_jurnal
        );

        return view('jurnal.excel', [
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

    public function tgl_indo($tanggal, $sep,$d1,$d2,$d3){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode($sep, $tanggal);
        
        // variabel pecahkan 0 = tahun
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tanggal
     
        return $pecahkan[$d1] . ' ' . $bulan[ (int)$pecahkan[$d2] ] . ' ' . $pecahkan[$d3];
    }
}