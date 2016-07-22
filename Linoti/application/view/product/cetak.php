<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('L','cm','A4');
	
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Product '.$product_code);
	$pdf->SetMargins(1,1,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	//$myX = $pdf->GetX();
	//$myY = $pdf->GetY();
	//$pdf->SetFillColor(255, 215, 37);
	//$pdf->Rect(0, 0, 210, 297, 'F');
	//$pdf->SetX($myX);
	//$pdf->SetY($myY);
	//$logo = base_url('asset/images/linoti.png');
//	$pdf->Image($logo,0.9, 0.6,-300, -450);
	$pdf->SetFont('Arial','I',7);
//	$pdf->Cell(28, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	//$pdf->Ln(1);
	//$pdf->SetLineWidth(0.04);
	//$pdf->Line(1,2.3,29,2.3);
	//$pdf->SetLineWidth(0.01);
	//$pdf->Line(1,2.4,29,2.4);
	//$pdf->SetFont('Arial','',9);
	//$pdf->Cell(32.2, 1.2,'Jepara, '.$tgl_beli, 0, 1, 'C');
	//$pdf->Line(1,3,20,3);
	//$pdf->SetLineWidth(0.02);
	//$pdf->Line(1,3.1,20,3.1);
	//$pdf->Ln(0.2);
	
	$product_name			= '';
	$product_photo		= base_url('asset/product_photo/unknown.jpg');
	$category					= '';
	$cm_length				= '';
	$cm_width					= '';
	$cm_height				= '';
	$inch_length			= '';
	$inch_width				= '';
	$inch_height			= '';
	$weight_kg				= '';
	$weight_lbs				= '';
	$ext_qty					= '';
	$ext_qty2					= '';
	$ext_length				= '';
	$ext_length2			= '';
	$cm_seat					= '';
	$inch_seat				= '';
	$cm_clear					= '';
	$inch_clear				= '';
	$vol_m3						= '';
	$vol_cuft					= '';
	$qty_packing			= '';
	$qty_box					= '';
	$knock_down				= '';
	$gross_kg					= '';
	$gross_lbs				= '';
	$qty_20						= '';
	$qty_40						= '';
	$qty_40hc					= '';
	$prod_detail			= '';
	
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{
			$product_name			= $dataresult->product_name;
			if (!empty($dataresult->product_photo)){
				$product_photo		= base_url('asset/product_photo/'.$dataresult->product_photo);
			}
			$category					= $dataresult->category;
			$cm_length				= $dataresult->cm_length;
			$cm_width					= $dataresult->cm_width;
			$cm_height				= $dataresult->cm_height;
			$inch_length			= $dataresult->inch_length;
			$inch_width				= $dataresult->inch_width;
			$inch_height			= $dataresult->inch_height;
			$weight_kg				= $dataresult->weight_kg;
			$weight_lbs				= $dataresult->weight_lbs;
			$ext_qty					= $dataresult->ext_qty;
			$ext_qty2					= $dataresult->ext_qty2;
			$ext_length				= $dataresult->ext_length;
			$ext_length2			= $dataresult->ext_length2;
			$cm_seat					= $dataresult->cm_seat;
			$inch_seat				= $dataresult->inch_seat;
			$cm_clear					= $dataresult->cm_clear;
			$inch_clear				= $dataresult->inch_clear;
			$vol_m3						= $dataresult->vol_m3;
			$vol_cuft					= $dataresult->vol_cuft;
			$qty_packing			= $dataresult->qty_packing;
			$qty_box					= $dataresult->qty_box;
			$knock_down				= $dataresult->knock_down;
			$gross_kg					= $dataresult->gross_kg;
			$gross_lbs				= $dataresult->gross_lbs;
			if ($dataresult->qty_20 >0){
				$qty_20					= $dataresult->qty_20;
			}
			if ($dataresult->qty_40 >0){
				$qty_40					= $dataresult->qty_40;
			}
			if ($dataresult->qty_40hc >0){
				$qty_40hc				= $dataresult->qty_40hc;
			}
			$prod_detail			= $dataresult->prod_detail;
		}
	}
	
	$pdf->SetLineWidth(0.04);
	//$pdf->Line(18.5,0.6,26.0,0.6);
	
	//$pdf->Ln(0.3);
	//$pdf->SetLineWidth(0.01);
	//$pdf->Line(1,2.3,20,2.3);
	//$vproduct_photo
	
	
	$pdf->centreImage($product_photo,17.5, 0.6);
	$pdf->SetFont('Arial','B',14);
	//$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(9, 0.4,'', 0, 0, 'L');									$pdf->Cell(7,0.4,'',0,1,'L');		
	$pdf->Cell(6, 0.4,'Code', 0, 0, 'L');						$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$product_code, 0, 0, 'L');			$pdf->Cell(7,0.4,'',0,1,'L');				
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(11.5, 0.4,'', 0, 0, 'R');									$pdf->Cell(7,0.4,'',0,1,'L');				
	$pdf->Cell(6, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$coll_name, 0, 0, 'L');					$pdf->Cell(7,0.4,'',0,1,'L');				
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(9, 0.4,'', 0, 0, 'L');									$pdf->Cell(7,0.4,'',0,1,'L');				
	$pdf->Cell(6, 0.4,'Name', 0, 0, 'L');						$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->MultiCell(8, 0.4,$product_name, 0, 1, 'L', false);	
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(9, 0.4,'', 0, 0, 'L');									$pdf->Cell(7,0.4,'',0,1,'L');				
	$pdf->Cell(6, 0.4,'Category', 0, 0, 'L');				$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$category, 0, 0, 'L');					$pdf->Cell(7,0.4,'',0,1,'L');			
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(9, 0.4,'', 0, 0, 'L');									$pdf->Cell(7,0.4,'',0,1,'L');				
	
	$titleFrameX1 = 0.6; 
	$titleFrameX2 = 16.0; 
	$titleFrameY1 = 0.6; 
	$titleFrameY2 = 4.2; 
	
	$photoFrameX1 = 17.5; 
	$photoFrameX2 = 28.5; 
	$photoFrameY1 = 0.6; 
	$photoFrameY2 = 11.6; 
	
	$titleinFrameX1 = 0.7; 
	$titleinFrameX2 = 15.9; 
	$titleinFrameY1 = 0.7; 
	$titleinFrameY2 = 4.1; 
	
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX1,$photoFrameY2); // left photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX2,$photoFrameY1); // top photo frame line
	$pdf->Line($photoFrameX2,$photoFrameY1,$photoFrameX2,$photoFrameY2); // right photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY2,$photoFrameX2,$photoFrameY2); // bottom photo frame line
	
	if (strlen($product_name)>29){
		//$titleFrameY1 = $titleFrameY1 + 0.4;
		$titleFrameY2 = $titleFrameY2 + 0.4;
		
	//	$titleinFrameY1 = $titleinFrameY1 + 0.4;
		$titleinFrameY2 = $titleinFrameY2 + 0.4;
	}
	
	$pdf->Line($titleFrameX1,$titleFrameY1,$titleFrameX1,$titleFrameY2); // left frame line
	$pdf->Line($titleFrameX1,$titleFrameY1,$titleFrameX2,$titleFrameY1); // top frame line
	$pdf->Line($titleFrameX2,$titleFrameY1,$titleFrameX2,$titleFrameY2); // right frame line
	$pdf->Line($titleFrameX1,$titleFrameY2,$titleFrameX2,$titleFrameY2); // bottom frame line
	
	//$pdf->SetLineWidth(0.02);
	
	$pdf->Line($titleinFrameX1,$titleinFrameY1,$titleinFrameX1,$titleinFrameY2); // in left frame line
	$pdf->Line($titleinFrameX1,$titleinFrameY1,$titleinFrameX2,$titleinFrameY1); // in top frame line
	$pdf->Line($titleinFrameX2,$titleinFrameY1,$titleinFrameX2,$titleinFrameY2); // in right frame line
	$pdf->Line($titleinFrameX1,$titleinFrameY2,$titleinFrameX2,$titleinFrameY2); // in bottom frame line
	
	//$pdf->Ln(0.3);
	$myloop = 0;
	$pdf->Ln(1);
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(3, 0.4,'Product Sizes', 0, 1, 'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Overall', 0, 0, 'L'); 			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'L '.$cm_length.'   x   W '.$cm_width.'   x  H '.$cm_height.'  cm ', 0, 1, 'L');
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'L '.$inch_length.'  x   W '.$inch_width.'  x  H '.$inch_height.'  in ', 0, 1, 'L');
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Net Weight', 0, 0, 'L'); 	$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$weight_kg.'  kg', 0, 1, 'L');
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$weight_lbs.'  lbs', 0, 1, 'L');
	
	if ($ext_length>0){
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
		$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Extension', 0, 0, 'L'); 		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$ext_qty.'  pcs   x  '.$ext_length.'  cm', 0, 1, 'L');
		$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$ext_qty2.'  pcs   x  '.$ext_length2.'  in', 0, 1, 'L');
	} else {
		$myloop = $myloop+1;
	}
	
	if ($cm_seat>0){
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
		$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Seat Height', 0, 0, 'L'); 	$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$cm_seat.'  cm', 0, 1, 'L');
		$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$inch_seat.'  in', 0, 1, 'L');
	} else {
		$myloop = $myloop+1;
	}
	
	if ($cm_clear>0){
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
		$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Clearance', 0, 0, 'L'); 		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$cm_clear.'  cm', 0, 1, 'L');
		$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$inch_clear.'  in', 0, 1, 'L');
	} else {
		$myloop = $myloop+1;
	}
	
	for ($i=1;$i<=$myloop;$i++){
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
		$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
		$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
		$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
	}
	
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 						$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
	
	$pdf->SetFont('Arial','BU',12);
	$pdf->Cell(3, 0.4,'Packing', 0, 1, 'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 														$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
	$vbox = 'box';
	if ($qty_packing > 1){
		$vbox = 'boxes';
	}
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Qty', 0, 0, 'L'); 													$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$qty_packing.'  '.$vbox, 0, 0, 'L');				$pdf->Cell(6, 0.4,'', 0, 0, 'L');							$pdf->Cell(5.5, 0.4,'Packing Volume outter        ', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(3, 0.4,' '.$vol_m3.'  m3     '.$vol_cuft.'  cu ft', 0, 1, 'L');
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 														$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');																
	$vqty_20='';
	if (empty($qty_20)){
		$vqty_20 ='         ';
	}
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Qty product per box', 0, 0, 'L'); 					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$qty_box.'  pcs', 0, 0, 'L');											$pdf->Cell(6, 0.4,'', 0, 0, 'L');							$pdf->Cell(5.5, 0.4,"Qty inside container    20'  ", 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(3, 0.4,' '.$qty_20.$vqty_20.'  pcs     ', 0, 1, 'L');
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 														$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');																
	$vknock ='No';
	if ($knock_down==1){
		$vknock ='Yes';
	} 
	$vqty_40='';
	if (empty($qty_40)){
		$vqty_40 ='         ';
	}
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Knock Down', 0, 0, 'L'); 									$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$vknock, 0, 0, 'L');											$pdf->Cell(6, 0.4,'', 0, 0, 'L');							$pdf->Cell(5.5, 0.4,"                                      40'  ", 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(3, 0.4,' '.$qty_40.$vqty_40.'  pcs     ', 0, 1, 'L');
	$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 														$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');																
	$vqty_40hc='';
	if (empty($qty_40hc)){
		$vqty_40hc ='         ';
	}
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->Cell(4, 0.4,'Gross Weight', 0, 0, 'L'); 								$pdf->Cell(0.5, 0.4,':', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,' '.$gross_kg.'  kg    '.$gross_lbs.'  lbs', 0, 0, 'L');		$pdf->Cell(6, 0.4,'', 0, 0, 'L');							$pdf->Cell(5.5, 0.4,"                                      40'HC ", 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(3, 0.4,' '.$qty_40.$vqty_40hc.'  pcs     ', 0, 1, 'L');
	
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');				$pdf->Cell(3, 0.4,'', 0, 0, 'L'); 														$pdf->Cell(0.5, 0.4,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.4,'', 0, 1, 'L');
	
	if (!empty($prod_detail)){
		$pdf->SetFont('Arial','BU',12);
		$pdf->Cell(3, 0.4,'Product Details', 0, 1, 'L');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(3, 0.2,'', 0, 0, 'L');				$pdf->Cell(3, 0.2,'', 0, 0, 'L'); 												$pdf->Cell(0.5, 0.2,'', 0, 0, 'L'); 		$pdf->Cell(3, 0.2,'', 0, 1, 'L');
		$pdf->Cell(2, 0.4,'', 0, 0, 'L');				$pdf->MultiCell(4, 0.4,$prod_detail, 0, 1, 'L', false); 	
	}
	$pdf->SetLineWidth(0.04);
	
	//$pdf->Line(1,4.6,29,4.6);
	//$pdf->Line(18.5,0.6,18.5,11.2);
	//$pdf->Line(12.3,4.4,12.3,6.6);
	//$pdf->Line(29,3.0,29,4.6);
	//$pdf->Ln(0.15);
	//$pdf->Line(18.5,11.2,26.0,11.2);
	//$pdf->Line(26.0,0.6,26.0,11.2);
	$pdf->SetFont('Arial','B',6.5);
	
	
	$pdf->Output('Product - '.$product_code, 'I');
?>