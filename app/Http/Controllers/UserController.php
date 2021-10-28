<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Validator;
use Hash;
use Session;

class UserController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "User",
            "page_data_urlname" => "user",
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

        $td["fieldsoptions"] = [
            "role" => [
                ["name" => "admin", "label" => "Administrator"],
                ["name" => "manager", "label" => "Manager"],
                ["name" => "selling", "label" => "Selling Staf"],
                ["name" => "purchasing", "label" => "Purchasing Staf"],
                ["name" => "sellingandpurchasing", "label" => "Selling and Purhcasing Staf"]
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
        $page_data["footer_js_page_specific_script"] = ["paging.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_list"];
        
        return view("user.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["user.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("user.create", ["page_data" => $page_data]);
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
            $id = User::create([
                "name"=> $request->name,
                "company_id" => Auth::user()->company_id,
                "email"=> $request->email,
                "phone"=> $request->phone,
                "password"=> Hash::make($request->password),
                "photo_profile"=> $request->photo_profile,
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
    public function show(User $user)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["user.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $user->id;
        return view("user.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["user.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $user->id;
        return view("user.create", ["page_data" => $page_data]);
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
            User::where("id", $id)->update([
                "name"=> $request->name,
                "email"=> $request->email,
                "phone"=> $request->phone,
                "password"=> Hash::make($request->password),
                "photo_profile"=> $request->photo_profile,
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
        if($request->ajax()){
            $user = User::whereId($request->id)->first();
            if(!$user){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(User::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "name", "email");
		$keyword = null;
		if(isset($request->search["value"])){
			$keyword = $request->search["value"];
		}
		
		if(isset($code_id) && $code_id != ""){
			$keyword = $code_id;
		}
		
		$orders = array('id', 'ASC');
		if(isset($request->order)){
			$orders = array($list_column[$request->order['0']['column']], $request->order['0']['dir']);
		}
		
		$limit = null;
		if(isset($request->length) && $request->length != -1){
			$limit = array(intval($request->start), intval($request->length));
		}
		
        $dt = array();
        $no = 0;
        foreach(User::where(function($q) use ($keyword) {
            $q->where('name', 'like', '%'.$keyword.'%')
                ->orWhere('email', 'like', '%'.$keyword.'%');
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get($list_column) as $user){
            $no = $no+1;
            $act = '
            <a href="/assignmenu/'.$user->id.'/edit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign Menus to this user"><i class="fas fa-bars text-white"></i></a>

            <a href="/user/'.$user->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>
            
            <a href="/user/'.$user->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>
            
            <button type="button" class="btn btn-danger row-delete">
                <i class="fas fa-minus-circle text-white"></i>
            </button>';
            //array_push($dt, array($no+$limit[0], $user->nama, $user->email, $act));
            array_push($dt, array($user->id, $user->name, $user->email, $act));
        }
		$output = array(
			"draw"    => intval($request->draw),
			"recordsTotal"  =>  User::get()->count(),
			"recordsFiltered" => intval(User::where(function($q) use ($keyword) {
                $q->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('email', 'like', '%'.$keyword.'%');
            })->orderBy($orders[0], $orders[1])->get()->count()),
			"data"    => $dt
		);
		
		echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax()){
            $user = User::whereId($request->id)->first();
            if(!$user){
                abort(404, "Data not found");
            }


            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "user" => $user
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
        if ($request->ajax()){
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

    public function storeUploadFile(Request $request){
        if($request->ajax()){
            $input = $request->all();
            $input['file'] = $request->menname.time().'.'.$request->file->getClientOriginalExtension();
            $request->file->move(public_path($request->menname), $input['file']);

            return response()->json([
                "status" => 200,
                "message" => "Upload successfully",
                "filename" => $input['file']
            ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function editprofile()
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["user.page_specific_script.footer_js_editprofile"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = Auth::user()->id;
        return view("user.create", ["page_data" => $page_data]);
    }

    public function updateprofile(Request $request)
    {
        $page_data = $this->tabledesign();
        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            User::where("id", Auth::user()->id)->update([
                "name"=> $request->name,
                "email"=> $request->email,
                "phone"=> $request->phone,
                "password"=> Hash::make($request->password),
                "photo_profile"=> $request->photo_profile,
                "user_updater_id"=> Auth::user()->id
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Profile is updated',
                'data' => ['id' => Auth::user()->id]
            ]);
        }
    }

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('appToken')->accessToken;
           //After successfull authentication, notice how I return json parameters
            return response()->json([
              'success' => true,
              'token' => $success,
              'user' => $user
          ]);
        } else {
       //if authentication is unsuccessfull, notice how I return json parameters
          return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
    }

    /**
     * Register api.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|unique:users|regex:/(0)[0-9]{10}/',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
          return response()->json([
            'success' => false,
            'message' => $validator->errors(),
          ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;
        return response()->json([
            'success' => true,
            'token' => $success,
            'user' => $user
        ]);
    }

    public function logout(Request $res)
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
        }else {
            return response()->json([
            'success' => false,
            'message' => 'Unable to Logout'
            ]);
        }
     }
}
