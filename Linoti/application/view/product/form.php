<?php
	if(isset($data)) {
		$collection = $data->row();
		$coll_code = $collection->coll_code;
		$coll_name = $collection->coll_name;
	}
?>
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
	
	$("#cetak").click(function(){
		var product_code	= $("#kode").val();
		var coll_code			= $("#coll_code").val();
		window.open('<?php echo site_url();?>/product/cetak/'+product_code+'/'+coll_code);
		return false();
	});
	
	$(function() {
		$("#foto_brg").change(function() {
			var file = this.files[0];
			var fileName = $(this).val();
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg","image/bmp"];
			
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
				$('#show_img').attr('src','noimage.png');
				return false;
			}
			else
			{
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
				//$('#foto_brg').attr('value',fileName);
			}
		});
		
	});
	
	function imageIsLoaded(e) {
		$('#show_img').attr('src', e.target.result);
	};
	
	$("#simpan").click(function(){
		var data 		= new FormData($('#form')[0]);
		var kode		= $("#kode").val();
		var nama_val	= $("#nama_val").val();
		
		//var string = $("#form").serialize();
		
		data.append("kode",  $("#kode").val());
		data.append("product_photo",  $("#foto_brg").val());
		data.append("nama_val",  $("#nama_val").val());
		
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
		if(nama_val.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Product cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_val").focus();
			return false();
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/product/simpan",
			data	: data,
			cache	: false,
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				//CariSimpanan();
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
<style>
.target-ratio-resize {
	max-width: 400px; /* max img width */
	max-height: 600px; /* max img height */
}

</style>
<?php 
	$myfont=5;
?>
<form name="form" id="form">
<fieldset class="atas">
	<table width="100%" border="0">
		<tr>    
			<td width="18%" colspan="2"><font size="<?=$myfont?>">Code</font></td>
			<td width="1%" align="center"><font size="<?=$myfont?>">:</font></td>
			<td width="36%">
				<input type="hidden" name="coll_code" id="coll_code" value="<?=$coll_code?>" />
				<input type="hidden" name="type_product_id" id="type_product_id" value="<?=$type_product_id?>" />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="kode" id="kode" size="40" maxlength="8" <?php if ($kode!=''){ ?> readonly="readonly" <?php } ?> class="easyui-validatebox" data-options="required:true" style="height:25px;font-size:15px;font-weight:bold;" value="<?php echo $kode;?>" />
			</td>
<?php
	if ($product_photo=="")
		$foto = base_url('asset/product_photo/unknown.jpg');
	else
		$foto = base_url('asset/product_photo/'.$product_photo);
?>
			<td rowspan="16" width="45%" align="center" valign="top">
				<div>
					<table>
						<tr>
							<td>
								<div style="width: 400px; height: 300px; border: no; overflow: hidden; position: relative;"><img class="target-ratio-resize" id="show_img" src="<?php echo $foto; ?>" style="position: absolute;" onload="OnImageLoad(event);" /><br/></div><input type="file" name="foto_brg" id="foto_brg" value="<?php echo $product_photo;?>" size="20"/>
							</td>
						</tr>
					</table>
				</div>
			</td>
			<!--<td width="50"></td>-->
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
		<tr>    
			<td colspan="2"><font size="<?=$myfont?>">Collection</font></td>
			<td align="center"><font size="<?=$myfont?>">:</font></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nama_coll" id="nama_coll" size="40" class="easyui-validatebox" readonly="readonly" data-options="required:true" style="height:25px;font-size:15px;font-weight:bold;" value="<?=strtoupper($coll_name)?>"/></td>
		</tr>
		<tr>    
			<td colspan="2"><font size="<?=$myfont?>">Name</font></td>
			<td align="center"><font size="<?=$myfont?>">:</font></td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="nama_val" id="nama_val" size="40" class="easyui-validatebox" data-options="required:true" style="height:25px;font-size:15px;font-weight:bold;" value="<?=$nama_val?>"/></td>
		</tr>
		<tr>    
			<td colspan="2"><font size="<?=$myfont?>">Category</font></td>
			<td align="center"><font size="<?=$myfont?>">:</font></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="category" id="category" size="40" class="easyui-validatebox" style="height:25px;font-size:15px;font-weight:bold;" value="<?=$category?>"/></td>
		</tr>
		<tr>    
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td colspan="2"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td colspan="2"><u><font size="4">Product Sizes</font></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td width="4%">&nbsp;</td>
			<td width="14%">Overall</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;<input type="text" name="cm_length" id="cm_length" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_length',newValue);}}" align="right" value="<?=$cm_length?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;<input type="text" name="cm_width" id="cm_width" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_width',newValue);}}" align="right" value="<?=$cm_width?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H&nbsp;&nbsp;<input type="text" name="cm_height" id="cm_height" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_height',newValue);}}" align="right" value="<?=$cm_height?>"/>&nbsp;&nbsp;&nbsp;cm</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;L&nbsp;&nbsp;<input type="text" name="inch_length" id="inch_length" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,required:true" readonly="readonly" align="right" value="<?=$inch_length?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;W&nbsp;&nbsp;<input type="text" name="inch_width" id="inch_width" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,required:true" readonly="readonly" align="right" value="<?=$inch_width?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H&nbsp;&nbsp;<input type="text" name="inch_height" id="inch_height" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,required:true" readonly="readonly" align="right" value="<?=$inch_height?>"/>&nbsp;&nbsp;&nbsp;in</td>
		</tr> <!--
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr> -->
		<tr>    
			<td>&nbsp;</td>
			<td>Net Weight</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="weight_kg" id="weight_kg" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('weight_kg',newValue);}}" align="right" value="<?=$weight_kg?>"/>&nbsp;&nbsp;&nbsp;kg</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="weight_lbs" id="weight_lbs" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,required:true" readonly="readonly" align="right" value="<?=$weight_lbs?>"/>&nbsp;&nbsp;&nbsp;lbs</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">Extension</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ext_qty" id="ext_qty" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,onChange:function(newValue,oldValue){if (newValue!=oldValue){$('#ext_qty2').numberbox('setValue',newValue)}}" align="right" value="<?=$ext_qty?>"/>&nbsp;&nbsp;&nbsp;pcs&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;<input type="text" name="ext_length" id="ext_length" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('ext_length',newValue);}}" value="<?=$ext_length?>"/>&nbsp;&nbsp;&nbsp;cm</td>
			<!--
			<td rowspan="4" valign="top">
				<table border="0" >
					<tr>
						<td width="200">&nbsp;&nbsp;&nbsp;&nbsp;Clearance</td>
						<td width="20" align="right">:</td>
						<td width="150" align="right"><input type="text" name="cm_clear" id="cm_clear" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_clear',newValue);}}" value="<?=$qty_20?>"/>&nbsp;&nbsp;&nbsp;cm</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right"><input type="text" name="inch_clear" id="inch_clear" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$qty_40?>"/>&nbsp;&nbsp;&nbsp;"&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
				</table>
			</td> -->
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="ext_qty2" id="ext_qty2" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0" readonly="readonly" value="<?=$ext_qty2?>"/>&nbsp;&nbsp;&nbsp;pcs&nbsp;&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;<input type="text" name="ext_length2" id="ext_length2" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$ext_length2?>"/>&nbsp;&nbsp;&nbsp;in</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">1 Seat</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;W &nbsp;<input type="text" name="cm_seat_w" id="cm_seat_w" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_seat_w',newValue);}}" value="<?=$cm_seat_w?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;&nbsp;<input type="text" name="cm_seat_d" id="cm_seat_d" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_seat_d',newValue);}}" value="<?=$cm_seat_d?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H&nbsp;&nbsp;<input type="text" name="cm_seat_h" id="cm_seat_h" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_seat_h',newValue);}}" value="<?=$cm_seat_h?>"/>&nbsp;&nbsp;&nbsp;cm</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;W &nbsp;<input type="text" name="inch_seat_w" id="inch_seat_w" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$inch_seat_w?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;&nbsp;<input type="text" name="inch_seat_d" id="inch_seat_d" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$inch_seat_d?>"/>&nbsp;&nbsp;x&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H&nbsp;&nbsp;<input type="text" name="inch_seat_h" id="inch_seat_h" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$inch_seat_h?>"/>&nbsp;&nbsp;&nbsp;in</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">Clearance</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="cm_clear" id="cm_clear" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_clear',newValue);}}" value="<?=$cm_clear?>"/>&nbsp;&nbsp;&nbsp;cm</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="inch_clear" id="inch_clear" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$inch_clear?>"/>&nbsp;&nbsp;&nbsp;in</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">Armrest Height</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="cm_arm" id="cm_arm" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('cm_arm',newValue);}}" value="<?=$cm_arm?>"/>&nbsp;&nbsp;&nbsp;cm</td>
		</tr>
		<tr>    
			<td width="50">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td align="center">&nbsp;</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="inch_arm" id="inch_arm" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" readonly="readonly" value="<?=$inch_arm?>"/>&nbsp;&nbsp;&nbsp;in</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td colspan="2"><u><font size="4">Packing</font></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>Qty</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="qty_packing" id="qty_packing" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:1,required:true" value="<?=$qty_packing?>"/>&nbsp;&nbsp;&nbsp;boxes</td>
			<td rowspan="4" valign="top">
				<table border="0" width="100%">
					<tr>
						<td>Packing Volume outter</td>
						<td></td>
						<td align="right">:</td>
						<td colspan="2">&nbsp; <input type="text" name="vol_m3" id="vol_m3" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:3,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('vol_m3',newValue);}}" value="<?=$vol_m3?>"/>&nbsp;&nbsp;&nbsp;m3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="vol_cuft" id="vol_cuft" size="5" class="easyui-numberbox" style="text-align:right" readonly="readonly" data-options="min:0,precision:2,required:true" value="<?=$vol_cuft?>"/>&nbsp;&nbsp;&nbsp;cu ft</td>
						
					</tr>
					<tr>
						<td width="35%">Qty Inside container</td>
						<td width="10%">20 '</td>
						<td width="2%" align="right">:</td>
						<td width="28%">&nbsp; <input type="text" name="qty_20" id="qty_20" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0" value="<?=$qty_20?>"/>&nbsp;&nbsp;&nbsp;pcs</td>
						<td width="25%"></td>
					</tr>
					<tr>
						<td align="right"></td>
						<td>40 '</td>
						<td align="right">:</td>
						<td>&nbsp; <input type="text" name="qty_40" id="qty_40" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0" value="<?=$qty_40?>"/>&nbsp;&nbsp;&nbsp;pcs</td>
					</tr>
					<tr>
						<td align="right"></td>
						<td>40 ' HC</td>
						<td align="right">:</td>
						<td>&nbsp; <input type="text" name="qty_40hc" id="qty_40hc" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0" value="<?=$qty_40hc?>"/>&nbsp;&nbsp;&nbsp;pcs</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>Qty product per box</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="qty_perbox" id="qty_perbox" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:1,required:true" value="<?=$qty_perbox?>"/>&nbsp;&nbsp;&nbsp;</td>
			
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>Knock Down</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="knock_down" value="1" <?php if ($knock_down==1){ ?> checked <?php } ?> /></td>
			
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>Gross Weight</td>
			<td align="center">:</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="gross_kg" id="gross_kg" size="5" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:1,required:true,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('gross_kg',newValue);}}" value="<?=$gross_kg?>"/>&nbsp;&nbsp;&nbsp;kg&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="gross_lbs" id="gross_lbs" size="5" class="easyui-numberbox" style="text-align:right" readonly="readonly" data-options="min:0,precision:2,required:true" value="<?=$gross_lbs?>"/>&nbsp;&nbsp;&nbsp;lbs</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td colspan="2"><u><font size="4">Product Details</font></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td colspan="4" rowspan="4" valign="top"><textarea name="prod_detail" rows="5" style="border:1;width:91%;height:100%;resize:none"><?php echo $prod_detail; ?></textarea></td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
		
		</tr>
		<tr>    
			<td>&nbsp;</td>
			
		</tr>
		<tr>    
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td colspan="2"><u><font size="4">Remarks from user</font></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
			<td colspan="4" rowspan="4" valign="top"><textarea name="remarks" rows="5" style="border:1;width:91%;height:100%;resize:none"><?php echo $remarks; ?></textarea></td>
		</tr>
		<tr>    
			<td>&nbsp;</td>
		
		</tr>
		<tr>    
			<td>&nbsp;</td>
			
		</tr>
		<tr>    
			<td>&nbsp;</td>
		</tr>
	</table>
