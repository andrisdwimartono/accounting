<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pencairan;
use App\Models\Pencairanrka;
use App\Models\Kegiatan;
use App\Models\Approval;
use App\Models\Detailbiayakegiatan;

class PencairanController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Pencairan",
            "page_data_urlname" => "pencairan",
            "fields" => [
                "tanggal_pencairan" => "date",
                "catatan" => "text",
                "pencairanrka" => "childtable"
            ],
            "fieldschildtable" => [
                "pencairanrka" => [
                    "kegiatan" => "link",
                    "nominalbiaya" => "float",
                ]
            ],
            "fieldlink" => [
                "kegiatan" => "kegiatans"
            ]
        ];

        $td["fieldsrules"] = [
            "tanggal_pencairan" => "required",
            "catatan" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_pencairanrka"] = [
            "kegiatan" => "required|exists:kegiatans,id",
            "nominalbiaya" => "required|numeric"
        ];

        $td["fieldsmessages_pencairanrka"] = [
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
        $page_data["footer_js_page_specific_script"] = ["pencairan.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["pencairan.page_specific_script.header_js_list"];
        
        return view("pencairan.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["pencairan.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["pencairan.page_specific_script.header_js_create"];
        
        return view("pencairan.create", ["page_data" => $page_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_list(Request $request)
    {
        $list_column = array("id", "tanggal_pencairan", "catatan", "id");
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
        foreach(Pencairan::where(function($q) use ($keyword) {
            $q->where("tanggal_pencairan", "ILIKE", "%" . $keyword. "%")->orWhere("catatan", "ILIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "tanggal_pencairan", "catatan"]) as $pencairan){
            $no = $no+1;
            $act = '
            <a href="/pencairan/'.$pencairan->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/pencairan/'.$pencairan->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($pencairan->id, $pencairan->tanggal_pencairan, $pencairan->catatan, $act));
        }
        
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Pencairan::get()->count(),
            "recordsFiltered" => intval(Pencairan::where(function($q) use ($keyword) {
                $q->where("tanggal_pencairan", "ILIKE", "%" . $keyword. "%")->orWhere("catatan", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getlinks(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()){
            $page = $request->page;
            $resultCount = 25;

            $offset = ($page - 1) * $resultCount;

            $lists = null;
            $count = 0;
            if($request->field == "kegiatan"){
                $lists = Kegiatan::where(function($q) use ($request) {
                    $q->where("kegiatan_name", "ILIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("kegiatan_name as text")]);
                $count = Kegiatan::count();
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

    public function getbiayakegiatan(Request $request){
        if($request->ajax() || $request->wantsJson()){
            $kegiatan = Kegiatan::whereId($request->id)->first();
            if(!$kegiatan){
                abort(404, "Data not found");
            }

            $finalappr = Approval::where("parent_id", $request->id)->orderBy("no_seq", "asc")->first();
            $total_biaya = 0;
            if($finalappr){
                $ct1_detailbiayakegiatans = Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $finalappr->role)->orderBy("no_seq")->get();
                
                if(Detailbiayakegiatan::whereParentId($request->id)->where("isarchived", "on")->where("archivedby", $finalappr->role)->orderBy("no_seq")->count() > 1){
                    foreach($ct1_detailbiayakegiatans as $detailbiayakegiatans){
                        $total_biaya += $detailbiayakegiatans->nominalbiaya;
                    }
                }
            }

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "total_biaya" => $total_biaya
                ]
            );

            return response()->json($results);
        }
    }

    public function getlistrka(Request $request){
        if($request->ajax() || $request->wantsJson()){
            
            $lists = Kegiatan::where(function($q) use ($request) {
                $q->whereBetween("tanggal", [$request->tanggal_pencairan_start, $request->tanggal_pencairan_finish]);
            })->orderBy("id")->get([DB::raw("id as kegiatan"), DB::raw("kegiatan_name as kegiatan_label"), DB::raw("1000000 as nominalbiaya")]);

            $no_seq = 1;
            foreach($lists as $list){
                $list->no_seq = $no_seq++;
            }
            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "ct1_pencairanrka" => $lists
                ]
            );

            return response()->json($results);
        }
    }
}
