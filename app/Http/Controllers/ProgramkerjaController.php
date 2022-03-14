<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Programkerja;
use App\Models\Detailbiayaproker;
use App\Models\Satuan;

class ProgramkerjaController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Program Kerja",
            "page_data_urlname" => "programkerja",
            "fields" => [
                "programkerja_code" => "text",
                "programkerja_name" => "text",
                "deskripsi_programkerja" => "textarea",
                "type_programkerja" => "text",
                "ct1_detailbiayaproker" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_detailbiayaproker" => [
                    "detailbiayaproker_name" => "text",
                    "deskripsibiaya" => "textarea",
                    "standarbiaya" => "float",
                    "volume" => "float",
                    "satuan" => "link"
                ]
            ],
            "fieldlink" => [
                "satuan" => "satuans"
            ]
        ];

        $td["fieldsrules"] = [
            "programkerja_code" => "nullable",
            "programkerja_name" => "required",
            "deskripsi_programkerja" => "nullable",
            "type_programkerja" => "nullable",
            "ct1_detailbiayaproker" => "nullable"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_detailbiayaproker"] = [
            "detailbiayaproker_name" => "required",
            "deskripsibiaya" => "nullable",
            "standarbiaya" => "required|numeric",
            "volume" => "required|numeric",
            "satuan" => "nullable|exists:satuans,id"
        ];

        $td["fieldsmessages_ct1_detailbiayaproker"] = [
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
        $page_data["footer_js_page_specific_script"] = ["programkerja.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["programkerja.page_specific_script.header_js_list"];
        
        return view("programkerja.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["programkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["programkerja.page_specific_script.header_js_create"];
        
        return view("programkerja.create", ["page_data" => $page_data]);
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
        $rules_ct1_detailbiayaproker = $page_data["fieldsrules_ct1_detailbiayaproker"];
        $requests_ct1_detailbiayaproker = json_decode($request->ct1_detailbiayaproker, true);
        foreach($requests_ct1_detailbiayaproker as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_detailbiayaproker"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_detailbiayaproker, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Programkerja::create([
                //"programkerja_code"=> $request->programkerja_code,
                "programkerja_name"=> $request->programkerja_name,
                "deskripsi_programkerja"=> $request->deskripsi_programkerja,
                "type_programkerja"=> $request->type_programkerja,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            
            $this->generateKodePK($id);

            foreach($requests_ct1_detailbiayaproker as $ct_request){
                Detailbiayaproker::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "detailbiayaproker_name"=> $ct_request["detailbiayaproker_name"],
                    "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                    "standarbiaya"=> $ct_request["standarbiaya"],
                    "volume"=> $ct_request["volume"],
                    "satuan"=> $ct_request["satuan"],
                    "satuan_label"=> $ct_request["satuan_label"],
                    "user_creator_id" => Auth::user()->id
                ]);
            }

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
    public function show(Programkerja $programkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["programkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["programkerja.page_specific_script.header_js_create"];
        
        $page_data["id"] = $programkerja->id;
        return view("programkerja.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Programkerja $programkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["programkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["programkerja.page_specific_script.header_js_create"];
        
        $page_data["id"] = $programkerja->id;
        return view("programkerja.create", ["page_data" => $page_data]);
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
        $rules_ct1_detailbiayaproker = $page_data["fieldsrules_ct1_detailbiayaproker"];
        $requests_ct1_detailbiayaproker = json_decode($request->ct1_detailbiayaproker, true);
        foreach($requests_ct1_detailbiayaproker as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_detailbiayaproker"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_detailbiayaproker, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Programkerja::where("id", $id)->update([
                //"programkerja_code"=> $request->programkerja_code == ''?null:$request->programkerja_code,
                "programkerja_name"=> $request->programkerja_name,
                "deskripsi_programkerja"=> $request->deskripsi_programkerja == ''?null:$request->deskripsi_programkerja,
                "type_programkerja"=> $request->type_programkerja == ''?null:$request->type_programkerja,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_ct1_detailbiayaproker as $ct_request){
                if(isset($ct_request["id"])){
                    Detailbiayaproker::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "detailbiayaproker_name"=> $ct_request["detailbiayaproker_name"] == ''?null:$ct_request["detailbiayaproker_name"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"] == ''?null:$ct_request["deskripsibiaya"],
                        "standarbiaya"=> $ct_request["standarbiaya"] == ''?null:$ct_request["standarbiaya"],
                        "volume"=> $ct_request["volume"] == ''?null:$ct_request["volume"],
                        "satuan"=> $ct_request["satuan"] == ''?null:$ct_request["satuan"],
                        "satuan_label"=> $ct_request["satuan_label"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Detailbiayaproker::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "detailbiayaproker_name"=> $ct_request["detailbiayaproker_name"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "standarbiaya"=> $ct_request["standarbiaya"],
                        "volume"=> $ct_request["volume"],
                        "satuan"=> $ct_request["satuan"],
                        "satuan_label"=> $ct_request["satuan_label"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Detailbiayaproker::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_detailbiayaproker as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Detailbiayaproker::whereId($ch->id)->delete();
                    }
                }

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
            $programkerja = Programkerja::whereId($request->id)->first();
            if(!$programkerja){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Programkerja::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "programkerja_code", "programkerja_name", "id");
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
        $no = 0;
        foreach(Programkerja::where(function($q) use ($keyword) {
            $q->where("programkerja_code", "LIKE", "%" . $keyword. "%")->orWhere("programkerja_name", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "programkerja_code", "programkerja_name"]) as $programkerja){
            $no = $no+1;
            $act = '
            <a href="/programkerja/'.$programkerja->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/programkerja/'.$programkerja->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($programkerja->id, $programkerja->programkerja_code, $programkerja->programkerja_name, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Programkerja::get()->count(),
            "recordsFiltered" => intval(Programkerja::where(function($q) use ($keyword) {
                $q->where("programkerja_code", "LIKE", "%" . $keyword. "%")->orWhere("programkerja_name", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $programkerja = Programkerja::whereId($request->id)->first();
            if(!$programkerja){
                abort(404, "Data not found");
            }

            $ct1_detailbiayaprokers = Detailbiayaproker::whereParentId($request->id)->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayaproker" => $ct1_detailbiayaprokers,
                    "programkerja" => $programkerja
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
            if($request->field == "satuan"){
                $lists = Satuan::where(function($q) use ($request) {
                    $q->where("satuan_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("satuan_name as text")]);
                $count = Satuan::count();
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

    public function generateKodePK($id){
        $programkerja_code = "";
        for($i = 0; $i < 3-strlen((string)$id); $i++){
            $programkerja_code .= "0";
        }
        $programkerja_code .= $id;
        $programkerja_code .= "-";
        $programkerja_code .= substr(explode("-", date('Y-m-d'))[0], 2);
        $programkerja_code .= "-";
        $programkerja_code .= 'PK';

        Programkerja::where("id", $id)->update([
            "programkerja_code"=> $programkerja_code
        ]);
        return $programkerja_code;
    }
}