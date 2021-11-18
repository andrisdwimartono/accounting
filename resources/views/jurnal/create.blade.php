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
                                <h4 class="card-title text-white">Jurnal Umum</h4>
                            </div>
                            
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                        <input type="hidden" id="id_jurnal" name="id_jurnal" value="3">
                        <input type="hidden" id="is_edit" name="is_edit" value="1">
                        <div class="form-group row m-0">
                            <label class="col-sm-4 col-form-label" for="unitkerja">Unit Kerja</label>
                            <div class="col-sm-6 cakfield">
                                <select name="unitkerja" id="unitkerja" class="form-control form-control-sm select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                </select>
                                <input type="hidden" name="unitkerja_label" id="unitkerja_label">
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label class="col-sm-4 col-form-label" for="anggaran_label">Kode Anggaran</label>
                            <div class="col-sm-6 cakfield">
                                <input type="text" name="anggaran_label" class="form-control form-control-sm" id="anggaran_label" placeholder="Enter Kode Anggaran" @if($page_data["page_method_name"] == "View") readonly @endif>
                            </div>
                        </div>
                        <div class="form-group row m-0">
                            <label class="col-sm-4 col-form-label" for="no_jurnal">Nomor Jurnal</label>
                            <div class="col-sm-6 cakfield">
                                <input type="text" name="no_jurnal" class="form-control form-control-sm" id="no_jurnal" placeholder="Enter Nomor Jurnal" value="JU#######" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group row m-0">
                            <label for="tanggal_jurnal" class="col-sm-4 col-form-label">Tanggal Jurnal</label>
                            <div class="col-sm-6 cakfield">
                                <input name="tanggal_jurnal" class="datepicker-default form-control form-control-sm" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                            </div>
                        </div>
                        <div class="form-group row m-0 mb-1">
                            <label class="col-sm-4 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-6 cakfield">
                                <textarea name="keterangan" class="form-control form-control-sm" id="keterangan" placeholder="Enter Keterangan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                            </div>
                        </div>
                        <div class="form-group m-0">
                            <div class="col-sm-12 row" id="forcaktable1">
                                <table id="caktable1" class="table table-bordered" style="table-layout: fixed;">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="column-hidden" scope="col">ID COA</th>
                                            <th class="text-white text-center" scope="col" style="width: 40%; overflow: hidden;">Kode Rekening</th>
                                            <th class="text-white text-center" scope="col" style="width: 15%;">Deskripsi</th>
                                            <th class="text-white text-center" scope="col" style="width: 20%;">Debet</th>
                                            <th class="text-white text-center" scope="col" style="width: 20%;">Kredit</th>
                                            <th class="text-white text-center col-sm-1 pl-0 pr-0" scope="col" style="width: 5%;"></th>
                                            <th class="column-hidden" scope="col">ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr row-seq="1">
                                            <td class="column-hidden"></td>
                                            <td class="p-0"><select name="coa_1" id="coa_1" class="form-control select2bs4staticBackdrop addnewrowselect" data-row="1" style="width: 100%;"></select></td>
                                            <td class="p-0"><input type="text" name="deskripsi_1" class="form-control form-control-sm" id="deskripsi_1"></td>
                                            <td class="p-0"><input type="text" name="debet_1" value="0" class="form-control form-control-sm cakautonumeric cakautonumeric-float text-right" id="debet_1" placeholder="Enter Debet"></td>
                                            <td class="p-0"><input type="text" name="kredit_1" value="0" class="form-control form-control-sm cakautonumeric cakautonumeric-float text-right" id="kredit_1" placeholder="Enter Kredit"></td>
                                            <td class="p-0 text-center"><i class="text-danger fas fa-minus-circle row-delete" id="row_delete_1" style="cursor: pointer;"></i></td>
                                            <td class="column-hidden"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="p-0">
                                            <td class="column-hidden"></td>
                                            <td rowspan="2" class="text-center">
                                                <div class="form-group row m-0 p-0">
                                                    <button type="button" id="createnew" class="btn btn-primary">Baru</button>
                                                    <button type="button" class="btn btn-success" id="submit-form" @if($page_data["page_method_name"] == "View") readonly @endif>Simpan</button>
                                                    <button type="button" id="addrow" class="btn btn-primary">+row</button>
                                                </div>
                                            </td>
                                            <td class="p-0 text-right">Total : </td>
                                            <td class="p-0 text-right" id="totaldebet"></td>
                                            <td class="p-0 text-right" id="totalkredit"></td>
                                            <td class="p-0"></td>
                                            <td class="column-hidden"></td>
                                        </tr>
                                        <tr class="p-0">
                                            <td class="column-hidden"></td>
                                            <td class="p-0 text-right">Selisih : </td>
                                            <td class="p-0 text-right" id="totalselisih"></td>
                                            <td class="p-0"></td>
                                            <td class="p-0"></td>
                                            <td class="column-hidden"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="text-danger col-sm-12" id="caktable1_message"></div>
                                
                            </div>
                        </div>
                    @if($page_data["page_method_name"] != "View")
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">
                        
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">

                        </div>
                    </div>
                    @endif
                </form>
                <div class="form-group m-0">
                    <div class="col-sm-12 row bg-primary" id="forcaktablesearch2">
                        <!-- <div class="col-sm-1 cakfield">
                            <select name="countcaktable2" id="countcaktable2" class="form-control form-control-sm bg-primary mt-1">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div> -->
                        <label for="tanggal_jurnal_from" class="col-sm-1 col-form-label">Tgl</label>
                        <div class="col-sm-2 cakfield">
                            <input name="tanggal_jurnal_from" id="tanggal_jurnal_from" class="datepicker-default form-control form-control-sm bg-primary mt-1" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                        </div>
                        <label for="tanggal_jurnal_to" class="col-sm-1 col-form-label">s/d</label>
                        <div class="col-sm-2 cakfield">
                            <input name="tanggal_jurnal_to" id="tanggal_jurnal_to" class="datepicker-default form-control form-control-sm bg-primary mt-1" id="datepicker" <?=$page_data["page_method_name"] == "View"?"readonly":""?>>
                        </div>
                        <label class="col-sm-2 text-right col-form-label" for="no_jurnal_search">No Jurnal</label>
                        <div class="col-sm-3 cakfield">
                            <input type="text" name="no_jurnal_search" class="form-control form-control-sm bg-primary mt-1" id="no_jurnal_search" placeholder="Enter Nomor Jurnal">
                        </div>
                    </div>
                    <div class="col-sm-12 row" id="forcaktable2">
                        <table id="caktable2" class="table table-bordered">
                            <thead class="bg-white">
                                <tr>
                                    <th class="text-black text-center column-hidden" scope="col">ID</th>
                                    <th class="text-black text-center" scope="col">Tanggal</th>
                                    <th class="text-black text-center" scope="col">No Jurnal</th>
                                    <!-- <th class="text-black text-center" scope="col">No Rek. Akuntansi</th> -->
                                    <th class="text-black text-center" scope="col">Keterangan</th>
                                    <!-- <th class="text-black text-center" scope="col">Debet</th>
                                    <th class="text-black text-center" scope="col">Kredit</th> -->
                                    <th scope="col">Act</th>
                                    <th class="column-hidden" scope="col">ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr row-seq="1">
                                    <td class="column-hidden"></td>
                                    <td class="p-0"><select name="coa_1" id="coa_1" class="form-control select2bs4staticBackdrop addnewrowselect" data-row="1" style="width: 100%;"></select></td>
                                    <td class="p-0"><input type="text" name="deskripsi_1" class="form-control form-control-sm" id="deskripsi_1"></td>
                                    <td class="p-0"><input type="text" name="debet_1" value="0" class="form-control form-control-sm cakautonumeric cakautonumeric-float" id="debet_1" placeholder="Enter Debet"></td>
                                    <td class="p-0"><input type="text" name="kredit_1" value="0" class="form-control form-control-sm cakautonumeric cakautonumeric-float" id="kredit_1" placeholder="Enter Kredit"></td>
                                    <td class="p-0 text-center"><i class="text-danger fas fa-minus-circle row-delete" id="row_delete_1" style="cursor: pointer;"></i></td>
                                    <td class="column-hidden"></td>
                                </tr> -->
                            </tbody>
                            
                        </table>
                        <div class="text-danger col-sm-12" id="caktable2_message"></div>
                        <input type="hidden" name="transaksi" class="form-control" id="transaksi" placeholder="Enter Menu Field">
                    </div>
                </div>
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
                                <!-- <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="coa">No. Rek. Akuntansi</label>
                                    <div class="col-sm-6 cakfield">
                                        <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                        </select>
                                        <input type="hidden" name="coa_label" id="coa_label">
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="deskripsi">Deskripsi</label>
                                    <div class="col-sm-6 cakfield">
                                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                    </div>
                                </div> -->
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
                                <!-- <div class="form-group row">
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
                                </div> -->
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