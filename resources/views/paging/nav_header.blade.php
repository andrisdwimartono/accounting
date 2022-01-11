        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/" class="brand-logo">
                
                @if(isset(Session::get('global_setting')->logo_instansi))
                    <img class="logo-abbr" src="{{ asset ('/logo_instansi/'.Session::get('global_setting')->logo_instansi) }} " alt="">
				@else
                    <img class="logo-abbr" src="{{ asset ('/assets/images/logo_default.png') }} " alt="">
                @endif

                @if(isset(Session::get('global_setting')->logo_sia))
                    <img class="logo-compact" src="{{ asset ('/logo_sia/'.Session::get('global_setting')->logo_sia) }} " alt="">
                    <img class="brand-title" src="{{ asset ('/logo_sia/'.Session::get('global_setting')->logo_sia) }} " alt="">
				@else
                    <img class="logo-compact" src="{{ asset ('/assets/images/logo_sia_default.png') }} " alt="">
                    <img class="brand-title" src="{{ asset ('/assets/images/logo_sia_default.png') }} " alt="">
                @endif

            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->