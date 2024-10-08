<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use URL;
use App\Models\User_role_menu;

class CheckauthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user() == null){
            return redirect()->to('logout');
        }else{
            $current_url = str_replace(URL::to('/')."/", "", URL::current());
            
            $url_part = explode("/", $current_url);
            
            //$usermenus = Auth::user()->getUserMenu;
            $usermenus = User_role_menu::where("role", Auth::user()->role)
            ->leftJoin("menus", "menus.id", "=", "user_role_menus.menu_id")
            ->select(["menus.url", "user_role_menus.is_granted", "menus.mainmenu"])->get();
            $is_granted = false;
            $is_exist = false;
            foreach($usermenus as $um){
                if(count($url_part) > 1){
                    $um->url = str_replace("{".$um->mainmenu."}", $url_part[1], $um->url);
                
                    if($current_url == $um->url){
                        $is_exist = true;
                        if($um->is_granted == 'on'){
                            $is_granted = true;
                        }
                    }
                }
            }
            
            if($is_exist && !$is_granted){
                abort(403);
            }
        }
            
        // if(Auth::user()->role != "admin"){
        //     /* 
        //     silahkan modifikasi pada bagian ini
        //     apa yang ingin kamu lakukan jika rolenya tidak sesuai
        //     */
        //     return redirect()->to('logout');
        // }
        return $next($request);
    }
}
