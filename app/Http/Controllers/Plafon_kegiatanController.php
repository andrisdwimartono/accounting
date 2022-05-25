<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Programkerja;
use App\Models\Plafon_kegiatan;
use App\Models\Detailbiayaproker;
use App\Models\Satuan;
use App\Models\Coa;
use App\Models\Unitkerja;

class Plafon_kegiatanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Plafon Kegiatan",
            "page_data_urlname" => "plafon_kegiatan",
            "fields" => [
                'tahun' => "select",
                'programkerja' => "link",
                'unit_pelaksana' => "link",
                'kegiatan_name' => "text",
                'deskripsi' => "text",
                'coa' => 'link',
                'plafon' => "float"
            ],
            "fieldschildtable" => [
                "ct1_detailbiayakegiatan" => [
                    "kegiatan_name" => "text",
                    "deskripsi" => "text",
                    "coa" => "link",
                    "plafon" => "float"
                ],
            ],
            "fieldsoptions" => [
                "tahun" => [
                    ["name" => "2020", "label" => "2020"],
                    ["name" => "2021", "label" => "2021"],
                    ["name" => "2022", "label" => "2022"],
                    ["name" => "2023", "label" => "2023"]
                ],
                
            ],
            "fieldlink" => [
                "unit_pelaksana" => "unitkerjas",
                "iku" => "ikus",
                "coa" => "coas",
                "user" => "users",
                "programkerja" => "programkerjas"
            ]
        ];

        $tahun_list = "2020,2021,2022,2023";

        $role_list = "admin,direktur,manager,staffkeuangan,staff";

        $status_approval_list = "approve,revise,reject";
        
        $status_list = "pengajuan,terima,revisi";

        $td["fieldsrules"] = [
            "unit_pelaksana" => "required|exists:unitkerjas,id",
            // "tahun" => "required|in:2020,2021,2022,2023",
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_detailbiayakegiatan"] = [
            "programkerja" => "required|exists:programkerjas,id",
            "kegiatan_name" => "required",
            "coa" => "required|exists:coas,id",
            "plafon" => "required|numeric"
        ];

        $td["fieldsmessages_ct1_detailbiayakegiatan"] = [
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
        $page_data["footer_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.header_js_list"];
        
        return view("plafon_kegiatan.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.header_js_create"];
        
        return view("plafon_kegiatan.create", ["page_data" => $page_data]);
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
        $rules_ct1_detailbiayakegiatan = $page_data["fieldsrules_ct1_detailbiayakegiatan"];
        $requests_ct1_detailbiayakegiatan = json_decode($request->ct1_detailbiayakegiatan, true);
        foreach($requests_ct1_detailbiayakegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_detailbiayakegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_detailbiayakegiatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        $mode = "create";
        if($request->validate($rules, $messages)){
            $plafon_kegiatan = Plafon_kegiatan::where("tahun", $request->tahun)->where("unit_pelaksana", $request->unit_pelaksana)->first();
            if($plafon_kegiatan){
                $mode = "update";
            }
            $new_menu_field_ids = array();
            foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                if($ct_request["id"] != ""){
                    Plafon_kegiatan::where("id", $ct_request["id"])->update([
                        'tahun' => $request->tahun,
                        'tahun_label' => $request->tahun_label,
                        'programkerja' => $ct_request["programkerja"],
                        'programkerja_label' => $ct_request["programkerja_label"],
                        'unit_pelaksana' => $request->unit_pelaksana,
                        'unit_pelaksana_label' => $request->unit_pelaksana_label,
                        'kegiatan_name' => $ct_request["kegiatan_name"],
                        'deskripsi' => $ct_request["deskripsi"],
                        'coa' => $ct_request["coa"],
                        'coa_label' => $ct_request["coa_label"],
                        'plafon' => $ct_request["plafon"],
                        "user_creator_id" => Auth::user()->id
                    ]);
                }else{
                    $id = Plafon_kegiatan::create([
                        'tahun' => $request->tahun,
                        'tahun_label' => $request->tahun_label,
                        'programkerja' => $ct_request["programkerja"],
                        'programkerja_label' => $ct_request["programkerja_label"],
                        'unit_pelaksana' => $request->unit_pelaksana,
                        'unit_pelaksana_label' => $request->unit_pelaksana_label,
                        'kegiatan_name' => $ct_request["kegiatan_name"],
                        'deskripsi' => $ct_request["deskripsi"],
                        'coa' => $ct_request["coa"],
                        'coa_label' => $ct_request["coa_label"],
                        'plafon' => $ct_request["plafon"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $id);
                }
            }

            foreach(Plafon_kegiatan::where("tahun", $request->tahun)->where("unit_pelaksana", $request->unit_pelaksana)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Plafon_kegiatan::whereId($ch->id)->delete();
                }
            }

            return response()->json([
                'status' => 201,
                'message' => $mode=="update"?'Updated':'Created'
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
    public function edit($tahun, $unit_pelaksana)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["plafon_kegiatan.page_specific_script.header_js_create"];
        
        $page_data["tahun"] = $tahun;
        $page_data["tahun_label"] = $tahun;
        $page_data["unit_pelaksana"] = $unit_pelaksana;
        $uk = Unitkerja::where("id", $unit_pelaksana)->first();
        $page_data["unit_pelaksana_label"] = "";
        if($uk){
            $page_data["unit_pelaksana_label"] = $uk->unitkerja_name;
        }
        
        return view("plafon_kegiatan.create", ["page_data" => $page_data]);
    }

//     /**
//     * Update the specified resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//     public function update(Request $request, $id)
//     {
//         $page_data = $this->tabledesign();
//         $rules_ct1_detailbiayaproker = $page_data["fieldsrules_ct1_detailbiayaproker"];
//         $requests_ct1_detailbiayaproker = json_decode($request->ct1_detailbiayaproker, true);
//         foreach($requests_ct1_detailbiayaproker as $ct_request){
//             $child_tb_request = new \Illuminate\Http\Request();
//             $child_tb_request->replace($ct_request);
//             $ct_messages = array();
//             foreach($page_data["fieldsmessages_ct1_detailbiayaproker"] as $key => $value){
//                 $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
//             }
//             $child_tb_request->validate($rules_ct1_detailbiayaproker, $ct_messages);
//         }

//         $rules = $page_data["fieldsrules"];
//         $messages = $page_data["fieldsmessages"];
//         if($request->validate($rules, $messages)){
//             Programkerja::where("id", $id)->update([
//                 //"programkerja_code"=> $request->programkerja_code == ''?null:$request->programkerja_code,
//                 "programkerja_name"=> $request->programkerja_name,
//                 "deskripsi_programkerja"=> $request->deskripsi_programkerja == ''?null:$request->deskripsi_programkerja,
//                 "type_programkerja"=> $request->type_programkerja == ''?null:$request->type_programkerja,
//                 "user_updater_id"=> Auth::user()->id
//             ]);

//             $new_menu_field_ids = array();
//             foreach($requests_ct1_detailbiayaproker as $ct_request){
//                 if(isset($ct_request["id"]) && $ct_request["id"] != ""){
//                     Detailbiayaproker::where("id", $ct_request["id"])->update([
//                         "no_seq" => $ct_request["no_seq"],
//                         "parent_id" => $id,
//                         "detailbiayaproker_name"=> $ct_request["detailbiayaproker_name"] == ''?null:$ct_request["detailbiayaproker_name"],
//                         "deskripsibiaya"=> $ct_request["deskripsibiaya"] == ''?null:$ct_request["deskripsibiaya"],
//                         "standarbiaya"=> $ct_request["standarbiaya"] == ''?null:$ct_request["standarbiaya"],
//                         "volume"=> $ct_request["volume"] == ''?null:$ct_request["volume"],
//                         "satuan"=> $ct_request["satuan"] == ''?null:$ct_request["satuan"],
//                         "satuan_label"=> $ct_request["satuan_label"],
//                         "user_updater_id" => Auth::user()->id
//                     ]);
//                 }else{
//                     $idct = Detailbiayaproker::create([
//                         "no_seq" => $ct_request["no_seq"],
//                         "parent_id" => $id,
//                         "detailbiayaproker_name"=> $ct_request["detailbiayaproker_name"],
//                         "deskripsibiaya"=> $ct_request["deskripsibiaya"],
//                         "standarbiaya"=> $ct_request["standarbiaya"],
//                         "volume"=> $ct_request["volume"],
//                         "satuan"=> $ct_request["satuan"],
//                         "satuan_label"=> $ct_request["satuan_label"],
//                         "user_creator_id" => Auth::user()->id
//                     ])->id;
//                     array_push($new_menu_field_ids, $idct);
//                 }
//             }

//             foreach(Detailbiayaproker::whereParentId($id)->get() as $ch){
//                     $is_still_exist = false;
//                     foreach($requests_ct1_detailbiayaproker as $ct_request){
//                         if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
//                             $is_still_exist = true;
//                         }
//                     }
//                     if(!$is_still_exist){
//                         Detailbiayaproker::whereId($ch->id)->delete();
//                     }
//                 }

//             return response()->json([
//                 'status' => 201,
//                 'message' => 'Id '.$id.' is updated',
//                 'data' => ['id' => $id]
//             ]);
//         }
// }

    // /**
    // * Remove the specified resource from storage.
    // *
    // * @param int $id
    // * @return \Illuminate\Http\Response
    // */
    // public function destroy(Request $request)
    // {
    //     if($request->ajax() || $request->wantsJson()){
    //         $programkerja = Programkerja::whereId($request->id)->first();
    //         if(!$programkerja){
    //             abort(404, "Data not found");
    //         }
    //         $results = array(
    //             "status" => 417,
    //             "message" => "Deleting failed"
    //         );
    //         if(Programkerja::whereId($request->id)->forceDelete()){
    //             $results = array(
    //                 "status" => 204,
    //                 "message" => "Deleted successfully"
    //             );
    //         }

    //         return response()->json($results);
    //     }
    // }

    public function get_list(Request $request)
    {
        $page_data = $this->tabledesign();
        $list_column = array("tahun", "unit_pelaksana", "tahun");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $orders = array("tahun", "ASC");
        if(isset($request->order)){
            $orders = array($list_column[$request->order["0"]["column"]], $request->order["0"]["dir"]);
        }

        $limit = null;
        if(isset($request->length) && $request->length != -1){
            $limit = array(intval($request->start), intval($request->length));
        }

        $dt = array();
        $no = 0;
        foreach(Plafon_kegiatan::where(function($q) use ($keyword) {
            $q->where("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("unit_pelaksana_label", "LIKE", "%" . $keyword. "%");
        })->groupBy("tahun")->groupBy("unit_pelaksana")->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["tahun", "unit_pelaksana"]) as $plafon_kegiatan){
            $no = $no+1;
            $act = '
            <a href="/plafon_kegiatan/'.$plafon_kegiatan->tahun.'/'.$plafon_kegiatan->unit_pelaksana.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/plafon_kegiatan/'.$plafon_kegiatan->tahun.'/'.$plafon_kegiatan->unit_pelaksana.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>';

            $plafon_kegiatan->tahun_label = $plafon_kegiatan->tahun;
            $uk = Unitkerja::where("id", $plafon_kegiatan->unit_pelaksana)->first();
            $plafon_kegiatan->unit_pelaksana_label = "";
            if($uk){
                $plafon_kegiatan->unit_pelaksana_label = $uk->unitkerja_name;
            }
            array_push($dt, array($no, $plafon_kegiatan->tahun_label, $plafon_kegiatan->unit_pelaksana_label, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Plafon_kegiatan::get()->count(),
            "recordsFiltered" => intval(Plafon_kegiatan::where(function($q) use ($keyword) {
                $q->where("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("unit_pelaksana_label", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $ct1_detailbiayakegiatans = Plafon_kegiatan::where("tahun", $request->tahun)->where("unit_pelaksana", $request->unit_pelaksana)->first();
            if(!$ct1_detailbiayakegiatans){
                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "ct1_detailbiayakegiatan" => []
                    ]
                );
                return response()->json($results);
            }

            $ct1_detailbiayakegiatans = Plafon_kegiatan::where("tahun", $request->tahun)->where("unit_pelaksana", $request->unit_pelaksana)->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans
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
                    $q->where("coa_name", "ILIKE", "%" . $request->term. "%")->orWhere("coa_code", "ILIKE", "%" . $request->term. "%");
                })->whereNull("fheader")->whereIn("category", ["biaya", "biaya_lainnya"])->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text")]);
                $count = Coa::count();
            }elseif($request->field == "unit_pelaksana"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "programkerja"){
                $lists = Programkerja::where(function($q) use ($request) {
                    $q->where("programkerja_name", "LIKE", "%" . $request->term. "%")->orWhere("programkerja_code", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(programkerja_code, ' ', programkerja_name) as text")]);
                $count = Programkerja::count();
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