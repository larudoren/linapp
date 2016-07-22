<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('L','cm','Legal');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Purchasing Order');
	$pdf->SetMargins(1,1,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	$logo = base_url('asset/images/linoti.png');
	$pdf->Image($logo,0.9, 0.6,-350, -450);
	$pdf->SetFont('Arial','I',7);
	//$pdf->Cell(28, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	$pdf->Ln(1);
	//$pdf->SetLineWidth(0.04);
	//$pdf->Line(1,2.3,29,2.3);
	//$pdf->SetLineWidth(0.01);
	//$pdf->Line(1,2.4,29,2.4);
	//$pdf->SetFont('Arial','',9);
	//$pdf->Cell(32.2, 1.2,'Jepara, '.$tgl_beli, 0, 1, 'C');
	//$pdf->Line(1,3,20,3);
	$pdf->SetLineWidth(0.02);
	//$pdf->Line(1,3.1,20,3.1);
	//$pdf->Ln(0.2);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(28, 0.7,'PURCHASE ORDER', 1, 1, 'C');
	
	$pdf->SetLineWidth(0.02);
	$pdf->Line(1,3.0,29,3.0);
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.01);
	//$pdf->Line(1,2.3,20,2.3);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(3, 0.4,'PO Number', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$po, 0, 0, 'L');								$pdf->Cell(7,0.4,'',0,0,'L');				$pdf->Cell(2.5, 0.4,'PI Number', 0, 0, 'L');	$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$pi, 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Attention', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$supplier, 0, 0, 'L');					$pdf->Cell(7,0.4,'',0,0,'L');				$pdf->Cell(2.5, 0.4,'Customer', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,strtoupper($customer), 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Date of Issue', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$tgl_beli, 0, 0, 'L');					$pdf->Cell(7,0.4,'',0,0,'L');				$pdf->Cell(2.5, 0.4,'Deadline', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,'', 0, 1, 'L');
	
	//$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.02);
	//$pdf->Line(1,4.6,29,4.6);
	$pdf->Line(1,3.0,1,4.6);
	//$pdf->Line(12.3,4.4,12.3,6.6);
	$pdf->Line(29,3.0,29,4.6);
	$pdf->Ln(0.15);
	
	$pdf->SetFont('Arial','B',6.5);
	
	$pdf->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Merk', 1, 0, 'C',false);
	$pdf->Cell(11, 1.6,'Description', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'Qty Need', 1, 0, 'C',false);
	$pdf->Cell(1, 1.6,'Stock', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'Min Qty', 1, 0, 'C',false);
	$pdf->Cell(1.3,1.6,'Qty Order', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Unit Net Price', 1, 0, 'C',false);
	$pdf->Cell(2.5, 1.6,'Total Price', 1, 0, 'C',false);$startX = $pdf->getX();$startY = $pdf->getY();
	$pdf->Cell(4.5, 0.8,'In', 1, 0, 'C',false);
	$pdf->Cell(3, 0.8,'Payment', 1, 1, 'C',false);
	
	$pdf->setY($startY+0.8);$pdf->setX($startX);
	$pdf->Cell(1.5, 0.8,'Date', 1, 0, 'C',false);
	$pdf->Cell(1.5, 0.8,'Qty', 1, 0, 'C',false);
	$pdf->Cell(1.5, 0.8,'Total Value', 1, 0, 'C',false);
	$pdf->Cell(1.5, 0.8,'Date', 1, 0, 'C',false);
	$pdf->Cell(1.5, 0.8,'Value', 1, 1, 'C',false);
	$total_row = $data->num_rows;
	$count_row = 14-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$num = 1;
	$pdf->SetFont('Arial','',6.5);
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{
			$totalharga = $dataresult->hargabeli*$dataresult->qty_order;
			if($dataresult->currency_name=='Rp') {
				$ttlrp = $ttlrp+$totalharga;
			}
			else {
				$ttldl = $ttldl+$totalharga;
			}
			$size ='';
			
			if ($dataresult->size_length > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_length);
				$fraction = $dataresult->size_length - $whole;
				if ($fraction > 0){
					$size = $size.'L '.number_format($dataresult->size_length,1,',','.').' x ';
				} else {
					$size = $size.'L '.number_format($dataresult->size_length,0,',','.').' x ';
				}
			}
					
			if ($dataresult->size_width > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_width);
				$fraction = $dataresult->size_width - $whole;
				if ($fraction > 0){
					$size = $size.'W '.number_format($dataresult->size_width,1,',','.').' x ';
				} else {
					$size = $size.'W '.number_format($dataresult->size_width,0,',','.').' x ';
				}
			}
					
			if ($dataresult->size_height > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_height);
				$fraction = $dataresult->size_height - $whole;
				if ($fraction > 0){
					$size = $size.'H '.number_format($dataresult->size_height,1,',','.').' x ';
				} else {
					$size = $size.'H '.number_format($dataresult->size_height,0,',','.').' x ';
				}
			}
			
			if ($size!=''){
				$size = substr($size,0,-3);
				if (empty($dataresult->size_length_unit)){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$dataresult->size_length_unit.'; ';
				}
			}
			
			if ($dataresult->size_diameter > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameter);
				$fraction = $dataresult->size_diameter - $whole;
				if ($fraction > 0){
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out   '.number_format($dataresult->size_diameter,1,',','.');
				} else {
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out   '.number_format($dataresult->size_diameter,0,',','.');
				}
				if (empty($dataresult->size_diameter_unit)){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$dataresult->size_diameter_unit.'; ';
				}
			}
					
			if ($dataresult->size_diameterin > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameterin);
				$fraction = $dataresult->size_diameterin - $whole;
				if ($fraction > 0){
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in   '.number_format($dataresult->size_diameterin,1,',','.');
				} else {
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in   '.number_format($dataresult->size_diameterin,0,',','.');
				}
				if (empty($dataresult->size_diameterin_unit)){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$dataresult->size_diameterin_unit.'; ';
				}
			}
			
			if ($dataresult->size_thread!=''){
				$size = $size.$dataresult->size_thread.'; ';
			}
			
			$tgibaris = 0.6;
			
			if (strlen($dataresult->nama_barang)>44){
				$barisdes = $tgibaris;
				if (strlen($dataresult->nama_barang)>90){
					$tgibaris = $tgibaris * 3;
				} else {
					$tgibaris = $tgibaris * 2;
				}
				
				$barisfin = $tgibaris;
				
				if (strlen($dataresult->finishing) > 58 && strlen($dataresult->finishing) <= 87){
					$tgibaris = 0.6 * 3;
					$barisdes = $tgibaris;
					$barisfin = $tgibaris;
				} else if (strlen($dataresult->finishing) > 87){
					$tgibaris = 0.6 * 4;
					$barisdes = $tgibaris;
					$barisfin = $tgibaris;
				} else {
					if (strlen($size) > 135 && strlen($size) <= 180){
						$tgibaris = 0.6 * 3;
						$barisdes = $tgibaris;
						$barisfin = $tgibaris;
					} elseif (strlen($size) > 180) {
						$tgibaris = 0.6 * 4;
						$barisdes = $tgibaris;
						$barisfin = $tgibaris;
					} 
				}
				
			} else {
				$barisfin = $tgibaris;
				if (strlen($dataresult->finishing) > 23 && strlen($dataresult->finishing) <= 58){
					$tgibaris = $tgibaris * 2;
					//$barisfin = $tgibaris;
				} else if (strlen($dataresult->finishing) > 58){
					$tgibaris = $tgibaris * 3;
					//$barisfin = $tgibaris;
				} else {
					
				}
				$barisdes = $tgibaris;
				
			}
			
			$pdf->Cell(0.6, $tgibaris, $num, 1, 0, 'C'); 										// No
			if (empty($dataresult->kode_barang_spc)){
				$pdf->Cell(2, $tgibaris,'-', 1, 0, 'C');													// Code
			} else {
				$pdf->Cell(2, $tgibaris,$dataresult->kode_barang_spc, 1, 0, 'C');													// Code
			}
			if (empty($dataresult->merk)){
				$pdf->Cell(2, $tgibaris,'-', 1, 0, 'C');													// Merk
			} else {
				$pdf->Cell(2, $tgibaris,$dataresult->merk, 1, 0, 'C');													// Merk
			}
			$pdf->MultiCell(5, $barisdes, $dataresult->nama_barang, 1, 0, 'L',false);	// Desciption
			if ($size==''){
				$pdf->MultiCell(3.5, $tgibaris, '-', 1, 0, 'L', false);												// Desciption
			} else {
				$pdf->MultiCell(3.5, $tgibaris, urldecode($size), 1, 0, 'L', false);												// Desciption
			}
			if (empty($dataresult->finishing)){
				$pdf->MultiCell(2.5, $tgibaris, '-', 1, 0, 'L', false);												// Desciption
			} else {
				$pdf->MultiCell(2.5, $tgibaris, $dataresult->finishing, 1, 0, 'L', false);												// Desciption
			}
			//if ($dataresult->jmlbeli > 0){
				$pdf->Cell(1.3, $tgibaris, $dataresult->jmlbeli.' '.$dataresult->unit_name, 1, 0, 'C');		// Qty Need
			//} else {
			//	$pdf->Cell(1.3, $tgibaris, $dataresult->jmlbeli, 1, 0, 'C');		// Qty Need
			//}
			$pdf->Cell(1, $tgibaris, '', 1, 0, 'C');												// Stock
			if ($dataresult->min_qty==0){
				$pdf->Cell(1.3, $tgibaris, ' '.$dataresult->unit_name, 1, 0, 'C');											// Min Qty
			} else { 
				$pdf->Cell(1.3, $tgibaris, number_format($dataresult->min_qty, 0, ',','.').' '.$dataresult->unit_name, 1, 0, 'C');											// Min Qty
			}
			if ($dataresult->qty_order==0){
				$pdf->Cell(1.3, $tgibaris, '', 1, 0, 'C'); // Qty Order
			} else {
				$pdf->Cell(1.3, $tgibaris, $dataresult->qty_order, 1, 0, 'C'); // Qty Order
			}
			
			$pdf->Cell(0.5, $tgibaris, $dataresult->currency_name, 'TLB', 0, 'L'); 
			if($dataresult->currency_name=='Rp'){ 
				if ($dataresult->hargabeli > 0){
					$pdf->Cell(1.5, $tgibaris, number_format($dataresult->hargabeli, 0,',','.'), 'TRB', 0, 'R');		// Unit Price Rp
				} else {
					$pdf->Cell(1.5, $tgibaris, '-', 'TRB', 0, 'R');		// Unit Price Rp
				}
			}else{
			  if ($dataresult->hargabeli > 0){
					$whole = 0;
					$fraction = 0.0; 
					$fraction_str='';
					$whole = floor ($dataresult->hargabeli);
					$fraction = $dataresult->hargabeli - $whole;
					$fraction_str = ''.number_format($dataresult->hargabeli, 3,',','.');
					if ($fraction > 0){
						if(substr($fraction_str,-1)!='0'){
							$pdf->Cell(1.5, $tgibaris, number_format($dataresult->hargabeli, 3,',','.'), 'TRB', 0, 'R');		// Unit Price $
						} elseif(substr($fraction_str,-2,1)!='0'){
							$pdf->Cell(1.5, $tgibaris, number_format($dataresult->hargabeli, 2,',','.'), 'TRB', 0, 'R');		// Unit Price $
						} else {
							$pdf->Cell(1.5, $tgibaris, number_format($dataresult->hargabeli, 1,',','.'), 'TRB', 0, 'R');		// Unit Price $
						}
					} else {
						$pdf->Cell(1.5, $tgibaris, number_format($dataresult->hargabeli, 0,',','.'), 'TRB', 0, 'R');		// Unit Price $
					}
				} else {
					$pdf->Cell(1.5, $tgibaris, '-', 'TRB', 0, 'R');		// Unit Price $
				}
			} 
			$pdf->Cell(0.5, $tgibaris, $dataresult->currency_name, 'TLB', 0, 'L'); 
			//if ($totalharga>0){
				if ($dataresult->currency_name=='Rp'){
					if ($totalharga > 0){
					$pdf->Cell(2, $tgibaris, number_format($totalharga, 0,',','.'), 'TRB', 0, 'R');		// Total Price Rp
					} else {
					$pdf->Cell(2, $tgibaris, '-', 'TRB', 0, 'R');		// Total Price Rp
					}
				} else {
					if ($totalharga > 0){
						$whole = 0;
						$fraction = 0.0; 
						$fraction_str='';
						$whole = floor ($totalharga);
						$fraction = $totalharga - $whole;
						$fraction_str = ''.number_format($totalharga, 3, ',','.');
						if ($fraction > 0){
							if (substr($fraction_str,-1)!='0'){
								$pdf->Cell(2, $tgibaris, number_format($totalharga, 3,',','.'), 'TRB', 0, 'R');		// Total Price $
							} elseif (substr($fraction_str,-2,1)!='0') {
								$pdf->Cell(2, $tgibaris, number_format($totalharga, 2,',','.'), 'TRB', 0, 'R');		// Total Price $
							} else {
								$pdf->Cell(2, $tgibaris, number_format($totalharga, 1,',','.'), 'TRB', 0, 'R');		// Total Price $
							}
						} else {
							$pdf->Cell(2, $tgibaris, number_format($totalharga, 0,',','.'), 'TRB', 0, 'R');		// Total Price $
						}
					} else {
						$pdf->Cell(2, $tgibaris, '-', 'TRB', 0, 'R');		// Total Price 0
					}
				}
			//} else {
			//	$pdf->Cell(1.5, $tgibaris, '-', 'TRB', 0, 'R');		// Total Price 0
			//}
			$pdf->Cell(1.5, $tgibaris, '', 1, 0, 'L');
			$pdf->Cell(1.5, $tgibaris, '', 1, 0, 'L');
			$pdf->Cell(1.5, $tgibaris, '', 1, 0, 'L');
			$pdf->Cell(1.5, $tgibaris, '', 1, 0, 'L');
			$pdf->Cell(1.5, $tgibaris, '', 1, 1, 'L');
			$num++;
			$matauang = $dataresult->currency_name;
		}
		for($a=1; $a<=$count_row; $a++)
		{
			$pdf->Cell(0.6, 0.6,'', 1, 0, 'C');
			$pdf->Cell(2, 0.6,'', 1, 0, 'C');
			$pdf->Cell(2, 0.6,'', 1, 0, 'C');
			$pdf->Cell(5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(3.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.3, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.3, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.3, 0.6,'', 1, 0, 'C');
			$pdf->Cell(2, 0.6,'', 1, 0, 'C');
			$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.5, 0.6,'', 1, 1, 'C');
		}
	}
	else
	{
		$ttlrp=0;
		$ttldl=0;
	}
	
	$pdf->SetFont('Arial','B',6.5);
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'Total Price', 1, 0, 'L');
	$pdf->Cell(0.5, 0.6,'Rp', 'LTB', 0, 'L');
	if ($ttlrp > 0){
		$pdf->Cell(2, 0.6, number_format($ttlrp, 0,',','.'), 'TRB', 1, 'R');
	} else {
		$pdf->Cell(2, 0.6, '-', 'TRB', 1, 'R');
	}
	//$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	if ($ttldl>0){
		$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
		$pdf->Cell(1.5, 0.6,'Total Price', 1, 0, 'L');
		$pdf->Cell(0.5, 0.6,'$', 'LTB', 0, 'L');
		$whole = 0;
		$fraction = 0.0; 
		$fraction_str='';
		$whole = floor ($ttldl);
		$fraction = $ttldl - $whole;
		$fraction_str = ''.number_format($ttldl, 3,',','.');
		if ($fraction > 0){
			if (substr($fraction_str,-1)!='0'){
				$pdf->Cell(2, 0.6, number_format($ttldl, 3,',','.'), 'TRB', 1, 'R');
			} elseif (substr($fraction_str,-2,1)!='0'){
				$pdf->Cell(2, 0.6, number_format($ttldl, 2,',','.'), 'TRB', 1, 'R');
			} else {
				$pdf->Cell(2, 0.6, number_format($ttldl, 1,',','.'), 'TRB', 1, 'R');
			}
		} else {
			$pdf->Cell(2, 0.6, number_format($ttldl, 0,',','.'), 'TRB', 1, 'R');
		}
	}
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'', 1, 0, 'C');
	$pdf->Cell(1, 0.6,'', 'LTB', 0, 'L');
	$pdf->Cell(1.5, 0.6, '', 'TRB', 1, 'R');
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'', 1, 0, 'C');
	$pdf->Cell(1, 0.6,'', 'LTB', 0, 'L');
	$pdf->Cell(1.5, 0.6, '', 'TRB', 1, 'R');
	//$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	#$pdf->Cell(7.5, 0.6,'Total ($)', 1, 0, 'R');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6, number_format($ttldl, 2), 1, 0, 'R');$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	$pdf->Cell(19, 0.6,'THANK YOU FOR YOUR COOPERATION', 0, 0, 'L');
	$pdf->Cell(7.5, 0.6,'', 0, 0, 'L');
	$pdf->Cell(1.5, 0.6,'Director', 0, 1, 'C');
	//$pdf->SetFont('Arial','',6.5);
	//$pdf->Cell(5.5, 0.6,'Purchasing Dept,', 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'Accounting Dept,', 0, 1, 'C');
	//$pdf->Cell(5.5, 0.6,'', 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'', 0, 1, 'C');
	//$pdf->SetFont('Arial','B',6.5);
	//$pdf->Cell(5.5, 0.6, $this->session->userdata('nama_lengkap'), 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'Sri Rahayu', 0, 1, 'C');
	//$pdf->SetFont('Arial','');
	//$pdf->Cell(5.5, 0.6,'', 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'Director', 0, 1, 'C');
	//$pdf->Cell(5.5, 0.6,'', 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'', 0, 1, 'C');
	//$pdf->SetFont('Arial','B',6.5);
	//$pdf->Cell(5.5, 0.5,'', 0, 0, 'C');$pdf->Cell(8, 0.6,'', 0, 0, 'C');$pdf->Cell(5.5, 0.6,'Stephane A.', 0, 1, 'C');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'LINOTI', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'Factory :', 0, 0, 'L');
	$pdf->Cell(7.5, 0.5,'', 0, 0, 'L');
	$pdf->SetFont('Arial','UB',6.5);
	$pdf->Cell(1.5, 0.5,'S.A', 0, 1, 'C');
	$pdf->SetFont('Arial','B',6.5);
	$pdf->Cell(19, 0.5,"Jl. Sunan Mantingan No. 19 Rt 02 Rw 03 Dema'an Jepara 59419 Central Java - Indonesia", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"Phone : +62 291 5752560 Fax : +62 291 591790 email : info@linoti.com", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"http://www.linoti.com", 0, 1, 'L');
	
	$pdf->Output('Purchase Order - '.$po, 'I');
?>