</fieldset>
<fieldset class="bawah">
	<table width="100%">
		<tr>
			<td colspan="3" align="center">
				<button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
				<?php if ($code_cari=='PR' && $coll_cari!='PR' && $type_cari!='PR' && $category_cari!='PR') {?>
				<a href="<?php echo base_url();?>index.php/product/tambah/<?=$code_cari?>/<?=$coll_cari?>/<?=$type_cari?>/<?=$category_cari?>/<?=$hal?>">
					<button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
				</a>
				<?php } ?>
				<button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PREVIEW</button>
				<a href="<?php echo base_url();?>index.php/product/name/<?=$code_cari?>/<?=$coll_cari?>/<?=$type_cari?>/<?=$category_cari?>/<?=$hal?>">
					<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CLOSE</button>
				</a>
			</td>
		</tr>
	</table>  
</fieldset>   
</form>
<script>
	function onChangeFunction(sizetype,sizenumber){
		var whole = 0;
		var convert = 0;
		//var cwhole = 0;
		var fraction = 0.0;
		var frac_to_str='';
		var sub_frac='';
		var cfraction = 0.0;
		var temp =0.0;
		if (sizetype.indexOf('cm')!=-1 || sizetype.indexOf('ext_length')!=-1){
			
			convert = sizenumber / 2.54;
			whole = Math.floor(convert);
			fraction = convert - whole;
			//frac_to_str = ''+fraction;
			//sub_frac = frac_to_str.substr(0,5);
			if (fraction >= 0.125 && fraction <= 0.374){
				cfraction = 0.25;
			} else if (fraction >= 0.375 && fraction <= 0.624){
				cfraction = 0.5;
			} else if (fraction >= 0.625 && fraction <= 0.874){
				cfraction = 0.75;
			} else if (fraction >= 0.875){
				cfraction = 1.0;
			}
			temp = whole+cfraction;
			if (sizetype.indexOf('ext_length')!=-1) {
				$('#ext_length2').numberbox('setValue',temp);
			} else if (sizetype.indexOf('seat_w')!=-1){
				$('#inch_seat_w').numberbox('setValue',temp);
			} else if (sizetype.indexOf('seat_d')!=-1){
				$('#inch_seat_d').numberbox('setValue',temp);
			} else if (sizetype.indexOf('seat_h')!=-1){
				$('#inch_seat_h').numberbox('setValue',temp);
			} else if (sizetype.indexOf('clear')!=-1){
				$('#inch_clear').numberbox('setValue',temp);
			} else if (sizetype.indexOf('arm')!=-1){
				$('#inch_arm').numberbox('setValue',temp);
			} else if (sizetype.indexOf('length')!=-1){
				$('#inch_length').numberbox('setValue',temp);
			} else if (sizetype.indexOf('width')!=-1){
				$('#inch_width').numberbox('setValue',temp);
			} else if (sizetype.indexOf('height')!=-1){
				$('#inch_height').numberbox('setValue',temp);
			}
		} else if (sizetype.indexOf('weight')!=-1 || sizetype.indexOf('gross')!=-1){
			convert = sizenumber * 2.204;
			whole = Math.floor(convert);
			fraction = convert - whole;
			
			if (fraction >= 0.125 && fraction <= 0.374){
				cfraction = 0.25;
			} else if (fraction >= 0.375 && fraction <= 0.624){
				cfraction = 0.5;
			} else if (fraction >= 0.625 && fraction <= 0.874){
				cfraction = 0.75;
			} else if (fraction >= 0.875){
				cfraction = 1.0;
			}
			temp = whole+cfraction;
			
			if (sizetype.indexOf('weight')!=-1){
				$('#weight_lbs').numberbox('setValue',temp);
			} else {
				$('#gross_lbs').numberbox('setValue',temp);
			}
		} else if (sizetype.indexOf('vol')!=-1){
			convert = sizenumber * 35.31;
			whole = Math.floor(convert);
			fraction = convert - whole;
			
			if (fraction >= 0.125 && fraction <= 0.374){
				cfraction = 0.25;
			} else if (fraction >= 0.375 && fraction <= 0.624){
				cfraction = 0.5;
			} else if (fraction >= 0.625 && fraction <= 0.874){
				cfraction = 0.75;
			} else if (fraction >= 0.875){
				cfraction = 1.0;
			}
			temp = whole+cfraction;
			$('#vol_cuft').numberbox('setValue',temp);
		}
		
		//return temp; 
	}
</script>