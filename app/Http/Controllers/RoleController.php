<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Menu;
use App\Models\User_role_menu;

class RoleController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Role",
            "page_data_urlname" => "role",
            "fields" => [
                "nama" => "text",
                "alias" => "text"
            ],
            "fieldschildtable" => [
            ]
        ];

        $td["fieldsrules"] = [
            "nama" => "required|min:1|max:100|unique:roles,nama",
            "alias" => "required|min:2|max:25|unique:roles,alias"
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
        $page_data["footer_js_page_specific_script"] = ["role.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["role.page_specific_script.header_js_list"];
        
        return view("role.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["role.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("role.create", ["page_data" => $page_data]);
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
            $id = role::create([
                "nama"=> $request->nama,
                "alias"=> $request->alias,
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
    public function show(role $role)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["role.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $role->id;
        return view("role.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(role $role)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["role.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $role->id;
        return view("role.create", ["page_data" => $page_data]);
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
        $rules["nama"] = $rules["nama"].",".$id;
        $rules["alias"] = $rules["alias"].",".$id;
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            role::where("id", $id)->update([
                "nama"=> $request->nama,
                "alias"=> $request->alias,
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
            $role = role::whereId($request->id)->first();
            if(!$role){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(role::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "nama", "alias");
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
        // dd(role::find(1)->get());
        foreach(role::where(function($q) use ($keyword) {
            $q->where("nama", "ILIKE", "%" . $keyword. "%")->orWhere("alias", "ILIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "nama", "alias"]) as $role){
            $no = $no+1;
            $act = '
            <a href="/assignmenurole/'.$role->alias.'/edit"  class="btn btn-success shadow btn-xs sharp"   data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Menus to this role"><i class="fa fa-bars"></i></a>

            <a href="/role/'.$role->id.'" class="btn btn-info shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fa fa-eye"></i></a>

            <a href="/role/'.$role->id.'/edit" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User Data"><i class="fa fa-edit"></i></a>

            <a class="row-delete btn btn-danger shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User"><i class="fa fa-trash"></i></a>';
            

            array_push($dt, array($role->id, $role->nama, $role->alias, $act));
    }
        // dd($dt);
    
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => role::get()->count(),
            "recordsFiltered" => intval(role::where(function($q) use ($keyword) {
                $q->where("nama", "ILIKE", "%" . $keyword. "%")->orWhere("alias", "ILIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $role = role::whereId($request->id)->first();
            if(!$role){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "role" => $role
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

    public function assignmenu($role)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["user.page_specific_script.assignmenu_footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $role;
        $menus = Menu::orderBy("mp_sequence", "ASC")->orderBy("m_sequence", "ASC")->get();
        return view('user.assignmenu', ['page_data' => $page_data, 'menus' => $menus]);
    }

    public function getdataassignmenurole(Request $request)
    {
       if($request->ajax() || $request->wantsJson()){
            $user_menus = User_role_menu::whereRole($request->id)->get();
            if(!$user_menus){
                abort(404, "Data not found");
            }

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "user_menus" => $user_menus,
                    "user" => [
                        "role" => $request->id
                    ]
                ]
            );

            return response()->json($results);
        }
    }

    public function updateassignmenu(Request $request, $role)
    {
        $page_data = $this->tabledesign();
        
        
        foreach(Menu::whereNull("is_group_menu")->get() as $menu){
            if(User_role_menu::where("role", $role)->where("menu_id", $menu->id)->first()){
                User_role_menu::where("role", $role)->where("menu_id", $menu->id)->update([
                    "is_granted" => $request["menu_".$menu->id],
                ]);
            }else{
                User_role_menu::create([
                    "role" => $role,
                    "menu_id" => $menu->id,
                    "is_granted" => $request["menu_".$menu->id],
                ]);
            }
        }

        foreach(Menu::whereNotNull("is_group_menu")->get() as $menu){
            if(User_role_menu::where("role", $role)->where("is_granted", 'on')){
                if(User_role_menu::where("role", $role)->where("menu_id", $menu->id)->first()){
                    User_role_menu::where("role", $role)->where("menu_id", $menu->id)->update([
                        "is_granted" => 'on',
                    ]);
                }else{
                    User_role_menu::create([
                        "role" => $role,
                        "menu_id" => $menu->id,
                        "is_granted" => $request["menu_".$menu->id],
                    ]);
                }
            }else{
                if(User_role_menu::where("role", $role)->where("menu_id", $menu->id)->first()){
                    User_role_menu::where("role", $role)->where("menu_id", $menu->id)->update([
                        "is_granted" => null,
                    ]);
                }else{
                    User_role_menu::create([
                        "role" => $role,
                        "menu_id" => $menu->id,
                        "is_granted" => $request["menu_".$menu->id],
                    ]);
                }
            }
        }
            
        return response()->json([
            'status' => 201,
            'message' => 'ID '.$role.' successfully updated',
            'data' => ['id' => $role]
        ]);
        
    }

    public function getRoleMenu(){
        if(Auth::user()){
            // dd(Auth::user()->role_label);
            $user_menus = User_role_menu::find(1)
            ->select(['menus.*'])
            ->leftJoin('menus','menus.id','user_role_menus.menu_id')
            ->where("role",Auth::user()->role_label)->where("is_granted", "on")
            ->where("is_shown_at_side_menu", "on")->orderBy("mp_sequence", "ASC")->orderBy("m_sequence", "ASC")
            ->get();

            if(!$user_menus){
                abort(404, "Data not found");
            }

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "user_menus" => $user_menus
                ]
            );

            return response()->json($results);
        }
    }
}
