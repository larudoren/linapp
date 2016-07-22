<div id="view">
<div style="float:left; padding-bottom:5px;">
<!-- <a href="<?php echo base_url();?>index.php/brand/tambah"> -->
<?php
	if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='06'){
?>
<!-- <button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/brand">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>-->
<?php } ?>

</div> <!--
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/brand">
Code & Brand : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div> -->
<div id="gird" style="float:left; width:100%;">
<!--
<table id="dataTable" width="100%">
<tr>
    <th>No</th>
		<th>Code</th>
    <th>&nbsp;</th>
	<?php
		if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='06'){
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
            <td align="center"><?=$no?></td>
            <td><?=$db['brand_code']?></td>
            <td><a href="<?=site_url('collection/name/'.$db['brand_name'])?>"><?=$db['brand_name']?></a></td>
			<?php
				if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='06'){
			?>
            <td align="center" width="80">
            <a href="<?php echo base_url();?>index.php/brand/edit/<?=$db['brand_code']?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/brand/hapus/<?=$db['brand_code']?>"
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
        	<td colspan="7" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table> -->
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
<form name="form" method="post" action="<?php echo base_url();?>index.php/product/name">
	<table id="dataTable" width="50%" style="margin-left:250px;border:none">
		<tr>
			<th style="width:120px;">Code</th>
			<th style="width:120px;">Collection</th>
			<th style="width:120px;">Type</th>
			<th style="width:120px;">Category</th>
		</tr>
		<tr>
			<td><input type="text" name="code_cari" id="code_cari" size="20" /></td>
			<td>
				<select class="easyui-combobox" name="coll_cari" id="coll_cari" style="width:140px">
					<option value="">-- Select --</option>
					<?php 
						foreach($l_collection->result() as $t_coll){
					?>
							<option value="<?=$t_coll->coll_name?>"><?=$t_coll->coll_name?></option>
					<?php
						}
					?>
				</select>
			</td>
			<td>
				<select type="text" class="easyui-combobox" name="type_cari" id="type_cari" style="width:180px">
					<option value="">-- Select --</option>
					<?php 
						foreach($l_type->result() as $t_type){
					?>
							<option value="<?=$t_type->type_product?>"><?=$t_type->type_product?></option>
					<?php
						}
					?>
				</select>
			</td>
			<td>
				<select class="easyui-combobox" name="category_cari" id="category_cari" style="width:140px">
					<option value="">-- Select --</option>
					<option value="Furniture">Furniture</option>
					<option value="Upholstery">Upholstery</option>
					<option value="Decoration">Decoration</option>
					<option value="Mirror">Mirror</option>
				</select>
			</td>
			<td>
				<!--<a href="<?php echo base_url();?>index.php/brand">-->
					<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
				<!--</a>-->
			</td>
		</tr>
	</table>

</form>
</div>
<div style="float:center; padding-bottom:5px;">

</div>
</div>