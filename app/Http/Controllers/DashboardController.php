<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\Transaction;
use Session;

class DashboardController extends Controller
{
    public function tabledesign(){
        $td = [
            "page_data_name" => "DSS",
            "page_data_urlname" => "dss",
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
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_list"];
        
        return view("labarugi.list", ["page_data" => $page_data]);
    }

    public function dss(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "";
        $page_data["category"] = "dss";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_dss"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_dss"];
        
        return view("dashboard.dss", ["page_data" => $page_data]);
    }

    public function neraca(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "";
        $page_data["category"] = "neraca";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_dss"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_dss"];
        
        return view("dashboard.dss", ["page_data" => $page_data]);
    }

    public function labarugi(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["category"] = "labarugi";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_dss"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_dss"];
        
        // return view("dashboard.chart", ["page_data" => $page_data]);
        return view("dashboard.dss", ["page_data" => $page_data]);
    }

    public function get_transaction(Request $request){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_list"];

        $bulan_periode = (int) date('m');
        $tahun_periode = (int) date('Y');
        // dd($bulan_periode, $tahun_periode);

        $debet = array("aset","biaya","biaya_lainnya");
        $category = $request->category;
        
        $dt = array();
        $yearopen = Session::get('global_setting');
        $periode = "";
        foreach(Transaction::select([ "transactions.unitkerja_label", "coas.category", "anggaran_label", "tanggal", "jenis_transaksi", "transactions.coa_label", "transactions.jenisbayar_label", "kode_va", DB::raw("debet-credit as nominal_dc"), DB::raw("credit-debet as nominal_cd")])
        ->leftJoin('coas', 'transactions.coa', '=', 'coas.id')
        ->where(function($q) use($category){
            if($category == 'labarugi'){
                $q->whereIn('coas.category',['pendapatan', 'biaya', 'biaya_lainnya', 'pendapatan_lainnya']);
            } else if($category == 'neraca') {
                $q->whereIn('coas.category',['aset','hutang','modal']);
            }
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->whereMonth("tanggal", ">=", $yearopen->bulan_tutup_tahun)->whereMonth("tanggal", "<=", $bulan_periode)->whereYear("tanggal", $tahun_periode);
                });
            } else {
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->whereMonth("tanggal", "<=", $bulan_periode)->whereYear("tanggal", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->whereMonth("tanggal", ">", $yearopen->bulan_tutup_tahun)->whereYear("tanggal", $tahun_periode-1);
                });
            }
        })->get()
         as $data){
            array_push($dt, array(
                "Unit Kerja" => $data->unitkerja_label, 
                "Kode Anggaran" => $data->anggaran_label, 
                "Tahun" => date("Y",strtotime($data->tanggal)), 
                "Bulan" => date("m",strtotime($data->tanggal)), 
                "Jenis Transaksi" => $data->jenis_transaksi, 
                "Kategori" => $data->category,
                "COA" => $data->coa_label, 
                "Jenis Bayar" => $data->jenisbayar_label, 
                "Kode VA" => $data->kode_va, 
                // "Nominal" => $data->nominal
                "Nominal" => in_array($data->category,$debet) ? $data->nominal_dc : $data->nominal_cd
            ));
        }

        $bulan_tutup = (int)$yearopen->bulan_tutup_tahun;
        dd($bulan_tutup);
        if($bulan_periode >= $bulan_tutup){
            $periode = $this->convertBulan($bulan_tutup) . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        } else {
            $periode = $this->convertBulan($bulan_tutup) . " " . $tahun_periode-1 . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        }
        // dd($dt);
        $output = array(
            "data" => $dt,
            "periode" => $periode
        );

        echo json_encode($output);
    }

    public function get_list(Request $request)
    {
        $bulan_periode = 1;
        if(isset($request->search["bulan_periode"])){
            $bulan_periode = $request->search["bulan_periode"];
        }
        $tahun_periode = 1;
        if(isset($request->search["tahun_periode"])){
            $tahun_periode = $request->search["tahun_periode"];
        }
        $child_level = 1;
        if(isset($request->search["child_level"])){
            $child_level = $request->search["child_level"];
        }

        $dt = array();
        $no = 0;
        $sum_nom = 0;
        $yearopen = Session::get('global_setting');
        foreach(Coa::find(1)
        ->select([ "coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader", DB::raw("SUM(labarugis.debet) as debet"), DB::raw("SUM(labarugis.credit) as credit")]) //"neracas.debet", "neracas.credit"])//DB::raw("SUM(neracas.debet) as debet"), DB::raw("SUM(neracas.credit) as credit")])
        ->leftJoin('labarugis', 'coas.id', '=', 'labarugis.coa')
        ->whereIn('coas.category',["pendapatan", "biaya", "biaya_lainnya", "pendapatan_lainnya"])
        ->where(function($q){
            $q->where(function($q){
                $q->where("labarugis.debet","!=",0)->orWhere("labarugis.credit","!=",0);
            })
            ->orWhere(function($q){
                $q->where("coas.fheader","on");
            });  
        })
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            }else{
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
            $q->orWhere(function($q){
                $q->whereNull("bulan_periode");
            });  
        })
        ->groupBy(["coas.id", "coas.coa_name", "coas.coa_code", "coas.coa", "coas.level_coa", "coas.fheader"])
        ->orderBy("coas.level_coa", "desc")
          ->get() as $neraca){
            
            $no = $no+1;
            
            $nom = abs($neraca->debet - $neraca->credit);
            $sum_nom += $nom;
            
            $dt[$neraca->id] = array($neraca->id, $neraca->coa_code, $neraca->coa_name, $nom, $nom, $neraca->coa, $neraca->level_coa, $neraca->fheader);
        }
        

        // get nominal
        $iter = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0) && ($dt[7] != "on");
        });
        
        // sum nominal to header
        foreach($iter as $key => $item){
            $d = $item;
            $deb = $item[3];
            $cre = $item[4];
            for($i=$d[6] ; $i>1 ; $i--){
                $dt[$d[5]][3] = (int) $dt[$d[5]][3] + $deb;
                $dt[$d[5]][4] = (int) $dt[$d[5]][4] + $cre;
                $d = $dt[$d[5]];
            }
        }
        // remove null value
        $dt = array_filter($dt, function ($dt) {
            return ($dt[3] != 0) || ($dt[4] != 0);
            // return $dt;
        });
        // leveling
        if($child_level==0){
            $dt = array_filter($dt, function ($dt) use ($child_level) {
                return ((int)$dt[6] <= 1);
            });
        }
        
        // sort by code
        $columns = array_column($dt, 1);
        array_multisort($columns, SORT_ASC, $dt);
        // convert array
        $dt = array_values($dt);

        $labels = array_column($dt, 2);
        $noms = array_column($dt, 3);
        $perc = array_map( function($val) use($sum_nom) { return ($val / $sum_nom)*100; }, $noms);
        $perc = array_values($perc);


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $perc,
            "label" => $labels
        );

        echo json_encode($output);
    }

    public function convertBulan($bulan){
        $nmb = "";
        switch(date("F", mktime(0, 0, 0, $bulan, 10)))
        {
            case 'January':     $nmb="Januari";     break; 
            case 'February':    $nmb="Februari";    break; 
            case 'March':       $nmb="Maret";       break; 
            case 'April':       $nmb="April";       break; 
            case 'May':         $nmb="Mei";         break; 
            case 'June':        $nmb="Juni";        break; 
            case 'July':        $nmb="Juli";        break;
            case 'August':      $nmb="Agustus";     break;
            case 'September':   $nmb="September";   break;
            case 'October':     $nmb="Oktober";     break;
            case 'November':    $nmb="November";    break;
            case 'December':    $nmb="Desember";    break;
        }
        return $nmb;
    }
}