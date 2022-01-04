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
                                        <?php if($page_data["page_method_name"] == "Create"){ ?>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="password">Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unitkerja">Unit Kerja</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="unitkerja" id="unitkerja" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="unitkerja_label" id="unitkerja_label">
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