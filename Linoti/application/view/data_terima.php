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
function pilih(id){
	$("#dlg").dialog('close');
	$("#kode_brg").val(id);
	$("#kode_brg").focus();
	
}
</script>
<table id="dataTable" class="detail" width="100%">
<tr>
	<th>No</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Satuan</th>
    <th>Departemen</th>
    <th>Stok</th>
    <th>Ambil</th>
</tr>
<?php
	$awal = date('Y-m-01');
	$sekarang = date('Y-m-d');
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		$stok = $this->app_model->CariStokAkhir($db['kode_barang'], $awal, $sekarang);
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['kode_barang']; ?></td>
            <td ><?php echo $db['nama_barang']; ?></td>
            <td align="center"><?php echo $db['unit_name']; ?></td>
            <td align="right"><?php echo $db['dept_name']; ?></td>
            <td align="center"><?php echo $stok; ?></td>
            <td align="center">
            <a href="javascript:pilih('<?php echo $db['kode_barang'];?>')" >
        	<img src="<?php echo base_url();?>asset/images/add.png" title='Ambil'>
        	</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="7" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>