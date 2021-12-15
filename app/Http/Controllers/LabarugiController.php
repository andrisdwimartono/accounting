<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Labarugi;
use App\Models\Coa;
use App\Models\Jenisbayar;
use App\Models\Globalsetting;
use PDF;

class LabarugiController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Laba Rugi",
            "page_data_urlname" => "labarugi",
            "fields" => [
                "tahun_periode" => "integer",
                "bulan_periode" => "integer",
                "coa" => "link",
                "jenisbayar" => "link",
                "fheader" => "checkbox",
                "debet" => "float",
                "credit" => "float"
            ],
            "fieldschildtable" => [
            ],
            "fieldlink" => [
                "coa" => "coas",
                "jenisbayar" => "jenisbayars"
            ]
        ];

        $td["fieldsrules"] = [
            "tahun_periode" => "required|integer",
            "bulan_periode" => "required|integer",
            "coa" => "required|exists:coas,id",
            "jenisbayar" => "required|exists:jenisbayars,id",
            "fheader" => "required",
            "debet" => "required|numeric",
            "credit" => "required|numeric"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
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
        $page_data["page_method_name"] = "List";
        $page_data["footer_js_page_specific_script"] = ["labarugi.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["labarugi.page_specific_script.header_js_list"];
        
        return view("labarugi.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["labarugi.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("labarugi.create", ["page_data" => $page_data]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $page_data = $this->tabledesign();
        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Labarugi::create([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "jenisbayar"=> $request->jenisbayar,
                "jenisbayar_label"=> $request->jenisbayar_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "debet"=> $request->debet,
                "credit"=> $request->credit,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            return response()->json([
                'status' => 201,
                'message' => 'Created with id '.$id,
                'data' => ['id' => $id]
            ]);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Labarugi $labarugi)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["labarugi.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $labarugi->id;
        return view("labarugi.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Labarugi $labarugi)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["labarugi.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $labarugi->id;
        return view("labarugi.create", ["page_data" => $page_data]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $page_data = $this->tabledesign();
        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Labarugi::where("id", $id)->update([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "jenisbayar"=> $request->jenisbayar,
                "jenisbayar_label"=> $request->jenisbayar_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "debet"=> $request->debet,
                "credit"=> $request->credit,
                "user_updater_id"=> Auth::user()->id
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Id '.$id.' is updated',
                'data' => ['id' => $id]
            ]);
        }
}

    /**
    * Remove the specified resource from storage.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $labarugi = Labarugi::whereId($request->id)->first();
            if(!$labarugi){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Labarugi::whereId($request->id)->forceDelete()){
                $results = array(
                    "status" => 204,
                    "message" => "Deleted successfully"
                );
            }

            return response()->json($results);
        }
    }

    // public function get_list(Request $request)
    // {
    //     $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
    //     $keyword = null;
    //     if(isset($request->search["value"])){
    //         $keyword = $request->search["value"];
    //     }

    //     $bulan_periode = 1;
    //     if(isset($request->search["bulan_periode"])){
    //         $bulan_periode = $request->search["bulan_periode"];
    //     }
    //     $tahun_periode = 1;
    //     if(isset($request->search["tahun_periode"])){
    //         $tahun_periode = $request->search["tahun_periode"];
    //     }

    //     $orders = array("id", "ASC");
    //     if(isset($request->order)){
    //         $orders = array($list_column[$request->order["0"]["column"]], $request->order["0"]["dir"]);
    //     }

    //     $limit = null;
    //     if(isset($request->length) && $request->length != -1){
    //         $limit = array(intval($request->start), intval($request->length));
    //     }

    //     $dt = array();
    //     $no = 0;
    //     foreach(Labarugi::where(function($q) use ($keyword) {
    //         $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%");
    //     })->where(function($q) {
    //         $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
    //     })->where(function($q) use($bulan_periode, $tahun_periode){
    //         $q->where(function($q) use ($bulan_periode, $tahun_periode){
    //             $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
    //         })->orWhere(function($q) use ($bulan_periode, $tahun_periode){
    //             $q->where("tahun_periode", "<", $tahun_periode);
    //         });
    //     })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->select([ "coa_label", DB::raw("SUM(debet) as debet"), DB::raw("SUM(credit) as credit")])->groupBy("coa_label")->get() as $labarugi){
    //         $no = $no+1;
    //         $act = '';
    //         // '<a href="/labarugi/'.$labarugi->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

    //         // <a href="/labarugi/'.$labarugi->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

    //         // <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

    //         array_push($dt, array($no, $labarugi->coa_label, $labarugi->debet, $labarugi->credit, $act));
    // }
    //     $output = array(
    //         "draw" => intval($request->draw),
    //         "recordsTotal" => Labarugi::get()->count(),
    //         "recordsFiltered" => intval(Labarugi::where(function($q) use ($keyword) {
    //             $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%");
    //         })->where(function($q) {
    //             $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
    //         })->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->orderBy($orders[0], $orders[1])->get()->count()),
    //         "data" => $dt
    //     );

    //     echo json_encode($output);
    // }

    public function get_list(Request $request)
    {
        $list_column = array("id", "coa_code", "coa_name", "level_coa", "fheader", "factive", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
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
        if($keyword){
            $no = 0;
        foreach(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
                })->where("factive", "on")->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                    $no = $no+1;
                    $act = '';

                    if($coa->fheader == 'on'){
                        $act .= '<button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>';
                    }
                    
                    $bulan_periode = 1;
                    if(isset($request->search["bulan_periode"])){
                        $bulan_periode = $request->search["bulan_periode"];
                    }
                    $tahun_periode = 1;
                    if(isset($request->search["tahun_periode"])){
                        $tahun_periode = $request->search["tahun_periode"];
                    }
                    $child_level = 1;
                    if(isset($request->search["child_level"])){
                        $child_level = $request->search["child_level"];
                    }

                    if($coa->fheader != "on"){
                        $labarugi_val = Labarugi::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                            $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                        })->first();
                        if($labarugi_val){
                            array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $labarugi_val->debet, $labarugi_val->credit, $coa->level_coa, $coa->fheader, $act));
                        }
                    }else{
                        $dc = array(0, 0);
                        $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
                        if($dc[0] != 0  || $dc[1] != 0)
                            array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $dc[0], $dc[1], $coa->level_coa, $coa->fheader, $act));
                    }
                }
        }else{
            $this->get_list_data($dt, $request, $keyword, $limit, $orders, null);
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Coa::get()->count(),
            "recordsFiltered" => intval(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    private function get_list_data(&$dt, $request, &$keyword, $limit, $orders, $parent_id = null){
        $no = 0;
        foreach(Coa::where(function($q) use (&$keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("factive", "on")->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->where("coa", $parent_id)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                $no = $no+1;
                $act = '';

                if($coa->fheader == 'on'){
                    $act .= '<button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>';
                }
                
                $bulan_periode = 1;
                if(isset($request->search["bulan_periode"])){
                    $bulan_periode = $request->search["bulan_periode"];
                }
                $tahun_periode = 1;
                if(isset($request->search["tahun_periode"])){
                    $tahun_periode = $request->search["tahun_periode"];
                }
                $child_level = 1;
                if(isset($request->search["child_level"])){
                    $child_level = $request->search["child_level"];
                }

                if($coa->fheader != "on"){
                    $labarugi_val = Labarugi::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                        $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                    })->first();
                    if($labarugi_val){
                        array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $labarugi_val->debet, $labarugi_val->credit, $coa->level_coa, $coa->fheader, $act));
                    }
                }else{
                    $dc = array(0, 0);
                    $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
                    if($dc[0] != 0  || $dc[1] != 0)
                        array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $dc[0], $dc[1], $coa->level_coa, $coa->fheader, $act));
                }
                if((int)$coa->level_coa <= $child_level){
                    array_merge($dt, $this->get_list_data($dt, $request, $keyword, $limit, $orders, $coa->id));
                }
            
        }
        return $dt;
    }

    public function getAngka(&$dc, $parent_id, $bulan_periode, $tahun_periode){
        foreach(Coa::where("factive", "on")->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->where("coa", $parent_id)->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
            $labarugi_val = Labarugi::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })->first();
            if($labarugi_val){
                $dc[0] = $dc[0]+$labarugi_val->debet;
                $dc[1] = $dc[1]+$labarugi_val->credit;
            }
            $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
        }
        return $dc;
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $labarugi = Labarugi::whereId($request->id)->first();
            if(!$labarugi){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "labarugi" => $labarugi
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
            if($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("coa_name as text")]);
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

    public function print(Request $request){
        ini_set('max_execution_time', 300);
        $page_data = $this->tabledesign();
        $list_column = array("id", "coa_code", "coa_name", "level_coa", "fheader", "factive", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
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
        if($keyword){
            $no = 0;
        foreach(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
                })->where("factive", "on")->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                    $no = $no+1;
                    $act = '';

                    if($coa->fheader == 'on'){
                        $act .= '<button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>';
                    }
                    
                    $bulan_periode = 1;
                    if(isset($request->search["bulan_periode"])){
                        $bulan_periode = $request->search["bulan_periode"];
                    }
                    $tahun_periode = 1;
                    if(isset($request->search["tahun_periode"])){
                        $tahun_periode = $request->search["tahun_periode"];
                    }
                    $child_level = 1;
                    if(isset($request->search["child_level"])){
                        $child_level = $request->search["child_level"];
                    }

                    if($coa->fheader != "on"){
                        $labarugi_val = Labarugi::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                            $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                        })->first();
                        if($labarugi_val){
                            array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $labarugi_val->debet, $labarugi_val->credit, $coa->level_coa, $coa->fheader, $act));
                        }
                    }else{
                        $dc = array(0, 0);
                        $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
                        if($dc[0] != 0  || $dc[1] != 0)
                            array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $dc[0], $dc[1], $coa->level_coa, $coa->fheader, $act));
                    }
                }
        }else{
            $this->get_list_data($dt, $request, $keyword, $limit, $orders, null);
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Coa::get()->count(),
            "recordsFiltered" => intval(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->whereIn("category", ["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        $pdf = PDF::loadview("labarugi.print", ["labarugi" => $output,"page_data" => $page_data, "data" => $request, "globalsetting" => Globalsetting::where("id", 1)->first(), "bulan_periode" => $request->search["bulan_periode"]?$request->search["bulan_periode"]:0, "tahun_periode" => $request->search["tahun_periode"]?$request->search["tahun_periode"]:0]);
        $pdf->getDomPDF();
        $pdf->setOptions(["isPhpEnabled"=> true,"isJavascriptEnabled"=>true,'isRemoteEnabled'=>true,'isHtml5ParserEnabled' => true]);
        return $pdf->stream('labarugi.pdf');
    }

    public function convertCode($data, $level){
        $val = substr($data,0,1) . "-" . substr($data,1,2) . "-" . substr($data,3,2) . "-" . substr($data,5);
        $padd = (((int) $level-1)*20);
        $html = "<span style='padding-left:".strval($padd)."px'>".$val."</span>";        
        return $html;
    }

    public function tab($data, $level){
        $padd = (((int) $level-1)*20);
        $html = "<span style='padding-left:".strval($padd)."px'>".$data."</span>";        
        return $html;
    }
}