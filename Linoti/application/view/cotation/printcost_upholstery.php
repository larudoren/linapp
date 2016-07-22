<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	$waktuq = date('H i');
	
	$pdf = new FPDF('L','cm','A4');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetMargins(1,1,1);
	$pdf->AddPage();
	$totalPages = Ceil(count($data)/ 19);
	$logo = base_url('asset/images/linoti.png');
	$pdf->Image($logo,0.9, 0.6,-300, -350);
	$pdf->SetFont('Arial','I',7);
	//$pdf->Cell(28, 0.1, 'Printed on '.$tanggal.' '.$waktu.' By '.$this->session->userdata('nama_lengkap'), 0, 1, 'R');
	$pdf->Cell(28, 0.6, 'Page '.$pdf->PageNo().' of '.$totalPages.'', 0, 1, 'R');
	$pdf->Ln(1);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,2,29,2);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.1,29,2.1);
	$pdf->SetFont('Arial','',9);
	
	$pdf->SetLineWidth(0.04); 
	$pdf->Cell(32.2, 0.3,'', 0, 1, 'C');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(7, 0.8,'Code', 1, 0, 'C');$pdf->Cell(7, 0.8,'Collection', 1, 0, 'C');$pdf->Cell(7, 0.8,'Name', 1, 0, 'C');$pdf->Cell(7, 0.8,'Finishing', 1, 1, 'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(7, 0.8,$product_code, 1, 0, 'C');$pdf->Cell(7, 0.8,$collection, 1, 0, 'C');$pdf->Cell(7, 0.8,utf8_decode($name), 1, 0, 'C');$pdf->Cell(7, 0.8,$finishing, 1, 1, 'C');
	/*
	$pdf->Line(1,3,20,3); */
	//$pdf->Ln(0);
	$pdf->Cell(32.2, 0.3,'', 0, 1, 'C');
	//$pdf->SetLineWidth(0.04);
	//$pdf->Line(1,3.1,20,3.1);
	$pdf->Ln(0.2); 
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(28, 0.7,'COTATION UPHOLSTERY', 1, 1, 'C');
	
	//$pdf->SetLineWidth(0.04);
	//$pdf->Line(1,4.4,20,4.4);
	/*
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'To', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(9, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2.5, 0.4,'FROM', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(1, 0.4,'PT. CHAKRA NAGA', 0, 1, 'L');
	$pdf->Cell(2, 0.4,'Address', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2.5, 0.4,'', 0, 0, 'L');$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(1, 0.4,'Jl. Sunan Mantingan', 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'Phone', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2.5, 0.4,'', 0, 0, 'L');$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(1, 0.4,'No. 19/21 RT. 02/03 Jepara', 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'Fax', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2.5, 0.4,'ORDER', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(1, 0.4, '', 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'Mobile', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2.5, 0.4,'PO NUMBER', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(1, 0.4,'', 0, 1, 'L');
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,6.6,20,6.6);
	$pdf->Line(1,4.4,1,6.6);
	$pdf->Line(12.3,4.4,12.3,6.6);
	$pdf->Line(20,4.4,20,6.6);
	$pdf->Ln(0.15); */
	
	$pdf->SetFont('Arial','B',9);
	$pdf->MultiCell(1, 1.6,'No.', 1,0, 'C', false);$startX = $pdf->getX();$startY = $pdf->getY();$pdf->MultiCell(16, 0.8,'Material', 1, 0, 'C', false);/*$pdf->MultiCell(2, 0.8,'Kg(s) / Component', 1, 0, 'C',false);$pdf->MultiCell(2, 0.8,'Pc(s) / Component', 1, 0, 'C',false);*/$starXQuantity=$pdf->getX();$pdf->MultiCell(4, 1.6,'Qty', 1, 0, 'C',false);$pdf->MultiCell(2, 1.6,'Unit Price', 1, 0, 'C',false);$pdf->MultiCell(2,1.6,'PPN',1,0,'C',false); $pdf->MultiCell(3, 1.6,'Cost', 1, 1, 'C',false);
	/*$pdf->Cell(1, 0.8,'', 'LRB', 0, 'C'); */$pdf->setY($startY+0.8);$pdf->setX($startX);$pdf->MultiCell(2.5, 0.8,'Family', 1, 0, 'C',false);$pdf->MultiCell(13.5, 0.8,'Name', 1, 0, 'C',false);/*$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LBR', 1, 'C');*/
	$total_row = count($data);
	$count_row = 19-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$num = 1;
	$pdf->SetFont('Arial','',9);
	$mypage =0;
	if(count($data)>0)
	{
		$pdf->setY($startY+1.6);
		foreach($data as $dataresult)
		{ 
		
			if (($num % 20 == 0 && count($data) > 19) || ($num % 19 == 0 && count($data) <= 19)){
				$pdf->AddPage();
				$logo = base_url('asset/images/linoti.png');
				$pdf->Image($logo,0.9, 0.6,-300, -350);
				$pdf->SetFont('Arial','I',7);
				//$pdf->Cell(28, 0.1, 'Printed on '.$tanggal.' '.$waktu.' By '.$this->session->userdata('nama_lengkap'), 0, 1, 'R');
				$pdf->Cell(28, 0.6, 'Page '.$pdf->PageNo().' of '.$totalPages.'', 0, 1, 'R');
				$pdf->Ln(1);
				$pdf->SetLineWidth(0.04);
				$pdf->Line(1,2,29,2);
				$pdf->SetLineWidth(0.01);
				$pdf->Line(1,2.1,29,2.1);
				$pdf->SetFont('Arial','',9);
				
				$pdf->SetLineWidth(0.04); 
				$pdf->Cell(32.2, 0.3,'', 0, 1, 'C');
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(7, 0.8,'Code', 1, 0, 'C');$pdf->Cell(7, 0.8,'Collection', 1, 0, 'C');$pdf->Cell(7, 0.8,'Name', 1, 0, 'C');$pdf->Cell(7, 0.8,'Finishing', 1, 1, 'C');
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(7, 0.8,$product_code, 1, 0, 'C');$pdf->Cell(7, 0.8,$collection, 1, 0, 'C');$pdf->Cell(7, 0.8,$name, 1, 0, 'C');$pdf->Cell(7, 0.8,$finishing, 1, 1, 'C');

				$pdf->Cell(32.2, 0.3,'', 0, 1, 'C');
				
				$pdf->Ln(0.2); 
				
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(28, 0.7,'COTATION UPHOLSTERY', 1, 1, 'C');
				
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(1, 1.6,'No.', 1,0, 'C', false);$startX = $pdf->getX();$startY = $pdf->getY();$pdf->MultiCell(16, 0.8,'Material', 1, 0, 'C', false);/*$pdf->MultiCell(2, 0.8,'Kg(s) / Component', 1, 0, 'C',false);$pdf->MultiCell(2, 0.8,'Pc(s) / Component', 1, 0, 'C',false);*/$starXQuantity=$pdf->getX();$pdf->MultiCell(4, 1.6,'Qty', 1, 0, 'C',false);$pdf->MultiCell(2, 1.6,'Unit Price', 1, 0, 'C',false);$pdf->MultiCell(2,1.6,'PPN',1,0,'C',false); $pdf->MultiCell(3, 1.6,'Cost', 1, 1, 'C',false);
				/*$pdf->Cell(1, 0.8,'', 'LRB', 0, 'C'); */$pdf->setY($startY+0.8);$pdf->setX($startX);$pdf->MultiCell(2.5, 0.8,'Family', 1, 0, 'C',false);$pdf->MultiCell(13.5, 0.8,'Name', 1, 0, 'C',false);/*$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LBR', 1, 'C');*/
				$pdf->SetFont('Arial','',9);
				$pdf->setY($startY+1.6);
			}
			
			$Qty = '';
			$harga_unit = $dataresult['brg_harga'];
			$total_harga = 0;
			if ($dataresult['consumption_m']!=0){
				$Qty = $dataresult['consumption_m'].' m';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['consumption_m'];
				}
			} else if($dataresult['sqf25']!=0){
				$Qty = $dataresult['sqf25'].' sq ft';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['sqf25'];
				}
			} else if($dataresult['sqf28']!=0){
				$Qty = $dataresult['sqf28'].' sq ft';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['sqf28'];
				}
			} else if($dataresult['sqf3048']!=0){
				$Qty = $dataresult['sqf3048'].' sq ft';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['sqf3048'];
				}
			} else if($dataresult['runningmeter140']!=0){
				$Qty = $dataresult['runningmeter140'].' rm';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter140'];
				}
			} else if($dataresult['runningmeter150']!=0){
				$Qty = $dataresult['runningmeter150'].' rm';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter150'];
				}
			} else if($dataresult['runningmeter160']!=0){
				$Qty = $dataresult['runningmeter160'].' rm';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter160'];
				}
			} else if($dataresult['runningmeter047']!=0){
				$Qty = $dataresult['runningmeter047'].' m';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter047'];
				}
			} else if($dataresult['runningmeter050']!=0){
				$Qty = $dataresult['runningmeter050'].' m';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter050'];
				}
			} else if($dataresult['runningmeter057']!=0){
				$Qty = $dataresult['runningmeter057'].' m';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['runningmeter057'];
				}
			} else if($dataresult['kilo']!=0){
				$Qty = $dataresult['kilo'].' kg';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['kilo'];
				}
			} else if($dataresult['pieces']!=0){
				if (strpos(strtolower($dataresult['nama_barang']),'staples')!==false){
					$Qty = $dataresult['pieces'].' strip';
				} else {
					$Qty = $dataresult['pieces'].' pcs';
				}
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['pieces'];
				}
			} else if($dataresult['consumption_m2']!=0){
				$Qty = $dataresult['consumption_m2'].' m2';
				if ($harga_unit>0){
					$total_harga = $harga_unit * $dataresult['consumption_m2'];
				}
			}
			
			$harga='';
			if ($harga_unit>0){
				$harga = number_format($harga_unit,0,'.',',');
			}
			
			$harga_total ='';
			if ($total_harga>0){
				$harga_total = number_format($total_harga,0,'.',',');
			}
			
			$ppn = 'NO';
			if($dataresult['ppn']=='1'){
				$ppn ='YES';
			}
			
			$ttlrp = $ttlrp + $total_harga;
			
			$pdf->Cell(1, 0.6, $num, 1, 0, 'C');$pdf->Cell(2.5, 0.6, $dataresult['family'], 1, 0, 'C');$pdf->Cell(13.5, 0.6, $dataresult['nama_barang'], 1, 0, 'L');$pdf->MultiCell(4, 0.6,$Qty, 1, 0, 'C',false);$pdf->Cell(0.2, 0.6,'Rp', 'LTB', 0, 'L');$pdf->MultiCell(1.8, 0.6,$harga, 'TRB', 0, 'R',false);$pdf->MultiCell(2,0.6,$ppn,1,0,'C',false);$pdf->Cell(0.2, 0.6,'Rp', 'LTB', 0, 'L');$pdf->MultiCell(2.8, 0.6,$harga_total, 'TRB', 1, 'R',false);
			$startYline = $pdf->getY(); 
			/*
			if ($num==$total_row && $num % 20 !=0){
				
				//$pdf->SetLineWidth(0.04);
				//$pdf->Line(1,$startYline+0.1,29,$startYline+0.1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(48, 4, 'Departement UPHOLSTERY', 0, 1, 'C');
				$pdf->Cell(48, 1, '( . . . . . . . . . . . . . . . . . . . . . )', 0, 1, 'C');
			}
			*/			
			$num++;
			
		} 
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(25, 0.6, 'Total', 1, 0, 'R');$pdf->Cell(0.2, 0.6, 'Rp', 'LTB', 0, 'L');$pdf->Cell(2.8, 0.6, number_format($ttlrp,0,'.',','), 'TRB', 1, 'R');
		//$pdf->SetLineWidth(0.04);
		//		$pdf->Line(1,18,29,18);
	}
	//$pdf->Output('asset/'.$product_code.' '.$collection.' '.$name.' '.$finishing.' Upholstery '.$tanggal.' '.$waktuq.'.pdf', 'F'); // this line to auto store / save the aouput pdf file to the server
	$pdf->Output($product_code.' '.$collection.' '.$name.' '.$finishing.' Upholstery '.$tanggal.' '.$waktuq.'.pdf', 'I');
	
?>