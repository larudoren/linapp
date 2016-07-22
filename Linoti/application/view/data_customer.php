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
	$("#text_cari").val('');
	$("#dlg").dialog('close');
	$("#cust_code").val(id);
	$("#cust_code").focus();
	
}
</script>
<table id="dataTable" class="detail" width="100%">
<tr>
	<th>No</th>
    <!--<th>Kode</th>-->
    <th>Customer Name</th>
    <th>Country</th>
    <th>Telp</th>
    <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <!--<td align="center"><?php echo $db['cust_code']; ?></td>-->
            <td ><?php echo urldecode($db['cust_name']); ?></td>
            <td align="left"><?php echo $db['cust_country']; ?></td>
            <td align="left"><?php echo $db['cust_phone'];; ?></td>
            <td align="center">
            <a href="javascript:pilih('<?php echo $db['cust_code'];?>')" >
        	<img src="<?php echo base_url();?>asset/images/add.png" title='Use'>
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