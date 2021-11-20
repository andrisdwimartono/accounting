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

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
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
                Transaction::create([
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
                ]);
            }

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
        $page_data = $this->tabledesign();
        $rules_transaksi = $page_data["fieldsrules_transaksi"];
        //$requests_transaksi = json_decode('[{"no_seq":0,"unitkerja":"2","unitkerja_label":"Kemahasiswaan","anggaran":0,"anggaran_label":"","no_jurnal":"","tanggal":"2021-11-15","keterangan":"","jenis_transaksi":"","coa":"613","coa_label":"1-01-02-001 Bank BSI Universitas", "deskripsi":"aa","jenisbayar":0,"jenisbayar_label":"","nim":"","kode_va":"","fheader":"","debet":1000,"credit":0,"id":"28"},{"no_seq":1,"unitkerja":"2","unitkerja_label":"Kemahasiswaan","anggaran":0,"anggaran_label":"","no_jurnal":"","tanggal":"2021-11-15","keterangan":"","jenis_transaksi":"","coa":"621","coa_label":"1-01-04-002 Piutang Amal Usaha Muhammadiyah (AUM)","deskripsi":"bb","jenisbayar":0,"jenisbayar_label":"","nim":"","kode_va":"","fheader":"","debet":0,"credit":2000,"id":"29"},{"no_seq":2,"unitkerja":"2","unitkerja_label":"Kemahasiswaan","anggaran":0,"anggaran_label":"","no_jurnal":"","tanggal":"2021-11-15","keterangan":"","jenis_transaksi":"","coa":"630","coa_label":"1-02-04-001 Meja ","deskripsi":"ccc","jenisbayar":0,"jenisbayar_label":"","nim":"","kode_va":"","fheader":"","debet":0,"credit":5000,"id":"30"},{"no_seq":3,"unitkerja":"2","unitkerja_label":"Kemahasiswaan","anggaran":0,"anggaran_label":"","no_jurnal":"","tanggal":"2021-11-15","keterangan":"","jenis_transaksi":"","coa":"645","coa_label":"4-01-04-001 Perusahaan A","deskripsi":"dd","jenisbayar":0,"jenisbayar_label":"","nim":"","kode_va":"","fheader":"","debet":4000,"credit":0,"id":"31"},{"no_seq":4,"unitkerja":"2","unitkerja_label":"Kemahasiswaan","anggaran":0,"anggaran_label":"","no_jurnal":"","tanggal":"2021-11-15","keterangan":"","jenis_transaksi":"","coa":"613","coa_label":"1-01-02-003 Bank BNI","deskripsi":"ee","jenisbayar":0,"jenisbayar_label":"","nim":"","kode_va":"","fheader":"","debet":2000,"credit":0,"id":"32"}]', true);
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
            if(!$jurnal){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Jurnal::where("id", $request->id)->update([
                "alasan_hapus" => $request->alasan_hapus,
                "isdeleted" => "on"
            ])){
                Transaction::where("parent_id", $request->id)->update([
                    "alasan_hapus" => $request->alasan_hapus,
                    "isdeleted" => "on"
                ]);
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
}