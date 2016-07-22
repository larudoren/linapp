<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
});
</script>
<style type="text/css">
.stripe1 {
    background-color:#FBEC88;
}
.stripe2 {
    background-color:#FFF;
}
.highlight {
	-moz-box-shadow: 1px 1px 2px #fff inset;
	-webkit-box-shadow: 1px 1px 2px #fff inset;
	box-shadow: 1px 1px 2px #fff inset;		  
	border:             #aaa solid 1px;
	background-color: #fece2f;
}
</style>
<table id="dataTable" width="100%">
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
		$g_total = 0;
		$ttldl = 0;
		$ttlrp = 0;
		$no =1;
		foreach($data->result_array() as $db){  
		if($db['status']==0) $status = 'Stock';
		else {$status='Order';}
		$total = $db['jmlbeli']*$db['hargabeli'];
		//$tgl = $this->app_model->tgl_indo($db['tglbeli']);
		$tgl = date("d-m-y", strtotime($db['tglbeli']));
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['po']; ?></td>
            <td align="center"><?php echo $tgl; ?></td>
            <td><?php echo $db['kode_barang'].'-'.$db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
			<td><?=$db['supplier_name']?></td>
            <td align="right"><?php echo number_format($db['jmlbeli'], 2); ?></td>
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
		$matauang = $db['currency_name'];
		$g_total =$g_total+$total;
		}
	}else{
		$g_total =0;
		$ttlrp=0;
		$ttldl=0;
	?>
    	<tr>
        	<td colspan="10" align="center" >Tidak Ada Data</td>
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