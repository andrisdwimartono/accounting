@if (Auth::user() == null){
    @include('login');
    @php
      die();
    @endphp
@endif
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:title" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:description" content="MotaAdmin - Bootstrap Admin Dashboard" />
    <meta property="og:image" content="https://motaadmin.dexignlab.com/xhtml/social-image.png" />
    <meta name="format-detection" content="telephone=no">
    
    <link rel="icon" href="{{ asset ("/logo_instansi/". Session::get('global_setting')->logo_instansi) }}">
 
    <title>SIA {{ Session::get('global_setting')->nama_instansi }} | {{$page_data["page_method_name"]}} {{$page_data["page_data_name"]}}</title>
  @if(isset($page_data["header_js_page_specific_script"]))
    @foreach($page_data["header_js_page_specific_script"] as $header_js_pss)
  @include($header_js_pss)
    @endforeach
  @endif
  </head>
<body>
  @php
    $path = Request::path();
    $path = explode("/", $path)[0];
    $path = str_replace("create", "", $path);
  @endphp
  <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

<input type="hidden" id="cakcurrent_url" value="{{$path}}">
<!--**********************************
    Main wrapper start
***********************************-->
<div id="main-wrapper">
  <div id="cto_overlay" class="overlay">
      <div id="cto_mengecek"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>
    </div>
		@include('paging.nav_header')  		
		@include('paging.chat_box')
		@include('paging.sidebar_fixed')
		@include('paging.header')
		@include('paging.sidebar')

        @yield('content')

		@include('paging.footer')      
</div>


 
@if(isset($page_data["footer_js_page_specific_script"]))
  @foreach($page_data["footer_js_page_specific_script"] as $footer_js_pss)
@include($footer_js_pss)
  @endforeach
@endif
</body>
</html>
