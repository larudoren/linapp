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

function funct_update(terima,barang,jml,remarks,nama,qty_order,qty_before){
	//alert('A');
	$('#UpdateQtyReceive').numberbox('setValue',jml);
	$('#UpdateKodeTerima').val(terima);
	$('#UpdateKodeBarang').val(barang);
	$('#UpdateRemarks').val(remarks);
	$('#UpdateQtyOrder').numberbox('setValue',qty_order);
	$('#UpdateQtyBefore').numberbox('setValue',qty_before);
	$("#dlgEdit").dialog({
		title: 'Update - '+nama
	});
	$('#dlgEdit').dialog('open');
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
    <!--<th>Unit</th>-->
    <!--<th>Price</th>-->
    <th>Qty Order</th>
    <th>Qty Received Before</th>
    <th>Qty Received</th>
    <th>Remarks</th>
		<th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$ttldl = 0;
		$ttlrp = 0;
		$no =1;
		foreach($data->result_array() as $db){
		$total = $db['jml_terima']*$db['harga_terima'];
		$size ='';
		
		if ($db['size_length'] > 0){
			$whole = 0;
			$fraction = 0.0;
			$whole = floor($db['size_length']);
			$fraction = $db['size_length'] - $whole;
			if ($fraction > 0){
				$size = $size.'L '.number_format($db['size_length'],1,',','.').' x ';
			} else {
				$size = $size.'L '.number_format($db['size_length'],0,',','.').' x ';
			}
		}
		
		if ($db['size_width'] > 0){
			$whole = 0;
			$fraction = 0.0;
			$whole = floor($db['size_width']);
			$fraction = $db['size_width'] - $whole;
			if ($fraction > 0){
				$size = $size.'W '.number_format($db['size_width'],1,',','.').' x ';
			} else {
				$size = $size.'W '.number_format($db['size_width'],0,',','.').' x ';
			}
		}
		
		if ($db['size_height'] > 0){
			$whole = 0;
			$fraction = 0.0;
			$whole = floor($db['size_height']);
			$fraction = $db['size_height'] - $whole;
			if ($fraction > 0){
				$size = $size.'H '.number_format($db['size_height'],1,',','.').' x ';
			} else {
				$size = $size.'H '.number_format($db['size_height'],0,',','.').' x ';
			}
		}
		
		if ($size!=''){
			$size = substr($size,0,-3);
			if (empty($db['size_length_unit'])){
				$size = $size.'; ';
			} else {
				$size = $size.' '.$db['size_length_unit'].'; ';
			}
		}
		
		if ($db['size_diameter'] > 0){
			$whole = 0;
			$fraction = 0.0;
			$whole = floor($db['size_diameter']);
			$fraction = $db['size_diameter'] - $whole;
			if ($fraction > 0){
				$size = $size.'&#216; out   '.number_format($db['size_diameter'],1,',','.');
			} else {
				$size = $size.'&#216; out   '.number_format($db['size_diameter'],0,',','.');
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
				$size = $size.'&#216; in   '.number_format($db['size_diameterin'],1,',','.');
			} else {
				$size = $size.'&#216; in   '.number_format($db['size_diameterin'],0,',','.');
			}
			if (empty($db['size_diameterin_unit'])){
				$size = $size.'; ';
			} else {
				$size = $size.' '.$db['size_diameterin_unit'].'; ';
			}
		}
		
		if ($db['size_thread']!=''){
			$size = $size.$db['size_thread'].'; ';
		}
		?>    
    	<tr class="edit_tr">
			<td align="center"><?php echo $no; ?></td>
			<td align="center"><?php echo $db['kode_barang_spc']; ?></td>
			<td><?php echo $db['nama_barang']; ?></td>
			<td><?php echo $size; ?></td>
			<td><?php echo $db['finishing']; ?></td>
			<!--<td align="center"><?php echo $db['unit_name']; ?></td>-->
			<!--
			<td align="right">
				<?php 
					if ($db['currency_name']=='Rp'){
						echo $db['currency_name'].' '.number_format($db['harga_terima'], 0, ',','.'); 
					} else {
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db['harga_terima']);
						$fraction = $db['harga_terima'] - $whole;
						$fraction_str = ''.number_format($db['harga_terima'], 3,',','.');
						if ($fraction > 0){
							if(substr($fraction_str,-1)!='0'){
								echo $db['currency_name'].' '.number_format($db['harga_terima'], 3, ',','.');
							} elseif(substr($fraction_str,-2,1)!='0'){
								echo $db['currency_name'].' '.number_format($db['harga_terima'], 2, ',','.');
							}else {
								echo $db['currency_name'].' '.number_format($db['harga_terima'], 1, ',','.');
							}
						} else {
							echo $db['currency_name'].' '.number_format($db['harga_terima'], 0, ',','.');
						}
					}
				?>
			</td> -->
			<td align="center"><?php echo $db['qty_order'].' '.$db['unit_name']; ?></td>
			<td align="center"><?php echo $db['jml'].' '.$db['unit_name']; ?></td>
			<td align="center"><?php echo $db['jml_terima'].' '.$db['unit_name']; ?></td>
			<td align="center"><?php echo $db['remarks']; ?>
			<!--
				<form method="POST" action="<?php echo site_url('penerimaan_barang/update_item');?>" >
					<input type="hidden" name="kode" value="<?php echo $db['kode_terima'];?>-<?php echo $db['kode_barang'];?>" />
					<input type="text" name="jml" value="<?php echo $db['jml_terima']; ?>" size="7"/>
					<input type="submit" value="Update">
				</form>-->
			</td>
			<!--
			<td align="right">
				<?php 
					if ($db['currency_name']=='Rp')	{
						echo $db['currency_name'].' '.number_format($total, 0, ',','.'); 
					} else {
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($total);
						$fraction = $total - $whole;
						$fraction_str = ''.number_format($total, 3,',','.');
						if ($fraction > 0){
							if(substr($fraction_str,-1)!='0'){
								echo $db['currency_name'].' '.number_format($total, 3, ',','.'); 
							} elseif(substr($fraction_str,-2,1)!='0'){
								echo $db['currency_name'].' '.number_format($total, 2, ',','.'); 
							}else {
								echo $db['currency_name'].' '.number_format($total, 1, ',','.'); 
							}
						} else {
							echo $db['currency_name'].' '.number_format($total, 0, ',','.'); 
						}
					}
				?>
			</td> -->
      <td align="center">
        <a href="javascript:void(0)" onClick="funct_update('<?=$db['kode_terima']?>','<?=$db['kode_barang']?>','<?=$db['jml_terima']?>','<?=$db['remarks']?>','<?=$db['nama_barang']?>','<?=$db['qty_order']?>','<?=$db['jml']?>')">
					<img src="<?php echo base_url();?>asset/images/browse.png" title='Update'>
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
        	<td colspan="10" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<!--
<tr>
	<td colspan="6" align="right"><b>Total</b></td>
    <td align="right">
			<b>
				<?php 
						echo 'Rp '.number_format($ttlrp, 0, ',','.');
				?>
			</b>
		</td>
</tr>  -->
<!--
<tr>
	<td colspan="6" align="right"><b>Total</b></td>
    <td align="right">
			<b>
			<?php 
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($ttldl);
				$fraction = $ttldl - $whole;
				$fraction_str = ''.number_format($ttldl, 3,',','.');
				
				if ($fraction > 0){
					if(substr($fraction_str,-1)!='0'){
						echo '$ '.number_format($ttldl, 3, ',', '.');
					} elseif(substr($fraction_str,-2,1)!='0'){
						echo '$ '.number_format($ttldl, 2, ',', '.');
					}else {
						echo '$ '.number_format($ttldl, 1, ',', '.');
					}
				} else {
					echo '$ '.number_format($ttldl, 0, ',', '.');
				}
			?>
			</b>
		</td>
</tr> -->
</table>