<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	$waktuq = date('H i');
	
	$pdf = new FPDF('L','cm','A4');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetMargins(1,1,1);
	$pdf->SetAutoPageBreak(TRUE, 0);
	$pdf->AddPage();
	$totalPages = Ceil($data->num_rows / 19);
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
	
	$pdf->SetFont('Arial','B',8);
	$pdf->MultiCell(1, 1.6,'No.', 1,0, 'C', false);$startX = $pdf->getX();$startY = $pdf->getY();$pdf->MultiCell(9, 0.8,'Component', 1,0, 'C', false);$pdf->MultiCell(10.4, 0.8,'Material', 1, 0, 'C', false);$pdf->MultiCell(3, 0.8,'Finished Size (mm)', 1, 0, 'C',false);$pdf->MultiCell(1, 1.6,'Kg(s)', 1, 0, 'C',false);/*$pdf->MultiCell(1, 1.6,'Pc(s)', 1, 0, 'C',false);*/$starXQuantity=$pdf->getX();$pdf->MultiCell(1.2, 1.6,'Qty', 1, 0, 'C',false);$pdf->MultiCell(1.2, 0.534,'Mat. Waste (%)', 1, 0, 'C',false);$pdf->MultiCell(1.2, 0.534,'Comp. Waste (%)', 1, 1, 'C',false);
	/*$pdf->Cell(1, 0.8,'', 'LRB', 0, 'C'); */$pdf->setY($startY+0.8);$pdf->setX($startX); $pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(2.5, 0.8,'Family', 1, 0, 'C',false);$pdf->MultiCell(7.9, 0.8,'Name', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'L', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'W', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'H', 1, 1, 'C',false);/*$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LBR', 1, 'C');*/
	$total_row = $data->num_rows;
	$count_row = 21-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$num = 1;
	$pdf->SetFont('Arial','',8);
	$mypage =0;
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{ 
			if ($num % 21 == 1 && $num >  1){
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
				
				$pdf->SetFont('Arial','B',8);
				$pdf->MultiCell(1, 1.6,'No.', 1,0, 'C', false);$startX = $pdf->getX();$startY = $pdf->getY();$pdf->MultiCell(9, 0.8,'Component', 1,0, 'C', false);$pdf->MultiCell(10.4, 0.8,'Material', 1, 0, 'C', false);$pdf->MultiCell(3, 0.8,'Finished Size (mm)', 1, 0, 'C',false);$pdf->MultiCell(1, 1.6,'Kg(s)', 1, 0, 'C',false);/*$pdf->MultiCell(1, 1.6,'Pc(s)', 1, 0, 'C',false);*/$starXQuantity=$pdf->getX();$pdf->MultiCell(1.2, 1.6,'Qty', 1, 0, 'C',false);$pdf->MultiCell(1.2, 0.534,'Mat. Waste (%)', 1, 0, 'C',false);$pdf->MultiCell(1.2, 0.534,'Comp. Waste (%)', 1, 1, 'C',false);
				$pdf->setY($startY+0.8);$pdf->setX($startX); $pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(3, 0.8,'', 1, 0, 'C',false);$pdf->MultiCell(2.5, 0.8,'Family', 1, 0, 'C',false);$pdf->MultiCell(7.9, 0.8,'Name', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'L', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'W', 1, 0, 'C',false);$pdf->MultiCell(1, 0.8,'H', 1, 1, 'C',false);/*$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(2, 0.8,'Component', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LRB', 0, 'C');$pdf->Cell(1.2, 0.8,'Waste', 'LBR', 1, 'C');*/
				$pdf->SetFont('Arial','',8);
			}
			if ($dataresult->length==0)
				$length ='';
			else
				$length = $dataresult->length;
			if ($dataresult->width==0)
				$width ='';
			else
				$width = $dataresult->width;
			if ($dataresult->height==0)
				$height ='';
			else
				$height = $dataresult->height;
			if ($dataresult->volume==0)
				$volume ='';
			else
				$volume = $dataresult->volume;
			if ($dataresult->inpieces==0)
				$inpieces ='';
			else
				$inpieces = $dataresult->inpieces;
			if ($dataresult->average_waste==0)
				$average_waste ='';
			else
				$average_waste = $dataresult->average_waste;
			if ($dataresult->special_waste==0)
				$special_waste ='';
			else
				$special_waste = $dataresult->special_waste;
			if ($dataresult->quantity==0)
				$quantity='';
			else
				$quantity = $dataresult->quantity;
			$pdf->Cell(1, 0.6, $num, 1, 0, 'C');$pdf->Cell(3, 0.6, urldecode($dataresult->komponen1), 1, 0, 'L');$pdf->Cell(3, 0.6, urldecode($dataresult->komponen2), 1, 0, 'L');$pdf->Cell(3, 0.6, urldecode($dataresult->komponen3), 1, 0, 'L');$pdf->Cell(2.5, 0.6, $dataresult->family, 1, 0, 'C');$pdf->Cell(7.9, 0.6, $dataresult->nama_barang, 1, 0, 'L');$pdf->Cell(1, 0.6, $length , 1, 0, 'C');$pdf->Cell(1, 0.6,$width, 1, 0, 'C');$pdf->Cell(1, 0.6, $height, 1, 0, 'C');$pdf->Cell(1, 0.6, $volume, 1, 0, 'C');/*$pdf->Cell(1, 0.6, $inpieces, 1, 0, 'C');*/$pdf->Cell(1.2, 0.6, $quantity, 1, 0, 'C');$pdf->Cell(1.2, 0.6, $average_waste, 1, 0, 'C');$pdf->Cell(1.2, 0.6, $special_waste, 1, 1, 'C');
			$startYline = $pdf->getY(); /*
			if ($num==$total_row && $num % 20 !=0){
				
				//$pdf->SetLineWidth(0.04);
				//$pdf->Line(1,$startYline+0.1,29,$startYline+0.1);
				$pdf->SetFont('Arial','B',8);
				$pdf->Cell(48, 4, 'Departement UPHOLSTERY', 0, 1, 'C');
				$pdf->Cell(48, 1, '( . . . . . . . . . . . . . . . . . . . . . )', 0, 1, 'C');
			} */
			$num++;

		}
		//$pdf->SetLineWidth(0.04);
		//		$pdf->Line(1,18,29,18);
	}
	//$pdf->Output('asset/'.$product_code.' '.$collection.' '.$name.' '.$finishing.' Upholstery '.$tanggal.' '.$waktuq.'.pdf', 'F'); // this line to auto store / save the aouput pdf file to the server
	$pdf->Output($product_code.' '.$collection.' '.$name.' '.$finishing.' Upholstery '.$tanggal.' '.$waktuq.'.pdf', 'I');
	
?>