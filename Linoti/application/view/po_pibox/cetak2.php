<html>
<head>
  <style>
    @page {<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
				margin:170px 15px;
				font-size:9.5px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
				margin:170px 15px;
				font-size:7px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
				margin:170px 10px;
				font-size:6px;
				<?php } ?> }
    #header { position: fixed; top: -160px; height: 170px;}
    #footer { position: relative; bottom: 0px; height: 0px;}
    <!--#content { position: fixed; left: 0px; top: 210px; right: 0px;}-->
    <!--#footer .page:after { position: fixed; bottom: 0px; height: 0px;}-->
	
	body { 
		font-family:'times new roman';
		<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
		font-size:9.5px;
		<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
		font-size:7px;
		<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
		font-size:6px;
		<?php } ?>
	}
	
	table {
		border-collapse: collapse;
	}
	th, td {
		border: 0.5px solid black;
	}
	
  </style>
<body>
  <div id="header">
	<?php 
		$logo = '/xampp/htdocs/Linoti/asset/images/linoti.png'; 
		list($width, $height) = getimagesize($logo);
	?>
    <table width="100%" border="0">
		<tr>
			<td align="left">
				<?php
				if ($width >= $height){
				?>
				<img src="<?=$logo?>" width="100px">
				<?php
				} else {
				?>
				<img src="<?=$logo?>" height="100px">
				<?php
				}
				?>
			</td>
		</tr>
	</table>
	<table border="0" id="tableheader">
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td align="center">
							<font size="14px"><strong>PURCHASE ORDER KE SUPPLIERS</strong></font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>
				<table>
				<?php if ($box1==1 && $box2!=1 && $box3!=1){ 
							
				?>
					<tr>
						<?php if ($lshape==1) {
								$code=30;
								$img=50;
								$coll=50;
								$descr=60;
								$pack_rem=20;
								$u_price=40;
								$update=35;
								$com_l=20;
								$com_w=20;
								$com_h=20;
								$kdown=25;
								$type=11;
								$gap_l=10;
								$gap_w=10;
								$gap_h=10;
								$in_l=12;
								$in_w=12;
								$in_h=12;
								$cr_l=10;
								$cr_w=10;
								$cr_h=10;
								$out_l=12;
								$out_w=12;
								$out_h=12;
								$outer=14;
								$qbox=10;
								$box_rem=21;
								$touter=14;
								$lv=13;
								$lh=13;
						?>
						<td colspan="29">
						<?php } else { 
								$code=35;
								$img=50;
								$coll=50;
								$descr=80;
								$pack_rem=40;
								$u_price=40;
								$update=35;
								$com_l=20;
								$com_w=20;
								$com_h=20;
								$kdown=25;
								$type=11;
								$gap_l=10;
								$gap_w=10;
								$gap_h=10;
								$in_l=12;
								$in_w=12;
								$in_h=12;
								$cr_l=10;
								$cr_w=10;
								$cr_h=10;
								$out_l=12;
								$out_w=12;
								$out_h=12;
								$outer=14;
								$qbox=10;
								$box_rem=21;
								$touter=14;
								
						?>
						<td colspan="27">
						<?php } ?>
							<table border="0" style="font-size:12px;font-weight:bold;" width="100%">
								<tr>
									<td width="70">PO Number</td>
									<td width="5">:</td>
									<td width="200"><?=$po?></td>
									<td>&nbsp;</td>
									<td width="70">PI Number</td>
									<td width="5">:</td>
									<td width="150"><?=$pi?></td>
								</tr>
								<tr>
									<td>Attention</td>
									<td>:</td>
									<td><?=$supplier?></td>
									<td></td>
									<td>Customer</td>
									<td>:</td>
									<td><?=$customer?></td>
								</tr>
								<tr>
									<td>Date of Issue</td>
									<td>:</td>
									<td><?=$tanggalbeli?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Deadline</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Date Print</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center" bgcolor="#f3f3f3">Items</td>
						<th colspan="3" rowspan="2" align="center" bgcolor="#92D050">Comercial<br/>Size(cm)</td>
						<th rowspan="3" align="center" width="<?=$kdown?>" bgcolor="#CCC0DA">Knock<br/>Down<br/>?</td>
						<th rowspan="3" align="center" width="20" bgcolor="#C5BE97">Packing Remarks</td>
						<?php if ($lshape==1) {?>
						<th colspan="18" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } else { ?>
						<th colspan="16" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } ?>
						
						<th rowspan="2" align="center" width="<?=$u_price?>" bgcolor="#66FFFF">Unit<br/>Price</td>
						<th rowspan="2" align="center" width="<?=$update?>" bgcolor="#66FFFF">Update</td>
					</tr>
					<tr>
						<th rowspan="2" width="<?=$code?>" bgcolor="#f3f3f3">Code</th>
						<th rowspan="2" width="<?=$img?>" bgcolor="#f3f3f3">Image</th>
						<th rowspan="2" width="<?=$coll?>" bgcolor="#f3f3f3">Collection</th>
						<th rowspan="2" width="<?=$descr?>" bgcolor="#f3f3f3">Description</th>
						<th bgcolor="#C5BE97" width="<?=$type?>">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
						<?php if ($lshape==1){ ?>
						<th rowspan="2" width="<?=$lv?>" bgcolor="#C5BE97">L<br>Vertical</th>
						<th rowspan="2" width="<?=$lh?>" bgcolor="#C5BE97">L<br>Horizontal</th>
						<?php } ?>
						<th rowspan="2" width="<?=$outer?>" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" width="<?=$qbox?>" bgcolor="#FDE9D9">Qty Box</th>
						<th rowspan="2" width="<?=$box_rem?>" bgcolor="#FDE9D9">Remarks</th>
					</tr>
					<tr>
						<th bgcolor="#92D050" width="<?=$com_l?>">L</th>
						<th bgcolor="#92D050" width="<?=$com_w?>">W</th>
						<th bgcolor="#92D050" width="<?=$com_h?>">H</th>
						<th bgcolor="#C5BE97"></th>
						<th bgcolor="#C5BE97" width="<?=$gap_l?>">L</th>
						<th bgcolor="#C5BE97" width="<?=$gap_w?>">W</th>
						<th bgcolor="#C5BE97" width="<?=$gap_h?>">H</th>
						<th bgcolor="#FDE9D9" width="<?=$in_l?>">L</th>
						<th bgcolor="#FDE9D9" width="<?=$in_w?>">W</th>
						<th bgcolor="#FDE9D9" width="<?=$in_h?>">H</th>
						<th bgcolor="#C5BE97" width="<?=$cr_l?>">L</th>
						<th bgcolor="#C5BE97" width="<?=$cr_w?>">W</th>
						<th bgcolor="#C5BE97" width="<?=$cr_h?>">H</th>
						<th bgcolor="#FDE9D9" width="<?=$out_l?>">L</th>
						<th bgcolor="#FDE9D9" width="<?=$out_w?>">W</th>
						<th bgcolor="#FDE9D9" width="<?=$out_h?>">H</th>
						<th bgcolor="#66FFFF" width="<?=$outer?>">Box 1</th>
						<th bgcolor="#66FFFF"></th>
					</tr>
					<?php 
						
						} elseif ($box1==1 && $box2==1 && $box3!=1) { 
							$code=35;
							$img=35;
							$coll=40;
							$descr=70;
							$pack_rem=25;
							$u_price=60;
							$update=30;
							$com_l=13;
							$com_w=13;
							$com_h=13;
							$kdown=15;
							$type=12;
							$gap_l=10;
							$gap_w=10;
							$gap_h=10;
							$in_l=12;
							$in_w=12;
							$in_h=12;
							$cr_l=10;
							$cr_w=10;
							$cr_h=10;
							$out_l=12;
							$out_w=12;
							$out_h=12;
							$outer=14;
							$qbox=10;
							$box_rem=21;
							$touter=14;
							$b1_hrg=30;
							$b2_hrg=30;
					?>
					<tr>
						<?php if ($lshape==1) {?>
						<td colspan="47">
						<?php } else { ?>
						<td colspan="45">
						<?php } ?>
							<table border="0" style="font-size:12px;font-weight:bold;" width="100%">
								<tr>
									<td width="70">PO Number</td>
									<td width="5">:</td>
									<td width="200"><?=$po?></td>
									<td>&nbsp;</td>
									<td width="70">PI Number</td>
									<td width="5">:</td>
									<td width="150"><?=$pi?></td>
								</tr>
								<tr>
									<td>Attention</td>
									<td>:</td>
									<td><?=$supplier?></td>
									<td></td>
									<td>Customer</td>
									<td>:</td>
									<td><?=$customer?></td>
								</tr>
								<tr>
									<td>Date of Issue</td>
									<td>:</td>
									<td><?=$tanggalbeli?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Deadline</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Date Print</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center" bgcolor="#f3f3f3">Items</td>
						<th colspan="3" rowspan="2" align="center" bgcolor="#92D050">Comercial<br/>Size(cm)</td>
						<th rowspan="3" align="center" width="15" bgcolor="#CCC0DA">Knock<br/>Down<br/>?</td>
						<th rowspan="3" align="center" width="<?=$pack_rem?>" bgcolor="#C5BE97">Packing Remarks</td>
						<?php if($lshape==1) {?>
						<th colspan="18" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } else { ?>
						<th colspan="16" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } ?>
						<th colspan="16" align="center" bgcolor="#C5BE97">Box 2</td>
						
						<th rowspan="3" align="center" width="<?=$touter?>" bgcolor="#C5BE97">Total<br/>Vol. Box<br/>Outer<br>Order</td>
						<th rowspan="2" colspan="2" align="center" width="<?=$u_price?>" bgcolor="#66FFFF">Unit<br/>Price</td>
						<th rowspan="2" align="center" width="<?=$update?>" bgcolor="#66FFFF">Update</td>
					</tr>
					<tr>
						<th rowspan="2" width="35" bgcolor="#f3f3f3">Code</th>
						<th rowspan="2" width="35" bgcolor="#f3f3f3">Image</th>
						<th rowspan="2" width="40" bgcolor="#f3f3f3">Collection</th>
						<th rowspan="2" width="70" bgcolor="#f3f3f3">Description</th>
						<th bgcolor="#C5BE97" width="<?=$type?>">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
						<?php if($lshape==1){ ?>
						<th rowspan="2" bgcolor="#C5BE97">a</th>
						<th rowspan="2" bgcolor="#C5BE97">b</th>
						<?php } ?>
						<th rowspan="2" width="<?=$outer?>" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" width="<?=$qbox?>" bgcolor="#FDE9D9">Qty Box 1</th>
						<th rowspan="2" width="<?=$box_rem?>" bgcolor="#C5BE97">Remarks Box 1</th>
						<th bgcolor="#C5BE97" width="<?=$type?>">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
						<th rowspan="2" width="<?=$outer?>" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" width="<?=$qbox?>" bgcolor="#FDE9D9">Qty Box 2</th>
						<th rowspan="2" width="<?=$box_rem?>" bgcolor="#C5BE97">Remarks Box 2</th>
					</tr>
					<tr>
						<th bgcolor="#92D050" width="<?=$com_l?>">L</th> 
						<th bgcolor="#92D050" width="<?=$com_w?>">W</th> 
						<th bgcolor="#92D050" width="<?=$com_h?>">H</th> 
						<th bgcolor="#C5BE97"></th> 
						<th bgcolor="#C5BE97" width="<?=$gap_l?>">L</th> 
						<th bgcolor="#C5BE97" width="<?=$gap_w?>">W</th> 
						<th bgcolor="#C5BE97" width="<?=$gap_h?>">H</th> 
						<th bgcolor="#FDE9D9" width="<?=$in_l?>">L</th> 
						<th bgcolor="#FDE9D9" width="<?=$in_w?>">W</th> 
						<th bgcolor="#FDE9D9" width="<?=$in_h?>">H</th>
						<th bgcolor="#C5BE97" width="<?=$cr_l?>">L</th> 
						<th bgcolor="#C5BE97" width="<?=$cr_w?>">W</th> 
						<th bgcolor="#C5BE97" width="<?=$cr_h?>">H</th> 
						<th bgcolor="#FDE9D9" width="<?=$out_l?>">L</th> 
						<th bgcolor="#FDE9D9" width="<?=$out_w?>">W</th> 
						<th bgcolor="#FDE9D9" width="<?=$out_h?>">H</th> 
						<th bgcolor="#C5BE97"></th>
						<th bgcolor="#C5BE97" width="<?=$gap_l?>">L</th>
						<th bgcolor="#C5BE97" width="<?=$gap_w?>">W</th>
						<th bgcolor="#C5BE97" width="<?=$gap_h?>">H</th>
						<th bgcolor="#FDE9D9" width="<?=$in_l?>">L</th>
						<th bgcolor="#FDE9D9" width="<?=$in_w?>">W</th>
						<th bgcolor="#FDE9D9" width="<?=$in_h?>">H</th>
						<th bgcolor="#C5BE97" width="<?=$cr_l?>">L</th>
						<th bgcolor="#C5BE97" width="<?=$cr_w?>">W</th>
						<th bgcolor="#C5BE97" width="<?=$cr_h?>">H</th>
						<th bgcolor="#FDE9D9" width="<?=$out_l?>">L</th>
						<th bgcolor="#FDE9D9" width="<?=$out_w?>">W</th>
						<th bgcolor="#FDE9D9" width="<?=$out_h?>">H</th>
						<th bgcolor="#66FFFF" width="<?=$b1_hrg?>">Box 1</th>
						<th bgcolor="#66FFFF" width="<?=$b2_hrg?>">Box 2</th>
						<th bgcolor="#66FFFF"></th>
					</tr>
					<?php } elseif ($box1==1 && $box2==1 && $box3==1) { 
							$code=25;
							$img=25;
							$coll=30;
							$descr=35;
							$pack_rem=20;
							$u_price=70;
							$update=25;
					?>
					<tr>
						<?php if ($lshape==1) {?>
						<td colspan="61">
						<?php } else { ?>
						<td colspan="59">
						<?php } ?>
							<table border="0" style="font-size:12px;font-weight:bold;" width="100%">
								<tr>
									<td width="70">PO Number</td>
									<td width="5">:</td>
									<td width="200"><?=$po?></td>
									<td>&nbsp;</td>
									<td width="70">PI Number</td>
									<td width="5">:</td>
									<td width="150"><?=$pi?></td>
								</tr>
								<tr>
									<td>Attention</td>
									<td>:</td>
									<td><?=$supplier?></td>
									<td></td>
									<td>Customer</td>
									<td>:</td>
									<td><?=$customer?></td>
								</tr>
								<tr>
									<td>Date of Issue</td>
									<td>:</td>
									<td><?=$tanggalbeli?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Deadline</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Date Print</td>
									<td>:</td>
									<td>-</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<th colspan="4" align="center" bgcolor="#f3f3f3">Items</td>
						<th colspan="3" rowspan="2" align="center" bgcolor="#92D050">Comercial<br/>Size(cm)</td>
						<th rowspan="3" align="center" bgcolor="#CCC0DA">Knock<br/>Down<br/>?</td>
						<th rowspan="3" align="center" width="20" bgcolor="#C5BE97">Packing Remarks</td>
						<?php if($lshape==1){ ?>
						<th colspan="17" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } else { ?>
						<th colspan="15" align="center" bgcolor="#C5BE97">Box 1</td>
						<?php } ?>
						<th colspan="15" align="center" bgcolor="#C5BE97">Box 2</td>
						<th colspan="15" align="center" bgcolor="#C5BE97">Box 3</td>
						
						<th rowspan="3" align="center" bgcolor="#C5BE97">Total<br/>Vol. Box<br/>Outer<br>Order</td>
						<th rowspan="2" colspan="3" align="center" width="70" bgcolor="#66FFFF">Unit<br/>Price</td>
						<th rowspan="2" align="center" width="25" bgcolor="#66FFFF">Update</td>
					</tr>
					<tr>
						<th rowspan="2" width="25" bgcolor="#f3f3f3">Code</th>
						<th rowspan="2" width="25" bgcolor="#f3f3f3">Image</th>
						<th rowspan="2" width="30" bgcolor="#f3f3f3">Collection</th>
						<th rowspan="2" width="35" bgcolor="#f3f3f3">Description</th>
						<th bgcolor="#C5BE97">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size</th>
						<?php if($lshape==1){ ?>
						<th rowspan="2" bgcolor="#C5BE97">a</th>
						<th rowspan="2" bgcolor="#C5BE97">b</th>
						<?php } ?>
						<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" bgcolor="#FDE9D9">Qty Box 1</th>
						<th bgcolor="#C5BE97">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size</th>
						<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" bgcolor="#FDE9D9">Qty Box 2</th>
						<th bgcolor="#C5BE97">Type</th>
						<th colspan="3" bgcolor="#C5BE97">Gap</th>
						<th colspan="3" bgcolor="#FDE9D9">Inner Size</th>
						<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
						<th colspan="3" bgcolor="#FDE9D9">Outer Size</th>
						<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
						<th rowspan="2" bgcolor="#FDE9D9">Qty Box 3</th>
					</tr>
					<tr>
						<th bgcolor="#92D050">L</th>
						<th bgcolor="#92D050">W</th>
						<th bgcolor="#92D050">H</th>
						<th bgcolor="#C5BE97"></th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#C5BE97"></th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#C5BE97"></th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#C5BE97">L</th>
						<th bgcolor="#C5BE97">W</th>
						<th bgcolor="#C5BE97">H</th>
						<th bgcolor="#FDE9D9">L</th>
						<th bgcolor="#FDE9D9">W</th>
						<th bgcolor="#FDE9D9">H</th>
						<th bgcolor="#66FFFF">Box 1</th>
						<th bgcolor="#66FFFF">Box 2</th>
						<th bgcolor="#66FFFF">Box 3</th>
						<th bgcolor="#66FFFF"></th>
					</tr>
					<?php } 
					?>
				</table>
			</td>
		</tr>
	</table>
  </div>
  <?php
  if ($box1!=0 && $box2==0 && $box3==0){ ?>
	<div id="content" style="margin-top:34px; margin-left:1px">
	<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
	<div id="content" style="margin-top:50px; margin-left:1px">
	<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
	<div id="content" style="margin-top:50px; margin-left:2px">
	<?php } ?> 
  <!--<div id="content" style="margin-top:50px">-->
    <p style="page-break-before: avoid;"><table style="font-size:9.5px;"> 
	<?php
		$num_item=1;
		$max_page=10;
		if($data->num_rows>0){
							
			foreach($data->result() as $dataresult){
				
				if ($dataresult->product_photo!=''){
					$foto = '/xampp/htdocs/Linoti/asset/product_photo/'.$dataresult->product_photo;
				} else {
					$foto = '/xampp/htdocs/Linoti/asset/product_photo/unknown.jpg';
				}
				list($width, $height) = getimagesize($foto);
		?>
				<!--
		<?php
				if ($num_item % $max_page == 0){
					if ($box1==1 && $box2!=1 && $box3!=1){
						if ($lshape==1){
		?>
						<tr border="0"><td colspan="29" border="0"><div style="page-break-before: always;"></div></td></tr>
		<?php
						}else{
		?>
						<tr border="0"><td colspan="27" border="0"><div style="page-break-before: always;"></div></td></tr>
		<?php
						}
					}else if($box1==1 && $box2==1 && $box3!=1){
						if ($lshape==1){
		?>
						<tr><td colspan="47" border="0"><div style="page-break-before: always;"></div></td></tr>
		<?php
						} else {
		?>
						<tr><td colspan="45" border="0"><div style="page-break-before: always;"></div></td></tr>
		<?php
						}
					} else if($box1==1 && $box2==1 && $box3==1){
						if ($lshape==1){
		?>
						<tr><td colspan="61"><div style="page-break-before: always;"></div></td></tr>
		<?php
						} else{
		?>
						<tr><td colspan="59"><div style="page-break-before: always;"></div></td></tr>
		<?php
						}
					}
				}
		?> -->
					<tr>
					<td align="center" width="30"><?=$dataresult->product_code?></td>
					<td align="center" width="<?=$img?>">
						
							<?php 
								if ($width >= $height){ 
									if ($box1==1 && $box2!=1 && $box3!=1){
							?>
										<img src="<?=$foto?>" width="50px"/>
							<?php 
									} elseif ($box1==1 && $box2==1 && $box3!=1){
							?>
										<img src="<?=$foto?>" width="40px"/>
							<?php
									} else {
							?>
										<img src="<?=$foto?>" width="30px"/>
							<?php
									}
								} else{ 
									if ($box1==1 && $box2!=1 && $box3!=1){
							?>
										<img src="<?=$foto?>" height="50px"/>
								<?php 
									} elseif ($box1==1 && $box2==1 && $box3!=1){
							?>
										<img src="<?=$foto?>" width="40px"/>
							<?php
									} else {
							?>
										<img src="<?=$foto?>" height="30px"/>
							<?php 
									}
								} 
							?>
						
					</td>
					<td width="<?=$coll?>"><?=$dataresult->coll_name?></td>
					<td width="<?=$descr?>"><?=$dataresult->product_name?></td>
		<?php
					if ($dataresult->cm_length > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($dataresult->cm_length);
						$fraction = $dataresult->cm_length - $whole;
						if ($fraction > 0){
		?>
							<td align="center" width="<?=$com_l?>"><?=number_format($dataresult->cm_length,1)?></td>
		<?php
						} else {
		?>
							<td align="center" width="<?=$com_l?>"><?=number_format($dataresult->cm_length,0)?></td>
		<?php
						}
					} else {
		?>
						<td width="<?=$com_l?>"></td>
		<?php
					}
					
					if ($dataresult->cm_width > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($dataresult->cm_width);
						$fraction = $dataresult->cm_width - $whole;
						if ($fraction > 0){
		?>
							<td align="center" width="<?=$com_w?>"><?=number_format($dataresult->cm_width,1)?></td>
		<?php
						} else {
		?>
							<td align="center" width="<?=$com_w?>"><?=number_format($dataresult->cm_width,0)?></td>
		<?php
						}
					} else {
		?>
						<td width="<?=$com_w?>"></td>
		<?php
					}
					
					if ($dataresult->cm_height > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($dataresult->cm_height);
						$fraction = $dataresult->cm_height - $whole;
						if ($fraction > 0){
		?>
							<td align="center" width="<?=$com_h?>"><?=number_format($dataresult->cm_height,1)?></td>
		<?php
						} else {
		?>
							<td align="center" width="<?=$com_h?>"><?=number_format($dataresult->cm_height,0)?></td>
		<?php
						}
					} else {
		?>
						<td width="<?=$com_h?>"></td>
		<?php
					}
					
					$textdetail = "SELECT E.boxnumber, E.kdown, E.remarks_packing, E.remarks, E.lstyrofoam, E.wstyrofoam, E.hstyrofoam, E.linner, E.winner, E.hinner, E.lkarton, E.wkarton, E.hkarton, E.louter,E.wouter, 
																E.houter, E.volouter, A.qtybox, E.qtyperbox,E.typebox, F.currency_name, A.hrgbox, DATE_FORMAT(A.hrgdate,'%d-%b-%y') as hrgdate, E.asize, E.bsize
												 FROM d_belibox A
												 LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
												 LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
												 LEFT OUTER JOIN currency F ON F.currency_code=A.currency
												 WHERE A.po='".$dataresult->po."' AND A.product_code='".$dataresult->product_code."' AND A.companyarea='".$dataresult->companyarea."' ORDER BY E.boxnumber";
					$table =  $this->app_model->manualQuery($textdetail);
					$row = $table->num_rows();
					$fp=fopen("datadetail.txt","a");
					fwrite($fp,$textdetail.'
					');
					if ($row>0){
						$tmp = 1;
						$volbox1=0;
						$volbox2=0;
						$volbox3=0;
						$currency='';
						$hrg1=0;
						$hrg2=0;
						$hrg3=0;
						$hrgdate='';
						
						foreach ($table->result() as $dt){
							if ($box1==1 && $box2!=1 && $box3!=1){
								$volbox1 = $dt->volouter*$dt->qtybox;
								$currency = $dt->currency_name;
								$hrgdate = $dt->hrgdate;
								$hrg1 = $dt->hrgbox;
		?>
								<td align="center" width="<?=$kdown?>"><?=$dt->kdown?></td>
								<?php if (empty($dt->remarks_packing)){
									$dt->remarks_packing = '&nbsp;';
								}
								?>
								<td align="center" width="<?=$pack_rem?>"><?=$dt->remarks_packing?></td>
								<td align="center" width="<?=$type?>"><?=$dt->typebox?></td>
								<td align="center" width="<?=$gap_l?>"><?=number_format($dt->lstyrofoam,0)?></td>
								<td align="center" width="<?=$gap_w?>"><?=number_format($dt->wstyrofoam,0)?></td>
								<td align="center" width="<?=$gap_h?>"><?=number_format($dt->hstyrofoam,0)?></td>
		<?php
								if ($dt->linner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->linner);
									$fraction = $dt->linner - $whole;
									if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
										$warnalinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnalinner = '';
									}
									if ($fraction > 0){
		?>
										<td align="center" width="<?=$in_l?>" <?php echo $warnalinner; ?>><?=number_format($dt->linner,1)?></td>
		<?php
									} else {
		?>
										<td align="center" width="<?=$in_l?>" <?php echo $warnalinner; ?>><?=number_format($dt->linner,0)?></td>
		<?php
									}
								} else {
		?>
									<td width="<?=$in_l?>">&nbsp;</td>
		<?php
								}
								
								if ($dt->winner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->winner);
									$fraction = $dt->winner - $whole;
									if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
										$warnawinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnawinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$in_w?>" <?php echo $warnawinner; ?>><?=number_format($dt->winner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$in_w?>" <?php echo $warnawinner; ?>><?=number_format($dt->winner,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$in_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->hinner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hinner);
									$fraction = $dt->hinner - $whole;
									if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
										$warnahinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnahinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$in_h?>" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$in_h?>" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$in_h?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->lkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->lkarton);
									$fraction = $dt->lkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$gap_l?>"><?=number_format($dt->lkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$gap_l?>"><?=number_format($dt->lkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$gap_l?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->wkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wkarton);
									$fraction = $dt->wkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$gap_w?>"><?=number_format($dt->wkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$gap_w?>"><?=number_format($dt->wkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$gap_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->hkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hkarton);
									$fraction = $dt->hkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$gap_h?>"><?=number_format($dt->hkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$gap_h?>"><?=number_format($dt->hkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$gap_h?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->louter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->louter);
									$fraction = $dt->louter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_l?>"><?=number_format($dt->louter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_l?>"><?=number_format($dt->louter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_l?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->wouter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wouter);
									$fraction = $dt->wouter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_w?>"><?=number_format($dt->wouter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_w?>"><?=number_format($dt->wouter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->houter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->houter);
									$fraction = $dt->houter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_h?>"><?=number_format($dt->houter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_h?>"><?=number_format($dt->houter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_h?>">&nbsp;</td>
			<?php
								}
								
								if ($lshape==1){
									if ($dt->asize > 0){
										$whole = 0;
										$fraction = 0.0;
										$whole = floor($dt->asize);
										$fraction = $dt->asize - $whole;
										if ($fraction > 0){
			?>
								<td align="center" width="<?=$lv?>"><?=number_format($dt->asize,1)?></td>
			<?php
										}else{
			?>
								<td align="center" width="<?=$lv?>"><?=number_format($dt->asize,0)?></td>
			<?php
										}
									} else {
			?>
								<td width="<?=$lv?>">&nbsp;</td>
			<?php
									}
									
									if ($dt->bsize > 0){
										$whole = 0;
										$fraction = 0.0;
										$whole = floor($dt->bsize);
										$fraction = $dt->bsize - $whole;
										if ($fraction > 0){
			?>
								<td align="center" width="<?=$lh?>"><?=number_format($dt->bsize,1)?></td>
			<?php
										} else {
			?>
								<td align="center" width="<?=$lh?>"><?=number_format($dt->bsize,0)?></td>
			<?php
										}
									}else{
			?>
								<td width="<?=$lh?>">&nbsp;</td>
			<?php
									}
								}
			?>
								<td align="center" width="<?=$outer?>"><?=$dt->volouter?></td>
								<td align="center" width="<?=$qbox?>"><?=$dt->qtybox?></td>
								<td align="center" width="<?=$box_rem?>"><?=$dt->remarks?></td>
			<?php
								
							}elseif ($box1==1 && $box2==1 && $box3!=1){
								if ($tmp==1){
			?>
									<td align="center" width="<?=$kdown?>"><?=$dt->kdown?></td>
									<?php if (empty($dt->remarks_packing)){
										$dt->remarks_packing = '&nbsp;';
									}
									?>
									<td align="center" width="<?=$pack_rem?>"><?=$dt->remarks_packing?></td>
			<?php
									$volbox1 = $dt->volouter*$dt->qtybox;
									$currency = $dt->currency_name;
									$hrgdate = $dt->hrgdate;
									$hrg1 = $dt->hrgbox;
								} else if ($tmp==2){
									$volbox2 = $dt->volouter*$dt->qtybox;
									$hrg2 = $dt->hrgbox;
								}
			?>
								<td align="center" width="<?=$type?>"><?=$dt->typebox?></td>
								<td align="center" width="<?=$gap_l?>"><?=number_format($dt->lstyrofoam,0)?></td>
								<td align="center" width="<?=$gap_w?>"><?=number_format($dt->wstyrofoam,0)?></td>
								<td align="center" width="<?=$gap_h?>"><?=number_format($dt->hstyrofoam,0)?></td>
			<?php
								if ($dt->linner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->linner);
									$fraction = $dt->linner - $whole;
									if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
										$warnalinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnalinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$in_l?>" <?php echo $warnalinner; ?>><?=number_format($dt->linner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$in_l?>" <?php echo $warnalinner; ?>><?=number_format($dt->linner,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$in_l?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->winner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->winner);
									$fraction = $dt->winner - $whole;
									if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
										$warnawinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnawinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$in_w?>" <?php echo $warnawinner; ?>><?=number_format($dt->winner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$in_w?>" <?php echo $warnawinner; ?>><?=number_format($dt->winner,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$in_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->hinner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hinner);
									$fraction = $dt->hinner - $whole;
									if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
										$warnahinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnahinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$in_h?>" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$in_h?>" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$in_h?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->lkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->lkarton);
									$fraction = $dt->lkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$cr_l?>"><?=number_format($dt->lkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$cr_l?>"><?=number_format($dt->lkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$cr_l?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->wkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wkarton);
									$fraction = $dt->wkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$cr_w?>"><?=number_format($dt->wkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$cr_w?>"><?=number_format($dt->wkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$cr_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->hkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hkarton);
									$fraction = $dt->hkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$cr_h?>"><?=number_format($dt->hkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$cr_h?>"><?=number_format($dt->hkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$cr_h?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->louter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->louter);
									$fraction = $dt->louter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_l?>"><?=number_format($dt->louter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_l?>"><?=number_format($dt->louter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_l?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->wouter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wouter);
									$fraction = $dt->wouter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_w?>"><?=number_format($dt->wouter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_w?>"><?=number_format($dt->wouter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_w?>">&nbsp;</td>
			<?php
								}
								
								if ($dt->houter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->houter);
									$fraction = $dt->houter - $whole;
									if ($fraction > 0){
			?>
										<td align="center" width="<?=$out_h?>"><?=number_format($dt->houter,1)?></td>
			<?php
									} else {
			?>
										<td align="center" width="<?=$out_h?>"><?=number_format($dt->houter,0)?></td>
			<?php
									}
								} else {
			?>
									<td width="<?=$out_h?>">&nbsp;</td>
			<?php
								}
			?>	
								<td align="center" width="<?=$outer?>"><?=$dt->volouter?></td>
								<td align="center" width="<?=$qbox?>"><?=$dt->qtybox?></td>
								<td align="center" width="<?=$box_rem?>"><?=$dt->remarks?></td>
			<?php
								
								$tmp++;
							}elseif ($box1==1 && $box2==1 && $box3==1){
								if ($tmp==1){
			?>
									<td align="center" width="<?=$kdown?>"><?=$dt->kdown?></td>
									<?php if (empty($dt->remarks_packing)){
										$dt->remarks_packing = '&nbsp;';
									}
									?>
									<td align="center" width="<?=$pack_rem?>"><?=$dt->remarks_packing?></td>
			<?php
									$volbox1 = $dt->volouter*$dt->qtybox;
									$currency = $dt->currency_name;
									$hrgdate = $dt->hrgdate;
									$hrg1 = $dt->hrgbox;
								} else if ($tmp==2){
									$volbox2 = $dt->volouter*$dt->qtybox;
									$hrg2 = $dt->hrgbox;
								} else if($tmp==3){
									$volbox3 = $dt->volouter*$dt->qtybox;
									$hrg3 = $dt->hrgbox;
								}
			?>
								<td align="center"><?=$dt->typebox?></td>
								<td align="center"><?=number_format($dt->lstyrofoam,0)?></td>
								<td align="center"><?=number_format($dt->wstyrofoam,0)?></td>
								<td align="center"><?=number_format($dt->hstyrofoam,0)?></td>
			<?php
								if ($dt->linner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->linner);
									$fraction = $dt->linner - $whole;
									if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
										$warnalinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnalinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" <?php echo $warnalinner; ?>><?=number_format($dt->linner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" <?php echo $warnalinner; ?>><?=number_format($dt->linner,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->winner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->winner);
									$fraction = $dt->winner - $whole;
									if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
										$warnawinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnawinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" <?php echo $warnawinner; ?>><?=number_format($dt->winner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" <?php echo $warnawinner; ?>><?=number_format($dt->winner,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->hinner >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hinner);
									$fraction = $dt->hinner - $whole;
									if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
										$warnahinner = ' bgcolor="#FFFF00" ';
									} else {
										$warnahinner = '';
									}
									if ($fraction > 0){
			?>
										<td align="center" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,1)?></td>
			<?php
									} else {
			?>
										<td align="center" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->lkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->lkarton);
									$fraction = $dt->lkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->lkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->lkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->wkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wkarton);
									$fraction = $dt->wkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->wkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->wkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->hkarton >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->hkarton);
									$fraction = $dt->hkarton - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->hkarton,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->hkarton,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->louter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->louter);
									$fraction = $dt->louter - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->louter,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->louter,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->wouter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->wouter);
									$fraction = $dt->wouter - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->wouter,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->wouter,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
								
								if ($dt->houter >0 ){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->houter);
									$fraction = $dt->houter - $whole;
									if ($fraction > 0){
			?>
										<td align="center"><?=number_format($dt->houter,1)?></td>
			<?php
									} else {
			?>
										<td align="center"><?=number_format($dt->houter,0)?></td>
			<?php
									}
								} else {
			?>
									<td></td>
			<?php
								}
			?>
								<td align="center"><?=$dt->volouter?></td>
								<td align="center"><?=$dt->qtybox?></td>
								<td align="center"><?=$dt->remarks?></td>
			<?php
								
								$tmp++;
							}
						}
						
						if ($box1==1 && $box2!=1 && $box3!=1){
			?>
							
			<?php
							if ($hrg1>0){
			?>
								<td align="center" width="<?=$u_price?>"><?=$currency.'  '.number_format($hrg1,0,'.',',')?></td>
			<?php
							} else {
			?>
								<td width="<?=$u_price?>">&nbsp;</td>
			<?php
							}
							
							if ($hrgdate!='' && $hrg1>0){
			?>
								<td align="center" width="<?=$update?>"><?=$hrgdate?></td>
			<?php
							} else {
			?>
								<td width="<?=$update?>">&nbsp;</td>
			<?php
							}
						}elseif ($box1==1 && $box2==1 && $box3!=1){
							if ($tmp-1<2){
								$tmp2=$tmp-1;
								while ($tmp2<2){
			?>
									<td align="center" width="<?=$type?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$gap_l?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$gap_w?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$gap_h?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$in_l?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$in_w?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$in_h?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$cr_l?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$cr_w?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$cr_h?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$out_l?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$out_w?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$out_h?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$outer?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$qbox?>" bgcolor="#ADADAD">&nbsp;</td>
									<td align="center" width="<?=$box_rem?>" bgcolor="#ADADAD">&nbsp;</td>
			<?php
									$tmp2++;
								}
							}
			?>
							<td align="center" width="<?=$touter?>"><?=($volbox1+$volbox2)?></td>
			<?php
							if ($hrg1>0){
			?>
								<td align="center" width="<?=$b1_hrg?>"><?=$currency.'  '.number_format($hrg1,0,'.',',')?></td>
			<?php
							} else {
			?>
								<td width="<?=$b1_hrg?>">&nbsp;</td>
			<?php
							}
							
							if ($hrg2>0){
			?>
								<td align="center" width="<?=$b2_hrg?>"><?=$currency.'  '.number_format($hrg2,0,'.',',')?></td>
			<?php
							} else {
			?>
								<td width="<?=$b2_hrg?>">&nbsp;</td>
			<?php
							}
							
							if (($hrgdate!='' && $hrg1>0) || ($hrgdate!='' && $hrg2>0)){
			?>
								<td align="center" width="<?=$update?>"><?=$hrgdate?></td>
			<?php
							} else {
			?>
								<td width="<?=$update?>">&nbsp;</td>
			<?php
							}
						}elseif ($box1==1 && $box2==1 && $box3==1){
							if ($tmp-1<3){
								$tmp3=$tmp-1;
								while ($tmp3<3){
			?>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
									<td align="center" bgcolor="#ADADAD"></td>
			<?php
									$tmp3++;
								}
							}
			?>
							<td align="center"><?=($volbox1+$volbox2+$volbox3)?></td>
			<?php
												
							if ($hrg1>0){
			?>
								<td align="center"><?=$currency.'  '.number_format($hrg1,0,'.',',')?></td>
			<?php
							} else{
			?>
								<td></td>
			<?php
							}
							
							if ($hrg2>0){
			?>
								<td align="center"><?=$currency.'  '.number_format($hrg2,0,'.',',')?></td>
			<?php
							} else {
			?>
								<td></td>
			<?php
							}
							
							if ($hrg3>0){
			?>
								<td align="center"><?=$currency.'  '.number_format($hrg3,0,'.',',')?></td>
			<?php
							} else {
			?>
								<td></td>
			<?php
							}					
							
							if ($hrgdate!='' && ($hrg1>0 || $hrg2>0 || $hrg3>0)){
			?>
								<td align="center"><?=$hrgdate?></td>
			<?php
							} else {
			?>
								<td></td>
			<?php
							}
						}
						
					}
		?>
				</tr>
		<?php
			$num_item++;
			}
			
		}
	?>
	</table></p>
  </div>
  <div id="footer">
    <p class="page"><table border="0" width="95%">
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3" align="left"><font size="11px">KETERANGAN</font></td>
				<td align="center"><font size="11px">Director</font></td>
			</tr>
			<tr>
				<td width="5" bgcolor="yellow"></td>
				<td colspan="2"><font size="11px"><strong>= KD / Rubah Ukuran</strong></font></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td width="650">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3"><font size="11px">LINOTI<br>Factory :<br>Jl. Sunan Mantingan No. 19 Rt 02 Rw 03 Dema'an Jepara 59419 Central Java - Indonesia<br>Phone : +62 291 5752560 Fax : +62 291 591790 email : info@linoti.com<br>http://www.linoti.com</font></td>
				<td align="center"><font size="11px"><strong><u>S.A</u></strong></font></td>
			</tr>
		</table></p>
  </div>
</body>
</html>
 