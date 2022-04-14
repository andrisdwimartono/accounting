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
                                                <label class="col-sm-4 col-form-label" for="programkerja_code">Kode</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="programkerja_code" class="form-control" id="programkerja_code" placeholder="###-YY-PK" readonly>
                                                    <span class="text-secondary">Otomatis dibuat oleh sistem</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="programkerja_name">Nama Program Kerja</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="programkerja_name" class="form-control" id="programkerja_name" placeholder="Enter Nama Program Kerja" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label" for="deskripsi_programkerja">Deskripsi</label>
                                                <div class="col-sm-6">
                                                    <textarea name="deskripsi_programkerja" class="form-control" id="deskripsi_programkerja" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="type_programkerja" id="type_programkerja" placeholder="Enter type" value="utama">
                                            
                                            <div class="form-group">
                                                <label for="ct1_detailbiayaproker">Detail RKA</label>
                                                <div class="table-responsive">
                                                    <table id="caktable1" class="display" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Biaya</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Deskripsi</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Volume</th>
                                                                <th class="column-hidden">Satuan</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Satuan Label</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Biaya Satuan</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Standar Biaya</th>
                                                                <th scope="col" style="width: 10%; overflow: hidden;">Act</th>
                                                                <th class="column-hidden">id</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="p-0">
                                                                <td class="column-hidden"></td>
                                                                    <td class="text-center">
                                                                        <div class="form-group row m-0 p-0 properties ms-auto">
                                                                            @if($page_data["page_method_name"] == "Create"  || $page_data["page_method_name"] == "Update") 
                                                                                <button type="button" id="addrow" class="btn btn-primary shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Anggaran"><i class="fa fa-plus"></i></button>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                    
                                                                    <td class="p-0 text-right"></td>
                                                                    <td class="p-0 text-right"></td>
                                                                    <td class="p-0 text-right"></td>
                                                                    <td class="p-0 text-right">
                                                                        <div class="form-group row m-0 p-0 properties ms-auto">
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
                                                <input type="hidden" name="ct1_detailbiayaproker" class="form-control" id="ct1_detailbiayaproker" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                            </div>
                                        </div>
                                        @if($page_data["page_method_name"] != "View")
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-9">
                                                <button type="submit" id="trysubmit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection