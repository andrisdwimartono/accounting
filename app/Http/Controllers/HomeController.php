<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
  
class HomeController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Home",
            "page_data_urlname" => "home"
        ];
        return $td;
    }
    public function index()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Home";
        $page_data["footer_js_page_specific_script"] = ["paging.page_specific_script.footer_js_home"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];

        return view('home', ['page_data' => $page_data]);
    }
    public function test()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Home";
        $page_data["footer_js_page_specific_script"] = ["paging.page_specific_script.footer_js_home"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];

        return view('form-element', ['page_data' => $page_data]);
    }
}