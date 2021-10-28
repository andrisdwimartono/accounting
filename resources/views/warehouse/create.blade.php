@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="warehouse_name">Nama</label>
                                <div class="col-sm-6">
                                    <input type="text" name="warehouse_name" class="form-control" id="warehouse_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="address_1">Alamat 1</label>
                                <div class="col-sm-6">
                                    <input type="text" name="address_1" class="form-control" id="address_1" placeholder="Enter Alamat 1" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="address_2">Alamat 2</label>
                                <div class="col-sm-6">
                                    <input type="text" name="address_2" class="form-control" id="address_2" placeholder="Enter Alamat 2" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="description">Deskripsi</label>
                            <div class="col-sm-6">
                                <textarea name="description" class="form-control" id="description" placeholder="Enter Deskripsi" @if($page_data["page_method_name"] == "View") readonly @endif></textarea>
                            </div>
                        </div>
                    </div>
                    @if($page_data["page_method_name"] != "View")
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-4">
                        <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-4">

                        </div>
                    </div>
                    @endif
                </form>
@endsection