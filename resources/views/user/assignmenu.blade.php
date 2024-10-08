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
                            <h4>Assign Role {{$page_data["id"]}}</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                            <li class="breadcrumb-item active"><a href="/{{$page_data['page_data_urlname']}}">{{$page_data['page_data_name']}}</a></li>
                        </ol>
                    </div>
                </div>

        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="card card-primary card-tabs">
              <div id="cto_overlay" class="overlay">
                <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
              </div>
              <form id="quickForm" action="#">
              @csrf
              <!-- 
              <div class="form-group row">
                <label class="col-sm-1 ml-2 col-form-label" for="role">Role</label>
                <div class="col-sm-6">
                  <select name="role" id="role" class="form-control select2-container" style="width: 100%;" @if($page_data["page_method_name"] == "View") readonly @endif>

                  </select>
                </div>
              </div> -->
              <div class="card-header p-0 pt-1">
                <input type="hidden" name="role_label" id="role_label">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  @php $index = 0 @endphp
                  @foreach ($menus as $menu)
                    @if ($menu->is_group_menu == 1 || $menu->is_group_menu == "on")
                  <li class="nav-item">
                    <a class="nav-link{{$index == 0?' active':''}}" id="tab-menu-{{$menu->id}}-tab" data-toggle="pill" href="#tab-menu-{{$menu->id}}" role="tab" aria-controls="tab-menu-{{$menu->id}}" aria-selected="true">{{$menu->menu_name}}</a>
                  </li>
                      @php $index++ @endphp
                    @endif
                  @endforeach
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Others</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  @php $index = 0 @endphp
                  @foreach ($menus as $menu)
                    @if ($menu->is_group_menu == 1 || $menu->is_group_menu == "on")
                  <div class="tab-pane fade show{{$index == 0?' active':''}}" id="tab-menu-{{$menu->id}}" role="tabpanel" aria-labelledby="tab-menu-{{$menu->id}}-tab">
                  @foreach ($menus as $menu_child)
                    @if ($menu_child->parent_id == $menu->id && $menu_child->is_group_menu != 1 && $menu_child->is_group_menu != "on")
                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="menu_{{$menu_child->id}}" name="menu_{{$menu_child->id}}">
                        <label class="custom-control-label{{$menu_child->is_view=='on'?' font-weight-bold':''}}" for="menu_{{$menu_child->id}}">{{$menu_child->menu_name}}</label>
                      </div>
                    </div>
                    @endif
                  @endforeach
                    </div>
                      @php $index++ @endphp
                    @endif
                  @endforeach
                    <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                      @foreach ($menus as $menu_child)
                      @if ($menu_child->parent_id == null && $menu_child->is_group_menu != 1 && $menu_child->is_group_menu != "on")
                      <div class="form-group">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="menu_{{$menu_child->id}}" name="menu_{{$menu_child->id}}">
                          <label class="custom-control-label{{$menu_child->is_view=='on'?' font-weight-bold':''}}" for="menu_{{$menu_child->id}}">{{$menu_child->menu_name}}</label>
                        </div>
                      </div>
                      @endif
                    @endforeach
                    </div>
                  </div>
                  @if($page_data["page_method_name"] != "View")
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" @if($page_data["page_method_name"] == "View") readonly @endif>Submit</button>
                </div>
                @endif
                </form>
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
      <!-- /.container-fluid -->
      </div>
      </div>
      @endsection