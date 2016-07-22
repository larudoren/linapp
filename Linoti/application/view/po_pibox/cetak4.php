<html>
	<head>
		<style type="text/css">
			body { 
				font-family:'times new roman';
				<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
				font-size:11px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
				font-size:7px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
				font-size:6px;
				<?php } ?>
			}   
			<!--
			table.print-friendly tr {
				page-break-inside: avoid !important;
			}
			table {
				border-collapse: collapse;
			}
			th, td {
				border: 0.5px solid black;
			} -->
			html{
				<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
				margin:15px 15px
				<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
				margin:15px 15px
				<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
				margin:10px 10px
				<?php } ?>
			}
			
			.main .container {
				padding: 0 0
			}
			
			.table {
				display: table;
				border-collapse: separate;
				border-spacing: 30px 0;
			}
			.row {
				display: table-row
			}
			.col {
				display: table-cell;
				background-color: #fff;
				padding: 30px;
			}
			.col.sidebar {
				width: 300px
			}
			
		</style>
	</head>
	<body>
		<div class="main">
			<div class="container">
				<div class="table-header">
				</div>
				<div class="table-content">
				</div>
				<div class="table-footer">
				</div>
			</div>
		</div>
	</body>
 </html>
<!--
<html>
	<head>
		<style type="text/css">
			body { 
				font-family:'times new roman';
				<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
				font-size:11px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
				font-size:7px;
				<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
				font-size:6px;
				<?php } ?>
			}   
			table.print-friendly tr {
				page-break-inside: avoid !important;
			}
			table {
				border-collapse: collapse;
			}
			th, td {
				border: 0.5px solid black;
			}
			html{
				<?php if ($box1!=0 && $box2==0 && $box3==0){ ?>
				margin:15px 15px
				<?php } elseif ($box1!=0 && $box2!=0 && $box3==0) { ?>
				margin:15px 15px
				<?php } elseif ($box1!=0 && $box2!=0 && $box3!=0) { ?>
				margin:10px 10px
				<?php } ?>
			}
		</style>
	</head>
	<body>
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
		<table border="0">
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
					<table class="print-friendly">
						<?php if ($box1==1 && $box2!=1 && $box3!=1){ ?>
						<tr>
							<?php if ($lshape==1) {?>
							<td colspan="29">
							<?php } else { ?>
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
										<td><?=$printdate?></td>
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
							<th rowspan="3" align="center" width="40" bgcolor="#C5BE97">Packing Remarks</td>
							<?php if ($lshape==1) {?>
							<th colspan="18" align="center" bgcolor="#C5BE97">Box 1</td>
							<?php } else { ?>
							<th colspan="16" align="center" bgcolor="#C5BE97">Box 1</td>
							<?php } ?>
							
							<th rowspan="2" align="center" width="40" bgcolor="#66FFFF">Unit<br/>Price</td>
							<th rowspan="2" align="center" width="35" bgcolor="#66FFFF">Update</td>
						</tr>
						<tr>
							<th rowspan="2" width="35" bgcolor="#f3f3f3">Code</th>
							<th rowspan="2" width="50" bgcolor="#f3f3f3">Image</th>
							<th rowspan="2" width="50" bgcolor="#f3f3f3">Collection</th>
							<th rowspan="2" width="80" bgcolor="#f3f3f3">Description</th>
							<th bgcolor="#C5BE97">Type</th>
							<th colspan="3" bgcolor="#C5BE97">Gap</th>
							<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
							<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
							<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
							<?php if ($lshape==1){ ?>
							<th rowspan="2" bgcolor="#C5BE97">L<br>Vertical</th>
							<th rowspan="2" bgcolor="#C5BE97">L<br>Horizontal</th>
							<?php } ?>
							<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
							<th rowspan="2" bgcolor="#FDE9D9">Qty Box</th>
							<th rowspan="2" bgcolor="#FDE9D9">Remarks</th>
						</tr>
						<tr>
							<th bgcolor="#92D050" width="20">L</th>
							<th bgcolor="#92D050" width="20">W</th>
							<th bgcolor="#92D050" width="20">H</th>
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
							<th bgcolor="#66FFFF"></th>
						</tr>
						<?php } elseif ($box1==1 && $box2==1 && $box3!=1) { ?>
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
										<td><?=$printdate?></td>
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
							<th rowspan="3" align="center" width="40" bgcolor="#C5BE97">Packing Remarks</td>
							<?php if($lshape==1) {?>
							<th colspan="18" align="center" bgcolor="#C5BE97">Box 1</td>
							<?php } else { ?>
							<th colspan="16" align="center" bgcolor="#C5BE97">Box 1</td>
							<?php } ?>
							<th colspan="16" align="center" bgcolor="#C5BE97">Box 2</td>
							
							<th rowspan="3" align="center" bgcolor="#C5BE97">Total<br/>Vol. Box<br/>Outer<br>Order</td>
							<th rowspan="2" colspan="2" align="center" width="60" bgcolor="#66FFFF">Unit<br/>Price</td>
							<th rowspan="2" align="center" width="30" bgcolor="#66FFFF">Update</td>
						</tr>
						<tr>
							<th rowspan="2" width="35" bgcolor="#f3f3f3">Code</th>
							<th rowspan="2" width="35" bgcolor="#f3f3f3">Image</th>
							<th rowspan="2" width="40" bgcolor="#f3f3f3">Collection</th>
							<th rowspan="2" width="70" bgcolor="#f3f3f3">Description</th>
							<th bgcolor="#C5BE97">Type</th>
							<th colspan="3" bgcolor="#C5BE97">Gap</th>
							<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
							<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
							<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
							<?php if($lshape==1){ ?>
							<th rowspan="2" bgcolor="#C5BE97">a</th>
							<th rowspan="2" bgcolor="#C5BE97">b</th>
							<?php } ?>
							<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
							<th rowspan="2" bgcolor="#FDE9D9">Qty Box 1</th>
							<th rowspan="2" bgcolor="#C5BE97">Remarks Box 1</th>
							<th bgcolor="#C5BE97">Type</th>
							<th colspan="3" bgcolor="#C5BE97">Gap</th>
							<th colspan="3" bgcolor="#FDE9D9">Inner Size (cm)</th>
							<th colspan="3" bgcolor="#C5BE97">+ Carton</th>
							<th colspan="3" bgcolor="#FDE9D9">Outer Size (cm)</th>
							<th rowspan="2" bgcolor="#C5BE97">Vol. Outer<br> / pcs</th>
							<th rowspan="2" bgcolor="#FDE9D9">Qty Box 2</th>
							<th rowspan="2" bgcolor="#C5BE97">Remarks Box 2</th>
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
							<th bgcolor="#66FFFF">Box 1</th>
							<th bgcolor="#66FFFF">Box 2</th>
							<th bgcolor="#66FFFF"></th>
						</tr>
						<?php } elseif ($box1==1 && $box2==1 && $box3==1) { ?>
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
										<td><?=$printdate?></td>
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
						
						if($data->num_rows>0){
							
							foreach($data->result() as $dataresult){
								if ($dataresult->product_photo!=''){
									$foto = '/xampp/htdocs/Linoti/asset/product_photo/'.$dataresult->product_photo;
								} else {
									$foto = '/xampp/htdocs/Linoti/asset/product_photo/unknown.jpg';
								}
								list($width, $height) = getimagesize($foto);
						?>
								<tr style="page-break-inside: avoid;">
									<td align="center"><?=$dataresult->product_code?></td>
									<td align="center">
										
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
									<td><?=$dataresult->coll_name?></td>
									<td><?=$dataresult->product_name?></td>
						<?php
									if ($dataresult->cm_length > 0){
										$whole = 0;
										$fraction = 0.0;
										$whole = floor($dataresult->cm_length);
										$fraction = $dataresult->cm_length - $whole;
										if ($fraction > 0){
						?>
											<td align="center"><?=number_format($dataresult->cm_length,1)?></td>
						<?php
										} else {
						?>
											<td align="center"><?=number_format($dataresult->cm_length,0)?></td>
						<?php
										}
									} else {
						?>
										<td></td>
						<?php
									}
									
									if ($dataresult->cm_width > 0){
										$whole = 0;
										$fraction = 0.0;
										$whole = floor($dataresult->cm_width);
										$fraction = $dataresult->cm_width - $whole;
										if ($fraction > 0){
						?>
											<td align="center"><?=number_format($dataresult->cm_width,1)?></td>
						<?php
										} else {
						?>
											<td align="center"><?=number_format($dataresult->cm_width,0)?></td>
						<?php
										}
									} else {
						?>
										<td></td>
						<?php
									}
									
									if ($dataresult->cm_height > 0){
										$whole = 0;
										$fraction = 0.0;
										$whole = floor($dataresult->cm_height);
										$fraction = $dataresult->cm_height - $whole;
										if ($fraction > 0){
						?>
											<td align="center"><?=number_format($dataresult->cm_height,1)?></td>
						<?php
										} else {
						?>
											<td align="center"><?=number_format($dataresult->cm_height,0)?></td>
						<?php
										}
									} else {
						?>
										<td></td>
						<?php
									}
									
									$textdetail = "SELECT E.boxnumber, E.kdown, E.remarks_packing, E.remarks, E.lstyrofoam, E.wstyrofoam, E.hstyrofoam, E.linner, E.winner, E.hinner, E.lkarton, E.wkarton, E.hkarton, E.louter,E.wouter, 
																				E.houter, E.volouter, A.qtybox, E.qtyperbox,E.typebox, F.currency_name, A.hrgbox, DATE_FORMAT(A.hrgdate,'%d-%b-%y') as hrgdate, E.asize, E.bsize
																 FROM d_belibox A
																 JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
																 JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
																 LEFT OUTER JOIN currency F ON F.currency_code=A.currency
																 WHERE A.po='".$dataresult->po."' AND A.product_code='".$dataresult->product_code."' AND A.companyarea='".$dataresult->companyarea."' ORDER BY E.boxnumber";
									$table =  $this->app_model->manualQuery($textdetail);
									$row = $table->num_rows();
									
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
												<td align="center"><?=$dt->kdown?></td>
												<td align="center"><?=$dt->remarks_packing?></td>
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
												
												if ($lshape==1){
													if ($dt->asize > 0){
														$whole = 0;
														$fraction = 0.0;
														$whole = floor($dt->asize);
														$fraction = $dt->asize - $whole;
														if ($fraction > 0){
							?>
												<td align="center"><?=number_format($dt->asize,1)?></td>
							<?php
														}else{
							?>
												<td align="center"><?=number_format($dt->asize,0)?></td>
							<?php
														}
													} else {
							?>
												<td></td>
							<?php
													}
													
													if ($dt->bsize > 0){
														$whole = 0;
														$fraction = 0.0;
														$whole = floor($dt->bsize);
														$fraction = $dt->bsize - $whole;
														if ($fraction > 0){
							?>
												<td align="center"><?=number_format($dt->bsize,1)?></td>
							<?php
														} else {
							?>
												<td align="center"><?=number_format($dt->bsize,0)?></td>
							<?php
														}
													}else{
							?>
												<td></td>
							<?php
													}
												}
							?>
												<td align="center"><?=$dt->volouter?></td>
												<td align="center"><?=$dt->qtybox?></td>
												<td align="center"><?=$dt->remarks?></td>
							<?php
												
											}elseif ($box1==1 && $box2==1 && $box3!=1){
												if ($tmp==1){
							?>
													<td align="center"><?=$dt->kdown?></td>
													<td align="center"><?=$dt->remarks_packing?></td>
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
											}elseif ($box1==1 && $box2==1 && $box3==1){
												if ($tmp==1){
							?>
													<td align="center"><?=$dt->kdown?></td>
													<td align="center"><?=$dt->remarks_packing?></td>
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
												<td align="center"><?=$currency.'  '.number_format($hrg1,0,'.',',')?></td>
							<?php
											} else {
							?>
												<td></td>
							<?php
											}
											
											if ($hrgdate!='' && $hrg1>0){
							?>
												<td align="center"><?=$hrgdate?></td>
							<?php
											} else {
							?>
												<td></td>
							<?php
											}
										}elseif ($box1==1 && $box2==1 && $box3!=1){
											if ($tmp-1<2){
												$tmp2=$tmp-1;
												while ($tmp2<2){
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
													$tmp2++;
												}
											}
							?>
											
											<td align="center"><?=($volbox1+$volbox2)?></td>
							<?php
											if ($hrg1>0){
							?>
												<td align="center"><?=$currency.'  '.number_format($hrg1,0,'.',',')?></td>
							<?php
											} else {
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
											
											if (($hrgdate!='' && $hrg1>0) || ($hrgdate!='' && $hrg2>0)){
							?>
												<td align="center"><?=$hrgdate?></td>
							<?php
											} else {
							?>
												<td></td>
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
							}
							
						}
						?>
					</table>
				</td>
			</tr>
		</table>
		<br/>
		<table border="0" width="95%">
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
		</table>
	</body>
</html>
-->
 