<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Satuan",
            "page_data_urlname" => "satuan",
            "fields" => [
                "satuan_name" => "text",
                "satuan_katerangan" => "textarea",
                "type_satuan" => "select"
            ],
            "fieldschildtable" => [
            ],
            "fieldsoptions" => [
                "type_satuan" => [
                    ["name" => "Mata Uang", "label" => "Mata Uang"],
                    ["name" => "Massa", "label" => "Massa"],
                    ["name" => "Panjang", "label" => "Panjang"],
                    ["name" => "Luas", "label" => "Luas"],
                    ["name" => "Volume", "label" => "Volume"],
                    ["name" => "Waktu", "label" => "Waktu"],
                    ["name" => "Jumlah", "label" => "Jumlah"],
                ]
            ]
        ];

        $type_satuan_list = "Mata Uang,Massa,Panjang,Luas,Volume,Waktu,Jumlah";

        $td["fieldsrules"] = [
            "satuan_name" => "required",
            "satuan_katerangan" => "required",
            "type_satuan" => "required|in:Mata Uang,Massa,Panjang,Luas,Volume,Waktu,Jumlah"
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
        $page_data["footer_js_page_specific_script"] = ["satuan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["satuan.page_specific_script.header_js_list"];
        
        return view("satuan.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["satuan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["satuan.page_specific_script.header_js_create"];
        
        return view("satuan.create", ["page_data" => $page_data]);
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
            $id = Satuan::create([
                "satuan_name"=> $request->satuan_name,
                "satuan_katerangan"=> $request->satuan_katerangan,
                "type_satuan"=> $request->type_satuan,
                "type_satuan_label"=> $request->type_satuan_label,
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
    public function show(Satuan $satuan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["satuan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["satuan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $satuan->id;
        return view("satuan.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Satuan $satuan)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["satuan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["satuan.page_specific_script.header_js_create"];
        
        $page_data["id"] = $satuan->id;
        return view("satuan.create", ["page_data" => $page_data]);
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
            Satuan::where("id", $id)->update([
                "satuan_name"=> $request->satuan_name,
                "satuan_katerangan"=> $request->satuan_katerangan,
                "type_satuan"=> $request->type_satuan,
                "type_satuan_label"=> $request->type_satuan_label,
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
            $satuan = Satuan::whereId($request->id)->first();
            if(!$satuan){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Satuan::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "satuan_name", "satuan_katerangan", "type_satuan_label", "id");
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
        foreach(Satuan::where(function($q) use ($keyword) {
            $q->where("satuan_name", "LIKE", "%" . $keyword. "%")->orWhere("satuan_katerangan", "LIKE", "%" . $keyword. "%")->orWhere("type_satuan_label", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "satuan_name", "satuan_katerangan", "type_satuan_label"]) as $satuan){
            $no = $no+1;
            $act = '
            <a href="/satuan/'.$satuan->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/satuan/'.$satuan->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($satuan->id, $satuan->satuan_name, $satuan->satuan_katerangan, $satuan->type_satuan_label, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Satuan::get()->count(),
            "recordsFiltered" => intval(Satuan::where(function($q) use ($keyword) {
                $q->where("satuan_name", "LIKE", "%" . $keyword. "%")->orWhere("satuan_katerangan", "LIKE", "%" . $keyword. "%")->orWhere("type_satuan_label", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $satuan = Satuan::whereId($request->id)->first();
            if(!$satuan){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "satuan" => $satuan
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