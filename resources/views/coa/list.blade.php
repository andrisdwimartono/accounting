@extends('paging.main')

@section('content')

<!--**********************************
    Content body end
***********************************-->

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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/{{$page_data["page_data_urlname"]}}">{{$page_data["page_data_name"]}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills mb-4 light">
                                    <li class="nav-item">
                                        <a id="tabaset" class="nav-link{{$page_data['category'] == 'aset'?' active':''}}" data-toggle="tab" href="/coa/aset/list"> Aset</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabhutang" class="nav-link{{$page_data['category'] == 'hutang'?' active':''}}" data-toggle="tab" href="/coa/hutang/list"> Hutang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabmodal" class="nav-link{{$page_data['category'] == 'modal'?' active':''}}" data-toggle="tab" href="/coa/modal/list"> Modal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabpendapatan" class="nav-link{{$page_data['category'] == 'pendapatan'?' active':''}}" data-toggle="tab" href="/coa/pendapatan/list"> Pendapatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabbiaya" class="nav-link{{$page_data['category'] == 'biaya'?' active':''}}" data-toggle="tab" href="/coa/biaya/list"> Biaya</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabbiaya_lainnya" class="nav-link{{$page_data['category'] == 'biaya_lainnya'?' active':''}}" data-toggle="tab" href="/coa/biaya_lainnya/list"> Biaya Lainnya</a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="tabpendapatan_lainnya" class="nav-link{{$page_data['category'] == 'pendapatan_lainnya'?' active':''}}" data-toggle="tab" href="/coa/pendapatan_lainnya/list"> Pendapatan Lainnya</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a id="tabplus" class="nav-link" data-toggle="tab" href="#" id="tabplus"> +</a>
                                    </li> -->
                                </ul>
                        
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                @csrf
                                <table id="example1" class="display" style="width: 100%" table-category="aset">
                                    <thead>
                                        <tr>
                                            <th width="10px" class="column-hidden">No</th>
                                            <th width="100px">Kode</th>
                                            <th width="250px">Nama</th>
                                            <th width="10px" class="column-hidden">Level</th>
                                            <th width="10px" class="column-hidden">Rek. Akun.</th>
                                            <th width="10px" class="column-hidden">Rek. Akun.</th>
                                            <th width="10px" class="column-hidden">Kategori</th>
                                            <th width="10px" class="column-hidden">Kategori</th>
                                            <th width="10px">Head?</th>
                                            <th width="10px" class="column-hidden">Aktif?</th>
                                            <th width="20px">Jenis Aktivitas</th>
                                            <th width="10px">Act</th>
                                        </tr>
                                    </thead>
                                </table>
                                    
                                    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><b>Warning!!</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger row-delete-confirmed">Hapus</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modal-add-new-coa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><b>Kode Rekening Akuntansi</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="quickForm" action="#">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group row m-0">
                                                                <label class="col-sm-4 col-form-label" for="coa_code">Kode</label>
                                                                <div class="col-sm-6 cakfield">
                                                                    <input type="text" name="coa_code" class="form-control form-control-sm" id="coa_code" placeholder="Enter Kode" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-0">
                                                                <label class="col-sm-4 col-form-label" for="coa_name">Nama</label>
                                                                <div class="col-sm-6 cakfield">
                                                                    <input type="text" name="coa_name" class="form-control form-control-sm" id="coa_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-0">
                                                                <label class="col-sm-4 col-form-label" for="level_coa">Level</label>
                                                                <div class="col-sm-6 cakfield">
                                                                    <input type="text" name="level_coa" class="form-control form-control-sm" id="level_coa" placeholder="Enter Level" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-0">
                                                                <label class="col-sm-4 col-form-label" for="coa">Induk</label>
                                                                <div class="col-sm-6 cakfield">
                                                                    <select name="coa" id="coa" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                                    </select>
                                                                    <input type="hidden" name="coa_label" id="coa_label">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row m-0">
                                                                <label class="col-sm-4 col-form-label" for="category">Kategori</label>
                                                                <div class="col-sm-6 cakfield">
                                                                    <select name="category" id="category" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                                    </select>
                                                                    <input type="hidden" name="category_label" id="category_label">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <label class="col-sm-4 col-form-label" for="fheader"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="fheader" class="custom-control-input" id="fheader" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                                                                    <label class="custom-control-label" for="fheader">Header?</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <label class="col-sm-4 col-form-label" for="factive"></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" name="factive" class="custom-control-input" id="factive" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                                                                    <label class="custom-control-label" for="factive">Aktif?</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($page_data["page_method_name"] != "View")
                                                        <div class="form-group row m-0">
                                                            <div class="col-sm-9 offset-sm-9">
                                                            <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="form-group row m-0">
                                                            <div class="col-sm-9 offset-sm-9">

                                                            </div>
                                                        </div>
                                                        @endif
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <!-- <button type="button" class="btn btn-danger row-add-new-save">Save</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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