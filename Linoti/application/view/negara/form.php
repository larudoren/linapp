<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	
	$("#negara_code").focus();
	
	$("#negara_code").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		//CariDataSupplier();
	});
	
	$("#negara").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$.extend($.fn.validatebox.defaults.rules, {  
        justText: {  
            validator: function(value, param){  
				return !value.match(/[^a-zA-Z\- ]/);
            },  
            message: 'Please enter only alphabets and hypen (-).'  
        },
		myAlpha: {  
            validator: function(value, param){  
				return !value.match(/[^a-zA-Z]/);
            },  
            message: 'Please enter only alphabets and maximum 3 characters.'  
        }
    });
	/*
	$.extend($.fn.validatebox.defaults.rules, {  
        justText: {  
            validator: function(value, param){  
				return !value.match(/[^a-zA-Z\- ]/);
            },  
            message: 'Please enter only alphabets and hypen (-).'  
        }  
    }); */
	
	$("#simpan").click(function(){
		var negara_code		= $("#negara_code").val();
		var negara	= $("#nama_dept").val();
		
		var string = $("#form").serialize();
		
		if(negara_code.length==0 || negara_code.length!=3){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong dan harus 3 digit', 
				timeout:2000,
				showType:'show'
			});
			$("#negara_code").focus();
			return false();
		}
		if(negara.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Negara tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#negara").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/negara/simpan",
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
					msg: 'Server tidak merespon :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();		
	});
	
});	
</script>
<table width="100%">
<tr>
<td valign="top" width="50%">
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Kode</td>
    <td width="5">:</td>
    <td><input type="text" name="negara_code" id="negara_code" size="7" maxlength="3" class="easyui-validatebox" data-options="required:true,validType:'myAlpha'" value="<?php echo $negara_code;?>" /><input type="hidden" id="negara_id" name="negara_id" value="<?php echo $negara_id;?>" /></td>
</tr>
<tr>    
	<td>Negara</td>
    <td>:</td>
    <td><input type="text" name="negara" id="negara" size="20" class="easyui-validatebox" data-options="required:true,validType:'justText'" value="<?=$negara?>"/></td>
</tr>
</table>
</fieldset>
</tr>
<tr>
<td colspan="2">
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/negara/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/negara/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
</td>
</tr>
</table> 