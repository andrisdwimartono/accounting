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
                            <div class="card-header bg-primary" style="display:block">
                                <div class="form-group row">
                                    <div class="col-sm-6 cakfield">
                                        Kode Rekening 
                                        <select name="coa" id="coa" class="form-control select2bs4staticBackdrop addnewrowselect" data-row="1" style="width: 100%;"></select>
                                        <input type="hidden" name="coa_code" id="coa_code">
                                    </div>
                                    <div class="col-sm-3 cakfield">
                                        Start Date
                                        <input id="startDate" name="startDate" width="100%" />
                                    </div>
                                    <div class="col-sm-3 cakfield">
                                        End Date
                                        <input id="endDate" name="endDate" width="100%" />
                                    </div>
                                            
                                </div>

                            </div>
                            <div class="card-body">                                

                                <div class="table-responsive">
                                 
                                    
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="col-md-1">No</th>
                                                <th class="col-md-2">Tanggal</th>
                                                <th class="col-md-2">No Jurnal</th>
                                                <th class="col-md-3">Deskripsi</th>
                                                <th class="col-md-2">Debet</th>
                                                <th class="col-md-2">Kredit</th>
                                            </tr>
                                        </thead>
                                        <tfoot id="jumlah">
                                            <tr>
                                                <th></th><th></th><th></th><th></th><th></th><th></th>
                                            </tr>
                                        </tfoot>
                                        <!-- <tfoot id="saldo">
                                            <tr>
                                                <th></th><th></th><th></th><th></th><th></th><th></th>
                                            </tr>
                                        </tfoot> -->
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