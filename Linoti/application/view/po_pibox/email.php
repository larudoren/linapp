<html>
	<head>
		<style type="text/css">
			body { 
				font-family:'times new roman';
				font-size:11px;
			}   
			table {
				border-collapse: collapse;
			}
			th, td {
				border: 0.5px solid black;
			}
			html{
				margin:20px 20px
			}
		</style>
	</head>
	<body>
		<table>
			<tr>
				<td colspan="15">
					<table width="100%" border="0">
						<tr>
							<td align="center"><font size="16px">LINOTI</font></td>
						</tr>
						<tr>
							<td align="right"><font size="9px">Jepara, <?=$tanggalbeli?>&nbsp;&nbsp;</font></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="15">
					<table width="100%" border="0">
						<tr>
							<td width="50">Customer</td>
							<td width="5">:</td>
							<td colspan="5"><?=$customer?></td>
						</tr>
						<tr>
							<td>Container Number</td>
							<td>:</td>
							<td colspan="5">001</td>
						</tr>
						<tr>
							<td>Loading Plan</td>
							<td>:</td>
							<td><?=$tglload?></td>
							<td width="500">&nbsp;</td>
							<td width="50">PO Number</td>
							<td width="5">:</td>
							<td><?=$po?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th rowspan="2" bgcolor="#C5D9F1">PHOTO</th>
				<th rowspan="2" bgcolor="#C5D9F1">CODE</th>
				<th rowspan="2" bgcolor="#C5D9F1">DESCRIPTION</th>
				<th rowspan="2" bgcolor="#C5D9F1">QTY</th>
				<th colspan="3" bgcolor="#C5D9F1">PACKING DIMENSION (cm)</th>
				<th rowspan="2" bgcolor="#C5D9F1">TYPE BOX</th>
				<th rowspan="2" bgcolor="#C5D9F1">KNOCK DOWN ?</th>
				<th colspan="3" bgcolor="#C5D9F1">Keterangan Printing</th>
				<th rowspan="2" bgcolor="#C5D9F1">Unit Price</th>
				<th rowspan="2" bgcolor="#C5D9F1">Total Price</th>
				<th rowspan="2" bgcolor="#C5D9F1">Remarks</th>
			</tr>
			<tr>
				<th bgcolor="#C5D9F1">PKG.<br/>WIDTH</th>
				<th bgcolor="#C5D9F1">PKG.<br/>DEPT</th>
				<th bgcolor="#C5D9F1">PKG.<br/>HEIGHT</th>
				<th bgcolor="#C5D9F1">Warning</th>
				<th bgcolor="#C5D9F1">Front</th>
				<th bgcolor="#C5D9F1">Simbol Khusus</th>
			</tr>
