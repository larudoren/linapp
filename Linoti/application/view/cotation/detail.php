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
});
	
	$(document).ready(function(){
		$(':input:not([type="submit"])').each(function() {
			$(this).focus(function() {
				$(this).addClass('hilite');
			}).blur(function() {
				$(this).removeClass('hilite');});
		});	
		
		$('id_cotation').val(<?php echo $id_cotation; ?>);
		
		$('#cotation').tabs({
			onSelect: function(title,index){
			  if (title=='Sanding (Amplas)'){
					var tab = $(this).tabs('getSelected');
					var dgWood 		= tab.find('table.tableWoodSandingAmplas');
					var dgVeneer 	= tab.find('table.tableVeneerSandingAmplas');
					var dg 				= tab.find('table.tableSandingAmplas');
					dg.datagrid('reload');
					dgWood.datagrid('reload');
					dgVeneer.datagrid('reload');
				}
			}
		});
		
		
		var height = $(window).height();
		var width = $(window).width();
		var content_height = height - 140;
		
		
		$("#contentCotation").equalHeights(content_height,content_height);
		
		$(window).resize(function(){
        $("#contentCotation").equalHeights(content_height,content_height);
				//$("#cotation").tabs('resize',{});

				$("div.easyui-tabs").each(function() {
					if($(this).is(':visible'))
						//if($(this).attr('id') != 'cotation')
							$(this).tabs('resize',{})
				});
				$('table.easyui-datagrid').datagrid('resize');
		
    }); 
		
		//$('#cotation').tabs('select','Wood');
		
		//tampil_data_uphold();
		//$('#cotation div wood').css('display','none'); 
		/*
		 function closeTab(container='#cotation', title) {
                var opts = $.data(container, 'tabs').options;
                var elem = $('>div.tabs-header li:has(a span:contains("' + title + '"))', container)[0];
                if (!elem) return;
                
                var tabAttr = $.data(elem, 'tabs.tab');
                var panel = $('#' + tabAttr.id);
                
                if (opts.onClose.call(panel, tabAttr.title) == false) return;
                
                var selected = $(elem).hasClass('tabs-selected');
                $.removeData(elem, 'tabs.tab');
                $(elem).remove();
                panel.remove();
                
                setSize(container);
                if (selected) {
                        selectTab(container);
                } else {
                        var wrap = $('>div.tabs-header .tabs-wrap', container);
                        var pos = Math.min(
                                        wrap.scrollLeft(),
                                        getMaxScrollWidth(container)
                        );
                        wrap.animate({scrollLeft:pos}, opts.scrollDuration);
                }
        } */
		<?php 
foreach ($l_cotation->result() as $cot){
	if ($cot->view == 1){
		if ($cot->textchild=='Sanding (Amplas)'){
			$this->load->view('js/sanding_amplas.js');
		} else {
			$this->load->view('js/'.strtolower($cot->textchild).'.js');
		}
	} 
} 
?>
	
	});	
	
	
	
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
	<div id="contentCotation" width="100%">
	<form name="form" id="form">
	<table width="100%">
		<tr>
			<td>
				<div id="gird" style="float:left; width:100%;">
					<table id="dataTable" width="100%">
						<?php
							$overall['cm_length']=0;
							$overall['cm_width']=0;
							$overall['cm_height']=0;
							if($data->num_rows()>0){
								$no =1;
								foreach($data->result_array() as $db){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($db['cm_length']);
									$fraction = $db['cm_length'] - $whole;
									if ($fraction>0){
										$overall['cm_length'] = $db['cm_length'];
									}else{
										$overall['cm_length'] = floor($db['cm_length']);
									}
									
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($db['cm_width']);
									$fraction = $db['cm_width'] - $whole;
									if ($fraction>0){
										$overall['cm_width'] = $db['cm_width'];
									} else {
										$overall['cm_width'] = floor($db['cm_width']);
									}
									
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($db['cm_height']);
									$fraction = $db['cm_height'] - $whole;
									if ($fraction>0){
										$overall['cm_height'] = $db['cm_height'];
									} else {
										$overall['cm_height'] = floor($db['cm_height']);
									}
								?>
									<tr>
										<?php
											if ($db['product_photo']==''){
												$photo = base_url('asset/product_photo/unknown.jpg');
											} else {
												$photo = base_url('asset/product_photo/'.$db['product_photo']);
											}
										?>
										<td rowspan="2" align="center" width="110px"><div style="width: 100px; height: 100px; border: no; overflow: hidden; position: relative;">
    <img src="<?=$photo?>" style="position: absolute;" onload="OnImageLoad(event);"/>
</div><!--<img src="<?=$photo?>" width="60px" height="70px" />--></td>
										<th height="20px" width="150px">Code</th>
										<th width="250px">Collection</th>
										<th>Name</th>
										<th>Finishing</th>
									</tr>
									<tr class="edit_tr">
										<td align="center"><?php echo $db['product_code']; ?></td>
										<td align="center"><?php echo $db['collection']; ?></td>
										<td align="center"><?php echo $db['name']; ?></td>
										<td align="center"><?php echo $db['finishing']; ?></td>
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
								<?php
									$no++;
		
								}
							}else{
							?>
									<tr>
											<td colspan="13" align="center" >Empty Data</td>
										</tr>
								<?php	
							}
						?>
						</table>
				</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<!--<fieldset>-->
				<div id="cotation" class="easyui-tabs" style="width:1050px;">
