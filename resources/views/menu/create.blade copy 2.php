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
        <label class="col-sm-4 col-form-label" for="ct1_menu">Menu</label>
        <div class="col-sm-6">
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
        <label class="col-sm-4 col-form-label" for="email">Email</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" id="email" name="email" placeholder="Email" />
        </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="password">Password</label>
          <div class="col-sm-6">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="confirm_password">Confirm password</label>
          <div class="col-sm-6">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password" />
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="nomor">Nomor</label>
          <div class="col-sm-6">
              <input type="number" class="form-control" id="nomor" name="nomor" placeholder="Nomor" />
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="reservationdatetime_datetimecoba">Date Time Coba</label>
          <div class="col-sm-6">
              <input type="text" name="datetimecoba" id="datetimecoba" class="form-control datetimepicker-input">
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="reservationdate_datecoba">Date Coba</label>
          <div class="col-sm-6">
              <input type="text" name="datecoba" id="datecoba" class="form-control datepicker-input">
          </div>
      </div>

      <div class="form-group row">
          <label class="col-sm-4 col-form-label" for="confirm_password">States</label>
          <div class="col-sm-6">
              <select class="form-control select2-container" style="width: 100%;" name="states">
                  <option value="AL">Alabama</option>
                  <option value="WY">Wyoming</option>
              </select>
          </div>
      </div>

      <div class="form-group row">
          <div class="col-sm-6 offset-sm-4">
              <div class="form-check">
                  <input type="checkbox" id="agree" name="agree" value="agree" class="form-check-input"/>
                  <label class="form-check-label">Please agree to our policy</label>
              </div>
          </div>
      </div>

      <div class="form-group row">
          <div class="col-sm-9 offset-sm-4">
              <button type="submit" class="btn btn-primary" name="signup" value="Sign up">Sign up</button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button>
          </div>
      </div>
    </form>
      @endsection