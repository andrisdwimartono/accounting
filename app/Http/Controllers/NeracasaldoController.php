<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Neracasaldo;
use App\Models\Coa;
use App\Models\Jenisbayar;

class NeracasaldoController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Neraca Saldo",
            "page_data_urlname" => "neracasaldo",
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
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["neracasaldo.page_specific_script.header_js_list"];
        
        return view("neracasaldo.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("neracasaldo.create", ["page_data" => $page_data]);
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
            $id = Neracasaldo::create([
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
    public function show(Neracasaldo $neracasaldo)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neracasaldo->id;
        return view("neracasaldo.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Neracasaldo $neracasaldo)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neracasaldo->id;
        return view("neracasaldo.create", ["page_data" => $page_data]);
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
            Neracasaldo::where("id", $id)->update([
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
            $neracasaldo = Neracasaldo::whereId($request->id)->first();
            if(!$neracasaldo){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Neracasaldo::whereId($request->id)->forceDelete()){
                $results = array(
                    "status" => 204,
                    "message" => "Deleted successfully"
                );
            }

            return response()->json($results);
        }
    }

    public function get_list(Request $request)
    {
        $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
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
        foreach(Neracasaldo::where(function($q) use ($keyword) {
            $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%")->orWhere("jenisbayar_label", "LIKE", "%" . $keyword. "%");
        })->where(function($q) {
            $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
        })->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "tahun_periode", "bulan_periode", "coa_label", "debet", "credit"]) as $neracasaldo){
            $no = $no+1;
            $act = '
            <a href="/neracasaldo/'.$neracasaldo->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/neracasaldo/'.$neracasaldo->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($neracasaldo->id, $neracasaldo->coa_label, $neracasaldo->debet, $neracasaldo->credit, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Neracasaldo::get()->count(),
            "recordsFiltered" => intval(Neracasaldo::where(function($q) use ($keyword) {
                $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%")->orWhere("jenisbayar_label", "LIKE", "%" . $keyword. "%");
            })->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $neracasaldo = Neracasaldo::whereId($request->id)->first();
            if(!$neracasaldo){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "neracasaldo" => $neracasaldo
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
}