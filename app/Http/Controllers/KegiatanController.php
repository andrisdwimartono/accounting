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

use App\Models\Neracasaldo;
use App\Models\Aruskas;
use App\Models\Neraca;
use App\Models\Labarugi;
use App\Models\Bankva;
use App\Models\Opencloseperiode;
use App\Models\Fakultas;
use App\Models\Prodi;


class KegiatanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Kegiatan",
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
                    "nominalbiaya" => "float"
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

        $td["fieldsrules"] = [
            "unit_pelaksana" => "required|exists:unitkerjas,id",
            "tahun" => "required|in:2020,2021,2022,2023",
            "iku" => "required|exists:ikus,id",
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
        
        return view("kegiatan.list", ["page_data" => $page_data]);
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
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
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
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "iku"=> $request->iku,
                "iku_label"=> $request->iku_label,
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
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $kegiatan->id;
        return view("kegiatan.create", ["page_data" => $page_data]);
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
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
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
            foreach($requests_ct1_detailbiayakegiatan as $ct_request){
                if(isset($ct_request["id"])){
                    Detailbiayakegiatan::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Detailbiayakegiatan::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $ct_request["coa_label"],
                        "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                        "nominalbiaya"=> $ct_request["nominalbiaya"],
                        "user_creator_id" => Auth::user()->id
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
        $list_column = array("id", "unit_pelaksana_label", "tahun_label", "iku_label", "kegiatan_name", "output", "id");
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
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("unit_pelaksana_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_label", "LIKE", "%" . $keyword. "%")->orWhere("iku_label", "LIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "LIKE", "%" . $keyword. "%")->orWhere("output", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unit_pelaksana_label", "tahun_label", "iku_label", "kegiatan_name", "output"]) as $kegiatan){
            $no = $no+1;
            $act = '
            <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/kegiatan/'.$kegiatan->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($kegiatan->id, $kegiatan->unit_pelaksana_label, $kegiatan->tahun_label, $kegiatan->iku_label, $kegiatan->kegiatan_name, $kegiatan->output, $act));
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

            $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->get();
            $ct2_approvals = Approval::whereParentId($request->id)->get();

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

    public function processapprove(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $last_approval = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$request->no_seq)+1)->first();

            if($last_approval && $last_approval->status_approval != "approve"){
                abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
            }

            if(!Approval::where("parent_id", $request->id)->where("no_seq", ((int)$request->no_seq))->update([
                "role"                    => $request->role,
                "role_label"              => $request->role_label,
                "jenismenu"               => $request->jenismenu,
                "user"                    => $request->user,
                "user_label"              => $request->user_label,
                "komentar"                => $request->komentar,
                "status_approval"         => $request->status_approval,
                "status_approval_label"   => $request->status_approval_label,
            ])){
                abort(401, "Gagal update");
            }
            
            $tgl = date('Y-m-d');
            if(Approval::where("parent_id", $request->id)->count() > Approval::where("parent_id", $request->id)->where("status_approval", "approve")->count()){
                if(Approval::where("parent_id", $request->id)->where("status_approval", "approve")->count() > 1){
                    Kegiatan::where("id", $request->id)->update([
                        "status" => "approving"
                    ]);
                }else{
                    Kegiatan::where("id", $request->id)->update([
                        "status" => "process"
                    ]);
                }

                $this->checkOpenPeriode($tgl);
                $kegiatan = Kegiatan::where("id", $request->id)->first();
                $trans = Transaction::where("anggaran", $kegiatan->id)->first();
                $jurnal = Jurnal::where("id", $trans->parent_id)->first();
                if($jurnal){
                    Jurnal::where("id", $jurnal->id)->whereNull("isdeleted")->update([
                        "alasan_hapus" => "Batal Approve",
                        "isdeleted" => "on"
                    ]);

                    Transaction::where("parent_id", $jurnal->id)->whereNull("isdeleted")->update([
                        "alasan_hapus" => "Batal Approve",
                        "isdeleted" => "on"
                    ]);
                    foreach(Transaction::where("parent_id", $jurnal->id)->get() as $trans){
                        $this->summerizeJournal("delete", $trans->id);
                    }
                }
            }elseif(Approval::where("parent_id", $request->id)->count() == Approval::where("parent_id", $request->id)->where("status_approval", "approve")->count()){
                $this->checkOpenPeriode($tgl);
                $kegiatan = Kegiatan::where("id", $request->id)->first();
                $detailbiayakegiatan = Detailbiayakegiatan::where("parent_id", $request->id)->get();
                $nominal = 0;
                foreach($detailbiayakegiatan as $dbk){
                    $nominal += $dbk->nominalbiaya;
                }
                
                $id = Jurnal::create([
                    "unitkerja"=> $kegiatan->unit_pelaksana,
                    "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                    "no_jurnal"=> "JU#####",
                    "tanggal_jurnal"=> $tgl,
                    "keterangan"=> $kegiatan->kegiatan_name,
                    "user_creator_id"=> Auth::user()->id
                ])->id;
    
                $no_jurnal = "JU";
                for($i = 0; $i < 7-strlen((string)$id); $i++){
                    $no_jurnal .= "0";
                }
                $no_jurnal .= $id;
                Jurnal::where("id", $id)->update([
                    "no_jurnal"=> $no_jurnal
                ]);
                
                $coaum = Coa::where("factive", "on")->whereNull("fheader")->where("kode_jenisbayar", "UMKERJA1")->first();
                $coabank = Coa::where("factive", "on")->whereNull("fheader")->where("kode_jenisbayar", "BANKBSIQQ")->first();

                $no_seq = 0;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $id,
                    "deskripsi"=> "",
                    "debet"=> 0,
                    "credit"=> $nominal,
                    "unitkerja"=> $kegiatan->unit_pelaksana,
                    "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                    "anggaran"=> $kegiatan->id,
                    "anggaran_label"=> $kegiatan->kegiatan_name,
                    "tanggal"=> $tgl,
                    "keterangan"=> $kegiatan->Deskripsi,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coabank->id,
                    "coa_label"=> $this->convertCode($coabank->coa_code)." ".$coabank->coa_name,
                    "jenisbayar"=> $coabank->jenisbayar,
                    "jenisbayar_label"=> $coabank->jenisbayar_label,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "user_creator_id" => Auth::user()->id
                ])->id;
                $this->summerizeJournal("store", $idct);
                
                $no_seq++;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $id,
                    "deskripsi"=> "",
                    "debet"=> $nominal,
                    "credit"=> 0,
                    "unitkerja"=> $kegiatan->unit_pelaksana,
                    "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                    "anggaran"=> $kegiatan->id,
                    "anggaran_label"=> $kegiatan->kegiatan_name,
                    "tanggal"=> $tgl,
                    "keterangan"=> $kegiatan->Deskripsi,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coaum->id,
                    "coa_label"=> $this->convertCode($coaum->coa_code)." ".$coaum->coa_name,
                    "jenisbayar"=> $coaum->jenisbayar,
                    "jenisbayar_label"=> $coaum->jenisbayar_label,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "user_creator_id" => Auth::user()->id
                ])->id;
                $this->summerizeJournal("store", $idct);

                Kegiatan::where("id", $request->id)->update([
                    "status" => "approved"
                ]);

                return response()->json([
                    "status" => 200,
                    "message" => "Membuat Jurnal"
                ]);
            }

            return response()->json([
                "status" => 200,
                "message" => $request->status_approval_label." berhasil"
            ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function summerizeJournal($method, $id_transaction){
        $transaction = Transaction::where("id", $id_transaction)->first();
        $coa = Coa::where("id", $transaction->coa)->first();
        $bulan = explode("-", $transaction->tanggal)[1];
        $tahun = explode("-", $transaction->tanggal)[0];
        if($method == "store" || $method == "updatelast"){
            $neracasaldo = Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
            if($neracasaldo){
                Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                    "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->debet+$transaction->debet-$transaction->credit:0,
                    "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->credit+$transaction->credit-$transaction->debet:0,
                ]);
            }else{
                Neracasaldo::create([
                    "tahun_periode" => $tahun, 
                    "bulan_periode" => $bulan, 
                    "coa" => $transaction->coa, 
                    "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                    "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$transaction->debet-$transaction->credit:0, 
                    "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$transaction->credit-$transaction->debet:0, 
                    "user_creator_id" => 2,
                    "jenisbayar" => 0,
                    "jenisbayar_label" => "",
                    "unitkerja" => $transaction->unitkerja,
                    "unitkerja_label" => $transaction->unitkerja_label
                ]);
            }

            $aruskas = Aruskas::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
            if($aruskas){
                Aruskas::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                    "debet" => $aruskas->debet+$transaction->debet,
                    "credit" => $aruskas->credit+$transaction->credit,
                ]);
            }else{
                Aruskas::create([
                    "tahun_periode" => $tahun, 
                    "bulan_periode" => $bulan, 
                    "coa" => $transaction->coa, 
                    "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                    "debet" => $transaction->debet,
                    "credit" => $transaction->credit,
                    "user_creator_id" => 2,
                    "jenisbayar" => 0,
                    "jenisbayar_label" => "",
                    "jenis_aktivitas" => $coa->jenis_aktivitas,
                    "unitkerja" => $transaction->unitkerja,
                    "unitkerja_label" => $transaction->unitkerja_label
                ]);
            }

            if(in_array($coa->category, array("pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"))){
                $coa_sur_def = Coa::where("coa_code", "30300000")->first();
                $neraca = Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($neraca){
                    Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => 0,
                        "credit" => $neraca->credit+$transaction->credit-$transaction->debet,
                    ]);
                }else{
                    Neraca::create([
                        "tahun_periode" => $tahun, 
                        "bulan_periode" => $bulan, 
                        "coa" => $coa_sur_def->id, 
                        "coa_label" => $coa_sur_def->coa_code." ".$coa_sur_def->coa_name, 
                        "debet" => 0, 
                        "credit" => $transaction->credit-$transaction->debet, 
                        "user_creator_id" => 2,
                        "unitkerja" => $transaction->unitkerja,
                        "unitkerja_label" => $transaction->unitkerja_label
                    ]);
                }
                $labarugi = Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($labarugi){
                    Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => in_array($coa->category, array("biaya", "biaya_lainnya"))?$labarugi->debet+$transaction->debet-$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("biaya", "biaya_lainnya"))?$labarugi->credit+$transaction->credit-$transaction->debet:0,
                    ]);
                }else{
                    Labarugi::create([
                        "tahun_periode" => $tahun, 
                        "bulan_periode" => $bulan, 
                        "coa" => $coa->id, 
                        "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                        "debet" => in_array($coa->category, array("biaya", "biaya_lainnya"))?$transaction->debet-$transaction->credit:0, 
                        "credit" => !in_array($coa->category, array("biaya", "biaya_lainnya"))?$transaction->credit-$transaction->debet:0,
                        "user_creator_id" => 2,
                        "unitkerja" => $transaction->unitkerja,
                        "unitkerja_label" => $transaction->unitkerja_label
                    ]);
                }
            }else{
                $neraca = Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($neraca){
                    Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->debet+$transaction->debet-$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->credit+$transaction->credit-$transaction->debet:0,
                    ]);
                }else{
                    Neraca::create([
                        "tahun_periode" => $tahun, 
                        "bulan_periode" => $bulan, 
                        "coa" => $transaction->coa, 
                        "coa_label" => $coa->coa_code." ".$coa->coa_name, 
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$transaction->debet-$transaction->credit:0, 
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$transaction->credit-$transaction->debet:0, 
                        "user_creator_id" => 2,
                        "unitkerja" => $transaction->unitkerja,
                        "unitkerja_label" => $transaction->unitkerja_label
                    ]);
                }
            }
        }elseif($method == "updatefirst" || $method == "delete"){
            $neracasaldo = Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
            if($neracasaldo){
                Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                    "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->debet-$transaction->debet+$transaction->credit:0,
                    "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->credit-$transaction->credit+$transaction->debet:0,
                    "user_updater_id" => 2
                ]);
            }

            $aruskas = Aruskas::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
            if($aruskas){
                Aruskas::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                    "debet" => $aruskas->debet-$transaction->debet,
                    "credit" => $aruskas->credit-$transaction->credit,
                    "user_updater_id" => 2
                ]);
            }

            if(in_array($coa->category, array("pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"))){
                $coa_sur_def = Coa::where("coa_code", "30300000")->first();
                $neraca = Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($neraca){
                    Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => 0,
                        "credit" => $neraca->credit-$transaction->credit+$transaction->debet,
                        "user_updater_id" => 2
                    ]);
                }
                $labarugi = Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($labarugi){
                    Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$labarugi->debet-$transaction->debet+$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$labarugi->credit-$transaction->credit+$transaction->debet:0,
                        "user_updater_id" => 2
                    ]);
                }
            }else{
                $neraca = Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->first();
                if($neraca){
                    Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->where("unitkerja", $transaction->unitkerja)->update([
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->debet-$transaction->debet+$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->credit-$transaction->credit+$transaction->debet:0,
                        "user_updater_id" => 2
                    ]);
                }
            }
        }
    }

    public function convertCode($data){
        $val = "";
        $array = str_split($data);
        $i = 0;
        foreach ($array as $char) {
            if($i == 0){
                $val = $val.$char."-";
            }else if($i == 2 || $i == 4){
                $val = $val.$char."-";
            }else if($i > 4 && ($i-4)%3 == 0 && $i != strlen($data)-1){
                $val = $val.$char."-";
            }else{
                $val = $val.$char;
            }
            $i++;
        }
        return $val;
     }

     public function checkOpenPeriode($date){
        $opencloseperiode = Opencloseperiode::orderBy("id", "desc")->first();
        if($opencloseperiode->bulan_open == explode("-", $date)[1] && $opencloseperiode->tahun_open == explode("-", $date)[0]){
            return true;
        }else{
            abort(403, "Periode buka hanya ".$opencloseperiode->bulan_open_label." ".$opencloseperiode->tahun_open);
        }
    }
}