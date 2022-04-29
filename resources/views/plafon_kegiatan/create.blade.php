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
                                            <input type="hidden" name="mode" value="create">
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="tahun">Tahun</label>
                                                <div class="col-sm-6 cakfield">
                                                    <select name="tahun" id="tahun" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                    </select>
                                                    <input type="hidden" name="tahun_label" id="tahun_label">
                                                </div>
                                            </div>
                                            <div class="form-group row m-0">
                                                <label class="col-sm-4 col-form-label" for="unit_pelaksana">Unit Pelaksana</label>
                                                <div class="col-sm-6 cakfield">
                                                    <select name="unit_pelaksana" id="unit_pelaksana" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                    </select>
                                                    <input type="hidden" name="unit_pelaksana_label" id="unit_pelaksana_label">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="ct1_detailbiayakegiatan">Detail Kegiatan</label>
                                                <div class="table-responsive">
                                                    <table id="caktable1" class="display" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="column-hidden">Proker ID</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Program Kerja</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Nama Kegiatan</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Deskripsi</th>
                                                                <th class="column-hidden">COA ID</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">COA</th>
                                                                <th scope="col" style="width: 15%; overflow: hidden;">Plafon</th>
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
                                                <input type="hidden" name="ct1_detailbiayakegiatan" class="form-control" id="ct1_detailbiayakegiatan" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
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