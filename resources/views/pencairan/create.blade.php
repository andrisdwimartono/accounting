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
                                            <div class="form-group row m-0">
                                                <label for="tanggal_pencairan" class="col-sm-4 col-form-label">Tanggal Pencairan</label>
                                                <div class="col-sm-6 cakfield">
                                                    <input name="tanggal_pencairan" class="datepicker-default form-control form-control-sm tanggaljurnal1" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="catatan">Catatan</label>
                                                <div class="col-sm-6 cakfield">
                                                    <textarea name="catatan" class="form-control" id="catatan" placeholder="Enter catatan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ct1_pencairanrka">Detail RKA</label>
                                                <div id="pencairanrka_search" class="form-group row col-sm-12 justify-content-center">
                                                    @if($page_data["page_method_name"] != "View")
                                                    <label for="tanggal_pencairan_start" class="col-sm-1 col-form-label">Awal</label>
                                                    <div class="col-sm-3 cakfield">
                                                        <input name="tanggal_pencairan_start" class="datepicker-default form-control form-control-sm tanggaljurnal1" id="datepicker1">
                                                    </div>
                                                    <label for="tanggal_pencairan_finish" class="col-sm-1 col-form-label">Akhir</label>
                                                    <div class="col-sm-3 cakfield">
                                                        <input name="tanggal_pencairan_finish" class="datepicker-default form-control form-control-sm tanggaljurnal1" id="datepicker2">
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button type="button" id="filterkegiatan" class="btn btn-info">Filter</button>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="caktable1" class="display" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="column-hidden" scope="col">No</th>
                                                                <th scope="col" style="width: 25%; overflow: hidden;">Rencana Kerja Anggaran</th>
                                                                <th scope="col" style="width: 25%; overflow: hidden;">Nominal</th>
                                                                <th scope="col" style="width: 10%;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="p-0">
                                                                <td class="column-hidden"></td>
                                                                    <td class="text-center">
                                                                        <div class="form-group row m-0 p-0 properties ms-auto">
                                                                            <!-- <button type="button" id="createnew" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Tabel"><i class="fa fa-trash"></i></button>
                                                                            <button type="button" class="btn btn-success shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan Anggaran" id="submit-form" @if($page_data["page_method_name"] == "View") readonly @endif><i class="fa fa-save"></i></button> -->
                                                                            @if($page_data["page_method_name"] == "Create"  || $page_data["page_method_name"] == "Update") 
                                                                                <button type="button" id="addrow" class="btn btn-primary shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Anggaran"><i class="fa fa-plus"></i></button>
                                                                            @endif
                                                                            <div class="p-0 text-right ml-auto pr-2 pt-2">
                                                                            Total :
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-0 text-right" id="totalnom"> </td>
                                                                    <td class="p-0 text-right"></td>
                                                                    <!-- <td class="p-0 text-right" id="totalkredit"></td> -->
                                                                    <td class="column-hidden"></td>
                                                                    
                                                                </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- <div class="text-danger col-sm-12" id="caktable1_message"></div> -->
                                                <input type="hidden" name="ct1_pencairanrka" class="form-control" id="ct1_pencairanrka" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        @if($page_data["page_method_name"] != "View")
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-9">
                                                <button type="button" id="trysubmit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                            </div>
                                        </div>
                                        @endif
                                    </form>
                                        <!-- Modal Detail Biaya -->
                                        <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct1_detailbiayakegiatan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct1_detailbiayakegiatan_Label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdrop_ct1_detailbiayakegiatan_Label">Detail Biaya</h5>
                                                    <button type="button" id="staticBackdrop_ct1_detailbiayakegiatan_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="quickModalForm_ct1_detailbiayakegiatan" action="#">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" for="coa">Kode Rek. Biaya</label>
                                                            <div class="col-sm-6 cakfield">
                                                                <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                                </select>
                                                                <input type="hidden" name="coa_label" id="coa_label">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" for="deskripsibiaya">Deskripsi</label>
                                                            <div class="col-sm-6 cakfield">
                                                                <textarea name="deskripsibiaya" class="form-control" id="deskripsibiaya" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" for="nominalbiaya">Nominal Pengajuan</label>
                                                            <div class="col-sm-6 cakfield">
                                                                <input type="text" name="nominalbiaya" value="0" class="form-control cakautonumeric cakautonumeric-float" id="nominalbiaya" placeholder="Enter Nominal Pengajuan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Detail Biaya End -->
                                    <?php if($page_data["page_method_name"] != "Create" && $page_data["page_method_name"] != "Update"){ ?>
                                    <!-- Modal Approval -->
                                    <div class="modal fade bd-example-modal-lg" id="staticBackdrop_ct2_approval" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_ct2_approval_Label" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdrop_ct2_approval_Label">Approval</h5>
                                                <button type="button" id="staticBackdrop_ct2_approval_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="quickModalForm_ct2_approval" action="#">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label" for="role">Jabatan</label>
                                                        <div class="col-sm-6 cakfield">
                                                            <select name="role" id="role" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                            </select>
                                                            <input type="hidden" name="role_label" id="role_label">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="jenismenu" id="jenismenu">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label" for="user">Pejabat</label>
                                                        <div class="col-sm-6 cakfield">
                                                            <select name="user" id="user" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                            </select>
                                                            <input type="hidden" name="user_label" id="user_label">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label" for="komentar">Komentar</label>
                                                        <div class="col-sm-6 cakfield">
                                                            <textarea name="komentar" class="form-control" id="komentar" placeholder="Enter Komentar" @if($page_data["page_method_name"] != "View") readonly @endif></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label" for="status_approval">Status Approval</label>
                                                        <div class="col-sm-6 cakfield">
                                                            <select name="status_approval" id="status_approval" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] != "View") readonly @endif>

                                                            </select>
                                                            <input type="hidden" name="status_approval_label" id="status_approval_label">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Approval End -->
                                <?php } ?>
                                
                                <!-- Modal Try Submit -->
                                <div class="modal fade" id="modal-trysubmit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><b>Warning!!</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Ya, berarti anda setuju untuk dibuatkan <b><u>JURNAL</u></b>!, Apakah anda yakin?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" id="trysubmit-confirmed">Ya</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Try Submit End -->
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection