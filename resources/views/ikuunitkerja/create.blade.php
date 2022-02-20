@extends("paging.main")

@section("content")
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
                            <li class="breadcrumb-item active"><a href="/{{$page_data['page_data_urlname']}}">{{$page_data['page_data_name']}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body" style="color: #89879f; padding: 2rem; font-size:0.95rem;">
                                <div class="basic-form">               
                                    <form id="quickForm" action="#">
                                    @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="misi">Misi</label>
                                            <div class="col-sm-6">
                                                <textarea type="text" name="misi" class="form-control" style="height:90px;" id="misi" placeholder="Enter Misi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="bidang">Bidang</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="bidang" class="form-control" id="bidang" placeholder="Enter Bidang" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="sasaran_bidang">Sasaran Bidang</label>
                                            <div class="col-sm-6">
                                                <textarea type="text" name="sasaran_bidang" class="form-control" style="height:90px;" id="sasaran_bidang" placeholder="Enter Sasaran Bidang" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="strategi">Strategi</label>
                                            <div class="col-sm-6">
                                                <textarea type="text" name="strategi" class="form-control" style="height:90px;" id="strategi" placeholder="Enter Strategi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="tahun">Tahun</label>
                                            <div class="col-sm-6 cakfield">
                                            <input type="text" name="tahun" class="form-control" id="tahun" placeholder="Enter Tahun" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unit_pelaksana">Unit Pelaksana</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="unit_pelaksana" id="unit_pelaksana" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </select>
                                                <input type="hidden" name="unit_pelaksana_label" id="unit_pelaksana_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="sasaran_bidang">Target Capaian</label>
                                            <div class="col-sm-6">
                                                <textarea type="text" name="iku_name" class="form-control" style="height:90px;" id="strategi" placeholder="Enter Target Capaian" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        
                                        @if($page_data["page_method_name"] != "View")
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-4">
                                            <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-4">

                                            </div>
                                        </div>
                                        @endif    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection