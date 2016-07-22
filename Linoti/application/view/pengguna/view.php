<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/pengguna/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/pengguna">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/pengguna">
Username / Full Name : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
	<th>Username</th>
	<th>Full Name</th>
	<th>Level</th>
	<?php
		if($this->session->userdata('level')=='01'){
	?>
    <th>Action</th>
	<?php } ?>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){ 
		$level = $this->app_model->CariLevel($db['level']); 
		?>    
    	<tr>
			<td align="center" width="50"><?php echo $no; ?></td>
            <td align="left" width="200" ><?php echo $db['username']; ?></td>
            <td ><?php echo $db['nama_lengkap']; ?></td>
            <td align="left" width="200" ><?php echo $db['level'].' - '.$level; ?></td>
            <?php
			if($this->session->userdata('level')=='01'){
			?>
			<td align="center" width="80">
            <a href="<?php echo base_url();?>index.php/pengguna/edit/<?php echo $db['username'];?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/pengguna/hapus/<?php echo $db['username'];?>"
            onClick="return confirm('Do you want to delete the data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
            </td>
			<?php } ?>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="4" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>