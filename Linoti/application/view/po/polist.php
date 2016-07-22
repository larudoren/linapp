<!--
<script type="text/javascript">
		$(document).ready(function() { 
			$("a#example6").fancybox({
				'titlePosition'		: 'inside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9,
				'closeClick'			: false,
				'autoDimenstions'	: true, 
				'closeButton'			: true,
				'border'					: true,
				'hideOnOverlayClick' : false,
			}); 
			
			$("a.showpdf").click(function (e){
				//e.preventDefault();
				//$("#popfoto").attr('width','260px');
				//$("#popfoto").load($(this).attr('href'));
				alert(e.href)
				//return false(); */
				//window.open('<?php echo site_url();?>/po/showpdf/'+e.href);
			});

		});
	</script>
	-->
<script type="text/javascript">
	var po_file = '';
	
	$('#dlgdel').dialog({
		 buttons: [{
				text:'Yes',
				//iconCls:'icon-del',
				handler:function(){
					//alert(po_file);
					ok_del(po_file);
				}
		},{
				text:'No',
				handler:function(){
						$('#dlgdel').dialog('close');
				}
		}]
	});
	
	function ok_del(datafile){
		//alert(datafile)
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po/hapuspdf",
			data	: "file="+datafile,
			cache	: false,
			success	: function(data){ 
				$('#dlgdel').dialog('close');
				document.location.reload(true);
				/*
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				tampil_data();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server not respond :'+kesalahan,
					timeout:2000,
					showType:'slide'
				}); */
			} 
		});
		return false();
	}
	
	function funct_hapus(datafile){
		po_file = datafile;
		$('#dlgdel').dialog('open');
	}
	
</script>
<div id="view">
	<div style="float:left; padding-bottong: 5px">
		<a href="<?php echo base_url();?>index.php/po/">
			<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
		</a>
		<a href="<?php echo base_url();?>index.php/po/polist/<?php echo $supplier_code; ?>">
			<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
		</a>
	</div>
	
	
	
	<div style="float:right; padding-bottom:5px;">
		<form name="form" method="post" action="<?php echo base_url();?>index.php/po/polist/<?php echo $supplier_code; ?>">
		PO : <input type="text" name="txt_cari" id="txt_cari" size="50" />
		<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
		</form>
	</div>
	
	<div id="gird" style="float:left; width:100%;">
		<table id="dataTable" width="100%">
			<tr>
				<th width="80">No</th>
				<th>PO</th>
				<th width="100"></th>
			</tr>
<?php
	$data_file = $this->app_model->dir_files_name($dir_name,$cari,$supplier_code,'');
	if (!empty($data_file)){
			echo $data_file;
	} else {
?>
			<tr>
				<td colspan="3" align="center">Empty File</td>
			</tr>
<?php
	}
?>
		</table>
	</div>
</div>

<div id="dlgdel" align="center" class="easyui-dialog" title="Confirmation" style="width:250px;height:120px;padding:10px;" data-options="modal:true,closed:true">
	Are you sure want to delete this PO?
</div>
