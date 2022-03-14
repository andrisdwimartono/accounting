<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Unitkerja;
use App\Models\Transaction;
use App\Models\Anggaran;
use App\Models\Coa;
use App\Models\Jenisbayar;
use App\Models\Neracasaldo;
use App\Exports\BukuBesarExport;
use PDF;
use Excel;
use Session;

class BukuBesarController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Buku Besar",
            "page_data_urlname" => "bukubesar",
            "fields" => [
                "tanggal" => "text",
                "coa_code" => "text",
                "no_jurnal" => "link",
                "deskripsi" => "text",
                "debet" => "text",
                "kredit" => "text",
                "unitkerja" => "link"
            ],
            "fieldschildtable" => [
            ]
        ];

        $td["fieldsrules"] = [
        ];

        $td["fieldsmessages"] = [
        ];

        return $td;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Buku Besar";
        $page_data["footer_js_page_specific_script"] = ["bukubesar.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["bukubesar.page_specific_script.header_js_list"];
        
        return view("bukubesar.list", ["page_data" => $page_data]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["footer_js_page_specific_script"] = ["unitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("bukubesar.create", ["page_data" => $page_data]);
    }

   


    public function get_list(Request $request)
    {
        $coa = null;
        $list_column = array("id","tanggal", "coa_code", "no_jurnal", "deskripsi", "debet", "kredit");
        
        $keyword = null;
        
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }
        if(isset($request->search["coa_code"])){
            $coa = $request->search["coa_code"];
        }
        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }

        $tanggal_jurnal_from = date('Y-m-d');
        if(isset($request->search["tanggal_jurnal_from"])){
            $tanggal_jurnal_from = $request->search["tanggal_jurnal_from"];
        }
        $tanggal_jurnal_to = date('Y-m-d');
        if(isset($request->search["tanggal_jurnal_to"])){
            $tanggal_jurnal_to = $request->search["tanggal_jurnal_to"];
        }

        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
        }

        $orders = array("id", "ASC");
        if(isset($request->order)){
            $orders = array($list_column[$request->order["0"]["column"]], $request->order["0"]["dir"]);
        }

        $limit = null;
        if(isset($request->length) && $request->length != -1){
            $limit = array(intval($request->start), intval($request->length));
        }

        $dt = array();
        $no = 0;
        foreach((Transaction::where("coa", $coa)
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
          ->orderBy($orders[0], $orders[1])
          ->offset($limit[0])
          ->limit($limit[1])
          ->get(["id", "tanggal", "no_jurnal", "deskripsi", "debet", "credit"])) as $bukubesar){
            $no = $no+1;
            array_push($dt, array($bukubesar->id, $bukubesar->tanggal, $bukubesar->no_jurnal, $bukubesar->deskripsi, $bukubesar->debet, $bukubesar->credit));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Transaction::get()->count(),
            "recordsFiltered" => intval(Transaction::where(function($q) use ($keyword) {
                    $q->where("tanggal", "ILIKE", "%" . $keyword. "%")->orWhere("no_jurnal", "ILIKE", "%" . $keyword. "%")->orWhere("deskripsi", "ILIKE", "%" . $keyword. "%");
                })->where(function($q) {
                    $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                })->where("coa", $coa)
                ->whereBetween("tanggal", [$tanggal_jurnal_from, $tanggal_jurnal_to])
                ->whereNull('isdeleted')
                ->where(function($q) use ($unitkerja){
                    if($unitkerja != 'null' && $unitkerja != 0){
                        $q->where("unitkerja", $unitkerja);
                    }
                })
                ->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_saldo_awal(Request $request)
    {
        $data = $request->all();
        $coa = $data["coa"];
        // $bulan_periode = $data["bulan_periode"];
        // $tahun_periode = $data["tahun_periode"];
        $tanggal_jurnal_from = $data["tanggal_jurnal_from"];
        $tanggal_jurnal_to = $data["tanggal_jurnal_to"];
        $unitkerja = 0;
        if(isset($data["unitkerja"]) && $data["unitkerja"] != ""){
            $unitkerja = $request->search["unitkerja"];
        }
        $yearopen = Session::get('global_setting');
        $neracasaldo = Neracasaldo::select(
                DB::raw("SUM(debet) as total_debet"),
                DB::raw("SUM(credit) as total_credit"),
            )
            ->where("coa", (int)$coa)
            ->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })
            ->where(function($q) use($tanggal_jurnal_from, $yearopen){
                $bulan_periode = explode("-", $tanggal_jurnal_from)[1];
                $tahun_periode = explode("-", $tanggal_jurnal_from)[0];
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
            })
            ->where(function($q) use ($unitkerja){
                if($unitkerja != 'null' && $unitkerja != 0){
                    $q->where("aruskass.unitkerja", $unitkerja);
                }
            })
            ->groupBy("tahun_periode")
            ->get();

        $output = array(
            "data" => $neracasaldo
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $unitkerja = Unitkerja::whereId($request->id)->first();
            if(!$unitkerja){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "unitkerja" => $unitkerja
                ]
            );

            return response()->json($results);
        }
    }

    public function getoptions(Request $request)
    {
        $page_data = $this->tabledesign();
        if($request->fieldname && $page_data["fieldsoptions"][$request->fieldname]){
            return response()->json($page_data["fieldsoptions"][$request->fieldname]);
        }else{
            return response()->json();
        }
    }

    public function getlinks(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()){
            $page = $request->page;
            $resultCount = 25;

            $offset = ($page - 1) * $resultCount;

            $lists = null;
            $count = 0;
            if($request->field == "unitkerja"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "ILIKE", "%" . $request->term. "%")->orWhere("unitkerja_code", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "anggaran"){
                $lists = Anggaran::where(function($q) use ($request) {
                    $q->where("anggaran_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("anggaran_name as text")]);
                $count = Anggaran::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "ILIKE", "%" . $request->term. "%")->orWhere("coa_code", "ILIKE", "%" . $request->term. "%");
                })->where("fheader", null)->orderBy("coa_code", "asc")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text"), DB::raw("coa_name as description")]);
                $count = Coa::count();
            }elseif($request->field == "jenisbayar"){
                $lists = Jenisbayar::where(function($q) use ($request) {
                    $q->where("jenisbayar_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("jenisbayar_name as text")]);
                $count = Jenisbayar::count();
            }

            $endCount = $offset + $resultCount;
            $morePages = $endCount > $count;

            $results = array(
                "results" => $lists,
                "pagination" => array(
                    "more" => $morePages
                ),
                "total_count" => $count,
                "incomplete_results" =>$morePages,
                "items" => $lists
            );

            return response()->json($results);
        }
    }

    public function print(Request $request)
    {
        $coa = null;
        $list_column = array("id","tanggal", "coa_code", "no_jurnal", "deskripsi", "debet", "kredit");
        
        $keyword = null;
        
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }
        if(isset($request->search["coa_code"])){
            $coa = $request->search["coa_code"];
        }
        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }

        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
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

        // $coa_master = Coa::where("id",$coa)->get();
        // $dc = [$coa_master->coa_code,$coa_master->coa_name];

        foreach((Transaction::where("coa", (int) $coa)
          ->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })
          ->whereMonth("tanggal", "=", $bulan_periode)
          ->whereYear("tanggal", "=", $tahun_periode)
          ->whereNull('isdeleted')
          ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("unitkerja", $unitkerja);
            }
        })
          ->get(["id", "tanggal", "no_jurnal", "deskripsi", "debet", "credit"])) as $bukubesar){
        
            $no = $no+1;
            $deb = "<td class='rp'>Rp</td><td class='nom'><b>".number_format($bukubesar->debet,0,",",".")."</td>";
            $cre = "<td class='rp'>Rp</td><td class='nom'><b>".number_format($bukubesar->credit,0,",",".")."</td>";
            array_push($dt, array($bukubesar->id, $bukubesar->tanggal, $bukubesar->no_jurnal, $bukubesar->deskripsi, $deb, $cre));
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

        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Transaction::where("coa", $coa)
                                ->where(function($q) {
                                    $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                                }),
            "recordsFiltered" => 0,
            "data" => $dt,
            "deb" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($deb_total,0,",",".")."</b></td>",
            "cre" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($cre_total,0,",",".")."</b></td>",
            "sal_deb" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format((int) $sal_deb,0,",",".")."</b></td>",
            "sal_cre" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format((int) $sal_cre,0,",",".")."</b></td>",
        );

        

        $gs = Session::get('global_setting');
        $image =  base_path() . '/public/logo_instansi/'.$gs->logo_instansi;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $uk = null;
        if($unitkerja != null && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }
        $pdf = PDF::loadview("bukubesar.print", ["bukubesar" => $output,"data" => $request, "globalsetting" => Session::get('global_setting'), "bulan" => $this->convertBulan($bulan_periode), "tahun" => $tahun_periode, "coa" => $dc, "unitkerja" => $unitkerja, "unitkerja_label" => $uk?$uk->unitkerja_name:"", "logo" => $dataUri]);
        $pdf->getDomPDF();
        $pdf->setOptions(["isPhpEnabled"=> true,"isJavascriptEnabled"=>true,'isRemoteEnabled'=>true,'isHtml5ParserEnabled' => true]);
        return $pdf->stream('bukubesar.pdf');
    }

    public function excel(Request $request)
    {
        $date = date("m-d-Y h:i:s a", time());
        return Excel::download(new BukuBesarExport($request), 'bukubesar_'.$date.'.xlsx');
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
