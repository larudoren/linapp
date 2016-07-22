<?php
	//require(APPPATH.'plugins/libpdf/fpdf.php');
	require(APPPATH.'plugins/tcpdf/tcpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	//$pdf = new FPDF('L','cm','A4');
	$pdf = new TCPDF('L','cm','A4');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Purchasing Order');
	$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
	$pdf->SetMargins(1,0,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	$logo = base_url('asset/images/linoti.png');
	//$pdf->Image($logo,0.9, 0.6,-350, -450);
	$pdf->SetFont('Times','I',7);
	
	
	$pdf->SetFont('Times','B',6.5);
	
	$border='0.5';
	$html='<table width="100%">';
	$html .= '<tr>
							<td colspan="15" align="center" border="'.$border.'">
								<table>
									<tr>
										<td align="center"><font size="20">LINOTI</font></td>
									</tr>
									<tr>
										<td align="right">Jepara, '.$tanggalbeli.'&nbsp;&nbsp;&nbsp;&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="15" border="'.$border.'">
								<table border="0">
									<tr>
										<td width="70px">  Customer</td>
										<td width="5px">:</td>
										<td colspan="5" width="250px">'.$customer.'</td>
									</tr>
									<tr>
										<td width="70px">  Container Number</td>
										<td width="5px">:</td>
										<td colspan="5" width="250px">001</td>
									</tr>
									<tr>
										<td width="70px">  Loading Plan</td>
										<td width="5px">:</td>
										<td width="250px">'.$tglload.'</td>
										<td width="320px"></td>
										<td width="50px">PO. Number</td>
										<td width="5px">:</td>
										<td width="250px">'.$po.'</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="15" align="center" border="'.$border.'"></td>
						</tr>
						<tr>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>PHOTO</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>CODE</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1" width="135px"><strong><br>DESCRIPTION</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1" width="20px"><strong><br>QTY</strong></td>
							<td colspan="3" align="center" border="'.$border.'" bgcolor="#C5D9F1" width="120px"><strong>PACKING DIMENSION (cm)</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1" width="40px"><strong><br>TYPE BOX</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>KNOCK DOWN ?</strong></td>
							<td colspan="3" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>Keterangan Printing</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>Unit Price</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>Total Price</strong></td>
							<td rowspan="2" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong><br>Remarks</strong></td>
						</tr>
						<tr>
							<td rowspan="" align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>PKG.<br>WIDTH</strong></td>
							<td align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>PKG.<br>DEPT</strong></td>
							<td align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>PKG.<br>HEIGHT</strong></td>
							<td align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>Warning</strong></td>
							<td align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>Front</strong></td>
							<td align="center" border="'.$border.'" bgcolor="#C5D9F1"><strong>Simbol Khusus</strong></td>
						</tr>'; 
	
	$total_row = $data->num_rows;
	$count_row = 13-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$ttitem=0;
	$num = 1;
	$pdf->SetFont('Times','',6.5);
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{
			$totalharga = $dataresult->hrgbox*$dataresult->qtybox;
			$ttitem = $ttitem+$dataresult->qtybox;
			if ($dataresult->product_photo!=''){
				$foto = base_url('asset/product_photo/'.$dataresult->product_photo);
			} else {
				$foto = base_url('asset/product_photo/unknown.jpg');
			}
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
			
			$html .= '<tr>
										<td align="center" border="'.$border.'"><br><img src="'.$foto.'" width="40px" height="40px" /></td>
										<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->product_code.'</td>
										<td align="left" border="'.$border.'"><br><br><br> '.$dataresult->product_name.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->qtybox.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->linner.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->winner.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->hinner.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->typebox.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$dataresult->kdown.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$warning.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$front.'</td>
										<td align="left" border="'.$border.'" align="center"><br><br><br> '.$symbol.'</td>';
			if ($dataresult->hrgbox>0){
				$html	.=		'<td align="left" border="'.$border.'" align="center"><br><br><br> Rp. '.number_format($dataresult->hrgbox,0,'.',',').'</td>';
			} else {
				$html	.=		'<td align="left" border="'.$border.'" align="center"><br><br><br> Rp. -</td>';
			}
			
			if ($totalharga>0){
				$html	.=		'<td align="left" border="'.$border.'" align="center"><br><br><br> Rp. '.number_format($totalharga,0,'.',',').'</td>';
			} else {
				$html	.=		'<td align="left" border="'.$border.'" align="center"><br><br><br> Rp. -</td>';
			}
			$html	.=			'<td align="left" border="'.$border.'"><br><br><br>'.$dataresult->remarks.'</td>'; 
										
		
			
			if($dataresult->currency_name=='Rp') {
				$ttlrp = $ttlrp+$totalharga;
			}
			else {
				$ttldl = $ttldl+$totalharga;
			}
			
			$html .= '</tr>';
		}
		$html .= '<tr>
									<td align="left" border="'.$border.'" bgcolor="#C5D9F1"></td>
									<td align="center" border="'.$border.'" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"><strong><br>TOTAL</strong></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"><strong><br> '.$ttitem.'</strong></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"></td>
									<td align="left" border="'.$border.'" align="center" colspan="4" bgcolor="#C5D9F1"><strong><br>Total</strong></td>
									<td align="left" border="'.$border.'" align="center" bgcolor="#C5D9F1"><strong><br> Rp. '.number_format($ttlrp,0,'.',',').'</strong></td>
									<td align="left" border="'.$border.'" bgcolor="#C5D9F1"></td>
							</tr>'; 
	}
	else
	{
		$ttlrp=0;
		$ttldl=0;
	}
	
	
	$pdf->Ln(1);
	$html .= '</table>';
	$pdf->writeHtml($html);
	$pdf->Cell(19, 0.6,'', 0, 0, 'L');
	$pdf->Cell(6, 0.6,'', 0, 0, 'L');
	$pdf->Cell(1.5, 0.6,'Director', 0, 1, 'C');
	
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 0, 'L');
	$pdf->Cell(6, 0.5,'', 0, 0, 'L');
	$pdf->SetFont('Times','UB',6.5);
	$pdf->Cell(1.5, 0.5,'S.A', 0, 1, 'C');
	$pdf->SetFont('Times','B',6.5);
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	
	$filename = 'asset/po/'.$supplier.'/'.$po.'_'.$tanggal.'_email.pdf';
	if ($saveas!=''){
		$pdf->Output($filename, 'FI');
	} else {
		$pdf->Output($filename, 'I');
	}
	
?>