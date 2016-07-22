<div id="view">
<div style="float:left; padding-bottom:5px;">
<a href="<?php echo base_url();?>index.php/collection/tambah/<?=$brand?>">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?php echo base_url();?>index.php/collection/name/<?=$brand?>">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<a href="<?php echo base_url();?>index.php/brand">
<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
</a>
</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/collection/name/<?=$brand?>">
Code & Collection : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
    <th>No</th>
	<th>Code</th>
    <th>Collection</th>
    <th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){
		?>    
    	<tr>
            <td align="center"><?=$no?></td>
            <td><?=$db['coll_code']?></td>
            <td><a href="<?=site_url('product/name/'.$db['coll_name'].'/'.$db['brand_name'])?>"><?=$db['coll_name']?></a></td>
            <td align="center" width="80">
							<a href="<?php echo base_url();?>index.php/collection/edit/<?=$db['brand_name']?>:<?=$db['coll_code']?>:<?=$db['coll_brand']?>">
								<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
							</a>
							<a href="<?php echo base_url();?>index.php/collection/hapus/<?=$db['brand_name']?>:<?=$db['coll_code']?>:<?=$db['coll_brand']?>"
									onClick="return confirm('Do you want to delete the data?')">
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
        	<td colspan="7" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>