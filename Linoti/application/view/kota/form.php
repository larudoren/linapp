<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	function tampil_data(){
		var kode = $("#propinsi_code").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/kota/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#negara_code").focus();
	
	$("#kota_code").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		//CariDataSupplier();
	});
	
	$("#negara").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$("#propinsi_code").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		//CariDataSupplier();
	});
	
	$.extend($.fn.validatebox.defaults.rules, {  
        justText: {  
            validator: function(value, param){  
				return !value.match(/[^a-zA-Z\-]/);
            },  
            message: 'Please enter only alphabets and hypen (-).'  
        },
		myAlpha: {  
            validator: function(value, param){  
				return !value.match(/[^a-zA-Z]\ /);
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
	
	$("#tambah_data").click(function(){
		$("#kota_code").val('');
		$("#kota").val('');
		$("#kota_code").focus();
	});
	
	$("#simpan").click(function(){
		var kota_code		= $("#kota_code").val();
		var kota	= $("#kota").val();
		
		var string = $("#form").serialize();
		
		if(kota_code.length==0 || kota_code.length!=5){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode Kota tidak boleh kosong dan harus 5 digit', 
				timeout:2000,
				showType:'show'
			});
			$("#kota_code").focus();
			return false();
		}
		if(kota.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Kota tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#kota").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/kota/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
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
	<td width="150">Kode Negara</td>
    <td width="5">:</td>
    <td><input type="text" name="negara_code" id="negara_code" size="7" maxlength="3" readonly="readonly" value="<?php echo $negara_code;?>" /></td>
</tr>
<tr>    
	<td>Negara</td>
    <td>:</td>
    <td><input type="text" name="negara" id="negara" size="20" readonly="readonly" value="<?=$negara?>"/></td>
</tr>
<tr>    
	<td width="150">Kode Propinsi</td>
    <td width="5">:</td>
    <td><input type="text" name="propinsi_code" id="propinsi_code" size="7" maxlength="3" readonly="readonly" value="<?php echo $propinsi_code;?>" /></td>
</tr>
<tr>    
	<td>Propinsi</td>
    <td>:</td>
    <td><input type="text" name="propinsi" id="propinsi" size="20" readonly="readonly" value="<?=$propinsi?>"/></td>
</tr>
</table>
</fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
    <tr>    
        <td width="150">Kode Kota</td>
        <td width="5">:</td>
        <td><input type="text" name="kota_code" id="kota_code" class="easyui-validatebox" data-options="required:true,validType:'justText'" size="10" maxlength="5"/>
        <!--<button type="button" name="cari_barang" id="cari_barang" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>-->
        </td>
    </tr>
    <tr>    
        <td>Kota</td>
        <td>:</td>
        <td><input type="text" name="kota" id="kota"  size="50" class="easyui-validatebox" data-options="required:true,validType:'myAlpha'" maxlength="50"/></td>
    </tr>
    </table>
    </fieldset>
</td>
</tr>
<tr>
<td colspan="2">
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <!-- <a href="<?php echo base_url();?>index.php/propinsi/tambah"> -->
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    <!--</a> -->
    <a href="<?php echo base_url();?>index.php/kota/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
</td>
</tr>
<tr>
<td colspan="2">
<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="Kota" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="txt_cari" id="txt_cari" size="50" />
	<div id="data_kota"></div>
</div>
</td>
</tr>
</table> 