<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Neraca;
use App\Models\Coa;
use App\Models\Globalsetting;

class NeracaController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Neraca",
            "page_data_urlname" => "neraca",
            "fields" => [
                "tahun_periode" => "integer",
                "bulan_periode" => "integer",
                "coa" => "link",
                "fheader" => "checkbox",
                "debet" => "float",
                "credit" => "float"
            ],
            "fieldschildtable" => [
            ],
            "fieldlink" => [
                "coa" => "coas"
            ]
        ];

        $td["fieldsrules"] = [
            "tahun_periode" => "required|integer",
            "bulan_periode" => "required|integer",
            "coa" => "required|exists:coas,id",
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
        $page_data["footer_js_page_specific_script"] = ["neraca.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["neraca.page_specific_script.header_js_list"];
        
        return view("neraca.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["neraca.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("neraca.create", ["page_data" => $page_data]);
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
            $id = Neraca::create([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
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
    public function show(Neraca $neraca)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["neraca.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neraca->id;
        return view("neraca.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Neraca $neraca)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["neraca.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $neraca->id;
        return view("neraca.create", ["page_data" => $page_data]);
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
            Neraca::where("id", $id)->update([
                "tahun_periode"=> $request->tahun_periode,
                "bulan_periode"=> $request->bulan_periode,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
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
            $neraca = Neraca::whereId($request->id)->first();
            if(!$neraca){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Neraca::whereId($request->id)->forceDelete()){
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
        $maxLevel = Coa::max('level_coa');

        $list_column = array("id", "coa_code", "coa_name", "level_coa", "fheader", "factive", "id");
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

        $dt = array();
        $no = 0;
        $yearopen = Globalsetting::where("id", 1)->first();
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")]) //"neracas.debet", "neracas.credit"])//DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")])
        ->leftJoin('neracas', 'coas.id', '=', 'neracas.coa')
        ->whereIn('coas.category',['aset','hutang','modal'])
        ->where(function($q){
            $q->where(function($q){
                $q->where("neracas.debet","!=",0)->orWhere("neracas.credit","!=",0);
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
        $dt = array_filter($dt, function ($dt) use ($child_level) {
            return ((int)$dt[6] <= (int)$child_level+1);
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

    private function get_list_data(&$dt, $request, &$keyword, $limit, $orders, $parent_id = null){
        $no = 0;
        foreach(Coa::where(function($q) use (&$keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("factive", "on")->where("coa", $parent_id)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                $no = $no+1;
                $act = '';

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

                if($coa->fheader != "on"){
                    $neraca_val = Neraca::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                        $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
                    })->first();
                    if($neraca_val){
                        array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $neraca_val->debet, $neraca_val->credit, $coa->level_coa, $coa->fheader, $act));
                    }
                }else{
                    $dc = array(0, 0);
                    $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
                    if($dc[0] != 0  || $dc[1] != 0)
                        array_push($dt, array($coa->id, $coa->coa_code." ".$coa->coa_name, $dc[0], $dc[1], $coa->level_coa, $coa->fheader, $act));
                }
                if((int)$coa->level_coa <= $child_level){
                    array_merge($dt, $this->get_list_data($dt, $request, $keyword, $limit, $orders, $coa->id));
                }
            
        }
        return $dt;
    }

    public function getAngka(&$dc, $parent_id, $bulan_periode, $tahun_periode){
        foreach(Coa::where("factive", "on")->where("coa", $parent_id)->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
            $labarugi_val = Neraca::where("coa", $coa->id)->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->where(function($q) {
                $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
            })->first();
            if($labarugi_val){
                $dc[0] = $dc[0]+$labarugi_val->debet;
                $dc[1] = $dc[1]+$labarugi_val->credit;
            }
            $this->getAngka($dc, $coa->id, $bulan_periode, $tahun_periode);
        }
        return $dc;
    }

    // public function get_list(Request $request)
    // {
    //     $list_column = array("id", "coa_label", "coa_label", "debet", "credit", "id");
    //     $keyword = null;
    //     if(isset($request->search["value"])){
    //         $keyword = $request->search["value"];
    //     }
    //     $bulan_periode = 1;
    //     if(isset($request->search["bulan_periode"])){
    //         $bulan_periode = $request->search["bulan_periode"];
    //     }
    //     $tahun_periode = 1;
    //     if(isset($request->search["tahun_periode"])){
    //         $tahun_periode = $request->search["tahun_periode"];
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
    //     foreach(Neraca::where(function($q) use ($keyword) {
    //         $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%");
    //     })->where(function($q) {
    //         $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
    //     })->where(function($q) use($bulan_periode, $tahun_periode){
    //         $q->where(function($q) use ($bulan_periode, $tahun_periode){
    //             $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
    //         })->orWhere(function($q) use ($bulan_periode, $tahun_periode){
    //             $q->where("tahun_periode", "<", $tahun_periode);
    //         });
    //     })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->select([ "coa_label", DB::raw("SUM(debet) as debet"), DB::raw("SUM(credit) as credit")])->groupBy("coa_label")->get() as $neraca){
    //         $no = $no+1;
    //         $act = '
    //         <a href="/neraca/'.$neraca->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

    //         <a href="/neraca/'.$neraca->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

    //         <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

    //         array_push($dt, array($no, $neraca->coa_label, $neraca->debet, $neraca->credit, $act));
    // }
    //     $output = array(
    //         "draw" => intval($request->draw),
    //         "recordsTotal" => Neraca::get()->count(),
    //         "recordsFiltered" => intval(Neraca::where(function($q) use ($keyword) {
    //             $q->where("tahun_periode", "LIKE", "%" . $keyword. "%")->orWhere("bulan_periode", "LIKE", "%" . $keyword. "%")->orWhere("coa_label", "LIKE", "%" . $keyword. "%");
    //         })->where(function($q) {
    //             $q->where("debet", "!=", 0)->orWhere("credit", "!=", 0);
    //         })->where("bulan_periode", $bulan_periode)->where("tahun_periode", $tahun_periode)->orderBy($orders[0], $orders[1])->get()->count()),
    //         "data" => $dt
    //     );

    //     echo json_encode($output);
    // }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $neraca = Neraca::whereId($request->id)->first();
            if(!$neraca){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "neraca" => $neraca
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
}