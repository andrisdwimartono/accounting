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
                                        <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;"></select>
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
                                 
                                    
                                    <table id="bukubesar" class="dttables table table-bordered table-striped dataTable ">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>No Jurnal</th>
                                                <th>Deskripsi</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tfoot id="jumlah" class="dttables-footer table table-bordered table-striped dataTable">
                                            <tr>
                                                <td colspan=4 class="right"></td><td></td><td></td>
                                            </tr>
                                            <tr>
                                                <td colspan=4 class="right"></td><td></td><td></td>
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