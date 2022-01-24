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
												<h5 class="mb-1">2000</h5>
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
												<h5 class="mb-1">2000</h5>
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
												<h5 class="mb-1">2000</h5>
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
												<h5 class="mb-1">2000</h5>
                                                <span style="font-size:15pt;" class="text-success"><b>Klasifikasi</b></span>
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
                        <div class="card-header"><h4 class="output-header"></h4></div>
                        <div class="card-body"> 
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