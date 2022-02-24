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
                                            <label class="col-sm-4 col-form-label" for="satuan_name">Nama Satuan</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="satuan_name" class="form-control" id="satuan_name" placeholder="Enter Satuan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="satuan_katerangan">Keterangan</label>
                                            <div class="col-sm-6">
                                                <textarea type="text" name="satuan_katerangan" class="form-control" style="height:90px;" id="satuan_katerangan" placeholder="Enter Misi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="type_satuan">Tipe Satuan</label>
                                            <div class="col-sm-6">
                                                <select name="type_satuan" id="type_satuan" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="type_satuan_label" id="type_satuan_label">
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