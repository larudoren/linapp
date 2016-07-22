 <script>
    $("#dialog").dialog({
		autoOpen: false,
		width: 550, 
		modal: true,
		hide: 'fade',
		show: 'fade',
		closeOnEscape: false, 
		draggable: true,
		resizable: true,
		title: 'Supplier List'
	});
</script>
<div id="dialog" style="float:left; width:100%;">
	<table id="dataTable" width="100%">
		<tr>
			<th>No</th>
			<!--<th>Kode Barang</th>-->
			<th>Supplier</th>
			<th>Price</th>
			<th>Update</th>
		</tr>
<?php
if($data->num_rows()>0){
	$no=1;
	foreach($data->result_array() as $db){
?>
		<tr>
			<td align="center"><?=$no?></td>
            <!--<td align="center"><?=$db['kode_barang']?></td>-->
            <td align="center"><?=$db['supplier_name']?></td>
            <td align="center"><table><tr><td align="left"><?=$db['currency_name']?></td><td align="right"><?php if ($db['currency_name']=='Rp'){ echo number_format($db['harga'],0,',','.');} else {echo number_format($db['harga'],2,',','.');}?></td></tr></table></td>
            <td align="center"><?=$db['tglbeli']?></td>
		</tr>
<?php
		$no++;
	}
}else{
?>
		<tr>
        	<td colspan="10" align="center" >Empty Data</td>
        </tr>
<?php 
	}
?>
	</table>
 </div>
 

