@extends('paging.main')

    @section('content')
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
                            <li class="breadcrumb-item active"><a href="/{{$page_data['page_data_urlname']}}">{{$page_data["page_data_name"]}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                        <div class="card-header" style="display:block">
                                <div class="form-group row m-0" style="height:40px;">
                                    <div class="col-sm-4">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Unit Pelaksana</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="unitkerja" id="unitkerja" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Tahun</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="tahun_periode" id="tahun_periode" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                                <?php for($i = 2018; $i < ((int) date("Y"))+3; $i++){ ?>
                                                    <option value="<?=$i;?>"<?=date("Y")==$i?" selected":""?>><?=$i;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>       
                                    <div class="col-sm-4">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey">Status</label>
                                        </div>
                                        <div class="col-sm-9 right">
                                            <select name="status" id="status" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                 @csrf
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead class="bg-primary">
                                            <tr>
                                                <!-- <th></th> -->
                                                <th width=20px>No</th>
                                                <th width=20px>Kode Anggaran</th>
                                                <th width=150px>Unit Pelaksana</th>
                                                <th>Tanggal</th>
                                                <!-- <th>IKU</th> -->
                                                <th width=250px>Nama</th>
                                                <th>Output</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><b>Warning!!</b></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger row-delete-confirmed">Hapus</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        <!--**********************************
            Content body end
        ***********************************-->
@endsection