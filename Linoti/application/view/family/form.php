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
	
	var edepartemen = '<?php echo $departemen; ?>';
	if (edepartemen.length!=0){
		var temp = edepartemen.split(",");
		$('#departemen').combogrid('setValues',temp);
	}
	
	$("#simpan").click(function(){
		
		var kode		= $("#kode").val();
		var family	= $("#family").val();
		
		var string = $("#form").serialize();
		var category = $('#category').combogrid('getValues');
		//alert('B');
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
		if(family.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Nama Satuan tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#family").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/family/simpan",
			data	: string+'&departemens='+category,
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
    <td><input type="text" name="kode" id="kode" size="7" class="easyui-validatebox" data-options="required:true" value="<?php echo $kode;?>" /></td>
</tr>
<tr>    
	<td>Family</td>
    <td>:</td>
    <td><input type="text" name="family" id="family" size="60" class="easyui-validatebox" data-options="required:true" value="<?=$family?>"/></td>
</tr>
<tr>    
	<td>Category</td>
    <td>:</td>
    <td>
		<select name="category" id="category"  style="width:300px" class="easyui-combogrid" data-options="
			panelWidth: 300,
			panelHeight: 300,
			idField: 'category_id',
			textField: 'category',
			multiple:true,
			url: '<?php echo site_url(); ?>/ref_json/DataCategory',
			method: 'post',
			mode:'remote',
			columns: [[
				{field:'category_id',title:'Category Id',width:80, hidden:true},
				{field:'category',title:'Category',width:200}
			]],
			fitColumns: true,
			filter: function(q, row){
				var opts = $(this).combogrid('options');
				return row[opts.textField].indexOf(q) == 0;
			}"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/family/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/family/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>