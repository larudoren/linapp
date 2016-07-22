<?php
	$libpdf = '../libpdf/fpdf.php';
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('P','cm','A4');
	$pdf->SetMargins(1,1,1);
	$pdf->AddPage();
	$logo = base_url('asset/images/linoti.png');
	$pdf->Image($logo,0.9, 0.6,-450, -450);
	$pdf->SetFont('Arial','I',7);
	$pdf->Cell(19, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	$pdf->Ln(1);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.4,20,2.4);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(32.2, 1.2,'Jepara, '.$tgl_terima, 0, 1, 'C');
	$pdf->Line(1,3,20,3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,3.1,20,3.1);
	$pdf->Ln(0.2);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(19, 0.7,'BUKTI PENERIMAAN BARANG', 1, 1, 'C');
	
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,4.4,20,4.4);
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetFont('Arial','B',9);
	$address = character_limiter($alamat, 50);
	$address2= explode('&', $address);
	$pdf->Cell(2, 0.4,'TO', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(5.5, 0.4,'Linoti', 0, 0, 'L');$pdf->Cell(2, 0.4,'From', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(9, 0.4,$supplier, 0, 1, 'L');
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(5.5, 0.4,'Desa Karang Kebagusan', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Address', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(11.5, 0.4, $address2[0], 0, 1, 'L');
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');$pdf->Cell(5.5, 0.4,"RT 5 RW 1 - Jepara", 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Phone', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,$phone, 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'NO PO', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(5.5, 0.4, $po, 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Fax', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,$fax, 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2, 0.4,'', 0, 0, 'L');$pdf->Cell(0.5, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(5.5, 0.4,'', 0, 0, 'L');$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Mobile', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4,$mobile, 0, 1, 'L');
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,6.6,20,6.6);
	$pdf->Line(1,4.4,1,6.6);
	$pdf->Line(8.5,4.4,8.5,6.6);
	$pdf->Line(20,4.4,20,6.6);
	$pdf->Ln(0.15);
	
	$pdf->SetFont('Arial','B',7);
	
	$pdf->Cell(0.6, 0.8,'No.', 1, 0, 'C');$pdf->Cell(2, 0.8,'Code', 1, 0, 'C');$pdf->Cell(11.5, 0.8,'Deskripsi', 1, 0, 'C');$pdf->Cell(2, 0.8,'Jumlah', 1, 0, 'C');$pdf->Cell(3, 0.8,'Ket.', 1, 1, 'C');
	$total_row = $data->num_rows;
	$count_row = 26-$total_row;
	$total = 0;
	$num = 1;
	$pdf->SetFont('Arial','',7);
	if($data->num_rows>0)
	{
		foreach($data->result() as $dataresult)
		{
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
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out '.number_format($dataresult->size_diameter,1,',','.');
				} else {
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' out '.number_format($dataresult->size_diameter,0,',','.');
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
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in '.number_format($dataresult->size_diameterin,1,',','.');
				} else {
					$size = $size.html_entity_decode('&#216;', ENT_XHTML,"ISO-8859-1").' in '.number_format($dataresult->size_diameterin,0,',','.');
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
			$baris = 0.6;
			$barisremakrs=$baris;
			$pjg_remarks = strlen($dataresult->remarks);
			$pjg_nama = strlen($dataresult->nama_barang);
			$pjg_size = strlen($size);
			$pjg_finishing = strlen($dataresult->finishing);
			if ($pjg_remarks > 25) {
				$b_remarks = $baris;
				if ($pjg_nama > 52 || $pjg_size > 40 || $pjg_finishing > 36){
					$baris = $baris * 3;
				} else {
					$baris = $baris * 2;
				}
				$b_name = $baris;
				$b_size = $baris;
				$b_finishing = $baris;
			} elseif ($pjg_remarks > 50){
				if ($pjg_nama > 78 || $pjg_size > 60 || $pjg_finishing > 54){
					$baris = $baris * 4;
				} else {
					$baris = $baris * 3;
				}
			} else {
				//if ($pjg_nama > 26)
			}
			
			$pdf->Cell(0.6, $baris, $num, 1, 0, 'C');												 // Number
			$pdf->Cell(2, $baris, $dataresult->kode_barang_spc, 1, 0, 'C');  // Special Code
			$pdf->Cell(5, $baris, $dataresult->nama_barang, 1, 0, 'L');  		 // Name
			$pdf->Cell(4, $baris, $size, 1, 0, 'L');												 // Size
			$pdf->Cell(2.5, $baris, $dataresult->finishing, 1, 0, 'L');			 // Finishing
			$pdf->Cell(2, $baris, $dataresult->jml_terima.' '.$dataresult->unit_name, 1, 0, 'C'); // Qty Receive
			$pdf->MultiCell(3, $barisremakrs, $dataresult->remarks, 1, 1, 'L');  // Remarks
			
			
			$num++;
			$total=$total+$dataresult->jml_terima;
		}
		/*
		for($a=1; $a<=$count_row; $a++)
		{
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(6, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(3, 0.6,'', 1, 1, 'C');
		}
		*/
	}
	
	$pdf->SetFont('Arial','B',9);
	//$pdf->Cell(13, 0.6,'Total', 1, 0, 'C');$pdf->Cell(2, 0.6, $total, 1, 0, 'R');$pdf->Cell(4, 0.6,'', 1, 1, 'C');
	$pdf->Cell(19, 0.3,'', 0, 1, 'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(6.5, 0.6,'Penerima', 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6,'Mengetahui', 0, 1, 'C');
	$pdf->Cell(19, 0.8,'', 0, 1, 'C');
	$pdf->Cell(6.5, 0.6, $this->session->userdata('nama_lengkap'), 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6, '(                                            )', 0, 1, 'C');
	
	$pdf->Output($kode_terima.'_'.$tanggalterima.'-BPB.pdf', 'I');
?>