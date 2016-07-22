<?php
	header("Content-Type: application/vnd.ms-excel;");
	date_default_timezone_set("Asia/Jakarta");
	header("Content-Disposition: attachment; filename=Laporan_Stock_Barang_".date("d-m-Y").date("_H-i").".xls");
?>
<table border="1">
	<tr>
		<th rowspan="3" align="center">No</th>
		<th rowspan="3" align="center">Item Code</th>
		<th rowspan="3" align="center">Name</th>
		<th rowspan="3" align="center">Unit</th>
		<th colspan="12" align="center">Stock</th>
	</tr>
	<tr>
		<th colspan="3" align="center">Early</th>
		<th colspan="3" align="center">In</th>
		<th colspan="3" align="center">Out</th>
		<th colspan="3" align="center">Last</th>
	</tr>
	<tr>
		<th>Price</th>
		<th>Qty</th>
		<th>Total</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Total</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Total</th>
		<th>Price</th>
		<th>Qty</th>
		<th>Total</th>
	</tr>
	<?php
		$awal_bulan = date('Y-m-01');
		$sekarang = date('Y-m-d');
		if($data->num_rows()>0) {
		$no = 1;
		foreach($data->result() as $result) {
			$kode = $result->kode_barang;
			$material = $result->nama_barang;
			$unit = $result->unit_name;
			$opname = $this->app_model->CariStokOpname($kode);
			if ($opname[0]!=0){
				$awal = $opname[0];
				$tgl_awal = $opname[1];
			} else {
				$awal = $this->app_model->CariStokAwal($kode,$awal_bulan);
				$tgl_awal = $awal_bulan;
			}
		//	$awal = $this->app_model->CariStokAwal($kode,$tgl1);
			$terima = $this->app_model->CariJmlTerima($kode,$tgl_awal,$sekarang);
			$keluar = $this->app_model->CariJmlKeluar($kode,$tgl_awal,$sekarang);
			$stok = ($awal+$terima)-$keluar;
			$cost = $this->app_model->cost_average($kode);
			if($awal=='') {
				$suwawal = 0;
			} else {
				$suwawal = $awal;
			}
			if($terima=='') {
				$sutrim = 0;
			} else {
				$sutrim = $terima;
			}
			if($keluar=='') {
				$sular = 0;
			} else {
				$sular = $keluar;
			}
			
			if($stok!=0)
			{
				$a_total  = $cost->average*$suwawal;
				$h_terima = $sutrim*$cost->average;
				$h_keluar = $sular*$cost->average;
				$h_keluar = $sular*$cost->average;
				$h_stok   = $stok*$cost->average;
				$total = $stok*$cost->average;
				$grand_total = $grand_total+$total;
	?>
	<tr>
		<td><?=$no?></td>
		<td><?=$kode?></td>
		<td><?=$material?></td>
		<td><?=$unit?></td>
		<td align="right"><?=round($cost->average)?></td>
		<td align="right"><?=$suwawal?></td>
		<td align="right"><?=round($a_total)?></td>
		<td align="right"><?=round($cost->average)?></td>
		<td align="right"><?=$sutrim?></td>
		<td align="right"><?=round($h_terima)?></td>
		<td align="right"><?=round($cost->average)?></td>
		<td align="right"><?=$sular?></td>
		<td align="right"><?=round($h_keluar)?></td>
		<td align="right"><?=round($cost->average)?></td>
		<td align="right"><?=$stok?></td>
		<td align="right"><?=round($h_stok)?></td>
	</tr>
	<?php
				$no++;
			}
		}
		}
	?>
	<tr>
		<td colspan="15" align="right">Grand Total</td>
		<td align="right"><?=round($grand_total)?></td>
	</tr>
</table>