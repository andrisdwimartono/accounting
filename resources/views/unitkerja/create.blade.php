@extends("paging.main")

@section("content")
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-10 p-md-0">
                        <div class="welcome-text">
                            <!-- <h4>Hi, welcome back!</h4>
                            <span>Element</span> -->
                        </div>
                    </div>
                    <div class="col-sm-10 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/unitkerja">Unit Kerja</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">User</h4>
                            </div>
                            
                            <form id="quickForm" action="#">
                            @csrf
                                <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unitkerja_code">Kode Unit Kerja</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="unitkerja_code" class="form-control" id="unitkerja_code" placeholder="Enter Kode Unit Kerja" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unitkerja_name">Nama Unit Kerja</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="unitkerja_name" class="form-control" id="unitkerja_name" placeholder="Enter Nama Unit Kerja" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                </div>
                                @if($page_data["page_method_name"] != "View")
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-9">
                                    <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                    </div>
                                </div>
                                @else
                                <div class="form-group row">
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