<?php
	//require(APPPATH.'plugins/libpdf/fpdf.php');
	require(APPPATH.'plugins/tcpdf/tcpdf.php');
	
	date_default_timezone_set ('Asia/Jakarta');
	$tanggal = date('Y-m-d');
	$waktu = date('H:i:s');
	
	//$pdf = new FPDF('L','cm','A4');
	$pdf = new TCPDF('L','cm','A4');
	//$pdf->AddFont('Dot Matrix','','dotmatrix.php');
	$pdf->SetTitle('Purchasing Order');
	$pdf->setHeaderData('',0,'','',array(0,0,0), array(255,255,255) );  
	$pdf->SetMargins(0.5,0,1);
	$pdf->SetAutoPageBreak(TRUE, 0.5);
	$pdf->AddPage();
	$logo = base_url('asset/images/linoti.png');
	//$pdf->Image($logo,0.9, 0.6,-350, -450);
	//$pdf->SetFont('Times','I',7);
	//$pdf->Cell(28, 0.1, 'Printed on '.$tanggal.' '.$waktu, 0, 1, 'R');
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
	
	//$pdf->SetFont('Arial','B',14);
	//$pdf->Cell(28, 0.7,'PURCHASE ORDER KE SUPPLIERS', 1, 1, 'C');
	
	//$pdf->SetLineWidth(0.02);
	//$pdf->Line(1,3.0,29,3.0);
	
	//$pdf->Ln(0.3);
	//$pdf->SetLineWidth(0.01);
	//$pdf->Line(1,2.3,20,2.3);
	//$pdf->SetFont('Arial','B',8);
//	$pdf->Cell(3, 0.4,'PO Number', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$po, 0, 0, 'L');								$pdf->Cell(7,0.4,'',0,0,'L');				$pdf->Cell(2.5, 0.4,'PI Number', 0, 0, 'L');	$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$pi, 0, 1, 'L');
	//$pdf->Cell(3, 0.4,'Attention', 0, 0, 'L');					$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$supplier, 0, 0, 'L');					$pdf->Cell(7,0.4,'',0,0,'L');				$pdf->Cell(2.5, 0.4,'Customer', 0, 0, 'L');		$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');			$pdf->Cell(1, 0.4,$customer, 0, 1, 'L');
	//$pdf->Cell(3, 0.4,'Date of Issue', 0, 0, 'L');			$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(9, 0.4,$tgl_beli, 0, 1, 'L');
