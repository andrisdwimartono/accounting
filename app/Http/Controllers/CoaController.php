<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\Globalsetting;
use App\Models\Neracasaldo;
use PDF;

class CoaController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "COA",
            "page_data_urlname" => "coa",
            "fields" => [
                "coa_code" => "text",
                "coa_name" => "text",
                "level_coa" => "text",
                "coa" => "link",
                "category" => "select",
                "fheader" => "checkbox",
                "factive" => "checkbox"
            ],
            "fieldschildtable" => [
            ],
            "fieldsoptions" => [
                "category" => [
                    ["name" => "aset", "label" => "Aset"],
                    ["name" => "hutang", "label" => "Hutang"],
                    ["name" => "modal", "label" => "Modal"],
                    ["name" => "pendapatan", "label" => "Pendapatan"],
                    ["name" => "biaya", "label" => "Biaya"],
                    ["name" => "biaya_lainnya", "label" => "Biaya Lainnya"],
                    ["name" => "pendapatan_lainnya", "label" => "Pendapatan Lainnya"]
                ]
            ],
            "fieldlink" => [
                "coa" => "coas"
            ]
        ];

        $category_list = "aset,hutang,modal,pendapatan,biaya,biaya_lainnya,pendapatan_lainnya";

        $td["fieldsrules"] = [
            "coa_code" => "required|min:5|max:20|unique:coas,coa_code",
            "coa_name" => "required|min:2|max:255|unique:coas,coa_name",
            "level_coa" => "required|min:1|max:4",
            "coa" => "exists:coas,id",
            "category" => "required|in:aset,hutang,modal,pendapatan,biaya,biaya_lainnya,pendapatan_lainnya"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!",
            "unique" => ":attribute sudah ada!!"
        ];

        return $td;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index($category)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["category"] = $category;
        $page_data["footer_js_page_specific_script"] = ["coa.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["coa.page_specific_script.header_js_list"];
        
        return view("coa.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["coa.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("coa.create", ["page_data" => $page_data]);
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
            $id = Coa::create([
                "coa_code"=> $request->coa_code,
                "coa_name"=> $request->coa_name,
                "level_coa"=> $request->level_coa,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "category"=> $request->category,
                "category_label"=> $request->category_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "factive"=> isset($request->factive)?$request->factive:null,
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
    public function show(Coa $coa)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["coa.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $coa->id;
        return view("coa.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Coa $coa)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["coa.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $coa->id;
        return view("coa.create", ["page_data" => $page_data]);
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
        $rules["coa_code"] = $rules["coa_code"].",".$id;
        $rules["coa_name"] = $rules["coa_name"].",".$id;
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Coa::where("id", $id)->update([
                "coa_code"=> $request->coa_code,
                "coa_name"=> $request->coa_name,
                "level_coa"=> $request->level_coa,
                "coa"=> $request->coa,
                "coa_label"=> $request->coa_label,
                "category"=> $request->category,
                "category_label"=> $request->category_label,
                "fheader"=> isset($request->fheader)?$request->fheader:null,
                "factive"=> isset($request->factive)?$request->factive:null,
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
            $coa = Coa::whereId($request->id)->first();
            if(!$coa){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            $ns = Neracasaldo::where("coa", $request->id)->first();
            
            if(is_null($ns)){
                if(Coa::whereId($request->id)->forceDelete()){
                    $results = array(
                        "status" => 204,
                        "message" => "Deleted successfully"
                    );
                }
            }else{
                if(Coa::whereId($request->id)->update(array("factive" => null))){
                    $results = array(
                        "status" => 204,
                        "message" => "Deleted successfully",
                    );
                }
            }
            
            return response()->json($results);
        }
    }

    public function get_list(Request $request)
    {
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

        $dt = array();
        if($keyword){
            $no = 0;
        foreach(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
                    })->where("factive", "on")->where("category", $request->category_filter)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                        $no = $no+1;
                        $act = '
                        <!--<a href="/coa/'.$coa->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-info"></i></a>

                        <a href="/coa/'.$coa->id.'/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-success"></i></a>-->

                        <button type="button" class="row-delete"> <i class="fas fa-minus-circle text-danger"></i> </button>
                        
                        <!--
                        <button type="button" class="row-update-line"> <i class="fas fa-edit text-success"></i> </button>-->
                        ';

                        if($coa->fheader == 'on'){
                            $act .= '<button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>';
                        }

                    array_push($dt, array($coa->id, $coa->coa_code, $coa->coa_name, $coa->level_coa, $coa->coa, $coa->coa_label, $coa->category, $coa->category_label, $coa->fheader, $coa->factive, $act));
                }
        }else{
            $this->get_list_data($dt, $request, $keyword, $limit, $orders, null);
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Coa::get()->count(),
            "recordsFiltered" => intval(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("category", $request->category_filter)->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    private function get_list_data(&$dt, $request, &$keyword, $limit, $orders, $parent_id = null){
        $no = 0;
        foreach(Coa::where(function($q) use (&$keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("factive", "on")->where("category", $request->category_filter)->where("coa", $parent_id)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                $no = $no+1;
                $act = '
                <!--<a href="/coa/'.$coa->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-info"></i></a>

                <a href="/coa/'.$coa->id.'/edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-success"></i></a>-->

                
            	<a class="row-delete btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

                <!--<button type="button" class="row-delete"> <i class="fas fa-minus-circle text-danger"></i> </button>!-->
                
                <!--
                <button type="button" class="row-update-line"> <i class="fas fa-edit text-success"></i> </button>-->
                ';

                if($coa->fheader == 'on'){
                    $act .= '<a href="#" class="row-add-child btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-plus"></i></a>';
                    // $act .= '<button type="button" class="row-add-child"> <i class="fas fa-plus text-info"></i> </button>';
                }

            array_push($dt, array($coa->id, $coa->coa_code, $coa->coa_name, $coa->level_coa, $coa->coa, $coa->coa_label, $coa->category, $coa->category_label, $coa->fheader, $coa->factive, $act));
            
            array_merge($dt, $this->get_list_data($dt, $request, $keyword, $limit, $orders, $coa->id));
            
        }
        return $dt;
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $coa = Coa::whereId($request->id)->first();
            if(!$coa){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "coa" => $coa
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
                })->where("fheader", "on")->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("coa_name as text")]);
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

    public function print(Request $request){
        ini_set('max_execution_time', 300);
        $page_data = $this->tabledesign();

        $list_column = array("id", "coa_code", "coa_name", "level_coa", "fheader", "factive", "id");
        $keyword = null;
        if(isset($request->search["value"])){
            $keyword = $request->search["value"];
        }

        $orders = array("coa_code", "ASC");
        if(isset($request->order)){
            $orders = array($list_column[$request->order["0"]["column"]], $request->order["0"]["dir"]);
        }

        $limit = null;
        if(isset($request->length) && $request->length != -1){
            $limit = array(intval($request->start), intval($request->length));
        }

        $dt = array();
            
        $no = 0;
        foreach(Coa::where(function($q) use ($keyword, $request) {
            $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("factive", "on")->where("category", $request->category_filter)->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "coa_code", "coa_name", "level_coa", "coa", "coa_label", "category", "category_label", "fheader", "factive"]) as $coa){
                    $no = $no+1;
                    $act = '';
                    $coa_code = $this->convertCode($coa->coa_code, $coa->level_coa);
                    $coa_name = $this->tab($coa->coa_name, $coa->level_coa);
                        
                array_push($dt, array($coa->id, $coa_code, $coa_name, $coa->level_coa, $coa->coa, $coa->coa_label, $coa->category, $coa->category_label, $coa->fheader, $coa->factive, $act));
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Coa::get()->count(),
            "recordsFiltered" => intval(Coa::where(function($q) use ($keyword, $request) {
                $q->where("coa_code", "LIKE", "%" . $keyword. "%")->orWhere("coa_name", "LIKE", "%" . $keyword. "%")->orWhere("level_coa", "LIKE", "%" . $keyword. "%")->orWhere("fheader", "LIKE", "%" . $keyword. "%")->orWhere("factive", "LIKE", "%" . $keyword. "%");
            })->where("category", $request->category_filter)->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        $gs = Globalsetting::where("id", 1)->first();

        $pdf = PDF::loadview("coa.print", ["coa" => $output,"page_data" => $page_data, "data" => $request, "globalsetting" => $gs]);
        $pdf->getDomPDF();
        $pdf->setOptions(["isPhpEnabled"=> true,'isRemoteEnabled'=>true]);
        return $pdf->stream('coa.pdf');
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