<?php
	$ttldl = 0;
	$ttlrp = 0;
	$ttitem=0;
	$num = 1;
	if($data->num_rows>0){
		foreach($data->result() as $dataresult){
			if ($num>1 && $num%11==0){
?>
			<tr>
				<td colspan="15" height="60px" style="border:0">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="15">
					<table width="100%" border="0">
						<tr>
							<td align="center"><font size="16px">LINOTI</font></td>
						</tr>
						<tr>
							<td align="right"><font size="9px">Jepara, <?=$tanggalbeli?>&nbsp;&nbsp;</font></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="15">
					<table width="100%" border="0">
						<tr>
							<td width="50">Customer</td>
							<td width="5">:</td>
							<td colspan="5"><?=$customer?></td>
						</tr>
						<tr>
							<td>Container Number</td>
							<td>:</td>
							<td colspan="5">001</td>
						</tr>
						<tr>
							<td>Loading Plan</td>
							<td>:</td>
							<td><?=$tglload?></td>
							<td width="500">&nbsp;</td>
							<td width="50">PO Number</td>
							<td width="5">:</td>
							<td><?=$po?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th rowspan="2" bgcolor="#C5D9F1">PHOTO</th>
				<th rowspan="2" bgcolor="#C5D9F1">CODE</th>
				<th rowspan="2" bgcolor="#C5D9F1">DESCRIPTION</th>
				<th rowspan="2" bgcolor="#C5D9F1">QTY</th>
				<th colspan="3" bgcolor="#C5D9F1">PACKING DIMENSION (cm)</th>
				<th rowspan="2" bgcolor="#C5D9F1">TYPE BOX</th>
				<th rowspan="2" bgcolor="#C5D9F1">KNOCK DOWN ?</th>
				<th colspan="3" bgcolor="#C5D9F1">Keterangan Printing</th>
				<th rowspan="2" bgcolor="#C5D9F1">Unit Price</th>
				<th rowspan="2" bgcolor="#C5D9F1">Total Price</th>
				<th rowspan="2" bgcolor="#C5D9F1">Remarks</th>
			</tr>
			<tr>
				<th bgcolor="#C5D9F1">PKG.<br/>WIDTH</th>
				<th bgcolor="#C5D9F1">PKG.<br/>DEPT</th>
				<th bgcolor="#C5D9F1">PKG.<br/>HEIGHT</th>
				<th bgcolor="#C5D9F1">Warning</th>
				<th bgcolor="#C5D9F1">Front</th>
				<th bgcolor="#C5D9F1">Simbol Khusus</th>
			</tr>
<?php
			}
			$totalharga = $dataresult->hrgbox*$dataresult->qtybox;
			$ttitem = $ttitem+$dataresult->qtybox;
			if ($dataresult->product_photo!=''){
				$foto = '/xampp/htdocs/Linoti/asset/product_photo/'.$dataresult->product_photo;
			} else {
				$foto = '/xampp/htdocs/Linoti/asset/product_photo/unknown.jpg';
			}
			list($width, $height) = getimagesize($foto);
			
			if ($dataresult->print_warning=='Y'){
				$warning = 'Yes';
			} else {
				$warning = 'No';
			}
			
			if ($dataresult->print_front=='Y'){
				$front = 'Yes';
			} else {
				$front = 'No';
			}
			
			if ($dataresult->print_symbol=='Y'){
				$symbol = 'Yes';
			} else {
				$symbol = 'No';
			}
?>
			<tr>
				<td align="center">
					<?php if ($width >= $height){ ?>
					<img src="<?=$foto?>" width="60px"/>
					<?php } else { ?>
					<img src="<?=$foto?>" height="60px" />
					<?php } ?>
				</td>
				<td align="center"><?=$dataresult->product_code?></td>
				<td align="left"><?=$dataresult->product_name?></td>
				<td align="center"><?=$dataresult->qtybox?></td>
				<td align="center"><?=$dataresult->linner?></td>
				<td align="center"><?=$dataresult->winner?></td>
				<td align="center"><?=$dataresult->hinner?></td>
				<td align="center"><?=$dataresult->typebox?></td>
				<td align="center"><?=$dataresult->kdown?></td>
				<td align="center"><?=$warning?></td>
				<td align="center"><?=$front?></td>
				<td align="center"><?=$symbol?></td>
<?php
			if ($dataresult->hrgbox>0){
?>
				<td align="center"> Rp. <?=number_format($dataresult->hrgbox,0,'.',',')?></td>
<?php
			} else {
?>
				<td align="center"> Rp. -</td>
<?php
			}
			
			if ($totalharga>0){
?>
				<td align="center"> Rp. <?=number_format($totalharga,0,'.',',')?></td>
<?php
			} else {
?>
				<td align="center"> Rp. -</td>
<?php
			}
?>
			  <td align="left"><?=$dataresult->remarks?></td>
<?php										
		
			
			if($dataresult->currency_name=='Rp') {
				$ttlrp = $ttlrp+$totalharga;
			}
			else {
				$ttldl = $ttldl+$totalharga;
			}
?>
			</tr>
<?php
			$num++;
		}
?>
			<tr>
				<td align="left"bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"><strong>TOTAL</strong></td>
				<td align="center" bgcolor="#C5D9F1"><strong><?=$ttitem?></strong></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" bgcolor="#C5D9F1"></td>
				<td align="center" colspan="4" bgcolor="#C5D9F1"><strong>Total</strong></td>
				<td align="center" bgcolor="#C5D9F1"><strong>Rp. <?=number_format($ttlrp,0,'.',',')?></strong></td>
				<td align="left" bgcolor="#C5D9F1"></td>
			</tr>
<?php
	}
?>
		</table>
	</body>
</html>