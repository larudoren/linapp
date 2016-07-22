<?php
	$libpdf = '../libpdf/fpdf.php';
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('P','cm','Letter');
	$pdf->SetMargins(0.5,0.3,0.5);
	$pdf->AddFont('DotMatrix','','DotMatrix.php');
	$pdf->AddPage();
	$pdf->SetFont('Dotmatrix','',14);
	$pdf->Cell(0, 0.5,'PT. CHAKRA NAGA FURNITURE', 0, 1, 'L');
	$pdf->SetFont('Dotmatrix','',5.4);
	$pdf->Cell(0, 0.2,'JL. SUNAN MANTINGAN 21 DEMAAN - JEPARA - CENTRAL JAVA INDONESIA', 0, 1, 'L');
	$pdf->Cell(0, 0.2,'TELEPHONE : +62 291 591741 / 3319780 FAX : +62 291 591790', 0, 1, 'L');
	$pdf->Cell(0, 0.2,'WWW.CHAKRANAGA.COM', 0, 1, 'L');
	
	$pdf->SetLineWidth(0.02);
	$pdf->Line(0.5,1.5,21.1,1.5);
	
	$pdf->SetFont('Dotmatrix','',12);
	$pdf->Ln(0.2);
	$pdf->Cell(0, 1,'FAKTUR PENGELUARAN BARANG', 0, 1, 'C');
	$pdf->SetFont('Dotmatrix','',11);
	$pdf->Cell(2.2, 0.4,'No.', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.34, 0.4, $kode_keluar, 0, 0, 'L');$pdf->Cell(2.2, 0.4,'From', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.34, 0.4, 'Logistic Dept', 0, 0, 'L');$pdf->Cell(2.2, 0.4,'To', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.41, 0.4, $departemen, 0, 1, 'L');
	$pdf->Cell(2.2, 0.4,'PI', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.34, 0.4, $pi, 0, 0, 'L');$pdf->Cell(2.2, 0.4,'Date', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.34, 0.4, $tgl_keluar, 0, 0, 'L');$pdf->Cell(2.2, 0.4,'Receiver', 0, 0, 'L');$pdf->Cell(0.3, 0.4,':', 0, 0, 'C');$pdf->Cell(4.41, 0.4, $receiver, 0, 0, 'L');
	
	$num=1;
	$pdf->Ln(0.6);
	$pdf->SetFont('Dotmatrix','',10);
	$pdf->Cell(1, 0.5,'NO', 1, 0, 'C');$pdf->Cell(3, 0.5,'CODE', 1, 0, 'C');$pdf->Cell(7.59, 0.5,'DESCRIPTION', 1, 0, 'C');$pdf->Cell(2, 0.5,'UNIT', 1, 0, 'C');$pdf->Cell(2, 0.5,'QTY', 1, 0, 'C');$pdf->Cell(5, 0.5,'REMARKS', 1, 1, 'C');
	$pdf->Ln(0.2);
	foreach($data->result() as $result) {
		$pdf->Cell(1, 0.57, $num, 0, 0, 'L');$pdf->Cell(3, 0.57, $result->kode_barang, 0, 0, 'L');$pdf->Cell(7.59, 0.57, $result->nama_barang, 0, 0, 'L');$pdf->Cell(2, 0.57, $result->unit_name, 0, 0, 'L');$pdf->Cell(2, 0.57, $result->jml_keluar, 0, 0, 'C');$pdf->Cell(5, 0.57, $result->remarks, 0, 1, 'L');
		$num++;
	}
	
	$pdf->Ln(0.7);
	$pdf->Cell(6.86, 0.5,'Receiver', 0, 0, 'C');$pdf->Cell(6.86, 0.5,'Checked', 0, 0, 'C');$pdf->Cell(6.87, 0.5,'Approved', 0, 0, 'C');
	$pdf->Ln(1.5);
	$pdf->Cell(6.86, 0.5, '(                  )', 0, 0, 'C');$pdf->Cell(6.86, 0.5, '(                  )', 0, 0, 'C');$pdf->Cell(6.87, 0.5, '(                  )', 0, 0, 'C');
	$pdf->Output($kode_keluar.'-FAKTUR PENGELUARAN', 'I');
?>