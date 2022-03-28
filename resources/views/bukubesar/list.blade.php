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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan</a></li>
                            <li class="breadcrumb-item active"><a href="">{{$page_data["page_data_name"]}}</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                <div class="col-12">
                        <div class="card">
                        @csrf
                        <div class="card-header" style="display:block">
                                <div class="form-group row m-0" style="height:40px;">
                                    <div class="col-sm-3">
                                        <div class="col-sm-2 left">
                                            <label class="text-grey">Kode Rek.</label>
                                        </div>
                                        <div class="col-sm-10 right">
                                            <select name="coa" id="coa" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey" for="tanggal_jurnal_from">Dari</label>
                                        </div>
                                        <div class="col-sm-9 right cakfield">
                                            <input name="tanggal_jurnal_from" id="tanggal_jurnal_from" class="datepicker-default form-control form-control-sm bg-primary mt-1">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-3 left">
                                            <label class="text-grey" for="tanggal_jurnal_to">Ke</label>
                                        </div>
                                        <div class="col-sm-9 right cakfield">
                                            <input name="tanggal_jurnal_to" id="tanggal_jurnal_to" class="datepicker-default form-control form-control-sm bg-primary mt-1">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="col-sm-2 left">
                                            <label class="text-grey">Unit Kerja</label>
                                        </div>
                                        <div class="col-sm-10 right">
                                            <select name="unitkerja" id="unitkerja" class="form-control select2bs4staticBackdrop" data-row="1" style="width: 100%;">
                                            </select>
                                            <input type="hidden" name="unitkerja_label" id="unitkerja_label">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body">                                

                                <div class="table-responsive">
                                 
                                    <table id="bukubesar" class="display" style="width:100%;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th class="column-hidden">No</th>
                                                <th>Tanggal</th>
                                                <th>No Jurnal</th>
                                                <th>Keterangan</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td class="column-hidden"></td>
                                                <td></td>
                                                <td></td>
                                                <td class="right total"></td>
                                                <td class="total" style="border-top: 1px solid #000 !Important;"></td>
                                                <td class="total" style="border-top: 1px solid #000 !Important;"></td>
                                            </tr>
                                            <tr>
                                                <td class="column-hidden"></td>
                                                <td></td>
                                                <td></td>
                                                <td class="right total"></td>
                                                <td class="total" style="border-top: 1px solid #d7dae3 !Important;"></td>
                                                <td class="total" style="border-top: 1px solid #d7dae3 !Important;"></td>
                                            </tr>
                                            <tr>
                                                <td class="column-hidden"></td>
                                                <td></td>
                                                <td></td>
                                                <td class="right total"></td>
                                                <td class="total" style="border-top: 1px solid #d7dae3 !Important;"></td>
                                                <td class="total" style="border-top: 1px solid #d7dae3 !Important;"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
