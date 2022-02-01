<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Globalsetting;
use App\Models\Bankva;
use App\Models\Coa;
use App\Models\Approvalsetting;
use Session;

class GlobalsettingController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Global Setting",
            "page_data_urlname" => "globalsetting",
            "fields" => [
                "nama_instansi" => "text",
                "logo_instansi" => "upload",
                "bulan_tutup_tahun" => "select",
                "ct1_bank_va" => "childtable",
                "ct2_approval_setting" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_bank_va" => [
                    "kode_va" => "text",
                    "coa" => "link"
                ],
                "ct2_approval_setting" => [
                    "role" => "select",
                    "jenismenu" => "hidden"
                ]
            ],
            "fieldsoptions" => [
                "bulan_tutup_tahun" => [
                    ["name" => "1", "label" => "Januari"],
                    ["name" => "2", "label" => "Februari"],
                    ["name" => "3", "label" => "Maret"],
                    ["name" => "4", "label" => "April"],
                    ["name" => "5", "label" => "Mei"],
                    ["name" => "6", "label" => "Juni"],
                    ["name" => "7", "label" => "Juli"],
                    ["name" => "8", "label" => "Agustus"],
                    ["name" => "9", "label" => "September"],
                    ["name" => "10", "label" => "Oktober"],
                    ["name" => "11", "label" => "November"],
                    ["name" => "12", "label" => "Desember"]
                ],
                "role" => [
                    ["name" => "admin", "label" => "Administrator"],
                    ["name" => "direktur", "label" => "Direktur"],
                    ["name" => "manager", "label" => "Manager"],
                    ["name" => "staffkeuangan", "label" => "Staff Keuangan"],
                    ["name" => "staff", "label" => "Staff Umum"]
                ]
            ],
            "fieldlink" => [
                "coa" => "coas"
            ],
        ];

        $bulan_tutup_tahun_list = "1,2,3,4,5,6,7,8,9,10,11,12";

        $role_list = "admin,direktur,manager,staffkeuangan,staff";

        $td["fieldsrules"] = [
            "nama_instansi" => "required|min:2|max:255",
            "bulan_tutup_tahun" => "required|in:1,2,3,4,5,6,7,8,9,10,11,12",
            "ct1_bank_va" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_bank_va"] = [
            "kode_va" => "required|min:1|max:255",
            "coa" => "required|exists:coas,id"
        ];

        $td["fieldsmessages_ct1_bank_va"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct2_approval_setting"] = [
            "role" => "required|in:admin,direktur,manager,staffkeuangan,staff",
            "jenismenu" => "required"
        ];

        $td["fieldsmessages_ct2_approval_setting"] = [
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
        $page_data["footer_js_page_specific_script"] = ["paging.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_list"];
        
        return view("globalsetting.list", ["page_data" => $page_data, "globalsetting" => Globalsetting::where("id", 1)->first(), ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["globalsetting.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $globalsetting = Globalsetting::first();
        $page_data["id"] = $globalsetting->id;
        return view("globalsetting.create", ["page_data" => $page_data, "globalsetting" => Globalsetting::where("id", 1)->first(), ]);
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
        $rules_ct1_bank_va = $page_data["fieldsrules_ct1_bank_va"];
        $requests_ct1_bank_va = json_decode($request->ct1_bank_va, true);
        foreach($requests_ct1_bank_va as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_bank_va"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_bank_va, $ct_messages);
        }

        $rules_ct2_approval_setting = $page_data["fieldsrules_ct2_approval_setting"];
        $requests_ct2_approval_setting = json_decode($request->ct2_approval_setting, true);
        foreach($requests_ct2_approval_setting as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct2_approval_setting"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct2_approval_setting, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Globalsetting::create([
                "nama_instansi"=> $request->nama_instansi,
                "logo_instansi"=> $request->logo_instansi,
                "bulan_tutup_tahun"=> $request->bulan_tutup_tahun,
                "bulan_tutup_tahun_label"=> $request->bulan_tutup_tahun_label,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_bank_va as $ct_request){
                Bankva::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "kode_va"=> $ct_request["kode_va"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "user_creator_id" => Auth::user()->id
                ]);
            }

            foreach($requests_ct2_approval_setting as $ct_request){
                Approvalsetting::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "role"=> $ct_request["role"],
                    "role_label"=> $ct_request["role_label"],
                    "jenismenu"=> $ct_request["jenismenu"],
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
    public function show(Globalsetting $globalsetting)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["globalsetting.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $globalsetting->id;
        return view("globalsetting.create", ["page_data" => $page_data, "globalsetting" => Globalsetting::where("id", 1)->first(), ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Globalsetting $globalsetting)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["globalsetting.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $globalsetting->id;
        return view("globalsetting.create", ["page_data" => $page_data, "globalsetting" => Globalsetting::where("id", 1)->first(), ]);
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
        $rules_ct1_bank_va = $page_data["fieldsrules_ct1_bank_va"];
        $requests_ct1_bank_va = json_decode($request->ct1_bank_va, true);
        foreach($requests_ct1_bank_va as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_bank_va"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_bank_va, $ct_messages);
        }

        $rules_ct2_approval_setting = $page_data["fieldsrules_ct2_approval_setting"];
        $requests_ct2_approval_setting = json_decode($request->ct2_approval_setting, true);
        foreach($requests_ct2_approval_setting as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct2_approval_setting"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct2_approval_setting, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Globalsetting::where("id", $id)->update([
                "nama_instansi"=> $request->nama_instansi,
                "nama_lengkap_instansi"=> $request->nama_lengkap_instansi,
                "logo_instansi"=> $request->logo_instansi,
                "logo_sia"=> $request->logo_sia,
                "bulan_tutup_tahun"=> $request->bulan_tutup_tahun,
                "bulan_tutup_tahun_label"=> $request->bulan_tutup_tahun_label,
                "user_updater_id"=> Auth::user()->id
            ]);

            Session::put('global_setting', Globalsetting::where("id", 1)->first());
            
            $new_menu_field_ids = array();
            foreach($requests_ct1_bank_va as $ct_request){
                if(isset($ct_request["id"])){
                    Bankva::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                    "kode_va"=> $ct_request["kode_va"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Bankva::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                    "kode_va"=> $ct_request["kode_va"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Bankva::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct1_bank_va as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Bankva::whereId($ch->id)->delete();
                }
            }

            $new_menu_field_ids = array();
            foreach($requests_ct2_approval_setting as $ct_request){
                if(isset($ct_request["id"])){
                    Approvalsetting::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "role"=> $ct_request["role"],
                        "role_label"=> $ct_request["role_label"],
                        "jenismenu"=> $ct_request["jenismenu"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Approvalsetting::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "role"=> $ct_request["role"],
                        "role_label"=> $ct_request["role_label"],
                        "jenismenu"=> $ct_request["jenismenu"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Approvalsetting::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct2_approval_setting as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Approvalsetting::whereId($ch->id)->delete();
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
            $globalsetting = Globalsetting::whereId($request->id)->first();
            if(!$globalsetting){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Globalsetting::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "nama_instansi", "bulan_tutup_tahun_label", "id");
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
        foreach(Globalsetting::where(function($q) use ($keyword) {
            $q->where("nama_instansi", "LIKE", "%" . $keyword. "%")->orWhere("bulan_tutup_tahun_label", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "nama_instansi", "bulan_tutup_tahun_label"]) as $globalsetting){
            $no = $no+1;
            $act = '
            <a href="/globalsetting/'.$globalsetting->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/globalsetting/'.$globalsetting->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($globalsetting->id, $globalsetting->nama_instansi, $globalsetting->bulan_tutup_tahun_label, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Globalsetting::get()->count(),
            "recordsFiltered" => intval(Globalsetting::where(function($q) use ($keyword) {
                $q->where("nama_instansi", "LIKE", "%" . $keyword. "%")->orWhere("bulan_tutup_tahun_label", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $globalsetting = Globalsetting::whereId($request->id)->first();
            if(!$globalsetting){
                abort(404, "Data not found");
            }

            $ct1_bank_vas = Bankva::whereParentId($request->id)->get();
            $ct2_approval_settings = Approvalsetting::whereParentId($request->id)->where("jenismenu", "RKA")->get();
            $ct2_approval_settingspjk = Approvalsetting::whereParentId($request->id)->where("jenismenu", "PJK")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_bank_va" => $ct1_bank_vas,
                    "ct2_approval_setting" => $ct2_approval_settings,
                    "ct2_approval_settingpjk" => $ct2_approval_settingspjk,
                    "globalsetting" => $globalsetting
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

    public function storeUploadFile(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $input = $request->all();
            $input['file'] = $request->menname.time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($request->menname), $input['file']);

            return response()->json([
                "status" => 200,
                "message" => "Upload successfully",
                "filename" => $input['file']
            ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function getglobalsetting(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $globalsetting = Globalsetting::orderBy("id", "asc")->first();
            if(!$globalsetting){
                abort(404, "Data not found");
            }

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "globalsetting" => $globalsetting
                ]
            );

            return response()->json($results);
        }
    }
}