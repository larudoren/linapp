<?php
	$libpdf = '../libpdf/fpdf.php';
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	$pdf = new FPDF('P','cm','A4');
	$pdf->SetMargins(1,1,1);
	$pdf->AddPage();
	$logo = base_url('asset/images/chakranaga.jpg');
	$pdf->Image($logo,0.1, 0.6,-300, -450);
	$pdf->SetFont('Arial','I',7);
	$pdf->Cell(19, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
	$pdf->Ln(1);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.4,20,2.4);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(32.2, 1.2,'Jepara, '.$tgl_keluar, 0, 1, 'C');
	$pdf->Line(1,3,20,3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,3.1,20,3.1);
	$pdf->Ln(0.2);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(19, 0.7,'FAKTUR PENGELUARAN', 1, 1, 'C');
	
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,4.4,20,4.4);
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(2.7, 0.4,'KODE', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->SetFont('Arial','B',9);$pdf->Cell(5.5, 0.4, $kode_keluar, 0, 1, 'L');$pdf->SetFont('Arial','',9);//$pdf->Cell(2, 0.4,'From', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(9, 0.4, 'tes', 0, 1, 'L');
	$pdf->Cell(2.7, 0.4,'DEPARTEMEN', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->SetFont('Arial', '',9);$pdf->Cell(5.5, 0.4, $departemen, 0, 1, 'L');//$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Address', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(11.5, 0.4, 'tes', 0, 1, 'L');
	$pdf->Cell(2.7, 0.4,'CUSTOMER', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->Cell(5.5, 0.4, $customer, 0, 1, 'L');//$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Phone', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4, 'tes', 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	$pdf->Cell(2.7, 0.4,'PENERIMA', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->SetFont('Arial','',9);$pdf->Cell(5.5, 0.4, $receiver, 0, 1, 'L');//$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Fax', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(9, 0.4, 'tes', 0, 1, 'L');$pdf->SetFont('Arial','B',9);
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,6.2,20,6.2);
	$pdf->Line(1,4.4,1,6.2);
	//$pdf->Line(8.5,4.4,8.5,6.6);
	$pdf->Line(20,4.4,20,6.2);
	$pdf->Ln(0.15);
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(1.5, 0.8,'No.', 1, 0, 'C');$pdf->Cell(6, 0.8,'Deskripsi', 1, 0, 'C');$pdf->Cell(2, 0.8,'Jml', 1, 0, 'C');$pdf->Cell(1.5, 0.8,'Valuta', 1, 0, 'C');$pdf->Cell(2.5, 0.8,'Harga', 1, 0, 'C');$pdf->Cell(2.5, 0.8,'Total Harga', 1, 0, 'C');$pdf->Cell(3, 0.8,'Ket.', 1, 1, 'C');
	$total_row = $data->num_rows;
	$count_row = 27-$total_row;
	$jumlah = 0;
	$num = 1;
	$pdf->SetFont('Arial','',9);
	foreach($data->result() as $dataresult)
	{
		$totalharga = $dataresult->harga*$dataresult->jml_keluar;
		$jumlah += $totalharga;
		$pdf->Cell(1.5, 0.6, $num, 1, 0, 'C');$pdf->Cell(6, 0.6, $dataresult->nama_barang, 1, 0, 'L');$pdf->Cell(2, 0.6, $dataresult->jml_keluar, 1, 0, 'C');$pdf->Cell(1.5, 0.6, 'Rp', 1, 0, 'C');$pdf->Cell(2.5, 0.6, number_format($dataresult->harga), 1, 0, 'R');$pdf->Cell(2.5, 0.6, number_format($totalharga), 1, 0, 'R');$pdf->Cell(3, 0.6, '', 1, 1, 'L');
		$num++;
	}
	for($a=1; $a<=$count_row; $a++)
	{
		$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(6, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	}
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(7.5, 0.6,'Total', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6, 'Rp. '.number_format($jumlah), 1, 0, 'R');$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	$pdf->Cell(19, 1.5,'', 0, 1, 'C');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(6.5, 0.6,'Penerima', 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6, 'Logistik', 0, 1, 'C');
	$pdf->Cell(19, 0.8,'', 0, 1, 'C');
	$pdf->Cell(6.5, 0.6, $receiver, 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6, $this->session->userdata('nama_lengkap'), 0, 1, 'C');
	
	$pdf->Output($kode_keluar.'-FAKTUR PENGELUARAN', 'I');
?>