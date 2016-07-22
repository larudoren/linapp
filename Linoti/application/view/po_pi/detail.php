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
	
	$("#datein").datepicker({
			dateFormat:"dd-mm-yy"
    });
});

function funct_edit(po,kode_barang,qty_order,datein,qty_in,remarks,nama_barang,temp_stock){
	$("#UpdatePO").val(po);
	$("#UpdateKodeBarang").val(kode_barang);
	$("#UpdateQtyOrder").numberbox('setValue',qty_order);
	$("#UpdateStock").numberbox('setValue',temp_stock);
	$("#dlgEdit").dialog({
		title: 'Update PO Detail - '+nama_barang
	});
	$("#dlgEdit").dialog('open');
}

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
	<th colspan="3">Description</th>
	<th>Qty Need</th>
	<th>Stock</th>
	<th>Min Qty</th>
	<th>Qty Order</th>
	<th>Unit Net Price</th>
	<th>Total Price</th>
	<th>Action</th>
</tr>

<?php
	if($data->num_rows()>0){
		$ttldl = 0;
		$ttlrp = 0;
		$no =1;
		foreach($data->result_array() as $db){
		$total = $db['qty_order']*$db['hargabeli'];
		$size ='';
			if ($db['size_length']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_length']);
				$fraction = $db['size_length'] - $whole;
				if ($fraction > 0){
					$size .= 'L '.number_format($db['size_length'], 1,',','.').' x ';
				} else {
					$size .= 'L '.number_format($db['size_length'], 0,',','.').' x ';
				}
			}
					
			if ($db['size_width']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_width']);
				$fraction = $db['size_width'] - $whole;
				if ($fraction > 0){
					$size .= 'W '.number_format($db['size_width'], 1,',','.').' x ';
				} else {
					$size .= 'W '.number_format($db['size_width'], 0,',','.').' x ';
				}
			}
			
			if ($db['size_height']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_height']);
				$fraction = $db['size_height'] - $whole;
				if ($fraction > 0){
					$size .= 'H '.number_format($db['size_height'], 1,',','.').' x ';
				} else {
					$size .= 'H '.number_format($db['size_height'], 0,',','.').' x ';
				}
			}
			
			if ($size!=''){
				$size = substr($size,0,-3);
				if (empty($db['size_length_unit'])){
					$size .= '; ';
				} else {
					$size .= ' '.$db['size_length_unit'].'; ';
				}
			}
			
			if ($db['size_diameter'] > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_diameter']);
				$fraction = $db['size_diameter'] - $whole;
				if ($fraction > 0){
					$size = $size.'&#216; out '.number_format($db['size_diameter'],1,',','.');
				} else {
					$size = $size.'&#216; out '.number_format($db['size_diameter'],0,',','.');
				}
				if (empty($db['size_diameter_unit'])){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$db['size_diameter_unit'].'; ';
				}
			}
					
			if ($db['size_diameterin'] > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_diameterin']);
				$fraction = $db['size_diameterin'] - $whole;
				if ($fraction > 0){
					$size = $size.'&#216; in '.number_format($db['size_diameterin'],1,',','.');
				} else {
					$size = $size.'&#216; in '.number_format($db['size_diameterin'],0,',','.');
				}
				if (empty($db['size_diameterin_unit'])){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$db['size_diameterin_unit'].'; ';
				}
			}
			
			if ($db['size_density']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_density']);
				$fraction = $db['size_density'] - $whole;
				if ($fraction > 0){
					$size = $size.'D'.number_format($db['size_density'],1,',','.').'; ';
				} else {
					$size = $size.'D'.number_format($db['size_density'],0,',','.').'; ';
				}
			}
			
			if (!empty($db->size_thread)){
				$size		= $size.$db->size_thread.'; ';
			}
		?>    
    	<tr class="edit_tr">
			<td align="center" width="10"><?php echo $no; ?></td>
      <td align="center"  width="150"><?php echo $db['kode_barang_spc']; ?></td>
			<td><?php echo $db['nama_barang']; ?></td>
			<td><?php echo $size; ?></td>
			<td><?php echo $db['finishing']; ?></td>
			<td align="center" width="70"><?php echo $db['jmlbeli'].' '.$db['useper']; ?></td>
			<td align="center" width="70"><?php echo $db['temp_stock'].' '.$db['useper']; ?></td>
			<td align="center" width="70"><?php echo $db['min_qty'].' '.$db['unit_name']; ?></td>
			<td align="center" width="70"><?php echo $db['qty_order'].' '.$db['unit_name']; ?></td>
			<?php 
				if ($db['currency_name']=='Rp'){
			?>
			<td align="right" width="100"><?php echo $db['currency_name'].'. '.number_format($db['hargabeli'], 0,',','.'); ?></td>
			<?php
				} else {
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($db['hargabeli']);
					$fraction = $db['hargabeli'] - $whole;
					$fraction_str = ''.number_format($db['hargabeli'], 3,',','.');
					
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
			?>
			<td align="right" width="100"><?php echo $db['currency_name'].'. '.number_format($db['hargabeli'], 3,',','.'); ?></td>
			<?php
						} elseif(substr($fraction_str,-2,1)!='0'){
			?>
			<td align="right" width="100"><?php echo $db['currency_name'].'. '.number_format($db['hargabeli'], 2,',','.'); ?></td>
			<?php
						} else {
			?>
			<td align="right" width="100"><?php echo $db['currency_name'].'. '.number_format($db['hargabeli'], 1,',','.'); ?></td>
			<?php
						}
					} else {
			?>
			<td align="right" width="100"><?php echo $db['currency_name'].'. '.number_format($db['hargabeli'], 0,',','.'); ?></td>
			<?php
					}
				}
				
				if ($db['currency_name']=='Rp'){
			?>
            <td align="right" width="120"><?php echo $db['currency_name'].'. '.number_format($total, 0, ',','.'); ?></td>
			<?php
				} else {
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($total);
					$fraction = $total - $whole;
					$fraction_str = ''.number_format($total, 3,',','.');
					
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
			?>
						<td align="right" width="120"><?php echo $db['currency_name'].'. '.number_format($total, 3,',','.'); ?></td>
			<?php
						} elseif(substr($fraction_str,-2,1)!='0'){
			?>
						<td align="right" width="120"><?php echo $db['currency_name'].'. '.number_format($total, 2,',','.'); ?></td>
			<?php
						} else {
			?>
						<td align="right" width="120"><?php echo $db['currency_name'].'. '.number_format($total, 1,',','.'); ?></td>
			<?php
						}
					} else {
			?>
            <td align="right" width="120"><?php echo $db['currency_name'].'. '.number_format($total, 0,',','.'); ?></td>
			<?php
					}
				}
			?>
				
				<td align="center" width="70">
					 <a href="javascript:void(0);" onClick="funct_edit('<?=$db['po']?>','<?=$db['kode_barang']?>','<?=$db['qty_order']?>','<?=$db['datein']?>','<?=$db['qty_in']?>','<?=$db['remarks']?>','<?=$db['nama_barang']?>','<?=$db['temp_stock']?>')">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/po_pi/hapus_detail/<?php echo $db['po']; ?>/<?php echo $db['kode_barang'];?>"
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
		}
	}else{
		$ttlrp=0;
		$ttldl=0;
	?>
    	<tr>
        	<td colspan="12" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<tr>
	<td colspan="9" align="right"><b>Total</b></td>
    <td align="right"><b><?php echo 'Rp. '.number_format($ttlrp, 0,',','.');?></b></td>
</tr>  
<tr>
	<td colspan="9" align="right"><b>Total</b></td>
<?php
	if ($ttldl > 0) {
		$whole = 0;
		$fraction = 0.0;
		$whole = floor($ttldl);
		$fraction = $ttldl - $whole;
		$fraction_str = ''.number_format($ttldl, 3,',','.');
		
		if ($fraction > 0){
			if(substr($fraction_str,-1)!='0'){
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 3,',','.');?></b></td>
<?php
			} elseif(substr($fraction_str,-2,1)!='0'){
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 2,',','.');?></b></td>
<?php
			} else {
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 1,',','.');?></b></td>
<?php
			}
		}
	} else {
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 0,',','.');?></b></td>
<?php
	}
?>
</tr> 
</table>