<table>
    <thead>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=3>{{ Session::get('global_setting')->nama_lengkap_instansi }}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=3>Laporan {{isset($transaction["jenis"])&&$transaction["jenis"]=="neraca"?"Neraca":"Neraca Saldo"}}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=3><?= $transactions['unitkerja_label'] != ""?"Unit Kerja ".$transactions['unitkerja_label']." ":"" ?>Periode {{$transactions['bulan']}} {{$transactions['tahun']}}</td>
        </tr>
        <tr><td colspan=3></td></tr>
        <tr><td colspan=3></td></tr>

        <tr>
            <th>Kode Rekening Akuntansi</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions['data'] as $transaction)
        <tr>
            <td>{!! $transaction[1] !!}  {{ $transaction[2] }}</td>
            <td>{{ $transaction[3] }}</td>
            <td>{{ $transaction[4] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>