<html>
    <head>
        <meta name="dompdf.view" content="FitV" />
        <title>Print Laba Rugi</title>
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
                        <?php $nama_bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"); ?>
                        <h4>Print Laba Rugi Bulan <?=$nama_bulan[$bulan_periode]?> <?=$tahun_periode?></h5>
                    </td>
                    <td width="6em">
                        <img class='logo' src="{{ asset('/logo_instansi/'.$globalsetting->logo_instansi) }}" alt="UMSIDA">
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
                        <td scope="col" width="150px">Kode Rek.</td>
                        <td scope="col" width="250px">Nama Rekening Akuntansi</td>
                        <td scope="col" width="80px">Debet</td>
                        <td scope="col" width="80px">Kredit</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $debet = 0;
                        $credit = 0;
                    ?>
                    @foreach($labarugi['data'] as $c)
                    <?php 
                        $debet = $debet+($c[5]!="on"?$c[2]:0);
                        $credit = $credit+($c[5]!="on"?$c[3]:0);
                    ?>
                    <tr>
                        <td scope="col" width="150px">{!! convertCode(explode(" ",$c[1])[0], $c[4]) !!}</td>
                        <td scope="col" width="250px"><span style='padding-left:<?=(((int) $c[4]-1)*10)?>px'>{!! str_replace(explode(" ",$c[1])[0],"",$c[1]) !!}</span></td>
                        <td scope="col" width="80px">{!! $c[5]!="on"?number_format($c[2],2,",","."):"" !!}</td>
                        <td scope="col" width="80px">{!! $c[5]!="on"?number_format($c[3],2,",","."):"" !!}</td>
                    </tr>
                    <!-- <div class="page-break"></div> -->
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align:right;padding-right:3px;">Jumlah</td>
                        <td><?=number_format($debet,2,",",".")?></td>
                        <td><?=number_format($credit,2,",",".")?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;padding-right:3px;"><?=$debet-$credit>0?"Surplus":"Defisit"?></td>
                        <td><?=$debet-$credit>0?number_format($debet-$credit,2,",","."):""?></td>
                        <td><?=$debet-$credit<=0?number_format($credit-$debet,2,",","."):""?></td>
                    </tr>
                </tfoot>
            </table>
        </main>
        <?php
            function convertCode($data, $level){
                $val = substr($data,0,1) . "-" . substr($data,1,2) . "-" . substr($data,3,2) . "-" . substr($data,5);
                $padd = (((int) $level-1)*10);
                $html = "<span style='padding-left:".strval($padd)."px'>".$val."</span>";        
                return $html;
            }
        ?>
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

        <script type="text/Javascript">
            $.ajax({
                url: "/getglobalsetting",
                type: "get",
                success: function(data){
                    $(".logo-abbr").attr("src", "/logo_instansi/"+data.data.globalsetting.logo_instansi);
                },
                error: function (err) {
                    console.log(err);
                }
            });
            cto_loading_show();
            $.ajax({
                url: "/getlistlabarugi",
                type: "post",
                data: $("#formprint").serialize(),
                success: function(data){
                    var list_data = JSON.parse(data);
                    for(var i = 0; i < list_data.data.length; i++){
                        var row = "<tr>";
                        var padd = 10+((parseInt(list_data.data[i][3])-1)*10)+"px";
                        var val = list_data.data[i][8] == "on"?"<span><b>"+convertCode(list_data.data[i][1])+"</b></span>":"<span>"+convertCode(list_data.data[i][1])+"</span>";
                        row += "<td style=\"padding-left: "+padd+"\">"+val+"</td>";
                        val = list_data.data[i][8] == "on"?"<span><b>"+list_data.data[i][2]+"</b></span>":"<span>"+list_data.data[i][2]+"</span>";
                        row += "<td>"+val+"</td>";
                        row += "</tr>";
                        $("#table_body").append(row);
                    }
                    
                    cto_loading_hide();
                },
                error: function (err) {
                    if (err.status == 422) {
                        $.each(err.responseJSON.errors, function (i, error) {
                            var validator = $("#quickForm").validate();
                            var errors = {};
                            errors[i] = error[0];
                            validator.showErrors(errors);
                        });
                    }
                    //cto_loading_hide();
                }
            });
            function convertCode(data){
                var val = "";
                for(var i = 0; i < data.length; i++){
                    if(i == 0){
                    val = val+data.charAt(i)+"-";
                    }else if(i == 2 || i == 4){
                    val = val+data.charAt(i)+"-";
                    }else if(i > 4 && (i-4)%3 == 0 && i != data.length-1){
                    val = val+data.charAt(i)+"-";
                    }else{
                    val = val+data.charAt(i);
                    }
                }
                return val;
            }
        </script>
    </body>
</html>