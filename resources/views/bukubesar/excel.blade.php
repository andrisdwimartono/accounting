<table>
    <thead>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=5>{{ Session::get('global_setting')->nama_lengkap_instansi }}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=5>Laporan Buku Besar</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=5>Kode Rekening {{$transactions['coa']}}</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=5><?= $transactions['unitkerja_label'] != ""?"Unit Kerja ".$transactions['unitkerja_label']." ":"" ?>Periode {{$transactions['bulan']}} {{$transactions['tahun']}}</td>
        </tr>
       
        <tr><td colspan=5></td></tr>
        <tr><td colspan=5></td></tr>

        <tr>
            <th>Tanggal</th>
            <th>No. Jurnal</th>
            <th>Keterangan</th>
            <th>Debet</th>
            <th>Kredit</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions['data'] as $transaction)
        <tr>
            <td>{{ $transaction[1] }}</td>
            <td>{{ $transaction[2] }}</td>
            <td>{{ $transaction[3] }}</td>
            <td>{{ $transaction[4] }}</td>
            <td>{{ $transaction[5] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>