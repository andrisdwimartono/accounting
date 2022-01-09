<table>
    <thead>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=2>{{ $globalsetting->nama_lengkap_instansi }}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=2>Laporan Arus Kas</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=2><?= $transactions['unitkerja_label'] != ""?"Unit Kerja ".$transactions['unitkerja_label']." ":"" ?>Periode {{$transactions['bulan']}} {{$transactions['tahun']}}</td>
        </tr>
        <tr><td colspan=2></td></tr>
        <tr><td colspan=2></td></tr>

        <tr>
            <th>Jenis Aktivitas</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions['data'] as $transaction)
        <tr>
            <td>{{ $transaction[2] }}</td>
            <td>{{ $transaction[3] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>