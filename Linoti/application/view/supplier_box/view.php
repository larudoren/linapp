<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->
<script type="text/javascript" src="<?=base_url('asset/js/jquery.mousewheel-3.0.4.pack.js')?>"></script>
<!--<script type="text/javascript" src="<?=base_url('asset/js/jquery.min.js')?>"></script> -->
<script type="text/javascript" src="<?=base_url('asset/js/jquery.fancybox-1.3.4.pack.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('asset/css/jquery.fancybox-1.3.4.css')?>" media="screen" />
<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
</script>
<script type="text/javascript">
		$(document).ready(function() { 
			$("a#example6").fancybox({
				'titlePosition'		: 'inside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9,
				'closeClick'			: false,
				'autoDimenstions'	: true, 
				'closeButton'			: true,
				'border'					: true,
				'hideOnOverlayClick' : false,
			}); 
			
			$("a.picture").click(function (e){
				e.preventDefault();
				//$("#popfoto").attr('width','260px');
				//$("#popfoto").load($(this).attr('href'));
				$(this).fancybox({
				  'titlePosition'		: 'inside',
					'overlayColor'		: '#000',
					'autoDimenstions'	: true,
					'overlayOpacity'	: 0.9,
					'closeClick'			: false,
					'href'						: $(this).href,
					'closeButton'			: true,
					'width'						: '260px', /*
					'height'					: 340, */
					'hideOnOverlayClick' : false,
					'title' : $(this).attr('title')
				});
				//return false(); */
			});

		});
	</script>
<script>
	
</script>
<div id="view">
<?php
//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
?>
<div style="float:left; padding-bottom:5px;">
<a href="<?=site_url('supplier_box')?>">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<a href="<?=site_url('supplier_box/clear')?>">
<button type="button" class="easyui-linkbutton" >Clear search result</button>
</a>

</div>
<?php
//}
?>

<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">

<tr>
	<form name="form" method="post" action="<?php echo base_url('index.php/supplier_box');?>">
	<td></td>
	<td><input type="text" name="code_cari" id="code_cari" size="15" value="<?=$this->session->userdata('dproduct_code_cari')?>" /></td>
	<td></td>
	<td><input type="text" name="name_cari" id="name_cari" size="50" value="<?=$this->session->userdata('dproduct_name_cari')?>" /></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td align="center"><button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button></td>
	</form>
</tr> 
<tr>
	<th>No</th>
    <th>Code</th>
    <th>Photo</th>
    <th>Name</th>
    <th>Collection</th>
    <th>Category</th>
    <th>Supplier</th>
    <th>Date</th>
    <th>Price</th>
