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
                            <li class="breadcrumb-item active"><a href="/transaction">Transaksi</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-sm-10">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Transaksi</h4>
                            </div>

                            <form id="quickForm" action="#">
                            @csrf
                                <div class="card-body">
                                        <div class="form-group row m-0">
                                            <label class="col-sm-4 col-form-label" for="unitkerja">Unit Kerja</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="unitkerja" id="unitkerja" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="unitkerja_label" id="unitkerja_label">
                                            </div>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label class="col-sm-4 col-form-label" for="journal_number">Nomor Jurnal</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="journal_number" class="form-control" id="journal_number" placeholder="Enter Nomor Jurnal" readonly @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row m-0">
                                            <label class="col-sm-4 col-form-label" for="anggaran_name">Nama Anggaran</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="anggaran_name" class="form-control" id="anggaran_name" placeholder="Enter Nama Anggaran" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                    
                                    
                                    <div class="form-group row m-0">
                                            <label class="col-sm-4 col-form-label" for="transaction_date">Tanggal</label>
                                            <div class="col-sm-6" id="reservationdatetime_transaction_date" data-target-input="nearest">
                                                <input type="text" name="transaction_date" id="transaction_date" class="form-control datetimepicker-input" data-target="#reservationdatetime_transaction_date">
                                            </div>
                                        </div>

                                    <div class="form-group row m-0">
                                        <label class="col-sm-4 col-form-label" for="description">Keterangan</label>
                                        <div class="col-sm-6 cakfield">
                                            <textarea name="description" class="form-control" id="description" placeholder="Enter Keterangan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row m-0">
                                        <label class="col-sm-4 col-form-label" for="transaction_type">Jenis Transaksi</label>
                                        <div class="col-sm-6 cakfield">
                                            <select name="transaction_type" id="transaction_type" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                            </select>
                                            <input type="hidden" name="transaction_type_label" id="transaction_type_label">
                                        </div>
                                    </div>
                                    <input type="hidden" name="transaction_detail" class="form-control" id="transaction_detail" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                    
                                    </form>
                                    <br>
                                    <br>
                                    <br>
                                    <form id="quickModalForm_transaction_detail" action="#">
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="coa">COA</label>
                                                <div class="col-sm-6 cakfield">
                                                    <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                    </select>
                                                    <input type="hidden" name="coa_label" id="coa_label">
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="description">Deskripsi</label>
                                                <div class="col-sm-6 cakfield">
                                                    <input type="text" name="description" class="form-control" id="description" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="debet">Debet</label>
                                                <div class="col-sm-6 cakfield">
                                                    <input type="text" name="debet" value="0" class="form-control cakautonumeric cakautonumeric-float" id="debet" placeholder="Enter Debet" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="credit">Kredit</label>
                                                <div class="col-sm-6 cakfield">
                                                    <input type="text" name="credit" value="0" class="form-control cakautonumeric cakautonumeric-float" id="credit" placeholder="Enter Kredit" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="va_code">Kode VA</label>
                                                <div class="col-sm-6 cakfield">
                                                    <input type="text" name="va_code" class="form-control" id="va_code" placeholder="Enter Kode VA" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            </div>
                                            <div class="modal-footer-child text-right">

                                            </div>
                                        
                                    <div class="form-group">
                                        <label for="transaction_detail">Detail Transaksi</label>
                                        <div id="result">
                                            Event result:
                                        </div>
                                        <table id="cttransaction_detail" class="table table-bordered table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>COA</th>
                                                    <th>COA Label</th>
                                                    <th>Deskripsi</th>
                                                    <th>Debet</th>
                                                    <th>Kredit</th>
                                                    <th>Kode VA</th>
                                                    <th>Action</th>
                                                    <th>id</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </form>
                                @if($page_data["page_method_name"] != "View")
                                <div class="form-group row m-0">
                                    <div class="col-sm-9 offset-sm-9">
                                    <button type="button" id="submitform" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                    </div>
                                </div>
                                @else
                                <div class="form-group row m-0">
                                    <div class="col-sm-9 offset-sm-9">

                                    </div>
                                </div>
                                @endif
                            
                            <!-- Modal Detail Transaksi -->
                            <div class="modal fade bd-example-modal-lg" id="staticBackdrop_transaction_detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" data-focus="false" role="dialog" aria-labelledby="staticBackdrop_transaction_detail_Label" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdrop_transaction_detail_Label">Detail Transaksi</h5>
                                        <button type="button" id="staticBackdrop_transaction_detail_Close" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                                    </div>
                                    <div class="modal-body">
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- Modal Detail Transaksi End -->
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection