    @extends('paging.main')

    @section('content')
    <form id="quickForm" action="#">
      @csrf
      <div class="form-group row">
        <label class="col-sm-4 col-form-label" for="mp_sequence">Menu Pack Sequence</label>
        <div class="col-sm-6">
          <input type="number" name="mp_sequence" class="form-control" id="mp_sequence" placeholder="Enter MP Sequence" @if($page_data["page_method_name"] == "View") readonly @endif>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label" for="menu_name">Menu Name</label>
        <div class="col-sm-6">
          <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Enter Menu Name" @if($page_data["page_method_name"] == "View") readonly @endif>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label" for="url">Url</label>
        <div class="col-sm-6">
          <input type="text" name="url" class="form-control" id="url" placeholder="Enter Url" @if($page_data["page_method_name"] == "View") readonly @endif>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-sm-4 col-form-label" for="menu_icon">Menu Icon</label>
        <div class="col-sm-6">
          <input type="text" name="menu_icon" class="form-control" id="menu_icon" placeholder="Enter Menu Icon" @if($page_data["page_method_name"] == "View") readonly @endif>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-6 offset-sm-4">
          <div class="form-check">
            <input type="checkbox" name="is_shown_at_side_menu" class="form-check-input" id="is_shown_at_side_menu" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>

            <label class="form-check-label">Shown at Menu Side</label>
          </div>
        </div>
      </div>
      
      <div class="form-group row">
        <!-- <label class="col-sm-4 col-form-label" for="ct1_menu">Menu</label> -->
        <div class="col-sm-10">
          <table id="ctt1_menu" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>MS</th>
                <th>Name</th>
                <th>Url</th>
                <th>Icon</th>
                <th>Shown at SM</th>
                <th>Action</th>
                <th>id</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
              <tr>
                <th>MS</th>
                <th>Name</th>
                <th>Url</th>
                <th>Icon</th>
                <th>Shown at SM</th>
                <th>Action</th>
                <th>id</th>
              </tr>
            </tfoot>
          </table>
          <input type="hidden" name="ct1_menu" class="form-control" id="ct1_menu" placeholder="Enter Menu" @if($page_data["page_method_name"] == "View") readonly @endif>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-sm-9 offset-sm-4">
          @if($page_data["page_method_name"] != "View")
            <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
          @endif
        </div>
      </div>
    </form>

    <div class="modal fade bd-example-modal-lg" id="ctm1_menu" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" id="ctm1_menuClose" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="ctf1_menu" action="#">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="ct1_menu_name">Menu Name</label>
                <div class="col-sm-6">
                  <input type="text" name="ct1_menu_name" class="form-control" id="ct1_menu_name" placeholder="Enter Menu Name" @if($page_data["page_method_name"] == "View") readonly @endif>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="ct1_url">Url</label>
                <div class="col-sm-6">
                  <input type="text" name="ct1_url" class="form-control" id="ct1_url" placeholder="Enter Url" @if($page_data["page_method_name"] == "View") readonly @endif>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label" for="ct1_menu_icon">Menu Icon</label>
                <div class="col-sm-6">
                  <input type="text" name="ct1_menu_icon" class="form-control" id="ct1_menu_icon" placeholder="Enter Menu Icon" @if($page_data["page_method_name"] == "View") readonly @endif>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-6 offset-sm-4">
                  <div class="form-check">
                    <input type="checkbox" name="ct1_is_shown_at_side_menu" class="form-check-input" id="ct1_is_shown_at_side_menu" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>

                    <label class="form-check-label">Shown at Menu Side</label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
      @endsection