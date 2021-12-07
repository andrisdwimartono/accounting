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
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Jurnal Umum<?=isset($page_data["page_job"])?" ".$page_data["page_job"]:""?></h4>
                            </div>
                            
                            <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="nama_instansi">Nama Instansi</label>
                                <div class="col-sm-6 cakfield">
                                    <input type="text" name="nama_instansi" class="form-control" id="nama_instansi" placeholder="Enter Nama Instansi" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="input-group col-sm-6 cakfield">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="upload_logo_instansi" name="upload_logo_instansi" onchange="selectingfile('logo_instansi');">
                                        <label class="custom-file-label" for="upload_logo_instansi">Pilih file Logo</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_logo_instansi" disabled>Upload</button>
                                    </div>
                                </div>
                                <input type="hidden" class="custom-file-input" id="logo_instansi" name="logo_instansi">    
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="bulan_tutup_tahun">Bulan Tutup Tahun</label>
                                <div class="col-sm-6 cakfield">
                                    <select name="bulan_tutup_tahun" id="bulan_tutup_tahun" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="bulan_tutup_tahun_label" id="bulan_tutup_tahun_label">
                                </div>
                            </div>
                        <div class="form-group">
                            <label for="ct1_bank_va">Bank VA</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="ctct1_bank_va" class="table table-bordered table-striped" style="width:100%">
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
                            <input type="hidden" name="ct1_bank_va" class="form-control" id="ct1_bank_va" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
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

            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection