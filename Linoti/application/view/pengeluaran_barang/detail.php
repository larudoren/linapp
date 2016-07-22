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
    <th>Name</th>
    <th>Unit</th>
    <!--<th>Harga</th>-->
    <th>Quantity</th>
    <!--<th>Total</th>-->
    <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		$count = 0;
		foreach($data->result_array() as $db){
			//$sub_count = $db['harga']*$db['jml_keluar'];
			//$count = $count+$sub_count;
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['kode_barang_spc']; ?></td>
			<td><?php echo $db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
            <!--<td align="right"><?php echo 'Rp. '.number_format($db['harga'], 2); ?></td>-->
            <td align="center"><?php echo $db['jml_keluar']; ?></td>
           <!-- <td align="right"><?php echo 'Rp. '.number_format($sub_count, 2); ?></td>-->
            <td align="center">
            <a href="<?php echo base_url();?>index.php/pengeluaran_barang/hapus_detail/<?php echo $db['kode_keluar'];?>/<?php echo $db['kode_barang'];?>"
            onClick="return confirm('Do you want to delete the data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
		//$count=0;
	?>
    	<tr>
        	<td colspan="8" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<!--
<tr>
	<td colspan="6" align="right"><b>Total</b></td>
    <td align="right"><b><?php echo 'Rp. '.number_format($count, 2);?></b></td>
	<td colspan="6" align="right">&nbsp;</td>
</tr> -->
</table>