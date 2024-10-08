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
                            <!-- <h4>Hi, welcome back!</h4>
                            <span>Element</span> -->
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="/transaction">Transaksi</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">Transaksi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                 @csrf
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit Kerja</th>
                                            <th>Nomor Jurnal</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
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