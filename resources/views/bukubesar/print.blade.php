<html>
    <head>
        <meta name="dompdf.view" content="FitV" />
        <title>Print COA</title>
        <link rel="stylesheet" href="{{ asset('public/assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" media="screen">
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

            .table tfoot tr td {
                padding: 2px 10px;
            }

            .rp{
                width:10px;
                border-right:none;
            }

            .nom{
                width:70px;
                border-left:none;
                text-align:right;
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
                        <h3>Laporan Buku Besar</h3>
                        <h4>Untuk Kode Rekening {{ $coa }}</h4> 
                        <h4>Periode {{ $bulan }} {{ $tahun }}</h5>
                    </td>
                    <td width="6em">
                        <img class='logo' src="{{ $logo }}" alt="{{ $globalsetting->nama_instansi }}">
                    </td>
                </tr>
            </table>
            <hr size=3>
            <hr size=2.5 style="margin-top:-5px; margin-bottom:20px;">
        </header>

        <footer>
        </footer>

        <main>
        <table class="table" border=1 style="margin:20px -50px">
                <thead >
                    <tr>
                        <td scope="col" width="100px">Tanggal</th>
                        <td scope="col" width="100px">No Jurnal</th>
                        <td scope="col" width="200px">Deskripsi</th>
                        <td scope="col" colspan=2 width="100px">Debet</th>
                        <td scope="col" colspan=2 width="100px">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukubesar['data'] as $d)
                    <tr>
                        <td scope="col" width="100px">{!! $d[1] !!}</td>
                        <td scope="col" width="100px">{!! $d[2] !!}</td>
                        <td scope="col" width="200px">{!! $d[3] !!}</td>
                        {!! $d[4] !!}
                        {!! $d[5] !!}
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="border:none;"></td>
                        <td  style="border:none;"></td>
                        <td class="nom" style="border:none;"><b>JUMLAH</b></td>
                        {!! $bukubesar['deb'] !!}
                        {!! $bukubesar['cre'] !!}                        
                    </tr>
                    <tr>
                        <td style="border:none;"></td>
                        <td  style="border:none;"></td>
                        <td class="nom" style="border:none;"><b>SALDO</b></td>
                        {!! $bukubesar['sal_deb'] !!}
                        {!! $bukubesar['sal_cre'] !!}                        
                    </tr>
                </tfoot>
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