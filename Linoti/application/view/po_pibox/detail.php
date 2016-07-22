<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
	
	$("#datein").datepicker({
			dateFormat:"dd-mm-yy"
    });
});

$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	/* Every change for the header checkbox (checked or unchecked)*/
	$("#chkall").on("change", checkallFunction);
	
	$('#check_idbeli').val('');
	
	/* # Get all the id of this PO details which parsing from controller*/
	var allbeli = "<?php echo $all_idbeli; ?>"; 
	
	/* # convert all the id of this PO details into an array */
	var allbeli_array = JSON.parse("[" + allbeli + "]");
	
	
	function checkallFunction() {
		var allcheck='';
		if ($("#chkall").is(':checked')){
			for (i=0;i<allbeli_array.length;i++){
				$("#chk_"+allbeli_array[i]).prop('checked',true);
				allcheck = allcheck+allbeli_array[i]+'-';
			}
			$('#check_idbeli').val('-'+allcheck+'-');
		}else{
			for (i=0;i<allbeli_array.length;i++){
				$("#chk_"+allbeli_array[i]).prop('checked',false);
			}
			$('#check_idbeli').val('');
		}
        
    }
	
	/* Every single item that checked or unchecked the checkbox to collect all the item that will be proccess*/
	for (i=0;i<allbeli_array.length;i++){
		
		$('#chk_'+allbeli_array[i]).on("change",function(){
			var check_idbeli = $('#check_idbeli').val();
			
			var idbeli = $(this).val().replace('check_','');
			if($(this).is(':checked')){
				if (check_idbeli.indexOf('-'+idbeli+'-') == -1 && check_idbeli == ''){
					$('#check_idbeli').val('-'+check_idbeli+idbeli+'-');
				} else if (check_idbeli.indexOf('-'+idbeli+'-') == -1 && check_idbeli != ''){
					$('#check_idbeli').val(check_idbeli+idbeli+'-');
				}
			}else {
				if (check_idbeli.indexOf('-'+idbeli+'-') != -1 && check_idbeli == '-'+idbeli+'-'){
					$('#check_idbeli').val('');
				}else {
					check_idbeli = check_idbeli.replace('-'+idbeli,'');
					$('#check_idbeli').val(check_idbeli);
				}
			}
			
		});
	}
});

function funct_editd(idbeli,product_code,boxnumber,packingremarks,boxremarks,po,qtybox){
	$("#idbeli").val(idbeli);
	$("#packingremarks").val(packingremarks);
	$("#boxremarks").val(boxremarks);
	$("#updatepo").val(po);
	$('#updateqty').numberbox('setValue',qtybox);
	
	$("#dlgEditd").dialog({
		title: 'Update Remarks - '+product_code+' - '+boxnumber
	});
	$("#dlgEditd").dialog('open');
}

</script>
<style type="text/css">
.stripe1 {
    background-color:#FBEC88;
}
.stripe2 {
    background-color:#FFF;
}
.highlight {
	-moz-box-shadow: 1px 1px 2px #fff inset;
	-webkit-box-shadow: 1px 1px 2px #fff inset;
	box-shadow: 1px 1px 2px #fff inset;		  
	border:             #aaa solid 1px;
	background-color: #fece2f;
}
</style>

<table id="dataTable" width="100%">
<tr>
	<th><input type="checkbox" id="chkall" name="chkall" value="chkall"></input></th>
	<th>Code</th>
	<th>Image</th>
	<th>Collection</th>
	<th>Description</th>
	<th>Box</th>
	<th>Knock<br>Down?</th>
	<th>Packing Remarks</th>
	<th>Type</th>
	<th colspan="3">Inner Size (mm)</th>
	<th colspan="3">Outer Size (mm)</th>
	<th>Vol. Outer</th>
	<th>Qty<br>Box</th>
	<th>Unit Price</th>
	<th>Total</th>
	<th>Remarks</th>
	<th>Action</th>
</tr>

