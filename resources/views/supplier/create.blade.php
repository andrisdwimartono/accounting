@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="supplier_name">Nama</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_name" class="form-control" id="supplier_name" placeholder="Enter Nama" readonly>
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
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="first_name">Nama Depan</label>
                                <div class="col-sm-6">
                                    <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Enter Nama Depan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="last_name">Nama Belakang</label>
                                <div class="col-sm-6">
                                    <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Enter Nama Belakang" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="supplier_company">Perusahaan Pemasok</label>
                                <div class="col-sm-6">
                                    <input type="text" name="supplier_company" class="form-control" id="supplier_company" placeholder="Enter Perusahaan Pemasok" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="email">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter Email" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="phone_1">No HP 1</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone_1" class="form-control" id="phone_1" placeholder="Enter No HP 1" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="phone_2">No HP 2</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phone_2" class="form-control" id="phone_2" placeholder="Enter No HP 2" @if($page_data["page_method_name"] == "View") readonly @endif>
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
@endsection