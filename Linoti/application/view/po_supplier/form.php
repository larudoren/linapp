<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kode").focus();
	//$("#kode").attr('readonly','true');
	
	$("#kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		//CariDataSupplier();
	});
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PO Code cannot_leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}

		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po_supplier/simpan",
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
					msg: 'Server not response :'+kesalahan,
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
	<td width="150">PO Code</td>
    <td width="5">:</td>
    <td>
			<input type="text" name="supplier_code" id="supplier_code" size="7" hidden="true" class="easyui-validatebox" data-options="required:true" value="<?php echo $supplier_code;?>" />
			<input type="text" name="kode" id="kode" size="10" class="easyui-validatebox" data-options="required:true" value="<?php echo $kode;?>" />
		</td>
</tr>

</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/po_supplier/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>