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
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Kode Rekening Akuntansi</h4>
                            </div>
                            
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row m-0">
                                <label class="col-sm-4 col-form-label" for="unitkerja">Unit Kerja</label>
                                <div class="col-sm-6 cakfield">
                                    <select name="unitkerja" id="unitkerja" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="unitkerja_label" id="unitkerja_label">
                                </div>
                            </div>
                            <div class="form-group row m-0">
                                <label class="col-sm-4 col-form-label" for="no_jurnal">Nomor Jurnal</label>
                                <div class="col-sm-6 cakfield">
                                    <input type="text" name="no_jurnal" class="form-control form-control-sm" id="no_jurnal" placeholder="Enter Nomor Jurnal" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            
                        <div class="form-group row m-0">
                            <label for="tanggal_jurnal" class="col-sm-4 col-form-label">Tanggal Jurnal</label>
                            <div class="col-sm-6 cakfield">
                                <input name="tanggal_jurnal" class="datepicker-default form-control form-control-sm" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label class="col-sm-4 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-6 cakfield">
                                <textarea name="keterangan" class="form-control form-control-sm" id="keterangan" placeholder="Enter Keterangan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="transaksi">Transaksi</label>
                            <div id="result">
                                Event result:
                            </div>
                            <table id="cttransaksi" class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Unit Kerja</th>
                                        <th>Unit Kerja Label</th>
                                        <th>Anggaran</th>
                                        <th>Anggaran Label</th>
                                        <th>No Jurnal</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Jenis Transaksi</th>
                                        <th>No. Rek. Akuntansi</th>
                                        <th>No. Rek. Akuntansi Label</th>
                                        <th>Deskripsi</th>
                                        <th>Jenis Bayar</th>
                                        <th>Jenis Bayar Label</th>
                                        <th>NIM</th>
                                        <th>Kode VA</th>
                                        <th>Header?</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Action</th>
                                        <th>id</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <input type="hidden" name="transaksi" class="form-control" id="transaksi" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
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
                <!-- Modal Transaksi -->
                <div class="modal fade bd-example-modal-lg" id="staticBackdrop_transaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_transaksi_Label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdrop_transaksi_Label">Transaksi</h5>
                            <button type="button" id="staticBackdrop_transaksi_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <form id="quickModalForm_transaksi" action="#">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="anggaran">Anggaran</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="anggaran" id="anggaran" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="anggaran_label" id="anggaran_label">
                                    </div>
                                </div>
                                <input type="hidden" name="no_jurnal" id="no_jurnal">
                                <div class="form-group row m-0">
                                    <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-6 cakfield">
                                        <input name="tanggal" class="datepicker-default form-control form-control-sm" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="keterangan">Keterangan</label>
                                    <div class="col-sm-6 cakfield">
                                        <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Enter Keterangan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="coa">No. Rek. Akuntansi</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="coa_label" id="coa_label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="deskripsi">Deskripsi</label>
                                    <div class="col-sm-6 cakfield">
                                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="jenisbayar">Jenis Bayar</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="jenisbayar" id="jenisbayar" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="jenisbayar_label" id="jenisbayar_label">
                                    </div>
                                </div>
                                <input type="hidden" name="nim" id="nim">
                                <input type="hidden" name="kode_va" id="kode_va">
                                <input type="hidden" name="fheader" id="fheader">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="debet">Debet</label>
                                    <div class="col-sm-6 cakfield">
                                        <input type="text" name="debet" value="0" class="form-control cakautonumeric cakautonumeric-float" id="debet" placeholder="Enter Debet" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="credit">Kredit</label>
                                    <div class="col-sm-6 cakfield">
                                        <input type="text" name="credit" value="0" class="form-control cakautonumeric cakautonumeric-float" id="credit" placeholder="Enter Kredit" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Transaksi End -->

            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection