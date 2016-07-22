<script type="text/javascript">
	$(function() {
		$('#multiformup').submit(function(e) {
			e.preventDefault();
			var dataForm 		= new FormData($('#multiformup')[0]);
			dataForm.append("id_cotation",  '<?php echo $id_cotation; ?>');
			
			
			var win = $.messager.progress({
				title:'Please wait',
				msg:'Uploading data...',
				text: 'PROCESSING....'
			});
			
			$.ajax({
				type: 'POST',
				url 			:'<?php echo site_url(); ?>/cotation/import_upholstery/', 
				cache	: false,
				processData: false,  // tell jQuery not to process the data
				contentType: false,   // tell jQuery not to set contentType
				data: dataForm,
				/*
				data			: {
					'title'				: $('#title').val()
				},*/
				success	: function (data)
				{
					datas = JSON.parse(data);
					$.messager.progress('close');
					if (datas['status']=='success'){
						$('#dialogUp').dialog('close');
						$('#dgUpholdstery').datagrid('reload');
					} else {
						$.messager.show({
							title:'Info',
							msg:datas['msg'], 
							timeout:2000,
							showType:'show'
						});
					}
					
				}
			});
			return false;
		});
	});
	
	function funct_refreshup(id_cotation){
		$('#dialogUp').dialog('refresh','<?php echo base_url();?>index.php/cotation/showUpholstery/'+id_cotation);
	}
</script>
<!--<form name="multiform" id="multiform" action="<?=site_url('cotation/import_upholstery/'.$id_cotation.'/')?>" method="POST" enctype="multipart/form-data">-->
<form name="multiformup" id="multiformup">
<fieldset class="atas">
Pilih File Excel*: <input name="fileexcel" type="file" id="fileexcel" accept=".xls">
<br/>
* file yang bisa di upload adalah .xls (Excel 2003).<br/>
Download Excel template <a href="<?=base_url('asset/template/Upholstery.xls')?>"><img src="<?=base_url('asset/img/excel.png')?>" width="25px" /></a>
</fieldset>

<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <input type="submit" name="simpan" id="simpan"  class="easyui-linkbutton" data-options="iconCls:'icon-save'" value="Upload" />
	<a onclick="funct_refreshup('<?=$id_cotation?>');">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
	</a>
    </td>
</tr>
</table>  
</form>
</fieldset>
<fieldset>