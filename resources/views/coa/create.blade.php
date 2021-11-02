@extends("paging.main")

@section("content")
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <!-- <div class="row page-titles mx-0">
                    <div class="col-sm-10 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <span>Element</span>
                        </div>
                    </div>
                    <div class="col-sm-10 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/coa">COA</a></li>
                        </ol>
                    </div>
                </div> -->
                <!-- row -->
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Kode Rekening Akuntansi</h4>
                            </div>

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
                    </div>
                </div>
            </div>
        </div>
@endsection