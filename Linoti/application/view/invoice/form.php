<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#pi_number").focus();
	
	$("#pi_number").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataSupplier();
	});
	
	$("#tgl_order").datepicker({
			dateFormat:"yy-mm-dd"
    });
	
	$("#cancel_customer").click(function(){
		$("#NewCustomerform").form('clear');
		$("#dlgNewCustomer").dialog('close');
	});
	
	$("#save_customer").click(function(){
		var newCustomerName = $("#NewCustomerName").val();
		
		var string = $("#NewCustomerform").serialize();
		if (newCustomerName.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, New Customer Name cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/invoice/simpan_customer",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				$("#NewCustomerform").form('clear');
				$("#dlgNewCustomer").dialog('close');
				$("#text_cari").val(newCustomerName);
				AmbilDaftarCustomer();
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
	
	$("#simpan").click(function(){
		//var pi_number		= $("#pi_number").val();
		var tgl_order		= $("#tgl_order").val();
		var cust_code	= $("#cust_code").val();
		
		var string = $("#form").serialize();
		/*
		if(pi_number.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PI No. cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		} */
		if(tgl_order.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Date PI cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#tgl_order").focus();
			return false();
		}
		if(cust_code.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Customer Name cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#cust_code").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/invoice/simpan",
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
	
	$("#cari_customer").click(function(){
		AmbilDaftarCustomer();
		$("#dlg").dialog('open');
	});
	
	$("#tambah_customer").click(function(){
		$("#dlgNewCustomer").dialog('open');
	});
	
	$("#text_cari").keyup(function(){
		AmbilDaftarCustomer();
		//$("#dlg").dialog('open');
	}).keyup();
	
	function AmbilDaftarCustomer(){
		var cari = $("#text_cari").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataCustomer",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_customer").html(data);
			}
		});
	}
	
	
	if ($("#cust_code").val()!=''){
		CariCustomer();
	}
	
	$("#cust_code").focus(function(e){
		var isi = $(e.target).val();
		CariCustomer();
	});
	
	$("#cust_code").keyup(function(){
		CariCustomer();
	});
	
	function CariCustomer(){
		var kode = $("#cust_code").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoCustomer",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#cust_name").val(data.nama);
			}
		});
	};
	
});	
</script>
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td>Customer Name</td>
  <td>:</td>
  <td>
		<input type="text" name="cust_name" id="cust_name" size="32" readonly="readonly"/>
		<input type="text" name="cust_code" id="cust_code" hidden="true" value="<?=$cust_code?>" data-options="required:true,validType:'length[3,3]'" class="easyui-validatebox" />
    <button type="button" name="cari_customer" id="cari_customer" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
	</td>
</tr>
<tr>    
	<td>Date PI</td>
	<td>:</td>
	<td><input type="text" name="tgl_order" id="tgl_order" size="20" maxlength="10" class="easyui-validatebox" data-options="required:true" value="<?=$tgl_order?>"/></td>
</tr>
<tr>    
	<td width="150">PI Number</td>
	<td width="5">:</td>
	<td>
		<input type="text" name="pi_number" id="pi_number" size="20" maxlength="50" <?php if ($pi_number!=''){ ?>  readonly="readonly" <?php } ?>class="easyui-validatebox" value="<?php echo $pi_number;?>" />
		<input type="text" name="pi_id" id="pi_id" hidden="true" value="<?=$pi_id?>" class="easyui-validatebox" />
	</td>
</tr>
<!--
<tr>
	<td>Judul</td>
	<td>:</td>
	<td><input type="text" name="judul" id="judul" size="20" class="easyui-validatebox" value="<?=$judul?>"/></td>
</tr> -->
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/invoice/tambah">
			<button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a>
    <a href="<?php echo base_url();?>index.php/invoice/">
			<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
	</td>
</tr>
</table>  
</fieldset>   
</form>
<div id="dlg" class="easyui-dialog" title="Data Customer" style="width:900px;height:400px; padding:5px;" data-options="modal:true,closed:true">
	Search : <input type="text" name="text_cari" id="text_cari" size="50" /> <button type="button" name="tambah_customer" id="tambah_customer" class="easyui-linkbutton" data-options="iconCls:'icon-add'">New Customer</button>
	<div id="daftar_customer"></div>
</div>
<div id="dlgNewCustomer" class="easyui-dialog" title="New Customer" style="width:900px;height:400px; padding:5px;" data-options="modal:true,closed:true">
	<form name="NewCustomerform" id="NewCustomerform">
	<fieldset class="atas">
	<table width="100%">
		<tr>
			<td>Customer Name</td>
			<td>:</td>
			<td><input type="text" class="easyui-validatebox" name="NewCustomerName" id="NewCustomerName" size="50" /></td>
		</tr>
		<!--
		<tr>
			<td>Customer Country</td>
			<td>:</td>
			<td><input type="text" class="easyui-validatebox" name="NewCustomerCountry" id="NewCustomerCountry" size="50" /></td>
		</tr> -->
	</table>
	</fieldset>
	<fieldset class="bawah">
	<table width="100%">
		<tr>
			<td colspan="3" align="center">
				<button type="button" name="save_customer" id="save_customer" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
				<button type="button" name="cancel_customer" id="cancel_customer" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CANCEL</button>
			</td>
		</tr>
	</table>
	
</div>