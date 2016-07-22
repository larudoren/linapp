<?php
	header("Content-Type: application/vnd.ms-excel;");
	header("Content-Disposition: attachment; filename=export.xls");
?>
<table border="1">
	<tr>
		<th>No</th>
		<th>PO</th>
		<th>Tanggal</th>
		<th>Barang</th>
		<th>Satuan</th>
		<th>Supplier</th>
		<th>Jumlah</th>
		<th>Valuta</th>
		<th>Harga</th>
		<th>Total</th>
	</tr>
	<?php
		if($data->num_rows()>0){
			$ttldl = 0;
			$ttlrp = 0;
			$no =1;
			foreach($data->result_array() as $db){  
			if($db['status']==0) $status = 'Stock';
			else {$status='Order';}
			$total = $db['jmlbeli']*$db['hargabeli'];
			$tgl = $this->app_model->tgl_indo($db['tglbeli']);
	?>
		<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['po']; ?></td>
            <td align="center"><?php echo $tgl; ?></td>
            <td><?php echo $db['kode_barang'].'-'.$db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
			<td><?=$db['supplier_name']?></td>
            <td align="center"><?php echo number_format($db['jmlbeli'], 2); ?></td>
            <td align="center"><?php echo $db['currency_name']; ?></td>
            <td align="right"><?php echo number_format($db['hargabeli'], 2); ?></td>
            <td align="right"><?php echo number_format($total, 2); ?></td>
		</tr>
	<?php
			$no++;
			if($db['currency_name']=='Rp') {
				$ttlrp = $ttlrp+$total;
			}
			else {
				$ttldl = $ttldl+$total;
			}
		}
	}else{
		$ttlrp=0;
		$ttldl=0;
	?>
    	<tr>
        	<td colspan="9" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
	?>
	<tr>
	<th colspan="7" align="center">TOTAL</th>
	<th align="center">Rp</th>
    <th align="right" colspan="2"><?php echo number_format($ttlrp, 2); ?></th>
</tr>
<tr>
	<th colspan="7" align="center">TOTAL</th>
	<th align="center">$</th>
    <th align="right" colspan="2"><?php echo number_format($ttldl, 2); ?></th>
</tr>
</table>