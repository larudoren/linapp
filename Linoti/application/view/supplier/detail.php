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
    <th>Nama</th>
    <th>Position</th>
    <th>Mobile 1</th>
    <th>Mobile 2</th>
    <th>Mobile 3</th>
    <th>Email 1</th>
    <th>Email 2</th>
    <th>Email 3</th>
    <th>Remarks</th>
    <th>Aksi</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		$count = 0;
		foreach($data->result_array() as $db){
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
            <td align="center"><?php echo $db['name']; ?></td>
			<td><?php echo $db['position']; ?></td>
            <td align="center"><?php echo $db['mobile1']; ?></td>
            <td align="center"><?php echo $db['mobile2']; ?></td>
            <td align="center"><?php echo $db['mobile3']; ?></td>
            <td align="center"><?php echo $db['email1']; ?></td>
            <td align="center"><?php echo $db['email2']; ?></td>
            <td align="center"><?php echo $db['email3']; ?></td>
            <td align="center"><?php echo $db['remarks']; ?></td>
            <td align="center">
            <a href="<?php echo base_url();?>index.php/supplier/hapus_detail/<?php echo $db['supplier_code'];?>/<?php echo $db['sequence'];?>"
            onClick="return confirm('Anda yakin ingin menghapus data ini?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Hapus'>
			</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
		$count=0;
	?>
    	<tr>
        	<td colspan="11" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>