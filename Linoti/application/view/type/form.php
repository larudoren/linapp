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
		//CariDataSupplier();
	});
	
	var edepartemen = '<?php echo $departemen; ?>';
	if (edepartemen.length!=0){
		var temp = edepartemen.split(",");
		$('#departemen').combogrid('setValues',temp);
	}
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		var type	= $("#type").val();
		
		var string = $("#form").serialize();
		var departemens = $('#departemen').combogrid('getValues');
		
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, do not leave Code empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		if(type.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, do not leave Type empty', 
				timeout:2000,
				showType:'show'
			});
			$("#type").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/type/simpan",
			data	: string+'&departemens='+departemens,
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
	<td>Type</td>
    <td>:</td>
    <td><input type="text" name="type" id="type" size="60" class="easyui-validatebox" data-options="required:true" value="<?=$type?>"/></td>
</tr>
<tr>    
	<td>Department</td>
    <td>:</td>
    <td><select name="departemen" id="departemen"  style="width:300px" class="easyui-combogrid" data-options="
			panelWidth: 300,
			panelHeight: 300,
			idField: 'dept_code',
			textField: 'dept_name',
			multiple:true,
			url: '<?php echo site_url(); ?>/ref_json/ComboboxDepartemen',
			method: 'post',
			columns: [[
				{field:'dept_code',title:'Dept Code',width:80, hidden:true},
				{field:'dept_name',title:'Departemen',width:200}
			]],
			fitColumns: true,
			onChange : function(newValue,oldValue){
				var url = '<?php echo site_url(); ?>/ref_json/DataFamily/'+newValue;
				$('#family').combobox('reload',url);
			},
			filter: function(q, row){
				var opts = $(this).combogrid('options');
				return row[opts.textField].indexOf(q) == 0;
			}"/></td>
</tr>
<tr>
	<td>Family</td>
	<td>:</td>
	<td>
		<select name="family" id="family" class="easyui-combobox" data-options="valueField:'family_id',textField:'family', onLoadSuccess:function(){$(this).combobox('select','<?php echo $family; ?>')}" />
	</td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/type/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a>
    <a href="<?php echo base_url();?>index.php/type/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>