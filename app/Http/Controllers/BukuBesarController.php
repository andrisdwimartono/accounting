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
                "kredit" => "text"
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
        $startDate = null;
        $endDate = null;
        
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }
        if(isset($request->search["coa_code"])){
            $coa = $request->search["coa_code"];
        }
        if(isset($request->search["startDate"])){
            $startDate = $request->search["startDate"];
        }
        if(isset($request->search["endDate"])){
            $endDate = $request->search["endDate"];
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
        
        foreach(Transaction::where(function($q) use ($keyword, $coa, $startDate, $endDate) {
            // $q->where("deskripsi", "LIKE", "%" . $keyword. "%")
            //   ->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%");           
            if(isset($coa)){
                $q->where("coa", $coa);
            }
            if(isset($startDate)){
                $q->where("tanggal", ">=", $startDate);
            }
            if(isset($endDate)){
                $q->where("tanggal", "<=", $endDate);
            }
            if(isset($startDate) && isset($endDate)){
                $q->where("tanggal", ">=", $startDate)
                  ->where("tanggal", "<=", $endDate);
            }

        })->orderBy($orders[0], $orders[1])
          ->offset($limit[0])
          ->limit($limit[1])
          ->get(["id", "tanggal", "no_jurnal", "deskripsi", "debet", "credit"]) as $transaksi
        ){
            $no = $no+1;
            array_push($dt, array($no, $transaksi->tanggal, $transaksi->no_jurnal, $transaksi->deskripsi, $transaksi->debet, $transaksi->kredit));
        }
    
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Transaction::get()->count(),
            "recordsFiltered" => intval(Transaction::where(function($q) use ($keyword, $coa) {
                // $q->where("deskripsi", "LIKE", "%" . $keyword. "%")
                //     ->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%");
                if(isset($coa)){
                    $q->where("coa", $coa);
                }
                
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
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
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "anggaran"){
                $lists = Anggaran::where(function($q) use ($request) {
                    $q->where("anggaran_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("anggaran_name as text")]);
                $count = Anggaran::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%")->orWhere("coa_code", "LIKE", "%" . $request->term. "%");
                })->where("fheader", null)->orderBy("coa_code", "asc")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text"), DB::raw("coa_name as description")]);
                $count = Coa::count();
            }elseif($request->field == "jenisbayar"){
                $lists = Jenisbayar::where(function($q) use ($request) {
                    $q->where("jenisbayar_name", "LIKE", "%" . $request->term. "%");
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
}
