<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kode").focus();
	$("#kode").attr('readonly','true');
	
	$("#kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataSupplier();
	});
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		var layer	= $("#layer").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Code cannot empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		if(layer.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Layer cannot empty', 
				timeout:2000,
				showType:'show'
			});
			$("#layer").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/layer/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				CariSimpanan();
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
</script>
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Code</td>
    <td width="5">:</td>
    <td><input type="text" name="kode" id="kode" size="7" class="easyui-validatebox" data-options="required:true" value="<?php echo $kode;?>" /></td>
</tr>
<tr>    
	<td>Layer</td>
    <td>:</td>
    <td><input type="text" name="layer" id="layer" size="60" class="easyui-validatebox" data-options="required:true" value="<?=$layer?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/layer/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a>
    <a href="<?php echo base_url();?>index.php/layer/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>