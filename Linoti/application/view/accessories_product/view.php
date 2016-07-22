<script type="text/javascript">
$(document).ready(function(){
	$("#cari_tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
});
</script>
<div id="view">
<div style="float:left; padding-bottom:5px;"><!--
<a href="<?php echo base_url();?>index.php/accessories_product/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>-->
<a href="<?php echo base_url();?>index.php/accessories_product">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/accessories_product">
PI Number : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>PI Number</th>
  <th>Code</th>
	<th>Name</th>
  <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		//$tgl = $this->app_model->tgl_indo($db['tanggal']);
		//$item = $this->app_model->ItemKeluar($db['kode_keluar']);
		//$jml = $this->app_model->JmlJual($db['kode_keluar']);
		?>    
    	<tr>
            <td align="center" width="100" ><?php echo $db['pi_number']; ?></td>
            <td align="center" width="100" ><?php echo $db['product_code']; ?></td>
            <td align="center" width="100" ><?php echo $db['product_name']; ?></td>
            <td align="center" width="80">
						<a href="<?php echo base_url();?>index.php/accessories_product/detail/<?=$db['pi_number'].'-'.$db['seq'].'-'.$db['coll_name'].'-'.$db['brand_name']?>">
			<img src="<?php echo base_url();?>asset/images/browse.png" title='Detail'>
			</a>
             <?php
			if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='02' || $this->session->userdata('level')=='04'){
			?>
     
            <?php } ?>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="7" align="center">Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>