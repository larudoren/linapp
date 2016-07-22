<div id="view">
<div style="float:left; padding-bottom:5px;">
<?php
	if($this->session->userdata('level')=='01'){
?>
<!--
<a href="<?php echo base_url();?>index.php/porpinsi/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Tambah Data</button>
</a> -->
<a href="<?php echo base_url();?>index.php/kota">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<?php } ?>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/kota">
Cari Kode Negara, Kode Propinsi & Nama Propinsi : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
    <th>No</th>
	<th>Kode Propinsi</th>
	<th>Propinsi</th>
	<th>Negara</th>
	<?php
		if($this->session->userdata('level')=='01'){
	?>
    <th>Aksi</th>
	<?php } ?>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
            <td align="center"><?=$no?></td>
            <td><?=$db['propinsi_code']?></td>
            <td><?=$db['propinsi']?></td>
            <td><?=$db['negara']?></td>
			<?php
				if($this->session->userdata('level')=='01'){
			?>
            <td align="center" width="80">
            <a href="<?php echo base_url();?>index.php/kota/edit/<?=$db['negara_code']?>/<?=$db['propinsi_code']?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a> <!--
            <a href="<?php echo base_url();?>index.php/negara/hapus/<?=$db['negara_id']?>"
            onClick="return confirm('Anda yakin ingin menghapus data ini?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Hapus'>
			</a> -->
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