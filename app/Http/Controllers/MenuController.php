<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\User_menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Menu",
            "page_data_urlname" => "menu",
            "fields" => [
                "mp_sequence"=> "int",
                "menu_name"=> "text",
                "url"=> "text",
                "menu_icon"=> "text",
                "parent_id"=> "int",
                "is_group_menu"=> "checkbox",
                "is_shown_at_side_menu"=> "checkbox",
                "ct_menu"=> "childtable",
                "is_view" => "checkbox",
                "mainmenu" => "text"
            ],
            "fieldsrules" => [
                "mp_sequence"=> "required",
                "menu_name"=> "required",
                "url"=> "required",
                "parent_id"=> "required",
                "is_group_menu"=> "required",
                "is_shown_at_side_menu"=> "required"
            ],
            "fieldschildtable" => [
                "ct_menu" => [
                    "m_sequence"=> "int",
                    "menu_name"=> "text",
                    "url"=> "text",
                    "menu_icon"=> "text",
                    "is_shown_at_side_menu"=> "int"
                ]
            ]
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
        $page_data["footer_js_page_specific_script"] = ["menu.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_list"];

        // query builder
        // $kitai = DB::table('menus')->get();
        
        $menus = Menu::all();
        return view('menu.list', ['page_data' => $page_data,'menus' => $menus]);
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
        //footer_js_page_specific_script untuk script javascript yang akan diprint di halaman
        $page_data["footer_js_page_specific_script"] = ["menu.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view('menu.create', ['page_data' => $page_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page_data = $this->tabledesign();
        
        $rules = [
            'mp_sequence' => 'required|integer|min:1',
            'menu_name' => 'required|min:3',
            'url' => 'required|min:1'
        ];

        $messages = [
            'required' => 'Field :attribute harus diisi!!',
            'min' => 'Field :attribute minimal :min karakter!!',
            'unique' => ':attribute sudah dipakai!',
            'max' => 'Field :attribute maksimal :max karakter!!',
            'integer' => 'Field :attribute harus berupa angka!!'
        ];

        $ctrule1_menu = [
            'ct1_menu_name' => 'required|min:3',
            'ct1_url' => 'required|min:3'
        ];

        $ctreq1_menu = json_decode($request->ct1_menu, true);
        foreach($ctreq1_menu as $ct1_req){
            $childtbrequest1_menu = new \Illuminate\Http\Request();
            $childtbrequest1_menu->replace($ct1_req);
            $ctmessages1_menu = [
                'required' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus diisi!!',
                'min' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' minimal :min karakter!!',
                'unique' => ':attribute No '.$ct1_req["ct1_m_sequence"].' sudah dipakai!',
                'max' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' maksimal :max karakter!!',
                'digits' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus angka dengan panjang karakter :digits!!',
                'integer' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus berupa angka!!',
                'in' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' dengan value '.$ct1_req["ct1_is_shown_at_side_menu"].' tidak ada di pilihan!!'
            ];
            $childtbrequest1_menu->validate($ctrule1_menu, $ctmessages1_menu);
        }
        
        if($request->validate($rules, $messages)){
            $id = Menu::create([
                'mp_sequence'=> $request->mp_sequence,
                'm_sequence'=> 0,
                'menu_name'=> $request->menu_name,
                'url'=> $request->url,
                'menu_icon'=> $request->menu_icon,
                'is_group_menu' => count($ctreq1_menu) > 0? 'on':null,
                'is_shown_at_side_menu'=> $request->is_shown_at_side_menu == 1 ? 'on': ($request->is_shown_at_side_menu == 'on'? 'on': null),
                'is_view'=> $request->is_view == 1 ? 'on': ($request->is_view == 'on'? 'on': null),
                'user_creator_id' => Auth::user()->id
            ])->id;
            
            foreach($ctreq1_menu as $ct1_req){
                Menu::create([
                    'parent_id' => $id,
                    'mp_sequence'=> $request->mp_sequence,
                    'm_sequence'=> $ct1_req["ct1_m_sequence"],
                    'menu_name'=> $ct1_req["ct1_menu_name"],
                    'url'=> $ct1_req["ct1_url"],
                    'menu_icon'=> $ct1_req["ct1_menu_icon"],
                    'is_group_menu' => null,
                    'is_shown_at_side_menu'=> $ct1_req["ct1_is_shown_at_side_menu"] == 1 ? 'on': ($ct1_req["ct1_is_shown_at_side_menu"] == 'on'? 'on':null),
                    'is_view'=> $ct1_req["ct1_is_view"] == 1 ? 'on': ($ct1_req["ct1_is_view"] == 'on'? 'on': null),
                    'mainmenu'=> $ct1_req["ct1_mainmenu"],
                    'user_creator_id' => Auth::user()->id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["menu.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $menu->id;
        return view('menu.create', ['page_data' => $page_data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["menu.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $menu->id;
        return view('menu.create', ['page_data' => $page_data]);
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
        $page_data = $this->tabledesign();
        
        $rules = [
            'mp_sequence' => 'required|integer|min:1',
            'menu_name' => 'required|min:3',
            'url' => 'required|min:1'
        ];

        $messages = [
            'required' => 'Field :attribute harus diisi!!',
            'min' => 'Field :attribute minimal :min karakter!!',
            'unique' => ':attribute sudah dipakai!',
            'max' => 'Field :attribute maksimal :max karakter!!',
            'integer' => 'Field :attribute harus berupa angka!!'
        ];

        $ctrule1_menu = [
            'ct1_menu_name' => 'required|min:3',
            'ct1_url' => 'required|min:3'
        ];

        $ctreq1_menu = json_decode($request->ct1_menu, true);
        foreach($ctreq1_menu as $ct1_req){
            $childtbrequest1_menu = new \Illuminate\Http\Request();
            $childtbrequest1_menu->replace($ct1_req);
            $ctmessages1_menu = [
                'required' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus diisi!!',
                'min' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' minimal :min karakter!!',
                'unique' => ':attribute No '.$ct1_req["ct1_m_sequence"].' sudah dipakai!',
                'max' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' maksimal :max karakter!!',
                'digits' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus angka dengan panjang karakter :digits!!',
                'integer' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' harus berupa angka!!',
                'in' => 'Field :attribute No '.$ct1_req["ct1_m_sequence"].' dengan value '.$ct1_req["ct1_is_shown_at_side_menu"].' tidak ada di pilihan!!'
            ];
            $childtbrequest1_menu->validate($ctrule1_menu, $ctmessages1_menu);
        }
        
        if($request->validate($rules, $messages)){
            Menu::where("id", $id)->update([
                'mp_sequence'=> $request->mp_sequence,
                'm_sequence'=> 0,
                'menu_name'=> $request->menu_name,
                'url'=> $request->url,
                'menu_icon'=> $request->menu_icon,
                'is_group_menu' => count($ctreq1_menu) > 0? 'on':null,
                'is_shown_at_side_menu'=> $request->is_shown_at_side_menu == 1 ? 'on': ($request->is_shown_at_side_menu == 'on'? 'on': null),
                'is_view'=> $request->is_view == 1 ? 'on': ($request->is_view == 'on'? 'on': null),
                'user_updater_id' => Auth::user()->id
            ]);

            User_menu::where("menu_id", $id)->update([
                'mp_sequence'=> $request->mp_sequence,
                'm_sequence'=> 0,
                'menu_name'=> $request->menu_name,
                'url'=> $request->url,
                'menu_icon'=> $request->menu_icon,
                'is_group_menu' => count($ctreq1_menu) > 0? 'on':null,
                'is_shown_at_side_menu'=> $request->is_shown_at_side_menu == 1 ? 'on': ($request->is_shown_at_side_menu == 'on'? 'on': null),
                'is_view'=> $request->is_view == 1 ? 'on': ($request->is_view == 'on'? 'on': null),
                'user_updater_id' => Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($ctreq1_menu as $ct1_req){
                if(isset($ct1_req["id"])){
                    Menu::where("id", $ct1_req["id"])->update([
                        'mp_sequence'=> $request->mp_sequence,
                        'm_sequence'=> $ct1_req["ct1_m_sequence"],
                        'menu_name'=> $ct1_req["ct1_menu_name"],
                        'url'=> $ct1_req["ct1_url"],
                        'menu_icon'=> $ct1_req["ct1_menu_icon"],
                        'is_group_menu' => null,
                        'is_shown_at_side_menu'=> $ct1_req["ct1_is_shown_at_side_menu"] == 1 ? 'on': ($ct1_req["ct1_is_shown_at_side_menu"] == 'on'? 'on':null),
                        'parent_id' => $id,
                        'is_view'=> $ct1_req["ct1_is_view"] == 1 ? 'on': ($ct1_req["ct1_is_view"] == 'on'? 'on': null),
                        'mainmenu'=> $ct1_req["ct1_mainmenu"],
                        'user_updater_id' => Auth::user()->id
                    ]);

                    User_menu::where("menu_id", $ct1_req["id"])->update([
                        'mp_sequence'=> $request->mp_sequence,
                        'm_sequence'=> $ct1_req["ct1_m_sequence"],
                        'menu_name'=> $ct1_req["ct1_menu_name"],
                        'url'=> $ct1_req["ct1_url"],
                        'menu_icon'=> $ct1_req["ct1_menu_icon"],
                        'is_group_menu' => null,
                        'is_shown_at_side_menu'=> $ct1_req["ct1_is_shown_at_side_menu"] == 1 ? 'on': ($ct1_req["ct1_is_shown_at_side_menu"] == 'on'? 'on':null),
                        'parent_id' => $id,
                        'is_view'=> $ct1_req["ct1_is_view"] == 1 ? 'on': ($ct1_req["ct1_is_view"] == 'on'? 'on': null),
                        'mainmenu'=> $ct1_req["ct1_mainmenu"],
                        'user_updater_id' => Auth::user()->id
                    ]);
                }else{
                    $idct = Menu::create([
                        'mp_sequence'=> $request->mp_sequence,
                        'm_sequence'=> $ct1_req["ct1_m_sequence"],
                        'menu_name'=> $ct1_req["ct1_menu_name"],
                        'url'=> $ct1_req["ct1_url"],
                        'menu_icon'=> $ct1_req["ct1_menu_icon"],
                        'is_group_menu' => null,
                        'is_shown_at_side_menu'=> $ct1_req["ct1_is_shown_at_side_menu"] == 1 ? 'on': ($ct1_req["ct1_is_shown_at_side_menu"] == 'on'? 'on':null),
                        'parent_id' => $id,
                        'is_view'=> $ct1_req["ct1_is_view"] == 1 ? 'on': ($ct1_req["ct1_is_view"] == 'on'? 'on': null),
                        'mainmenu'=> $ct1_req["ct1_mainmenu"],
                        'user_creator_id' => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Menu::whereParentId($id)->get() as $ch){
                $is_still_exist = false;
                foreach($ctreq1_menu as $ct_request){
                    if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                        $is_still_exist = true;
                    }
                }
                if(!$is_still_exist){
                    Menu::whereId($ch->id)->delete();
                }
            }
            
            return response()->json([
                'status' => 201,
                'message' => 'ID '.$id.' successfully updated',
                'data' => ['id' => $id]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $menu = Menu::whereId($request->id)->first();
            if(!$menu){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Menu::whereId($request->id)->forceDelete()){
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
        //if Manager Optima, he can approve the submitted. if the submission were submitted, the submit button will disapear. And the order of submission is not not yet submitted first
        $list_column = array("id", "mp_sequence", "m_sequence", "menu_name", "url", "menu_icon", "is_shown_at_side_menu");
		$keyword = null;
		if(isset($request->search["value"])){
			$keyword = $request->search["value"];
		}
		
		if(isset($code_id) && $code_id != ""){
			$keyword = $code_id;
		}
		
		$orders = array('mp_sequence', 'ASC');
		if(isset($request->order)){
			$orders = array($list_column[$request->order['0']['column']], $request->order['0']['dir']);
		}
		
		$limit = null;
		if(isset($request->length) && $request->length != -1){
			$limit = array(intval($request->start), intval($request->length));
		}
		
        $dt = array();
        $no = 0;
        foreach(Menu::whereNull('parent_id')->where(function($q) use ($keyword) {
            $q->where('menu_name', 'like', '%'.$keyword.'%')
                ->orWhere('url', 'like', '%'.$keyword.'%');
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get($list_column) as $menu){
            $no = $no+1;
            $act = '
            <a href="/menu/'.$menu->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>
            
            <a href="/menu/'.$menu->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>
            
            <button type="button" class="btn btn-danger row-delete">
                <i class="fas fa-minus-circle text-white"></i>
            </button>';
            //array_push($dt, array($no+$limit[0], $menu->nama, $menu->email, $act));
            array_push($dt, array($menu->id, $menu->mp_sequence, $menu->m_sequence, $menu->menu_name, $menu->url, isset($menu->menu_icon) ? '<i class="fa '.$menu->menu_icon.'"></i>':'', $menu->is_shown_at_side_menu == 1? '&#10003;': ($menu->is_shown_at_side_menu == 'on'?'&#10003;':''), $act));
        }
		$output = array(
			"draw"    => intval($request->draw),
			"recordsTotal"  =>  Menu::whereNull('parent_id')->get()->count(),
			"recordsFiltered" => intval(Menu::whereNull('parent_id')->where(function($q) use ($keyword){
                $q->where('menu_name', 'like', '%'.$keyword.'%')
                    ->orWhere('url', 'like', '%'.$keyword.'%');
            })->orderBy($orders[0], $orders[1])->get()->count()),
            //$this->submission_model->nDataOngoing($keyword, $orders)
			"data"    => $dt
		);
		
		echo json_encode($output);
    }

    public function getdata(Request $request)
    {
       if($request->ajax() || $request->wantsJson()){
            $menu = Menu::whereId($request->id)->first();
            if(!$menu){
                abort(404, "Data not found");
            }
            $ct1_menu = Menu::whereParentId($request->id)->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "menu" => $menu,
                    "ct1_menu" => $ct1_menu
                ]
            );

            return response()->json($results);
        }
    }

    public function getchildtablefields(Request $request)
    {
        $page_data = $this->tabledesign();
        if($request->fieldname && $page_data["fieldschildtable"][$request->fieldname]){
            return response()->json($page_data["fieldschildtable"][$request->fieldname]);
        }else{
            return response()->json();
        }
    }
}
