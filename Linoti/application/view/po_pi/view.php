<script type="text/javascript" src="<?=base_url('asset/js/datagrid-scrollview.js')?>"></script>
<script type="text/javascript" src="<?=base_url('asset/js/jquery.edatagrid.js')?>"></script>
<script type="text/javascript">
$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
	};
	
$(document).ready(function(){
	$("#cari_tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
		
	$('#cancel_update').click(function (){
		$('#dlgEdit').dialog('close');
		return false();
	});
	
	$('#save_update').click(function (){
		var string = $("#UpdateItemform").serialize();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po_pi/update_deadline",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				$("#dlgEdit").dialog('close');
				var url = window.location.href;
				window.location.href = url;
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server not respond :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();	
		
	});
	
});

function funct_edit(po,tgldeadline){
	$('#UpdatePO').val(po);
	$('#tgldeadline').datebox('setValue',tgldeadline);
	$("#dlgEdit").dialog('open');
}
</script>
<div id="view">
<div style="float:left; padding-bottom:5px;">
<!--
<a href="<?php echo base_url();?>index.php/po_pi/tambah">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>-->
<a href="<?php echo base_url();?>index.php/po_pi">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>

</div>
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/po_pi">
Date &nbsp; <input type="text" name="cari_tgl" id="cari_tgl" size="15" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Supplier Name : &nbsp;<input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
	<th>PO Number</th>
	<th>Supplier</th>
	<th>PO Date</th>
	<th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){  
		//$tgl = $this->app_model->tgl_indo($db['tgl_terima']);
		//$item = $this->app_model->ItemTerima($db['kode_terima']);
		//$jml = $this->app_model->JmlTerima($db['kode_terima']);
		$tgldeadline = $db['tgldeadline'];
		?>    
    	<tr>
			<td align="center"><?php echo $no; ?></td>
			<td><?php echo $db['po']; ?></td>
      <td><?php echo $db['supplier_name']; ?></td>
			<td align="center"><?php echo $db['tglbeli']; ?></td>
            <td align="center">
            <?php
			if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='02' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='05'){
			?>
            <a href="<?php echo base_url();?>index.php/po_pi/edit/<?php echo $db['po'];?>">
			<img src="<?php echo base_url();?>asset/images/browse.png" title='Detail'>
			</a>
			 <a href="javascript:void(0);" onClick="funct_edit('<?php echo $db['po'];?>','<?php echo $tgldeadline;?>')">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/po_pi/hapus/<?php echo $db['po'];?>"
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
        	<td colspan="8" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>
<div id="dlgEdit" class="easyui-dialog" title="Deadline" style="width:500px;height:235px; padding:5px;"  data-options="modal:true,closed:true">
	<form name="UpdateItemform" id="UpdateItemform">
	<fieldset class="atas">
	<table width="100%">
		<tr>
			<td>Deadline</td>
			<td>:</td>
			<td>
				<input type="text" name="UpdatePO" id="UpdatePO" hidden="true" size="20" />
				<input type="text" name="tgldeadline" id="tgldeadline" class="easyui-datebox" size="15"/>
			</td>
		</tr>
	</table>
	</fieldset>
	<fieldset class="bawah">
	<table width="100%">
		<tr>
			<td colspan="3" align="center">
				<button type="button" name="save_update" id="save_update" class="easyui-linkbutton" data-options="iconCls:'icon-save'">UPDATE</button>
				<button type="button" name="cancel_update" id="cancel_update" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CANCEL</button>
			</td>
		</tr>
	</table>
	</fieldset>
	</form>
</div>