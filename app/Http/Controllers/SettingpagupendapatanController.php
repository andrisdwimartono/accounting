<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Settingpagupendapatan;
use App\Models\Nilaipagu;
use App\Models\Unitkerja;
use App\Models\Potensipendapatan;
use App\Models\Coa;

class SettingpagupendapatanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Setting Pagu dan Potensi Pendapatan",
            "page_data_urlname" => "settingpagupendapatan",
            "fields" => [
                "tahun" => "select",
                "ct1_nilaipagu" => "childtable",
                "ct2_potensipendapatan" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_nilaipagu" => [
                    "unitkerja" => "link",
                    "maxbiaya" => "float"
                ],
                "ct2_potensipendapatan" => [
                    "unitkerja2" => "link",
                    "coa" => "link",
                    "nominalpendapatan" => "float"
                ]
            ],
            "fieldsoptions" => [
                "tahun" => [
                    ["name" => "2018", "label" => "2018"],
                    ["name" => "2019", "label" => "2019"],
                    ["name" => "2020", "label" => "2020"],
                    ["name" => "2021", "label" => "2021"],
                    ["name" => "2022", "label" => "2022"],
                    ["name" => "2023", "label" => "2023"],
                    ["name" => "2024", "label" => "2024"]
                ]
            ],
            "fieldlink" => [
                "unitkerja" => "unitkerjas",
                "unitkerja2" => "unitkerjas",
                "coa" => "coas"
            ]
        ];

        $tahun_list = "2018,2019,2020,2021,2022,2023,2024";

        $td["fieldsrules"] = [
            "tahun" => "required|in:2018,2019,2020,2021,2022,2023,2024",
            "ct1_nilaipagu" => "required",
            "ct2_potensipendapatan" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_nilaipagu"] = [
            "unitkerja" => "required|exists:unitkerjas,id",
            "maxbiaya" => "required|numeric"
        ];

        $td["fieldsmessages_ct1_nilaipagu"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct2_potensipendapatan"] = [
            "unitkerja2" => "required|exists:unitkerjas,id",
            "coa" => "required|exists:coas,id",
            "nominalpendapatan" => "required|numeric"
        ];

        $td["fieldsmessages_ct2_potensipendapatan"] = [
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
        $page_data["footer_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.header_js_list"];
        
        return view("settingpagupendapatan.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.header_js_create"];
        
        return view("settingpagupendapatan.create", ["page_data" => $page_data]);
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
        $rules_ct1_nilaipagu = $page_data["fieldsrules_ct1_nilaipagu"];
        $requests_ct1_nilaipagu = json_decode($request->ct1_nilaipagu, true);
        foreach($requests_ct1_nilaipagu as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_nilaipagu"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_nilaipagu, $ct_messages);
        }

        $rules_ct2_potensipendapatan = $page_data["fieldsrules_ct2_potensipendapatan"];
        $requests_ct2_potensipendapatan = json_decode($request->ct2_potensipendapatan, true);
        foreach($requests_ct2_potensipendapatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct2_potensipendapatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct2_potensipendapatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Settingpagupendapatan::create([
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_nilaipagu as $ct_request){
                Nilaipagu::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "unitkerja"=> $ct_request["unitkerja"],
                    "unitkerja_label"=> $ct_request["unitkerja_label"],
                    "maxbiaya"=> $ct_request["maxbiaya"],
                    "user_creator_id" => Auth::user()->id
                ]);
            }

            foreach($requests_ct2_potensipendapatan as $ct_request){
                Potensipendapatan::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "unitkerja2"=> $ct_request["unitkerja2"],
                    "unitkerja2_label"=> $ct_request["unitkerja2_label"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "nominalpendapatan"=> $ct_request["nominalpendapatan"],
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
    public function show(Settingpagupendapatan $settingpagupendapatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $settingpagupendapatan->id;
        return view("settingpagupendapatan.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Settingpagupendapatan $settingpagupendapatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["settingpagupendapatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $settingpagupendapatan->id;
        return view("settingpagupendapatan.create", ["page_data" => $page_data]);
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
        $rules_ct1_nilaipagu = $page_data["fieldsrules_ct1_nilaipagu"];
        $requests_ct1_nilaipagu = json_decode($request->ct1_nilaipagu, true);
        foreach($requests_ct1_nilaipagu as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_nilaipagu"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_nilaipagu, $ct_messages);
        }

        $rules_ct2_potensipendapatan = $page_data["fieldsrules_ct2_potensipendapatan"];
        $requests_ct2_potensipendapatan = json_decode($request->ct2_potensipendapatan, true);
        foreach($requests_ct2_potensipendapatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct2_potensipendapatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct2_potensipendapatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Settingpagupendapatan::where("id", $id)->update([
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_ct1_nilaipagu as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Nilaipagu::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "maxbiaya"=> $ct_request["maxbiaya"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Nilaipagu::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "maxbiaya"=> $ct_request["maxbiaya"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Nilaipagu::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_nilaipagu as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Nilaipagu::whereId($ch->id)->delete();
                    }
                }

            $new_menu_field_ids = array();
            foreach($requests_ct2_potensipendapatan as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Potensipendapatan::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "unitkerja2"=> $ct_request["unitkerja2"],
                        "unitkerja2_label"=> $ct_request["unitkerja2_label"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "nominalpendapatan"=> $ct_request["nominalpendapatan"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Potensipendapatan::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "unitkerja2"=> $ct_request["unitkerja2"],
                        "unitkerja2_label"=> $ct_request["unitkerja2_label"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "nominalpendapatan"=> $ct_request["nominalpendapatan"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Potensipendapatan::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct2_potensipendapatan as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Potensipendapatan::whereId($ch->id)->delete();
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
            $settingpagupendapatan = Settingpagupendapatan::whereId($request->id)->first();
            if(!$settingpagupendapatan){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Settingpagupendapatan::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "tahun_label", "id");
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
        foreach(Settingpagupendapatan::where(function($q) use ($keyword) {
            $q->where("tahun_label", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "tahun_label"]) as $settingpagupendapatan){
            $no = $no+1;
            $act = '
            <a href="/settingpagupendapatan/'.$settingpagupendapatan->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/settingpagupendapatan/'.$settingpagupendapatan->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($settingpagupendapatan->id, $settingpagupendapatan->tahun_label, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Settingpagupendapatan::get()->count(),
            "recordsFiltered" => intval(Settingpagupendapatan::where(function($q) use ($keyword) {
                $q->where("tahun_label", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $settingpagupendapatan = Settingpagupendapatan::whereId($request->id)->first();
            if(!$settingpagupendapatan){
                abort(404, "Data not found");
            }

            $ct1_nilaipagus = Nilaipagu::whereParentId($request->id)->get();
            $ct2_potensipendapatans = Potensipendapatan::whereParentId($request->id)->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_nilaipagu" => $ct1_nilaipagus,
                    "ct2_potensipendapatan" => $ct2_potensipendapatans,
                    "settingpagupendapatan" => $settingpagupendapatan
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
            }elseif($request->field == "unitkerja2"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%");
                })->where("category", "pendapatan")->whereNull("fheader")->where("factive", "on")->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(coa_code, ' ', coa_name) as text")]);
                $count = Coa::count();
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