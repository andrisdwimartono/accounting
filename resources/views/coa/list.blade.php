@extends('paging.main')

@section('content')
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <!-- <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <span>Element</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/coa">COA</a></li>
                        </ol>
                    </div>
                </div> -->
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Kode Rekening Akuntansi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                 @csrf
                                    <table id="example1" class="table table-bordered table-striped">
                                    <thead class="bg-primary">
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