        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="/" class="brand-logo">
                <img class="logo-abbr" src="{{ asset ('/logo_instansi/'.Session::get('global_setting')) }} " alt="">
                <img class="logo-compact" src="{{ asset ('/logo_sia/'.Session::get('global_setting')->logo_sia) }} " alt="">
                <img class="brand-title" src="{{ asset ('/logo_sia/'.Session::get('global_setting')) }} " alt="">
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