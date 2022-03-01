<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Kegiatan;
use App\Models\Unitkerja;
use App\Models\Iku;
use App\Models\Programkerja;
use App\Models\Detailbiayakegiatan;
use App\Models\Coa;
use App\Models\Approval;
use App\Models\Approvalsetting;
use App\Models\Jurnal;
use App\Models\Transaction;
use App\Models\Pjk;
use App\Models\Detailbiayapjk;
use App\Models\Outputrka;
use App\Models\Outputlpj;
use App\Models\Settingpagupendapatan;
use App\Models\Nilaipagu;
use App\Models\Potensipendapatan;
use App\Models\Detailkegiatan;
use App\Models\Satuan;
use App\Models\Detailbiayaproker;
use App\Models\Detailpjk;

class KegiatanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Rencana Kegiatan dan Anggaran",
            "page_data_urlname" => "kegiatan",
            "fields" => [
                "kode_anggaran" => "text",
                "unit_pelaksana" => "link",
                "tahun" => "select",
                "programkerja" => "link",
                "kegiatan_name" => "text",
                "Deskripsi" => "textarea",
                "output" => "text",
                "proposal" => "upload",
                "ct1_detailbiayakegiatan" => "childtable",
                "ct3_outputrka" => "childtable",
                "ct2_approval" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_detailbiayakegiatan" => [
                    "coa" => "link",
                    "deskripsibiaya" => "textarea",
                    "nominalbiaya" => "float",
                    "status" => "select"
                ],
                "ct3_outputrka" => [
                    "iku" => "link",
                    "indikator" => "text",
                    "keterangan" => "text",
                    "target" => "float",
                    "satuan_target" => "text"
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
                "status_kegiatan" => [
                    ["name" => "process", "label" => "process"],
                    ["name" => "approved", "label" => "approved"],
                    ["name" => "approving", "label" => "approving"],
                    ["name" => "submitting", "label" => "submitting"],
                    ["name" => "submitted", "label" => "submitted"],
                    ["name" => "paid", "label" => "paid"],
                    ["name" => "reporting", "label" => "reporting"],
                    ["name" => "reported", "label" => "reported"],
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
            "programkerja" => "required|exists:programkerjas,id",
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

        $td["fieldsrules_ct3_outputrka"] = [
            "iku" => "required",
            "keterangan" => "required",
            "target" => "required|numeric",
            "satuan_target" => "nullable"
        ];

        $td["fieldsmessages_ct3_outputrka"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct4_detailkegiatan"] = [
            
        ];

        $td["fieldsmessages_ct4_detailkegiatan"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct3_outputlpj"] = [
            "iku" => "required|exists:ikuunitkerjas,id",
            "Indikator" => "required",
            "keterangan" => "required",
            "target" => "required|numeric",
            "satuan_target" => "required",
            "realisasi" => "nullable|numeric",
            "satuan_realisasi" => "nullable",
            "file_bukti" => "nullable",
            "link_bukti" => "nullable",
            "hasil_pencapaian" => "nullable|numeric"
        ];

        $td["fieldsmessages_ct3_outputlpj"] = [
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

        $td["fieldsrules_pengajuan"] = [
            "tanggal_pencairan" => "required"
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

    public function persetujuankegiatan(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "Persetujuan Rencana Kegiatan dan Anggaran";
        $page_data["page_data_urlname"] = "kegiatan";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_list_persetujuankegiatan"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.list", ["page_data" => $page_data]);
    }

    public function pengajuan()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "Pengajuan Pencairan Anggaran";
        $page_data["page_data_urlname"] = "pengajuan";
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

    public function laporan_pengajuan()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Laporan";
        $page_data["page_data_name"] = "Pengajuan Anggaran";
        $page_data["page_data_urlname"] = "pengajuan";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_laporan"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.laporan", ["page_data" => $page_data]);
    }

    public function laporan_pencairan()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Laporan";
        $page_data["page_data_name"] = "Pencairan Anggaran";
        $page_data["page_data_urlname"] = "pencairan";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_laporan"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_list"];
        
        return view("kegiatan.laporan", ["page_data" => $page_data]);
    }

    public function laporan_pertanggungjawaban()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Laporan";
        $page_data["page_data_name"] = "Pertanggungjawaban Anggaran";
        $page_data["page_data_urlname"] = "pertanggungjawaban";
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

        $rules_ct3_outputrka = $page_data["fieldsrules_ct3_outputrka"];
        $requests_ct3_outputrka = json_decode($request->ct3_outputrka, true);
        foreach($requests_ct3_outputrka as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct3_outputrka"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct3_outputrka, $ct_messages);
        }

        $rules_ct4_detailkegiatan = $page_data["fieldsrules_ct4_detailkegiatan"];
        $requests_ct4_detailkegiatan = json_decode($request->ct4_detailkegiatan, true);
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct4_detailkegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct4_detailkegiatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Kegiatan::create([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tanggal"=> $request->tanggal_kegiatan_submit,
                "programkerja"=> $request->programkerja,
                "programkerja_label"=> $request->programkerja_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi,
                "output"=> $request->output,
                "proposal"=> $request->proposal,
                "status" => "process",
                "user_creator_id"=> Auth::user()->id
            ])->id;
            
            $kode_anggaran = $this->kodeanggaran($request, $id);
            Kegiatan::where("id", $id)->update([
                "kode_anggaran" => $kode_anggaran
            ]);

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

            foreach($requests_ct3_outputrka as $ct_request){
                Outputrka::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "iku"=> $ct_request["iku"],
                    "iku_label"=> $ct_request["iku_label"],
                    "indikator"=> $ct_request["indikator"],
                    "keterangan"=> $ct_request["keterangan"],
                    "target"=> $ct_request["target"],
                    "satuan_target"=> $ct_request["satuan_target"],
                    "user_creator_id" => Auth::user()->id
                ]);
            }

            foreach($requests_ct4_detailkegiatan as $ct_request){
                Detailkegiatan::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                    "deskripsibiaya" => $ct_request["deskripsibiaya"],
                    "standarbiaya" => $ct_request["standarbiaya"],
                    "volume" => $ct_request["volume"],
                    "satuan" => $ct_request["satuan"],
                    "satuan_label" => $ct_request["satuan_label"],
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
        $page_data["jenismenu"] = 'rka';
        $page_data["lastapprove"] = $this->lastapprove($kegiatan->id);
        $page_data["nextapprove"] = $this->nextapprove($kegiatan->id);
        return view("kegiatan.create", ["page_data" => $page_data]);
    }

    public function show_pengajuan(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["page_data_name"] = "Pengajuan Anggaran";
        $page_data["footer_js_page_specific_script"] = ["kegiatan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["kegiatan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $kegiatan->id;
        $page_data["jenismenu"] = 'pengajuan';
        $page_data["page_data_urlname"] = 'pengajuan';
        $page_data["lastapprove"] = $this->lastapprove_pengajuan($kegiatan->id);
        $page_data["nextapprove"] = $this->nextapprove_pengajuan($kegiatan->id);
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

    public function lastapprove_pengajuan($id){
        $getlastapproval = Approval::where("parent_id", $id)->where("jenismenu", "pengajuan")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        return $getlastapproval;
    }
    
    public function nextapprove_pengajuan($id){
        $getlastapproval = Approval::where("parent_id", $id)->where("jenismenu", "pengajuan")->where("status_approval", "approve")->orderBy("no_seq", "asc")->first();
        $getnextapp = Approval::where("parent_id", $id)->where("jenismenu", "pengajuan")->whereNull("status_approval")->orderBy("no_seq", "desc")->first();
        if($getlastapproval){
            $getnextapp = Approval::where("parent_id", $id)->where("jenismenu", "pengajuan")->whereNull("status_approval")->where("no_seq", ((int) $getlastapproval->no_seq)-1)->orderBy("no_seq", "desc")->first();
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

    public function edit_pengajuan(Kegiatan $kegiatan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["page_data_name"] = "Pengajuan Pencairan Anggaran";
        $page_data["page_data_urlname"] = "pengajuan";
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

        $rules_ct3_outputrka = $page_data["fieldsrules_ct3_outputrka"];
        $requests_ct3_outputrka = json_decode($request->ct3_outputrka, true);
        foreach($requests_ct3_outputrka as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct3_outputrka"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct3_outputrka, $ct_messages);
        }

        $rules_ct4_detailkegiatan = $page_data["fieldsrules_ct4_detailkegiatan"];
        $requests_ct4_detailkegiatan = json_decode($request->ct4_detailkegiatan, true);
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct4_detailkegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct4_detailkegiatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Kegiatan::where("id", $id)->update([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "programkerja"=> $request->programkerja,
                "programkerja_label"=> $request->programkerja_label,
                "kegiatan_name"=> $request->kegiatan_name,
                "Deskripsi"=> $request->Deskripsi == ''?null:$request->Deskripsi,
                "output"=> $request->output == ''?null:$request->output,
                "proposal"=> $request->proposal == ''?null:$request->proposal,
                "user_updater_id"=> Auth::user()->id,
                "tanggal"=> $request->tanggal
            ]);

            $new_menu_field_ids = array();
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

            $new_menu_field_ids = array();
            foreach($requests_ct3_outputrka as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Outputrka::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "iku"=> $ct_request["iku"],
                        "iku_label"=> $ct_request["iku_label"],
                        "indikator"=> $ct_request["indikator"],
                        "keterangan"=> $ct_request["keterangan"],
                        "target"=> $ct_request["target"],
                        "satuan_target"=> $ct_request["satuan_target"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Outputrka::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "iku"=> $ct_request["iku"],
                        "iku_label"=> $ct_request["iku_label"],
                        "indikator"=> $ct_request["indikator"],
                        "keterangan"=> $ct_request["keterangan"],
                        "target"=> $ct_request["target"],
                        "satuan_target"=> $ct_request["satuan_target"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Outputrka::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct3_outputrka as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Outputrka::whereId($ch->id)->delete();
                }
            }
            
            $new_menu_field_ids = array();
            foreach($requests_ct4_detailkegiatan as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Detailkegiatan::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                        "deskripsibiaya" => $ct_request["deskripsibiaya"],
                        "standarbiaya" => $ct_request["standarbiaya"],
                        "volume" => $ct_request["volume"],
                        "satuan" => $ct_request["satuan"],
                        "satuan_label" => $ct_request["satuan_label"],
                        "status" => $ct_request["status"],
                        "komentarrevisi" => $ct_request["komentarrevisi"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Detailkegiatan::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                        "deskripsibiaya" => $ct_request["deskripsibiaya"],
                        "standarbiaya" => $ct_request["standarbiaya"],
                        "volume" => $ct_request["volume"],
                        "satuan" => $ct_request["satuan"],
                        "satuan_label" => $ct_request["satuan_label"],
                        "status" => $ct_request["status"],
                        "komentarrevisi" => $ct_request["komentarrevisi"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Detailkegiatan::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct4_detailkegiatan as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Detailkegiatan::whereId($ch->id)->delete();
                }
            }

            return response()->json([
                'status' => 201,
                'message' => 'Id '.$id.' is updated',
                'data' => ['id' => $id]
            ]);
        }
    }

    public function update_pengajuan(Request $request, $id, $isapproving = false)
    {
        $page_data = $this->tabledesign();
        $rules = $page_data["fieldsrules_pengajuan"];
        $messages = $page_data["fieldsmessages"];
        
        if(isset($request->tanggal_pencairan)){
            if($request->validate($rules, $messages)){
                Kegiatan::where("id", $id)->update([
                    "tanggal_pencairan"=> $this->tgl_dbs($request->tanggal_pencairan),
                    "status" => "submitting"
                ]);
            }

            Kegiatan::where("id", $id)->update([
                "tanggal_pencairan"=> $this->tgl_dbs($request->tanggal_pencairan),
                "status" => "submitting"
            ]);
            
            foreach(Approvalsetting::where("jenismenu", "pengajuan")->get() as $appr){
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
                'message' => 'Anggaran diajukan',
                'data' => ['id' => $id]
            ]);
        } else {
            Kegiatan::where("id", $id)->update([
                "status" => "submitting"
            ]);
            
            if(!$isapproving){
                foreach(Approvalsetting::where("jenismenu", "pengajuan")->get() as $appr){
                    Approval::create([
                        "no_seq" => $appr->no_seq,
                        "parent_id" => $id,
                        "role"=> $appr->role,
                        "role_label"=> $appr->role_label,
                        "jenismenu"=> $appr->jenismenu,
                        "user_creator_id" => Auth::user()->id
                    ]);
                }
            }

            return response()->json([
                'status' => 201,
                'message' => 'Anggaran diajukan',
                'data' => ['id' => $id]
            ]);
        }
        
            
        
    }

    public function updaterka($request, $id)
    {
        $keg = Kegiatan::where("id",$id)->first();
        if($keg->status != "process" && $keg->status != "approving"){
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

        $rules_ct3_outputrka = $page_data["fieldsrules_ct3_outputrka"];
        $requests_ct3_outputrka = json_decode($request->ct3_outputrka, true);
        foreach($requests_ct3_outputrka as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct3_outputrka"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct3_outputrka, $ct_messages);
        }

        $rules_ct4_detailkegiatan = $page_data["fieldsrules_ct4_detailkegiatan"];
        $requests_ct4_detailkegiatan = json_decode($request->ct4_detailkegiatan, true);
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct4_detailkegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct4_detailkegiatan, $ct_messages);
        }

        //update
        //hapus yang lama jika ada
        Detailbiayakegiatan::where("parent_id", $id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->delete();

        //jika belum pernah, maka update archived
        Detailbiayakegiatan::where("parent_id", $id)->whereNull("isarchived")->whereNull("archivedby")->update([
            "isarchived" => "on",
            "user_updater_id" => Auth::user()->id
        ]);

        $new_menu_field_ids = array();
        foreach($requests_ct1_detailbiayakegiatan as $ct_request){
            // if(isset($ct_request["id"]) && $ct_request["id"] != ""){
            //     Detailbiayakegiatan::where("id", $ct_request["id"])->update([
            //         "no_seq" => $ct_request["no_seq"],
            //         "parent_id" => $id,
            //         "coa"=> $ct_request["coa"],
            //         "coa_label"=> $ct_request["coa_label"],
            //         "deskripsibiaya"=> $ct_request["deskripsibiaya"],
            //         "nominalbiaya"=> $ct_request["nominalbiaya"],
            //         "status" => $ct_request["status"]=="pengajuan"?"terima": $ct_request["status"],
            //         "komentarrevisi" => $ct_request["komentarrevisi"],
            //         "user_updater_id" => Auth::user()->id,
            //     ]);
            // }
            $idct = Detailbiayakegiatan::create([
                "no_seq" => $ct_request["no_seq"],
                "parent_id" => $id,
                "coa"=> $ct_request["coa"],
                "coa_label"=> $ct_request["coa_label"],
                "deskripsibiaya"=> $ct_request["deskripsibiaya"],
                "nominalbiaya"=> $ct_request["nominalbiaya"],
                "status" => $ct_request["status"]=="pengajuan" || $ct_request["status"]==""?"terima": $ct_request["status"],
                "komentarrevisi" => $ct_request["komentarrevisi"],
                "user_creator_id" => Auth::user()->id,
                "isarchived" => "on",
                "archivedby" => Auth::user()->role,
            ])->id;
            array_push($new_menu_field_ids, $idct);
        }

        // foreach(Detailbiayakegiatan::whereParentId($id)->get() as $ch){
        //     $is_still_exist = false;
        //     foreach($requests_ct1_detailbiayakegiatan as $ct_request){
        //         if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
        //             $is_still_exist = true;
        //         }
        //     }
        //     if(!$is_still_exist){
        //         //Detailbiayakegiatan::whereId($ch->id)->delete();
        //         // Detailbiayakegiatan::where("id", $ch->id)->update([
        //         //     "status" => "tolak",
        //         //     "user_updater_id" => Auth::user()->id,
        //         // ]);
        //     }
        // }

        //update
        //hapus yang lama jika ada
        Outputrka::where("parent_id", $id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->delete();

        //jika belum pernah, maka update archived
        Outputrka::where("parent_id", $id)->whereNull("isarchived")->whereNull("archivedby")->update([
            "isarchived" => "on",
            "user_updater_id" => Auth::user()->id
        ]);
        $new_menu_field_ids = array();
        foreach($requests_ct3_outputrka as $ct_request){
            $idct = Outputrka::create([
                "no_seq" => $ct_request["no_seq"],
                "parent_id" => $id,
                "iku"=> $ct_request["iku"],
                "iku_label"=> $ct_request["iku_label"],
                "indikator"=> $ct_request["indikator"],
                "keterangan"=> $ct_request["keterangan"],
                "target"=> $ct_request["target"],
                "satuan_target"=> $ct_request["satuan_target"],
                "user_creator_id" => Auth::user()->id,
                "isarchived" => "on",
                "archivedby" => Auth::user()->role,
            ])->id;
            array_push($new_menu_field_ids, $idct);
        }

        //update
        //hapus yang lama jika ada
        Detailkegiatan::where("parent_id", $id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->delete();

        //jika belum pernah, maka update archived
        Detailkegiatan::where("parent_id", $id)->whereNull("isarchived")->whereNull("archivedby")->update([
            "isarchived" => "on",
            "user_updater_id" => Auth::user()->id
        ]);
        $new_menu_field_ids = array();
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $idct = Detailkegiatan::create([
                "no_seq" => $ct_request["no_seq"],
                "parent_id" => $id,
                "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                "deskripsibiaya" => $ct_request["deskripsibiaya"],
                "standarbiaya" => $ct_request["standarbiaya"],
                "volume" => $ct_request["volume"],
                "satuan" => $ct_request["satuan"],
                "satuan_label" => $ct_request["satuan_label"],
                "status" => $ct_request["status"],
                "komentarrevisi" => $ct_request["komentarrevisi"],
                "user_creator_id" => Auth::user()->id,
                "isarchived" => "on",
                "archivedby" => Auth::user()->role,
            ])->id;
            array_push($new_menu_field_ids, $idct);
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
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $rl = Auth::user()->role_label;
        $pass = Approvalsetting::where("jenismenu", "RKA")->where("role", Auth::user()->role)->first();
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl, $rl, $pass){
            if($rl != 'admin' && $rl != 'Administrator' && !$pass){
                if($ukl){
                    $q->where("unit_pelaksana", $ukl);
                }
            }
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status", "user_creator_id"]) as $kegiatan){
            $no = $no+1;
            $act = '';
            
            if($kegiatan->user_creator_id == Auth::user()->id){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            } else {
                $act .= '<a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

                <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';
            }

            if(Auth::user()->role == 'admin'){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>
           
                <a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

                <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';
            }


            
            $status = "";
            switch ($kegiatan->status) {
                case "process":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approving":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approved":
                    $status = "<span class='badge light badge-primary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitting":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitted":
                    $status = "<span class='badge light badge-info' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "paid":
                    $status = "<span class='badge light badge-success' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "reporting":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "finish":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
            }

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

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $status, $act, $lpjact));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_persetujuankegiatan(Request $request)
    {
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $rl = Auth::user()->role_label;
        $pass = Approvalsetting::where("jenismenu", "RKA")->where("role", Auth::user()->role)->first();
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl, $rl, $pass){
            if($rl != 'admin' && $rl != 'Administrator' && !$pass){
                if($ukl){
                    $q->where("unit_pelaksana", $ukl);
                }
            }
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status", "user_creator_id"]) as $kegiatan){
            $no = $no+1;
            $act = '';
            
            if($kegiatan->user_creator_id == Auth::user()->id){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            }

            // dd(Auth::user()->role );
            if(Auth::user()->role == 'admin' || $pass){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            }


            
            $status = "";
            switch ($kegiatan->status) {
                case "process":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approving":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approved":
                    $status = "<span class='badge light badge-primary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitting":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitted":
                    $status = "<span class='badge light badge-info' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "paid":
                    $status = "<span class='badge light badge-success' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "reporting":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "finish":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
            }

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

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $status, $act, $lpjact));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function status($data){
        $status = "";
        switch ($data) {
            case "process":
                $status = "<span class='badge light badge-secondary' style='width:70px'>".$data."</span>";
                break;
            case "approving":
                $status = "<span class='badge light badge-secondary' style='width:70px'>".$data."</span>";
                break;
            case "approved":
                $status = "<span class='badge light badge-primary' style='width:70px'>".$data."</span>";
                break;
            case "submitting":
                $status = "<span class='badge light badge-secondary' style='width:70px'>".$data."</span>";
                break;
            case "submitted":
                $status = "<span class='badge light badge-info' style='width:70px'>".$data."</span>";
                break;
            case "paid":
                $status = "<span class='badge light badge-success' style='width:70px'>".$data."</span>";
                break;
            case "reporting":
                $status = "<span class='badge light badge-secondary' style='width:70px'>".$data."</span>";
                break;
            case "reported":
                $status = "<span class='badge light badge-warning' style='width:70px'>".$data."</span>";
                break;
        }

        return $status;
    }

    public function action($kegiatan){
        $act = '';
        if($kegiatan->status == "paid" || $kegiatan->status == "reporting" || $kegiatan->status == "reported"){           
            $pjk = Pjk::where('kegiatan_id', $kegiatan->id)->first();
            $act = '';
            if($pjk){
                $act .= '
                <a href="/pjk/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            }
            $act .= '
                <a href="/pjk/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>';
        } else if($kegiatan->status == "approved"){
            $act .= '
            <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';        
            
            if($kegiatan->user_creator_id == Auth::user()->id || Auth::user()->role == 'admin'){
                $act .= '
                    <a href="/pengajuan/'.$kegiatan->id.'/edit"  class="btn btn-info shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Pengajuan"><i class="fas fa-share text-white"></i></a>';
            }
        } else if($kegiatan->status == "submitting"){
            $act .= '
            <a href="/pengajuan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';        

        } else if($kegiatan->status == "process" || $kegiatan->status == "approving" ){
            // if($kegiatan->user_creator_id != Auth::user()->id){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            // }
        }

        if(Auth::user()->role == 'admin' || $kegiatan->user_creator_id == Auth::user()->id){
            $act .= '
            <a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';
        }

        return $act;
    }

    public function get_list_rka(Request $request)
    {
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $rl = Auth::user()->role_label;
        $pass = Approvalsetting::where("jenismenu", "RKA")->where("role", Auth::user()->role)->first();
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl, $rl, $pass){
            if($rl != 'admin' && $rl != 'Administrator' && !$pass){
                if($ukl){
                    $q->where("unit_pelaksana", $ukl);
                }
            }
        })
        ->whereIn('status', array('process', 'approving', 'approved'))
        ->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status"]) as $kegiatan){
            $no = $no+1;
            $status = $this->status($kegiatan->status);
            $act = $this->action($kegiatan);

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $status, $act));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_pengajuan(Request $request)
    {
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $rl = Auth::user()->role_label;
        $pass = Approvalsetting::where("jenismenu", "pengajuan")->where("role", Auth::user()->role)->first();
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl, $rl, $pass){
            if($rl != 'admin' && $rl != 'Administrator' && !$pass){
                if($ukl){
                    $q->where("unit_pelaksana", $ukl);
                }
            }
        })
        ->whereIn('status', array('approved','submitting', 'submitted'))
        ->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status"]) as $kegiatan){
            $no = $no+1;
            $act = '
            <a href="/pengajuan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/pengajuan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';

            $status = $this->status($kegiatan->status);
            $act = $this->action($kegiatan);

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $status, $act));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_pertanggungjawaban(Request $request)
    {
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "status", "id");
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
        $rl = Auth::user()->role_label;
        $pass = Approvalsetting::where("jenismenu", "PJK")->where("role", Auth::user()->role)->first();
        foreach(Kegiatan::where(function($q) use ($keyword) {
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })->where(function($q) use ($ukl, $rl, $pass){
            if($rl != 'admin' && $rl != 'Administrator' && !$pass && $rl != 'lpm'){
                if($ukl){
                    $q->where("unit_pelaksana", $ukl);
                }
            }
        })->whereIn("status", ["finish", "paid"])->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status", "user_creator_id"]) as $kegiatan){
            $no = $no+1;
            $act = '';
            
            if($kegiatan->user_creator_id = Auth::user()->id){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
            } else {
                $act .= '<a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

                <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';
            }

            // dd(Auth::user()->role );
            if(Auth::user()->role == 'admin'){
                $act .= '
                <a href="/kegiatan/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>
           
                <a href="/kegiatan/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

                <button type="button" class="row-delete btn btn-danger shadow btn-xs sharp"> <i class="fas fa-minus-circle text-white"></i> </button>';
            }


            
            $status = "";
            switch ($kegiatan->status) {
                case "process":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approving":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "approved":
                    $status = "<span class='badge light badge-primary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitting":
                    $status = "<span class='badge light badge-secondary' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "submitted":
                    $status = "<span class='badge light badge-info' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "paid":
                    $status = "<span class='badge light badge-success' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "reporting":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
                case "finish":
                    $status = "<span class='badge light badge-warning' style='width:70px'>".$kegiatan->status."</span>";
                    break;
            }

            $lpjact = "";
            if($kegiatan->status == "paid"){
                $pjk = Pjk::where('kegiatan_id', $kegiatan->id)->first();
                $lpjact = '';
                if($pjk){
                    $lpjact .= '
                    <a href="/pjk/'.$kegiatan->id.'" class="btn btn-primary shadow btn-xs sharp" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>';
                }
                $lpjact .= '
                    <a href="/pjk/'.$kegiatan->id.'/edit"  class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>';
            }

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $status, $lpjact, $act));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
            })->whereIn("status", ["finish", "paid"])->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_laporan(Request $request, $jenis)
    {
        $list_column = array("id", "kode_anggaran", "unit_pelaksana_label", "tanggal", "kegiatan_name", "output", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $unit_pelaksana = null;
        if(isset($request->search["unit_pelaksana"])){
            $unit_pelaksana = $request->search["unit_pelaksana"];
        }

        $status = null;
        if(isset($request->search["status"])){
            $status = $request->search["status"];
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
            $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
        })
        ->where(function($q) use ($unit_pelaksana) {
            if(isset($unit_pelaksana)){
                $q->where("unit_pelaksana", $unit_pelaksana);
            }
        })
        ->where(function($q) use ($status) {
            if(isset($status)){
                $q->where("status", $status);
            }
        })
        // ->where(function($q) use ($jenis) {
        //     if($jenis=='kegiatan'){
        //         $q->whereIn("status", array("process","approved"));
        //     } else if($jenis=='pengajuan'){
        //         $q->whereIn("status", array("submitted","submitting"));
        //     } else if($jenis=='pencairan'){
        //         $q->whereIn("status", array("paid"));
        //     } else if($jenis=='pertanggungjawaban'){
        //         $q->whereIn("status", array("reporting", "reported"));
        //     }
        // })
        ->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])
        ->get(["id", "kode_anggaran", "unit_pelaksana_label", "tanggal","tahun_label", "programkerja_label", "kegiatan_name", "output", "status"]) as $kegiatan){
            $no = $no+1;
            $status = $this->status($kegiatan->status);
            

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

            array_push($dt, array($kegiatan->id, $kegiatan->kode_anggaran, $kegiatan->unit_pelaksana_label,$kegiatan->tanggal, $kegiatan->kegiatan_name, $kegiatan->output, $status, $detail));
        }


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Kegiatan::get()->count(),
            "recordsFiltered" => intval(Kegiatan::where(function($q) use ($keyword) {
                $q->where("kode_anggaran", "ILIKE", "%" . $keyword. "%")->where("unit_pelaksana_label", "ILIKE", "%" . $keyword. "%")->orWhere("tahun_label", "ILIKE", "%" . $keyword. "%")->orWhere("programkerja_label", "ILIKE", "%" . $keyword. "%")->orWhere("kegiatan_name", "ILIKE", "%" . $keyword. "%")->orWhere("output", "ILIKE", "%" . $keyword. "%");
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

            // $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->get();
            // if(Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->count() < 1){
            //     $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            //     if(Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->count() < 1){
            //         $lastapp = Approval::where("parent_id", $request->id)->where("role", Auth::user()->role)->where("jenismenu", "RKA")->first();
            //         $beforeapp = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "RKA")->first();
            //         if($beforeapp){
            //             $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
            //         }
            //     }
            // }

            $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $dtbk = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($dtbk){
                    $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }

            // $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->get();
            // if(Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->count() < 1){
            //     $ct3_outputrkas = Outputrka::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            //     if(Outputrka::whereParentId($request->id)->whereNull("isarchived")->count() < 1){
            //         $lastapp = Approval::where("parent_id", $request->id)->where("role", Auth::user()->role)->where("jenismenu", "RKA")->first();
            //         $beforeapp = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "RKA")->first();
            //         if($beforeapp){
            //             $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
            //         }
            //     }
            // }

            $ct3_outputrkas = Outputrka::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $ok = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($ok){
                    $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }

            $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $ok = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($ok){
                    $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }
            
            $ct2_approvals = Approval::whereParentId($request->id)->where("jenismenu", "RKA")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                    "ct2_approval" => $ct2_approvals,
                    "ct3_outputrka" => $ct3_outputrkas,
                    "ct4_detailkegiatan" => $ct4_detailkegiatans,
                    "kegiatan" => $kegiatan
                ]
            );

            return response()->json($results);
        }
    }

    public function getdatadetailkegiatan(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $programkerja = Programkerja::whereId($request->programkerja)->first();
            if(!$programkerja){
                abort(404, "Data not found");
            }

            $ct4_detailkegiatans = Detailbiayaproker::whereParentId($request->programkerja)->orderBy("no_seq")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct4_detailkegiatan" => $ct4_detailkegiatans,
                ]
            );

            return response()->json($results);
        }
    }

    public function getdata_pengajuan(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }

            $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $dtbk = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($dtbk){
                    $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }

            // $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->get();
            // if(Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->count() < 1){
            //     $ct3_outputrkas = Outputrka::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            //     if(Outputrka::whereParentId($request->id)->whereNull("isarchived")->count() < 1){
            //         $lastapp = Approval::where("parent_id", $request->id)->where("role", Auth::user()->role)->where("jenismenu", "RKA")->first();
            //         $beforeapp = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "RKA")->first();
            //         if($beforeapp){
            //             $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
            //         }
            //     }
            // }

            $ct3_outputrkas = Outputrka::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $ok = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($ok){
                    $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }

            $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

            foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                $ok = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                if($ok){
                    $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                }
            }

            $ct2_approvals = Approval::whereParentId($request->id)->where("jenismenu", "pengajuan")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                    "ct2_approval" => $ct2_approvals,
                    "ct3_outputrka" => $ct3_outputrkas,
                    "ct4_detailkegiatan" => $ct4_detailkegiatans,
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
                    $q->where("unitkerja_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "iku"){
                $lists = Iku::where(function($q) use ($request) {
                    $q->where("iku_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("iku_name as text")]);
                $count = Iku::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "ILIKE", "%" . $request->term. "%");
                })->whereNull("fheader")->whereIn("category", ["biaya", "biaya_lainnya"])->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text")]);
                $count = Coa::count();
            }elseif($request->field == "programkerja"){
                $lists = Programkerja::where(function($q) use ($request) {
                    $q->where("programkerja_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("programkerja_name as text")]);
                $count = Programkerja::count();
            }elseif($request->field == "satuan"){
                $lists = Satuan::where(function($q) use ($request) {
                    $q->where("satuan_name", "ILIKE", "%" . $request->term. "%");
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

    public function processapprove(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $last_approval = Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->where("no_seq", ((int)$request->no_seq)+1)->first();

            if(!(($this->lastapprove($request->id) && ($this->lastapprove($request->id)->role == Auth::user()->role_label || $this->lastapprove($request->id)->role == Auth::user()->role)) || ($this->nextapprove($request->id) && ($this->nextapprove($request->id)->role == Auth::user()->role_label || $this->nextapprove($request->id)->role == Auth::user()->role)))){
                //abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
                abort(403, " Tidak bisa melakukan approval!");
            }

            // if($last_approval && $last_approval->status_approval != "approve"){
            //     abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
            // }

            if(!Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->where("role", Auth::user()->role_label)->update([
                "role"                    => Auth::user()->role_label,
                "jenismenu"               => "RKA",
                "user"                    => Auth::user()->id,
                "user_label"              => Auth::user()->name,
                "komentar"                => $request->komentar,
                "status_approval"         => $request->status_approval,
                "status_approval_label"   => $request->status_approval_label,
            ])){
                abort(401, "Gagal update");
            }else{
                $this->updaterka($request, $request->id);
            }
            
            $tgl = date('Y-m-d');
            $kegiatan = Kegiatan::where("id", $request->id)->first();
            if(Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->count() > Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->where("status_approval", "approve")->count()){
                if(Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->where("status_approval", "approve")->count() > 1){
                    Kegiatan::where("id", $request->id)->update([
                        "status" => "approving"
                    ]);
                }else{
                    Kegiatan::where("id", $request->id)->update([
                        "status" => "process"
                    ]);
                }

                // $this->checkOpenPeriode($tgl);
                
                // $trans = Transaction::where("anggaran", $kegiatan->id)->first();
                // if($trans){
                //     $jurnal = Jurnal::where("id", $trans->parent_id)->first();
                //     if($jurnal){
                //         Jurnal::where("id", $jurnal->id)->whereNull("isdeleted")->update([
                //             "alasan_hapus" => "Batal Approve",
                //             "isdeleted" => "on"
                //         ]);

                //         Transaction::where("parent_id", $jurnal->id)->whereNull("isdeleted")->update([
                //             "alasan_hapus" => "Batal Approve",
                //             "isdeleted" => "on"
                //         ]);
                //         foreach(Transaction::where("parent_id", $jurnal->id)->get() as $trans){
                //             $this->summerizeJournal("delete", $trans->id);
                //         }
                //     }
                // }
            }elseif(Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->count() == Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->where("status_approval", "approve")->count()){
                // if(Transaction::where("anggaran", $kegiatan->id)->count() > 0){
                //     abort(403, "Sudah approved dan terjurnal");
                // }
                // $this->checkOpenPeriode($tgl);
                // $lastapp = Approval::where("jenismenu", "RKA")->where("parent_id", $request->id)->orderBy("no_seq", "asc")->first();
                // $kegiatan = Kegiatan::where("id", $request->id)->first();
                // $detailbiayakegiatan = Detailbiayakegiatan::where("parent_id", $request->id)->where("archivedby", $lastapp->role)->get();
                // $nominal = 0;
                // foreach($detailbiayakegiatan as $dbk){
                //     $nominal += $dbk->nominalbiaya;
                // }
                
                // $id = Jurnal::create([
                //     "unitkerja"=> $kegiatan->unit_pelaksana,
                //     "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                //     "no_jurnal"=> "JU#####",
                //     "tanggal_jurnal"=> $tgl,
                //     "keterangan"=> $kegiatan->kegiatan_name,
                //     "user_creator_id"=> Auth::user()->id
                // ])->id;
    
                // $no_jurnal = "JU";
                // for($i = 0; $i < 7-strlen((string)$id); $i++){
                //     $no_jurnal .= "0";
                // }
                // $no_jurnal .= $id;
                // Jurnal::where("id", $id)->update([
                //     "no_jurnal"=> $no_jurnal
                // ]);
                
                // $coaum = Coa::where("factive", "on")->whereNull("fheader")->where("kode_jenisbayar", "UMKERJA1")->first();
                // $coabank = Coa::where("factive", "on")->whereNull("fheader")->where("kode_jenisbayar", "BANKBSIQQ")->first();

                // $no_seq = 0;
                // $idct = Transaction::create([
                //     "no_seq" => $no_seq,
                //     "parent_id" => $id,
                //     "deskripsi"=> "",
                //     "debet"=> 0,
                //     "credit"=> $nominal,
                //     "unitkerja"=> $kegiatan->unit_pelaksana,
                //     "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                //     "anggaran"=> $kegiatan->id,
                //     "anggaran_label"=> $kegiatan->kegiatan_name,
                //     "tanggal"=> $tgl,
                //     "keterangan"=> $kegiatan->Deskripsi,
                //     "jenis_transaksi"=> 0,
                //     "coa"=> $coabank->id,
                //     "coa_label"=> $this->convertCode($coabank->coa_code)." ".$coabank->coa_name,
                //     "jenisbayar"=> $coabank->jenisbayar,
                //     "jenisbayar_label"=> $coabank->jenisbayar_label,
                //     "fheader"=> null,
                //     "no_jurnal"=> $no_jurnal,
                //     "user_creator_id" => Auth::user()->id
                // ])->id;
                // $this->summerizeJournal("store", $idct);
                
                // $no_seq++;
                // $idct = Transaction::create([
                //     "no_seq" => $no_seq,
                //     "parent_id" => $id,
                //     "deskripsi"=> "",
                //     "debet"=> $nominal,
                //     "credit"=> 0,
                //     "unitkerja"=> $kegiatan->unit_pelaksana,
                //     "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                //     "anggaran"=> $kegiatan->id,
                //     "anggaran_label"=> $kegiatan->kegiatan_name,
                //     "tanggal"=> $tgl,
                //     "keterangan"=> $kegiatan->Deskripsi,
                //     "jenis_transaksi"=> 0,
                //     "coa"=> $coaum->id,
                //     "coa_label"=> $this->convertCode($coaum->coa_code)." ".$coaum->coa_name,
                //     "jenisbayar"=> $coaum->jenisbayar,
                //     "jenisbayar_label"=> $coaum->jenisbayar_label,
                //     "fheader"=> null,
                //     "no_jurnal"=> $no_jurnal,
                //     "user_creator_id" => Auth::user()->id
                // ])->id;
                // $this->summerizeJournal("store", $idct);

                Kegiatan::where("id", $request->id)->update([
                    "status" => "approved"
                ]);

                return response()->json([
                    "status" => 200,
                    "message" => "Anggaran telah diterima"
                ]);
            }

            return response()->json([
                "status" => 200,
                "message" => $request->status_approval_label." berhasil"
            ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function processapprove_pengajuan(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $last_approval = Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->where("no_seq", ((int)$request->no_seq)+1)->first();

            if(!(($this->lastapprove_pengajuan($request->id) && $this->lastapprove_pengajuan($request->id)->role == Auth::user()->role_label) || ($this->nextapprove_pengajuan($request->id) && $this->nextapprove_pengajuan($request->id)->role == Auth::user()->role_label))){
                //abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
                abort(403, " Tidak bisa melakukan approval!");
            }

            // if($last_approval && $last_approval->status_approval != "approve"){
            //     abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
            // }

            if(!Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->where("role", Auth::user()->role_label)->update([
                "role"                    => Auth::user()->role_label,
                "jenismenu"               => "pengajuan",
                "user"                    => Auth::user()->id,
                "user_label"              => Auth::user()->name,
                "komentar"                => $request->komentar,
                "status_approval"         => $request->status_approval,
                "status_approval_label"   => $request->status_approval_label,
            ])){
                abort(401, "Gagal update");
            }else{
                $this->update_pengajuan($request, $request->id, true);
            }
            
            $tgl = date('Y-m-d');
            $kegiatan = Kegiatan::where("id", $request->id)->first();
            if(Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->count() > Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->where("status_approval", "approve")->count()){
                if(Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->where("status_approval", "approve")->count() > 1){
                    Kegiatan::where("id", $request->id)->update([
                        "status" => "submitting"
                    ]);
                }
            }elseif(Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->count() == Approval::where("jenismenu", "pengajuan")->where("parent_id", $request->id)->where("status_approval", "approve")->count()){

                Kegiatan::where("id", $request->id)->update([
                    "status" => "submitted"
                ]);

                return response()->json([
                    "status" => 200,
                    "message" => "Anggaran telah diterima"
                ]);
            }

            return response()->json([
                "status" => 200,
                "message" => $request->status_approval_label." berhasil"
            ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function processapprovepjk(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::where("id", $request->id)->first();

            $last_approval = Approval::where("jenismenu", "PJK")->where("parent_id", $kegiatan->id)->where("no_seq", ((int)$request->no_seq)+1)->first();

            if(!(($this->lastapprovepjk($kegiatan->id) && $this->lastapprovepjk($kegiatan->id)->role == Auth::user()->role_label) || ($this->nextapprovepjk($kegiatan->id) && $this->nextapprovepjk($kegiatan->id)->role == Auth::user()->role_label))){
                abort(403, " Tidak bisa melakukan approval!");
            }

            // if($last_approval && $last_approval->status_approval != "approve"){
            //     abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
            // }

            $pjk = Pjk::where("kegiatan_id", $kegiatan->id)->first();
            // $last_approval = Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->where("no_seq", ((int)$request->no_seq)+1)->first();

            // if($last_approval && $last_approval->status_approval != "approve"){
            //     abort(403, $last_approval->role_label." tidak/belum menerima pengajuan ini!");
            // }

            if(!Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->where("role", Auth::user()->role_label)->update([
                "role"                    => Auth::user()->role,
                "jenismenu"               => "PJK",
                "user"                    => Auth::user()->id,
                "user_label"              => Auth::user()->name,
                "komentar"                => $request->komentar,
                "status_approval"         => $request->status_approval,
                "status_approval_label"   => $request->status_approval_label,
            ])){
                abort(401, "Gagal update");
            }else{
                $this->updatepjk($request, $request->id);
            }
            
            $tgl = date('Y-m-d');
            
            $transkeg = Transaction::where("anggaran", $kegiatan->id)->first();
            $jurnalkeg = Jurnal::where("id", $transkeg->parent_id)->first();
            if(Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->count() > Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->where("status_approval", "approve")->count()){
                if(Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->where("status_approval", "approve")->count() > 1){
                    PJK::where("id", $request->id)->update([
                        "status" => "approving"
                    ]);
                }else{
                    PJK::where("id", $request->id)->update([
                        "status" => "process"
                    ]);
                }

                $this->checkOpenPeriode($tgl);
                $kegiatan = Kegiatan::where("id", $request->id)->first();
                
                $trans = Transaction::where("idjurnalreference", $jurnalkeg->id)->first();
                if($trans){
                    $jurnal = Jurnal::where("idjurnalreference", $jurnalkeg->id)->first();
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
                }
            }elseif(Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->count() == Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->where("status_approval", "approve")->count()){
                if(Jurnal::where("idjurnalreference", $jurnalkeg->id)->count() > 0){
                    abort(403, "Sudah approved dan terjurnal");
                }
                $this->checkOpenPeriode($tgl);
                $lastapp = Approval::where("jenismenu", "PJK")->where("parent_id", $pjk->id)->orderBy("no_seq", "asc")->first();
                $kegiatan = Kegiatan::where("id", $request->id)->first();
                $detailbiayakegiatan = Detailbiayakegiatan::where("parent_id", $request->id)->get();
                $detailbiayapjk = Detailbiayapjk::where("parent_id", $pjk->id)->where("archivedby", $lastapp->role)->get();

                
                $id = Jurnal::create([
                    "unitkerja"=> $kegiatan->unit_pelaksana,
                    "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                    "no_jurnal"=> "JU#####",
                    "tanggal_jurnal"=> $tgl,
                    "keterangan"=> $kegiatan->kegiatan_name,
                    "idjurnalreference" => $jurnalkeg->id,
                    "no_jurnalreference" => $jurnalkeg->no_jurnal,
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

                $nominal = 0;
                $no_seq = -1;
                foreach($detailbiayapjk as $dbk){
                    $nominal += $dbk->nominalbiaya;
                    $no_seq++;
                    $idct = Transaction::create([
                        "no_seq" => $no_seq,
                        "parent_id" => $id,
                        "deskripsi"=> "",
                        "debet"=> $dbk->nominalbiaya,
                        "credit"=> 0,
                        "unitkerja"=> $kegiatan->unit_pelaksana,
                        "unitkerja_label"=> $kegiatan->unit_pelaksana_label,
                        "anggaran"=> $kegiatan->id,
                        "anggaran_label"=> $kegiatan->kegiatan_name,
                        "tanggal"=> $tgl,
                        "keterangan"=> $kegiatan->Deskripsi,
                        "jenis_transaksi"=> 0,
                        "coa"=> $dbk->coa,
                        "coa_label"=> $dbk->coa_label,
                        "fheader"=> null,
                        "no_jurnal"=> $no_jurnal,
                        "idjurnalreference" => $jurnalkeg->id,
                        "no_jurnalreference" => $jurnalkeg->no_jurnal,
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    $this->summerizeJournal("store", $idct);
                }
                
                $no_seq++;
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
                    "coa"=> $coaum->id,
                    "coa_label"=> $this->convertCode($coaum->coa_code)." ".$coaum->coa_name,
                    "jenisbayar"=> $coaum->jenisbayar,
                    "jenisbayar_label"=> $coaum->jenisbayar_label,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "idjurnalreference" => $jurnalkeg->id,
                    "no_jurnalreference" => $jurnalkeg->no_jurnal,
                    "user_creator_id" => Auth::user()->id
                ])->id;
                $this->summerizeJournal("store", $idct);

                Pjk::where("id", $pjk->id)->update([
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
        $page_data["jenismenu"] = 'pjk';
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
        if($keg->status != "paid"){
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

        $rules_ct4_detailkegiatan = $page_data["fieldsrules_ct4_detailkegiatan"];
        $requests_ct4_detailkegiatan = json_decode($request->ct4_detailkegiatan, true);
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct4_detailkegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct4_detailkegiatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        Pjk::where("id", $thispjk->id)->update([
            "user_updater_id"=> Auth::user()->id,
            "status" =>"approving"
        ]);
        
        $new_menu_field_ids = array();
        foreach($requests_ct1_detailbiayapjk as $ct_request){
            if(isset($ct_request["id"]) && $ct_request["id"] != ""){
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

        $requests_ct3_outputlpj = json_decode($request->ct3_outputrka, true);
        $new_menu_field_ids = array();
        foreach($requests_ct3_outputlpj as $ct_request){
            if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                Outputlpj::where("id", $ct_request["id"])->update([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $thispjk->id,
                    "iku"=> $ct_request["iku"],
                    "iku_label"=> $ct_request["iku_label"],
                    "indikator"=> $ct_request["indikator"],
                    "keterangan"=> $ct_request["keterangan"],
                    "target"=> $ct_request["target"],
                    "satuan_target"=> $ct_request["satuan_target"],
                    "realisasi" => $ct_request["realisasi"],
                    "satuan_realisasi" => $ct_request["satuan_realisasi"],
                    "file_bukti" => $ct_request["file_bukti"],
                    "link_bukti" => $ct_request["link_bukti"],
                    "user_updater_id" => Auth::user()->id
                ]);

                if(Auth::user()->role == "lpm"){
                    Outputlpj::where("id", $ct_request["id"])->update([
                        "hasil_pencapaian" => $ct_request["hasil_pencapaian"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }
            }else{
                if(Auth::user()->role != "lpm"){
                    $idct = Outputlpj::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $thispjk->id,
                        "iku"=> $ct_request["iku"],
                        "iku_label"=> $ct_request["iku_label"],
                        "indikator"=> $ct_request["indikator"],
                        "keterangan"=> $ct_request["keterangan"],
                        "target"=> $ct_request["target"],
                        "satuan_target"=> $ct_request["satuan_target"],
                        "realisasi" => $ct_request["realisasi"],
                        "satuan_realisasi" => $ct_request["satuan_realisasi"],
                        "file_bukti" => $ct_request["file_bukti"],
                        "link_bukti" => $ct_request["link_bukti"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }
        }

        foreach(Outputlpj::whereParentId($thispjk->id)->get() as $ch){
            $is_still_exist = false;
            foreach($requests_ct3_outputlpj as $ct_request){
                if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                    $is_still_exist = true;
                }
            }
            if(!$is_still_exist){
                if(Auth::user()->role != "lpm"){
                    Outputlpj::whereId($ch->id)->delete();
                }
            }
        }

        $new_menu_field_ids = array();
        foreach($requests_ct4_detailkegiatan as $ct_request){
            if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                Detailpjk::where("id", $ct_request["id"])->update([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $thispjk->id,
                    "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                    "deskripsibiaya" => $ct_request["deskripsibiaya"],
                    "standarbiaya" => $ct_request["standarbiaya"],
                    "volume" => $ct_request["volume"],
                    "satuan" => $ct_request["satuan"],
                    "satuan_label" => $ct_request["satuan_label"],
                    'kegiatan_id' => $id,
                    "desc_detail" => $ct_request["desc_detail"],
                    "user_updater_id" => Auth::user()->id
                ]);
            }else{
                $idct = Detailpjk::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $thispjk->id,
                    "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                    "deskripsibiaya" => $ct_request["deskripsibiaya"],
                    "standarbiaya" => $ct_request["standarbiaya"],
                    "volume" => $ct_request["volume"],
                    "satuan" => $ct_request["satuan"],
                    "satuan_label" => $ct_request["satuan_label"],
                    'kegiatan_id' => $id,
                    "desc_detail" => $ct_request["desc_detail"],
                    "user_creator_id" => Auth::user()->id
                ])->id;
                array_push($new_menu_field_ids, $idct);
            }
        }

        foreach(Detailpjk::whereParentId($id)->get() as $ch){
            $is_still_exist = false;
            foreach($requests_ct4_detailkegiatan as $ct_request){
                if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                    $is_still_exist = true;
                }
            }
            if(!$is_still_exist){
                Detailpjk::whereId($ch->id)->delete();
            }
        }

        return response()->json([
            'status' => 201,
            'message' => 'Id '.$id.' is updated',
            'data' => ['id' => $id]
        ]);
    }

    public function storepjk(Request $request, $id)
    {
        $keg = Kegiatan::where("id",$id)->first();
        if($keg->status != "paid"){
            abort(403, "tidak dapat di PJK, status belum terbayar");
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

        $rules_ct4_detailkegiatan = $page_data["fieldsrules_ct4_detailkegiatan"];
        $requests_ct4_detailkegiatan = json_decode($request->ct4_detailkegiatan, true);
        foreach($requests_ct4_detailkegiatan as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct4_detailkegiatan"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct4_detailkegiatan, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $pjkid = Pjk::create([
                "unit_pelaksana"=> $request->unit_pelaksana,
                "unit_pelaksana_label"=> $request->unit_pelaksana_label,
                "tahun"=> $request->tahun,
                "tahun_label"=> $request->tahun_label,
                "programkerja"=> $request->programkerja,
                "programkerja_label"=> $request->programkerja_label,
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

            $requests_ct3_outputlpj = json_decode($request->ct3_outputrka, true);
            $new_menu_field_ids = array();
            foreach($requests_ct3_outputlpj as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Outputlpj::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $pjkid,
                        "iku"=> $ct_request["iku"],
                        "iku_label"=> $ct_request["iku_label"],
                        "indikator"=> $ct_request["indikator"],
                        "keterangan"=> $ct_request["keterangan"],
                        "target"=> $ct_request["target"],
                        "satuan_target"=> $ct_request["satuan_target"],
                        "realisasi" => $ct_request["realisasi"],
                        "satuan_realisasi" => $ct_request["satuan_realisasi"],
                        "file_bukti" => $ct_request["file_bukti"],
                        "link_bukti" => $ct_request["link_bukti"],
                        "hasil_pencapaian" => $ct_request["hasil_pencapaian"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Outputlpj::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $pjkid,
                        "iku"=> $ct_request["iku"],
                        "iku_label"=> $ct_request["iku_label"],
                        "indikator"=> $ct_request["indikator"],
                        "keterangan"=> $ct_request["keterangan"],
                        "target"=> $ct_request["target"],
                        "satuan_target"=> $ct_request["satuan_target"],
                        "realisasi" => $ct_request["realisasi"],
                        "satuan_realisasi" => $ct_request["satuan_realisasi"],
                        "file_bukti" => $ct_request["file_bukti"],
                        "link_bukti" => $ct_request["link_bukti"],
                        "hasil_pencapaian" => $ct_request["hasil_pencapaian"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Outputlpj::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct3_outputlpj as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Outputlpj::whereId($ch->id)->delete();
                }
            }

            $new_menu_field_ids = array();
            foreach($requests_ct4_detailkegiatan as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    Detailpjk::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $pjkid,
                        "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                        "deskripsibiaya" => $ct_request["deskripsibiaya"],
                        "standarbiaya" => $ct_request["standarbiaya"],
                        "volume" => $ct_request["volume"],
                        "satuan" => $ct_request["satuan"],
                        "satuan_label" => $ct_request["satuan_label"],
                        'kegiatan_id' => $id,
                        "desc_detail" => $ct_request["desc_detail"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Detailpjk::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $pjkid,
                        "detailbiayaproker_name" => $ct_request["detailbiayaproker_name"],
                        "deskripsibiaya" => $ct_request["deskripsibiaya"],
                        "standarbiaya" => $ct_request["standarbiaya"],
                        "volume" => $ct_request["volume"],
                        "satuan" => $ct_request["satuan"],
                        "satuan_label" => $ct_request["satuan_label"],
                        'kegiatan_id' => $id,
                        "desc_detail" => $ct_request["desc_detail"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Detailpjk::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($requests_ct4_detailkegiatan as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Detailpjk::whereId($ch->id)->delete();
                }
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
            }elseif($kegiatan->status != "paid"){
                abort(403, "RKA belum terbayar");
            }

            $pjk = Pjk::where("kegiatan_id", $request->id)->first();
            if($pjk){
                // $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->get();
                // if(Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role)->orderBy("no_seq")->count() < 1){
                //     $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                //     if(Detailbiayapjk::whereKegiatanId($request->id)->whereNull("isarchived")->orderBy("no_seq")->count() < 1){
                //         $lastapp = Approval::where("parent_id", $pjk->id)->where("role", Auth::user()->role)->where("jenismenu", "PJK")->orderBy("no_seq", "asc")->first();
                //         $beforeapp = Approval::where("parent_id", $pjk->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "PJK")->first();
                //         if($beforeapp){
                //             $ct1_detailbiayakegiatans = Detailbiayapjk::whereKegiatanId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
                //         }
                //     }
                // }

                $ct1_detailbiayakegiatans = Detailbiayapjk::whereParentId($pjk->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                foreach(Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->orderBy("no_seq", "desc")->get() as $app){
                    $dtbk = Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($dtbk){
                        $ct1_detailbiayakegiatans = Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }

                // $ct3_outputlpjs = Outputlpj::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->get();
                // if(Outputlpj::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", Auth::user()->role_label)->orderBy("no_seq")->count() < 1){
                //     $ct3_outputlpjs = Outputlpj::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                //     if(Outputlpj::whereParentId($request->id)->whereNull("isarchived")->count() < 1){
                //         $lastapp = Approval::where("parent_id", $request->id)->where("role", Auth::user()->role)->where("jenismenu", "RKA")->first();
                //         $beforeapp = Approval::where("parent_id", $request->id)->where("no_seq", ((int)$lastapp->no_seq)+1)->where("jenismenu", "RKA")->first();
                //         if($beforeapp){
                //             $ct3_outputlpjs = Outputlpj::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $beforeapp->role)->orderBy("no_seq")->get();
                //         }
                //     }
                // }

                $ct3_outputrkas = Outputlpj::whereParentId($pjk->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                foreach(Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->orderBy("no_seq", "desc")->get() as $app){
                    $ok = Outputlpj::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($ok){
                        $ct3_outputrkas = Outputlpj::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }

                $ct4_detailkegiatans = Detailpjk::whereParentId($pjk->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                foreach(Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->orderBy("no_seq", "desc")->get() as $app){
                    $dtbk = Detailpjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($dtbk){
                        $ct4_detailkegiatans = Detailpjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }
            
                $ct2_approvals = Approval::whereParentId($pjk->id)->where("jenismenu", "PJK")->get();
                
                $pjk->kode_anggaran = $kegiatan->kode_anggaran;
                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                        "ct2_approval" => $ct2_approvals,
                        "ct3_outputrka" => $ct3_outputrkas,
                        "kegiatan" => $pjk,
                        "ct4_detailkegiatan" => $ct4_detailkegiatans
                    ]
                );
            }else{
                $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                    $dtbk = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($dtbk){
                        $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }
    
                $ct3_outputrkas = Outputrka::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();
    
                foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                    $ok = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($ok){
                        $ct3_outputrkas = Outputrka::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }

                $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->whereNull("isarchived")->orderBy("no_seq")->get();

                foreach(Approval::where("parent_id", $request->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                    $dtbk = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                    if($dtbk){
                        $ct4_detailkegiatans = Detailkegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get();
                    }
                }

                $ct2_approvals = [];

                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "ct1_detailbiayakegiatan" => $ct1_detailbiayakegiatans,
                        "ct2_approval" => $ct2_approvals,
                        "ct3_outputrka" => $ct3_outputrkas,
                        "kegiatan" => $kegiatan,
                        "ct4_detailkegiatan" => $ct4_detailkegiatans
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

    public function getdatakegiatanplafon(Request $request){
        if($request->ajax() || $request->wantsJson()){
            if(isset($request->tanggal_kegiatan) && isset($request->unitkerja)){
                $valplafon = 0;
                $valprocess = 0;
                $valapproved = 0;
                $valsubmitted = 0;
                $valpaid = 0;
                $valpjkprocess = 0;
                $valpjkapproved = 0;
                $valsisa = 0;

                $tahun = explode("/", $request->tanggal_kegiatan)[2];
                $sett = Settingpagupendapatan::where("tahun", $tahun)->orderBy("id", "desc")->first();
                if($sett){
                    $nilaipagu = Nilaipagu::where("parent_id", $sett->id)->where("unitkerja", $request->unitkerja)->first();
                    if($nilaipagu){
                        $valplafon = $nilaipagu->maxbiaya;
                    }
                }

                foreach(Kegiatan::where("unit_pelaksana", $request->unitkerja)->whereBetween("tanggal", [$tahun."-01-01", $tahun."-12-31"])->get() as $keg){
                    if($keg->status == "process" || $keg->status == "approving"){
                        $nom = 0;
                        foreach(Detailbiayakegiatan::whereParentId($keg->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                            $nom += $det->nominalbiaya;
                        }

                        foreach(Approval::where("parent_id", $keg->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                            $dtbk = Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                            $nom = 0;
                            if($dtbk){
                                foreach(Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                    $nom += $det->nominalbiaya;
                                }
                            }
                        }

                        $valprocess = $valprocess+$nom;
                    }elseif($keg->status == "approved" || $keg->status == "submitting"){
                        $nom = 0;
                        foreach(Detailbiayakegiatan::whereParentId($keg->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                            $nom += $det->nominalbiaya;
                        }

                        foreach(Approval::where("parent_id", $keg->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                            $dtbk = Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                            $nom = 0;
                            if($dtbk){
                                foreach(Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                    $nom += $det->nominalbiaya;
                                }
                            }
                        }

                        $valapproved = $valapproved+$nom;
                    }elseif($keg->status == "submitted"){
                        $nom = 0;
                        foreach(Detailbiayakegiatan::whereParentId($keg->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                            $nom += $det->nominalbiaya;
                        }

                        foreach(Approval::where("parent_id", $keg->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                            $dtbk = Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                            $nom = 0;
                            if($dtbk){
                                foreach(Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                    $nom += $det->nominalbiaya;
                                }
                            }
                        }

                        $valsubmitted = $valsubmitted+$nom;
                    }elseif($keg->status == "paid"){
                        $pjk = Pjk::where("kegiatan_id", $keg->id)->first();
                        if(!$pjk){
                            $nom = 0;
                            foreach(Detailbiayakegiatan::whereParentId($keg->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                                $nom += $det->nominalbiaya;
                            }

                            foreach(Approval::where("parent_id", $keg->id)->where("jenismenu", "RKA")->orderBy("no_seq", "desc")->get() as $app){
                                $dtbk = Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                                $nom = 0;
                                if($dtbk){
                                    foreach(Detailbiayakegiatan::whereParentId($keg->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                        $nom += $det->nominalbiaya;
                                    }
                                }
                            }

                            $valpaid = $valpaid+$nom;
                        }elseif($pjk->status == "process" || $pjk->status == "approving"){
                            $nom = 0;
                            foreach(Detailbiayapjk::whereParentId($pjk->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                                $nom += $det->nominalbiaya;
                            }

                            foreach(Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->orderBy("no_seq", "desc")->get() as $app){
                                $dtbk = Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                                $nom = 0;
                                if($dtbk){
                                    foreach(Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                        $nom += $det->nominalbiaya;
                                    }
                                }
                            }

                            $valpjkprocess = $valpjkprocess+$nom;
                        }elseif($pjk->status == "approved"){
                            $nom = 0;
                            foreach(Detailbiayapjk::whereParentId($pjk->id)->whereNull("isarchived")->orderBy("no_seq")->get() as $det){
                                $nom += $det->nominalbiaya;
                            }

                            foreach(Approval::where("parent_id", $pjk->id)->where("jenismenu", "PJK")->orderBy("no_seq", "desc")->get() as $app){
                                $dtbk = Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->first();
                                $nom = 0;
                                if($dtbk){
                                    foreach(Detailbiayapjk::whereParentId($pjk->id)->where("isarchived", "on")->where("archivedby", $app->role)->orderBy("no_seq")->get() as $det){
                                        $nom += $det->nominalbiaya;
                                    }
                                }
                            }

                            $valpjkapproved = $valpjkapproved+$nom;
                        }
                        
                    }
                }

                $valsisa = $valplafon-$valprocess-$valapproved-$valsubmitted-$valpaid-$valpjkprocess-$valpjkapproved;
                $results = array(
                    "status" => 201,
                    "message" => "Data available",
                    "data" => [
                        "valplafon" => $valplafon,
                        "valprocess" => $valprocess,
                        "valapproved" => $valapproved,
                        "valsubmitted" => $valsubmitted,
                        "valpaid" => $valpaid,
                        "valpjkprocess" => $valpjkprocess,
                        "valpjkapproved" => $valpjkapproved,
                        "valsisa" => $valsisa
                    ]
                );
    
                return response()->json($results);

            }
        }
    }

    public function tgl_dbs($tanggal){
        $date = str_replace('/', '-', $tanggal);
        return date('Y-m-d', strtotime($date));
    }

    public function kodeanggaran($request, $id){
        $uk = Unitkerja::where("id", $request->unit_pelaksana)->first();
        $kode_anggaran = "YA".$uk->unitkerja_code;
        if($uk->unitkerja_code != "0000"){
            $kode_anggaran = "UN".$uk->unitkerja_code;
        }
        $tgl = explode('-', $request->tanggal_kegiatan_submit);
        $kode_anggaran = $kode_anggaran.'-'.$tgl[0].$tgl[1];
        $nomor = "".$id;
        for($i = 0; $i < strlen((string)$id); $i++){
            $nomor = "0".$nomor;
        }
        $kode_anggaran = $kode_anggaran.'-'.$nomor;
        return $kode_anggaran;
    }
}