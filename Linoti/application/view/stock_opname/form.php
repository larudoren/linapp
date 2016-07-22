<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	$('#jml').numberbox({
		min:0
	});
	
	$('#jmlpm').numberbox({
		min:0
	});
	
	function tampil_data(){
		var kode = $("#stock_id").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/stock_opname/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#tanggal").datepicker({
			dateFormat:"yy-mm-dd"
    });
	
	$("#nama_brg").focus();
	
	$("#harga").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	//$("#jml").keypress(function(data){
		//if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			//return false;
		//}
	//});
	
	function hitung(){
		var jml = $("#jml").val();
		var harga = $("#harga").val();
		
		var total = parseInt(jml)*parseInt(harga);
		$("#total").val(total);
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga").keyup(function(){
		hitung();
	});
	
	$("#simpan").click(function(){
		var kode	= $("#stock_id").val();
		var tgl		= $("#tanggal").val();
		var kode_brg	= $("#kode_brg").val();
		var jml	= $("#jml").val();
		var jmlpm	= $("#jmlpm").val();
		var total		= $("#total").val();
		var remarks		= $("#remarks").val();
		var departemen		= $("#departemen").combobox('getValue');
		
		var string = $("#form").serialize();
		
		if(kode_brg.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Item Code cannot leave blank', 
				timeout:2000,
				showType:'show'
			});
			$("#kode_brg").focus();
			return false;
		}
		if(departemen.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Departement cannot leave blank', 
				timeout:2000,
				showType:'show'
			});
			$("#departemen").focus();
			return false;
		}
		if(jml.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Amount cannot leave blank', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false;
		}
		
		if (jmlpm.length!=0 && jmlpm!='0' && remarks.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, You have to write description for Quantity Plus/Minus', 
				timeout:2000,
				showType:'show'
			});
			$("#remarks").focus();
			return false;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/stock_opname/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				var tdata = data.split(",");
				$.messager.show({
					title:'Info',
					msg:tdata[0], 
					timeout:2000,
					showType:'slide'
				});
				if (kode.length==0 && tdata[1]!=''){
					$('#stock_id').val(tdata[1]);
				}
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
	
	$("#tambah_data").click(function(){
		$(".detail").val('');
		//$("#kode_brg").val('');
		$("#kode_brg").val('');
		$("#kode_brg").focus();
	});
	/*
	$("#cetak").click(function(){
		var kode	= $("#stock_id").val();
		window.open('<?php echo site_url();?>/stock_opname/cetak/'+kode);
		return false();
	}); */
	
	$("#cari_barang").click(function(){
		AmbilDaftarBarang('');
		$("#dlg").dialog('open');
	});
	
	$("#txt_cari").keyup(function(){
		AmbilDaftarBarang('');
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarBarang(tlimit){
		var cari = $("#txt_cari").val();
		var departemen = $('#departemen').combobox('getValue');
		var limit = '';
		
		if (tlimit.length!=0){
			limit = tlimit;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataTerimaBarang",
			data	: "cari="+cari+'&departemen='+departemen+'&limit='+limit,
			cache	: false,
			success	: function(data){
				$("#daftar_barang").html(data);
			}
		});
	}
});	
</script>
<table width="100%">
<tr>
<td valign="top" width="50%">
<form name="form" id="form">
    <fieldset>
    <table width="100%">
    <tr>    
        <td width="150">Code</td>
        <td width="5">:</td>
        <td><input type="text" name="stock_id" id="stock_id" size="12" readonly="readonly" value="<?php echo $stock_id;?>" /></td>
    </tr>
    <tr>
        <td>Date</td>
        <td>:</td>
        <td><input type="text" name="tanggal" id="tanggal"  size="15" value="<?php echo $tanggal;?>"/></td>
    </tr>
	<tr>    
        <td>Departement</td>
        <td>:</td>
        <td>
			<select name="departemen" id="departemen" class="easyui-combobox" style="width:200px">
				<?php 
				if(empty($departemen)){
				?>
				<option value="">-PILIH-</option>
				<?php
				}
				foreach($l_dept->result() as $t){
					if($departemen==$t->dept_code){
				?>
				<option value="<?php echo $t->dept_code;?>" selected="selected"><?php echo $t->dept_name;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->dept_code;?>"><?php echo $t->dept_name;?></option>
				<?php }
				} ?>
			</select>
		</td>
    </tr>
    </table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
    <tr>    
        <td width="150">Item Code</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_brg" id="kode_brg" size="25" class="easyui-validatebox" data-options="required:true" />
        <button type="button" name="cari_barang" id="cari_barang" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button> 
        </td>
    </tr>
    <tr>    
        <td>Name</td>
        <td>:</td>
        <td><input type="text" name="nama_brg" id="nama_brg" size="50" class="detail" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Unit</td>
        <td>:</td>
        <td><input type="text" name="satuan" id="satuan"  size="20" class="detail" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Quantity</td>
        <td>:</td>
        <td><input type="text" name="jml" id="jml"  size="20" class="detail" maxlength="20" style="text-align:right;"/></td>
    </tr>
	<tr>    
        <td>Quantity Plus/Minus</td>
        <td>:</td>
        <td><input type="text" name="jmlpm" id="jmlpm"  size="20" class="detail" maxlength="20" style="text-align:right;"/><input type="checkbox" name="minus" id="minus" value="minus">Minus</td>
    </tr>
	<tr>    
        <td>Remarks</td>
        <td>:</td>
        <td><input type="text" name="remarks" id="remarks" class="detail" size="50" maxlength="20" /></td>
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
	<button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PRINT</button>
    <a href="<?php echo base_url();?>index.php/stock_opname/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">CLOSE</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="List of items" style="width:900px;height:400px; padding:5px;" data-options="closed:true, modal:true">
	Type name to search : <input type="text" name="txt_cari" id="txt_cari" size="50" />
	<div id="daftar_barang"></div>
</div> <!--
<div id="mbuttons" name="mbuttons" style="display:none" align="right">
        
     <span><input class="easyui-searchbox" name="btncaribrg" id="btncaribrg" style="width:150px"></span>
         
 </div> -->
