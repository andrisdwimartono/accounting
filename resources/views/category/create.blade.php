@extends("paging.main")

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="category_name">Nama</label>
                                <div class="col-sm-6">
                                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Enter Nama" @if($page_data["page_method_name"] == "View") readonly @endif>
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