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
    <th>Item Code</th>
    <th>Name</th>
    <th>Unit</th>
    <th>Early Stock</th>
    <th>In</th>
    <th>Out</th>
    <th>Stock</th>
		<th>Price</th>
    <th>Total</th>
</tr>
<?php
	$awal_bulan = date('Y-m-01');
	$sekarang = date('Y-m-d');
	if($data->num_rows()>0){
		$sum_awal = 0;
		$sum_beli = 0;
		$sum_distribusi = 0;
		$sum_akhir = 0;
		$grand_total = 0;
		foreach($data->result_array() as $db){  
			$opname = $this->app_model->CariStokOpname($db['kode_barang']);
			if ($opname[0]!=0){
				$awal = $opname[0];
				$tgl_awal = $opname[1];
			} else {
				$awal = $this->app_model->CariStokAwal($db['kode_barang'],$awal_bulan);
				$tgl_awal = $awal_bulan;
			}
			$terima = $this->app_model->CariJmlTerima($db['kode_barang'],$tgl_awal,$sekarang);
			$keluar = $this->app_model->CariJmlKeluar($db['kode_barang'],$tgl_awal,$sekarang);
			$stok = ($awal+$terima)-$keluar;
			$cost= $this->app_model->cost_average($db['kode_barang']);
			$fp=fopen("laptampil.txt","w");
			fwrite($fp,'Awal : '.$awal.'; Terima : '.$terima.';	Keluar : '.$keluar.';	Stok : '.$stok);
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
				$total = $stok*$cost->average;
				$grand_total = $grand_total+$total;
		?>
    	<tr>
            <td align="center"><?php echo $db['kode_barang']; ?></td>
            <td ><?php echo $db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
            <td align="right"><?php echo $suwawal; ?></td>
            <td align="right"><?php echo $sutrim; ?></td>
            <td align="right"><?php echo $sular; ?></td>
            <td align="right"><?php echo $stok; ?></td>
						<td align="right"><?php $vCost=round($cost->average); echo number_format($vCost);?></td>
            <td align="right"><?php $vTotal=round($total); echo number_format($vTotal);?></td>
		</tr>
    <?php
			}
		}
	}else{
	?>
    	<tr>
        	<td colspan="8" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<?php
	if($data->num_rows()>0){
?>
<tr>
	<td colspan="8" align="right"><strong>Grand Total</strong></td>
	<td align="right"><b><?php echo number_format(round($grand_total));?></b></td>
</tr>
<?php
	}
?>
</table>