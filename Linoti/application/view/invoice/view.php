<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/invoice/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/invoice">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/invoice">
PI Number / Customer : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
    <th>No</th>
		<!--<th>Judul</th>-->
		<th>PI No.</th>
    <th>Date input PI</th>
    <!--<th>Date Shipping</th>-->
    <th>Customer</th>
    <th>Country</th>
    <!--<th>Phone</th>-->
    <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
            <td align="center"><?=$no?></td>
            <!--<td><?=$db['judul']?></td>-->
            <td align="center"><?=$db['pi_number']?></td>
            <td align="center"><?=$this->app_model->tgl_eng($db['pi_dateorder'])?></td>
            <!--<td align="center"><?=$this->app_model->tgl_indo($db['pi_dateshipp'])?></td>-->
            <td><?=urldecode($db['cust_name'])?></td>
            <td><?=$db['cust_state']?></td>
            <!--<td><?=$db['cust_phone']?></td>-->
            <td align="center" width="80">
            <a href="<?php echo base_url();?>index.php/invoice/detail/<?=$db['pi_id']?>/<?=$db['pi_number']?>">
			<img src="<?php echo base_url();?>asset/images/browse.png" title='Detail'>
			</a>
			<a href="<?php echo base_url();?>index.php/invoice/edit/<?=$db['pi_id']?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
			<a href="<?php echo base_url();?>index.php/invoice/tutup/<?=$db['pi_id']?>"
            onClick="return confirm('Do you want to Closing this PI?')">
			<img src="<?php echo base_url();?>asset/images/lock.png" title='Closing'>
			</a>
            <a href="<?php echo base_url();?>index.php/invoice/hapus/<?=$db['pi_id']?>"
            onClick="return confirm('Do you want to Delete this PI?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="8" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>