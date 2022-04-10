<table>
    <thead>
        <tr>
            <td colspan=8></td>
        </tr>

        <tr style="text-align:center; font-weight:bold;">
            <td></td>
            <td colspan=3></td>
            <td colspan=4>{{ Session::get('global_setting')->nama_lengkap_instansi }}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td></td>
            <td colspan=3></td>
            <td colspan=4>Laporan Posisi Keuangan</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td></td>
            <td colspan=3></td>
            <td colspan=4>Periode {{$transactions['bulan']}} {{$transactions['tahun']}}</td>
        </tr>
        <tr><td colspan=8></td></tr>

        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Catatan</th>
            <th>{{$transactions['bulan_before']}} {{$transactions['tahun_before']}}</th>
            <th>{{$transactions['bulan']}} {{$transactions['tahun']}}</th>
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
            <td></td>
            <td>Jumlah {{ $last_level_2 }}</td>
            <td></td>
            <td>{{ (double)$total_level_2_before }}</td>
            <td>{{ (double)$total_level_2 }}</td>
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
            <td></td>
            <td>{{ $transaction[6]==1?$transaction[2]:"" }}</td>
            <td>{{ $transaction[6]==2?$transaction[2]:"" }}</td>
            <td>{{ $transaction[6]==3?$transaction[2]:"" }}</td>
            <td>{{ $transaction[6]==4?$transaction[2]:"" }}</td>
            <td></td>
            <td>{{ $transaction[7]!='on'?(((double)$transaction[4])>0||$transaction[4]!="0"?$transaction[4]:0):"" }}</td>
            <td>{{ $transaction[7]!='on'?(((double)$transaction[3])>0||$transaction[3]!="0"?$transaction[3]:0):"" }}</td>
        </tr>
        <!-- <?php if($transaction[6]==1 || ($transaction[6]==2 && $last3_account != $transaction[2])){ ?>
        <tr>
            <td></td>
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
            <td></td>
            <td>Jumlah {{ $last_level_2 }}</td>
            <td></td>
            <td>{{ (double)$total_level_2_before }}</td>
            <td>{{ (double)$total_level_2 }}</td>
        </tr>
        @endif
    </tbody>
</table>