<?php
	if($data->num_rows()>0){
		$ttldl = 0;
		$ttlrp = 0;
		$no =1;
		foreach($data->result_array() as $db){
			$total = $db['qtybox']*$db['hrgbox'];
			if($db['product_photo']=="") {
				$foto = base_url('asset/product_photo/unknown.jpg');
			} else {
				$foto = base_url('asset/product_photo/'.$db['product_photo']);
			}
		?>    
    	<tr class="edit_tr">
			<td align="center" width="10"><input type="checkbox" id="chk_<?=$db['idbeli']?>"  name="chk_<?=$db['idbeli']?>" value="check_<?=$db['idbeli']?>"></input></td>
			<td align="center" width="10"><?php echo $db['product_code']; ?></td>
      <td align="center"  width="100"><!--<img src="<?=$foto?>" width="60px" />--><div style="width: 60px; height: 60px; border: no; overflow: hidden; position: relative;">
    <img src="<?=$foto?>" style="position: absolute;" onload="OnImageLoad(event);"/>
</div></td>
			
			<td><?php echo $db['coll_name']; ?></td>
			<td><?php echo $db['product_name']; ?></td>
			<td align="center"><?php echo $db['boxnumber']; ?></td>
			<td align="center"><?php echo $db['kdown']; ?></td>
			<td><?php echo $db['remarks_packing']; ?></td>
			<td align="center"><?php echo $db['typebox']; ?></td>
			<td align="center"><?php echo number_format($db['linner'],0,'.',''); ?></td>
			<td align="center"><?php echo number_format($db['winner'],0,'.',''); ?></td>
			<td align="center"><?php echo number_format($db['hinner'],0,'.',''); ?></td>
			<td align="center"><?php echo number_format($db['louter'],0,'.',''); ?></td>
			<td align="center"><?php echo number_format($db['wouter'],0,'.',''); ?></td>
			<td align="center"><?php echo number_format($db['houter'],0,'.',''); ?></td>
			<td align="center"><?php echo $db['volouter']; ?></td>
			<td align="center"><?php echo $db['qtybox']; ?></td>
			<td align="center"><?php echo $db['currency_name'].' '.number_format($db['hrgbox'],0,'.',','); ?></td>
			<td align="center"><?php echo $db['currency_name'].' '.number_format($total,0,'.',','); ?></td>
			<td><?php echo $db['remarks']; ?></td>
			<td align="center">
					<a href="javascript:void(0);" onClick="funct_editd('<?=$db['idbeli']?>','<?=$db['product_code']?>','<?=$db['boxnumber']?>','<?=$db['remarks_packing']?>','<?=$db['remarks']?>','<?=$db['po']?>','<?=$db['qtybox']?>')">
						<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
					</a>
			</td>
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

    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
	}
</script>
			<?php 
			
			if($db['currency_name']=='Rp') {
					$ttlrp = $ttlrp+$total;
				}
				else {
					$ttldl = $ttldl+$total;
			}
		} 
	}else{
		$ttlrp=0;
		$ttldl=0;
	?>
    	<tr>
        	<td colspan="12" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
<tr>
	<td colspan="18" align="right"><b>Total</b></td>
    <td align="right"><b><?php echo 'Rp. '.number_format($ttlrp, 0,',','.');?></b></td>
</tr>  
<tr>
	<td colspan="18" align="right"><b>Total</b></td>
<?php
	if ($ttldl > 0) {
		$whole = 0;
		$fraction = 0.0;
		$whole = floor($ttldl);
		$fraction = $ttldl - $whole;
		$fraction_str = ''.number_format($ttldl, 3,',','.');
		
		if ($fraction > 0){
			if(substr($fraction_str,-1)!='0'){
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 3,',','.');?></b></td>
<?php
			} elseif(substr($fraction_str,-2,1)!='0'){
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 2,',','.');?></b></td>
<?php
			} else {
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 1,',','.');?></b></td>
<?php
			}
		}
	} else {
?>
  <td align="right"><b><?php echo '$ '.number_format($ttldl, 0,',','.');?></b></td>
<?php
	}
?>
</tr> 
</table>