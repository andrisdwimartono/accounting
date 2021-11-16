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
                            <h4>Buku Besar</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan</a></li>
                            <li class="breadcrumb-item active"><a href="">Buku Besar</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary" style="display:block">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="coa">Kode Rekening</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="coa" id="coa" class="form-control select2bs4staticBackdrop addnewrowselect" data-row="1" style="width: 100%;"></select>
                                        <input type="hidden" name="coa_code" id="coa_code">
                                    </div>

                                    <label class="col-sm-4 col-form-label" for="coa">Kode Rekening</label>
                                    <div class="col-sm-6 cakfield">
                                        <div class="col-sm-6 cakfield">
                                            <input name="tanggal_jurnal_from" class="datepicker-default form-control form-control-sm" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                                        </div>
                                        <label for="tanggal_jurnal_to" class="col-sm-1 col-form-label">s/d</label>
                                        <div class="col-sm-6 cakfield">
                                            <input name="tanggal_jurnal_to" class="datepicker-default form-control form-control-sm" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                                        </div>
                                    </div>                        
                                </div>

                            </div>
                            <div class="card-body">                                

                                <div class="table-responsive">
                                 @csrf
                                    
                                    <table id="example1" class="table table-bordered table-striped">
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