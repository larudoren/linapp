<?php
	$libpdf = '../libpdf/fpdf.php';
	require(APPPATH.'plugins/libpdf/fpdf.php');
	
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
	$pdf->Cell(32.2, 1.2,'Jepara, '.$tgl_indo, 0, 1, 'C');
	$pdf->Line(1,3,20,3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,3.1,20,3.1);
	$pdf->Ln(0.2);
	
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(19, 0.7,'STOK BARANG', 1, 1, 'C');
	
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,4.4,20,4.4);
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.01);
	$pdf->Line(1,2.3,20,2.3);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(2.7, 0.4,'PERIODE', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->Cell(5.5, 0.4, $periode1.' s/d '.$periode2, 0, 1, 'L');$pdf->SetFont('Arial','',9);//$pdf->Cell(2, 0.4,'From', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->Cell(9, 0.4, 'tes', 0, 1, 'L');
	$pdf->Cell(2.7, 0.4,'DEPARTEMEN', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'C');$pdf->SetFont('Arial', '',9);$pdf->Cell(5.5, 0.4, $filter, 0, 1, 'L');//$pdf->SetFont('Arial','B',9);$pdf->Cell(2, 0.4,'Address', 0, 0, 'L');$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');$pdf->SetFont('Arial','',9);$pdf->Cell(11.5, 0.4, 'tes', 0, 1, 'L');
	
	$pdf->Ln(0.3);
	$pdf->SetLineWidth(0.04);
	$pdf->Line(1,5.35,20,5.35);
	$pdf->Line(1,4.4,1,5.35);
	//$pdf->Line(8.5,4.4,8.5,6.6);
	$pdf->Line(20,4.4,20,5.35);
	$pdf->Ln(0.15);
	
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(1.5, 0.8,'NO', 1, 0, 'C');$pdf->Cell(3, 0.8,'KODE', 1, 0, 'C');$pdf->Cell(4.5, 0.8,'DESKRIPSI', 1, 0, 'C');$pdf->Cell(2, 0.8,'SATUAN', 1, 0, 'C');$pdf->Cell(2, 0.8,'AWAL', 1, 0, 'C');$pdf->Cell(2, 0.8,'MASUK', 1, 0, 'C');$pdf->Cell(2, 0.8,'KELUAR', 1, 0, 'C');$pdf->Cell(2, 0.8,'AKHIR', 1, 1, 'C');
	$total_row = $data->num_rows;
	$count_row = 35-$total_row;
	$jumlah = 0;
	$num = 1;
	$pdf->SetFont('Arial','',9);
	if($total_row>0){
		foreach($data->result() as $dataresult)
		{
			$awal = $this->app_model->CariStokAwal($dataresult->kode_barang,$tgl1);
			$terima = $this->app_model->CariJmlTerima($dataresult->kode_barang,$tgl1,$tgl2);
			$keluar = $this->app_model->CariJmlKeluar($dataresult->kode_barang,$tgl1,$tgl2);
			$stok = $this->app_model->CariStokAkhir($dataresult->kode_barang,$tgl1,$tgl2);
			
			if($awal=='') {
				$suwawal = 0;
			} else {
				$suwawal = $awal;
			}
			if($terima=='') {
				$sutrim = 0;
			} else {
				$sutrim = $terima;
			}
			if($keluar=='') {
				$sular = 0;
			} else {
				$sular = $keluar;
			}
			
			if($suwawal!=0) {
			$pdf->Cell(1.5, 0.6, $num, 1, 0, 'C');$pdf->Cell(3, 0.6, $dataresult->kode_barang, 1, 0, 'C');$pdf->Cell(4.5, 0.6, $dataresult->nama_barang, 1, 0, 'L');$pdf->Cell(2, 0.6, $dataresult->unit_name, 1, 0, 'L');$pdf->Cell(2, 0.6, $suwawal, 1, 0, 'R');$pdf->Cell(2, 0.6, $sutrim, 1, 0, 'R');$pdf->Cell(2, 0.6, $sular, 1, 0, 'R');$pdf->Cell(2, 0.6, $stok, 1, 1, 'R');
			}
			$num++;
		}
		for($a=1; $a<=$count_row; $a++)
		{
			$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(3, 0.6,'', 1, 0, 'C');$pdf->Cell(4.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 1, 'C');
		}
		/*
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(7.5, 0.6,'Total', 1, 0, 'C');$pdf->Cell(2, 0.6,'', 1, 0, 'C');$pdf->Cell(1.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6,'', 1, 0, 'C');$pdf->Cell(2.5, 0.6, number_format($jumlah), 1, 0, 'R');$pdf->Cell(3, 0.6,'', 1, 1, 'C');
		$pdf->Cell(19, 1.5,'', 0, 1, 'C');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(6.5, 0.6,'Penerima', 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6,'Supplier', 0, 1, 'C');
		$pdf->Cell(19, 0.8,'', 0, 1, 'C');
		$pdf->Cell(6.5, 0.6, '', 0, 0, 'C');$pdf->Cell(6, 0.6,'', 0, 0, 'C');$pdf->Cell(6.5, 0.6, '', 0, 1, 'C');
		*/
	}
	
	$pdf->Output($tanggal.'-STOK BARANG', 'I');
?>