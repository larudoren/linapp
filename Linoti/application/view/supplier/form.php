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
		var kode = $("#kode").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/supplier/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#kode").focus();
	
	$("#kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataSupplier();
	});
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	//if ($("#status").val()=='2'){
		$("#kode").attr("readonly","true");
	//}
	//else {
	//	$("#kode").removeAttr("readonly");
	//}
	
	$("#tambah_data").click(function(){
		$(".detail").val('');
		$("#name").val('');
		$("#name").focus();
	});
	
	//$.fn.combobox.onChange = function (newValue,oldValue){
	//	alert(newValue);
	//}
	/*
	$("#negara").change(function(){
		//if (newValue!=oldValue)
			alert('A');
	});
	
	$("#negara").combobox({
		onChange : function (newValue,oldValue){
			//var url = "<?php echo site_url(); ?>/ref_json/DataPropinsi"
			var kode = newValue;
			//alert(newValue+' '+oldValue);
			$("#kota").val('');
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/ref_json/DataPropinsi",
				data	: "kode="+kode,
				cache	: false,
				dataType : "json",
				success	: function(data){
					$("#propinsi").combobox('reload',data);
				}
			});
			
		}
	}); */
	function CariDataSupplier(){
		var kode = $("#kode").val()
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoSupplier",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_supp").val(data.nama);
				$("#alamat").val(data.alamat);
				$("#negara").val(data.negara);
				$("#telp").val(data.telp);
				$("#fax").val(data.fax);
				$("#website").val(data.website);
			}
		});
	}
	
	$("#simpan").click(function(){
		var kode				= $("#kode").val();
		var tanggal				= $("#tgl").val();
		var nama_supp			= $("#nama_supp").val();
		var alamat				= $("#alamat").val();
		var negara				= $("#negara").val();
		var telp				= $("#telp").val();
		var fax					= $("#fax").val();
		var website				= $("#website").val();
		var remarks				= $("#remarks").val();
		var name				= $("#name").val();
		var position			= $("#position").val();
		var mobile1				= $("#mobile1").val();
		var mobile2				= $("#mobile2").val();
		var mobile3				= $("#mobile3").val();
		var email1				= $("#email1").val();
		var email2				= $("#email2").val();
		var email3				= $("#email3").val();
		var remarkscontact		= $("#remarkscontact").val();
		
		var string = $("#form").serialize();
		/*
		if(kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Code cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode").focus();
			return false();
		} */
		if(nama_supp.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier Name cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_supp").focus();
			return false();
		}
		if(alamat.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier Address cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#alamat").focus();
			return false();
		}
		if(negara.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier Country cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#negara").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/supplier/simpan",
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
<table width="100%">
<tr>
<td valign="top" width="50%">
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Code</td>
    <td width="5">:</td>
    <td><input type="text" name="kode" id="kode" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $kode;?>" /><input type="hidden" name="status" id="status" value="<?php echo $status; ?>" /></td>
</tr>
<tr>    
	<td>Supplier Name</td>
    <td>:</td>
    <td><input type="text" name="nama_supp" id="nama_supp"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true" value="<?php echo $nama_supp;?>"/></td>
</tr>
<tr>    
	<td>Supplier PO Code</td>
    <td>:</td>
    <td><input type="text" name="kode_po" id="kode_po"  size="10" maxlength="5" class="easyui-validatebox" data-options="required:true" value="<?php echo $kode_po;?>"/></td>
</tr>
<tr>    
	<td>Supplier Address</td>
    <td>:</td>
    <td><input type="text" name="alamat" id="alamat"  size="80" class="easyui-validatebox" value="<?php echo urldecode($alamat);?>"/>
    </td>
</tr>
<tr>    
	<td>POS Code</td>
    <td>:</td>
    <td><input type="text" name="kodepos" id="kodepos"  size="30" maxlength="30" class="easyui-validatebox" value="<?php echo $kodepos;?>"/></td>
</tr>
<tr>    
	<td>Supplier Country</td>
    <td>:</td>
    <td><input type="text" name="negara" id="negara"  size="80" class="easyui-validatebox" value="<?php echo urldecode($negara);?>"/>
	</td>
</tr>
<tr>    
	<td>Province</td>
    <td>:</td>
    <td><input type="text" name="propinsi" id="propinsi"  size="80" class="easyui-validatebox" value="<?php echo urldecode($propinsi);?>"/>
	</td>
</tr>
<tr>    
	<td>City</td>
    <td>:</td>
    <td><input type="text" name="kota" id="kota"  size="80" class="easyui-validatebox" value="<?php echo urldecode($kota);?>"/>
	</td>
</tr>
<tr>    
	<td>Telp</td>
    <td>:</td>
    <td><input type="text" name="telp" id="telp"  size="30" maxlength="30" value="<?php echo $telp;?>"/></td>
</tr>
<tr>    
	<td>Fax</td>
    <td>:</td>
    <td><input type="text" name="fax" id="fax"  size="30" maxlength="30" value="<?php echo $fax;?>"/></td>
</tr>
<tr>    
	<td>Email</td>
    <td>:</td>
    <td><input type="text" name="email" id="email"  size="30" maxlength="30" value="<?php echo $email;?>"/></td>
</tr>
<tr>    
	<td>Website</td>
    <td>:</td>
    <td><input type="text" name="website" id="website"  size="30" maxlength="30" class="easyui-validatebox" data-options="validType:'url'" value="<?php echo $website;?>"/></td>
</tr>
<tr>    
	<td>Remarks</td>
    <td>:</td>
    <td><input type="text" name="remarks" id="remarks"  size="30" maxlength="30" class="easyui-validatebox" value="<?php echo $remarks;?>"/></td>
</tr>
</table>
</td>
</fieldset>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
    <tr>    
        <td width="150">Contact Name</td>
        <td width="5">:</td>
        <td><input type="text" name="name" id="name" size="50" maxlength="50" class="detail"/>
        <!--<button type="button" name="cari_barang" id="cari_barang" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button>-->
        </td>
    </tr>
    <tr>    
        <td>Position</td>
        <td>:</td>
        <td><input type="text" name="position" id="position"  size="30" class="detail" maxlength="30"/></td>
        <td><input type="hidden" name="sequence" id="sequence"  size="30" class="detail" maxlength="30"/></td>
    </tr>
    <tr>    
        <td>Mobile 1</td>
        <td>:</td>
        <td><input type="text" name="mobile1" id="mobile1"  size="30" class="detail" maxlength="30"/></td>
    </tr>
    <tr>    
        <td>Mobile 2</td>
        <td>:</td>
        <td><input type="text" name="mobile2" id="mobile2"  size="30" class="detail" maxlength="30"/></td>
    </tr>
	<tr>    
        <td>Mobile 3</td>
        <td>:</td>
        <td><input type="text" name="mobile3" id="mobile3" class="detail" size="30" maxlength="30" /></td>
    </tr>
	<tr>    
        <td>Email 1</td>
        <td>:</td>
        <td><input type="text" name="email1" id="email1"  size="30" class="detail" maxlength="30"/></td>
    </tr>
    <tr>    
        <td>Email 2</td>
        <td>:</td>
        <td><input type="text" name="email2" id="email2"  size="30" class="detail" maxlength="30"/></td>
    </tr>
	<tr>    
        <td>Email 3</td>
        <td>:</td>
        <td><input type="text" name="email3" id="email3" class="detail" size="30" maxlength="30" /></td>
    </tr>
	<tr>    
        <td>Remarks</td>
        <td>:</td>
        <td><input type="text" name="remarkscontact" id="remarkscontact" class="detail" size="80" maxlength="80" /></td>
    </tr>
    </table>
    </fieldset>
</td>
</tr>
</table>   
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <!-- <a href="<?php //echo base_url();?>index.php/supplier/tambah"> -->
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    <!--</a> -->
    <a href="<?php echo base_url();?>index.php/supplier/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="Supplier Contact" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Search : <input type="text" name="txt_cari" id="txt_cari" size="50" />
	<div id="kontak_supplier"></div>
</div>