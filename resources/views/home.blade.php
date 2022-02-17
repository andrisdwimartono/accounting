@extends('paging.main')

@section('content')
<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body" style="min-height:350px;">
                                <center>
                                    <h2>Selamat Datang</h2>
                                    @if($globalsetting->logo_sia)
                                        <img class="mb-4" src="{{ asset ('/logo_instansi/'.$globalsetting->logo_instansi) }}" alt="" height="100">
                                    @else
                                        <img class="mb-4" src="{{ asset ('/assets/images/logo_sia_default.png') }}" alt="" height="100">
                                    @endif
                                    <h4>{{$globalsetting->nama_sia}}</h4>
                                </center>
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