<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Opencloseperiode;

class OpencloseperiodeController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Buka Tutup Buku Bulan",
            "page_data_urlname" => "opencloseperiode",
            "fields" => [
                "bulan_open" => "select",
                "tahun_open" => "text",
                "catatan" => "textarea"
            ],
            "fieldschildtable" => [
            ],
            "fieldsoptions" => [
                "bulan_open" => [
                    ["name" => "1", "label" => "Januari"],
                    ["name" => "2", "label" => "Februari"],
                    ["name" => "3", "label" => "Maret"],
                    ["name" => "4", "label" => "April"],
                    ["name" => "5", "label" => "Mei"],
                    ["name" => "6", "label" => "Juni"],
                    ["name" => "7", "label" => "Juli"],
                    ["name" => "8", "label" => "Agustus"],
                    ["name" => "9", "label" => "September"],
                    ["name" => "10", "label" => "Oktober"],
                    ["name" => "11", "label" => "November"],
                    ["name" => "12", "label" => "Desember"]
                ]
            ]
        ];

        $bulan_open_list = "1,2,3,4,5,6,7,8,9,10,11,12";

        $td["fieldsrules"] = [
            "bulan_open" => "required|in:1,2,3,4,5,6,7,8,9,10,11,12",
            "tahun_open" => "required|min:4"
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
        $page_data["footer_js_page_specific_script"] = ["paging.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_list"];
        
        return view("opencloseperiode.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["opencloseperiode.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("opencloseperiode.create", ["page_data" => $page_data]);
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
            $id = Opencloseperiode::create([
                "bulan_open"=> $request->bulan_open,
                "bulan_open_label"=> $request->bulan_open_label,
                "tahun_open"=> $request->tahun_open,
                "catatan"=> $request->catatan,
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
    public function show(Opencloseperiode $opencloseperiode)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["opencloseperiode.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $opencloseperiode->id;
        return view("opencloseperiode.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Opencloseperiode $opencloseperiode)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["opencloseperiode.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $opencloseperiode->id;
        return view("opencloseperiode.create", ["page_data" => $page_data]);
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
            Opencloseperiode::where("id", $id)->update([
                "bulan_open"=> $request->bulan_open,
                "bulan_open_label"=> $request->bulan_open_label,
                "tahun_open"=> $request->tahun_open,
                "catatan"=> $request->catatan,
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
            $opencloseperiode = Opencloseperiode::whereId($request->id)->first();
            if(!$opencloseperiode){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Opencloseperiode::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "bulan_open_label", "tahun_open", "catatan", "id");
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
        foreach(Opencloseperiode::where(function($q) use ($keyword) {
            $q->where("bulan_open_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_open", "LIKE", "%" . $keyword. "%")->orWhere("catatan", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "bulan_open_label", "tahun_open", "catatan"]) as $opencloseperiode){
            $no = $no+1;
            $act = '
            <a href="/opencloseperiode/'.$opencloseperiode->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/opencloseperiode/'.$opencloseperiode->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($opencloseperiode->id, $opencloseperiode->bulan_open_label, $opencloseperiode->tahun_open, $opencloseperiode->catatan, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Opencloseperiode::get()->count(),
            "recordsFiltered" => intval(Opencloseperiode::where(function($q) use ($keyword) {
                $q->where("bulan_open_label", "LIKE", "%" . $keyword. "%")->orWhere("tahun_open", "LIKE", "%" . $keyword. "%")->orWhere("catatan", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $opencloseperiode = Opencloseperiode::orderBy("id", "desc")->first();
            if(!$opencloseperiode){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "opencloseperiode" => $opencloseperiode
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