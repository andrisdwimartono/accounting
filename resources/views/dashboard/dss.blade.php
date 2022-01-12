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
                            <h4>DSS</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="">DSS</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                    @csrf
                    <div class="card">
                        <div class="card-header"><h4 class="output-header"></h4></div>
                        <div class="card-body">  
                            <div id="output" style="min-height: 500px;overflow:auto"></div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection