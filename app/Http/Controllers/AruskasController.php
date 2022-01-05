<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Aruskas;
use App\Models\Coa;
use App\Models\Unitkerja;
use App\Models\Jenisbayar;
use App\Models\Globalsetting;
use PDF;

class AruskasController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Arus Kas",
            "page_data_urlname" => "aruskas",
            "fields" => [
                "tahun_periode" => "integer",
                "bulan_periode" => "integer",
                "coa" => "link",
                "jenisbayar" => "link",
                "fheader" => "checkbox",
                "debet" => "float",
                "credit" => "float"
            ],
            "fieldschildtable" => [
            ],
            "fieldlink" => [
                "coa" => "coas",
                "jenisbayar" => "jenisbayars"
            ],
            "fieldsoptions" => [
                "jenis_aktivitas" => [
                    ["name" => "Aktivitas Operasi", "label" => "Aktivitas Operasi"],
                    ["name" => "Aktivitas Pendanaan", "label" => "Aktivitas Pendanaan"],
                    ["name" => "Aktivitas Investasi", "label" => "Aktivitas Investasi"]
                ]
            ],
        ];
        
        $td["fieldsrules"] = [
            "tahun_periode" => "required|integer",
            "bulan_periode" => "required|integer",
            "coa" => "required|exists:coas,id",
            "jenisbayar" => "required|exists:jenisbayars,id",
            "fheader" => "required",
            "debet" => "required|numeric",
            "credit" => "required|numeric",
            "jenis_aktivitas" => "in:Aktivitas Operasi,Aktivitas Pendanaan,Aktivitas Investasi"
        ];

        $td["fieldsmessages"] = [
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
        $page_data["footer_js_page_specific_script"] = ["aruskas.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["aruskas.page_specific_script.header_js_list"];
        
        return view("aruskas.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["aruskas.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("aruskas.create", ["page_data" => $page_data]);
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
        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            $id = Aruskas::create([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "jenisbayar"=> $request->jenisbayar,
                "jenisbayar_label"=> $request->jenisbayar_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "debet"=> $request->debet,
                "credit"=> $request->credit,
                "user_creator_id"=> Auth::user()->id
            ])->id;

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
    public function show(Aruskas $aruskas)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["aruskas.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $aruskas->id;
        return view("aruskas.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Aruskas $aruskas)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["aruskas.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $aruskas->id;
        return view("aruskas.create", ["page_data" => $page_data]);
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
        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Aruskas::where("id", $id)->update([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "jenisbayar"=> $request->jenisbayar,
                "jenisbayar_label"=> $request->jenisbayar_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "debet"=> $request->debet,
                "credit"=> $request->credit,
                "user_updater_id"=> Auth::user()->id
            ]);

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
            $aruskas = Aruskas::whereId($request->id)->first();
            if(!$aruskas){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Aruskas::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }
        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
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
        $yearopen = Globalsetting::where("id", 1)->first();
        
        $jenis_aktivitas = "";
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.category", "coas.coa", DB::raw("2 as level_coa"), "coas.fheader", DB::raw("SUM(aruskass.debet) as debet"), DB::raw("SUM(aruskass.credit) as credit"), "coas.jenis_aktivitas"])
        ->leftJoin('aruskass', 'coas.id', '=', 'aruskass.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("aruskass.debet","!=",0)->orWhere("aruskass.credit","!=",0);
            });
        })
        ->where(function($q){
            $q->where(function($q){
                $q->whereNotNull("coas.jenis_aktivitas")->orWhere("coas.jenis_aktivitas","!=","");
            });
        })->whereNull("coas.fheader")
        ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("aruskass.unitkerja", $unitkerja);
            }
        })
        ->where("bulan_periode",  $bulan_periode)->where("tahun_periode", $tahun_periode)
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", "coas.jenis_aktivitas"])
        ->orderBy("coas.jenis_aktivitas", "asc")
        ->orderBy("coas.id", "asc")
          ->get() as $aruskas){
            if($jenis_aktivitas != $aruskas->jenis_aktivitas){
                array_push($dt, array(0, "", $aruskas->jenis_aktivitas, "", "", 0, 1, "on", $aruskas->jenis_aktivitas));
                $jenis_aktivitas = $aruskas->jenis_aktivitas;
            }
            
            $coa_name_debet = "";
            $coa_name_credit = "";
            if(in_array($aruskas->category, array("aset", "biaya", "biaya_lainnya"))){
                if(in_array($aruskas->category, array("aset"))){
                    $coa_name_debet = "Penerimaan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengeluaran ".$aruskas->coa_name;
                }else{
                    $coa_name_debet = "Penambahan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengurangan ".$aruskas->coa_name;
                }
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
            }else{
                $coa_name_debet = "Pengurangan ".$aruskas->coa_name;
                $coa_name_credit = "Penambahan ".$aruskas->coa_name;
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                }
            }
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function get_saldo_awal(Request $request)
    {
        $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }
        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
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
        $yearopen = Globalsetting::where("id", 1)->first();
        
        $nominal_saldo_awal = 0;
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.category", "coas.coa", DB::raw("2 as level_coa"), "coas.fheader", DB::raw("SUM(aruskass.debet) as debet"), DB::raw("SUM(aruskass.credit) as credit"), "coas.jenis_aktivitas"])
        ->leftJoin('aruskass', 'coas.id', '=', 'aruskass.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("aruskass.debet","!=",0)->orWhere("aruskass.credit","!=",0);
            });
        })
        ->where(function($q){
            $q->where(function($q){
                $q->whereNotNull("coas.jenis_aktivitas")->orWhere("coas.jenis_aktivitas","!=","");
            });
        })->whereNull("coas.fheader")
        ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("aruskass.unitkerja", $unitkerja);
            }
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", "coas.jenis_aktivitas"])
        ->orderBy("coas.jenis_aktivitas", "asc")
        ->orderBy("coas.id", "asc")
        ->get() as $aruskas){
            if(in_array($aruskas->category, array("aset", "biaya", "biaya_lainnya"))){
                if($aruskas->debet != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+$aruskas->debet;
                }
                if($aruskas->credit != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->credit*(-1));
                }
            }else{
                if($aruskas->debet != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->debet*(-1));
                }
                if($aruskas->credit != 0){
                    $nominal_saldo_awal = $nominal_saldo_awal+($aruskas->credit*(-1));
                }
            }
        }

        echo json_encode($nominal_saldo_awal);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $aruskas = Aruskas::whereId($request->id)->first();
            if(!$aruskas){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "aruskas" => $aruskas
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
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%")->orWhere("unitkerja_code", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
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

    public function print(Request $request){

        $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }
        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
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
        $yearopen = Globalsetting::where("id", 1)->first();
        
        $jenis_aktivitas = "";
        $total = 0;
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.category", "coas.coa", DB::raw("2 as level_coa"), "coas.fheader", DB::raw("SUM(aruskass.debet) as debet"), DB::raw("SUM(aruskass.credit) as credit"), "coas.jenis_aktivitas"])
        ->leftJoin('aruskass', 'coas.id', '=', 'aruskass.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("aruskass.debet","!=",0)->orWhere("aruskass.credit","!=",0);
            });
        })
        ->where(function($q){
            $q->where(function($q){
                $q->whereNotNull("coas.jenis_aktivitas")->orWhere("coas.jenis_aktivitas","!=","");
            });
        })->whereNull("coas.fheader")
        ->where(function($q) use ($unitkerja){
            if($unitkerja != null && $unitkerja != 0){
                $q->where("aruskass.unitkerja", $unitkerja);
            }
        })
        ->where("bulan_periode",  $bulan_periode)->where("tahun_periode", $tahun_periode)
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", "coas.jenis_aktivitas"])
        ->orderBy("coas.jenis_aktivitas", "asc")
        ->orderBy("coas.id", "asc")
          ->get() as $aruskas){
            if($jenis_aktivitas != $aruskas->jenis_aktivitas){
                array_push($dt, array(0, "", $aruskas->jenis_aktivitas, "", "", 0, 1, "on", $aruskas->jenis_aktivitas));
                $jenis_aktivitas = $aruskas->jenis_aktivitas;
            }
            
            $coa_name_debet = "";
            $coa_name_credit = "";
            if(in_array($aruskas->category, array("aset", "biaya", "biaya_lainnya"))){
                if(in_array($aruskas->category, array("aset"))){
                    $coa_name_debet = "Penerimaan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengeluaran ".$aruskas->coa_name;
                }else{
                    $coa_name_debet = "Penambahan ".$aruskas->coa_name;
                    $coa_name_credit = "Pengurangan ".$aruskas->coa_name;
                }
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                    $total = $total+$aruskas->debet;
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                    $total = $total+$aruskas->credit*(-1);
                }
            }else{
                $coa_name_debet = "Pengurangan ".$aruskas->coa_name;
                $coa_name_credit = "Penambahan ".$aruskas->coa_name;
                if($aruskas->debet != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_debet, $aruskas->debet*(-1), $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                    $total = $total+$aruskas->debet*(-1);
                }
                if($aruskas->credit != 0){
                    array_push($dt, array($aruskas->id, $aruskas->coa_code, $coa_name_credit, $aruskas->credit, $aruskas->coa, $aruskas->level_coa, $aruskas->fheader, $aruskas->jenis_aktivitas));
                    $total = $total+$aruskas->credit;
                }
            }
        }
        
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt,
            "saldo_awal" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($this->get_saldo_awal($request),0,",",".")."</b></td>",
            "total" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($total,0,",",".")."</b></td>"
        );

        $gs = Globalsetting::where("id", 1)->first();
        $image =  base_path() . '/public/logo_instansi/'.$gs->logo_instansi;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $uk = null;
        if($unitkerja != null && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }
        $pdf = PDF::loadview("aruskas.print", ["aruskas" => $output,"data" => $request, "globalsetting" => Globalsetting::where("id", 1)->first(), "bulan" => $this->convertBulan($bulan_periode), "tahun" => $tahun_periode, "unitkerja" => $unitkerja, "unitkerja_label" => $uk?$uk->unitkerja_name:"", "logo"=>$dataUri]);
        $pdf->getDomPDF();
        $pdf->setOptions(["isPhpEnabled"=> true,"isJavascriptEnabled"=>true,'isRemoteEnabled'=>true,'isHtml5ParserEnabled' => true]);
        return $pdf->stream('aruskas.pdf');
    }

    public function convertBulan($bulan){
        $nmb = "";
        switch(date("F", mktime(0, 0, 0, $bulan, 10)))
        {
            case 'January':     $nmb="Januari";     break; 
            case 'February':    $nmb="Februari";    break; 
            case 'March':       $nmb="Maret";       break; 
            case 'April':       $nmb="April";       break; 
            case 'May':         $nmb="Mei";         break; 
            case 'June':        $nmb="Juni";        break; 
            case 'July':        $nmb="Juli";        break;
            case 'August':      $nmb="Agustus";     break;
            case 'September':   $nmb="September";   break;
            case 'October':     $nmb="Oktober";     break;
            case 'November':    $nmb="November";    break;
            case 'December':    $nmb="Desember";    break;
        }
        return $nmb;
    }

    public function convertCode($data, $level){
        $val = substr($data,0,1) . "-" . substr($data,1,2) . "-" . substr($data,3,2) . "-" . substr($data,5);
        $padd = (((int) $level-1)*20);
        $html = "<span style='padding-left:".strval($padd)."px'>".$val."</span>";        
        return $html;
    }

    public function tab($data, $level){
        $padd = (((int) $level-1)*20);
        $html = "<span style='padding-left:".strval($padd)."px'>".$data."</span>";        
        return $html;
    }
}