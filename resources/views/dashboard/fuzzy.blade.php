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
                <div class="col-6">
                    @csrf
                    <div class="card">
                        <div class="card-header"><h4 class="output-header">Pendapatan</h4></div>
                        <div class="card-body">
                            <table id="neraca" class="display" style="width: 100%;">
                                <!-- <thead >
                                    <tr>
                                        <th class="column-hidden">No</th>
                                        <th>Kode Rek.</th>
                                        <th>Nama Rekening Akuntansi</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th class="column-hidden">Level COA</th>
                                    </tr>
                                </thead> -->
                                <tfoot>
                                    <tr>
                                        <td class="right total"></td>
                                        <td class="total" style="border-top: 1px solid #000 !Important;"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>                
                </div>
                <div class="col-6">
                    @csrf
                    <div class="card">
                        <div class="card-header"><h4 class="output-header">Pengeluaran</h4></div>
                        <div class="card-body">
                            
                        </div>
                    </div>                
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header"><h4 class="output-header">Analisis</h4></div>
                        <div class="card-body">
                        
                    </div>                
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
@endsection