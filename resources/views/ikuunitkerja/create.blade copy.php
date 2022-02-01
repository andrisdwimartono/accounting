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
                                    <form id="quickForm" action="#" >
                                        @csrf
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="jenis_iku">Jenis IKU</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="jenis_iku" id="jenis_iku" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="jenis_iku_label" id="jenis_iku_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="iku_name">Nama</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="iku_name" class="form-control" id="iku_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unit_pelaksana">Unit Pelaksana</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="unit_pelaksana" id="unit_pelaksana" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="unit_pelaksana_label" id="unit_pelaksana_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="unit_pendukung">Unit Pendukung</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="unit_pendukung" id="unit_pendukung" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="unit_pendukung_label" id="unit_pendukung_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_standar_opt">Nilai Standar Tanda</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="nilai_standar_opt" id="nilai_standar_opt" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="nilai_standar_opt_label" id="nilai_standar_opt_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_standar">Nilai Standar</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="nilai_standar" class="form-control cakautonumeric cakautonumeric-integer" id="nilai_standar" value="0" placeholder="Enter Nilai Standar" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="satuan_nilai_standar">Satuan Nilai Standar</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="satuan_nilai_standar" id="satuan_nilai_standar" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="satuan_nilai_standar_label" id="satuan_nilai_standar_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_baseline_opt">Nilai Baseline Tanda</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="nilai_baseline_opt" id="nilai_baseline_opt" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="nilai_baseline_opt_label" id="nilai_baseline_opt_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_baseline">Nilai Baseline</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="nilai_baseline" class="form-control cakautonumeric cakautonumeric-integer" id="nilai_baseline" value="0" placeholder="Enter Nilai Baseline" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="satuan_nilai_baseline">Satuan Nilai Baseline</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="satuan_nilai_baseline" id="satuan_nilai_baseline" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="satuan_nilai_baseline_label" id="satuan_nilai_baseline_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_renstra_opt">Nilai Renstra Tanda</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="nilai_renstra_opt" id="nilai_renstra_opt" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="nilai_renstra_opt_label" id="nilai_renstra_opt_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_renstra">Nilai Renstra</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="nilai_renstra" class="form-control cakautonumeric cakautonumeric-integer" id="nilai_renstra" value="0" placeholder="Enter Nilai Renstra" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="satuan_nilai_renstra">Satuan Nilai Renstra</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="satuan_nilai_renstra" id="satuan_nilai_renstra" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="satuan_nilai_renstra_label" id="satuan_nilai_renstra_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_target_tahunan_opt">Nilai Target TahunanTanda</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="nilai_target_tahunan_opt" id="nilai_target_tahunan_opt" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="nilai_target_tahunan_opt_label" id="nilai_target_tahunan_opt_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="nilai_target_tahunan">Nilai Target Tahunan</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="nilai_target_tahunan" class="form-control cakautonumeric cakautonumeric-integer" id="nilai_target_tahunan" value="0" placeholder="Enter Nilai Target Tahunan" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="satuan_nilai_target_tahunan">Satuan Nilai Target Tahunan</label>
                                            <div class="col-sm-6 cakfield">
                                                <select name="satuan_nilai_target_tahunan" id="satuan_nilai_target_tahunan" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                </select>
                                                <input type="hidden" name="satuan_nilai_target_tahunan_label" id="satuan_nilai_target_tahunan_label">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="keterangan">Keterangan</label>
                                            <div class="col-sm-6 cakfield">
                                                <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Enter Keterangan" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="sumber_data">Sumber Data</label>
                                            <div class="col-sm-6 cakfield">
                                                <textarea name="sumber_data" class="form-control" id="sumber_data" placeholder="Enter Sumber Data" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label" for="rujukan">Rujukan</label>
                                            <div class="col-sm-6 cakfield">
                                                <input type="text" name="rujukan" class="form-control" id="rujukan" placeholder="Enter Rujukan" @if($page_data["page_method_name"] == "View") readonly @endif>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection