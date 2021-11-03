<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Unitkerja;
use App\Models\Transactiondetail;
use App\Models\Coa;

class TransactionController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "Transaksi",
            "page_data_urlname" => "transaction",
            "fields" => [
                "unitkerja" => "link",
                "journal_number" => "text",
                "anggaran_name" => "text",
                "transaction_date" => "date",
                "description" => "textarea",
                "transaction_type" => "select",
                "transaction_detail" => "childtable"
            ],
            "fieldschildtable" => [
                "transaction_detail" => [
                    "coa" => "link",
                    "description" => "text",
                    "debet" => "float",
                    "credit" => "float",
                    "va_code" => "text"
                ]
            ],
            "fieldsoptions" => [
                "transaction_type" => [
                    ["name" => "jt1", "label" => "JT 1"],
                    ["name" => "jt2", "label" => "JT 2"],
                    ["name" => "jt3", "label" => "JT 3"]
                ]
            ],
            "fieldlink" => [
                "unitkerja" => "unitkerjas",
                "coa" => "coas"
            ]
        ];

        $transaction_type_list = "jt1,jt2,jt3";

        $td["fieldsrules"] = [
            "unitkerja" => "required|exists:unitkerjas,id",
            "journal_number" => "required|min:1|max:25",
            "anggaran_name" => "max:255",
            "transaction_date" => "required|date_format:d/m/Y",
            "description" => "max:255",
            "transaction_type" => "in:jt1,jt2,jt3",
            "transaction_detail" => "required"
        ];

        $td["fieldsmessages"] = [
            "required" => ":attribute harus diisi!!",
            "min" => ":attribute minimal :min karakter!!",
            "max" => ":attribute maksimal :max karakter!!",
            "in" => "Tidak ada dalam pilihan :attribute!!",
            "exists" => "Tidak ada dalam :attribute!!",
            "date_format" => "Format tidak sesuai di :attribute!!"
        ];

        $td["fieldsrules_transaction_detail"] = [
            "coa" => "required|exists:coas,id",
            "description" => "max:255",
            "debet" => "required|numeric",
            "credit" => "required|numeric",
            "va_code" => "max:255"
        ];

        $td["fieldsmessages_transaction_detail"] = [
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
        $page_data["footer_js_page_specific_script"] = ["transaction.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_list"];
        
        return view("transaction.list", ["page_data" => $page_data]);
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
        $page_data["footer_js_page_specific_script"] = ["transaction.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        return view("transaction.create", ["page_data" => $page_data]);
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
        $rules_transaction_detail = $page_data["fieldsrules_transaction_detail"];
        $requests_transaction_detail = json_decode($request->transaction_detail, true);
        $debet_total = 0;
        $credit_total = 0;
        foreach($requests_transaction_detail as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaction_detail"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaction_detail, $ct_messages);
            $debet_total += $ct_request["debet"];
            $credit_total += $ct_request["credit"];
        }

        if($debet_total != $credit_total){
            abort(401, "debet Credit is not balanced");
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];

        $transaction_number = Transaction::where("unitkerja", $request->unitkerja)->get()->count()+1;
        $transaction_number = (string) $transaction_number;
        $journalunitkerja = array("", "RE", "MA", "UA", "AM");
        $journalnum = $journalunitkerja[$request->unitkerja];
        for($x = 0; $x < 8-(strlen($transaction_number)); $x++){
            $journalnum = $journalnum."0";
        }
        $journalnum = $journalnum.$transaction_number;
        
        if($request->validate($rules, $messages)){
            $id = Transaction::create([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "journal_number"=> $journalnum,
                "anggaran_name"=> $request->anggaran_name,
                "transaction_date"=> $request->transaction_date?\Carbon\Carbon::createFromFormat('d/m/Y', $request->transaction_date)->format('Y-m-d'):null,
                "description"=> $request->description,
                "transaction_type"=> $request->transaction_type,
                "transaction_type_label"=> $request->transaction_type_label,
                "user_creator_id"=> Auth::user()->id
            ])->id;

            foreach($requests_transaction_detail as $ct_request){
                Transactiondetail::create([
                    "no_seq" => $ct_request["no_seq"],
                    "parent_id" => $id,
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "description"=> $ct_request["description"],
                    "debet"=> $ct_request["debet"],
                    "credit"=> $ct_request["credit"],
                    "va_code"=> $ct_request["va_code"],
                    "user_creator_id" => Auth::user()->id
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
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Transaction $transaction)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "View";
        $page_data["footer_js_page_specific_script"] = ["transaction.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $transaction->id;
        return view("transaction.create", ["page_data" => $page_data]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Transaction $transaction)
    {
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "Update";
        $page_data["footer_js_page_specific_script"] = ["transaction.page_specific_script.footer_js_create"];
        $page_data["header_js_page_specific_script"] = ["paging.page_specific_script.header_js_create"];
        
        $page_data["id"] = $transaction->id;
        return view("transaction.create", ["page_data" => $page_data]);
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
        $rules_transaction_detail = $page_data["fieldsrules_transaction_detail"];
        $requests_transaction_detail = json_decode($request->transaction_detail, true);
        $debet_total = 0;
        $credit_total = 0;
        foreach($requests_transaction_detail as $ct_request){
            $child_tb_request = new \Illuminate\Http\Request();
            $child_tb_request->replace($ct_request);
            $ct_messages = array();
            foreach($page_data["fieldsmessages_transaction_detail"] as $key => $value){
                $ct_messages[$key] = "No ".$ct_request["no_seq"]." ".$value;
            }
            $child_tb_request->validate($rules_transaction_detail, $ct_messages);
            $debet_total += $ct_request["debet"];
            $credit_total += $ct_request["credit"];
        }

        if($debet_total != $credit_total){
            abort(401, "debet Credit is not balanced");
        }

        $rules = $page_data["fieldsrules"];
        $messages = $page_data["fieldsmessages"];
        if($request->validate($rules, $messages)){
            Transaction::where("id", $id)->update([
                "unitkerja"=> $request->unitkerja,
                "unitkerja_label"=> $request->unitkerja_label,
                "journal_number"=> $request->journal_number,
                "anggaran_name"=> $request->anggaran_name,
                "transaction_date"=> $request->transaction_date?\Carbon\Carbon::createFromFormat('d/m/Y', $request->transaction_date)->format('Y-m-d'):null,
                "description"=> $request->description,
                "transaction_type"=> $request->transaction_type,
                "transaction_type_label"=> $request->transaction_type_label,
                "user_updater_id"=> Auth::user()->id
            ]);

            $new_menu_field_ids = array();
            foreach($requests_transaction_detail as $ct_request){
                if(isset($ct_request["id"])){
                    Transactiondetail::where("id", $ct_request["id"])->update([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "description"=> $ct_request["description"],
                    "debet"=> $ct_request["debet"],
                    "credit"=> $ct_request["credit"],
                    "va_code"=> $ct_request["va_code"],
                        "user_updater_id" => Auth::user()->id
                    ]);
                }else{
                    $idct = Transactiondetail::create([
                        "no_seq" => $ct_request["no_seq"],
                        "parent_id" => $id,
                    "coa"=> $ct_request["coa"],
                    "coa_label"=> $ct_request["coa_label"],
                    "description"=> $ct_request["description"],
                    "debet"=> $ct_request["debet"],
                    "credit"=> $ct_request["credit"],
                    "va_code"=> $ct_request["va_code"],
                        "user_creator_id" => Auth::user()->id
                    ])->id;
                    array_push($new_menu_field_ids, $idct);
                }
            }

            foreach(Transactiondetail::whereParentId($id)->get() as $ch){
                    $is_still_exist = false;
                    foreach($requests_transaction_detail as $ct_request){
                        if($ch->id == $ct_request["id"] || in_array($ch->id, $new_menu_field_ids)){
                            $is_still_exist = true;
                        }
                    }
                    if(!$is_still_exist){
                        Transactiondetail::whereId($ch->id)->delete();
                    }
                }

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
            $transaction = Transaction::whereId($request->id)->first();
            if(!$transaction){
                abort(404, "Data not found");
            }
            $results = array(
                "status" => 417,
                "message" => "Deleting failed"
            );
            if(Transaction::whereId($request->id)->forceDelete()){
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
        $list_column = array("id", "unitkerja_label", "journal_number", "transaction_date", "id");
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
        foreach(Transaction::where(function($q) use ($keyword) {
            $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("journal_number", "LIKE", "%" . $keyword. "%")->orWhere("transaction_date", "LIKE", "%" . $keyword. "%");
        })->orderBy($orders[0], $orders[1])->offset($limit[0])->limit($limit[1])->get(["id", "unitkerja_label", "journal_number", "transaction_date"]) as $transaction){
            $no = $no+1;
            $act = '
            <a href="/transaction/'.$transaction->id.'" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="View Detail"><i class="fas fa-eye text-white"></i></a>

            <a href="/transaction/'.$transaction->id.'/edit" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data"><i class="fas fa-edit text-white"></i></a>

            <button type="button" class="btn btn-danger row-delete"> <i class="fas fa-minus-circle text-white"></i> </button>';

            array_push($dt, array($transaction->id, $transaction->unitkerja_label, $transaction->journal_number, $transaction->transaction_date, $act));
    }
        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => Transaction::get()->count(),
            "recordsFiltered" => intval(Transaction::where(function($q) use ($keyword) {
                $q->where("unitkerja_label", "LIKE", "%" . $keyword. "%")->orWhere("journal_number", "LIKE", "%" . $keyword. "%")->orWhere("transaction_date", "LIKE", "%" . $keyword. "%");
            })->orderBy($orders[0], $orders[1])->get()->count()),
            "data" => $dt
        );

        echo json_encode($output);
    }

    public function getdata(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){
            $transaction = Transaction::whereId($request->id)->first();
            if(!$transaction){
                abort(404, "Data not found");
            }

            $transaction->transaction_date = \Carbon\Carbon::createFromFormat('Y-m-d', $transaction->transaction_date)->format('d/m/Y');
            $transaction_details = Transactiondetail::whereParentId($request->id)->get();

            $results = array(
                "status" => 201,
                "message" => "Data available",
                "data" => [
                    "transaction_detail" => $transaction_details,
                    "transaction" => $transaction
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
            if($request->field == "unitkerja"){
                $lists = Unitkerja::where(function($q) use ($request) {
                    $q->where("unitkerja_name", "LIKE", "%" . $request->term. "%");
                })->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("unitkerja_name as text")]);
                $count = Unitkerja::count();
            }elseif($request->field == "coa"){
                $lists = Coa::where(function($q) use ($request) {
                    $q->where("coa_name", "LIKE", "%" . $request->term. "%")->orWhere("coa_code", "LIKE", "%" . $request->term. "%");
                })->whereNull("fheader")->orderBy("id")->skip($offset)->take($resultCount)->get(["id", DB::raw("coa_name as text"), DB::raw("coa_code as coa")]);
                foreach($lists as $string){
                    $length = strlen($string->coa);
                    $val = "";
                    for ($i=0; $i<$length; $i++) {
                        if($i == 0){
                            $val = $val.$string->coa[$i]."-";
                        }else if($i == 2 || $i == 4){
                            $val = $val.$string->coa[$i].".";
                        }else if($i > 4 && ($i-4)%3 == 0){
                            $val = $val.$string->coa[$i].".";
                        }else{
                            $val = $val.$string->coa[$i];
                        }
                    }
                    $string->text = $val." ".$string->text;
                }
                $count = Coa::count();
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
}
