<script type="text/javascript">
$.extend($.fn.datagrid.defaults.editors, {
	combogrid: {
		init: function(container, options){
			var input = $('<input type="text" class="datagrid-editable-input">').appendTo(container); 
			input.combogrid(options);
			return input;
		},
		destroy: function(target){
			$(target).combogrid('destroy');
		},
		getValue: function(target){
			return $(target).combogrid('getValue');
		},
		setValue: function(target, value){
			$(target).combogrid('setValue', value);
		},
		resize: function(target, width){
			$(target).combogrid('resize',width);
		}
	}
});

$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
	};
	$.fn.datebox.defaults.parser = function(s){
		if (!s) return new Date();
		var ss = s.split('-');
		var y = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var d = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	};


$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	tampil_data();
	//alert($('#fstatus').val());
	if ($('#fstatus').val()=='Edit'){
		var tmp  = '<?php echo $kode_supplier; ?>';
		$('#kode_supplier').combogrid('setValue',tmp);
		//$("#kode_supplier").combogrid('grid').datagrid('selectRecord','<?php echo $kode_supplier; ?>');
		var g = $("#kode_supplier").combogrid('grid');
		g.datagrid({
			onLoadSuccess: function (data){
				for (i=0;i<data['total'];i++){
					if (data['rows'][i]['supplier_code']==tmp){
						g.datagrid('selectRow',i);
					}
				}
			}
		
		});

	}
	/*
	$("#tglbeli").datepicker({
			dateFormat:"dd-mm-yy"
    }); */
	
	$("#saveas").click(function(){
		var kode	= $("#po").val();
		//alert(kode);
		if (kode.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
		} else {
			window.open('<?php echo site_url();?>/po_pi/cetak/'+kode+'/saveas');
		}
		return false();
	});
	
	function tampil_data(){
		var kode = $("#po").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po_pi/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	/*
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
	*/
	
	$('#cancel_update').click(function (){
		$('#dlgEdit').dialog('close');
		return false();
	});
	
	$('#save_update').click(function (){
		var string = $("#UpdateItemform").serialize();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po_pi/update_item",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				$("#dlgEdit").dialog('close');
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
	
	$("#simpan").click(function(){
		var supplier		= $("#kode_supplier").combogrid('getValue');
		var tgl		= $("#tglbeli").val();
		var pi	= $("#pi").val();
		//var remarks		= $("#remarks").val();
		
		var string = $("#form").serialize();
		
		if(supplier.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode_supplier").focus();
			return false();
		}
		
		if(tgl.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PO Date cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#tglbeli").focus();
			return false();
		}
		
		if(pi.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PI No. cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#pi").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/po_pi/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				var datas = data.split(",");
				$.messager.show({
					title:'Info',
					msg:datas[0], 
					timeout:2000,
					showType:'slide'
				});
				//alert(data[0]+' '+data[1]);
				$('#po').val(datas[1]);
				$('#simpan').hide();
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
	
	$("#cetak").click(function(){
		var kode	= $("#po").val();
		window.open('<?php echo site_url();?>/po_pi/cetak/'+kode);
		return false();
	});
	
});	
</script>
<form name="form" id="form">
<table width="100%">
<tr>
<td valign="top" width="50%">
    <fieldset>
    <table width="100%">
    <tr>    
			<td width="150">PO</td>
			<td width="5">:</td>
			<td><input type="text" name="po" id="po" size="30" value="<?=$po?>" readonly="readonly"/><input type="text" name="fstatus" id="fstatus" hidden="true" value="<?=$fstatus?>" /></td>
    </tr>    
    <tr>    
        <td width="150">Supplier</td>
        <td width="5">:</td>
        <td>
					<select name="kode_supplier" id="kode_supplier"  style="width:200px" class="easyui-combogrid" data-options="
								panelWidth: 550,
								panelHeight: 400,
								disabled:true,
								idField: 'supplier_code',
								textField: 'supplier_name',
								url: '<?php echo site_url(); ?>/ref_json/ComboboxPIAllSupplier',
								method: 'post',
								mode:'remote',
								pageList: [20,40,100],
								columns: [[
									{field:'supplier_code',title:'Kode Supplier',width:80, hidden:true},
									{field:'supplier_name',title:'Supplier',width:300},
									{field:'supplier_address',title:'Address', align:'left', width:300},
									{field:'supplier_country',title:'Country', align:'left', width:150}
								]],
								onBeforeLoad: function (param){
									param.pi = $('#pi').val();
									param.po_date = $('#tglbeli').val();
								},
								fitColumns: true,
								filter: function(q, row){
									var opts = $(this).combogrid('options');
									return row[opts.textField].indexOf(q) == 0;
								},
								pagination:true"/>
			</td>
    </tr>
    <tr>    
        <td>PO Date</td>
        <td>:</td>
        <td><input type="text" name="tglbeli" id="tglbeli" readonly="readonly"  size="15" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tglbeli;?>"/></td>
    </tr>
	<tr>    
        <td width="150">PI No.</td>
        <td width="5">:</td>
        <td><input type="text" name="pi" id="pi" size="20" value="<?php echo $pi;?>" <?php if(isset($no_edit)) {echo $no_edit; } ?> /></td>
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
	<?php if(!isset($no_edit)) { ?>
   <!-- <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>-->
	<?php } ?>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PREVIEW</button>
    <button type="button" name="saveas" id="saveas" class="easyui-linkbutton" data-options="iconCls:'icon-print'">SAVE AS FILE</button>
    <a href="<?php echo base_url();?>index.php/po_pi/">
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
<div id="dlgEdit" class="easyui-dialog" title="Update PO Detail" style="width:500px;height:235px; padding:5px;"  data-options="modal:true,closed:true">
	<form name="UpdateItemform" id="UpdateItemform">
	<fieldset class="atas">
	<table width="100%">
		<tr>
			<td>Stock</td>
			<td>:</td>
			<td>
				<input type="text" class="easyui-numberbox" name="UpdateStock" id="UpdateStock" size="20" />
				<input type="text" name="UpdatePO" id="UpdatePO" hidden="true" size="20" />
				<input type="text" name="UpdateKodeBarang" id="UpdateKodeBarang" hidden="true" size="20" />
			</td>
		</tr>
		<tr>
			<td>Qty Order</td>
			<td>:</td>
			<td>
				<input type="text" class="easyui-numberbox" name="UpdateQtyOrder" id="UpdateQtyOrder" size="20" />
			</td>
		</tr>
		<!--
		<tr>
			<td>Date In</td>
			<td>:</td>
			<td><input type="text" class="easyui-datebox" name="UpdateDateIn" id="UpdateDateIn" size="20" /></td>
		</tr>
		<tr>
			<td>Qty In</td>
			<td>:</td>
			<td><input type="text" class="easyui-numberbox" name="UpdateQtyIn" id="UpdateQtyIn" size="20" /></td>
		</tr>
		<tr>
			<td>Remarks</td>
			<td>:</td>
			<td><input type="text" name="UpdateRemarks" id="UpdateRemarks" size="55" /></td>
		</tr>-->
	</table>
	</fieldset>
	<fieldset class="bawah">
	<table width="100%">
		<tr>
			<td colspan="3" align="center">
				<button type="button" name="save_update" id="save_update" class="easyui-linkbutton" data-options="iconCls:'icon-save'">UPDATE</button>
				<button type="button" name="cancel_update" id="cancel_update" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CANCEL</button>
			</td>
		</tr>
	</table>
	</fieldset>
	</form>
</div>