<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Neracasaldo;
use App\Models\Coa;
use App\Models\Jenisbayar;
use App\Models\Unitkerja;
use App\Exports\NeracaSaldoExport;
use PDF;
use Excel;
use Session;

class NeracasaldoController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Neraca Saldo",
            "page_data_urlname" => "neracasaldo",
            "fields" => [
                "tahun_periode" => "integer",
                "bulan_periode" => "integer",
                "coa" => "link",
                "jenisbayar" => "link",
                "fheader" => "checkbox",
                "debet" => "float",
                "credit" => "float",
                "unitkerja" => "link"
            ],
            "fieldschildtable" => [
            ],
            "fieldlink" => [
                "coa" => "coas",
                "jenisbayar" => "jenisbayars",
                "unitkerja" => "unitkerjas"
            ]
        ];

        $td["fieldsrules"] = [
            "tahun_periode" => "required|integer",
            "bulan_periode" => "required|integer",
            "coa" => "required|exists:coas,id",
            "jenisbayar" => "required|exists:jenisbayars,id",
            "fheader" => "required",
            "debet" => "required|numeric",
            "credit" => "required|numeric"
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
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["neracasaldo.page_specific_script.header_js_list"];
        
        return view("neracasaldo.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("neracasaldo.create", ["page_data" => $page_data]);
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
            $id = Neracasaldo::create([
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
    public function show(Neracasaldo $neracasaldo)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neracasaldo->id;
        return view("neracasaldo.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Neracasaldo $neracasaldo)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["neracasaldo.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neracasaldo->id;
        return view("neracasaldo.create", ["page_data" => $page_data]);
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
            Neracasaldo::where("id", $id)->update([
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
            $neracasaldo = Neracasaldo::whereId($request->id)->first();
            if(!$neracasaldo){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Neracasaldo::whereId($request->id)->forceDelete()){
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
        $yearopen = Session::get('global_setting');
        
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", DB::raw("SUM(neracasaldos.debet) as debet"), DB::raw("SUM(neracasaldos.credit) as credit")]) //"neracas.debet", "neracas.credit"])//DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")])
        ->leftJoin('neracasaldos', 'coas.id', '=', 'neracasaldos.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("neracasaldos.debet","!=",0)->orWhere("neracasaldos.credit","!=",0);
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });  
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })
        ->where(function($q) use ($unitkerja){
            $q->where(function($q) use ($unitkerja){
                if($unitkerja != null && $unitkerja != 0){
                    $q->where("neracasaldos.unitkerja", $unitkerja)->whereNull("coas.fheader");
                }else{
                    $q->whereNull("coas.fheader");
                }
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });
        })
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader"])
        ->orderBy("coas.level_coa", "desc")
          ->get() as $neracasaldo){
            
            $no = $no+1;
            $dt[$neracasaldo->id] = array($neracasaldo->id, $neracasaldo->coa_code, $neracasaldo->coa_name, $neracasaldo->debet, $neracasaldo->credit, $neracasaldo->coa, $neracasaldo->level_coa, $neracasaldo->fheader);
        }
        
        // get nominal
        $iter = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0) && ($dt[7] != "on");
        });

        // sum nominal to header
        foreach($iter as $key => $item){
            $d = $item;
            $deb = $item[3];
            $cre = $item[4];
            for($i=$d[6] ; $i>1 ; $i--){
                $dt[$d[5]][3] = (int) $dt[$d[5]][3] + $deb;
                $dt[$d[5]][4] = (int) $dt[$d[5]][4] + $cre;
                $d = $dt[$d[5]];
            }
        }
        // remove null value
        $dt = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0);
            // return $dt;
        });

        
        // sort by code
        $columns = array_column($dt, 1);
        array_multisort($columns, SORT_ASC, $dt);
        // convert array
        $dt = array_values($dt);

        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt
        );

        echo json_encode($output);
    }

    

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $neracasaldo = Neracasaldo::whereId($request->id)->first();
            if(!$neracasaldo){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "neracasaldo" => $neracasaldo
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
            }elseif($request->field == "jenisbayar"){
                $lists = Jenisbayar::where(function($q) use ($request) {
                    $q->where("jenisbayar_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("jenisbayar_name as text")]);
                $count = Jenisbayar::count();
            }elseif($request->field == "unitkerja"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%")->orWhere("unitkerja_code", "LIKE", "%" . $request->term. "%");
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

    public function print(Request $request){
        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }
        $child_level = 1;
        if(isset($request->search["child_level"])){
            $child_level = $request->search["child_level"];
        }

        $unitkerja = 0;
        if(isset($request->search["unitkerja"])){
            $unitkerja = $request->search["unitkerja"];
        }
        
        $dt = array();
        $no = 0;
        $yearopen = Session::get('global_setting');
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", DB::raw("SUM(neracasaldos.debet) as debet"), DB::raw("SUM(neracasaldos.credit) as credit")]) //"neracas.debet", "neracas.credit"])//DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")])
        ->leftJoin('neracasaldos', 'coas.id', '=', 'neracasaldos.coa')
        ->where(function($q){
            $q->where(function($q){
                $q->where("neracasaldos.debet","!=",0)->orWhere("neracasaldos.credit","!=",0);
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });  
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })
        ->where(function($q) use ($unitkerja){
            $q->where(function($q) use ($unitkerja){
                if($unitkerja != null && $unitkerja != 0){
                    $q->where("neracasaldos.unitkerja", $unitkerja);
                }else{
                    $q->whereNull("coas.fheader");
                }
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });
        })
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader"])
        ->orderBy("coas.level_coa", "desc")
          ->get() as $neraca){    
            $no = $no+1;
            $dt[$neraca->id] = array($neraca->id, $neraca->coa_code, $neraca->coa_name, $neraca->debet, $neraca->credit, $neraca->coa, $neraca->level_coa, $neraca->fheader);
        }
        

        // get nominal
        $iter = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0) && ($dt[7] != "on");
        });
        
        // sum nominal to header
        foreach($iter as $key => $item){
            $d = $item;
            $deb = $item[3];
            $cre = $item[4];
            for($i=$d[6] ; $i>1 ; $i--){
                $dt[$d[5]][3] = (int) $dt[$d[5]][3] + $deb;
                $dt[$d[5]][4] = (int) $dt[$d[5]][4] + $cre;
                $d = $dt[$d[5]];
            }
        }
        // remove null value
        $dt = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0);
            // return $dt;
        });
        // leveling
        if($child_level==0){
            $dt = array_filter($dt, function ($dt) use ($child_level) {
                return ((int)$dt[6] <= 1);
            });
        }
        
        // sort by code
        $columns = array_column($dt, 1);
        array_multisort($columns, SORT_ASC, $dt);
        // convert array
        $dt = array_values($dt);
        
        // re-formatting
        $deb_total = 0;
        $cre_total = 0;
        foreach($dt as $key => $data){
            $dt[$key][1] = $this->convertCode($data[1], $data[6]);
            
            // bold header
            if($data[7]=="on"){
                $dt[$key][1] = "<b>".$dt[$key][1]."</b>";
                $dt[$key][2] = "<b>".$dt[$key][2]."</b>";
            }

            // total
            if($data[6]==1){
                $deb_total += (int) $data[3];
                $cre_total += (int) $data[4];
            }

            // format nominal
            if($child_level==1){
                $dt[$key][3] = "<td class='rp'>Rp</td><td class='nom'>".number_format($data[3],0,",",".")."</td>";
                $dt[$key][4] = "<td class='rp'>Rp</td><td class='nom'>".number_format($data[4],0,",",".")."</td>";
                if($data[7]=="on"){
                    $dt[$key][3] = "<td colspan=2></td>";
                    $dt[$key][4] = "<td colspan=2></td>";
                }    
            } else {
                $dt[$key][3] = "<td class='rp'>Rp</td><td class='nom'>".number_format($data[3],0,",",".")."</td>";
                $dt[$key][4] = "<td class='rp'>Rp</td><td class='nom'>".number_format($data[4],0,",",".")."</td>";
                if($data[7]!="on"){
                    $dt[$key][3] = "<td colspan=2></td>";
                    $dt[$key][4] = "<td colspan=2></td>";
                }
            }
        }

        $uk = null;
        if($unitkerja != null && $unitkerja != 0){
            $uk = Unitkerja::where("id", ($unitkerja?$unitkerja:0))->first();
        }

        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $dt,
            "deb" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($deb_total,0,",",".")."</b></td>",
            "cre" => "<td class='rp'>Rp</td><td class='nom'><b>".number_format($cre_total,0,",",".")."</b></td>",
            "unitkerja" => $unitkerja, 
            "unitkerja_label" => $uk?$uk->unitkerja_name:""
        );

        $gs = Session::get('global_setting');
        $image =  base_path() . '/public/logo_instansi/'.$gs->logo_instansi;
        $type = pathinfo($image, PATHINFO_EXTENSION);
        $data = file_get_contents($image);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $pdf = PDF::loadview("neracasaldo.print", ["neraca" => $output,"data" => $request, "globalsetting" => Session::get('global_setting'), "bulan" => $this->convertBulan($bulan_periode), "tahun" => $tahun_periode, "unitkerja" => $unitkerja, 
        "unitkerja_label" => $uk?$uk->unitkerja_name:"", "logo"=>$dataUri]);
        $pdf->getDomPDF();
        $pdf->setOptions(["isPhpEnabled"=> true,"isJavascriptEnabled"=>true,'isRemoteEnabled'=>true,'isHtml5ParserEnabled' => true]);
        return $pdf->stream('neraca.pdf');
    }

    public function excel(Request $request)
    {
        $date = date("m-d-Y h:i:s a", time());
        return Excel::download(new NeracaSaldoExport($request), 'neraca_saldo_'.$date.'.xlsx');
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