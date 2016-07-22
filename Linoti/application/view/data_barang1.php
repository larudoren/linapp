<script type="text/javascript">
$(function() {
	$("#dataTable.detail tr:even").addClass("stripe1");
	$("#dataTable.detail tr:odd").addClass("stripe2");
	$("#dataTable.detail tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
});
function pilih(kode_barang,nama_barang,unit_name){
	$("#dlg").dialog('close');
	$("#kode_brg").val(kode_barang);
	$("#nama_brg").val(nama_barang);
	$("#satuan").val(unit_name);
	$("#jml").focus();
}
</script>
<table id="dataTable" class="detail" width="100%">
<tr>
	<th>No</th>
    <th>Item Code</th>
    <th>Old Item Code</th>
    <th>Name</th>
    <th>Unit</th>
    <th>Departemen</th>
    <th>Use</th>
</tr>
<?php
	$awal = date('Y-m-01');
	$sekarang = date('Y-m-d');
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['kode_barang']; ?></td>
            <td align="center"><?php echo $db['kode_lama']; ?></td>
            <td ><?php echo $db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
            <td align="right"><?php echo $db['dept_name']; ?></td>
            <td align="center">
            <a href="javascript:pilih('<?php echo $db['kode_barang'];?>','<?php echo $db['nama_barang']; ?>','<?php echo $db['unit_name']; ?>')" >
        	<img src="<?php echo base_url();?>asset/images/add.png" title='Take'>
        	</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="7" align="center" >No Data</td>
        </tr>
    <?php	
	}
?>
</table>
