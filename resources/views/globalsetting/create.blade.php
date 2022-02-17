<script>    
  var menu="settings"
</script>

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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Settings</a></li>
                            <li class="breadcrumb-item active"><a href="/{{$page_data['page_data_urlname']}}">{{$page_data['page_data_name']}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form">
                                    <form id="quickForm" action="#"  style="color: #89879f; padding: 2rem; font-size:0.95rem;">
                                    @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <!-- === LOGO Instansi === -->
                                                <label class="col-sm-12 col-form-label">Logo Instansi</label>
                                                <div class="col-sm-12 input-group cakfield">
                                                    <div class="custom-file" style="width:100% !Important;">
                                                        <input type="file" class="custom-file-input" id="upload_logo_instansi" name="upload_logo_instansi" onchange="selectingfile('logo_instansi');">
                                                        <label class="custom-file-label" for="upload_logo_instansi">Pilih file Logo</label>
                                                    </div><br>
                                                    
                                                    @if($globalsetting->logo_instansi != "")
                                                        <img id="preview_logo_instansi" src="{{ asset ('/logo_instansi/'.$globalsetting->logo_instansi) }}"
                                                                alt="preview image" style="max-width: 100%;margin-top:10px;">
                                                    @else
                                                        <img id="preview_logo_instansi" src="{{ asset ("/assets/images/no_image.png") }}"
                                                            alt="preview image" style="max-width: 100%; max-height: 100px;margin-top:10px;">
                                                    @endif
                                                </div>
                                                <input type="hidden" class="custom-file-input" id="logo_instansi" name="logo_instansi">    

                                                <!-- === LOGO SIA === -->
                                                <label class="col-sm-12 col-form-label">Logo SIA</label>
                                                <div class="input-group col-sm-12 cakfield">
                                                    <div class="custom-file" style="width:100% !Important;">
                                                        <input type="file" class="custom-file-input" id="upload_logo_sia" name="upload_logo_sia" onchange="selectingfile('logo_sia');">
                                                        <label class="custom-file-label" for="upload_logo_sia">Pilih file Logo</label>
                                                    </div><br>
                                                    
                                                    @if($globalsetting->logo_sia != "")
                                                        <img id="preview_logo_sia" src="{{ asset ('/logo_sia/'.$globalsetting->logo_sia) }}"
                                                                alt="preview image" style="max-width: 100%;margin-top:10px;">
                                                    @else
                                                        <img id="preview_logo_sia" src="{{ asset ("/assets/images/no_image.png") }}"
                                                            alt="preview image" style="max-width: 100%; max-height: 100px;margin-top:10px;">
                                                    @endif
                                                </div>
                                                <input type="hidden" class="custom-file-input" id="logo_sia" name="logo_sia">    

                                                <!-- === MAIN BACKGROUND === -->
                                                <label class="col-sm-12 col-form-label">Background</label>
                                                <div class="input-group col-sm-12 cakfield">
                                                    <div class="custom-file" style="width:100% !Important;">
                                                        <input type="file" class="custom-file-input" id="upload_main_background" name="upload_main_background" onchange="selectingfile('main_background');">
                                                        <label class="custom-file-label" for="upload_main_background">Pilih file Background</label>
                                                    </div><br>
                                                    
                                                    @if($globalsetting->main_background != "")
                                                        <img id="preview_main_background" src="{{ asset ('/main_background/'.$globalsetting->main_background) }}"
                                                                alt="preview image" style="max-width: 100%;margin-top:10px;">
                                                    @else
                                                        <img id="preview_main_background" src="{{ asset ("/assets/images/no_image.png") }}"
                                                            alt="preview image" style="max-width: 100%; max-height: 100px;margin-top:10px;">
                                                    @endif
                                                </div>
                                                <input type="hidden" class="custom-file-input" id="main_background" name="main_background">    
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Nama Instansi</label>
                                                <input type="text" name="nama_lengkap_instansi" class="form-control" id="nama_lengkap_instansi" placeholder="Enter Nama Lengkap Instansi" @if($page_data["page_method_name"] == "View") readonly @endif><br>
                                                <label>Nama Alias</label>
                                                <input type="text" name="nama_instansi" class="form-control" id="nama_instansi" placeholder="Enter Nama Alias Instansi" @if($page_data["page_method_name"] == "View") readonly @endif><br>
                                                <label>Nama SIA</label>
                                                <textarea type="text" name="nama_sia" class="form-control" style="height:90px;" id="nama_sia" placeholder="Enter Nama SIA" @if($page_data["page_method_name"] == "View") readonly @endif></textarea><br>
                                                <label class="col-form-label" for="bulan_tutup_tahun">Awal Periode Tahunan</label>
                                                <div class="cakfield">
                                                    <select name="bulan_tutup_tahun" id="bulan_tutup_tahun" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif></select>
                                                    <input type="hidden" name="bulan_tutup_tahun_label" id="bulan_tutup_tahun_label">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ct1_bank_va">Bank VA</label>
                                            <div id="result">
                                                Event result:
                                            </div>
                                            <div class="table-responsive">
                                                <table id="ctct1_bank_va" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nomor VA</th>
                                                            <th>No. Kode Rekening</th>
                                                            <th>No. Kode Rekening Label</th>
                                                            <th>Action</th>
                                                            <th>id</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="ct1_bank_va" class="form-control" id="ct1_bank_va" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="ct2_approval_setting">Approval RKA</label>
                                            <div id="result">
                                                Event result:
                                            </div>
                                            <table id="ctct2_approval_setting" class="table table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jabatan</th>
                                                        <th>Jabatan Label</th>
                                                        <th>Menu</th>
                                                        <th>Action</th>
                                                        <th>id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="ct2_approval_setting" class="form-control" id="ct2_approval_setting" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="ct2_approval_setting_pengajuan">Approval Pengajuan</label>
                                            <div id="result">
                                                Event result:
                                            </div>
                                            <table id="ctct2_approval_setting_pengajuan" class="table table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jabatan</th>
                                                        <th>Jabatan Label</th>
                                                        <th>Menu</th>
                                                        <th>Action</th>
                                                        <th>id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="ct2_approval_setting_pengajuan" class="form-control" id="ct2_approval_setting_pengajuan" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                        </div>

                                        <div class="form-group">
                                            <label for="ct2_approval_settingpjk">Approval PJK</label>
                                            <div id="result">
                                                Event result:
                                            </div>
                                            <table id="ctct2_approval_settingpjk" class="table table-bordered table-striped" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Jabatan</th>
                                                        <th>Jabatan Label</th>
                                                        <th>Menu</th>
                                                        <th>Action</th>
                                                        <th>id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                            <input type="hidden" name="ct2_approval_settingpjk" class="form-control" id="ct2_approval_settingpjk" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
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
                <!-- Modal Bank VA -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct1_bank_va" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct1_bank_va_Label" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdrop_ct1_bank_va_Label">Bank VA</h5>
                                <button type="button" id="staticBackdrop_ct1_bank_va_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                            </div>
                            <div class="modal-body">
                                <form id="quickModalForm_ct1_bank_va" action="#">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="kode_va">Nomor VA</label>
                                        <div class="col-sm-6 cakfield">
                                            <input type="text" name="kode_va" class="form-control" id="kode_va" placeholder="Enter Nomor VA" @if($page_data["page_method_name"] == "View") readonly @endif>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label" for="coa">No. Kode Rekening</label>
                                        <div class="col-sm-6 cakfield">
                                            <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                            </select>
                                            <input type="hidden" name="coa_label" id="coa_label">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Bank VA End -->
                <!-- Modal Approval Setting -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct2_approval_setting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct2_approval_setting_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_ct2_approval_setting_Label">Approval RKA</h5>
                            <button type="button" id="staticBackdrop_ct2_approval_setting_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_ct2_approval_setting" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="role">Jabatan</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="role" id="role" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="role_label" id="role_label">
                                    </div>
                                </div>
                                <input type="hidden" name="jenismenu" id="jenismenu" value="RKA">
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Approval Setting End -->
            </div>
        </div>
@endsection