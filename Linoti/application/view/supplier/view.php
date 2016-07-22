<div id="view">
<div style="float:left; padding-bottom:5px;">
<?php
	if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='03' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
?>
<a href="<?php echo base_url();?>index.php/supplier/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/supplier">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<?php } ?>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/supplier">
Supplier Name : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
  <th>No</th>
  <th>Supplier Name</th>
	<th>City</th>
	<th>Province</th>
	<th>Country</th>
	<th>Telp</th>
	<th>Fax</th>
	<th>Website</th>
	<th>Remarks</th>
  <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
            <td align="center"><?php echo $no; ?></td>
            <td><?php echo $db['supplier_name']; ?></td>
            <td><?php echo $db['capital_city']; ?></td>
            <td><?php echo $db['supplier_state']; ?></td>
            <td><?php echo $db['supplier_country']; ?></td>
            <td><?php echo $db['supplier_phone']; ?></td>
            <td><?php echo $db['supplier_fax']; ?></td>
            <td><a href="<?php echo prep_url($db['supplier_website']); ?>" target="_blank"><?php echo $db['supplier_website']; ?></a></td>
            <td><?php echo $db['supplier_remarks']; ?></td>
            <td align="center">
            <a href="<?php echo base_url();?>index.php/supplier/edit/<?php echo $db['supplier_code'];?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
			<?php
				if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='03' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
			?>
            <a href="<?php echo base_url();?>index.php/supplier/hapus/<?php echo $db['supplier_code'];?>"
            onClick="return confirm('Do you want to delete this data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
			<?php } ?>
            </td>
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
<?php
	echo "<table align='center'><tr><td>".$paginator."</td></tr></table>";
?>

</div>
</div>