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
    <th>Code</th>
    <th colspan="3">Name</th>
    <!--<th>Unit</th>-->
    
    <th>Qty Needed</th>
    <th>Min Qty</th>
    <th>Qty Order</th>
		<!--<th>Currency</th>-->
    <th>Price</th>
    <th>Total</th>
    <th>Remarks</th>
    <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$ttldl = 0;
		$ttlrp = 0;
		$no =1;
		foreach($data->result_array() as $db){
		//if ($db['qty_order']==0){
		//	$total = $db['jmlbeli']*$db['hargabeli'];
		//} else {
			$total = $db['qty_order']*$db['hargabeli'];
		//}
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
      <td><?php echo $db['kode_barang_spc']; ?></td>
			<td><?php echo $db['nama_barang']; ?></td>
			<!--<td align="center"><?php echo $db['unit_name']; ?></td>-->
			<td align="center"><?=$db['dept_name']?></td>
			<td align="center"><?=$db['finishing']?></td>
			<td align="center"><?php echo $db['jmlbeli'].' '.$db['unit_name']; ?></td>
			<td align="center"><?php echo $db['min_qty'].' '.$db['unit_name']; ?></td>
			<td align="center">
				<form method="POST" action="<?php echo site_url('pembelian/update_item');?>" >
					<input type="hidden" name="kode" value="<?php echo $db['po'];?>/<?php echo $db['kode_barang'];?>" />
					<input type="text" name="qty_order" value="<?php echo $db['qty_order']; ?>" size="7"/>
					<input type="submit" value="Change">
				</form>
			</td>
			<!--<td align="center"><?=$db['currency_name']?></td>-->
			<?php if ($db['currency_name']=='Rp') {?>
			<td align="right"><?php echo 'Rp  '.number_format($db['hargabeli'], 0,',','.'); ?></td>
			<td align="right"><?php echo 'Rp  '.number_format($total, 0,',','.'); ?></td>
			<?php } else {
							$whole = 0;
							$fraction = 0.0; 
							$fraction_str='';
							$whole = floor ($db['hargabeli']);
							$fraction = $db['hargabeli'] - $whole;
							$fraction_str = ''.number_format($db['hargabeli'], 3,',','.');
							
							if ($fraction > 0){
								if(substr($fraction_str,-1)!='0'){
			?>
			<td align="right"><?php echo '$  '.number_format($db['hargabeli'], 3,',','.'); ?></td>
			<?php
								} elseif(substr($fraction_str,-2,1)!='0'){
			?>
			<td align="right"><?php echo '$  '.number_format($db['hargabeli'], 2,',','.'); ?></td>
			<?php
								} else {
			?>
			<td align="right"><?php echo '$  '.number_format($db['hargabeli'], 1,',','.'); ?></td>
			<?php
								}
							} else {
			?>
			<td align="right"><?php echo '$  '.number_format($db['hargabeli'], 0,',','.'); ?></td>
			<?php
							}
							
							$whole = 0;
							$fraction = 0.0; 
							$fraction_str='';
							$whole = floor ($total);
							$fraction = $total - $whole;
							$fraction_str = ''.number_format($total, 3,',','.');
							
							if ($fraction > 0){
								if (substr($fraction_str,-1)!='0'){
			?>
			<td align="right"><?php echo '$  '.number_format($total, 3,',','.'); ?></td>
			<?php 
								} elseif (substr($fraction_str,-2,1)!='0'){
			?>
			<td align="right"><?php echo '$  '.number_format($total, 2,',','.'); ?></td>
			<?php					
								} else {
			?>
			<td align="right"><?php echo '$  '.number_format($total, 1,',','.'); ?></td>
			<?php
								}
							} else {
			?>
			<td align="right"><?php echo '$  '.number_format($total, 0,',','.'); ?></td>
			<?php 
							}
						} 
			?>
			<td><?php  $db['remarks']?></td>
			<td align="center">
				<a href="<?php echo base_url();?>index.php/pembelian/hapus_detail/<?php echo $db['po'];?>/<?php echo $db['kode_barang'];?>"
					onClick="return confirm('Do you want to delete this data?')">
					<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
				</a>
			</td>
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
		}
	}else{
		$ttlrp=0;
		$ttldl=0;
	?>
    	<tr>
        	<td colspan="8" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<tr>
	<td colspan="9" align="right"><b>Total in (Rp)</b></td>
	<td align="right"><b><?php echo number_format($ttlrp, 0,',','.');?></b></td>
</tr>
<tr>
	<td colspan="9" align="right"><b>Total in ($)</b></td>
<?php
		$whole = 0;
		$fraction = 0.0; 
		$fraction_str='';
		$whole = floor ($ttldl);
		$fraction = $ttldl - $whole;
		$fraction_str = ''.number_format($ttldl, 3,',','.');
		
			if ($fraction > 0){
				if (substr($fraction_str,-1)!='0'){
?>
	<td align="right"><b><?php echo number_format($ttldl, 3,',','.');?></b></td>
<?php
				} elseif (substr($fraction_str,-2,1)!='0'){
?>
	<td align="right"><b><?php echo number_format($ttldl, 2,',','.');?></b></td>
<?php
				}else{
?>
	<td align="right"><b><?php echo number_format($ttldl, 1,',','.');?></b></td>
<?php
				}
			} else {
?>
	<td align="right"><b><?php echo number_format($ttldl, 0,',','.');?></b></td>
<?php
			}
?>
</tr>
</table>