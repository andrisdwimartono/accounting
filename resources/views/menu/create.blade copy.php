    @extends('paging.main')

    @section('content')
    <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div id="cto_overlay" class="overlay">
                <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
              </div>
              <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="#">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="mp_sequence">Menu Pack Sequence</label>
                    <input type="number" name="mp_sequence" class="form-control" id="mp_sequence" placeholder="Enter MP Sequence" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div>
                  <!-- <div class="form-group">
                    <label for="exampleInputM_sequence1">Menu Sequence</label>
                    <input type="text" name="m_sequence" class="form-control" id="exampleInputM_sequence1" placeholder="Enter M Sequence" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div> -->
                  <div class="form-group">
                    <label for="menu_name">Menu Name</label>
                    <input type="text" name="menu_name" class="form-control" id="menu_name" placeholder="Enter Menu Name" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div>
                  <div class="form-group">
                    <label for="url">Url</label>
                    <input type="text" name="url" class="form-control" id="url" placeholder="Enter Url" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div>
                  <div class="form-group">
                    <label for="menu_icon">Menu Icon</label>
                    <input type="text" name="menu_icon" class="form-control" id="menu_icon" placeholder="Enter Menu Icon" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="is_shown_at_side_menu" class="custom-control-input" id="is_shown_at_side_menu" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                      <label class="custom-control-label" for="is_shown_at_side_menu">Shown at Menu Side</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="ct1_menu">Menu</label>
                    <div id="result">
                        Event result:
                    </div>
                    <table id="ctt1_menu" class="table table-bordered table-striped" style="width:100%">
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
                    </table>
                    <input type="hidden" name="ct1_menu" class="form-control" id="ct1_menu" placeholder="Enter Menu" @if($page_data["page_method_name"] == "View") readonly @endif>
                  </div>
                </div>
                <!-- /.card-body -->
                @if($page_data["page_method_name"] != "View")
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                </div>
                @endif
              </form>

              <!-- Modal -->
              <div class="modal fade" id="ctm1_menu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ctm1_menuLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="ctm1_menuLabel">Menu</h5>
                    <button type="button" id="ctm1_menuClose" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                  </div>
                  <div class="modal-body">
                    <form id="ctf1_menu" action="#">
                    <div class="card-body">
                      <!-- <div class="form-group">
                        <label for="exampleInputCt1_m_sequence1">Menu Sequence</label>
                        <input type="text" name="ct1_m_sequence" class="form-control" id="exampleInputCt1_m_sequence1" placeholder="Enter M Sequence" @if($page_data["page_method_name"] == "View") readonly @endif>
                      </div> -->
                      <div class="form-group">
                        <label for="ct1_menu_name">Menu Name</label>
                        <input type="text" name="ct1_menu_name" class="form-control" id="ct1_menu_name" placeholder="Enter Menu Name" @if($page_data["page_method_name"] == "View") readonly @endif>
                      </div>
                      <div class="form-group">
                        <label for="ct1_url">Url</label>
                        <input type="text" name="ct1_url" class="form-control" id="ct1_url" placeholder="Enter Url" @if($page_data["page_method_name"] == "View") readonly @endif>
                      </div>
                      <div class="form-group">
                        <label for="ct1_menu_icon">Menu Icon</label>
                        <input type="text" name="ct1_menu_icon" class="form-control" id="ct1_menu_icon" placeholder="Enter Menu Icon" @if($page_data["page_method_name"] == "View") readonly @endif>
                      </div>
                      <div class="form-group">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="ct1_is_shown_at_side_menu" class="custom-control-input" id="ct1_is_shown_at_side_menu" @if($page_data["page_method_name"] == "View") disabled="disabled" @endif>
                          <label class="custom-control-label" for="ct1_is_shown_at_side_menu">Shown at Menu Side</label>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal end -->
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      @endsection