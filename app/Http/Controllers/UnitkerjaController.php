<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Unitkerja;

class UnitkerjaController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Unit Kerja",
            "page_data_urlname" => "unitkerja",
            "fields" => [
                "unitkerja_code" => "text",
                "unitkerja_name" => "text"
            ],
            "fieldschildtable" => [
            ]
        ];

        $td["fieldsrules"] = [
            "unitkerja_code" => "required|min:1|max:5|unique:unitkerjas,unitkerja_code",
            "unitkerja_name" => "required|min:2|max:255|unique:unitkerjas,unitkerja_name"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!",
            "unique" => ":attribute sudah ada, harus unik!!"
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
        $page_data["footer_js_page_specific_script"] = ["unitkerja.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["unitkerja.page_specific_script.header_js_list"];
        
        return view("unitkerja.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["unitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("unitkerja.create", ["page_data" => $page_data]);
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
            $id = Unitkerja::create([
                "unitkerja_code"=> $request->unitkerja_code,
                "unitkerja_name"=> $request->unitkerja_name,
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
    public function show(Unitkerja $unitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["unitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $unitkerja->id;
        return view("unitkerja.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Unitkerja $unitkerja)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["unitkerja.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $unitkerja->id;
        return view("unitkerja.create", ["page_data" => $page_data]);
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
        $rules["unitkerja_code"] = $rules["unitkerja_code"].",".$id;
        $rules["unitkerja_name"] = $rules["unitkerja_name"].",".$id;
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Unitkerja::where("id", $id)->update([
                "unitkerja_code"=> $request->unitkerja_code,
                "unitkerja_name"=> $request->unitkerja_name,
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
            $unitkerja = Unitkerja::whereId($request->id)->first();
            if(!$unitkerja){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Unitkerja::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "unitkerja_code", "unitkerja_name", "id");
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
        foreach(Unitkerja::where(function($q) use ($keyword) {
            $q->where("unitkerja_code", "ILIKE", "%" . $keyword. "%")->orWhere("unitkerja_name", "ILIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unitkerja_code", "unitkerja_name"]) as $unitkerja){
            $no = $no+1;
            $act = '
            <a href="/unitkerja/'.$unitkerja->id.'" class="btn btn-info shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fa fa-eye"></i></a>

            <a href="/unitkerja/'.$unitkerja->id.'/edit" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User Data"><i class="fa fa-edit"></i></a>

            <a class="row-delete btn btn-danger shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><i class="fa fa-trash"></i></a>';
            

            array_push($dt, array($unitkerja->id, $unitkerja->unitkerja_code, $unitkerja->unitkerja_name, $act));
    }
    
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Unitkerja::get()->count(),
            "recordsFiltered" => intval(Unitkerja::where(function($q) use ($keyword) {
                $q->where("unitkerja_code", "ILIKE", "%" . $keyword. "%")->orWhere("unitkerja_name", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $unitkerja = Unitkerja::whereId($request->id)->first();
            if(!$unitkerja){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "unitkerja" => $unitkerja
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
