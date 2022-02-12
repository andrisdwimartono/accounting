<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Kegiatan;
use App\Models\Unitkerja;
use App\Models\Iku;
use App\Models\Detailbiayakegiatan;
use App\Models\Coa;
use App\Models\Approval;
use App\Models\Approvalsetting;
use App\Models\Jurnal;
use App\Models\Transaction;
use App\Models\Pjk;
use App\Models\Detailbiayapjk;


class KegiatanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Rencana Kegiatan dan Anggaran",
            "page_data_urlname" => "kegiatan",
            "fields" => [
                "unit_pelaksana" => "link",
                "tahun" => "select",
                "iku" => "link",
                "kegiatan_name" => "text",
                "Deskripsi" => "textarea",
                "output" => "text",
                "proposal" => "upload",
                "ct1_detailbiayakegiatan" => "childtable",
                "ct2_approval" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_detailbiayakegiatan" => [
                    "coa" => "link",
                    "deskripsibiaya" => "textarea",
                    "nominalbiaya" => "float",
                    "status" => "select"
                ],
                "ct2_approval" => [
                    "role" => "select",
                    "jenismenu" => "hidden",
                    "user" => "hidden",
                    "komentar" => "textarea",
                    "status_approval" => "select"
                ]
            ],
            "fieldsoptions" => [
                "tahun" => [
                    ["name" => "2020", "label" => "2020"],
                    ["name" => "2021", "label" => "2021"],
                    ["name" => "2022", "label" => "2022"],
                    ["name" => "2023", "label" => "2023"]
                ],
                "role" => [
                    ["name" => "admin", "label" => "Administrator"],
                    ["name" => "direktur", "label" => "Direktur"],
                    ["name" => "manager", "label" => "Manager"],
                    ["name" => "staffkeuangan", "label" => "Staff Keuangan"],
                    ["name" => "staff", "label" => "Staff Umum"]
                ],
                "status_approval" => [
                    ["name" => "approve", "label" => "Terima"],
                    ["name" => "revise", "label" => "Revisi"],
                    ["name" => "reject", "label" => "Tolak"]
                ],
                "status" => [
                    ["name" => "pengajuan", "label" => "Pengajuan"],
                    ["name" => "terima", "label" => "Terima"],
                    ["name" => "revisi", "label" => "Revisi"]
                ]
            ],
            "fieldlink" => [
                "unit_pelaksana" => "unitkerjas",
                "iku" => "ikus",
                "coa" => "coas",
                "user" => "users"
            ]
        ];

        $tahun_list = "2020,2021,2022,2023";

        $role_list = "admin,direktur,manager,staffkeuangan,staff";

        $status_approval_list = "approve,revise,reject";
        
        $status_list = "pengajuan,terima,revisi";

        $td["fieldsrules"] = [
            "unit_pelaksana" => "required|exists:unitkerjas,id",
            // "tahun" => "required|in:2020,2021,2022,2023",
            // "iku" => "required|exists:ikus,id",
            "tanggal_kegiatan_submit" => "required",
            "kegiatan_name" => "required",
            "Deskripsi" => "nullable",
            "output" => "nullable",
            "proposal" => "nullable",
            "ct1_detailbiayakegiatan" => "required"
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
            "coa" => "required|exists:coas,id",
            "deskripsibiaya" => "nullable",
            "nominalbiaya" => "required|numeric"
        ];

        $td["fieldsmessages_ct1_detailbiayakegiatan"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct2_approval"] = [
            "role" => "required|in:admin,direktur,manager,staffkeuangan,staff",
            "jenismenu" => "required",
            "user" => "required|exists:users,id",
            "komentar" => "nullable",
            "status_approval" => "required|in:approve,revise,reject"
        ];

        $td["fieldsmessages_ct2_approval"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_detailbiayapjk"] = [
            "coa" => "required|exists:coas,id",
            "deskripsibiaya" => "nullable",
            "nominalbiaya" => "required|numeric"
        ];

        $td["fieldsmessages_ct1_detailbiayapjk"] = [
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
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.list", ["page_data" => $page_data]);
    }

    public function realisasi()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "Realisasi Anggaran";
        $page_data["page_data_urlname"] = "realisasi";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.list", ["page_data" => $page_data]);
    }

    public function pencairan()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "Pencairan Anggaran";
        $page_data["page_data_urlname"] = "pencairan";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.list", ["page_data" => $page_data]);
    }

    public function pertanggungjawaban()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "Pertanggungjawaban Anggaran";
        $page_data["page_data_urlname"] = "pertanggungjawaban";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.list", ["page_data" => $page_data]);
    }

    public function laporan()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Laporan";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_laporan"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.laporan", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        return view("kegiatan.create", ["page_data" => $page_data]);
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
        if($request->validate($rules, $messages)){
            $id = Kegiatan::create([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tanggal"=> $request->tanggal_kegiatan_submit,
                // "iku"=> $request->iku,
                // "iku_label"=> $request->iku_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi,
                "output"=> $request->output,
                "proposal"=> $request->proposal,
                "status" => "process",
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                Detailbiayakegiatan::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                    "nominalbiaya"=> $ct_request["nominalbiaya"],
                    "status" => "pengajuan",
                    "user_creator_id" => Auth::user()->id
                ]);
            }

            foreach(Approvalsetting::where("jenismenu", "RKA")->get() as $appr){
                Approval::create([
                    "no_seq" => $appr->no_seq,
                    "parent_id" => $id,
                    "role"=> $appr->role,
                    "role_label"=> $appr->role_label,
                    "jenismenu"=> $appr->jenismenu,
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
    public function show(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $kegiatan->id;
        $page_data["lastapprove"] = $this->lastapprove($kegiatan->id);
        $page_data["nextapprove"] = $this->nextapprove($kegiatan->id);
        return view("kegiatan.create", ["page_data" => $page_data]);
    }

    public function lastapprove($id){
        $getlastapproval = Approval::where("parent_id", $id)->where("jenismenu", "RKA")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        
        return $getlastapproval;
    }

    public function nextapprove($id){
        $getlastapproval = Approval::where("parent_id", $id)->where("jenismenu", "RKA")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        $getnextapp = Approval::where("parent_id", $id)->where("jenismenu", "RKA")->whereNull("status_approval")->orderBy("no_seq", "desc")->first();
        if($getlastapproval){
            $getnextapp = Approval::where("parent_id", $id)->where("jenismenu", "RKA")->whereNull("status_approval")->where("no_seq", ((int) $getlastapproval->no_seq)-1)->orderBy("no_seq", "desc")->first();
        }
        return $getnextapp;
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $kegiatan->id;
        return view("kegiatan.create", ["page_data" => $page_data]);
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
        $keg = Kegiatan::where("id",$id)->first();
        if($keg->status != "process"){
            abort(403, "tidak dapat diubah, status masih/sudah ".$keg->status);
        }

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
        if($request->validate($rules, $messages)){
            Kegiatan::where("id", $id)->update([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "iku"=> $request->iku,
                "iku_label"=> $request->iku_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi == ''?null:$request->Deskripsi,
                "output"=> $request->output == ''?null:$request->output,
                "proposal"=> $request->proposal == ''?null:$request->proposal,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            // dd($requests_ct1_detailbiayakegiatan);
            foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    
                    Detailbiayakegiatan::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        "user_updater_id" => Auth::user()->id,
                        "status" => "pengajuan"
                    ]);
                }else{
                    
                    $idct = Detailbiayakegiatan::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        "user_creator_id" => Auth::user()->id,
                        "status" => "pengajuan",
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Detailbiayakegiatan::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Detailbiayakegiatan::whereId($ch->id)->delete();
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
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Kegiatan::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $ukl = Auth::user()->unitkerja;
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("unit_pelaksana_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("iku_label", "LIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "LIKE", "%" . $keyword. "%")->orWhere("output", "LIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl){
            if($ukl){
                $q->where("unitkerja", $ukl);
            }
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unit_pelaksana_label", "tanggal","tahun_label", "iku_label", "kegiatan_name", "output", "status"]) as $kegiatan){
            $no = $no+1;
            $act = '
            <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';

            $lpjact = "";
            if($kegiatan->status == "approved"){
                $pjk = Pjk::where('kegiatan_id', $kegiatan->id)->first();
                $lpjact = '';
                if($pjk){
                    $lpjact .= '
                    <a href="/pjk/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
                }
                $lpjact .= '
                    <a href="/pjk/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>';
            }

            array_push($dt, array($kegiatan->id, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $kegiatan->output, $act, $lpjact));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("unit_pelaksana_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("iku_label", "LIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "LIKE", "%" . $keyword. "%")->orWhere("output", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_laporan(Request $request)
    {
        $list_column = array("id", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $unit_pelaksana = null;
        if(isset($request->search["unit_pelaksana"])){
            $unit_pelaksana = $request->search["unit_pelaksana"];
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
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("unit_pelaksana_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("iku_label", "LIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "LIKE", "%" . $keyword. "%")->orWhere("output", "LIKE", "%" . $keyword. "%");
        })
        ->where(function($q) use ($unit_pelaksana) {
            if(isset($unit_pelaksana)){
                $q->where("unit_pelaksana", $unit_pelaksana);
            }
        })
        ->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])
        ->get(["id", "unit_pelaksana_label", "tanggal","tahun_label", "iku_label", "kegiatan_name", "output"]) as $kegiatan){
            $no = $no+1;
            $act = '
            <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';

            $detail = array();
            $total = 0;
            foreach(Detailbiayakegiatan::whereParentId($kegiatan->id)->get() as $db){
                $nom =  "<span class='cak-rp'>Rp</span> <span class='cak-nom'>".number_format($db->nominalbiaya,0,",",".")."</span>";
                $total += (float) $db->nominalbiaya;
                array_push($detail, array($db->coa_label, $db->deskripisibiaya, $nom));
            }
            $tot =  "<b><span class='cak-rp'>Rp</span> <span class='cak-nom'>".number_format($total,0,",",".")."</span></b>";
                
            array_push($detail, array("", "<b>TOTAL</b>", $tot));
            // $detail = Detailbiayakegiatan::whereParentId($kegiatan->id)->get();

            array_push($dt, array($kegiatan->id, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $kegiatan->output, $act, $detail));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("unit_pelaksana_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("iku_label", "LIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "LIKE", "%" . $keyword. "%")->orWhere("output", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }

            $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->get();
            if(Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->count() < 1){
                $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                if(Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->count() < 1){
                    $lastapp = Approval::where("parent_id", $request->id)->where("role", Auth::user()->role)->where("jenismenu", "RKA")->first();
                    $beforeapp = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "RKA")->first();
                    if($beforeapp){
                        $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
                    }
                }
            }
            
            $ct2_approvals = Approval::whereParentId($request->id)->where("jenismenu", "RKA")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                    "ct2_approval" => $ct2_approvals,
                    "kegiatan" => $kegiatan
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
            if($request->field == "unit_pelaksana"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "iku"){
                $lists = Iku::where(function($q) use ($request) {
                    $q->where("iku_name", "LIKE", "%" . $request->term. "%");
                })->where("unit_pelaksana", $request->unit_pelaksana)->where("tahun", $request->tahun)->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("iku_name as text")]);
                $count = Iku::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%");
                })->whereIn("category", ["biaya", "biaya_lainnya"])->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text")]);
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

    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function showpjk(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_data_name"] = "PJK";
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_createpjk"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        $page_data["lastapprove"] = $this->lastapprovepjk($kegiatan->id);
        $page_data["nextapprove"] = $this->nextapprovepjk($kegiatan->id);
        $page_data["id"] = $kegiatan->id;
        return view("kegiatan.createpjk", ["page_data" => $page_data]);
    }

    public function lastapprovepjk($id){
        $pjk = PJK::where("kegiatan_id", $id)->first();
        $getlastapproval = Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        
        return $getlastapproval;
    }

    public function nextapprovepjk($id){
        $pjk = PJK::where("kegiatan_id", $id)->first();
        $getlastapproval = Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        $getnextapp = Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->whereNull("status_approval")->orderBy("no_seq", "desc")->first();
        if($getlastapproval){
            $getnextapp = Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->whereNull("status_approval")->where("no_seq", ((int) $getlastapproval->no_seq)-1)->orderBy("no_seq", "desc")->first();
        }
        return $getnextapp;
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function createpjk(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_data_name"] = "PJK";
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_createpjk"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $kegiatan->id;
        return view("kegiatan.createpjk", ["page_data" => $page_data]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function updatepjk(Request $request, $id)
    {
        $keg = Kegiatan::where("id",$id)->first();
        if($keg->status != "approved"){
            abort(403, "tidak dapat di PJK, status belum approved");
        }

        $thispjk = Pjk::where("kegiatan_id", $id)->first();
        if(!$thispjk){
            return $this->storepjk($request, $id);
        }

        $page_data = $this->tabledesign();
        $rules_ct1_detailbiayapjk = $page_data["fieldsrules_ct1_detailbiayapjk"];
        $requests_ct1_detailbiayapjk = json_decode($request->ct1_detailbiayakegiatan, true);
        foreach($requests_ct1_detailbiayapjk as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_detailbiayapjk"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_detailbiayapjk, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Pjk::where("id", $thispjk->id)->update([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "iku"=> $request->iku,
                "iku_label"=> $request->iku_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi == ''?null:$request->Deskripsi,
                "output"=> $request->output == ''?null:$request->output,
                "proposal"=> $request->proposal == ''?null:$request->proposal,
                'kegiatan_id' => $id,
                'desc_pjk' => $request->desc_pjk == ''?null:$request->desc_pjk,
                'laporan_pjk' => $request->laporan_pjk == ''?null:$request->laporan_pjk, 
                'user_pjk' => Auth::user()->id,
                "user_updater_id"=> Auth::user()->id,
                "status" =>"process"
            ]);
            
            $new_menu_field_ids = array();
            foreach($requests_ct1_detailbiayapjk as $ct_request){
                if(isset($ct_request["id"])){
                    Detailbiayapjk::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $thispjk->id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        'kegiatan_id' => $id,
                        'desc_detail' => $ct_request["desc_detail"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Detailbiayapjk::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $thispjk->id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        'kegiatan_id' => $id,
                        'desc_detail' => $ct_request["desc_detail"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Detailbiayapjk::whereParentId($thispjk->id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_detailbiayapjk as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Detailbiayapjk::whereId($ch->id)->delete();
                    }
                }

            return response()->json([
                'status' => 201,
                'message' => 'Id '.$id.' is updated',
                'data' => ['id' => $id]
            ]);
        }
    }

    public function storepjk(Request $request, $id)
    {
        $keg = Kegiatan::where("id",$id)->first();
        if($keg->status != "approved"){
            abort(403, "tidak dapat di PJK, status belum approved");
        }
        $page_data = $this->tabledesign();
        $rules_ct1_detailbiayapjk = $page_data["fieldsrules_ct1_detailbiayapjk"];
        $requests_ct1_detailbiayapjk = json_decode($request->ct1_detailbiayakegiatan, true);
        foreach($requests_ct1_detailbiayapjk as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_detailbiayapjk"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_detailbiayapjk, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $pjkid = pjk::create([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "iku"=> $request->iku,
                "iku_label"=> $request->iku_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi,
                "output"=> $request->output,
                "proposal"=> $request->proposal,
                'kegiatan_id' => $id,
                'desc_pjk' => $request->desc_pjk,
                'laporan_pjk' => $request->laporan_pjk,
                'user_pjk' => Auth::user()->id,
                "user_creator_id"=> Auth::user()->id,
                "status" =>"process"
            ])->id;

            foreach($requests_ct1_detailbiayapjk as $ct_request){
                Detailbiayapjk::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $pjkid,
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                    "nominalbiaya"=> $ct_request["nominalbiaya"],
                    'kegiatan_id' => $id,
                    'desc_detail' => $ct_request["desc_detail"],
                    "user_creator_id" => Auth::user()->id
                ]);
            }

            foreach(Approvalsetting::where("jenismenu", "PJK")->get() as $appr){
                Approval::create([
                    "no_seq" => $appr->no_seq,
                    "parent_id" => $pjkid,
                    "role"=> $appr->role,
                    "role_label"=> $appr->role_label,
                    "jenismenu"=> $appr->jenismenu,
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

    public function getdatapjk(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }elseif($kegiatan->status != "approved"){
                abort(403, "RKA belum di-approved");
            }

            $pjk = Pjk::where("kegiatan_id", $request->id)->first();
            if($pjk){

                $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->get();
                if(Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->count() < 1){
                    $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                    if(Detailbiayapjk::whereKegiatanId($request->id)->whereNull("isarchived")->orderBy("no_seq")->count() < 1){
                        $lastapp = Approval::where("parent_id", $pjk->id)->where("role", Auth::user()->role)->where("jenismenu", "PJK")->orderBy("no_seq", "asc")->first();
                        $beforeapp = Approval::where("parent_id", $pjk->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "PJK")->first();
                        if($beforeapp){
                            $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
                        }
                    }
                }
            
                $ct2_approvals = Approval::whereParentId($pjk->id)->where("jenismenu", "PJK")->get();

                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                        "ct2_approval" => $ct2_approvals,
                        "kegiatan" => $pjk
                    ]
                );
            }else{
                $lastapp = Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "asc")->first();
                $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("archivedby", $lastapp->role)->get();
                // foreach($ct1_detailbiayakegiatans as $ct1){
                //     $ct1->desc_detail = '';
                // }
                $ct2_approvals = [];

                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                        "ct2_approval" => $ct2_approvals,
                        "kegiatan" => $kegiatan
                    ]
                );
            }

            return response()->json($results);
        }
    }

    public function getdatahistory(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }

            $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->orderBy("archivedby")->orderBy("no_seq")->get();
            
            $ct2_approvals = Approval::whereParentId($request->id)->where("jenismenu", "RKA")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                    "ct2_approval" => $ct2_approvals,
                    "kegiatan" => $kegiatan
                ]
            );

            return response()->json($results);
        }
    }

    public function getdatahistorypjk(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }

            $pjk = Pjk::where("kegiatan_id", $request->id)->first();

            $ct1_detailbiayakegiatans = Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->orderBy("archivedby")->orderBy("no_seq")->get();
            
            $ct2_approvals = Approval::whereParentId($pjk->id)->where("jenismenu", "PJK")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                    "ct2_approval" => $ct2_approvals,
                    "kegiatan" => $kegiatan
                ]
            );

            return response()->json($results);
        }
    }
}