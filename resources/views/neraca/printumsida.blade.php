<html>
    <head>
        <meta name="dompdf.view" content="FitV" />
        <title>Print Laporan Posisi Keuangan</title>
        <style>
            @page {
                size: A4;
                margin: 50px 50px 100px;
            }

            main {
                top:10px;
                padding : 0px 5px;
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
                width:100px;
                text-align:left;
            }
            .table{
                width:100%;
                table-layout: fixed;
            }

            .table thead tr td{
                font-weight:bold;
                height:30px;
                text-align: center;
                background: #002060;
                color: #ffffff;
            }

            .table tbody tr td {
                font-size: 14px;
            }

            .table tfoot tr td {
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
        <table border="1" width="490px" class="table">
            <thead>
                <tr>
                    <td colspan=7></td>
                </tr>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan=2 rowspan="3"><img class='logo' src="{{ $logo }}" alt="{{ $globalsetting->nama_instansi }}"></td>
                    <td colspan=5>{{ Session::get('global_setting')->nama_lengkap_instansi }}</td>
                </tr>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan=5>Laporan Penghasilan Komprehensif</td>
                </tr>
                <tr style="text-align:center; font-weight:bold;">
                    <td colspan=5>Periode {{$transactions['bulan']}} {{$transactions['tahun']}}</td>
                </tr>
                <tr><td colspan=7></td></tr>

                <tr>
                    <th width="70px"></th>
                    <th width="70px"></th>
                    <th width="70px"></th>
                    <th width="70px"></th>
                    <th width="50px">Catatan</th>
                    <th width="80px">{{$transactions['bulan_before']}} {{$transactions['tahun_before']}}</th>
                    <th width="80px">{{$transactions['bulan']}} {{$transactions['tahun']}}</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $last3_account = "";
                    $total3_debet = 0;
                    $total3_credit = 0;

                    $first = true;
                    $last_level_2 = "";
                    $total_level_2 = 0;
                    $total_level_2_before = 0;
                ?>
                @foreach($transactions['data'] as $transaction)
                <?php if($transaction[6]==2 && $last3_account == ""){ 
                    $last3_account = $transaction[2]; } 
                ?>
                <?php 
                    $total3_debet = $total3_debet + (double)$transaction[3];
                    $total3_credit = $total3_credit + (double)$transaction[4];

                    if($transaction[6] == 2 || $transaction[6] == 1){
                        if(!$first){
                            //print last jumlah
                            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">Jumlah {{ $last_level_2 }}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($total_level_2_before, 0, ",", ".") }}</td>
                    <td style="text-align: right;">{{ number_format($total_level_2, 0, ",", ".") }}</td>
                </tr>

                            <?php
                        }
                        $first = false;
                        $last_level_2 = $transaction[2];
                        $total_level_2 = $transaction[3];
                        $total_level_2_before = $transaction[4];
                        if($transaction[6] == 1){
                            $first = true;
                        }
                    }
                ?>
                <tr>
                    @if($transaction[6]==1)
                    <td colspan="4" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $transaction[6]==1?$transaction[2]:"" }}</td>
                    @elseif($transaction[6]==2)
                    <td></td>
                    <td colspan="3" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $transaction[6]==2?$transaction[2]:"" }}</td>
                    @elseif($transaction[6]==3)
                    <td></td>
                    <td></td>
                    <td colspan="2" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $transaction[6]==3?$transaction[2]:"" }}</td>
                    @elseif($transaction[6]==4)
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{ $transaction[6]==4?$transaction[2]:"" }}</td>
                    @endif
                    <td></td>
                    <td style="text-align: right;">{{ $transaction[7]!='on'?(((double)$transaction[4])>0||$transaction[4]!="0"?number_format($transaction[4], 0, ",", "."):number_format(0, 0, ",", ".")):"" }}</td>
                    <td style="text-align: right;">{{ $transaction[7]!='on'?(((double)$transaction[3])>0||$transaction[3]!="0"?number_format($transaction[3], 0, ",", "."):number_format(0, 0, ",", ".")):"" }}</td>
                </tr>
                <!-- <?php if($transaction[6]==1 || ($transaction[6]==2 && $last3_account != $transaction[2])){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Jumlah {{$last3_account}}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $total3_debet>0?$total3_debet:$total3_credit }}</td>
                </tr>
                <?php $last3_account = $transaction[2]; } ?> -->
                @endforeach
                @if($last_level_2 != "")
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">Jumlah {{ $last_level_2 }}</td>
                    <td></td>
                    <td style="text-align: right;">{{ number_format($total_level_2_before, 0, ",", ".") }}</td>
                    <td style="text-align: right;">{{ number_format($total_level_2, 0, ",", ".") }}</td>
                </tr>
                @endif
            </tbody>
        </table>
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