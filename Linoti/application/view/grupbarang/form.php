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
	
	function CariDataSupplier(){
		var kode = $("#kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoSupplier",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_supp").val(data.nama_supplier);
				$("#alamat").val(data.alamat);
				$("#negara").val(data.negara);
				$("#telp").val(data.telp);
				$("#fax").val(data.telp);
				$("#email").val(data.telp);
			}
		});
	}
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		var nama_grup	= $("#nama_grup").val();
		var keterangan	= $("#keterangan").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Kode tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		if(nama_grup.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Grup tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_grup").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/grupbarang/simpan",
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
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Kode</td>
    <td width="5">:</td>
    <td>
		<select class="easyui-combobox" data-options="required:true" id="kode" name="kode">
			<option value="-"> -- Tipe Grup --</option>
			<?php
				foreach($data->result() as $t) {
					$tipe_code = $t->tipe_code;
					$tipe_name = $t->tipe_name;
			?>
			<option value="<?=$tipe_code?>"><?=$tipe_name?></option>
			<?php
				}
			?>
		</select>
	</td>
</tr>
<tr>    
	<td>Nama Grup</td>
    <td>:</td>
    <td><input type="text" name="nama_grup" id="nama_grup" size="20" class="easyui-validatebox" data-options="required:true" value="<?=$nama_grup?>"/></td>
</tr>
<tr>    
	<td>Keterangan</td>
    <td>:</td>
    <td><input type="text" name="keterangan" id="keterangan" size="20" class="easyui-validatebox" value="<?=$keterangan?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/grupbarang/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/grupbarang/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>