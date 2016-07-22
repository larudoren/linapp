<?php/*
	require(APPPATH.'plugins/libpdf/mc_table.php');
	
	class MY_PDF extends PDF_MC_Table {
		function myheader($po,$pi,$supplier,$customer,$tanggalbeli,$box1,$box2,$box3,$lshape){
		
			$this->SetMargins(1,1,1);
			$this->SetAutoPageBreak(TRUE, 0.5);
			$logo = base_url('asset/images/linoti.png');
			$this->Image($logo,0.9, 0.6,-350, -450);
			$this->SetFont('Arial','I',7);

			$this->Ln(1);
			$this->SetLineWidth(0.02);
			
			$this->SetFont('Times','B',14);
			$this->Cell(28, 0.7,'PURCHASE ORDER KE SUPPLIERS', 1, 1, 'C');
			
			$this->SetLineWidth(0.02);
			$this->Line(1,3.0,29,3.0);
			
			$this->Ln(0.3);
			$this->SetLineWidth(0.01);
			
			$this->SetFont('Times','B',8);
			
			# Header Cell Layout #
			
			$this->Cell(3, 0.4,'PO Number', 0, 0, 'L');					$this->Cell(0.5, 0.4,':', 0, 0, 'L');		$this->Cell(9, 0.4,$po, 0, 0, 'L');								$this->Cell(7,0.4,'',0,0,'L');				$this->Cell(2.5, 0.4,'PI Number', 0, 0, 'L');	$this->Cell(0.5, 0.4,':', 0, 0, 'L');			$this->Cell(1, 0.4,$pi, 0, 1, 'L');
			$this->Cell(3, 0.4,'Attention', 0, 0, 'L');					$this->Cell(0.5, 0.4,':', 0, 0, 'L');		$this->Cell(9, 0.4,$supplier, 0, 0, 'L');					$this->Cell(7,0.4,'',0,0,'L');				$this->Cell(2.5, 0.4,'Customer', 0, 0, 'L');		$this->Cell(0.5, 0.4,':', 0, 0, 'L');			$this->Cell(1, 0.4,$customer, 0, 1, 'L');
			$this->Cell(3, 0.4,'Date of Issue', 0, 0, 'L');			$this->Cell(0.5, 0.4,':', 0, 0, 'L');		$this->Cell(9, 0.4,$tanggalbeli, 0, 1, 'L');
			$this->Cell(3, 0.4,'Deadline', 0, 0, 'L');						$this->Cell(0.5, 0.4,':', 0, 0, 'L');		$this->Cell(1, 0.4,'-', 0, 1, 'L');
			
			$this->SetLineWidth(0.02);
			$this->Line(1,3.0,1,4.9);
			
			$this->Line(29,3.0,29,4.9);
			$this->Ln(0.15);
			
			$this->SetFont('Times','B',6.5);
			if ($box1==1 && $box2!=1 && $box3!=1){
				$this->MultiCell(5, 0.6,'Items', 1, 0, 'C',false);
				$this->MultiCell(2, 0.6,'Comercial Size', 1, 0, 'C',false);
				$this->MultiCell(1, 0.6,'Knock Down?', 1, 0, 'C',false);
				$this->MultiCell(3, 0.6,'Packing Remarks', 1, 0, 'C',false);
				if ($lshape==1){
					$this->MultiCell(10, 0.6,'Box 1', 1, 0, 'C',false);
				}else {
					$this->MultiCell(8, 0.6,'Box 1', 1, 0, 'C',false);
				}
				$this->MultiCell(2, 0.6,'Unit Price', 1, 0, 'C',false);
				$this->MultiCell(2, 0.6,'Update', 1, 1, 'C',false);
				
			} else if ($box1==1 && $box2==1 && $box3!=1){
				if ($lshape==1){
					
				}else {
					
				}
			} else if ($box1==1 && $box2==1 && $box3==1){
				if ($lshape==1){
					
				}else {
					
				}
			}
			/*
			$this->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
			$this->Cell(2, 1.6,'Code', 1, 0, 'C',false);
			$this->Cell(2, 1.6,'Merk', 1, 0, 'C',false);
			$this->Cell(11, 1.6,'Description', 1, 0, 'C',false);
			$this->Cell(1.3, 1.6,'Qty Need', 1, 0, 'C',false);
			$this->Cell(1.3, 1.6,'Stock', 1, 0, 'C',false);
			$this->Cell(1.3, 1.6,'Min Qty', 1, 0, 'C',false);
			$this->Cell(1.3,1.6,'Qty Order', 1, 0, 'C',false);
			$this->Cell(1.7, 1.6,'Unit Net Price', 1, 0, 'C',false);
			$this->Cell(2.5, 1.6,'Total Price', 1, 0, 'C',false);$startX = $this->getX();$startY = $this->getY();
			$this->Cell(3, 0.8,'In', 1, 1, 'C',false);
			*//*
		}
	}
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');

	$pdf = new MY_PDF('L','cm','A4');
	$pdf->AddPage();
	$pdf->SetTitle('Purchasing Order');
	
	$pdf->myheader($po,$pi,$supplier,$customer,$tanggalbeli,$box1,$box2,$box3,$lshape);
	
	
	
	$pdf->Output('Purchase Order - ', 'I');
		*/
	
?>