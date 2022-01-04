@extends('paging.main')

    @section('content')
    <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>{{$page_data["page_data_name"]}}</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan</a></li>
                            <li class="breadcrumb-item active"><a href="">{{$page_data["page_data_name"]}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                        @csrf
                            <div class="card-header" style="display:block">
                                <div class="form-group row m-0"  style="height:40px;">
                                    <div class="col-sm-4">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Bulan</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="bulan_periode" id="bulan_periode" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                                <option value="1"<?=date("m")==1?" selected":""?>>Januari</option>
                                                <option value="2"<?=date("m")==2?" selected":""?>>Februari</option>
                                                <option value="3"<?=date("m")==3?" selected":""?>>Maret</option>
                                                <option value="4"<?=date("m")==4?" selected":""?>>April</option>
                                                <option value="5"<?=date("m")==5?" selected":""?>>Mei</option>
                                                <option value="6"<?=date("m")==6?" selected":""?>>Juni</option>
                                                <option value="7"<?=date("m")==7?" selected":""?>>Juli</option>
                                                <option value="8"<?=date("m")==8?" selected":""?>>Agustus</option>
                                                <option value="9"<?=date("m")==9?" selected":""?>>September</option>
                                                <option value="10"<?=date("m")==10?" selected":""?>>Oktober</option>
                                                <option value="11"<?=date("m")==11?" selected":""?>>November</option>
                                                <option value="12"<?=date("m")==12?" selected":""?>>Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Tahun</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="tahun_periode" id="tahun_periode" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                                <?php for($i = 2018; $i < ((int) date("Y"))+3; $i++){ ?>
                                                    <option value="<?=$i;?>"<?=date("Y")==$i?" selected":""?>><?=$i;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Unit Kerja</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="unitkerja" id="unitkerja" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">                                

                                <div class="table-responsive">
                                 
                                    
                                    <table id="aruskas" class="display" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="column-hidden">No</th>
                                                <th class="column-hidden">Kode Rek.</th>
                                                <th>Aktivitas</th>
                                                <th>Nominal</th>
                                                <th class="column-hidden">Level COA</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="column-hidden"></td>
                                                <td class="column-hidden"></td>
                                                <td class="right total"></td>
                                                <td class="total" style="border-top: 1px solid #000 !Important;"></td>
                                                <td class="total column-hidden" style="border-top: 1px solid #000 !Important;"></td>
                                            </tr>
                                            <tr>
                                                <td class="column-hidden"></td>
                                                <td class="column-hidden"></td>
                                                <td class="right total"></td>
                                                <td class="total" style="border-top: 1px solid #000 !Important;"></td>
                                                <td class="total column-hidden" style="border-top: 1px solid #000 !Important;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection