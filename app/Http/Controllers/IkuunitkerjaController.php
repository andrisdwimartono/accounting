<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ikuunitkerja;
use App\Models\Unitkerja;
use App\Models\Iku;

class IkuunitkerjaController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "IKU Unit Kerja",
            "page_data_urlname" => "ikuunitkerja",
            "fields" => [
                "iku_tahun" => "select",
                "iku_unit_pelaksana" => "link",
                "upload_dokumen" => "upload",
                "ct1_iku" => "childtable"
            ],
            "fieldschildtable" => [
                "ct1_iku" => [
                    "jenis_iku" => "select",
                    "iku_name" => "text",
                    "unit_pelaksana" => "hidden",
                    "unit_pelaksana_label" => "hidden",
                    "tahun" => "hidden",
                    "unit_pendukung" => "link",
                    "nilai_standar_opt" => "select",
                    "nilai_standar" => "numeric",
                    "satuan_nilai_standar" => "select",
                    "nilai_baseline_opt" => "select",
                    "nilai_baseline" => "numeric",
                    "satuan_nilai_baseline" => "select",
                    "nilai_renstra_opt" => "select",
                    "nilai_renstra" => "numeric",
                    "satuan_nilai_renstra" => "select",
                    "nilai_target_tahunan_opt" => "select",
                    "nilai_target_tahunan" => "numeric",
                    "satuan_nilai_target_tahunan" => "select",
                    "keterangan" => "textarea",
                    "sumber_data" => "textarea",
                    "rujukan" => "text",
                    "upload_detail" => "upload"
                ]
            ],
            "fieldsoptions" => [
                "iku_tahun" => [
                    ["name" => "2020", "label" => "2020"],
                    ["name" => "2021", "label" => "2021"],
                    ["name" => "2022", "label" => "2022"],
                    ["name" => "2023", "label" => "2023"]
                ],
                "jenis_iku" => [
                    ["name" => "Visi Misi", "label" => "Visi Misi"],
                    ["name" => "Tata Pamong", "label" => "Tata Pamong"],
                    ["name" => "Mahasiswa", "label" => "Mahasiswa"],
                    ["name" => "Sumber Daya Manusia", "label" => "Sumber Daya Manusia"],
                    ["name" => "Keuangan dan Sarpras", "label" => "Keuangan dan Sarpras"],
                    ["name" => "Pendidikan", "label" => "Pendidikan"],
                    ["name" => "Penelitian", "label" => "Penelitian"],
                    ["name" => "Pengabdian Masyarakat", "label" => "Pengabdian Masyarakat"],
                    ["name" => "Luaran dan Capaian Tridharma", "label" => "Luaran dan Capaian Tridharma"],
                    ["name" => "Jati Diri", "label" => "Jati Diri"]
                ],
                "nilai_standar_opt" => [
                    ["name" => ">=", "label" => "≥"],
                    ["name" => ">", "label" => ">"],
                    ["name" => "==", "label" => "="],
                    ["name" => "<", "label" => "<"],
                    ["name" => "<=", "label" => "≤"],
                    ["name" => "!=", "label" => "≠"]
                ],
                "satuan_nilai_standar" => [
                    ["name" => "percent", "label" => "%"],
                    ["name" => "rp", "label" => "Rp"]
                ],
                "nilai_baseline_opt" => [
                    ["name" => ">=", "label" => "≥"],
                    ["name" => ">", "label" => ">"],
                    ["name" => "==", "label" => "="],
                    ["name" => "<", "label" => "<"],
                    ["name" => "<=", "label" => "≤"],
                    ["name" => "!=", "label" => "≠"]
                ],
                "satuan_nilai_baseline" => [
                    ["name" => "percent", "label" => "%"],
                    ["name" => "rp", "label" => "Rp"]
                ],
                "nilai_renstra_opt" => [
                    ["name" => ">=", "label" => "≥"],
                    ["name" => ">", "label" => ">"],
                    ["name" => "==", "label" => "="],
                    ["name" => "<", "label" => "<"],
                    ["name" => "<=", "label" => "≤"],
                    ["name" => "!=", "label" => "≠"]
                ],
                "satuan_nilai_renstra" => [
                    ["name" => "percent", "label" => "%"],
                    ["name" => "rp", "label" => "Rp"]
                ],
                "nilai_target_tahunan_opt" => [
                    ["name" => ">=", "label" => "≥"],
                    ["name" => ">", "label" => ">"],
                    ["name" => "==", "label" => "="],
                    ["name" => "<", "label" => "<"],
                    ["name" => "<=", "label" => "≤"],
                    ["name" => "!=", "label" => "≠"]
                ],
                "satuan_nilai_target_tahunan" => [
                    ["name" => "percent", "label" => "%"],
                    ["name" => "rp", "label" => "Rp"]
                ]
            ],
            "fieldlink" => [
                "iku_unit_pelaksana" => "unitkerjas",
                "unit_pendukung" => "unitkerjas"
            ]
        ];

        $iku_tahun_list = "2020,2021,2022,2023";

        $jenis_iku_list = "Visi Misi,Tata Pamong,Mahasiswa,Sumber Daya Manusia,Keuangan dan Sarpras,Pendidikan,Penelitian,Pengabdian Masyarakat,Luaran dan Capaian Tridharma,Jati Diri";

        $nilai_standar_opt_list = ">=,>,==,<,<=,!=";

        $satuan_nilai_standar_list = "percent,rp";

        $nilai_baseline_opt_list = ">=,>,==,<,<=,!=";

        $satuan_nilai_baseline_list = "percent,rp";

        $nilai_renstra_opt_list = ">=,>,==,<,<=,!=";

        $satuan_nilai_renstra_list = "percent,rp";

        $nilai_target_tahunan_opt_list = ">=,>,==,<,<=,!=";

        $satuan_nilai_target_tahunan_list = "percent,rp";

        $td["fieldsrules"] = [
            "iku_tahun" => "required|in:2020,2021,2022,2023",
            "iku_unit_pelaksana" => "required|exists:unitkerjas,id",
            "ct1_iku" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_ct1_iku"] = [
            "jenis_iku" => "required|in:Visi Misi,Tata Pamong,Mahasiswa,Sumber Daya Manusia,Keuangan dan Sarpras,Pendidikan,Penelitian,Pengabdian Masyarakat,Luaran dan Capaian Tridharma,Jati Diri",
            "iku_name" => "required",
            "unit_pelaksana" => "required",
            "unit_pendukung" => "exists:unitkerjas,id",
            "nilai_standar" => "required|numeric",
            "satuan_nilai_standar" => "nullable|in:percent,rp",
            "nilai_standar_opt" => "required|in:>=,>,==,<,<=,!=",
            "nilai_baseline" => "required|numeric",
            "satuan_nilai_baseline" => "nullable|in:percent,rp",
            "nilai_baseline_opt" => "required|in:>=,>,==,<,<=,!=",
            "nilai_renstra" => "required|numeric",
            "satuan_nilai_renstra" => "nullable|in:percent,rp",
            "nilai_renstra_opt" => "required|in:>=,>,==,<,<=,!=",
            "nilai_target_tahunan" => "required|numeric",
            "satuan_nilai_target_tahunan" => "nullable|in:percent,rp",
            "nilai_target_tahunan_opt" => "required|in:>=,>,==,<,<=,!=",
            "keterangan" => "max:1000",
            "sumber_data" => "max:1000",
            "unit_pelaksana_label" => "required",
            "tahun" => "required"
        ];

        $td["fieldsmessages_ct1_iku"] = [
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
        $page_data["page_data_urlname"] = "iku";
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.header_js_list"];
        

        return view("ikuunitkerja.list", ["page_data" => $page_data]);
    }

    public function indexikt()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "IKT Unit Kerja";
        $page_data["page_data_urlname"] = "iktunitkerja";
        $page_data["ikt"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.header_js_list"];
        
        return view("ikuunitkerja.list", ["page_data" => $page_data]);
    }

    public function indexsik()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["page_data_name"] = "SIK Unit Kerja";
        $page_data["page_data_urlname"] = "sikunitkerja";
        $page_data["sik"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.header_js_list"];
        
        return view("ikuunitkerja.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function createikt()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["page_data_name"] = "IKT Unit Kerja";
        $page_data["page_data_urlname"] = "iktunitkerja";
        $page_data["ikt"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function createsik()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["page_data_name"] = "SIK Unit Kerja";
        $page_data["page_data_urlname"] = "sikunitkerja";
        $page_data["sik"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
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
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Ikuunitkerja::create([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_iku as $ct_request){
                Iku::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "jenis_iku"=> $ct_request["jenis_iku"],
                    "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                    "iku_name"=> $ct_request["iku_name"],
                    "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                    "unit_pendukung"=> $ct_request["unit_pendukung"],
                    "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                    "nilai_standar"=> $ct_request["nilai_standar"],
                    "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                    "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                    "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                    "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                    "nilai_baseline"=> $ct_request["nilai_baseline"],
                    "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                    "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                    "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                    "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                    "nilai_renstra"=> $ct_request["nilai_renstra"],
                    "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                    "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                    "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                    "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                    "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                    "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                    "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                    "keterangan"=> $ct_request["keterangan"],
                    "sumber_data"=> $ct_request["sumber_data"],
                    "rujukan"=> $ct_request["rujukan"],
                    "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                    "tahun"=> $ct_request["tahun"],
                    "upload_detail"=> $ct_request["upload_detail"],
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

    public function storeikt(Request $request)
    {
        $page_data = $this->tabledesign();
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Ikuunitkerja::create([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "is_ikt" => "on",
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_iku as $ct_request){
                Iku::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "jenis_iku"=> $ct_request["jenis_iku"],
                    "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                    "iku_name"=> $ct_request["iku_name"],
                    "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                    "unit_pendukung"=> $ct_request["unit_pendukung"],
                    "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                    "nilai_standar"=> $ct_request["nilai_standar"],
                    "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                    "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                    "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                    "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                    "nilai_baseline"=> $ct_request["nilai_baseline"],
                    "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                    "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                    "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                    "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                    "nilai_renstra"=> $ct_request["nilai_renstra"],
                    "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                    "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                    "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                    "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                    "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                    "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                    "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                    "keterangan"=> $ct_request["keterangan"],
                    "sumber_data"=> $ct_request["sumber_data"],
                    "rujukan"=> $ct_request["rujukan"],
                    "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                    "tahun"=> $ct_request["tahun"],
                    "upload_detail"=> $ct_request["upload_detail"],
                    "is_ikt" => "on",
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

    public function storesik(Request $request)
    {
        $page_data = $this->tabledesign();
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Ikuunitkerja::create([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "is_sik" => "on",
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_ct1_iku as $ct_request){
                Iku::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "jenis_iku"=> $ct_request["jenis_iku"],
                    "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                    "iku_name"=> $ct_request["iku_name"],
                    "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                    "unit_pendukung"=> $ct_request["unit_pendukung"],
                    "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                    "nilai_standar"=> $ct_request["nilai_standar"],
                    "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                    "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                    "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                    "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                    "nilai_baseline"=> $ct_request["nilai_baseline"],
                    "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                    "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                    "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                    "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                    "nilai_renstra"=> $ct_request["nilai_renstra"],
                    "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                    "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                    "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                    "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                    "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                    "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                    "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                    "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                    "keterangan"=> $ct_request["keterangan"],
                    "sumber_data"=> $ct_request["sumber_data"],
                    "rujukan"=> $ct_request["rujukan"],
                    "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                    "tahun"=> $ct_request["tahun"],
                    "upload_detail"=> $ct_request["upload_detail"],
                    "is_sik" => "on",
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
    public function show(Ikuunitkerja $ikuunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $ikuunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function showikt(Ikuunitkerja $iktunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["page_data_name"] = "IKT Unit Kerja";
        $page_data["page_data_urlname"] = "iktunitkerja";
        $page_data["ikt"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $iktunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function showsik(Ikuunitkerja $sikunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["page_data_name"] = "SIK Unit Kerja";
        $page_data["page_data_urlname"] = "sikunitkerja";
        $page_data["sik"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $sikunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Ikuunitkerja $ikuunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $ikuunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function editikt(Ikuunitkerja $iktunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["page_data_name"] = "IKT Unit Kerja";
        $page_data["page_data_urlname"] = "iktunitkerja";
        $page_data["ikt"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $iktunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
    }

    public function editsik(Ikuunitkerja $sikunitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["page_data_name"] = "SIK Unit Kerja";
        $page_data["page_data_urlname"] = "sikunitkerja";
        $page_data["sik"] = true;
        $page_data["footer_js_page_specific_script"] = ["ikuunitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $sikunitkerja->id;
        return view("ikuunitkerja.create", ["page_data" => $page_data]);
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
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Ikuunitkerja::where("id", $id)->update([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_ct1_iku as $ct_request){
                if(isset($ct_request["id"])){
                    Iku::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"]==''?null:$ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"]==''?null:$ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"]==''?null:$ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"]==''?null:$ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Iku::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Iku::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_iku as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Iku::whereId($ch->id)->delete();
                    }
                }

            return response()->json([
                'status' => 201,
                'message' => 'Id '.$id.' is updated',
                'data' => ['id' => $id]
            ]);
        }
    }

    public function updateikt(Request $request, $id)
    {
        $page_data = $this->tabledesign();
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Ikuunitkerja::where("id", $id)->update([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "is_ikt"=> "on",
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_ct1_iku as $ct_request){
                if(isset($ct_request["id"])){
                    Iku::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"]==''?null:$ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"]==''?null:$ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"]==''?null:$ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"]==''?null:$ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "is_ikt"=> "on",
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Iku::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "is_ikt"=> "on",
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Iku::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_iku as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Iku::whereId($ch->id)->delete();
                    }
                }

            return response()->json([
                'status' => 201,
                'message' => 'Id '.$id.' is updated',
                'data' => ['id' => $id]
            ]);
        }
    }

    public function updatesik(Request $request, $id)
    {
        $page_data = $this->tabledesign();
        $rules_ct1_iku = $page_data["fieldsrules_ct1_iku"];
        $requests_ct1_iku = json_decode($request->ct1_iku, true);
        foreach($requests_ct1_iku as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_ct1_iku"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_ct1_iku, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Ikuunitkerja::where("id", $id)->update([
                "iku_tahun"=> $request->iku_tahun,
                "iku_tahun_label"=> $request->iku_tahun_label,
                "iku_unit_pelaksana"=> $request->iku_unit_pelaksana,
                "iku_unit_pelaksana_label"=> $request->iku_unit_pelaksana_label,
                "upload_dokumen"=> $request->upload_dokumen,
                "is_sik"=> "on",
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_ct1_iku as $ct_request){
                if(isset($ct_request["id"])){
                    Iku::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"]==''?null:$ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"]==''?null:$ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"]==''?null:$ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"]==''?null:$ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "is_sik"=> "on",
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Iku::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "jenis_iku"=> $ct_request["jenis_iku"],
                        "jenis_iku_label"=> $ct_request["jenis_iku_label"],
                        "iku_name"=> $ct_request["iku_name"],
                        "unit_pelaksana"=> $ct_request["unit_pelaksana"],
                        "unit_pendukung"=> $ct_request["unit_pendukung"],
                        "unit_pendukung_label"=> $ct_request["unit_pendukung_label"],
                        "nilai_standar"=> $ct_request["nilai_standar"],
                        "satuan_nilai_standar"=> $ct_request["satuan_nilai_standar"],
                        "satuan_nilai_standar_label"=> $ct_request["satuan_nilai_standar_label"],
                        "nilai_standar_opt"=> $ct_request["nilai_standar_opt"],
                        "nilai_standar_opt_label"=> $ct_request["nilai_standar_opt_label"],
                        "nilai_baseline"=> $ct_request["nilai_baseline"],
                        "satuan_nilai_baseline"=> $ct_request["satuan_nilai_baseline"],
                        "satuan_nilai_baseline_label"=> $ct_request["satuan_nilai_baseline_label"],
                        "nilai_baseline_opt"=> $ct_request["nilai_baseline_opt"],
                        "nilai_baseline_opt_label"=> $ct_request["nilai_baseline_opt_label"],
                        "nilai_renstra"=> $ct_request["nilai_renstra"],
                        "satuan_nilai_renstra"=> $ct_request["satuan_nilai_renstra"],
                        "satuan_nilai_renstra_label"=> $ct_request["satuan_nilai_renstra_label"],
                        "nilai_renstra_opt"=> $ct_request["nilai_renstra_opt"],
                        "nilai_renstra_opt_label"=> $ct_request["nilai_renstra_opt_label"],
                        "nilai_target_tahunan"=> $ct_request["nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan"=> $ct_request["satuan_nilai_target_tahunan"],
                        "satuan_nilai_target_tahunan_label"=> $ct_request["satuan_nilai_target_tahunan_label"],
                        "nilai_target_tahunan_opt"=> $ct_request["nilai_target_tahunan_opt"],
                        "nilai_target_tahunan_opt_label"=> $ct_request["nilai_target_tahunan_opt_label"],
                        "keterangan"=> $ct_request["keterangan"],
                        "sumber_data"=> $ct_request["sumber_data"],
                        "rujukan"=> $ct_request["rujukan"],
                        "unit_pelaksana_label"=> $ct_request["unit_pelaksana_label"],
                        "tahun"=> $ct_request["tahun"],
                        "upload_detail"=> $ct_request["upload_detail"],
                        "is_sik"=> "on",
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Iku::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_ct1_iku as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Iku::whereId($ch->id)->delete();
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
            $ikuunitkerja = Ikuunitkerja::whereId($request->id)->first();
            if(!$ikuunitkerja){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Ikuunitkerja::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "bab","elemen","indikator", "id");
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
        foreach(Iku::where(function($q) use ($keyword) {
            $q->where("bab", "LIKE", "%" . $keyword. "%")->orWhere("elemen", "LIKE", "%" . $keyword. "%")->orWhere("indikator", "LIKE", "%" . $keyword. "%");
        })->where("type", $request->type)
        ->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "bab", "elemen", "indikator"]) as $ikuunitkerja){
            $no = $no+1;

            $act = '
            <a href="/iku/'.$ikuunitkerja->id.'" class="btn btn-info shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fa fa-eye"></i></a>

            <a href="/iku/'.$ikuunitkerja->id.'/edit" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User Data"><i class="fa fa-edit"></i></a>

            <a class="row-delete btn btn-danger shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><i class="fa fa-trash"></i></a>';

            array_push($dt, array($ikuunitkerja->id, $ikuunitkerja->bab, $ikuunitkerja->elemen, $ikuunitkerja->indikator, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Iku::get()->count(),
            "recordsFiltered" => intval(Iku::where(function($q) use ($keyword) {
                $q->where("bab", "LIKE", "%" . $keyword. "%")->orWhere("elemen", "LIKE", "%" . $keyword. "%")->orWhere("indikator", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $ikuunitkerja = Ikuunitkerja::whereId($request->id)->first();
            if(!$ikuunitkerja){
                abort(404, "Data not found");
            }

            $ct1_ikus = Iku::whereParentId($request->id)->where(function($q) use ($request){
                if($request->is_ikt == "on"){
                    $q->where("is_ikt", "on");
                }else{
                    $q->whereNull("is_ikt");
                }
            })->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_iku" => $ct1_ikus,
                    "ikuunitkerja" => $ikuunitkerja,
                    "iktunitkerja" => $ikuunitkerja
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
            }elseif($request->field == "iku_unit_pelaksana"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "unit_pendukung"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
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
}
