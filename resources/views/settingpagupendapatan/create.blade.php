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
                                                    <label class="col-sm-4 col-form-label" for="tahun">Tahun</label>
                                                    <div class="col-sm-6 cakfield">
                                                        <select name="tahun" id="tahun" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                                        </select>
                                                        <input type="hidden" name="tahun_label" id="tahun_label">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group d-none" >
                                                    <label for="ct1_nilaipagu">Nilai Pagu / Plafon</label>
                                                    <div id="result">
                                                        Event result:
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="caktable1" class="display" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="column-hidden" scope="col">No</th>
                                                                    <th scope="col" style="width: 65%; overflow: hidden;">Unit Kerja</th>
                                                                    <th scope="col" style="width: 35%; overflow: hidden;">Nominal</th>
                                                                    <th scope="col" style="width: 10%;"></th>
                                                                    <th scope="col" class="column-hidden"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="p-0">
                                                                    <td class="column-hidden"></td>
                                                                        <td class="text-center">
                                                                            <div class="form-group row m-0 p-0 properties">
                                                                                <div class="mr-auto">
                                                                                    @if($page_data["page_method_name"] == "Create"  || $page_data["page_method_name"] == "Update"  ||($page_data["lastapprove"] && $page_data["lastapprove"]->role == Auth::user()->role) || ($page_data["nextapprove"] && $page_data["nextapprove"]->role == Auth::user()->role)) 
                                                                                        <button type="button" id="addrow" class="btn btn-primary shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Pagu"><i class="fa fa-plus"></i></button>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="ml-auto ">
                                                                                        Total :
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="p-0 text-right" id="totalnom"></td>
                                                                        <!-- <td class="p-0 text-right" id="totalkredit"></td> -->
                                                                        @if($page_data["page_method_name"] == "View")
                                                                            <td class="p-0"></td>
                                                                        @else
                                                                            <td class="p-0"></td>
                                                                        @endif
                                                                        <td class="column-hidden"></td>
                                                                        
                                                                    </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    
                                                    <input type="hidden" name="ct1_nilaipagu" class="form-control" id="ct1_nilaipagu" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                                
                                                <div class="form-group" >
                                                    <label for="ct2_potensipendapatan">Nilai Potensi Pendapatan</label>
                                                    <div id="result">
                                                        Event result:
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="caktable2" class="display" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th class="column-hidden" scope="col">No</th>
                                                                    <th scope="col" style="width: 30%; overflow: hidden;">Unit Kerja</th>
                                                                    <th scope="col" style="width: 35%; overflow: hidden;">Kode Rekening Pendapatan</th>
                                                                    <th scope="col" style="width: 35%; overflow: hidden;">Nominal</th>
                                                                    <th scope="col" style="width: 10%;"></th>
                                                                    <th scope="col" class="column-hidden"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="p-0">
                                                                    <td class="column-hidden"></td>
                                                                        <td class="text-center">
                                                                            <div class="form-group row m-0 p-0 properties">
                                                                                <!-- <button type="button" id="createnew" class="btn btn-warning shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Tabel"><i class="fa fa-trash"></i></button>
                                                                                <button type="button" class="btn btn-success shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan Anggaran" id="submit-form" @if($page_data["page_method_name"] == "View") readonly @endif><i class="fa fa-save"></i></button> -->
                                                                                @if($page_data["page_method_name"] == "Create"  || $page_data["page_method_name"] == "Update"  ||($page_data["lastapprove"] && $page_data["lastapprove"]->role == Auth::user()->role) || ($page_data["nextapprove"] && $page_data["nextapprove"]->role == Auth::user()->role)) 
                                                                                    <button type="button" id="addrow2" class="btn btn-primary shadow btn-xs sharp"  data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Pagu"><i class="fa fa-plus"></i></button>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                        <td class="p-0 text-right">Total : </td>
                                                                        <td class="p-0 text-right" id="totalnom2"></td>
                                                                        <!-- <td class="p-0 text-right" id="totalkredit"></td> -->
                                                                        @if($page_data["page_method_name"] == "View")
                                                                            <td class="p-0"></td>
                                                                        @else
                                                                            <td class="p-0"></td>
                                                                        @endif
                                                                        <td class="column-hidden"></td>
                                                                        
                                                                    </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    
                                                    <input type="hidden" name="ct2_potensipendapatan" class="form-control" id="ct2_potensipendapatan" placeholder="Enter Menu Field" @if($page_data["page_method_name"] == "View") readonly @endif>
                                                </div>
                                            
                                        </div>
                                        @if($page_data["page_method_name"] != "View")
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-9">
                                                <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group row justify-content-center">
                                            <div class="col-sm-4">
                                                @if(($page_data["lastapprove"] && $page_data["lastapprove"]->role == Auth::user()->role_label) || ($page_data["nextapprove"] && $page_data["nextapprove"]->role == Auth::user()->role_label))
                                                <button type="button" class="btn btn-danger" id="rejectrka"><i class="fas fa-trash"></i> Tolak</button>
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="button" class="btn btn-success" id="historyrka"><i class="fas fa-list"></i> Histori</button>
                                            </div>
                                            <div class="col-sm-4">
                                                @if(($page_data["lastapprove"] && $page_data["lastapprove"]->role == Auth::user()->role_label) || ($page_data["nextapprove"] && $page_data["nextapprove"]->role == Auth::user()->role_label))
                                                <button type="button" class="btn btn-primary" id="approverka"><i class="fas fa-check"></i> Terima</button>
                                                @endif
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
                                
                                @if($page_data["page_method_name"] == "View")
                                <!-- Modal Reject RKA -->
                                <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><b>Warning!!</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <textarea name="alasan_tolak" class="form-control m-2" id="alasan_tolak" placeholder="Tulis alasan mengtolak jurnal"></textarea>
                                                    <span class="d-none text-danger m-2" id="alasan_tolak_error"></span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" id="rejectrka-confirmed">Tolak</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal Tolak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Accept RKA -->
                                <div class="modal fade" id="modal-accept" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><b>Warning!!</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah anda yakin terima RKA ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" id="approverka-confirmed">Terima</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal Terima</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal History RKA -->
                                <div class="modal fade" id="modal-history" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><b>History RKA</b></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="historykegiatan" class="justify-content-center">
                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection