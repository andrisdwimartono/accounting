<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jurnal;
use App\Models\Unitkerja;
use App\Models\Transaction;
use App\Models\Anggaran;
use App\Models\Coa;
use App\Models\Jenisbayar;
use App\Models\Neracasaldo;
use App\Models\Neraca;
use App\Models\Labarugi;
use App\Models\Bankva;
use App\Models\Opencloseperiode;

class JurnalController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Jurnal",
            "page_data_urlname" => "jurnal",
            "fields" => [
                "unitkerja" => "link",
                "no_jurnal" => "text",
                "tanggal_jurnal" => "date",
                "keterangan" => "textarea",
                "transaksi" => "childtable"
            ],
            "fieldschildtable" => [
                "transaksi" => [
                    "unitkerja" => "link",
                    "anggaran" => "link",
                    "no_jurnal" => "hidden",
                    "tanggal" => "date",
                    "keterangan" => "textarea",
                    "jenis_transaksi" => "hidden",
                    "coa" => "link",
                    "deskripsi" => "textarea",
                    "jenisbayar" => "link",
                    "nim" => "hidden",
                    "kode_va" => "hidden",
                    "fheader" => "hidden",
                    "debet" => "float",
                    "credit" => "float"
                ]
            ],
            "fieldlink" => [
                "unitkerja" => "unitkerjas",
                "unitkerja" => "unitkerjas",
                "anggaran" => "anggarans",
                "coa" => "coas",
                "jenisbayar" => "jenisbayars"
            ]
        ];

        $td["fieldsrules"] = [
            "unitkerja" => "required|exists:unitkerjas,id",
            "no_jurnal" => "required|min:1|max:25",
            "tanggal_jurnal" => "required|date_format:Y-m-d",
            "keterangan" => "max:255",
            // "transaksi" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_transaksi"] = [
            "deskripsi" => "max:255",
            "debet" => "required|numeric",
            "credit" => "required|numeric",
            "unitkerja" => "required|exists:unitkerjas,id",
            // "anggaran" => "exists:anggarans,id",
            // "tanggal" => "required",
            "coa" => "required|exists:coas,id",
            // "jenisbayar" => "exists:jenisbayars,id"
        ];

        $td["fieldsmessages_transaksi"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_bkmk"] = [
            "unitkerja" => "required|exists:unitkerjas,id",
            "no_jurnal" => "required|min:1|max:25",
            "tanggal_jurnal" => "required|date_format:Y-m-d",
            "keterangan" => "max:255",
            "bank_kas" => "required|exists:coas,id",
            // "transaksi" => "required"
        ];

        $td["fieldsmessages_bkmk"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_pendapatan"] = [
            "kode_va" => "max:255",
            "nim" => "max:255",
            // "transaksi" => "required"
        ];

        $td["fieldsmessages_pendapatan"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_transaksi_pendapatan"] = [
            "nominal" => "required|numeric",
            "prodi" => "numeric",
            "jenisbayar" => "required"
        ];

        $td["fieldsmessages_transaksi_pendapatan"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_pencairandana"] = [
            "kode_bank" => "required|max:255",
            "nominal" => "required|numeric",
            "clientreff" => "required"
        ];

        $td["fieldsmessages_pencairandana"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_pjkpencairandana"] = [
            "clientreff" => "required",
            "clientreff_pencairan" => "required"
        ];

        $td["fieldsmessages_pjkpencairandana"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_transaksi_pjkpencairandana"] = [
            "nominal" => "required|numeric",
            "jenisbayar" => "required"
        ];

        $td["fieldsmessages_transaksi_pjkpencairandana"] = [
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
        
        return view("jurnal.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["jurnal.page_specific_script.header_js_create"];
        
        return view("jurnal.create", ["page_data" => $page_data]);
    }

    public function createsaldoawal()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["page_job"] = "Saldo Awal";
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["jurnal.page_specific_script.header_js_create"];
        
        return view("jurnal.create", ["page_data" => $page_data]);
    }

    public function createbkm()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["page_job"] = "BKM";
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_createbkmk"];
        $page_data["header_js_page_specific_script"] = ["jurnal.page_specific_script.header_js_createbkmk"];
        
        return view("jurnal.createbkmk", ["page_data" => $page_data]);
    }

    public function createbkk()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Create";
        $page_data["page_job"] = "BKK";
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_createbkmk"];
        $page_data["header_js_page_specific_script"] = ["jurnal.page_specific_script.header_js_createbkmk"];
        
        return view("jurnal.createbkmk", ["page_data" => $page_data]);
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
        $this->checkOpenPeriode($request->tanggal_jurnal);
        $rules_transaksi = $page_data["fieldsrules_transaksi"];
        $requests_transaksi = json_decode($request->transaksi, true);
        foreach($requests_transaksi as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaksi"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Jurnal::create([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "no_jurnal"=> $request->no_jurnal,
                "tanggal_jurnal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
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
            
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where("id", $ct_request["coa"])->first();
                $idct = Transaction::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "deskripsi"=> $ct_request["deskripsi"],
                    "debet"=> $ct_request["debet"],
                    "credit"=> $ct_request["credit"],
                    "unitkerja"=> $ct_request["unitkerja"],
                    "unitkerja_label"=> $ct_request["unitkerja_label"],
                    "anggaran"=> $ct_request["anggaran"],
                    "anggaran_label"=> $ct_request["anggaran_label"],
                    "tanggal"=> $request->tanggal_jurnal,
                    "keterangan"=> $ct_request["keterangan"],
                    "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $ct_request["jenisbayar"],
                    "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                    "nim"=> $ct_request["nim"],
                    "kode_va"=> $ct_request["kode_va"],
                    "fheader"=> $ct_request["fheader"],
                    "no_jurnal"=> $no_jurnal,
                    "user_creator_id" => Auth::user()->id
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            return response()->json([
                'status' => 201,
                'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
                'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }

    public function storebkmk(Request $request)
    {
        $page_data = $this->tabledesign();
        $this->checkOpenPeriode($request->tanggal_jurnal);
        $rules_transaksi = $page_data["fieldsrules_transaksi"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = 0;
        foreach($requests_transaksi as $ct_request){
            $no_seq++;
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaksi"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
            if($request->jurnal_type == "BKM"){
                $total_nominal = $total_nominal+$ct_request["credit"];
            }else{
                $total_nominal = $total_nominal+$ct_request["debet"];
            }
        }

        $rules = $page_data["fieldsrules_bkmk"];
        $messages = $page_data["fieldsmessages_bkmk"];
        if($request->validate($rules, $messages)){
            $id = Jurnal::create([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "no_jurnal"=> $request->no_jurnal,
                "tanggal_jurnal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            $no_jurnal = $request->jurnal_type;
            for($i = 0; $i < 7-strlen((string)$id); $i++){
                $no_jurnal .= "0";
            }
            $no_jurnal .= $id;
            Jurnal::where("id", $id)->update([
                "no_jurnal"=> $no_jurnal
            ]);
            
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where("id", $ct_request["coa"])->first();
                $idct = Transaction::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "deskripsi"=> $ct_request["deskripsi"],
                    "debet"=> $ct_request["debet"],
                    "credit"=> $ct_request["credit"],
                    "unitkerja"=> $ct_request["unitkerja"],
                    "unitkerja_label"=> $ct_request["unitkerja_label"],
                    "anggaran"=> $ct_request["anggaran"],
                    "anggaran_label"=> $ct_request["anggaran_label"],
                    "tanggal"=> $request->tanggal_jurnal,
                    "keterangan"=> $ct_request["keterangan"],
                    "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $ct_request["jenisbayar"],
                    "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                    "nim"=> $ct_request["nim"],
                    "kode_va"=> $ct_request["kode_va"],
                    "fheader"=> $ct_request["fheader"],
                    "no_jurnal"=> $no_jurnal,
                    "user_creator_id" => Auth::user()->id
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            $coa = Coa::where("id", $request->bank_kas)->first();
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> $request->jurnal_type=="BKM"?$total_nominal:0,
                "credit"=> $request->jurnal_type=="BKK"?$total_nominal:0,
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $request->bank_kas,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> 0,
                "jenisbayar_label"=> "",
                "nim"=> "",
                "kode_va"=> "",
                "fheader"=> "",
                "no_jurnal"=> $no_jurnal,
                "user_creator_id" => Auth::user()->id
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
                'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }


    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Jurnal $jurnal)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $jurnal->id;
        return view("jurnal.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Jurnal $jurnal)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["jurnal.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["jurnal.page_specific_script.header_js_create"];
        
        $page_data["id"] = $jurnal->id;
        return view("jurnal.create", ["page_data" => $page_data]);
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
        $this->checkOpenPeriode($request->tanggal_jurnal);
        $jr = Jurnal::where("id", $id)->first();
        $this->checkOpenPeriode($jr->tanggal_jurnal);
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi"];
        $requests_transaksi = json_decode($request->transaksi, true);
        foreach($requests_transaksi as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaksi"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Jurnal::where("id", $id)->update([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "tanggal_jurnal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_transaksi as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    $coa = Coa::where("id", $ct_request["coa"])->first();
                    $this->summerizeJournal("updatefirst", $ct_request["id"]);
                    Transaction::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "deskripsi"=> $ct_request["deskripsi"],
                        "debet"=> $ct_request["debet"],
                        "credit"=> $ct_request["credit"],
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "anggaran"=> $ct_request["anggaran"],
                        "anggaran_label"=> $ct_request["anggaran_label"],
                        "tanggal"=> $request->tanggal_jurnal,
                        "keterangan"=> $ct_request["keterangan"],
                        "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                        "jenisbayar"=> $ct_request["jenisbayar"],
                        "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                        "nim"=> $ct_request["nim"],
                        "kode_va"=> $ct_request["kode_va"],
                        "fheader"=> $ct_request["fheader"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                    $this->summerizeJournal("updatelast", $ct_request["id"]);
                }else{
                    $coa = Coa::where("id", $ct_request["coa"])->first();
                    $idct = Transaction::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "deskripsi"=> $ct_request["deskripsi"],
                        "debet"=> $ct_request["debet"],
                        "credit"=> $ct_request["credit"],
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "anggaran"=> $ct_request["anggaran"],
                        "anggaran_label"=> $ct_request["anggaran_label"],
                        "tanggal"=> $request->tanggal_jurnal,
                        "keterangan"=> $ct_request["keterangan"],
                        "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                        "jenisbayar"=> $ct_request["jenisbayar"],
                        "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                        "nim"=> $ct_request["nim"],
                        "kode_va"=> $ct_request["kode_va"],
                        "fheader"=> $ct_request["fheader"],
                        "no_jurnal"=> $request->no_jurnal,
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                    $this->summerizeJournal("store", $idct);
                }
            }

            foreach(Transaction::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_transaksi as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        $this->summerizeJournal("delete", $ch->id);
                        Transaction::whereId($ch->id)->delete();
                    }
                }

            return response()->json([
                'status' => 201,
                'message' => 'No Jurnal '.$request->no_jurnal." telah diupdate",
                'data' => ['id' => $id, 'no_jurnal' => $request->no_jurnal]
            ]);
        }
    }

    public function update_bkmk(Request $request, $id)
    {
        $this->checkOpenPeriode($request->tanggal_jurnal);
        $jr = Jurnal::where("id", $id)->first();
        $this->checkOpenPeriode($jr->tanggal_jurnal);
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = 0;
        foreach($requests_transaksi as $ct_request){
            $no_seq++;
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaksi"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
            if($request->jurnal_type == "BKM"){
                $total_nominal = $total_nominal+$ct_request["credit"];
            }else{
                $total_nominal = $total_nominal+$ct_request["debet"];
            }
        }

        $rules = $page_data["fieldsrules_bkmk"];
        $messages = $page_data["fieldsmessages_bkmk"];
        if($request->validate($rules, $messages)){
            Jurnal::where("id", $id)->update([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "tanggal_jurnal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_transaksi as $ct_request){
                if(isset($ct_request["id"]) && $ct_request["id"] != ""){
                    $coa = Coa::where("id", $ct_request["coa"])->first();
                    $this->summerizeJournal("updatefirst", $ct_request["id"]);
                    Transaction::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "deskripsi"=> $ct_request["deskripsi"],
                        "debet"=> $ct_request["debet"],
                        "credit"=> $ct_request["credit"],
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "anggaran"=> $ct_request["anggaran"],
                        "anggaran_label"=> $ct_request["anggaran_label"],
                        "tanggal"=> $request->tanggal_jurnal,
                        "keterangan"=> $ct_request["keterangan"],
                        "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                        "jenisbayar"=> $ct_request["jenisbayar"],
                        "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                        "nim"=> $ct_request["nim"],
                        "kode_va"=> $ct_request["kode_va"],
                        "fheader"=> $ct_request["fheader"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                    $this->summerizeJournal("updatelast", $ct_request["id"]);
                }else{
                    $coa = Coa::where("id", $ct_request["coa"])->first();
                    $idct = Transaction::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                        "deskripsi"=> $ct_request["deskripsi"],
                        "debet"=> $ct_request["debet"],
                        "credit"=> $ct_request["credit"],
                        "unitkerja"=> $ct_request["unitkerja"],
                        "unitkerja_label"=> $ct_request["unitkerja_label"],
                        "anggaran"=> $ct_request["anggaran"],
                        "anggaran_label"=> $ct_request["anggaran_label"],
                        "tanggal"=> $request->tanggal_jurnal,
                        "keterangan"=> $ct_request["keterangan"],
                        "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                        "coa"=> $ct_request["coa"],
                        "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                        "jenisbayar"=> $ct_request["jenisbayar"],
                        "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                        "nim"=> $ct_request["nim"],
                        "kode_va"=> $ct_request["kode_va"],
                        "fheader"=> $ct_request["fheader"],
                        "no_jurnal"=> $request->no_jurnal,
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                    $this->summerizeJournal("store", $idct);
                }
            }

            $coa = Coa::where("id", $request->bank_kas)->first();
            $this->summerizeJournal("updatefirst", $request->id_bank_kas);
            Transaction::where("id", $request->id_bank_kas)->update([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> $request->jurnal_type=="BKM"?$total_nominal:0,
                "credit"=> $request->jurnal_type=="BKK"?$total_nominal:0,
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $request->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $request->bank_kas,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> 0,
                "jenisbayar_label"=> "",
                "nim"=> "",
                "kode_va"=> "",
                "fheader"=> "",
                "user_creator_id" => Auth::user()->id
            ]);
            $this->summerizeJournal("updatelast", $request->id_bank_kas);

            foreach(Transaction::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_transaksi as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        $this->summerizeJournal("delete", $ch->id);
                        Transaction::whereId($ch->id)->delete();
                    }
                }

            return response()->json([
                'status' => 201,
                'message' => 'No Jurnal '.$request->no_jurnal." telah diupdate",
                'data' => ['id' => $id, 'no_jurnal' => $request->no_jurnal]
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
            $jurnal = Jurnal::whereId($request->id)->first();
            $this->checkOpenPeriode($jurnal->tanggal_jurnal);
            if(!$jurnal){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Jurnal::where("id", $request->id)->whereNull("isdeleted")->update([
                "alasan_hapus" => $request->alasan_hapus,
                "isdeleted" => "on"
            ])){
                Transaction::where("parent_id", $request->id)->whereNull("isdeleted")->update([
                    "alasan_hapus" => $request->alasan_hapus,
                    "isdeleted" => "on"
                ]);
                foreach(Transaction::where("parent_id", $request->id)->get() as $trans){
                    $this->summerizeJournal("delete", $trans->id);
                }
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
    //     $list_column = array("id", "unitkerja_label", "no_jurnal", "tanggal_jurnal", "id");
    //     $keyword = null;
    //     if(isset($request->search["value"])){
    //         $keyword = $request->search["value"];
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
    //     foreach(Jurnal::where(function($q) use ($keyword) {
    //         $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%")->orWhere("tanggal_jurnal", "LIKE", "%" . $keyword. "%");
    //     })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unitkerja_label", "no_jurnal", "tanggal_jurnal"]) as $jurnal){
    //         $no = $no+1;
    //         $act = '
    //         <a href="/jurnal/'.$jurnal->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

    //         <a href="/jurnal/'.$jurnal->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

    //         <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

    //         array_push($dt, array($jurnal->id, $jurnal->unitkerja_label, $jurnal->no_jurnal, $jurnal->tanggal_jurnal, $act));
    // }
    //     $output = array(
    //         "draw" => intval($request->draw),
    //         "recordsTotal" => Jurnal::get()->count(),
    //         "recordsFiltered" => intval(Jurnal::where(function($q) use ($keyword) {
    //             $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%")->orWhere("tanggal_jurnal", "LIKE", "%" . $keyword. "%");
    //         })->orderBy($orders[0], $orders[1])->get()->count()),
    //         "data" => $dt
    //     );

    //     echo json_encode($output);
    // }

    public function get_list(Request $request)
    {
        $list_column = array("id", "keterangan", "no_jurnal", "tanggal_jurnal", "id");
        
        $dt = array();
        $no = 0;
        foreach(Jurnal::where(function($q) use ($request) {
            $q->where("no_jurnal", "LIKE", "%" . $request->no_jurnal_search. "%");
        })->whereNull("isdeleted")->whereBetween("tanggal_jurnal", [$request->tanggal_jurnal_from, $request->tanggal_jurnal_to])->orderBy("no_jurnal", $request->ordering)->get(["id", "keterangan", "no_jurnal", "tanggal_jurnal"]) as $jurnal){
            $no = $no+1;
            $act = '
            <a href="/jurnal/'.$jurnal->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/jurnal/'.$jurnal->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($jurnal->id, $jurnal->tanggal_jurnal, $jurnal->no_jurnal, $jurnal->keterangan, $act));
        }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Jurnal::get()->count(),
            "recordsFiltered" => intval(Jurnal::where(function($q) use ($request) {
                $q->where("no_jurnal", "LIKE", "%" . $request->no_jurnal_search. "%");
            })->whereBetween("tanggal_jurnal", [$request->tanggal_jurnal_from, $request->tanggal_jurnal_to])->orderBy("tanggal_jurnal", "asc")->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_list_bkmk(Request $request)
    {
        $list_column = array("id", "keterangan", "no_jurnal", "tanggal_jurnal", "id");
        
        $dt = array();
        $no = 0;
        foreach(Jurnal::where(function($q) use ($request) {
            $q->where("no_jurnal", "LIKE", "%" . $request->no_jurnal_search. "%");
        })->where("no_jurnal", "LIKE", $request->jurnal_type. "%")->whereNull("isdeleted")->whereBetween("tanggal_jurnal", [$request->tanggal_jurnal_from, $request->tanggal_jurnal_to])->orderBy("no_jurnal", $request->ordering)->get(["id", "keterangan", "no_jurnal", "tanggal_jurnal"]) as $jurnal){
            $no = $no+1;
            $act = '
            <a href="/jurnal/'.$jurnal->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/jurnal/'.$jurnal->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($jurnal->id, $jurnal->tanggal_jurnal, $jurnal->no_jurnal, $jurnal->keterangan, $act));
        }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Jurnal::get()->count(),
            "recordsFiltered" => intval(Jurnal::where(function($q) use ($request) {
                $q->where("no_jurnal", "LIKE", "%" . $request->no_jurnal_search. "%");
            })->whereBetween("tanggal_jurnal", [$request->tanggal_jurnal_from, $request->tanggal_jurnal_to])->orderBy("tanggal_jurnal", "asc")->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $jurnal = Jurnal::whereId($request->id)->first();
            if(!$jurnal){
                abort(404, "Data not found");
            }

            $transaksis = Transaction::whereParentId($request->id)->orderBy("no_seq", "asc")->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "transaksi" => $transaksis,
                    "jurnal" => $jurnal
                ]
            );

            return response()->json($results);
        }
    }

    public function getdata_bkmk(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $jurnal = Jurnal::whereId($request->id)->first();
            if(!$jurnal){
                abort(404, "Data not found");
            }

            $transaksis = Transaction::where("no_jurnal", "LIKE", $request->jurnal_type."%")->whereParentId($request->id)->orderBy("no_seq", "asc")->get();

            $jurnal->bank_kas = $transaksis[count($transaksis)-1]->coa;
            $jurnal->bank_kas_label = $transaksis[count($transaksis)-1]->coa_label;
            $jurnal->id_bank_kas  = $transaksis[count($transaksis)-1]->id;
            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "transaksi" => $transaksis,
                    "jurnal" => $jurnal
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
            }elseif($request->field == "anggaran"){
                $lists = Anggaran::where(function($q) use ($request) {
                    $q->where("anggaran_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("anggaran_name as text")]);
                $count = Anggaran::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%")->orWhere("coa_code", "LIKE", "%" . $request->term. "%");
                })->where("fheader", null)->orderBy("coa_code", "asc")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text"), DB::raw("coa_name as description")]);
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

    public function getcoa(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()){
            $page = $request->page;
            $resultCount = 25;

            $offset = ($page - 1) * $resultCount;

            $lists = null;
            $count = 0;
            if($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%")->orWhere("coa_code", "LIKE", "%" . $request->term. "%");
                })->where("category", "pendapatan")->where("fheader", null)->orderBy("coa_code", "asc")->skip($offset)->take($resultCount)->get(["id", DB::raw("concat(concat(coa_code, ' '), coa_name) as text"), DB::raw("coa_name as description")]);
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

     public function summerizeJournal($method, $id_transaction){
        $transaction = Transaction::where("id", $id_transaction)->first();
        $coa = Coa::where("id", $transaction->coa)->first();
        $bulan = explode("-", $transaction->tanggal)[1];
        $tahun = explode("-", $transaction->tanggal)[0];
        if($method == "store" || $method == "updatelast"){
            $neracasaldo = Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
            if($neracasaldo){
                Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
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
                    "jenisbayar_label" => ""
                ]);
            }

            if(in_array($coa->category, array("pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"))){
                $coa_sur_def = Coa::where("coa_code", "30300000")->first();
                $neraca = Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($neraca){
                    Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
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
                        "user_creator_id" => 2
                    ]);
                }
                $labarugi = Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($labarugi){
                    Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
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
                        "user_creator_id" => 2
                    ]);
                }
            }else{
                $neraca = Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($neraca){
                    Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
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
                        "user_creator_id" => 2
                    ]);
                }
            }
        }elseif($method == "updatefirst" || $method == "delete"){
            $neracasaldo = Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
            if($neracasaldo){
                Neracasaldo::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
                    "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->debet-$transaction->debet+$transaction->credit:0,
                    "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neracasaldo->credit-$transaction->credit+$transaction->debet:0,
                    "user_updater_id" => 2
                ]);
            }

            if(in_array($coa->category, array("pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"))){
                $coa_sur_def = Coa::where("coa_code", "30300000")->first();
                $neraca = Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($neraca){
                    Neraca::where("coa", $coa_sur_def->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
                        "debet" => 0,
                        "credit" => $neraca->credit-$transaction->credit+$transaction->debet,
                        "user_updater_id" => 2
                    ]);
                }
                $labarugi = Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($labarugi){
                    Labarugi::where("coa", $coa->id)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$labarugi->debet-$transaction->debet+$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$labarugi->credit-$transaction->credit+$transaction->debet:0,
                        "user_updater_id" => 2
                    ]);
                }
            }else{
                $neraca = Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->first();
                if($neraca){
                    Neraca::where("coa", $transaction->coa)->where("tahun_periode", $tahun)->where("bulan_periode", $bulan)->update([
                        "debet" => in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->debet-$transaction->debet+$transaction->credit:0,
                        "credit" => !in_array($coa->category, array("aset", "biaya", "biaya_lainnya"))?$neraca->credit-$transaction->credit+$transaction->debet:0,
                        "user_updater_id" => 2
                    ]);
                }
            }
        }
    }

    public function storependapatan(Request $request)
    {
        $tgl = date('Y-m-d');
        $this->checkOpenPeriode($tgl);
        if(!isset($request->clientreff)){
            abort(401, "clientreff harus diisi!");
        }
        $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->first();
        if(!is_null($jr)){
            abort(404, "Reff sudah ada!");
        }
        $bankva = Bankva::where("kode_va", $request->kode_va)->first();
        if(!$bankva){
            abort(404, "Kode Virtual Account tidak dikenali");
        }
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi_pendapatan"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = -1;
        foreach($requests_transaksi as $ct_request){
            $no_seq++;
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            $coa_exist = true;
            foreach($page_data["fieldsmessages_transaksi_pendapatan"] as $key => $value){
                $ct_messages[$key] = "No ".$no_seq." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
            $coa = Coa::where(function($q) use($ct_request){
                if($ct_request["prodi"]){
                    $q->where("prodi", $ct_request["prodi"]);
                }else{
                    $q->whereNull("prodi");
                }
            })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
            if(!$coa){
                $coa_exist = false;
                
            }
            $total_nominal = $total_nominal+$ct_request["nominal"];
        }

        if(!$coa_exist){
            abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Pendapatan manapun");
        }
        if($no_seq < 0){
            abort(404, "Tidak ada data transaksi");
        }

        $rules = $page_data["fieldsrules_pendapatan"];
        $messages = $page_data["fieldsmessages_pendapatan"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            $id = Jurnal::create([
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "no_jurnal"=> "JU########",
                "tanggal_jurnal"=> $tgl,
                "keterangan"=> $request->kode_va." ".$request->nim,
                "apitype" => "apipendapatan",
                "clientreff" => $request->clientreff,
                "user_creator_id"=> 2
            ])->id;

            $no_jurnal = "JU";
            for($i = 0; $i < 7-strlen((string)$id); $i++){
                $no_jurnal .= "0";
            }
            $no_jurnal .= $id;
            Jurnal::where("id", $id)->update([
                "no_jurnal"=> $no_jurnal
            ]);
            
            $no_seq = -1;
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where(function($q) use($ct_request){
                    if($ct_request["prodi"]){
                        $q->where("prodi", $ct_request["prodi"]);
                    }else{
                        $q->whereNull("prodi");
                    }
                })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
                $no_seq++;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $id,
                    "deskripsi"=> "",
                    "debet"=> 0,
                    "credit"=> $ct_request["nominal"],
                    "unitkerja"=> $uk->id,
                    "unitkerja_label"=> $uk->unitkerja_name,
                    "anggaran"=> 0,
                    "anggaran_label"=> "",
                    "tanggal"=> $tgl,
                    "keterangan"=> $request->kode_va." ".$request->nim,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coa->id,
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $coa->jenisbayar,
                    "jenisbayar_label"=> $coa->jenisbayar_label,
                    "nim"=> $request->nim,
                    "kode_va"=> $request->kode_va,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "apitype" => "apipendapatan",
                    "clientreff" => $request->clientreff,
                    "user_creator_id" => 2
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            $coa = Coa::where("id", $bankva->coa)->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> $total_nominal,
                "credit"=> 0,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $tgl,
                "keterangan"=> $request->kode_va." ".$request->nim,
                "jenis_transaksi"=> 0,
                "coa"=> 612,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> $request->nim,
                "kode_va"=> $request->kode_va,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "apipendapatan",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
                'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }

    public function updatependapatan(Request $request)
    {
        if(!isset($request->clientreff)){
            abort(401, "clientreff harus diisi!");
        }
        $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->where("apitype", "apipendapatan")->first();
        if(is_null($jr)){
            abort(404, "Reff yang akan di-update tidak ada!");
        }
        $this->checkOpenPeriode($jr->tanggal_jurnal);
        
        $bankva = Bankva::where("kode_va", $request->kode_va)->first();
        if(!$bankva){
            abort(404, "Kode Virtual Account tidak dikenali");
        }
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi_pendapatan"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = -1;
        $rules = $page_data["fieldsrules_pendapatan"];
        $messages = $page_data["fieldsmessages_pendapatan"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            Jurnal::where("id", $jr->id)->update([
                "keterangan"=> $request->kode_va." ".$request->nim,
                "user_updater_id"=> 2
            ]);

            foreach($requests_transaksi as $ct_request){
                $no_seq++;
                $child_tb_request = new \Illuminate\Http\Request();
                $child_tb_request->replace($ct_request);
                $ct_messages = array();
                $coa_exist = true;
                foreach($page_data["fieldsmessages_transaksi_pendapatan"] as $key => $value){
                    $ct_messages[$key] = "No ".$no_seq." ".$value;
                }
                $child_tb_request->validate($rules_transaksi, $ct_messages);
                $coa = Coa::where(function($q) use($ct_request){
                    if($ct_request["prodi"]){
                        $q->where("prodi", $ct_request["prodi"]);
                    }else{
                        $q->whereNull("prodi");
                    }
                })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
                if(!$coa){
                    $coa_exist = false;
                    
                }
                $total_nominal = $total_nominal+$ct_request["nominal"];
            }

            if(!$coa_exist){
                abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Pendapatan manapun");
            }
            if($no_seq < 0){
                abort(404, "Tidak ada data transaksi");
            }

            foreach(Transaction::whereParentId($jr->id)->get() as $ch){       
                $this->summerizeJournal("delete", $ch->id);
                Transaction::whereId($ch->id)->delete();
            }
            
            $no_jurnal = $jr->no_jurnal;
            
            $no_seq = -1;
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where(function($q) use($ct_request){
                    if($ct_request["prodi"]){
                        $q->where("prodi", $ct_request["prodi"]);
                    }else{
                        $q->whereNull("prodi");
                    }
                })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
                $no_seq++;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $jr->id,
                    "deskripsi"=> "",
                    "debet"=> 0,
                    "credit"=> $ct_request["nominal"],
                    "unitkerja"=> $uk->id,
                    "unitkerja_label"=> $uk->unitkerja_name,
                    "anggaran"=> 0,
                    "anggaran_label"=> "",
                    "tanggal"=> $jr->tanggal_jurnal,
                    "keterangan"=> $request->kode_va." ".$request->nim,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coa->id,
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $coa->jenisbayar,
                    "jenisbayar_label"=> $coa->jenisbayar_label,
                    "nim"=> $request->nim,
                    "kode_va"=> $request->kode_va,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "apitype" => "apipendapatan",
                    "clientreff" => $request->clientreff,
                    "user_creator_id" => 2
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            $coa = Coa::where("id", $bankva->coa)->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $jr->id,
                "deskripsi"=> "",
                "debet"=> $total_nominal,
                "credit"=> 0,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $jr->tanggal_jurnal,
                "keterangan"=> $request->kode_va." ".$request->nim,
                "jenis_transaksi"=> 0,
                "coa"=> 612,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> $request->nim,
                "kode_va"=> $request->kode_va,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "apipendapatan",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'No Jurnal '.$no_jurnal." telah diupdate",
                'data' => ['id' => $jr->id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }

    // public function storepencairandana(Request $request)
    // {
    //     $tgl = date('Y-m-d');
    //     $this->checkOpenPeriode($tgl);
    //     if(!isset($request->clientreff)){
    //         abort(401, "clientreff harus diisi!");
    //     }
    //     $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->first();
    //     if(!is_null($jr)){
    //         abort(404, "Reff sudah ada!");
    //     }
    //     $bankva = Bankva::where("kode_jenisbayar", $request->kode_bank)->first();
    //     if(!$bankva){
    //         abort(404, "Kode Virtual Account tidak dikenali");
    //     }
    //     $page_data = $this->tabledesign();
    //     $rules_transaksi = $page_data["fieldsrules_transaksi_pendapatan"];
    //     $requests_transaksi = json_decode($request->transaksi, true);
    //     $total_nominal = 0;
    //     $no_seq = -1;
    //     foreach($requests_transaksi as $ct_request){
    //         $no_seq++;
    //         $child_tb_request = new \Illuminate\Http\Request();
    //         $child_tb_request->replace($ct_request);
    //         $ct_messages = array();
    //         $coa_exist = true;
    //         foreach($page_data["fieldsmessages_transaksi_pendapatan"] as $key => $value){
    //             $ct_messages[$key] = "No ".$no_seq." ".$value;
    //         }
    //         $child_tb_request->validate($rules_transaksi, $ct_messages);
    //         $coa = Coa::where(function($q) use($ct_request){
    //             if($ct_request["prodi"]){
    //                 $q->where("prodi", $ct_request["prodi"]);
    //             }else{
    //                 $q->whereNull("prodi");
    //             }
    //         })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
    //         if(!$coa){
    //             $coa_exist = false;
                
    //         }
    //         $total_nominal = $total_nominal+$ct_request["nominal"];
    //     }

    //     if(!$coa_exist){
    //         abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Pendapatan manapun");
    //     }
    //     if($no_seq < 0){
    //         abort(404, "Tidak ada data transaksi");
    //     }

    //     $rules = $page_data["fieldsrules_pendapatan"];
    //     $messages = $page_data["fieldsmessages_pendapatan"];
    //     $uk = Unitkerja::where("unitkerja_code", "01")->first();
    //     if($request->validate($rules, $messages)){
    //         $id = Jurnal::create([
    //             "unitkerja"=> $uk->id,
    //             "unitkerja_label"=> $uk->unitkerja_name,
    //             "no_jurnal"=> "JU########",
    //             "tanggal_jurnal"=> $tgl,
    //             "keterangan"=> $request->kode_va." ".$request->nim,
    //             "apitype" => "pencairandana",
    //             "clientreff" => $request->clientreff,
    //             "user_creator_id"=> 2
    //         ])->id;

    //         $no_jurnal = "JU";
    //         for($i = 0; $i < 7-strlen((string)$id); $i++){
    //             $no_jurnal .= "0";
    //         }
    //         $no_jurnal .= $id;
    //         Jurnal::where("id", $id)->update([
    //             "no_jurnal"=> $no_jurnal
    //         ]);
            
    //         $no_seq = -1;
    //         foreach($requests_transaksi as $ct_request){
    //             $coa = Coa::where(function($q) use($ct_request){
    //                 if($ct_request["prodi"]){
    //                     $q->where("prodi", $ct_request["prodi"]);
    //                 }else{
    //                     $q->whereNull("prodi");
    //                 }
    //             })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
    //             $no_seq++;
    //             $idct = Transaction::create([
    //                 "no_seq" => $no_seq,
    //                 "parent_id" => $id,
    //                 "deskripsi"=> "",
    //                 "debet"=> 0,
    //                 "credit"=> $ct_request["nominal"],
    //                 "unitkerja"=> $uk->id,
    //                 "unitkerja_label"=> $uk->unitkerja_name,
    //                 "anggaran"=> 0,
    //                 "anggaran_label"=> "",
    //                 "tanggal"=> $tgl,
    //                 "keterangan"=> $request->kode_va." ".$request->nim,
    //                 "jenis_transaksi"=> 0,
    //                 "coa"=> $coa->id,
    //                 "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
    //                 "jenisbayar"=> $coa->jenisbayar,
    //                 "jenisbayar_label"=> $coa->jenisbayar_label,
    //                 "nim"=> $request->nim,
    //                 "kode_va"=> $request->kode_va,
    //                 "fheader"=> null,
    //                 "no_jurnal"=> $no_jurnal,
    //                 "apitype" => "pencairandana",
    //                 "clientreff" => $request->clientreff,
    //                 "user_creator_id" => 2
    //             ])->id;
    //             $this->summerizeJournal("store", $idct);
    //         }

    //         $coa = Coa::where("id", $bankva->coa)->first();
    //         $no_seq++;
    //         $idct = Transaction::create([
    //             "no_seq" => $no_seq,
    //             "parent_id" => $id,
    //             "deskripsi"=> "",
    //             "debet"=> $total_nominal,
    //             "credit"=> 0,
    //             "unitkerja"=> $uk->id,
    //             "unitkerja_label"=> $uk->unitkerja_name,
    //             "anggaran"=> 0,
    //             "anggaran_label"=> "",
    //             "tanggal"=> $tgl,
    //             "keterangan"=> $request->kode_va." ".$request->nim,
    //             "jenis_transaksi"=> 0,
    //             "coa"=> 612,
    //             "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
    //             "jenisbayar"=> $coa->jenisbayar,
    //             "jenisbayar_label"=> $coa->jenisbayar_label,
    //             "nim"=> $request->nim,
    //             "kode_va"=> $request->kode_va,
    //             "fheader"=> null,
    //             "no_jurnal"=> $no_jurnal,
    //             "apitype" => "pencairandana",
    //             "clientreff" => $request->clientreff,
    //             "user_creator_id" => 2
    //         ])->id;
    //         $this->summerizeJournal("store", $idct);

    //         return response()->json([
    //             'status' => 201,
    //             'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
    //             'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
    //         ]);
    //     }
    // }

    // public function updatepencairandana(Request $request)
    // {
    //     if(!isset($request->clientreff)){
    //         abort(401, "clientreff harus diisi!");
    //     }
    //     $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->where("apitype", "pencairandana")->first();
    //     if(is_null($jr)){
    //         abort(404, "Reff yang akan di-update tidak ada!");
    //     }
    //     $this->checkOpenPeriode($jr->tanggal_jurnal);
        
    //     $bankva = Bankva::where("kode_va", $request->kode_va)->first();
    //     if(!$bankva){
    //         abort(404, "Kode Virtual Account tidak dikenali");
    //     }
    //     $page_data = $this->tabledesign();
    //     $rules_transaksi = $page_data["fieldsrules_transaksi_pendapatan"];
    //     $requests_transaksi = json_decode($request->transaksi, true);
    //     $total_nominal = 0;
    //     $no_seq = -1;
    //     $rules = $page_data["fieldsrules_pendapatan"];
    //     $messages = $page_data["fieldsmessages_pendapatan"];
    //     $uk = Unitkerja::where("unitkerja_code", "01")->first();
    //     if($request->validate($rules, $messages)){
    //         Jurnal::where("id", $jr->id)->update([
    //             "keterangan"=> $request->kode_va." ".$request->nim,
    //             "user_updater_id"=> 2
    //         ]);

    //         foreach($requests_transaksi as $ct_request){
    //             $no_seq++;
    //             $child_tb_request = new \Illuminate\Http\Request();
    //             $child_tb_request->replace($ct_request);
    //             $ct_messages = array();
    //             $coa_exist = true;
    //             foreach($page_data["fieldsmessages_transaksi_pendapatan"] as $key => $value){
    //                 $ct_messages[$key] = "No ".$no_seq." ".$value;
    //             }
    //             $child_tb_request->validate($rules_transaksi, $ct_messages);
    //             $coa = Coa::where(function($q) use($ct_request){
    //                 if($ct_request["prodi"]){
    //                     $q->where("prodi", $ct_request["prodi"]);
    //                 }else{
    //                     $q->whereNull("prodi");
    //                 }
    //             })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
    //             if(!$coa){
    //                 $coa_exist = false;
                    
    //             }
    //             $total_nominal = $total_nominal+$ct_request["nominal"];
    //         }

    //         if(!$coa_exist){
    //             abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Pendapatan manapun");
    //         }
    //         if($no_seq < 0){
    //             abort(404, "Tidak ada data transaksi");
    //         }

    //         foreach(Transaction::whereParentId($jr->id)->get() as $ch){       
    //             $this->summerizeJournal("delete", $ch->id);
    //             Transaction::whereId($ch->id)->delete();
    //         }
            
    //         $no_jurnal = $jr->no_jurnal;
            
    //         $no_seq = -1;
    //         foreach($requests_transaksi as $ct_request){
    //             $coa = Coa::where(function($q) use($ct_request){
    //                 if($ct_request["prodi"]){
    //                     $q->where("prodi", $ct_request["prodi"]);
    //                 }else{
    //                     $q->whereNull("prodi");
    //                 }
    //             })->where("kode_jenisbayar", $ct_request["jenisbayar"])->first();
    //             $no_seq++;
    //             $idct = Transaction::create([
    //                 "no_seq" => $no_seq,
    //                 "parent_id" => $jr->id,
    //                 "deskripsi"=> "",
    //                 "debet"=> 0,
    //                 "credit"=> $ct_request["nominal"],
    //                 "unitkerja"=> $uk->id,
    //                 "unitkerja_label"=> $uk->unitkerja_name,
    //                 "anggaran"=> 0,
    //                 "anggaran_label"=> "",
    //                 "tanggal"=> $jr->tanggal_jurnal,
    //                 "keterangan"=> $request->kode_va." ".$request->nim,
    //                 "jenis_transaksi"=> 0,
    //                 "coa"=> $coa->id,
    //                 "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
    //                 "jenisbayar"=> $coa->jenisbayar,
    //                 "jenisbayar_label"=> $coa->jenisbayar_label,
    //                 "nim"=> $request->nim,
    //                 "kode_va"=> $request->kode_va,
    //                 "fheader"=> null,
    //                 "no_jurnal"=> $no_jurnal,
    //                 "apitype" => "pencairandana",
    //                 "clientreff" => $request->clientreff,
    //                 "user_creator_id" => 2
    //             ])->id;
    //             $this->summerizeJournal("store", $idct);
    //         }

    //         $coa = Coa::where("id", $bankva->coa)->first();
    //         $no_seq++;
    //         $idct = Transaction::create([
    //             "no_seq" => $no_seq,
    //             "parent_id" => $jr->id,
    //             "deskripsi"=> "",
    //             "debet"=> $total_nominal,
    //             "credit"=> 0,
    //             "unitkerja"=> $uk->id,
    //             "unitkerja_label"=> $uk->unitkerja_name,
    //             "anggaran"=> 0,
    //             "anggaran_label"=> "",
    //             "tanggal"=> $jr->tanggal_jurnal,
    //             "keterangan"=> $request->kode_va." ".$request->nim,
    //             "jenis_transaksi"=> 0,
    //             "coa"=> 612,
    //             "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
    //             "jenisbayar"=> $coa->jenisbayar,
    //             "jenisbayar_label"=> $coa->jenisbayar_label,
    //             "nim"=> $request->nim,
    //             "kode_va"=> $request->kode_va,
    //             "fheader"=> null,
    //             "no_jurnal"=> $no_jurnal,
    //             "apitype" => "pencairandana",
    //             "clientreff" => $request->clientreff,
    //             "user_creator_id" => 2
    //         ])->id;
    //         $this->summerizeJournal("store", $idct);

    //         return response()->json([
    //             'status' => 201,
    //             'message' => 'No Jurnal '.$no_jurnal." telah diupdate",
    //             'data' => ['id' => $jr->id, 'no_jurnal' => $no_jurnal]
    //         ]);
    //     }
    // }

    public function storepencairandana(Request $request)
    {
        //clientreff, kode_bank, keterangan, nominal
        $tgl = date('Y-m-d');
        $this->checkOpenPeriode($tgl);
        $page_data = $this->tabledesign();
       
        $rules = $page_data["fieldsrules_pencairandana"];
        $messages = $page_data["fieldsmessages_pencairandana"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->first();
            if(!is_null($jr)){
                abort(404, "Reff sudah ada!");
            }
            $coa = Coa::where("kode_jenisbayar", $request->kode_bank)->whereNull("fheader")->where("factive", "on")->where("factive", "on")->first();
            if(is_null($coa)){
                abort(404, "Kode Bank tidak cocok dengan COA Pencairan Dana manapun");
            }
            $id = Jurnal::create([
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "no_jurnal"=> "JU########",
                "tanggal_jurnal"=> $tgl,
                "keterangan"=> $request->keterangan,
                "apitype" => "pencairandana",
                "clientreff" => $request->clientreff,
                "user_creator_id"=> 2
            ])->id;

            $no_jurnal = "JU";
            for($i = 0; $i < 7-strlen((string)$id); $i++){
                $no_jurnal .= "0";
            }
            $no_jurnal .= $id;
            Jurnal::where("id", $id)->update([
                "no_jurnal"=> $no_jurnal
            ]);
            
            $no_seq = -1;
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> 0,
                "credit"=> $request->nominal,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $tgl,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $coa->id,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "pencairandana",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            $coa = Coa::where("kode_jenisbayar", "UMBIAYA1")->whereNull("fheader")->where("factive", "on")->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> $request->nominal,
                "credit"=> 0,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $tgl,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $coa->id,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "pencairandana",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
                'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }

    public function updatepencairandana(Request $request)
    {
        if(!isset($request->clientreff)){
            abort(401, "clientreff harus diisi!");
        }
        $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->where("apitype", "pencairandana")->first();
        if(is_null($jr)){
            abort(404, "Reff yang akan di-update tidak ada!");
        }
        $this->checkOpenPeriode($jr->tanggal_jurnal);
        
        $page_data = $this->tabledesign();
       
        $rules = $page_data["fieldsrules_pencairandana"];
        $messages = $page_data["fieldsmessages_pencairandana"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            $coa = Coa::where("kode_jenisbayar", $request->kode_bank)->whereNull("fheader")->where("factive", "on")->first();
            if(is_null($coa)){
                abort(404, "Kode Bank tidak cocok dengan COA Pencairan Dana manapun");
            }
            Jurnal::where("id", $jr->id)->update([
                "keterangan"=> $request->keterangan,
                "user_updater_id"=> 2
            ]);

            foreach(Transaction::whereParentId($jr->id)->get() as $ch){       
                $this->summerizeJournal("delete", $ch->id);
                Transaction::whereId($ch->id)->delete();
            }

            $no_jurnal = $jr->no_jurnal;
            
            $no_seq = -1;
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $jr->id,
                "deskripsi"=> "",
                "debet"=> 0,
                "credit"=> $request->nominal,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $jr->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $coa->id,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "pencairandana",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            $coa = Coa::where("kode_jenisbayar", "UMBIAYA1")->whereNull("fheader")->where("factive", "on")->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $jr->id,
                "deskripsi"=> "",
                "debet"=> $request->nominal,
                "credit"=> 0,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $jr->tanggal_jurnal,
                "keterangan"=> $request->keterangan,
                "jenis_transaksi"=> 0,
                "coa"=> $coa->id,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "pencairandana",
                "clientreff" => $request->clientreff,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'No Jurnal '.$no_jurnal." telah diupdate",
                'data' => ['id' => $jr->id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }


    public function storepjkpencairandana(Request $request)
    {
        //clientreff, clientreff pencairan, transaksi[nominal, jenisbayar]
        $tgl = date('Y-m-d');
        $this->checkOpenPeriode($tgl);
        if(!isset($request->clientreff)){
            abort(401, "clientreff harus diisi!");
        }
        $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->first();
        if(!is_null($jr)){
            abort(404, "Reff sudah ada!");
        }

        $jr_pencairan = Jurnal::where("clientreff", $request->clientreff_pencairan)->whereNull("isdeleted")->where("apitype", "pencairandana")->first();
        if(is_null($jr_pencairan)){
            abort(404, "Reff Pencairan belum ada!");
        }
        
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi_pjkpencairandana"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = -1;
        foreach($requests_transaksi as $ct_request){
            $no_seq++;
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            $coa_exist = true;
            foreach($page_data["fieldsmessages_transaksi_pjkpencairandana"] as $key => $value){
                $ct_messages[$key] = "No ".$no_seq." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
            $coa = Coa::where("kode_jenisbayar", $ct_request["jenisbayar"])->whereNull("fheader")->where("factive", "on")->where("category", "biaya")->first();
            if(!$coa){
                $coa_exist = false;
                
            }
            $total_nominal = $total_nominal+$ct_request["nominal"];
        }

        if(!$coa_exist){
            abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Biaya manapun");
        }
        if($no_seq < 0){
            abort(404, "Tidak ada data transaksi");
        }

        $rules = $page_data["fieldsrules_pjkpencairandana"];
        $messages = $page_data["fieldsmessages_pjkpencairandana"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            $id = Jurnal::create([
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "no_jurnal"=> "JU########",
                "tanggal_jurnal"=> $tgl,
                "keterangan"=> $request->clientreff_pencairan,
                "apitype" => "apipjkpencairandana",
                "clientreff" => $request->clientreff,
                "idjurnalreference" => $jr_pencairan->id,
                "no_jurnalreference" => $jr_pencairan->no_jurnal,
                "user_creator_id"=> 2
            ])->id;

            $no_jurnal = "JU";
            for($i = 0; $i < 7-strlen((string)$id); $i++){
                $no_jurnal .= "0";
            }
            $no_jurnal .= $id;
            Jurnal::where("id", $id)->update([
                "no_jurnal"=> $no_jurnal
            ]);
            
            $no_seq = -1;
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where("kode_jenisbayar", $ct_request["jenisbayar"])->whereNull("fheader")->where("factive", "on")->first();
                $no_seq++;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $id,
                    "deskripsi"=> "",
                    "debet"=> $ct_request["nominal"],
                    "credit"=> 0,
                    "unitkerja"=> $uk->id,
                    "unitkerja_label"=> $uk->unitkerja_name,
                    "anggaran"=> 0,
                    "anggaran_label"=> "",
                    "tanggal"=> $tgl,
                    "keterangan"=> $request->clientreff_pencairan,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coa->id,
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $coa->jenisbayar,
                    "jenisbayar_label"=> $coa->jenisbayar_label,
                    "nim"=> null,
                    "kode_va"=> null,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "apitype" => "apipjkpencairandana",
                    "clientreff" => $request->clientreff,
                    "idjurnalreference" => $jr_pencairan->id,
                    "no_jurnalreference" => $jr_pencairan->no_jurnal,
                    "user_creator_id" => 2
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            $coa = Coa::where("kode_jenisbayar", "UMBIAYA1")->whereNull("fheader")->where("factive", "on")->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $id,
                "deskripsi"=> "",
                "debet"=> 0,
                "credit"=> $total_nominal,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $tgl,
                "keterangan"=> $request->clientreff_pencairan,
                "jenis_transaksi"=> 0,
                "coa"=> 612,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "apipjkpencairandana",
                "clientreff" => $request->clientreff,
                "idjurnalreference" => $jr_pencairan->id,
                "no_jurnalreference" => $jr_pencairan->no_jurnal,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'Buat Jurnal Berhasil '.$no_jurnal,
                'data' => ['id' => $id, 'no_jurnal' => $no_jurnal]
            ]);
        }
    }

    public function updatepjkpencairandana(Request $request)
    {
        if(!isset($request->clientreff)){
            abort(401, "clientreff harus diisi!");
        }
        $jr = Jurnal::where("clientreff", $request->clientreff)->whereNull("isdeleted")->first();
        if(is_null($jr)){
            abort(404, "Reff belum ada!");
        }
        $this->checkOpenPeriode($jr->tanggal_jurnal);
        $jr_pencairan = Jurnal::where("clientreff", $request->clientreff_pencairan)->whereNull("isdeleted")->where("apitype", "pencairandana")->first();
        if(is_null($jr_pencairan)){
            abort(404, "Reff Pencairan belum ada!");
        }
        
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi_pjkpencairandana"];
        $requests_transaksi = json_decode($request->transaksi, true);
        $total_nominal = 0;
        $no_seq = -1;
        foreach($requests_transaksi as $ct_request){
            $no_seq++;
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            $coa_exist = true;
            foreach($page_data["fieldsmessages_transaksi_pjkpencairandana"] as $key => $value){
                $ct_messages[$key] = "No ".$no_seq." ".$value;
            }
            $child_tb_request->validate($rules_transaksi, $ct_messages);
            $coa = Coa::where("kode_jenisbayar", $ct_request["jenisbayar"])->whereNull("fheader")->where("factive", "on")->where("category", "biaya")->first();
            if(!$coa){
                $coa_exist = false;
                
            }
            $total_nominal = $total_nominal+$ct_request["nominal"];
        }

        if(!$coa_exist){
            abort(404, "Prodi dan Jenis bayar tidak cocok dengan COA Biaya manapun");
        }
        if($no_seq < 0){
            abort(404, "Tidak ada data transaksi");
        }

        $rules = $page_data["fieldsrules_pjkpencairandana"];
        $messages = $page_data["fieldsmessages_pjkpencairandana"];
        $uk = Unitkerja::where("unitkerja_code", "01")->first();
        if($request->validate($rules, $messages)){
            Jurnal::where("id", $jr->id)->update([
                "user_updater_id"=> 2,
            ]);

            foreach(Transaction::whereParentId($jr->id)->get() as $ch){       
                $this->summerizeJournal("delete", $ch->id);
                Transaction::whereId($ch->id)->delete();
            }

            $no_jurnal = $jr->no_jurnal;
            
            $no_seq = -1;
            foreach($requests_transaksi as $ct_request){
                $coa = Coa::where("kode_jenisbayar", $ct_request["jenisbayar"])->whereNull("fheader")->where("factive", "on")->first();
                $no_seq++;
                $idct = Transaction::create([
                    "no_seq" => $no_seq,
                    "parent_id" => $jr->id,
                    "deskripsi"=> "",
                    "debet"=> $ct_request["nominal"],
                    "credit"=> 0,
                    "unitkerja"=> $uk->id,
                    "unitkerja_label"=> $uk->unitkerja_name,
                    "anggaran"=> 0,
                    "anggaran_label"=> "",
                    "tanggal"=> $jr->tanggal_jurnal,
                    "keterangan"=> $request->clientreff_pencairan,
                    "jenis_transaksi"=> 0,
                    "coa"=> $coa->id,
                    "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                    "jenisbayar"=> $coa->jenisbayar,
                    "jenisbayar_label"=> $coa->jenisbayar_label,
                    "nim"=> null,
                    "kode_va"=> null,
                    "fheader"=> null,
                    "no_jurnal"=> $no_jurnal,
                    "apitype" => "apipjkpencairandana",
                    "clientreff" => $request->clientreff,
                    "idjurnalreference" => $jr_pencairan->id,
                    "no_jurnalreference" => $jr_pencairan->no_jurnal,
                    "user_creator_id" => 2
                ])->id;
                $this->summerizeJournal("store", $idct);
            }

            $coa = Coa::where("kode_jenisbayar", "UMBIAYA1")->whereNull("fheader")->where("factive", "on")->first();
            $no_seq++;
            $idct = Transaction::create([
                "no_seq" => $no_seq,
                "parent_id" => $jr->id,
                "deskripsi"=> "",
                "debet"=> 0,
                "credit"=> $total_nominal,
                "unitkerja"=> $uk->id,
                "unitkerja_label"=> $uk->unitkerja_name,
                "anggaran"=> 0,
                "anggaran_label"=> "",
                "tanggal"=> $jr->tanggal_jurnal,
                "keterangan"=> $request->clientreff_pencairan,
                "jenis_transaksi"=> 0,
                "coa"=> 612,
                "coa_label"=> $this->convertCode($coa->coa_code)." ".$coa->coa_name,
                "jenisbayar"=> $coa->jenisbayar,
                "jenisbayar_label"=> $coa->jenisbayar_label,
                "nim"=> null,
                "kode_va"=> null,
                "fheader"=> null,
                "no_jurnal"=> $no_jurnal,
                "apitype" => "apipjkpencairandana",
                "clientreff" => $request->clientreff,
                "idjurnalreference" => $jr_pencairan->id,
                "no_jurnalreference" => $jr_pencairan->no_jurnal,
                "user_creator_id" => 2
            ])->id;
            $this->summerizeJournal("store", $idct);

            return response()->json([
                'status' => 201,
                'message' => 'No Jurnal '.$no_jurnal." telah diupdate",
                'data' => ['id' => $jr->id, 'no_jurnal' => $no_jurnal]
            ]);
        }
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