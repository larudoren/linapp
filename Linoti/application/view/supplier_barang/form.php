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
		var kode = $("#kode_barang").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/supplier_barang/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#kode").focus();
	$("#tgl_harga").datepicker({
			dateFormat:"yy-mm-dd"
    });
		
	$("#kode").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
		CariDataSupplier();
	});
	
	$("#tgl").datepicker({
			dateFormat:"dd-mm-yy"
    });
	
	if ($("#status").val()=='2'){
		$("#kode").attr("readonly","true");
	}
	else {
		$("#kode").removeAttr("readonly");
	}
	
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
		
		var supplier_code			= $("#kode_supplier").combogrid('getValue');
		var tgl_harga				= $("#tgl_harga").val();
		var currency				= $("#currency").val();
		var harga_barang				= $("#harga_barang").numberbox('getValue');
		var min_qty				= $("#min_qty").numberbox('getValue');
		var remarks				= $("#remarks").val();
		
		var string = $("#form").serialize();
		
		if(supplier_code.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Supplier cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#kode_supplier").focus();
			return false();
		}
		
		if(tgl_harga.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Date cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#tgl_harga").focus();
			return false();
		}
		
		if(harga_barang.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Price cannot be empty', 
				timeout:2000,
				showType:'show'
			});
			$("#harga_barang").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/supplier_barang/simpan",
			data	: string+'&kode_supplier='+supplier_code+'&harga_barang='+harga_barang+'&min_qty='+min_qty,
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
<fieldset class="atas">
<table id="dataTable" width="100%">
<tr>    
<?php
		if ($foto_barang==''){
			$photo = base_url('asset/foto_produk/unknown.jpg');
		} else {
			$photo = base_url('asset/foto_produk/'.$foto_barang);
		}
	?>
	<td width="110" rowspan="2" align="center"><div style="width: 100px; height: 100px; border: no; overflow: hidden; position: relative;">
    <img src="<?=$photo?>" style="position: absolute;" onload="OnImageLoad(event);"/>
</div></td>
	<th height="20">Code</th>
	<th>Name</th>
	<th>Size</th>
	<th>Finishing</th>
</tr>
<tr>    
	<td align="center"><?=$kode_barang_spc?></td>
	<td><?=$nama_barang?></td>
	<td><?=$size?></td>
	<td><?=$finishing?></td>
</tr>
<script>
	function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

    var result = { width: 0, height: 0, fScaleToTargetWidth: true };

    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }

    // scale to the target width
    var scaleX1 = targetwidth;
    var scaleY1 = (srcheight * targetwidth) / srcwidth;

    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight;
    var scaleY2 = targetheight;

    // now figure out which one we should use
		/*
    var fScaleOnWidth = (scaleX2 > targetwidth);
		
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
       fScaleOnWidth = !fLetterBox;
    }
		*/
		
		if (scaleX2 > targetwidth) {
        fScaleOnWidth = true;
    }
    else {
       fScaleOnWidth = false;
    }

    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    }
    else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);

    return result;
	}
	
	function OnImageLoad(evt) {

    var img = evt.currentTarget;

    // what's the size of this image and it's parent
    var w = $(img).width();
    var h = $(img).height();
    var tw = $(img).parent().width();
    var th = $(img).parent().height();
		
    // compute the new size and offsets
    var result = ScaleImage(w, h, tw, th, false);
		//alert(result.width+' '+result.height+' '+result.targetleft+' '+result.targettop);
    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
	}
</script>
</table>
</td>
</tr>
</table>     
</fieldset>
<fieldset class="atas">
<table width="100%">

<tr>

<td width="30%">
<div>

<table width="100%">
	<form id="form" name="form">
	<tr>
		<!--<td>Code</td>
		<td>:</td>
		<td><input type="text" id="kode_barang" name="kode_barang" class="easyui-validatebox" data-options="require:true" readonly="readonly" value="<?=$kode_barang?>"/></td>
		<td></td>-->
		
		<td>Supplier</td>
		<td>:</td>
		<td>
			<input type="text" id="kode_barang" name="kode_barang" hidden="true" class="easyui-validatebox" data-options="require:true" readonly="readonly" value="<?=$kode_barang?>"/>
			<!--<input type="text" id="kode_supplier" size="" name="kode_supplier" class="easyui-validatebox"/>-->
			<select name="kode_supplier" id="kode_supplier"  style="width:200px" class="easyui-combogrid" data-options="
								panelWidth: 550,
								panelHeight: 400,
								idField: 'supplier_code',
								textField: 'supplier_name',
								url: '<?php echo site_url(); ?>/ref_json/ComboboxAllSupplier',
								method: 'post',
								mode:'remote',
								columns: [[
									{field:'supplier_code',title:'Kode Supplier',width:80, hidden:true},
									{field:'supplier_name',title:'Supplier',width:300},
									{field:'supplier_address',title:'Address', align:'left', width:300},
									{field:'supplier_country',title:'Country', align:'left', width:150}
								]],
								fitColumns: true,
								filter: function(q, row){
									var opts = $(this).combogrid('options');
									return row[opts.textField].indexOf(q) == 0;
								},
								pagination:true"/>
		</td>
	</tr>
	<tr>
		<td>Date</td>
		<td>:</td>
		<td><input type="text" id="tgl_harga" name="tgl_harga"/></td>
	</tr>
	<tr>
		<td>Min Qty</td>
		<td>:</td>
		<td><input type="text" id="min_qty" name="min_qty" class="easyui-numberbox" style="text-align:right;"/>  <?=$unit_name?></td>
	</tr>
	<tr>
		<td>Price</td>
		<td>:</td>
		<td>
			<select name="currency" id="currency" style="height:25px;" align="center">
				<?php
					foreach($l_curr->result() as $valuta) {
				?>
				<option value="<?=$valuta->currency_code?>"><?=$valuta->currency_name?></option>
				<?php
					}
				?>
			</select>
			<input type="text" id="harga_barang" name="harga_barang" class="easyui-numberbox" style="text-align:right;" data-options="precision:3"/>
		</td>
	</tr>
	<tr>
		<td>Remarks</td>
		<td>:</td>
		<td><input type="text" id="remarks" size="28" name="remarks"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td></td>
		<td></td>
	</tr>
	</form>
	<tr>
		<td></td>
		<td></td>
		<td>
			<button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
			<a href="<?php echo base_url();?>index.php/supplier_barang/index/">
				<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
			</a>
		</td>
	<tr>
	</tr>
</table>

<div>
</td>
<td valign="top">

<div id="tampil_data"></div>

</td>

</tr>

</table>
</fieldset>

<div id="dlg" class="easyui-dialog" title="Supplier Contact" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Search : <input type="text" name="txt_cari" id="txt_cari" size="50" />
	<div id="kontak_supplier"></div>
</div>