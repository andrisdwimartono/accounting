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
                                            <div class="card-body">
                                                <div class="form-group row m-0">
                                                    <label class="col-sm-4 col-form-label" for="unit_pelaksana">Unit Pelaksana</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <select name="unit_pelaksana" id="unit_pelaksana" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                        </select>
                                                        <input type="hidden" name="unit_pelaksana_label" id="unit_pelaksana_label">
                                                    </div>
                                                </div>
                                                <div class="form-group row m-0">
                                                    <label for="tanggal_kegiatan" class="col-sm-4 col-form-label">Tanggal Kegiatan</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <input name="tanggal_kegiatan" class="datepicker-default form-control form-control-sm tanggaljurnal1" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row m-0">
                                                    <label class="col-sm-4 col-form-label" for="iku">Indikator</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <select name="iku" id="iku" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                        

                                                        </select>
                                                        <input type="hidden" name="iku_label" id="iku_label">
                                                    </div>
                                                </div> -->
                                                <div class="form-group row m-0">
                                                    <label class="col-sm-4 col-form-label" for="kegiatan_name">Nama Kegiatan</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <input type="text" name="kegiatan_name" class="form-control" id="kegiatan_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                    </div>
                                                </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="Deskripsi">Deksripsi Kegiatan</label>
                                                <div class="col-sm-6 cakfield">
                                                    <textarea name="Deskripsi" class="form-control" id="Deskripsi" placeholder="Enter deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                                </div>
                                            </div>
                                                <div class="form-group row m-0">
                                                    <label class="col-sm-4 col-form-label" for="output">Output Kegiatan</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <input type="text" name="output" class="form-control" id="output" placeholder="Enter Output" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                    </div>
                                                </div>
                                                <div class="form-group row m-0">
                                                    <label class="col-sm-4 col-form-label"></label>
                                                    <div class="input-group col-sm-6 cakfield">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="upload_proposal" name="upload_proposal" onchange="selectingfile('proposal');">
                                                            <label class="custom-file-label" for="upload_proposal">Pilih file Proposal</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" id="btn_proposal" disabled>Upload</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="custom-file-input" id="proposal" name="proposal">    
                                                </div>
                                            <div class="form-group">
                                                <label for="ct1_detailbiayakegiatan">Detail Biaya</label>
                                                <div id="result">
                                                    Event result:
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="caktable1" class="display" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="column-hidden" scope="col">No</th>
                                                                <th scope="col" style="width: 30%; overflow: hidden;">Kode Rekening</th>
                                                                <th scope="col" style="width: 40%;">Deskripsi</th>
                                                                <th scope="col" style="width: 20%;">Nominal</th>
                                                                <!-- <th scope="col" style="width: 20%;">Deskripsi PJK</th> -->
                                                                <th scope="col" style="width: 10%;"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <tr row-seq="1">
                                                                <td class="column-hidden"></td>
                                                                <td class="p-0"><select name="coa_1" id="coa_1" class="form-control form-control-sm select2bs4staticBackdrop addnewrowselect" data-row="1" style="width: 100%;"></select></td>
                                                                <td class="p-0"><input type="text" name="deskripsi_1" class="form-control form-control-sm" id="deskripsi_1"></td>
                                                                <td class="p-0"><input type="text" name="nominal_1" value="0" class="form-control form-control-sm cakautonumeric cakautonumeric-float text-right" id="debet_1" placeholder="Enter Debet"></td>
                                                                <td class="p-0 text-center"><i class="text-danger fas fa-minus-circle row-delete" id="row_delete_1" style="cursor: pointer;"></i></td>
                                                            </tr> -->
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="p-0">
                                                                <td class="column-hidden"></td>
                                                                    <td class="text-center">
                                                                        <div class="form-group row m-0 p-0 properties">
                                                                            <!-- <button type="button" id="createnew" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Tabel"><i class="fa fa-trash"></i></button>
                                                                            <button type="button" class="btn btn-success shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan Anggaran" id="submit-form" @if($page_data["page_method_name"] == "View") readonly @endif><i class="fa fa-save"></i></button> -->
                                                                            <button type="button" id="addrow" class="btn btn-primary shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Anggaran"><i class="fa fa-plus"></i></button>
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-0 text-right">Total : </td>
                                                                    <td class="p-0 text-right" id="totalnom"></td>
                                                                    <!-- <td class="p-0 text-right" id="totalkredit"></td> -->
                                                                    <td class="p-0"></td>
                                                                    <td class="column-hidden"></td>
                                                                </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <!-- <div class="text-danger col-sm-12" id="caktable1_message"></div> -->
                                                <input type="hidden" name="ct1_detailbiayakegiatan" class="form-control" id="ct1_detailbiayakegiatan" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>

                                            <?php if($page_data["page_method_name"] != "Create" && $page_data["page_method_name"] != "Update"){ ?>
                                            <div class="form-group">
                                                <label for="ct2_approval">Approval</label>
                                                <div id="result">
                                                    Event result: <?= Auth::user()->role ?>
                                                </div>
                                                <table id="ctct2_approval" class="table table-bordered table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Jabatan</th>
                                                            <th>Jabatan</th>
                                                            <th>Menu</th>
                                                            <th>Pejabat</th>
                                                            <th>Pejabat</th>
                                                            <th>Komentar</th>
                                                            <th>Status Approval</th>
                                                            <th>Status Approval</th>
                                                            <th>Action</th>
                                                            <th>id</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                                <input type="hidden" name="ct2_approval" class="form-control" id="ct2_approval" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                            <?php } ?>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection