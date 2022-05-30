<table>
    <thead>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=8>YAYASAN PENDIDIKAN KATOLIK ARNOLDUS</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=8>ANGGARAN PENDAPATAN DAN BELANJA</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=8>TAHUN ANGGARAN</td>
        </tr>
        <tr style="text-align:center; font-weight:bold;">
            <td colspan=8>Rincian Lengkap</td>
        </tr>
        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

        <tr>
            <th colspan=5 rowspan=2>KETERANGAN</th>
            <th rowspan=2>KODE</th>
            <th></th>
        </tr>
        <tr>
            <th>PLAFON</th>
            <th>ANGGARAN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>I. PENDAPATAN</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php 
            $parent = "";
            $parent2 = "";
            $total_per_bagian = 0;
            $parent_ct = 0;
            $ct = 0; ?>
        @foreach($transactions['potensipendapatan'] as $transaction)
            <?php 
            $ct++;
            if($parent != $transaction->coa_label){ ?>
            <?php 
            $parent_ct++;
            if($parent != ""){ ?>
        <tr>
            <td></td>
            <td></td>
            <td>Sub total - {{ $parent }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_per_bagian }}</td>
        </tr>
        <?php 
            $total_per_bagian = 0;
        } ?>
        <tr>
            <td></td>
            <td>1.{{$parent_ct}} {{ $transaction->coa_label }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $transaction->coa_name }}</td>
            <td></td>
            <td></td>
            <td>{{ convertCode($transaction->coa_code) }}</td>
            <td></td>
            <td>{{ $transaction->nominalpendapatan }}</td>
        </tr>
            <?php 
                $parent = $transaction->coa_label;
            }else{ ?>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $transaction->coa_name }}</td>
            <td></td>
            <td></td>
            <td>{{ convertCode($transaction->coa_code) }}</td>
            <td></td>
            <td>{{ $transaction->nominalpendapatan }}</td>
        </tr>
            <?php } ?>
            <?php if(count($transactions['potensipendapatan']) == $ct){ ?>
        <tr>
            <td></td>
            <td></td>
            <td>Sub total - {{ $parent }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_per_bagian+$transaction->nominalpendapatan }}</td>
        </tr>
        <?php } ?>

        <?php $total_per_bagian = $total_per_bagian+$transaction->nominalpendapatan; ?>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>II. BIAYA</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <?php 
            $parent = "";
            $parent2 = "";
            $total_per_bagian = 0;
            $total_per_bagian_plafon = 0;
            $parent_ct = 0;
            $ct = 0; ?>
        @foreach($transactions['detailbiayakegiatan'] as $transaction)
            <?php 
            $ct++;
            if($parent != $transaction->coa_label){ ?>
            <?php 
            $parent_ct++;
            if($parent != ""){ ?>
        <tr>
            <td></td>
            <td></td>
            <td>Sub total - {{ $parent }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_per_bagian_plafon }}</td>
            <td>{{ $total_per_bagian }}</td>
        </tr>
        <?php 
            $total_per_bagian = 0;
            $total_per_bagian_plafon = 0;
        } ?>
        <tr>
            <td></td>
            <td>2.{{$parent_ct}} {{ $transaction->coa_label }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $transaction->coa_name }}</td>
            <td></td>
            <td></td>
            <td>{{ convertCode($transaction->coa_code) }}</td>
            <td>{{ $transaction->plafon }}</td>
            <td>{{ $transaction->nominalbiaya }}</td>
        </tr>
            <?php 
                $parent = $transaction->coa_label;
            }else{ ?>
        <tr>
            <td></td>
            <td></td>
            <td>{{ $transaction->coa_name }}</td>
            <td></td>
            <td></td>
            <td>{{ convertCode($transaction->coa_code) }}</td>
            <td>{{ $transaction->plafon }}</td>
            <td>{{ $transaction->nominalbiaya }}</td>
        </tr>
            <?php } ?>
            <?php if(count($transactions['detailbiayakegiatan']) == $ct){ ?>
        <tr>
            <td></td>
            <td></td>
            <td>Sub total - {{ $parent }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_per_bagian_plafon+$transaction->plafon }}</td>
            <td>{{ $total_per_bagian+$transaction->nominalbiaya }}</td>
        </tr>
        <?php } ?>

        <?php 
            $total_per_bagian = $total_per_bagian+$transaction->nominalbiaya;
            $total_per_bagian_plafon = $total_per_bagian_plafon+$transaction->plafon;
        ?>
        @endforeach
    </tbody>
</table>

<?php 
    function convertCode($data){
        $val = "";
        $array = str_split($data);
        $i = 0;
        foreach ($array as $char) {
            if($i == 2 || $i == 6){
                $val = $val.$char."-";
            }else{
                $val = $val.$char;
            }
            $i++;
        }
        return $val;
     }
?>