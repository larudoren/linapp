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
		var kode = $("#po").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pembelian/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#kode_brg").focus(function(e){
		var isi = $(e.target).val();
		CariBarang();
	});
	$("#kode_brg").focus();
	$("#kode_brg").keyup(function(){
		CariBarang();
	});
	
	function CariBarang(){
		var kode = $("#kode_brg").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoBarang",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_brg").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#departemen").val(data.departemen);
			}
		});
	};
	
	function hitung(){
		var jml = $("#jml").val();
		var harga = $("#harga").val();
		//alert(jml+','+harga);
		var total = parseFloat(jml)*parseFloat(harga);
		$("#total").val(parseFloat(total).toFixed(3));
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga").keyup(function(){
		hitung();
	});
	
	$("#simpan").click(function(){
		var tgl		= $("#tgl").val();
		var supplier		= $("#supplier").val();
		var harga		= $("#harga").val();
		
		var kode_brg	= $("#kode_brg").combogrid('getValue');
		var tjml	= $("#jml").val();
		var jml = ''+tjml;
		var po	= $("#po").val();
		var remarks		= $("#remarks").val();
		var total = $("#total").numberbox('getValue');
		
		var string = $("#form").serialize();
		//alert(jml);
		/*
		if (po.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PO cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#po").focus();
			return false();
		} */
		if(tgl.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Date cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#tgl").focus();
			return false();
		}
		
		if(kode_brg.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Code cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode_brg").focus();
			return false();
		}
		if(harga.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Price cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#harga").focus();
			return false();
		}
		if(jml.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Quantity cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false();
		}
		/*
		if(total<=0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Quantity cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false();
		} */
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pembelian/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
			  var result = data.split(",");
				$.messager.show({
					title:'Info',
					msg:result[0], 
					timeout:2000,
					showType:'slide'
				});
				
				if (po.length==0){
					$("#po").val(result[1]);
				}
				tampil_data();
				$('#kode_brg').combogrid('setValue','');
				$(".detail").val('');
				$('#jml').val('');
				$('#harga').val('');
				$('#total').val('');
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
	
	$("#tambah_data").click(function(){
		$(".detail").val('');
		$("#kode_brg").val('');
		$("#jml").numberbox('setValue','');
		$("#harga").numberbox('setValue','');
		$("#total").numberbox('setValue','');
		$("#kode_brg").focus();
	});
	
	$("#cetak").click(function(){
		var kode	= $("#po").val();
		window.open('<?php echo site_url();?>/pembelian/cetak/'+kode+'/-');
		return false();
	});
	
	$("#saveas").click(function(){
		var kode	= $("#po").val();
		window.open('<?php echo site_url();?>/pembelian/cetak/'+kode+'/saveas');
		return false();
	});
	
	$("#cari_barang").click(function(){
		AmbilDaftarBarang();
		$("#dlg").dialog('open');
	});
	
	$("#text_cari").keyup(function(){
		AmbilDaftarBarang();
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarBarang(){
		var cari = $("#text_cari").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataBarang",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_barang").html(data);
			}
		});
	}
	
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
        <td><input type="text" name="po" id="po" size="20" value="<?=$po?>" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Date</td>
        <td>:</td>
        <td><input type="text" name="tgl" id="tgl"  size="15" data-options="required:true,validType:'length[3,10]'" value="<?php echo $tgl_beli;?>"/></td>
    </tr>
    <tr>    
        <td>Supplier</td>
        <td>:</td>
        <td>
        <select name="supplier" id="supplier">
        <?php 
		if(empty($supplier)){
		?>
        <option value="">-SELECT-</option>
        <?php
		}
		foreach($l_supp->result() as $t){
			if($supplier==$t->supplier_code){
		?>
        <option value="<?php echo $t->supplier_code;?>" selected="selected"><?php echo $t->supplier_name;?></option>
        <?php }else { ?>
        <option value="<?php echo $t->supplier_code;?>"><?php echo $t->supplier_name;?></option>
        <?php }
		} ?>
        </select>
        </td>
    </tr>
	<tr>    
        <td>Customer</td>
        <td>:</td>
        <td>
        <!--<select name="customer" id="customer" onChange="populateField(this.form)" >-->
        <select name="customer" id="customer" >
        <?php 
		//if(empty($customer)){
		?>
        <option value="">-SELECT-</option>
        <?php
		//}
		foreach($l_cust->result() as $y){
			if($customer==$y->cust_code){
		?>
        <option value="<?=$y->cust_code?>" selected="selected"><?php echo urldecode($y->cust_name);?></option>
        <?php }else { ?>
        <option value="<?=$y->cust_code?>"><?php echo urldecode($y->cust_name);?></option>
        <?php }
		} ?>
        </select>
        </td>
    </tr>
		<tr>
			<td>PI Number</td>
      <td>:</td>
			<td><input type="text" name="pi" id="pi" size="20" value="<?=$pi?>" <?php if(isset($edit)) { ?>readonly="readonly" <?php } ?>/></td>
		</tr>
    </table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%">
    <tr>    
        <td width="150">Item Name</td>
        <td width="5">:</td>
        <td>
						<select name="kode_brg" id="kode_brg"  style="width:200px" class="easyui-combogrid" data-options="
								panelWidth: 550,
								panelHeight: 400,
								idField: 'kode_barang',
								textField: 'nama_barang',
								url: '<?php echo site_url(); ?>/ref_json/ComboboxAllMaterial',
								method: 'post',
								mode:'remote',
								columns: [[
									{field:'kode_barang',title:'Kode Barang',width:80, hidden:true},
									{field:'kode_barang_spc',title:'Code',width:120},
									{field:'nama_barang',title:'Nama Barang',width:300},
									{field:'unit_name',title:'Unit', align:'center', width:100},
									{field:'finishing',title:'Finishing', align:'left', width:150},
									{field:'length',title:'Length', align:'center', width:100, formatter: function(value,row,index){
											if (value==0){
												return '';
											} else {
												return value;
											}
										}},
									{field:'width',title:'Width', align:'center', width:100, formatter: function(value,row,index){
											if (value==0){
												return '';
											} else {
												return value;
											}
										}},
									{field:'height',title:'Height', align:'center', width:100, formatter: function(value,row,index){
											if (value==0){
												return '';
											} else {
												return value;
											}
										}},
									{field:'diameter',title:'Ø Out', align:'center', width:100, formatter: function(value,row,index){
											if (value==0){
												return '';
											} else {
												return value;
											}
										}},
									{field:'diameterin',title:'Ø In', align:'center', width:100, formatter: function(value,row,index){
											if (value==0){
												return '';
											} else {
												return value;
											}
										}}
								]],
								fitColumns: true,
								onSelect: function(index, record){
									$('#satuan').val(record.unit_name);
								},
								filter: function(q, row){
									var opts = $(this).combogrid('options');
									return row[opts.textField].indexOf(q) == 0;
								},
								pagination:true"/>
        
        </td>
    </tr>
		<!--
    <tr>    
        <td>Name</td>
        <td>:</td>
        <td><input type="text" name="nama_brg" id="nama_brg"  size="50" class="detail" maxlength="50" readonly="readonly"/></td>
    </tr> -->
    <tr>    
        <td>Unit</td>
        <td>:</td>
        <td><input type="text" name="satuan" id="satuan"  size="20" class="detail" maxlength="20" readonly="readonly"/></td>
    </tr>
		<!--
		<tr>    
        <td>Stock / Order</td>
        <td>:</td>
        <td><input type="radio" name="status" value="0">Stock <input type="radio" name="status" value="1">Order</td>
    </tr> -->
    <tr>    
        <td>Price</td>
        <td>:</td>
        <td><select name="currency" id="currency">
				<?php
					foreach($l_curr->result() as $valuta) {
				?>
				<option value="<?=$valuta->currency_code?>"><?=$valuta->currency_name?></option>
				<?php
					}
				?>
			</select>
			<input type="text" name="harga" id="harga"  size="20" class="easyui-numberbox" maxlength="20" data-options="precision:3" />
		</td>
    </tr>
    <tr>    
        <td>Quantity</td>
        <td>:</td>
        <td><input type="text" name="jml" id="jml"  size="20" class="easyui-numberbox" maxlength="20"/></td>
    </tr>
    <tr>    
        <td>Total</td>
        <td>:</td>
        <td><input type="text" name="total" id="total" class="easyui-numberbox" size="20" maxlength="20" data-options="disabled:true" readonly="readonly"/></td>
    </tr>
	<tr>    
        <td>Remarks</td>
        <td>:</td>
        <td><input type="text" name="remarks" id="remarks" class="detail" size="50" maxlength="50"/></td>
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
    <button type="button" name="saveas" id="saveas" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE AS FILE</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PRINT</button>
    <a href="<?php echo base_url();?>index.php/pembelian/">
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
<div id="dlg" class="easyui-dialog" title="Daftar Barang" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Search : <input type="text" name="text_cari" id="text_cari" size="50" />
	<div id="daftar_barang"></div>
</div>