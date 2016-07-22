<script type="text/javascript">
$(document).ready(function(){
	$("#cari_tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
});
</script>
<div id="view">
<div style="float:left; padding-bottom:5px;">
<!--
<a href="<?php echo base_url();?>index.php/po/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>-->
<a href="<?php echo base_url();?>index.php/po">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/po">
Supplier : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
	<th>Supplier</th>
	<!--<th>Action</th>-->
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
			<td align="center" width="30px"><?php echo $no; ?></td>
            <td align="left"><a href="<?php echo base_url();?>index.php/po/polist/<?php echo urldecode($db['supplier_code']);?>"><?php echo urldecode($db['supplier_name']); ?></a></td>
            <!--<td align="center">-->
            <?php
			//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='02' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
			?>
           <!-- <a href="<?php echo base_url();?>index.php/po/edit/<?php echo urldecode($db['supplier_code']);?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>-->
      <!--      <a href="<?php echo base_url();?>index.php/po/hapus/<?php echo urldecode($db['supplier_code']);?>"
            onClick="return confirm('Do you want to delete this data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a> -->
            <?php //} ?>
            <!--</td>-->
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