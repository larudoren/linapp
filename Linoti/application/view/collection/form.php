<?php
	if(isset($data)) {
		$brand = $data->row();
		$brand_code = $brand->brand_code;
		$brand_name = $brand->brand_name;
	}
?>
<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kode").focus();
	
	$("#kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataSupplier();
	});
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		var nama_val	= $("#nama_val").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Code cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		if(nama_val.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Collection cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_val").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/collection/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				//CariSimpanan();
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
    <td>
		<input type="hidden" name="brand_code" id="brand_code" value="<?=$brand_code?>" />
		<input type="text" name="kode" id="kode" size="7" maxlength="3" readonly="readonly" class="easyui-validatebox" data-options="required:true,validType:'length[3]'" value="<?php echo $kode;?>" />
	</td>
</tr>
<tr>    
	<td>Collection</td>
    <td>:</td>
    <td><input type="text" name="nama_val" id="nama_val" size="20" class="easyui-validatebox" data-options="required:true" value="<?=$nama_val?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/collection/tambah/<?=$brand_name?>">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a>
    <a href="<?php echo base_url();?>index.php/collection/name/<?=$brand_name?>">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>