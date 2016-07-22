<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('P','cm','A4');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Accessories Card '.$product_code);
	$pdf->SetMargins(0.5,1,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	
	$logo = base_url('asset/images/linoti.png');
	$pdf->Image($logo,0.5, 0.6,-500, -600);
	$pdf->SetFont('Arial','I',7);
	//$pdf->Cell(20, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	$pdf->Ln(0.5);
	
	$pdf->SetFont('Arial','B',9);		
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');		$pdf->Cell(6, 0.4,'', 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Product Code', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$product_code, 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 1, 'L');	
	$pdf->Cell(3, 0.4,'Product Name', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,utf8_decode($product_name), 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Finishing', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$finishing, 0, 1, 'L');
	$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(1, 0.4,'', 0, 1, 'L');
	$pdf->Cell(3, 0.5,'Order', 0, 0, 'L');					$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
	$pdf->Cell(3, 0.5,'Qty', 0, 0, 'L');						$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
	
	if (empty($product_photo)){ 
		$photo = base_url('asset/product_photo/unknown.jpg');
	} else {
		$photo = base_url('asset/product_photo/'.$product_photo);
	}
	$pdf->centreImage1($photo,17.5, 1.9);
	//$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 0, 'L');								$pdf->Cell(2.5, 0.4,'Photo', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$product_photo, 0, 1, 'L');
	//$pdf->Line(0.6,1.4,20.5,1.4); // left photo frame line
	$photoFrameX1 = 17.5; 
	$photoFrameX2 = 20.5; 
	$photoFrameY1 = 1.9; 
	$photoFrameY2 = 4.9; 
	
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX1,$photoFrameY2); // left photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX2,$photoFrameY1); // top photo frame line
	$pdf->Line($photoFrameX2,$photoFrameY1,$photoFrameX2,$photoFrameY2); // right photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY2,$photoFrameX2,$photoFrameY2); // bottom photo frame line

	
	if($data_fit->num_rows>0)
	{
		$pdf->Ln(0.6);
	
		$pdf->SetFont('Arial','B',10);
		//$pdf->SetDrawColor(211,211,211);
		$posY = $pdf->GetY();
		$pdf->SetFillColor(211,211,211);
		$pdf->MultiCell(20, 0.8,'USE BY FITTING DEPARTMENT', 1, 1, 'L',true);
		
		//$pdf->Rect(0.6,$posY,20,$posY+0.8);
		//$pdf->SetY($posY);
		//$pdf->SetDrawColor(0,0,0);
		//$pdf->Line(0.5,$posY,0.5,$posY+0.8);
		//$pdf->Line(20.5,$posY,20.5,$posY+0.8);
		$pdf->SetFont('Arial','B',6.5);
		$pdf->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
		//$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
		$pdf->Cell(5.1, 1.6,'Description', 1, 0, 'C',false); $myX = $pdf->GetX(); $myY = $pdf->GetY();
		$pdf->Cell(6.3, 0.4,'Dimensions', 1, 0, 'C',false); $myX2 = $pdf->GetX();
		$pdf->SetY($myY+0.4); $pdf->SetX($myX); 
		$pdf->MultiCell(1, 0.4,'  Length  (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'     Width  (mm)  ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'        Height   (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in   (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'  '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out   or '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' head  (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'  Thread  ', 1, 0, 'C',false);
		$pdf->SetY($myY); $pdf->SetX($myX2);
		$pdf->MultiCell(2.7, 0.4,'                                         Finishing name from              Supplier                ', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'                      Qty  /         Item        ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              Qty  /    Order   ', 1, 0, 'C',false);
		//$pdf->Cell(1.3, 1.6,'ACC', 1, 0, 'C',false);
		$pdf->Cell(3, 1.6,'Remarks', 1, 1, 'C',false);

		$total_row = $data_fit->num_rows;
		$count_row = 14-$total_row;
		$ttldl = 0;
		$ttlrp = 0;
		$num = 1;
		$pdf->SetFont('Arial','',6.5);
		
		foreach($data_fit->result() as $dataresult)
		{
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
				}
			} else {
				$barisfin = $tgibaris;
				if (strlen($dataresult->finishing) > 23 && strlen($dataresult->finishing) <= 58){
					$tgibaris = $tgibaris * 2;
					//$barisfin = $tgibaris;
				} else if (strlen($dataresult->finishing) > 58){
					$tgibaris = $tgibaris * 3;
					//$barisfin = $tgibaris;
				}
				$barisdes = $tgibaris;
				
			}
			$pdf->Cell(0.6, $tgibaris, $num, 1, 0, 'C'); 										// No
			//$pdf->Cell(2, 0.6,$dataresult->kode_barang, 1, 0, 'C');													// Code
			$pdf->MultiCell(5.1,  $barisdes, iconv("UTF-8", "ISO-8859-1//IGNORE", $dataresult->nama_barang), 1, 0, 'L',false);	// Desciption
			if ($dataresult->size_length>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_length);
				$fraction = $dataresult->size_length - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,1,',','.'), 1, 0, 'C');	// Length
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,0,',','.'), 1, 0, 'C');	// Length
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_width>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_width);
				$fraction = $dataresult->size_width - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,1,',','.'), 1, 0, 'C');	// Width
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,0,',','.'), 1, 0, 'C');	// Width
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_height>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_height);
				$fraction = $dataresult->size_height - $whole;
				if ($fraction > 0 ){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,1,',','.'), 1, 0, 'C');	// Height
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,0,',','.'), 1, 0, 'C');	// Height
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameterin>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameterin);
				$fraction = $dataresult->size_diameterin - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,1,',','.'), 1, 0, 'C');	// Diameter in
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,0,',','.'), 1, 0, 'C');	// Diameter in
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameter>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameter);
				$fraction = $dataresult->size_diameter - $whole;
				if ($fraction > 0){
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,1,',','.'), 1, 0, 'C');	// Diameter Out
				} else {
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,0,',','.'), 1, 0, 'C');	// Diameter Out
				}
			} else {
				$pdf->Cell(1.3,  $tgibaris, '-', 1, 0, 'C');	
			}
			if (!empty($dataresult->size_thread)){
				$pdf->Cell(1,  $tgibaris, ''.$dataresult->size_thread, 1, 0, 'C');	// Thread
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');
			}
			$pdf->MultiCell(2.7,  $barisfin, $dataresult->finishing, 1, 0, 'L', false);	// Finished
			$whole = floor($dataresult->quantity);
			$fraction = $dataresult->quantity - $whole;
			$qty='';
			$qtystr='';
			if ($fraction > 0){
				$qtystr = ''.number_format($dataresult->quantity,3,',','.');
				if (substr($qtystr,-1)!='0'){
					$qty = ''.number_format($dataresult->quantity,3,',','.').' '.strtolower($dataresult->unit_name);
				} else if (substr($qtystr,-2,1)!='0'){
					$qty = ''.number_format($dataresult->quantity,2,',','.').' '.strtolower($dataresult->unit_name);
				} else {
					$qty = ''.number_format($dataresult->quantity,1,',','.').' '.strtolower($dataresult->unit_name);
				}
			} else {
				if ($dataresult->quantity >0 ){
					$qty = ''.$whole.' '.strtolower($dataresult->unit_name);
				} else {
					$qty = '';
				}
			}
			$pdf->Cell(1.3,  $tgibaris, $qty, 1, 0, 'C');		// Quantity
			$pdf->Cell(1, $tgibaris, '', 1, 0, 'C');												// Qty Order
			//$pdf->Cell(1.3,  $tgibaris, '', 1, 0, 'L');	// ACC
			$pdf->Cell(3,  $tgibaris, '', 1, 1, 'L');	// ACC
			$num++;
		} 
	}
	
	if ($data_ass->num_rows > 0){
		if ($data_fit->num_rows > 0){
			$pdf->AddPage();
			$logo = base_url('asset/images/linoti.png');
			$pdf->Image($logo,0.5, 0.6,-500, -600);
			$pdf->SetFont('Arial','I',7);
			//$pdf->Cell(20, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
			$pdf->Ln(0.5);
			
			$pdf->SetFont('Arial','B',9);		
			$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(6, 0.4,'', 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Product Code', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$product_code, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 1, 'L');	
			$pdf->Cell(3, 0.4,'Product Name', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$product_name, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Finishing', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$finishing, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(1, 0.4,'', 0, 1, 'L');
			$pdf->Cell(3, 0.5,'Order', 0, 0, 'L');					$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
			$pdf->Cell(3, 0.5,'Qty', 0, 0, 'L');						$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
			
			if (empty($product_photo)){ 
				$photo = base_url('asset/product_photo/unknown.jpg');
			} else {
				$photo = base_url('asset/product_photo/'.$product_photo);
			}
			$pdf->centreImage1($photo,17.5, 1.9);
			//$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 0, 'L');								$pdf->Cell(2.5, 0.4,'Photo', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$product_photo, 0, 1, 'L');
			//$pdf->Line(0.6,1.4,20.5,1.4); // left photo frame line
			$photoFrameX1 = 17.5; 
			$photoFrameX2 = 20.5; 
			$photoFrameY1 = 1.9; 
			$photoFrameY2 = 4.9; 
			
			$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX1,$photoFrameY2); // left photo frame line
			$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX2,$photoFrameY1); // top photo frame line
			$pdf->Line($photoFrameX2,$photoFrameY1,$photoFrameX2,$photoFrameY2); // right photo frame line
			$pdf->Line($photoFrameX1,$photoFrameY2,$photoFrameX2,$photoFrameY2); // bottom photo frame line
		}
		
		$pdf->Ln(0.6);
	
		$pdf->SetFont('Arial','B',10);
		//$pdf->SetDrawColor(211,211,211);
		//$posY = $pdf->GetY();
		$pdf->SetFillColor(211,211,211);
		$pdf->MultiCell(20, 0.7,'USE BY ASSEMBLING DEPARTMENT', 1, 1, 'L',true);
		$pdf->SetFont('Arial','B',6.5);
		//$pdf->SetDrawColor(0,0,0)
		$pdf->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
		//$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
		$pdf->Cell(5.1, 1.6,'Description', 1, 0, 'C',false); $myX = $pdf->GetX(); $myY = $pdf->GetY();
		$pdf->Cell(6.3, 0.4,'Dimensions', 1, 0, 'C',false); $myX2 = $pdf->GetX();
		$pdf->SetY($myY+0.4); $pdf->SetX($myX); 
		$pdf->MultiCell(1, 0.4,'  Length  (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'     Width  (mm)  ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'        Height   (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in   (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'  '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out   or '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' head  (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'  Thread  ', 1, 0, 'C',false);
		$pdf->SetY($myY); $pdf->SetX($myX2);
		$pdf->MultiCell(2.7, 0.4,'                                         Finishing name from              Supplier                ', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'                      Qty  /         Item        ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              Qty  /    Order   ', 1, 0, 'C',false);
		//$pdf->Cell(1.3, 1.6,'ACC', 1, 0, 'C',false);
		$pdf->Cell(3, 1.6,'Remarks', 1, 1, 'C',false);

		$total_row = $data_fit->num_rows;
		$count_row = 14-$total_row;
		$ttldl = 0;
		$ttlrp = 0;
		$num = 1;
		$pdf->SetFont('Arial','',6.5);
		
		foreach($data_ass->result() as $dataresult)
		{
			$tnama_barang = $dataresult->nama_barang;
			$tgibaris = 0.6;
			if (strlen($tnama_barang)>44){
				$barisdes = $tgibaris;
				if (strlen($tnama_barang)>90){
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
				}
			} else {
				$barisfin = $tgibaris;
				if (strlen($dataresult->finishing) > 23 && strlen($dataresult->finishing) <= 58){
					$tgibaris = $tgibaris * 2;
					//$barisfin = $tgibaris;
				} else if (strlen($dataresult->finishing) > 58){
					$tgibaris = $tgibaris * 3;
					//$barisfin = $tgibaris;
				}
				$barisdes = $tgibaris;
				
			}
			$pdf->Cell(0.6, $tgibaris, $num, 1, 0, 'C'); 										// No
			//$pdf->Cell(2, 0.6,$dataresult->kode_barang, 1, 0, 'C');													// Code
			$pdf->MultiCell(5.1,  $barisdes, iconv("UTF-8", "ISO-8859-1//IGNORE", $dataresult->nama_barang), 1, 0, 'L',false);	// Desciption
			if ($dataresult->size_length>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_length);
				$fraction = $dataresult->size_length - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,1,',','.'), 1, 0, 'C');	// Length
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,0,',','.'), 1, 0, 'C');	// Length
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_width>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_width);
				$fraction = $dataresult->size_width - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,1,',','.'), 1, 0, 'C');	// Width
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,0,',','.'), 1, 0, 'C');	// Width
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_height>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_height);
				$fraction = $dataresult->size_height - $whole;
				if ($fraction > 0 ){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,1,',','.'), 1, 0, 'C');	// Height
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,0,',','.'), 1, 0, 'C');	// Height
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameterin>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameterin);
				$fraction = $dataresult->size_diameterin - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,1,',','.'), 1, 0, 'C');	// Diameter in
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,0,',','.'), 1, 0, 'C');	// Diameter in
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameter>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameter);
				$fraction = $dataresult->size_diameter - $whole;
				if ($fraction > 0){
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,1,',','.'), 1, 0, 'C');	// Diameter Out
				} else {
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,0,',','.'), 1, 0, 'C');	// Diameter Out
				}
			} else {
				$pdf->Cell(1.3,  $tgibaris, '-', 1, 0, 'C');	
			}
			if (!empty($dataresult->size_thread)){
				$pdf->Cell(1,  $tgibaris, ''.$dataresult->size_thread, 1, 0, 'C');	// Thread
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');
			}
			$pdf->MultiCell(2.7,  $barisfin, urldecode($dataresult->finishing), 1, 0, 'L', false);	// Finished
			$whole = floor($dataresult->quantity);
			$fraction = $dataresult->quantity - $whole;
			$qty='';
			$qtystr='';
			if ($fraction > 0){
				$qtystr = ''.number_format($dataresult->quantity,3,',','.');
				if (substr($qtystr,-1)!='0'){
					$qty = ''.number_format($dataresult->quantity,3,',','.').' '.strtolower($dataresult->unit_name);
				} else if (substr($qtystr,-2,1)!='0'){
					$qty = ''.number_format($dataresult->quantity,2,',','.').' '.strtolower($dataresult->unit_name);
				} else {
					$qty = ''.number_format($dataresult->quantity,1,',','.').' '.strtolower($dataresult->unit_name);
				}
			} else {
				if ($dataresult->quantity >0 ){
					$qty = ''.$whole.' '.strtolower($dataresult->unit_name);
				} else {
					$qty = '';
				}
			}
			$pdf->Cell(1.3,  $tgibaris, $qty, 1, 0, 'C');		// Quantity
			$pdf->Cell(1, $tgibaris, '', 1, 0, 'C');												// Qty Order
			//$pdf->Cell(1.3,  $tgibaris, '', 1, 0, 'L');	// ACC
			$pdf->Cell(3,  $tgibaris, '', 1, 1, 'L');	// ACC
			$num++;
		}
	}
	
	if ($data_assfit->num_rows > 0){
		if ($data_ass->num_rows > 0 || $data_fit->num_rows > 0){
			$pdf->AddPage();
			$logo = base_url('asset/images/linoti.png');
			$pdf->Image($logo,0.5, 0.6,-500, -600);
			$pdf->SetFont('Arial','I',7);
			//$pdf->Cell(20, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
			$pdf->Ln(0.5);
			
			$pdf->SetFont('Arial','B',9);		
			$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(6, 0.4,'', 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Product Code', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$product_code, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 1, 'L');	
			$pdf->Cell(3, 0.4,'Product Name', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$product_name, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'Finishing', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$finishing, 0, 1, 'L');
			$pdf->Cell(3, 0.4,'', 0, 0, 'L');								$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');			$pdf->Cell(1, 0.4,'', 0, 1, 'L');
			$pdf->Cell(3, 0.5,'Order', 0, 0, 'L');					$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
			$pdf->Cell(3, 0.5,'Qty', 0, 0, 'L');						$pdf->Cell(0.5, 0.5,':', 0, 0, 'L');		$pdf->Cell(1, 0.5,'', 0, 1, 'L');
			
			if (empty($product_photo)){ 
				$photo = base_url('asset/product_photo/unknown.jpg');
			} else {
				$photo = base_url('asset/product_photo/'.$product_photo);
			}
			$pdf->centreImage1($photo,17.5, 1.9);
			//$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 0, 'L');								$pdf->Cell(2.5, 0.4,'Photo', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$product_photo, 0, 1, 'L');
			//$pdf->Line(0.6,1.4,20.5,1.4); // left photo frame line
			$photoFrameX1 = 17.5; 
			$photoFrameX2 = 20.5; 
			$photoFrameY1 = 1.9; 
			$photoFrameY2 = 4.9; 
			
			$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX1,$photoFrameY2); // left photo frame line
			$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX2,$photoFrameY1); // top photo frame line
			$pdf->Line($photoFrameX2,$photoFrameY1,$photoFrameX2,$photoFrameY2); // right photo frame line
			$pdf->Line($photoFrameX1,$photoFrameY2,$photoFrameX2,$photoFrameY2); // bottom photo frame line
		}
		
		$pdf->Ln(0.6);
	
		$pdf->SetFont('Arial','B',10);
		//$pdf->SetDrawColor(211,211,211);
		//$posY = $pdf->GetY();
		$pdf->SetFillColor(211,211,211);
		$pdf->MultiCell(20, 0.7,'USE BY ASSEMBLING DEPARTMENT AND USE AGAIN IN FITTING DEPARTMENT', 1, 1, 'L',true);
		$pdf->SetFont('Arial','B',6.5);
		//$pdf->SetDrawColor(0,0,0)
		$pdf->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
		//$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
		$pdf->Cell(5.1, 1.6,'Description', 1, 0, 'C',false); $myX = $pdf->GetX(); $myY = $pdf->GetY();
		$pdf->Cell(6.3, 0.4,'Dimensions', 1, 0, 'C',false); $myX2 = $pdf->GetX();
		$pdf->SetY($myY+0.4); $pdf->SetX($myX); 
		$pdf->MultiCell(1, 0.4,'  Length  (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'     Width  (mm)  ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'        Height   (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in   (mm)', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'  '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out   or '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' head  (mm) ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'  Thread  ', 1, 0, 'C',false);
		$pdf->SetY($myY); $pdf->SetX($myX2);
		$pdf->MultiCell(2.7, 0.4,'                                         Finishing name from              Supplier                ', 1, 0, 'C',false);
		$pdf->MultiCell(1.3, 0.4,'                      Qty  /         Item        ', 1, 0, 'C',false);
		$pdf->MultiCell(1, 0.4,'              Qty  /    Order   ', 1, 0, 'C',false);
		//$pdf->Cell(1.3, 1.6,'ACC', 1, 0, 'C',false);
		$pdf->Cell(3, 1.6,'Remarks', 1, 1, 'C',false);

		$total_row = $data_assfit->num_rows;
		$count_row = 14-$total_row;
		$ttldl = 0;
		$ttlrp = 0;
		$num = 1;
		$pdf->SetFont('Arial','',6.5);
		
		foreach($data_assfit->result() as $dataresult)
		{
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
				}
			} else {
				$barisfin = $tgibaris;
				if (strlen($dataresult->finishing) > 23 && strlen($dataresult->finishing) <= 58){
					$tgibaris = $tgibaris * 2;
					//$barisfin = $tgibaris;
				} else if (strlen($dataresult->finishing) > 58){
					$tgibaris = $tgibaris * 3;
					//$barisfin = $tgibaris;
				}
				$barisdes = $tgibaris;
				
			}
			$pdf->Cell(0.6, $tgibaris, $num, 1, 0, 'C'); 										// No
			//$pdf->Cell(2, 0.6,$dataresult->kode_barang, 1, 0, 'C');													// Code
			$pdf->MultiCell(5.1,  $barisdes, iconv("UTF-8", "ISO-8859-1//IGNORE", $dataresult->nama_barang), 1, 0, 'L',false);	// Desciption
			if ($dataresult->size_length>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_length);
				$fraction = $dataresult->size_length - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,1,',','.'), 1, 0, 'C');	// Length
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_length,0,',','.'), 1, 0, 'C');	// Length
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_width>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_width);
				$fraction = $dataresult->size_width - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,1,',','.'), 1, 0, 'C');	// Width
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_width,0,',','.'), 1, 0, 'C');	// Width
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_height>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_height);
				$fraction = $dataresult->size_height - $whole;
				if ($fraction > 0 ){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,1,',','.'), 1, 0, 'C');	// Height
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_height,0,',','.'), 1, 0, 'C');	// Height
				}
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameterin>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameterin);
				$fraction = $dataresult->size_diameterin - $whole;
				if ($fraction > 0){
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,1,',','.'), 1, 0, 'C');	// Diameter in
				} else {
					$pdf->Cell(1,  $tgibaris, number_format($dataresult->size_diameterin,0,',','.'), 1, 0, 'C');	// Diameter in
				}
			} else {
				$pdf->Cell(1, $tgibaris, '-', 1, 0, 'C');	
			}
			if ($dataresult->size_diameter>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($dataresult->size_diameter);
				$fraction = $dataresult->size_diameter - $whole;
				if ($fraction > 0){
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,1,',','.'), 1, 0, 'C');	// Diameter Out
				} else {
					$pdf->Cell(1.3,  $tgibaris, number_format($dataresult->size_diameter,0,',','.'), 1, 0, 'C');	// Diameter Out
				}
			} else {
				$pdf->Cell(1.3,  $tgibaris, '-', 1, 0, 'C');	
			}
			if (!empty($dataresult->size_thread)){
				$pdf->Cell(1,  $tgibaris, ''.$dataresult->size_thread, 1, 0, 'C');	// Thread
			} else {
				$pdf->Cell(1,  $tgibaris, '-', 1, 0, 'C');
			}
			$pdf->MultiCell(2.7,  $barisfin, $dataresult->finishing, 1, 0, 'L', false);	// Finished
			$whole = floor($dataresult->quantity);
			$fraction = $dataresult->quantity - $whole;
			$qty='';
			$qtystr='';
			if ($fraction > 0){
				$qtystr = ''.number_format($dataresult->quantity,3,',','.');
				if (substr($qtystr,-1)!='0'){
					$qty = ''.number_format($dataresult->quantity,3,',','.').' '.strtolower($dataresult->unit_name);
				} else if (substr($qtystr,-2,1)!='0'){
					$qty = ''.number_format($dataresult->quantity,2,',','.').' '.strtolower($dataresult->unit_name);
				} else {
					$qty = ''.number_format($dataresult->quantity,1,',','.').' '.strtolower($dataresult->unit_name);
				}
			} else {
				if ($dataresult->quantity >0 ){
					$qty = ''.$whole.' '.strtolower($dataresult->unit_name);
				} else {
					$qty = '';
				}
			}
			$pdf->Cell(1.3,  $tgibaris, $qty, 1, 0, 'C');		// Quantity
			$pdf->Cell(1, $tgibaris, '', 1, 0, 'C');												// Qty Order
			//$pdf->Cell(1.3,  $tgibaris, '', 1, 0, 'L');	// ACC
			$pdf->Cell(3,  $tgibaris, '', 1, 1, 'L');	// ACC
			$num++;
		}
	}
	
	$pdf->Output('Accessories Card - '.$product_code,'I');
?>