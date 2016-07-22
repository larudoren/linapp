<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	function tampil_data(){
		var kode = $("#kode_terima").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/penerimaan_barang/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
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
	
	$('#cancel_update').click(function (){
		$('#dlgEdit').dialog('close');
		return false();
	});
	
	$('#save_update').click(function (){
		var qty_order = $("#UpdateQtyOrder").numberbox('getValue');
		var qty_before = $("#UpdateQtyBefore").numberbox('getValue');
		var qty_receive = $("#UpdateQtyReceive").numberbox('getValue');
		var jml = Number(qty_before)+Number(qty_receive); 
		var string = $("#UpdateItemform").serialize();
		
		if (jml>qty_order){
			$.messager.show({
				title:'Info',
				msg:'Total of Quantity Received over Quantity Order', 
				timeout:2000,
				showType:'slide'
			});
		} else {
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/penerimaan_barang/update_item",
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
		}
		return false();	
		
	});
	
	$("#simpan").click(function(){
		var kode	= $("#kode_terima").val();
		var tgl		= $("#tgl").val();
		var jml	= $("#jml").val();
		var remarks		= $("#remarks").val();
		
		var string = $("#form").serialize();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/penerimaan_barang/simpan",
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
				
				$('#kode_terima').val(datas[1]);
				if (datas[0].indexOf('Failed') !=-1){
					$('#po').attr('readonly',false);
				} else {
					$('#po').attr('readonly','true');
				}
				tampil_data();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server not response :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		
		return false();		
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kode_terima").val();
		window.open('<?php echo site_url();?>/penerimaan_barang/cetak/'+kode);
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
		<!--
    <tr>    
        <td width="150">No. BPB</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_terima" id="kode_terima" size="16" maxlength="16" readonly="readonly" value="<?php echo $kode_terima;?>" /></td>
    </tr>-->
    <tr>    
			<td>Receive Date</td>
			<td>:</td>
			<td>
				<input type="text" name="kode_terima" id="kode_terima" size="16" maxlength="16" hidden="true" value="<?php echo $kode_terima;?>" />
				<input type="text" name="tgl" id="tgl"  size="15" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tgl_terima;?>"/>
			</td>
    </tr>
		<tr>    
			<td width="150">PO No.</td>
			<td width="5">:</td>
			<td><input type="text" name="po" id="po" size="20" value="<?php echo $po;?>" <?php if(isset($no_edit)) {?> readonly="readonly" <?php } ?> /></td>
    </tr>
		<tr>
			<td>Remarks</td>
			<td>:</td>
			<td><input type="text" name="remarks" id="remarks" size="40" value="<?php echo $remarks; ?>" /></td>
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
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PREVIEW</button>
    <a href="<?php echo base_url();?>index.php/penerimaan_barang/">
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

<div id="dlgEdit" class="easyui-dialog" title="Update Penerimaan Detail" style="width:500px;height:235px; padding:5px;"  data-options="modal:true,closed:true">
	<form name="UpdateItemform" id="UpdateItemform">
	<fieldset class="atas">
	<table width="100%">
		<tr>
			<td>Qty Receive</td>
			<td>:</td>
			<td>
				<input type="text" class="easyui-numberbox" name="UpdateQtyReceive" id="UpdateQtyReceive" size="20" />
				<input type="text" name="UpdateKodeTerima" id="UpdateKodeTerima" hidden="true" size="20" />
				<input type="text" name="UpdateKodeBarang" id="UpdateKodeBarang" hidden="true" size="20" />
				<input type="text" class="easyui-numberbox" name="UpdateQtyOrder" id="UpdateQtyOrder" hidden="true" size="20" />
				<input type="text" class="easyui-numberbox" name="UpdateQtyBefore" id="UpdateQtyBefore" hidden="true" size="20" />
			</td>
		</tr>
		<tr>
			<td>Remarks</td>
			<td>:</td>
			<td><input type="text" name="UpdateRemarks" id="UpdateRemarks" size="55" /></td>
		</tr>
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