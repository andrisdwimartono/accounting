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
                            <h4>DSS</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="">DSS</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
					<div class="col-xl-9 col-xxl-12">
                        <div class="row">
							<div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
								<div class="card overflow-hidden">
									<div class="card-body pb-4 px-4 pt-4">
										<div class="row">
											<div class="col">
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="mb-1" id="valueofroa">0</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span class='badge light' id="classroa" style='width:50px'></span>
                                                    </div>
                                                </div>
                                                <span style="font-size:15pt;" class="text-success"><b>ROA</b></span>
												<span class="text-success">Return of Asset</span>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
								<div class="card overflow-hidden">
									<div class="card-body pb-4 px-4 pt-4">
										<div class="row">
											<div class="col">
												<div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="mb-1" id="valueofroe">0</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span class='badge light' id="classroe" style='width:50px'></span>
                                                    </div>
                                                </div>
												<span style="font-size:15pt;" class="text-success"><b>ROE</b></span>
                                                <span class="text-success">Return on Equity</span>
											</div>
										</div>
									</div>
								</div>
							</div>
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
								<div class="card overflow-hidden">
									<div class="card-body pb-4 px-4 pt-4">
										<div class="row">
											<div class="col">
                                            <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="mb-1" id="valueofroi">0</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <span class='badge light' id="classroi" style='width:50px'></span>
                                                    </div>
                                                </div>
                                                <span style="font-size:15pt;" class="text-success"><b>ROI</b></span>
												<span class="text-success">Return of Investment</span>
											</div>
										</div>
									</div>
								</div>
							</div>
                            
                            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
								<div class="card overflow-hidden">
									<div class="card-body pb-4 px-4 pt-4">
										<div class="row">
											<div class="col">
												<h5 class="mb-1" id="valueofklasifikasi">Aksi A</h5>
                                                <a href="/kebijakan"><span style="font-size:15pt;" class="text-success"><b>Kebijakan</b></span></a>
											</div>
										</div>
									</div>
								</div>
							</div>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-12">
                    @csrf
                    <div class="card">
                        <div class="card-header" style="display:block">
                            <div class="form-group row m-0" style="height:40px;">
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
                                <div class="col-sm-4">
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
                                <!-- <div class="col-sm-4">
                                    <div class="col-sm-3 left">
                                        <label class="text-grey">Level</label>
                                    </div>
                                    <div class="col-sm-9 right">
                                        <select name="child_level" id="child_level" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            <option value=0>Header</option>
                                            <option value=1>Detail</option>
                                        </select>
                                    </div>
                                </div>                             -->
                            </div>
                            <h4 class="output-header"></h4>
                        </div>
                        <div class="card-body"> 
                            <!-- <canvas id="laporanChart"></canvas>
                            <br><br> -->

                            <button onclick="exportTableToExcel('testTable', 'pivot_table')" type="button" class="btn btn-success">Excel <span class='btn-icon-right'><i class='fa fa-download'></i></span></button> 
                            <div id="output" style="min-height: 500px;overflow:auto"></div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection