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
            "tanggal_jurnal" => "required|date_format:d/m/Y",
            "keterangan" => "max:255",
            "transaksi" => "required"
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
            "anggaran" => "exists:anggarans,id",
            "tanggal" => "required",
            "coa" => "required|exists:coas,id",
            "jenisbayar" => "exists:jenisbayars,id"
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
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
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
                "tanggal_jurnal"=> $request->tanggal_jurnal?\Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_jurnal)->format('Y-m-d'):null,
                "keterangan"=> $request->keterangan,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_transaksi as $ct_request){
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
                    "tanggal"=> $ct_request["tanggal"]?\Carbon\Carbon::createFromFormat('', $ct_request["tanggal"])->format('Y-m-d'):null,
                    "keterangan"=> $ct_request["keterangan"],
                    "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "jenisbayar"=> $ct_request["jenisbayar"],
                    "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                    "nim"=> $ct_request["nim"],
                    "kode_va"=> $ct_request["kode_va"],
                    "fheader"=> $ct_request["fheader"],
                    "no_jurnal"=> $ct_request["no_jurnal"],
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
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
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
                "no_jurnal"=> $request->no_jurnal,
                "tanggal_jurnal"=> $request->tanggal_jurnal?\Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal_jurnal)->format('Y-m-d'):null,
                "keterangan"=> $request->keterangan,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_transaksi as $ct_request){
                if(isset($ct_request["id"])){
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
                    "tanggal"=> $ct_request["tanggal"]?\Carbon\Carbon::createFromFormat('', $ct_request["tanggal"])->format('Y-m-d'):null,
                    "keterangan"=> $ct_request["keterangan"],
                    "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "jenisbayar"=> $ct_request["jenisbayar"],
                    "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                    "nim"=> $ct_request["nim"],
                    "kode_va"=> $ct_request["kode_va"],
                    "fheader"=> $ct_request["fheader"],
                    "no_jurnal"=> $ct_request["no_jurnal"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
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
                    "tanggal"=> $ct_request["tanggal"]?\Carbon\Carbon::createFromFormat('', $ct_request["tanggal"])->format('Y-m-d'):null,
                    "keterangan"=> $ct_request["keterangan"],
                    "jenis_transaksi"=> $ct_request["jenis_transaksi"],
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "jenisbayar"=> $ct_request["jenisbayar"],
                    "jenisbayar_label"=> $ct_request["jenisbayar_label"],
                    "nim"=> $ct_request["nim"],
                    "kode_va"=> $ct_request["kode_va"],
                    "fheader"=> $ct_request["fheader"],
                    "no_jurnal"=> $ct_request["no_jurnal"],
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
            $jurnal = Jurnal::whereId($request->id)->first();
            if(!$jurnal){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Jurnal::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "unitkerja_label", "no_jurnal", "tanggal_jurnal", "id");
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
        foreach(Jurnal::where(function($q) use ($keyword) {
            $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%")->orWhere("tanggal_jurnal", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unitkerja_label", "no_jurnal", "tanggal_jurnal"]) as $jurnal){
            $no = $no+1;
            $act = '
            <a href="/jurnal/'.$jurnal->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/jurnal/'.$jurnal->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($jurnal->id, $jurnal->unitkerja_label, $jurnal->no_jurnal, $jurnal->tanggal_jurnal, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Jurnal::get()->count(),
            "recordsFiltered" => intval(Jurnal::where(function($q) use ($keyword) {
                $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("no_jurnal", "LIKE", "%" . $keyword. "%")->orWhere("tanggal_jurnal", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
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

            $jurnal->tanggal_jurnal = \Carbon\Carbon::createFromFormat('Y-m-d', $jurnal->tanggal_jurnal)->format('d/m/Y');
            $transaksis = Transaction::whereParentId($request->id)->get();
            foreach($transaksis as $transaksi){
                if(isset($transaksi->tanggal)){
                    $transaksi->tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $transaksi->tanggal)->format('');
                }
            }

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
            }elseif($request->field == "unitkerja"){
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
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("coa_name as text")]);
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
}