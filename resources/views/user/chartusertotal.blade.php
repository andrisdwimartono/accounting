@extends("paging.main")

@section("content")
            <form id="quickForm" action="#">
                @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="start_date">Start Date</label>
                            <div class="col-sm-2">
                                <input type="text" name="start_date" id="start_date" class="form-control datepicker-input">
                            </div>
                            <div class="col-sm-1">
                                
                            </div>
                            <label class="col-sm-2 col-form-label" for="finish_date">Finish Date</label>
                            <div class="col-sm-2">
                                <input type="text" name="finish_date" id="finish_date" class="form-control datepicker-input">
                            </div>
                            <div class="col-sm-1">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
            </form>
            <div class="d-flex justify-content-center">
                <div id="myPlot" class="cakchart"></div>
            </div>
@endsection