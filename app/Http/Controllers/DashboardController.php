<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\Kebijakan;
use App\Models\Transaction;
use App\Models\Neracasaldo;
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

    public function fuzzy(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "";
        $page_data["category"] = "dss";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_fuzzy"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_dss"];
        
        return view("dashboard.fuzzy", ["page_data" => $page_data]);
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

    public function labarugichart(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["category"] = "labarugi";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_list"];
        
        return view("dashboard.chart", ["page_data" => $page_data]);
    }

    public function neracachart(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["category"] = "neraca";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_list"];
        
        return view("dashboard.chart", ["page_data" => $page_data]);
    }

    public function neracasaldochart(){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["category"] = "neracasaldo";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_list"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_list"];
        
        return view("dashboard.chart", ["page_data" => $page_data]);
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
        foreach(Neracasaldo::select([ "neracasaldos.unitkerja_label", "coas.category", "bulan_periode", "tahun_periode", "neracasaldos.coa_label", "neracasaldos.jenisbayar_label", DB::raw("debet-credit as nominal_dc"), DB::raw("credit-debet as nominal_cd")])
        ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
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
                    $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            } else {
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
        })->get()
         as $data){
            array_push($dt, array(
                "Unit Kerja" => $data->unitkerja_label, 
                // "Kode Anggaran" => $data->anggaran_label, 
                "Tahun" => $data->tahun_periode, 
                "Bulan" => $data->bulan_periode, 
                // "Jenis Transaksi" => $data->jenis_transaksi, 
                "Kategori" => $data->category,
                "COA" => $data->coa_label, 
                "Jenis Bayar" => $data->jenisbayar_label, 
                // "Kode VA" => $data->kode_va, 
                // "Nominal" => $data->nominal
                "Nominal" => in_array($data->category,$debet) ? $data->nominal_dc : $data->nominal_cd
            ));
        }

        $tahun_periode = (int)$tahun_periode;
        $bulan_tutup = (int)$yearopen->bulan_tutup_tahun;
        
        if($bulan_periode >= $bulan_tutup){
            $periode = $this->convertBulan($bulan_tutup) . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        } else {
            $periode = $this->convertBulan($bulan_tutup) . " " . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        }
        $output = array(
            "data" => $dt,
            "periode" => $periode
        );

        echo json_encode($output);
    }

    public function get_data_fuzzy(Request $request){
        $page_data = $this->tabledesign();
        $page_data["page_method_name"] = "List";
        $page_data["footer_js_page_specific_script"] = ["dashboard.page_specific_script.footer_js_fuzzy"];
        $page_data["header_js_page_specific_script"] = ["dashboard.page_specific_script.header_js_fuzzy"];

        $bulan_periode = (int) date('m');
        $tahun_periode = (int) date('Y');
        // dd($bulan_periode, $tahun_periode);

        $debet = array("aset","biaya","biaya_lainnya");
        $category = $request->category;
        
        $dt = array();
        $yearopen = Session::get('global_setting');
        $periode = "";
        foreach(Neracasaldo::select([ "neracasaldos.unitkerja_label", "coas.level_coa","coas.category", "bulan_periode", "tahun_periode", "neracasaldos.coa_label", "neracasaldos.jenisbayar_label", DB::raw("debet-credit as nominal_dc"), DB::raw("credit-debet as nominal_cd")])
        ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
        ->where(function($q) use($category){
            if($category == 'pendapatan'){
                $q->whereIn('coas.category',['aset','pendapatan', 'pendapatan_lainnya','modal']);
            } else if($category == 'pengeluaran') {
                $q->whereIn('coas.category',['hutang','biaya', 'biaya_lainnya']);
            }
        })
        ->where('coas.level_coa',2)
        ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
            // dd($yearopen);
            if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                //only one year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                });
            } else {
                //cross year
                $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                    $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                });
            }
        })->get()
         as $data){
            array_push($dt, array(
                "Unit Kerja" => $data->unitkerja_label, 
                // "Kode Anggaran" => $data->anggaran_label, 
                "Tahun" => $data->tahun_periode, 
                "Bulan" => $data->bulan_periode, 
                // "Jenis Transaksi" => $data->jenis_transaksi, 
                "Kategori" => $data->category,
                "COA" => $data->coa_label, 
                "level" => $data->level_coa, 
                "Jenis Bayar" => $data->jenisbayar_label, 
                // "Kode VA" => $data->kode_va, 
                // "Nominal" => $data->nominal
                "Nominal" => in_array($data->category,$debet) ? $data->nominal_dc : $data->nominal_cd
            ));
        }

        $tahun_periode = (int)$tahun_periode;
        $bulan_tutup = (int)$yearopen->bulan_tutup_tahun;
        
        if($bulan_periode >= $bulan_tutup){
            $periode = $this->convertBulan($bulan_tutup) . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        } else {
            $periode = $this->convertBulan($bulan_tutup) . " " . " - " . $this->convertBulan($bulan_periode) . " " . $tahun_periode;
        }
        $output = array(
            "data" => $dt,
            "periode" => $periode
        );

        echo json_encode($output);
    }

    public function roe(){
        $bulan_periode = (int) date('m');
        $tahun_periode = (int) date('Y');

        $debet = array("aset","biaya","biaya_lainnya");
        
        $dt = array();
        $yearopen = Session::get('global_setting');
        $periode = "";
        $pendapatan = Neracasaldo::select([ DB::raw("SUM(credit-debet) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','pendapatan')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $biaya = Neracasaldo::select([ DB::raw("SUM(debet-credit) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','biaya')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $modal = Neracasaldo::select([ DB::raw("SUM(credit-debet) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','modal')
            ->where('coas.coa_code','30300000')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $pendapatan = isset($pendapatan->nominal) ? $pendapatan->nominal : 0;
        $biaya = isset($biaya->nominal) ? $biaya->nominal : 0;
        $modal = isset($modal->nominal) ? $modal->nominal : 0;
        $roe = 0;
        if($modal != 0){
            $roe = ($pendapatan-$biaya) / $modal;
        }
        $roe = (float) number_format((float)$roe, 2, '.', '');
        
        $klas = 0;
        if($roe>=0 && $roe < 0.3){
            $klas = 0;
        } elseif($roe < 0.6) {
            $klas = 1;
        } else {
            $klas = 2;
        }

        $output = array(
            "value" => $roe,
            "klasifikasi" => $klas
        );

        return $output;
    }

    public function roa(){
        $bulan_periode = (int) date('m');
        $tahun_periode = (int) date('Y');

        $debet = array("aset","biaya","biaya_lainnya");
        
        $dt = array();
        $yearopen = Session::get('global_setting');
        $periode = "";
        $pendapatan = Neracasaldo::select([ DB::raw("SUM(credit-debet) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','pendapatan')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $biaya = Neracasaldo::select([ DB::raw("SUM(debet-credit) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','biaya')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $aset = Neracasaldo::select([ DB::raw("SUM(debet-credit) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','aset')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $pendapatan = isset($pendapatan->nominal) ? $pendapatan->nominal : 0;
        $biaya = isset($biaya->nominal) ? $biaya->nominal : 0;
        $aset = isset($aset->nominal) ? $aset->nominal : 0;
        $roa = 0;
        if($aset != 0){
            $roa = ($pendapatan-$biaya) / $aset;
        }
        $roa = (float) number_format((float)$roa, 2, '.', '');
        
        $klas = 0;
        if($roa>=0 && $roa < 0.3){
            $klas = 0;
        } elseif($roa < 0.6) {
            $klas = 1;
        } else {
            $klas = 2;
        }

        $output = array(
            "value" => $roa,
            "klasifikasi" => $klas
        );

        return $output;
    }

    public function roi(){
        $bulan_periode = (int) date('m');
        $tahun_periode = (int) date('Y');

        $debet = array("aset","biaya","biaya_lainnya");
        
        $dt = array();
        $yearopen = Session::get('global_setting');
        $periode = "";
        $pendapatan = Neracasaldo::select([ DB::raw("SUM(credit-debet) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','pendapatan')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $biaya = Neracasaldo::select([ DB::raw("SUM(debet-credit) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->where('coas.category','biaya')
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $investment = Neracasaldo::select([ DB::raw("SUM(debet-credit) as nominal")])
            ->leftJoin('coas', 'neracasaldos.coa', '=', 'coas.id')
            ->whereIn('coas.coa_code', ['10102006', '10103001', '10103002', '10103003', '10201001','10202001', '10203001', '10203002', '10204001', '10301001', '10302002'])
            ->groupBy('coas.category')
            ->where(function($q) use($bulan_periode, $tahun_periode, $yearopen){
                // dd($yearopen);
                if($bulan_periode >= $yearopen->bulan_tutup_tahun){
                    //only one year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">=", $yearopen->bulan_tutup_tahun)->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    });
                } else {
                    //cross year
                    $q->where(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", "<=", $bulan_periode)->where("tahun_periode", $tahun_periode);
                    })->orWhere(function($q) use ($bulan_periode, $tahun_periode, $yearopen){
                        $q->where("bulan_periode", ">", $yearopen->bulan_tutup_tahun)->where("tahun_periode", $tahun_periode-1);
                    });
                }
            })
            ->first();
        $pendapatan = isset($pendapatan->nominal) ? $pendapatan->nominal : 0;
        $biaya = isset($biaya->nominal) ? $biaya->nominal : 0;
        $investment = isset($investment->nominal) ? $investment->nominal : 0;
        $roi = 0;
        if($investment != 0){
            $roi = ($pendapatan-$biaya) / $investment;
        }
        $roi = (float) number_format((float)$roi, 2, '.', '');
        
        $klas = 0;
        if($roi>=0 && $roi < 0.3){
            $klas = 0;
        } elseif($roi < 0.6) {
            $klas = 1;
        } else {
            $klas = 2;
        }

        $output = array(
            "value" => $roi,
            "klasifikasi" => $klas
        );

        return $output;
    }

    public function klasifikasi(){
        $roa = $this->roa();
        $roi = $this->roi();
        $roe = $this->roe();

        $kebijakan = Kebijakan::select('deskripsi')
        ->where([
            ['roa','=',$roa['klasifikasi']],
            ['roe','=',$roe['klasifikasi']],
            ['roi','=',$roi['klasifikasi']]
        ])->first();

        echo json_encode(array(
            "roa" => $roa,
            "roi" => $roi,
            "roe" => $roe,
            "kebijakan" => $kebijakan->deskripsi
        ));
    }

    public function get_list(Request $request, $x)
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

        if($x==0){
            $bulan_periode -= 1;
            if($bulan_periode==0){
                $bulan_periode = 12;
                $tahun_periode -= 1;
            }
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
        $perc = array_map( function($val) use($sum_nom) { 
            return round((float)($val / $sum_nom)*100, 2); 
        }, $noms);
        $noms_edit = array_map(function($val){
           return "Rp " . number_format($val,0,",",".") ;
        }, $noms);
        $noms_edit = array_values($noms_edit);
        $perc = array_values($perc);


        $output = array(
            "draw" => intval($request->draw),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => $noms,
            "percent" => $perc, 
            "nominal" => $noms_edit,
            "label" => $labels,
            "bulan" => $this->convertBulan($bulan_periode),
            "tahun" => $tahun_periode
        );

        return $output;
    }

    public function get_list_two_month(Request $request)
    {
        $dt = array();
        $dt[0] = $this->get_list($request, 0);
        $dt[1] = $this->get_list($request, 1);

        $output = $dt;

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