//	$pdf->Cell(3, 0.4,'Deadline', 0, 0, 'L');						$pdf->Cell(0.5, 0.4,':', 0, 0, 'L');		$pdf->Cell(1, 0.4,'-', 0, 1, 'L');
	
	//$pdf->Ln(0.3);
	//$pdf->SetLineWidth(0.02);
	//$pdf->Line(1,4.6,29,4.6);
	//$pdf->Line(1,3.0,1,4.9);
	//$pdf->Line(12.3,4.4,12.3,6.6);
	//$pdf->Line(29,3.0,29,4.9);
	$pdf->Ln(0.15);
	$border='0.5';
	$html='<table width="100%">';
	if ($box1==1 && $box2!=1 && $box3!=1){
	
		$pdf->SetFont('Times','B',6.5);
		
		$html .= '<tr>
								<td colspan="4" align="center" border="'.$border.'" width="260px" bgcolor="#f3f3f3">Items</td>
								<td colspan="3" rowspan="2" align="center" border="'.$border.'" width="50px" bgcolor="#92D050">Comercial<br>Size (cm)</td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#CCC0DA">Knock Down ?</td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#C5BE97">Packing Remarks</td>
								<td colspan="15" align="center" border="'.$border.'" width="265px" bgcolor="#C5BE97">Box 1</td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#C5BE97">Vol. Box<br>Outer<br>Box 1</td>
								<td rowspan="2" align="center" border="'.$border.'" bgcolor="#66FFFF" width="40px">Unit<br>Price</td>
								<td rowspan="2" align="center" border="'.$border.'" bgcolor="#66FFFF" width="40px">Update</td>
							</tr>
							<tr>
								<td rowspan="2" align="center" border="'.$border.'" width="40px" bgcolor="#f3f3f3">Code</td>
								<td rowspan="2" align="center" border="'.$border.'" width="60px" bgcolor="#f3f3f3">Image</td>
								<td rowspan="2" align="center" border="'.$border.'" width="50px" bgcolor="#f3f3f3">Collection</td>
								<td rowspan="2" align="center" border="'.$border.'" width="110px" bgcolor="#f3f3f3">Description</td>
								<td align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97">Type</td>
								<td colspan="3" align="center" border="'.$border.'" width="40px" bgcolor="#C5BE97">Styrofoam</td>
								<td colspan="3" align="center" border="'.$border.'" width="60px" bgcolor="#FDE9D9">Inner Size</td>
								<td colspan="3" align="center" border="'.$border.'" width="50px" bgcolor="#C5BE97">+ Karton</td>
								<td colspan="3" align="center" border="'.$border.'" width="60px" bgcolor="#FDE9D9">Outer Size</td>
								<td rowspan="2" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97">Vol. Outer</td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#FDE9D9">Qty<br>Box</td>
							</tr>
							<tr>
								<td align="center" border="'.$border.'" bgcolor="#92D050">L</td>
								<td align="center" border="'.$border.'" bgcolor="#92D050">W</td>
								<td align="center" border="'.$border.'" bgcolor="#92D050">H</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">L</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">W</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">H</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">L</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">W</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">H</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">L</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">W</td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97">H</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">L</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">W</td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9">H</td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF">Box 1</td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"></td>
							</tr>'; 

	} else if ($box1==1 && $box2==1 && $box3!=1){
		$pdf->SetFont('Times','B',6);
		$fsize = '5.5';
		$html .= '<tr>
								<td colspan="4" align="center" border="'.$border.'" width="190px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Items</font></td>
								<td colspan="3" rowspan="2" align="center" border="'.$border.'" width="40px" bgcolor="#92D050"><font size="'.$fsize.'">Comercial<br>Size (cm)</font></td>
								<td rowspan="3" align="center" border="'.$border.'"  width="18px" bgcolor="#CCC0DA"><font size="'.$fsize.'">Knock Down ?</font></td>
								<td rowspan="3" align="center" border="'.$border.'"  width="30px" bgcolor="#C5BE97"><font size="'.$fsize.'">Packing Remarks</font></td>
								<td colspan="15" align="center" border="'.$border.'" width="190px" bgcolor="#C5BE97"><font size="'.$fsize.'">Box 1</font></td>
								<td colspan="15" align="center" border="'.$border.'" width="190px" bgcolor="#C5BE97"><font size="'.$fsize.'">Box 2</font></td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Box<br>Outer<br>Box 1</font></td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Box<br>Outer<br>Box 2</font></td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">Total<br>Vol. Box<br>Outer</font></td>
								<td rowspan="2" colspan="2" align="center" border="'.$border.'" bgcolor="#66FFFF" width="60px"><font size="'.$fsize.'">Unit<br>Price</font></td>
								<td rowspan="2" align="center" border="'.$border.'" bgcolor="#66FFFF" width="30px"><font size="'.$fsize.'">Update</font></td>
							</tr>
							<tr>
								<td rowspan="2" align="center" border="'.$border.'" width="20px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Code</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="50px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Image</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="40px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Collection</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="80px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Description</font></td>
								<td align="center" border="'.$border.'" width="15px" bgcolor="#C5BE97"><font size="'.$fsize.'">Type</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="25px" bgcolor="#C5BE97"><font size="'.$fsize.'">Styrofoam</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="40px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Inner Size</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="30px" bgcolor="#C5BE97"><font size="'.$fsize.'">+ Karton</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="45px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Outer Size</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Outer</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Qty Box<br>1</font></td>
								<td align="center" border="'.$border.'" width="15px" bgcolor="#C5BE97"><font size="'.$fsize.'">Type</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="25px" bgcolor="#C5BE97"><font size="'.$fsize.'">Styrofoam</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="40px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Inner Size</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="30px" bgcolor="#C5BE97"><font size="'.$fsize.'">+ Karton</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="45px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Outer Size</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Outer</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Qty Box<br>2</font></td>
							</tr>
							<tr>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"><font size="'.$fsize.'">Box 1</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"><font size="'.$fsize.'">Box 2</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"></td>
							</tr>';  
	} else if ($box1==1 && $box2==1 && $box3==1){
		$pdf->SetFont('Times','B',4);
		$fsize = '4.8';
		$html .= '<tr>
								<td colspan="4" align="center" border="'.$border.'" width="155px" bgcolor="#f3f3f3"><font size="'.$fsize.'">Items</font></td>
								<td colspan="3" rowspan="2" align="center" border="'.$border.'" width="30px" bgcolor="#92D050"><font size="'.$fsize.'">Comercial<br>Size (cm)</font></td>
								<td rowspan="3" align="center" border="'.$border.'"  width="15px" bgcolor="#CCC0DA"><font size="'.$fsize.'"><br>Knock Down ?</font></td>
								<td rowspan="3" align="center" border="'.$border.'"  width="30px" bgcolor="#C5BE97"><font size="'.$fsize.'"><br>Packing Remarks</font></td>
								<td colspan="15" align="center" border="'.$border.'" width="150px" bgcolor="#C5BE97"><font size="'.$fsize.'">Box 1</font></td>
								<td colspan="15" align="center" border="'.$border.'" width="150px" bgcolor="#C5BE97"><font size="'.$fsize.'">Box 2</font></td>
								<td colspan="15" align="center" border="'.$border.'" width="150px" bgcolor="#C5BE97"><font size="'.$fsize.'">Box 3</font></td>
								<td rowspan="3" align="center" border="'.$border.'" width="12px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Box Outer Box 1</font></td>
								<td rowspan="3" align="center" border="'.$border.'" width="12px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Box Outer Box 2</font></td>
								<td rowspan="3" align="center" border="'.$border.'" width="12px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Box Outer Box 3</font></td>
								<td rowspan="3" align="center" border="'.$border.'" width="12px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Total Vol. Box Outer</font></td>
								<td rowspan="2" colspan="3" align="center" border="'.$border.'" bgcolor="#66FFFF" width="60px"><font size="'.$fsize.'"><br>Unit Price</font></td>
								<td rowspan="2" align="center" border="'.$border.'" bgcolor="#66FFFF" width="20px"><font size="'.$fsize.'"><br>Update</font></td>
							</tr>
							<tr>
								<td rowspan="2" align="center" border="'.$border.'" width="20px" bgcolor="#f3f3f3"><font size="'.$fsize.'"><br>Code</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="40px" bgcolor="#f3f3f3"><font size="'.$fsize.'"><br>Image</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="35px" bgcolor="#f3f3f3"><font size="'.$fsize.'"><br>Collection</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="60px" bgcolor="#f3f3f3"><font size="'.$fsize.'"><br>Description</font></td>
								<td align="center" border="'.$border.'" width="10px" bgcolor="#C5BE97"><font size="'.$fsize.'">Type</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97"><font size="'.$fsize.'">Styrofoam</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Inner Size</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="25px" bgcolor="#C5BE97"><font size="'.$fsize.'">+ Karton</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Outer Size</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Outer</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="10px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Qty<br>Box</font></td>
								<td align="center" border="'.$border.'" width="10px" bgcolor="#C5BE97"><font size="'.$fsize.'">Type</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97"><font size="'.$fsize.'">Styrofoam</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Inner Size</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="25px" bgcolor="#C5BE97"><font size="'.$fsize.'">+ Karton</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Outer Size</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Outer</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="10px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Qty<br>Box</font></td>
								<td align="center" border="'.$border.'" width="10px" bgcolor="#C5BE97"><font size="'.$fsize.'">Type</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="20px" bgcolor="#C5BE97"><font size="'.$fsize.'">Styrofoam</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Inner Size</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="25px" bgcolor="#C5BE97"><font size="'.$fsize.'">+ Karton</font></td>
								<td colspan="3" align="center" border="'.$border.'" width="35px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Outer Size</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="15px" bgcolor="#C5BE97"><font size="'.$fsize.'">Vol. Outer</font></td>
								<td rowspan="2" align="center" border="'.$border.'" width="10px" bgcolor="#FDE9D9"><font size="'.$fsize.'">Qty<br>Box</font></td>
							</tr>
							<tr>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#92D050"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#C5BE97"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">L</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">W</font></td>
								<td align="center" border="'.$border.'" bgcolor="#FDE9D9"><font size="'.$fsize.'">H</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"><font size="'.$fsize.'">Box 1</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"><font size="'.$fsize.'">Box 2</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"><font size="'.$fsize.'">Box 3</font></td>
								<td align="center" border="'.$border.'" bgcolor="#66FFFF"></td>
							</tr>';  
	}
	
	/*
	$pdf->Cell(2, 1.6,'Code', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Image', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Collection', 1, 0, 'C',false);
	$pdf->Cell(11, 1.6,'Description', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'Qty Need', 1, 0, 'C',false);
	$pdf->Cell(1, 1.6,'Stock', 1, 0, 'C',false);
	$pdf->Cell(1.3, 1.6,'Min Qty', 1, 0, 'C',false);
	$pdf->Cell(1.3,1.6,'Qty Order', 1, 0, 'C',false);
	$pdf->Cell(2, 1.6,'Unit Net Price', 1, 0, 'C',false);
	$pdf->Cell(2.5, 1.6,'Total Price', 1, 0, 'C',false);$startX = $pdf->getX();$startY = $pdf->getY();
	$pdf->Cell(3, 0.8,'In', 1, 1, 'C',false);
	
	$pdf->setY($startY+0.8);$pdf->setX($startX);
	$pdf->Cell(1.5, 0.8,'Date', 1, 0, 'C',false);
	$pdf->Cell(1.5, 0.8,'Qty', 1, 1, 'C',false); */
	$total_row = $data->num_rows;
	$count_row = 13-$total_row;
	$ttldl = 0;
	$ttlrp = 0;
	$num = 1;
	$tmp_product_code='';
	$pdf->SetFont('Times','',6.5);
	if($data->num_rows>0)
	{ 
		foreach($data->result() as $dataresult)
		{ 
			if ($dataresult->product_photo!=''){
				$foto = base_url('asset/product_photo/'.$dataresult->product_photo);
				//$foto = 'asset/product_photo/'.$dataresult->product_code;
			} else {
				$foto = base_url('asset/product_photo/unknown.jpg');
				//$foto = 'asset/product_photo/unknown.jpg';
			}
			
			if ($box1==1 && $box2!=1 && $box3!=1){
			
				$html .= '<tr>
										<td align="left" border="'.$border.'"><font size="6px"><br><br><br>  '.$dataresult->product_code.'</font></td>
										<td align="center" border="'.$border.'"><br><img src="'.$foto.'" width="40px" height="40px" /></td>
										<td align="left" border="'.$border.'"><br><br><br> '.$dataresult->coll_name.'</td>
										<td align="left" border="'.$border.'"><br><br><br> '.$dataresult->product_name.'</td>'; 
				if ($dataresult->cm_length > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_length);
					$fraction = $dataresult->cm_length - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_length,1).'</td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_length,0).'</td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_width > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_width);
					$fraction = $dataresult->cm_width - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_width,1).'</td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_width,0).'</td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_height > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_height);
					$fraction = $dataresult->cm_height - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_height,1).'</td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_height,0).'</td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				
			} else if ($box1==1 && $box2==1 && $box3!=1){
			
				$html .= '<tr>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->product_code.'</font></td>
										<td align="center" border="'.$border.'"><br><img src="'.$foto.'" width="35px" height="35px" /></td>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->coll_name.'</font></td>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->product_name.'</font></td>'; 
				
				if ($dataresult->cm_length > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_length);
					$fraction = $dataresult->cm_length - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_length,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_length,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_width > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_width);
					$fraction = $dataresult->cm_width - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_width,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_width,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_height > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_height);
					$fraction = $dataresult->cm_height - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_height,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_height,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				} 
			} else if ($box1==1 && $box2==1 && $box3==1){
					$html .= '<tr>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->product_code.'</font></td>
										<td align="center" border="'.$border.'"><br><img src="'.$foto.'" width="30px" height="30px" /></td>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->coll_name.'</font></td>
										<td align="left" border="'.$border.'"><font size="'.$fsize.'"><br><br> '.$dataresult->product_name.'</font></td>'; 
				
				if ($dataresult->cm_length > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_length);
					$fraction = $dataresult->cm_length - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_length,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_length,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_width > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_width);
					$fraction = $dataresult->cm_width - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_width,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_width,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_height > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_height);
					$fraction = $dataresult->cm_height - $whole;
					if ($fraction > 0){
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_height,1).'</font></td>';
					} else {
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dataresult->cm_height,0).'</font></td>';
					}
				} else {
					$html .= '<td align="center" border="'.$border.'"></td>';
				} 
			}
			
			$textdetail = "SELECT E.boxnumber, E.kdown, E.remarks, E.lstyrofoam, E.wstyrofoam, E.hstyrofoam, E.linner, E.winner, E.hinner, E.lkarton, E.wkarton, E.hkarton, E.louter,E.wouter, 
														E.houter, E.volouter, A.qtybox, E.qtyperbox,E.typebox, F.currency_name, A.hrgbox, DATE_FORMAT(A.hrgdate,'%d-%b-%y') as hrgdate
										 FROM d_belibox A
										 JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
										 JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
										 LEFT OUTER JOIN currency F ON F.currency_code=A.currency
										 WHERE A.po='".$dataresult->po."' AND A.product_code='".$dataresult->product_code."' AND A.companyarea='".$dataresult->companyarea."'";
			$table =  $this->app_model->manualQuery($textdetail);
			$row = $table->num_rows();
			
			if ($row>0){
				$tmp = 1;
				$volbox1=0;
				$volbox2=0;
				$volbox3=0;
				$currency='';
				$hrg1=0;
				$hrg2=0;
				$hrg3=0;
				$hrgdate='';
				foreach ($table->result() as $dt){
					if ($box1==1 && $box2!=1 && $box3!=1){
						$volbox1 = $dt->volouter*$dt->qtybox;
						$currency = $dt->currency_name;
						$hrgdate = $dt->hrgdate;
						$hrg1 = $dt->hrgbox;
						
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.$dt->kdown.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.$dt->remarks.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.$dt->typebox.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->lstyrofoam,0).'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wstyrofoam,0).'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hstyrofoam,0).'</td>';
						
						if ($dt->linner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->linner);
							$fraction = $dt->linner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->linner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->linner,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->winner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->winner,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hinner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hinner,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->lkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->lkarton);
							$fraction = $dt->lkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->lkarton,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->lkarton,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wkarton);
							$fraction = $dt->wkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wkarton,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wkarton,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hkarton);
							$fraction = $dt->hkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hkarton,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hkarton,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->louter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->louter);
							$fraction = $dt->louter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->louter,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->louter,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wouter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wouter);
							$fraction = $dt->wouter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wouter,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wouter,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->houter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->houter);
							$fraction = $dt->houter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->houter,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->houter,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.$dt->volouter.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.$dt->qtybox.'</td>';
					} else if ($box1==1 && $box2==1 && $box3!=1){
						if ($tmp==1){
							$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->kdown.'</font></td>
												<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->remarks.'</font></td>';
							$volbox1 = $dt->volouter*$dt->qtybox;
							$currency = $dt->currency_name;
							$hrgdate = $dt->hrgdate;
							$hrg1 = $dt->hrgbox;
						} else if ($tmp==2){
							$volbox2 = $dt->volouter*$dt->qtybox;
							$hrg2 = $dt->hrgbox;
						}
						
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->typebox.'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lstyrofoam,0).'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wstyrofoam,0).'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hstyrofoam,0).'</font></td>';
											
						if ($dt->linner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->linner);
							$fraction = $dt->linner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->lkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->lkarton);
							$fraction = $dt->lkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wkarton);
							$fraction = $dt->wkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hkarton);
							$fraction = $dt->hkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->louter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->louter);
							$fraction = $dt->louter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->louter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->louter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wouter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wouter);
							$fraction = $dt->wouter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wouter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wouter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->houter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->houter);
							$fraction = $dt->houter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->houter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->houter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->volouter.'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->qtybox.'</font></td>';
						
						$tmp++;
					} else if ($box1==1 && $box2==1 && $box3==1){
						if ($tmp==1){
							$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->kdown.'</font></td>
												<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->remarks.'</font></td>';
							$volbox1 = $dt->volouter*$dt->qtybox;
							$currency = $dt->currency_name;
							$hrgdate = $dt->hrgdate;
							$hrg1 = $dt->hrgbox;
						} else if ($tmp==2){
							$volbox2 = $dt->volouter*$dt->qtybox;
							$hrg2 = $dt->hrgbox;
						} else if($tmp==3){
							$volbox3 = $dt->volouter*$dt->qtybox;
							$hrg3 = $dt->hrgbox;
						}
						
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->typebox.'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lstyrofoam,0).'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wstyrofoam,0).'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hstyrofoam,0).'</font></td>';
						
						if ($dt->linner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->linner);
							$fraction = $dt->linner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->lkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->lkarton);
							$fraction = $dt->lkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->lkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wkarton);
							$fraction = $dt->wkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hkarton >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hkarton);
							$fraction = $dt->hkarton - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hkarton,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->hkarton,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->louter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->louter);
							$fraction = $dt->louter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->louter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->louter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->wouter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->wouter);
							$fraction = $dt->wouter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wouter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->wouter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->houter >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->houter);
							$fraction = $dt->houter - $whole;
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->houter,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.number_format($dt->houter,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->volouter.'</font></td>
											<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->qtybox.'</font></td>';
						
						$tmp++;
					}
				}
				
				if ($box1==1 && $box2!=1 && $box3!=1){
					$html .= '<td align="center" border="'.$border.'"><br><br><br>'.$volbox1.'</td>';
					
					if ($hrg1>0){
						$html	.='<td align="center" border="'.$border.'"><br><br><br>'.$currency.'  '.number_format($hrg1,0,'.',',').'</td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
					if ($hrgdate!=''){
						$html	.='<td align="center" border="'.$border.'"><br><br><br>'.$hrgdate.'</td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
				} else if ($box1==1 && $box2==1 && $box3!=1){
					if ($tmp-1<2){
						$tmp2=$tmp-1;
						while ($tmp2<2){
							$html .= '<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>';
							$tmp2++;
						}
					}
					$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$volbox1.'</font></td>
										<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$volbox2.'</font></td>
										<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.($volbox1+$volbox2).'</font></td>';
										
					if ($hrg1>0){
						$html	.='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$currency.'  '.number_format($hrg1,0,'.',',').'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
					if ($hrg2>0){
						$html	.='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$currency.'  '.number_format($hrg2,0,'.',',').'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
					if ($hrgdate!=''){
						$html	.='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$hrgdate.'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
				} else if ($box1==1 && $box2==1 && $box3==1){
					if ($tmp-1<3){
						$tmp3=$tmp-1;
						while ($tmp3<3){
							$html .= '<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>
												<td align="center" border="'.$border.'" bgcolor="#ADADAD"></td>';
							$tmp3++;
						}
					}
					$html .= '<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$volbox1.'</font></td>
										<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$volbox2.'</font></td>
										<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$volbox3.'</font></td>
										<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.($volbox1+$volbox2+$volbox3).'</font></td>';
										
					if ($hrg1>0){
						$html .='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$currency.'  '.number_format($hrg1,0,'.',',').'</font></td>';
					} else{
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
					if ($hrg2>0){
						$html .='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$currency.'  '.number_format($hrg2,0,'.',',').'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
					if ($hrg3>0){
						$html	.='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$currency.'  '.number_format($hrg3,0,'.',',').'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}					
					
					if ($hrgdate!=''){
						$html	.='<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$hrgdate.'</font></td>';
					} else {
						$html	.='<td align="center" border="'.$border.'"></td>';
					}
					
				}
				
			}
			
			/*
				//$pdf->Image($foto,0.9,0.6,-350,-450);					
				//$pdf->Cell(2, 0.4,$dataresult->product_code, 1, 0, 'C',false);
				//$pdf->Cell(2, 0.4,'', 1, 0, 'C',false);
				//$pdf->Cell(2, 0.4,$dataresult->coll_name, 1, 0, 'L',false);
				//$pdf->Cell(2.2, 0.4,$dataresult->product_name, 1, 0, 'L',false);
				if ($dataresult->cm_length > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_length);
					$fraction = $dataresult->cm_length - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_length,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_length,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_length,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_length,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_width > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_width);
					$fraction = $dataresult->cm_width - $whole;
					if ($fraction > 0){
					//	$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_width,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_width,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_width,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_width,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->cm_height > 0){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->cm_height);
					$fraction = $dataresult->cm_height - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_height,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_height,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->cm_height,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->cm_height,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				} 
				$pdf->Cell(1, 0.4,$dataresult->kdown, 1, 0, 'C',false);
				$pdf->Cell(2, 0.4,$dataresult->remarks, 1, 0, 'C',false);
				$pdf->Cell(0.7, 0.4,$dataresult->typebox1, 1, 0, 'C',false);
				$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_lstyrofoam,0), 1, 0, 'C',false);
				$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_wstyrofoam,0), 1, 0, 'C',false);
				$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_hstyrofoam,0), 1, 0, 'C',false); 
				$html .= '<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->kdown.'</td>
									<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->remarks.'</td>
									<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->typebox1.'</td>
									<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_lstyrofoam,0).'</td>
									<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_wstyrofoam,0).'</td>
									<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_hstyrofoam,0).'</td>'; 
					
				if ($dataresult->box1_linner >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_linner);
					$fraction = $dataresult->box1_linner - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_linner,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_linner,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_linner,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_linner,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_winner >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_winner);
					$fraction = $dataresult->box1_winner - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_winner,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_winner,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_winner,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_winner,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_hinner >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_hinner);
					$fraction = $dataresult->box1_hinner - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_hinner,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_hinner,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_hinner,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_hinner,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_lkarton >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_lkarton);
					$fraction = $dataresult->box1_lkarton - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_lkarton,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_lkarton,1).'</td>';
					} else {
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_lkarton,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_lkarton,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.5, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_wkarton >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_wkarton);
					$fraction = $dataresult->box1_wkarton - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_wkarton,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_wkarton,1).'</td>';
					} else {
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_wkarton,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_wkarton,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.5, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_hkarton >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_hkarton);
					$fraction = $dataresult->box1_hkarton - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_hkarton,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_hkarton,1).'</td>';
					} else {
						//$pdf->Cell(0.5, 0.4,number_format($dataresult->box1_hkarton,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_hkarton,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.5, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_louter >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_louter);
					$fraction = $dataresult->box1_louter - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_louter,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_louter,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_louter,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_louter,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_wouter >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_wouter);
					$fraction = $dataresult->box1_wouter - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_wouter,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_wouter,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_wouter,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_wouter,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				
				if ($dataresult->box1_houter >0 ){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($dataresult->box1_houter);
					$fraction = $dataresult->box1_houter - $whole;
					if ($fraction > 0){
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_houter,1), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_houter,1).'</td>';
					} else {
						//$pdf->Cell(0.7, 0.4,number_format($dataresult->box1_houter,0), 1, 0, 'C',false);
						$html .= '<td align="center" border="'.$border.'"><br><br><br>'.number_format($dataresult->box1_houter,0).'</td>';
					}
				} else {
					//$pdf->Cell(0.7, 0.4,'0', 1, 0, 'C',false);
					$html .= '<td align="center" border="'.$border.'"></td>';
				}
				//$pdf->Cell(1.2, 0.4,$dataresult->box1_volouter, 1, 0, 'C',false);
				//$pdf->Cell(1, 0.4,$dataresult->box1_qtybox, 1, 0, 'C',false);
				//$pdf->Cell(1, 0.4,$dataresult->box1_volouter*$dataresult->box1_qtybox, 1, 0, 'C',false);
				//$pdf->Cell(1, 0.4,'', 1, 0, 'C',false);
				//$pdf->Cell(1, 0.4,'', 1, 1, 'C',false);
				$tdate = date_create($dataresult->box1_hrgdate);
				$html .= '	<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->box1_volouter.'</td>
										<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->box1_qtybox.'</td>
										<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->box1_volouter*$dataresult->box1_qtybox.'</td>
										<td align="center" border="'.$border.'"><br><br><br>'.$dataresult->box1_currency.'  '.number_format($dataresult->box1_hrgbox,0,'.',',').'</td>
										<td align="center" border="'.$border.'"><br><br><br>'.date_format($tdate,'d-M-y').'</td>
									</tr>'; 
			} else if ($box1==1 && $box2==1 && $box3!=1){
				$html .= '<tr>
										<td align="left" border="'.$border.'"><font size="6px"><br><br><br>  '.$dataresult->product_code.'</font></td>
										<td align="center" border="'.$border.'"><br><img src="'.$foto.'" width="40px" height="40px" /></td>
										<td align="left" border="'.$border.'"><br><br><br> '.$dataresult->coll_name.'</td>
										<td align="left" border="'.$border.'"><br><br><br> '.$dataresult->product_name.'</td>'; 
				
				
			} else if ($box1==1 && $box2==1 && $box3==1){
				
			} */
			$html .= '</tr>';
		} 
	}
	else
	{
		$ttlrp=0;
		$ttldl=0;
	}
	
	$pdf->SetFont('Times','B',6.5); /*
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'Total Price', 1, 0, 'L');
	$pdf->Cell(0.5, 0.6,'Rp', 'LTB', 0, 'L');
	if ($ttlrp > 0){
		$pdf->Cell(2, 0.6, number_format($ttlrp, 0,',','.'), 'TRB', 1, 'R');
	} else {
		$pdf->Cell(2, 0.6, '-', 'TRB', 1, 'R');
	}
	//$pdf->Cell(3, 0.6,'', 1, 1, 'C');
	if ($ttldl>0){
		$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
		$pdf->Cell(1.5, 0.6,'Total Price', 1, 0, 'L');
		$pdf->Cell(0.5, 0.6,'$', 'LTB', 0, 'L');
		$whole = 0;
		$fraction = 0.0; 
		$fraction_str='';
		$whole = floor ($ttldl);
		$fraction = $ttldl - $whole;
		$fraction_str = ''.number_format($ttldl, 3,',','.');
		if ($fraction > 0){
			if (substr($fraction_str,-1)!='0'){
				$pdf->Cell(2, 0.6, number_format($ttldl, 3,',','.'), 'TRB', 1, 'R');
			} elseif (substr($fraction_str,-2,1)!='0'){
				$pdf->Cell(2, 0.6, number_format($ttldl, 2,',','.'), 'TRB', 1, 'R');
			} else {
				$pdf->Cell(2, 0.6, number_format($ttldl, 1,',','.'), 'TRB', 1, 'R');
			}
		} else {
			$pdf->Cell(2, 0.6, number_format($ttldl, 0,',','.'), 'TRB', 1, 'R');
		}
	} 
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'', 1, 0, 'C');
	$pdf->Cell(1, 0.6,'', 'LTB', 0, 'L');
	$pdf->Cell(1.5, 0.6, '', 'TRB', 1, 'R');
	$pdf->Cell(20.5, 0.6,'', '', 0, 'R');
	$pdf->Cell(2, 0.6,'', 1, 0, 'C');
	$pdf->Cell(1, 0.6,'', 'LTB', 0, 'L');
	$pdf->Cell(1.5, 0.6, '', 'TRB', 1, 'R'); */
	$pdf->Ln(1);
	$html .= '</table>';
	$pdf->writeHtml($html);
	$pdf->Cell(19, 0.6,'KETERANGAN', 0, 0, 'L');
	$pdf->Cell(5, 0.6,'', 0, 0, 'L');
	$pdf->Cell(1.5, 0.6,'Director', 0, 1, 'C');

	$pdf->SetFillColor(0, 0, 100, 0);
	$pdf->Cell(0.5, 0.5,'', 0, 0, 'L',true);
	
	$pdf->Cell(18.5, 0.5,' = KD', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 1, 'L');
	$pdf->Cell(19, 0.5,'', 0, 0, 'L');
	$pdf->Cell(5, 0.5,'', 0, 0, 'L');
	$pdf->SetFont('Times','UB',6.5);
	$pdf->Cell(1.5, 0.5,'S.A', 0, 1, 'C');
	$pdf->SetFont('Times','B',6.5);
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	$pdf->Cell(19, 0.5,"", 0, 1, 'L');
	
	$filename = 'asset/po/'.$supplier.'/'.$po.'_'.$tanggal.'.pdf';
	$pdf->Output($filename, 'I');
	
	
	//$pdf->Output('Purchase Order - '.$po, 'I');
	//$pdf->Output($filename, 'G');
?>