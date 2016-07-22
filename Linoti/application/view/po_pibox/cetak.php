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
	
	$pdf->Ln(0.15);
	$border='0.5';
	$html='<table width="100%">';
	if ($box1==1 && $box2!=1 && $box3!=1){
	
		$pdf->SetFont('Times','B',6.5);
		
		$html .= '<tr>
								<td colspan="35" align="center">Ukuran Box untuk '.$customer.' '.$pi.'</td>
							</tr>
							<tr>
								<td colspan="35" align="center"></td>
							</tr>
							<tr>
								<td colspan="4" align="center" border="'.$border.'" width="260px" bgcolor="#f3f3f3">Items</td>
								<td colspan="3" rowspan="2" align="center" border="'.$border.'" width="50px" bgcolor="#92D050">Comercial<br>Size (cm)</td>
								<td rowspan="3" align="center" border="'.$border.'" bgcolor="#CCC0DA">Knock Down ?</td>
								<td rowspan="3" align="center" border="'.$border.'" width="40px" bgcolor="#C5BE97">Packing Remarks</td>
								<td colspan="15" align="center" border="'.$border.'" width="265px" bgcolor="#C5BE97">Box 1</td>
								<td rowspan="3" align="center" border="'.$border.'" width="40px" bgcolor="#C5BE97">Vol. Box<br>Outer<br>Box 1</td>
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
			
			$textdetail = "SELECT E.boxnumber, E.kdown, E.remarks_packing, E.remarks, E.lstyrofoam, E.wstyrofoam, E.hstyrofoam, E.linner, E.winner, E.hinner, E.lkarton, E.wkarton, E.hkarton, E.louter,E.wouter, 
														E.houter, E.volouter, A.qtybox, E.qtyperbox,E.typebox, F.currency_name, A.hrgbox, DATE_FORMAT(A.hrgdate,'%d-%b-%y') as hrgdate
										 FROM d_belibox A
										 JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
										 JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
										 LEFT OUTER JOIN currency F ON F.currency_code=A.currency
										 WHERE A.po='".$dataresult->po."' AND A.product_code='".$dataresult->product_code."' AND A.companyarea='".$dataresult->companyarea."'";
			$fp=fopen("datadetail.txt","w");
			fwrite($fp,$textdetail);
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
											<td align="center" border="'.$border.'"><br><br><br>'.$dt->remarks_packing.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.$dt->typebox.'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->lstyrofoam,0).'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->wstyrofoam,0).'</td>
											<td align="center" border="'.$border.'"><br><br><br>'.number_format($dt->hstyrofoam,0).'</td>';
						
						if ($dt->linner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->linner);
							$fraction = $dt->linner - $whole;
							if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
								$warnalinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnalinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><br><br><br>'.number_format($dt->linner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><br><br><br>'.number_format($dt->linner,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
								$warnawinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnawinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><br><br><br>'.number_format($dt->winner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><br><br><br>'.number_format($dt->winner,0).'</td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
								$warnahinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnahinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><br><br><br>'.number_format($dt->hinner,1).'</td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><br><br><br>'.number_format($dt->hinner,0).'</td>';
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
												<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->remarks_packing.'</font></td>';
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
							if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
								$warnalinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnalinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
								$warnawinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnawinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
								$warnahinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnahinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,0).'</font></td>';
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
												<td align="center" border="'.$border.'"><font size="'.$fsize.'"><br><br>'.$dt->remarks_packing.'</font></td>';
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
							if ($dataresult->cm_length!=($dt->linner-$dt->lstyrofoam)){
								$warnalinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnalinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnalinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->linner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->winner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->winner);
							$fraction = $dt->winner - $whole;
							if ($dataresult->cm_width!=($dt->winner-$dt->wstyrofoam)){
								$warnawinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnawinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnawinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->winner,0).'</font></td>';
							}
						} else {
							$html .= '<td align="center" border="'.$border.'"></td>';
						}
						
						if ($dt->hinner >0 ){
							$whole = 0;
							$fraction = 0.0;
							$whole = floor($dt->hinner);
							$fraction = $dt->hinner - $whole;
							if ($dataresult->cm_height!=($dt->hinner-$dt->hstyrofoam)){
								$warnahinner = ' bgcolor="#FFFF00" ';
							} else {
								$warnahinner = '';
							}
							if ($fraction > 0){
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,1).'</font></td>';
							} else {
								$html .= '<td align="center" border="'.$border.'" '.$warnahinner.'><font size="'.$fsize.'"><br><br>'.number_format($dt->hinner,0).'</font></td>';
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
			$html .= '</tr>';
		} 
	}
	else
	{
		$ttlrp=0;
		$ttldl=0;
	}
	
	$pdf->SetFont('Times','B',6.5); 
	$pdf->Ln(1);
	$html .= '</table>';
	$pdf->writeHtml($html);
	$pdf->Cell(19, 0.6,'KETERANGAN', 0, 0, 'L');
	$pdf->Cell(5, 0.6,'', 0, 0, 'L');
	$pdf->Cell(1.5, 0.6,'Director', 0, 1, 'C');

	$pdf->SetFillColor(0, 0, 100, 0);
	$pdf->Cell(0.5, 0.5,'', 0, 0, 'L',true);
	
	$pdf->Cell(18.5, 0.5,' = KD / Rubah Ukuran', 0, 1, 'L');
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
	if ($saveas!=''){
		$pdf->Output($filename, 'FI');
	} else {
		$pdf->Output($filename, 'I');
	}
	
?>