</tr>
<?php
	$awal = date('Y-m-01');
	$sekarang = date('Y-m-d');
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){
			if($db['product_photo']=="") {
				$foto = base_url('asset/product_photo/unknown.jpg');
			} else {
				$foto = base_url('asset/product_photo/'.$db['product_photo']);
			}
			
			$harga='';
			
			if ($db['currency']=='Rp'){
				//$harga = number_format($db['harga'],0,',','.');
				if (!empty($db['hargabox1'])){
					$harga .= 'BOX 1 : <strong>Rp '.number_format($db['hargabox1'],0,',','.').'</strong>; ';
				}
				if (!empty($db['hargabox2'])){
					$harga .= 'BOX 2 : <strong>Rp '.number_format($db['hargabox2'],0,',','.').'</strong>; ';
				}
				if (!empty($db['hargabox3'])){
					$harga .= 'BOX 3 : <strong>Rp '.number_format($db['hargabox3'],0,',','.').'</strong>; ';
				}
				
				if ($harga!=''){
					$harga = substr($harga,0,-2);
				}
			} else {
				
				if (!empty($db['hargabox1'])){
					$whole = 0;
					$fraction = 0.0;
					$fraction_str ='';
					$whole = floor($db['hargabox1']);
					$fraction = $db['hargabox1'] - $whole;
					$fraction_str = ''.number_format($db['hargabox1'], 3,',','.');
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
							$harga .= 'BOX 1 : <strong>'.$db['currency'].' '.number_format($db['hargabox1'],3,',','.').'</strong>; ';
						} elseif(substr($fraction_str,-2,1)!='0'){
							$harga .= 'BOX 1 : <strong>'.$db['currency'].' '.number_format($db['hargabox1'],2,',','.').'</strong>; ';
						} else {
							$harga .= 'BOX 1 : <strong>'.$db['currency'].' '.number_format($db['hargabox1'],1,',','.').'</strong>; ';
						}
					} else {
						$harga .= 'BOX 1 : <strong>'.$db['currency'].' '.number_format($db['hargabox1'],0,',','.').'</strong>; ';
					}
				}
				
				if (!empty($db['hargabox2'])){
					$whole = 0;
					$fraction = 0.0;
					$fraction_str ='';
					$whole = floor($db['hargabox2']);
					$fraction = $db['hargabox2'] - $whole;
					$fraction_str = ''.number_format($db['hargabox2'], 3,',','.');
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
							$harga .= 'BOX 2 : <strong>'.$db['currency'].' '.number_format($db['hargabox2'],3,',','.').'</strong>; ';
						} elseif(substr($fraction_str,-2,1)!='0'){
							$harga .= 'BOX 2 : <strong>'.$db['currency'].' '.number_format($db['hargabox2'],2,',','.').'</strong>; ';
						} else {
							$harga .= 'BOX 2 : <strong>'.$db['currency'].' '.number_format($db['hargabox2'],1,',','.').'</strong>; ';
						}
					} else {
						$harga .= 'BOX 2 : <strong>'.$db['currency'].' '.number_format($db['hargabox2'],0,',','.').'</strong>; ';
					}
				}
				
				if (!empty($db['hargabox3'])){
					$whole = 0;
					$fraction = 0.0;
					$fraction_str ='';
					$whole = floor($db['hargabox3']);
					$fraction = $db['hargabox3'] - $whole;
					$fraction_str = ''.number_format($db['hargabox3'], 3,',','.');
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
							$harga .= 'BOX 3 : <strong>'.$db['currency'].' '.number_format($db['hargabox3'],3,',','.').'</strong>; ';
						} elseif(substr($fraction_str,-2,1)!='0'){
							$harga .= 'BOX 3 : <strong>'.$db['currency'].' '.number_format($db['hargabox3'],2,',','.').'</strong>; ';
						} else {
							$harga .= 'BOX 3 : <strong>'.$db['currency'].' '.number_format($db['hargabox3'],1,',','.').'</strong>; ';
						}
					} else {
						$harga .= 'BOX 3 : <strong>'.$db['currency'].' '.number_format($db['hargabox3'],0,',','.').'</strong>; ';
					}
				}
				
				if ($harga!=''){
					$harga = substr($harga,0,-2);
				}
				
			} 
			
			
			
		?>    
    	<tr>
			<td align="center" width="30"><?=$no?></td>
           <td width="70" align="center"><font size="1"><?=$db['product_code']?></font></td>
            <td align="center" width="110"><a id="example6" class="picture" href="<?=$foto?>" title="<?=$db['product_name']?>"><div style="width: 100px; height: 100px; border: no; overflow: hidden; position: relative;">
    <img src="<?=$foto?>" style="position: absolute;" onload="OnImageLoad(event);"/>
</div></a><!--<a id="example6" class="picture" href="<?=$foto?>" title="<?=$db['product_name']?>"><img src="<?=$foto?>" width="60px" /></a>--></td>
            <td><a href="<?php echo base_url();?>index.php/supplier_box/edit/<?php echo $db['product_code'];?>"><?=$db['product_name']?></a></td>
            <td><?=$db['coll_name']?></td>
            <td><?=$db['category']?></td>
            <td width="200" align="center"><?=$db['supplier_name']?></td>
            <td width="50" align="center"><?=$db['tglhrg']?></td>
            <td align="center"><?=$harga?></td>
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
        	<td colspan="10" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<div id="popfoto" width="250px" height="250px" style="display:none"></div>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>