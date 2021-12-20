<script>    
  var menu="settings"
</script>

@extends("paging.main")

@section("content")



<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <!-- <div class="row page-titles mx-0">
                    <div class="col-sm-10 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <span>Element</span>
                        </div>
                    </div>
                    <div class="col-sm-10 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/coa">COA</a></li>
                        </ol>
                    </div>
                </div> -->
                <!-- row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                           
                            <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="prodi_name">Prodi</label>
                                <div class="col-sm-6 cakfield">
                                    <input type="text" name="prodi_name" class="form-control" id="prodi_name" placeholder="Enter Prodi" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="kode">Kode Prodi</label>
                                <div class="col-sm-6 cakfield">
                                    <input type="text" name="kode" class="form-control" id="kode" placeholder="Enter Kode Prodi" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="fakultas">Fakultas</label>
                                <div class="col-sm-6 cakfield">
                                    <select name="fakultas" id="fakultas" class="form-control select2bs4" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                                    </select>
                                    <input type="hidden" name="fakultas_label" id="fakultas_label">
                                </div>
                            </div>
                    </div>
                    @if($page_data["page_method_name"] != "View")
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">
                        <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-9">

                        </div>
                    </div>
                    @endif
                </form>

            </div>
                    </div>
                </div>
            </div>
        </div>
@endsection