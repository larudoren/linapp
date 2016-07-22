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
	
	if ($("#status").val()=='2'){
		$("#kode").attr("readonly","true");
	}
	else {
		$("#kode").removeAttr("readonly");
	}
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	function CariDataCustomer(){
		var kode = $("#kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoCustomer",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#tgl").val(data.tgl);
				$("#nama_cust").val(data.nama);
				$("#alamat").val(data.alamat);
				$("#negara").val(data.negara);
				$("#telp").val(data.telp);
				$("#fax").val(data.fax);
				$("#mobile").val(data.mobile);
				$("#email").val(data.email);
			}
		});
	}
	
	$("#simpan").click(function(){
		var kode		= $("#kode").val();
		var nama_cust	= $("#nama_cust").val();
		var alamat		= $("#alamat").val();
		var negara		= $("#negara").val();
		var telp		= $("#telp").val();
		var fax			= $("#fax").val();
		var email		= $("#email").val();
		
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
		if(nama_cust.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Customer Name cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_cust").focus();
			return false();
		}
		if(alamat.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Address cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#alamat").focus();
			return false();
		}
		if(negara.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Country cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#negara").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/customer/simpan",
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
    <td><input type="text" name="kode" id="kode" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $kode;?>" /><input type="hidden" name="status" id="status" value="<?php echo $status; ?>" /></td>
</tr>
<tr>    
	<td>Customer Name</td>
    <td>:</td>
    <td><input type="text" name="nama_cust" id="nama_cust"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true" value="<?php echo $nama_cust;?>"/></td>
</tr>
<tr>    
	<td>Customer Name Code</td>
    <td>:</td>
    <td><input type="text" name="name_code" id="name_code"  size="20" maxlength="20" class="easyui-validatebox" data-options="required:true" value="<?php echo $name_code;?>"/></td>
</tr>
<tr>    
	<td>Address</td>
    <td>:</td>
    <td><input type="text" name="alamat" id="alamat"  size="80" class="easyui-validatebox" data-options="required:true" value="<?php echo $alamat;?>"/>
    </td>
</tr>
<tr>    
	<td>Country</td>
    <td>:</td>
    <td><input type="text" name="negara" id="negara"  size="30" maxlength="30" class="easyui-validatebox" data-options="required:true" value="<?php echo $negara;?>"/></td>
</tr>
<tr>    
	<td>Phone</td>
    <td>:</td>
    <td><input type="text" name="telp" id="telp"  size="30" maxlength="30" value="<?php echo $telp;?>"/></td>
</tr>
<tr>    
	<td>Fax</td>
    <td>:</td>
    <td><input type="text" name="fax" id="fax"  size="30" maxlength="30" value="<?php echo $fax;?>"/></td>
</tr>
<tr>    
	<td>Mobile</td>
    <td>:</td>
    <td><input type="text" name="mobile" id="mobile"  size="30" maxlength="30" value="<?php echo $mobile;?>"/></td>
</tr>
<tr>    
	<td>Email</td>
    <td>:</td>
    <td><input type="text" name="email" id="email"  size="30" maxlength="30" class="easyui-validatebox" data-options="validType:'email'" value="<?php echo $email;?>"/></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SIMPAN</button>
    <a href="<?php echo base_url();?>index.php/customer/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">TAMBAH</button>
    </a>
    <a href="<?php echo base_url();?>index.php/customer/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>