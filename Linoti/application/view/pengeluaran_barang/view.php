<script type="text/javascript">
$(document).ready(function(){
	$("#cari_tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
});
</script>
<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/pengeluaran_barang/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/pengeluaran_barang">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/pengeluaran_barang">
Date <input type="text" name="cari_tgl" id="cari_tgl" size="15" />
Code : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<!--<th>Code</th>-->
  <th>Date</th>
	<!--<th>PI</th>-->
	<th>Customer</th>
	<th>Department</th>
	<th>Item</th>
	<th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		$tgl = $this->app_model->tgl_indo($db['tgl_keluar']);
		$item = $this->app_model->ItemKeluar($db['kode_keluar']);
		$jml = $this->app_model->JmlJual($db['kode_keluar']);
		?>    
    	<tr>
				<!--<td align="center" width="100" ><?php echo $db['kode_keluar']; ?></td>-->
        <td align="center" width="100" ><?php echo $tgl; ?></td>
				<!--<td align="center" width="100" ><?php echo $db['pi']; ?></td>-->
				<td align="center" width="100" ><?php echo urldecode($db['cust_name']); ?></td>
				<td align="center" width="100" ><?php echo $db['dept_name']; ?></td>
				<td align="right" width="100" ><?php echo $item; ?></td>
				<td align="center" width="80">
             <?php
			if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='02' || $this->session->userdata('level')=='04'){
			?>
            <a href="<?php echo base_url();?>index.php/pengeluaran_barang/edit/<?php echo $db['kode_keluar'];?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/pengeluaran_barang/hapus/<?php echo $db['kode_keluar'];?>"
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
        	<td colspan="7" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>