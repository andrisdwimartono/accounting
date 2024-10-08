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
            <td colspan=4>Laporan Arus Kas</td>
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
        ?>
        @foreach($transactions['data'] as $transaction)
        <?php if($transaction[5]==2 && $last3_account == ""){ 
            $last3_account = $transaction[2]; } 
        ?>
        <?php 
            $total3_debet = $total3_debet + (double)$transaction[3];
            $total3_credit = $total3_credit + (double)$transaction[4];
        ?>
        <tr>
            <td></td>
            <td>{{ $transaction[5]==1?$transaction[2]:"" }}</td>
            <td>{{ $transaction[5]==2?$transaction[2]:"" }}</td>
            <td>{{ $transaction[5]==3?$transaction[2]:"" }}</td>
            <td>{{ $transaction[5]==4?$transaction[2]:"" }}</td>
            <td></td>
            <td>{{ ((double)$transaction[8])>0||$transaction[8]!="0"?$transaction[8]:0 }}</td>
            <td>{{ ((double)$transaction[3])>0||$transaction[3]!="0"?$transaction[3]:0 }}</td>
        </tr>
        <!-- <?php if($transaction[5]==1 || ($transaction[5]==2 && $last3_account != $transaction[2])){ ?>
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
    </tbody>
</table>