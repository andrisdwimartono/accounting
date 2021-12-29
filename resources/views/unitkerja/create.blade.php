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
                                    <form id="quickForm" action="#" >
                                    @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="unitkerja_code">Kode Unit Kerja</label>
                                            <div class="col-sm-9 cakfield">
                                                <input type="text" name="unitkerja_code" class="form-control form-control" id="unitkerja_code" placeholder="Enter Kode Unit Kerja" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="unitkerja_name">Nama Unit Kerja</label>
                                            <div class="col-sm-9 cakfield">
                                                <input type="text" name="unitkerja_name" class="form-control form-control" id="unitkerja_name" placeholder="Enter Nama Unit Kerja" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        @if($page_data["page_method_name"] != "View")
                                        <div class="form-group row">
                                            <div class="col-sm-10">
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
            </div>
        </div>
@endsection