<?php
$temp['asstype'] = '';
$temp['indoortype'] = '';
foreach($l_assm->result() as $ass){
	$temp['asstype'] = $ass->asstype;
	$temp['indoortype'] = $ass->indoortype;
}
$sand['wood'] = 0;
$sand['panel'] = 0;
foreach($t_wood->result() as $wood){
	if (!empty($wood->total)){
		$sand['wood'] = $wood->total;
	}
}

foreach($t_panel->result() as $panel){
	$sand['panel'] = $panel->total;
}

foreach ($l_cotation->result() as $cot){
	if ($cot->view == 1){
		if ($cot->textchild=='Upholstery'){
?>
					<div title="Upholstery" id="upholstery" style="padding:10px;height:450px;">
						<table id="dgUpholdstery"></table>
						<br />
						<table id="dgUpholdsteryDetail"></table><br />
						
					</div> 
<?php
		} elseif ($cot->textchild=='Sanding (Amplas)') {
?>
					
					<div title="Sanding (Amplas)" id="sanding_amplas" style="padding:10px;height:450px;">
							<table id="panSandingAmplas"><?php $this->load->view('cotation/sanding_amplas',$sand);?></table>
					</div>
<?php
		} else {
			
?>
					<div title="<?php echo $cot->textchild; ?>" id="<?php echo strtolower($cot->textchild); ?>" style="padding:10px;height:450px;">
<?php
			if ($cot->textchild=='Assembling'){
?>
					<table id="<?php echo 'pan'.$cot->textchild; ?>"><?php $this->load->view('cotation/assembling',$temp);?></table>					
<?php
			} elseif($cot->textchild=='Packing'){ 
?>
					<table id="<?php echo 'pan'.$cot->textchild; ?>" width="100%"><?php $this->load->view('cotation/packing',$overall);?></table>					
<?php
			} else{
?>
						<table id="<?php echo 'dg'.$cot->textchild; ?>"></table>
<?php
			}
?>
					</div> <!--
					<div title="Panel" id="panel" style="padding:10px;">
						<table id="dgPanel"></table>
					</div>
					<div title="Accessories" id="accessories" style="padding:10px;">
						<table id="dgAccessories"></table>
					</div> -->
<?php
		}
	}
}
?>
				</div>
				<!--</fieldset>-->
			</td>
			
		</tr>
		<tr>
		<td>
			<fieldset class="bawah">
			<table width="100%" height="25px">
				<tr>
					<td colspan="3" align="center">
						
						<a href="<?php echo base_url();?>index.php/cotation/index/<?php echo $hal; ?>">
						<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
						</a>
					</td>
				</tr>
			</table>  
			</fieldset>   
		</td>
	</tr>
	</table>
	</form>
	</div>
	<div id="dialog"></div>
	<div id="dialogAcc"></div>
	<div id="dialogUp"></div>
	<div id="dialogImpAcc"></div>