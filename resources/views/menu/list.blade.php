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
                            <h4>{{$page_data["page_data_name"]}}</span>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/user">{{$page_data["page_data_name"]}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h4 class="card-title text-white">User</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                @csrf
                                <table id="example1" class="display" style="min-width: 845px">
                                        <thead class="bg-primary">
                                          <tr>
                                            <th>No</th>
                                            <th>MPS</th>
                                            <th>MS</th>
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th>Icon</th>
                                            <th>Shown at SM</th>
                                            <th>Action</th>
                                          </tr>
                                          </thead>
                                          <tfoot>
                                          <tr>
                                            <th>No</th>
                                            <th>MPS</th>
                                            <th>MS</th>
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th>Icon</th>
                                            <th>Shown at SM</th>
                                            <th>Action</th>
                                          </tr>
                                          </tfoot>
                                        </table>

                                      <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title"><b>Warning!!</b></h5>
                                              <button type="button" class="close" id="ctm1_menuClose" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
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