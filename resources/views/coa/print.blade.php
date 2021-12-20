<html>
    <head>
        <meta name="dompdf.view" content="FitV" />
        <title>Print COA</title>
        <style>
            @page {
                size: A4;
                margin: 200px 50px 100px;
            }

            header {
                position: fixed;
                top: -160px;
                height: 110px;
                text-align: center;
                line-height: 10px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
            }

            main {
                top:200px;
                padding : 0px 25px;
            }

            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;
                }
            }
            .page-break {
                page-break-after: always;
            }

            h2 h3 h4{
                font-family: Arial, Helvetica, sans-serif;
            }

            h4{
                font-weight: normal;
            }

            .logo{
                width:100%;
                text-align:left;
            }
            .table{
                width:100%;
                border-collapse: collapse;
            }

            .table thead tr td{
                font-weight:bold;
                height:30px;
                text-align: center;
                background: #d7d7d7;
            }

            .table tbody tr td {
                padding: 2px 10px;
            }

        </style>
    </head>
    <body>
        <header>
            <table>
                <tr>
                    <td width="6em"></td>
                    <td width="30em" style="text-align:center">
                        <h2>Universitas Muhammadiyah Sidoarjo</h2>
                        <h3>Laporan Kode Rekening Akuntansi</h3>
                        <?php foreach($page_data["fieldsoptions"]["category"] as $cat){ 
                            if($cat["name"] == $data->category_filter){
                            ?>
                        <h4>Untuk Kategori <?=$cat["label"]?></h5>
                        <?php } } ?> 
                    </td>
                    <td width="6em">
                        <img class='logo' src="{{ public_path() }}'.'/logo_instansi/'.$globalsetting->logo_instansi) }}" alt="UMSIDA">
                        <img class='logo' src="{{ public_path() }}'.'/logo_instansi/'.'logo_instansi1639985681.jpg') }}" alt="UMSIDA">
                        
                        <!-- <img src="http://103.139.25.136:8080/logo_instansi/logo_instansi1639985681.jpg"> -->
                    </td>
                </tr>
            </table>
            <hr size=3>
            <hr size=2.5 style="margin-top:-5px;">
        </header>

        <footer>
        </footer>

        <main>
            <table class="table" border=1>
                <thead>
                    <tr>
                        <td scope="col" width="100px">Kode</td>
                        <td scope="col" width="250px">Nama</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coa['data'] as $c)
                    <tr>
                        <td scope="col" width="100px">{!! $c[1] !!}</td>
                        <td scope="col" width="250px">{!! $c[2] !!}</td>
                    </tr>
                    <!-- <div class="page-break"></div> -->
                    @endforeach
                </tbody>
            </table>
        </main>
        <script type="text/php">
        if ( isset($pdf) ) { 
            $pdf->page_script('
                if ($PAGE_COUNT > 1) {
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $size = 12;
                    $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                    $y = 15;
                    $x = 520;
                    $pdf->text($x, $y, $pageText, $font, $size);
                } 
            ');
        }
        </script>
    </body>
</html>