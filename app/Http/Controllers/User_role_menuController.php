<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User_role_menu;
use App\Models\Menu;

use Illuminate\Http\Request;

class User_role_menuController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "User Role",
            "page_data_urlname" => "userrole",
            "fields" => [
                "name" => "text",
                "email" => "text",
                "phone" => "text",
                "password" => "text",
                "photo_profile" => "upload"
            ],
            "fieldschildtable" => [
                
            ]
        ];

        $td["fieldsrules"] = [
            "name" => "required|min:4|max:255",
            "email" => "required|min:4|max:255",
            "phone" => "required|min:4|max:20",
            "password" => "required|min:5|max:100"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_update"] = [
            "name" => "required|min:4|max:255",
            "email" => "required|min:4|max:255",
            "phone" => "required|min:4|max:20",
            "password" => "min:5|max:100"
        ];

        $td["fieldsmessages_update"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsoptions"] = [
            "role" => [
                ["name" => "admin", "label" => "Administrator"],
                ["name" => "direktur", "label" => "Direktur"],
                ["name" => "manager", "label" => "Manager"],
                ["name" => "staffkeuangan", "label" => "Staff Keuangan"],
                ["name" => "staff", "label" => "Staff Umum"],
            ]
        ];

        return $td;
    }

    public function getRoleMenu(){
        if(Auth::user()){
            $user_menus = User_role_menu::find(1)
            ->select(['menus.*'])
            ->leftJoin('menus','menus.id','user_role_menus.menu_id')
            ->where("role",Auth::user()->role)->where("is_granted", "on")
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
}
