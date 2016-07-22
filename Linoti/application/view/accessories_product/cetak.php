<?php
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('L','cm','A5');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Accessories Card');
	$pdf->SetMargins(0.5,1,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	$logo = base_url('asset/images/linoti.png');
	$pdf->Image($logo,0.5, 0.6,-500, -600);
	$pdf->SetFont('Arial','I',7);
	//$pdf->Cell(20, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	$pdf->Ln(0.5);
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(3, 0.4,'PI Number', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$pi_number, 0, 1, 'L');			
	$pdf->Cell(3, 0.4,'Product Code', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$product_code, 0, 1, 'L');
	$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 1, 'L');	
	$pdf->Cell(3, 0.4,'Product Name', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,$product_name, 0, 1, 'L');
	
	if (empty($product_photo)){ 
		$photo = base_url('asset/product_photo/unknown.jpg');
	} else {
		$photo = base_url('asset/product_photo/'.$product_photo);
	}
	$pdf->centreImage1($photo,17.5, 0.5);
	//$pdf->Cell(3, 0.4,'Collection', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(6, 0.4,$coll_name, 0, 0, 'L');								$pdf->Cell(2.5, 0.4,'Photo', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$product_photo, 0, 1, 'L');
	
	$photoFrameX1 = 17.5; 
	$photoFrameX2 = 20.5; 
	$photoFrameY1 = 0.5; 
	$photoFrameY2 = 3.5; 
	
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX1,$photoFrameY2); // left photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY1,$photoFrameX2,$photoFrameY1); // top photo frame line
	$pdf->Line($photoFrameX2,$photoFrameY1,$photoFrameX2,$photoFrameY2); // right photo frame line
	$pdf->Line($photoFrameX1,$photoFrameY2,$photoFrameX2,$photoFrameY2); // bottom photo frame line
	
	$pdf->Ln(0.6);
	
	$pdf->SetFont('Arial','B',6);
	
	$pdf->MultiCell(0.6, 1.6,'No', 1, 0, 'C',false);
	//$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
	$pdf->Cell(6.8, 1.6,'Description', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'       Length   (mm)        ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'              Width   (mm)    ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'        Height   (mm)        ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'               '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in     (mm)    ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'              '.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out    (mm)    ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 1.6,'Thread', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'Finishing', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'              Qty  /     Pcs     ', 1, 0, 'C',false);
	$pdf->MultiCell(1, 0.4,'              Qty  /    Order   ', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'ACC', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Remarks', 1, 1, 'C',false);

	$total_row = $data->num_rows;
	$count_row = 14-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$num = 1;
	$pdf->SetFont('Arial','',6);
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{
			
			$pdf->Cell(0.6, 0.6, $num, 1, 0, 'C'); 										// No
			//$pdf->Cell(2, 0.6,$dataresult->kode_barang, 1, 0, 'C');													// Code
			$pdf->Cell(6.8, 0.6, $dataresult->nama_barang, 1, 0, 'L');	// Desciption
			if ($dataresult->size_length>0){
				$pdf->Cell(1, 0.6, number_format($dataresult->size_length,0), 1, 0, 'C');	// Length
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');	
			}
			if ($dataresult->size_width>0){
				$pdf->Cell(1, 0.6, number_format($dataresult->size_width,0), 1, 0, 'L');	// Width
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');	
			}
			if ($dataresult->size_height>0){
				$pdf->Cell(1, 0.6, number_format($dataresult->size_height,0), 1, 0, 'C');	// Height
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');	
			}
			if ($dataresult->size_diameterin>0){
				$pdf->Cell(1, 0.6, number_format($dataresult->size_diameterin,0), 1, 0, 'C');	// Diameter in
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');	
			}
			if ($dataresult->size_diameter>0){
				$pdf->Cell(1, 0.6, number_format($dataresult->size_diameter,0), 1, 0, 'C');	// Diameter Out
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');	
			}
			if (!empty($dataresult->size_thread)){
				$pdf->Cell(1, 0.6, 'M'.$dataresult->size_thread, 1, 0, 'C');	// Thread
			} else {
				$pdf->Cell(1, 0.6, '', 1, 0, 'L');
			}
			$pdf->Cell(1.3, 0.6, '', 1, 0, 'L');	// Finished
			$pdf->Cell(1, 0.6, $dataresult->quantity, 1, 0, 'C');		// Quantity
			$pdf->Cell(1, 0.6, $dataresult->quantity*$quantity, 1, 0, 'C');												// Qty Order
			$pdf->Cell(1.3, 0.6, '', 1, 0, 'L');	// ACC
			$pdf->Cell(2, 0.6, '', 1, 1, 'L');	// ACC
			$num++;
		} /* 
		for($a=1; $a<=$count_row; $a++)
		{
			$pdf->Cell(0.6, 0.6,'', 1, 0, 'C');
			$pdf->Cell(8.8, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.3, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1, 0.6,'', 1, 0, 'C');
			$pdf->Cell(1.3, 0.6,'', 1, 1, 'C');
		} */
	} /*
	else
	{
		$ttlrp=0;
		$ttldl=0;
	} */

	
	$pdf->Output('Accessories Card - '.$pi_number, 'I');
?>