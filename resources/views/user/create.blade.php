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
                            <h4>Hi, welcome back!</h4>
                            <span>Element</span>
                        </div>
                    </div>
                    <div class="col-sm-10 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Element</a></li>
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
                                            <label class="col-sm-4 col-form-label" for="name">Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="email">Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="phone">HP</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Phone" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="password">Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label"></label>
                                            <div class="input-group col-sm-6">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="upload_photo_profile" name="upload_photo_profile" onchange="selectingfile('photo_profile');">
                                                    <label class="custom-file-label" for="upload_photo_profile">Pilih file Foto</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" id="btn_photo_profile" disabled>Upload</button>
                                                </div>
                                            </div>
                                            <input type="hidden" class="custom-file-input" id="photo_profile" name="photo_profile">    
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
@endsection