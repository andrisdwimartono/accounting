@extends("paging.main")

<script>    
  var menu="master"
</script>

@section("content")
                <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="member_level_name">Level</label>
                                <div class="col-sm-6">
                                    <input type="text" name="member_level_name" class="form-control" id="member_level_name" placeholder="Enter Level" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount_percentage">Persen Diskon</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount_percentage" class="form-control cakautonumeric cakautonumeric-float" id="discount_percentage" value="0" placeholder="Enter Persen Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label" for="discount">Nominal Diskon</label>
                                <div class="col-sm-6">
                                    <input type="text" name="discount" class="form-control cakautonumeric cakautonumeric-float" id="discount" value="0" placeholder="Enter Nominal Diskon" @if($page_data["page_method_name"] == "View") readonly @endif>
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
@endsection