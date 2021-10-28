@extends('paging.main')

    @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div id="cto_overlay" class="overlay">
                        <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
                    </div>
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                @csrf
                <!-- /.card-header -->
                <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <a href="/create{{$page_data["page_data_urlname"]}}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Data"><i class="fas fa-plus text-white"></i></a>
                    </div>
                </div>
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

<!-- /.container-fluid -->
<div class="modal modal-warning fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#ffc107">
                <h4 class="modal-title"><b>Warning !</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#ffcb2e">
                <p>Apakah anda yakin ingin menghapus?</p>
            </div>
            <div class="modal-footer justify-content-between" style="background-color:#ffc107">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary row-delete-confirmed">Ok</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection