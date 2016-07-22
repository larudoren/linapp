<div id="view">
<div style="float:left; padding-bottom:5px;">
<?php
	if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='03' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
?>
<a href="<?php echo base_url();?>index.php/type/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/type">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<?php } ?>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/type">
Code & Type : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
    <th>No</th>
    <!--<th>Code</th>-->
    <th>Type</th>
	<?php
		if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='03' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
	?>
    <th>Action</th>
	<?php } ?>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
            <td align="center" width="5%"><?=$no?></td>
            <!--<td><?=$db['type_id']?></td>-->
            <td><?=$db['type']?></td>
			<?php
				if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='03' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
			?>
            <td align="center" width="80">
            <a href="<?php echo base_url();?>index.php/type/edit/<?=$db['type_id']?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/type/hapus/<?=$db['type_id']?>"
            onClick="return confirm('Do you want to delete data?')">
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
        	<td colspan="7" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>