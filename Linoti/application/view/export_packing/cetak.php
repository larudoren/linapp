<?php
/*
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public"); 
	header("Content-Description: File Transfer");
	session_cache_limiter("must-revalidate"); */
	header("Content-Type: application/vnd.ms-excel;");
	date_default_timezone_set("Asia/Jakarta");
	header("Content-Disposition: attachment; filename=Product_Packing_".date("d-m-Y").date("_H-i"));
	
?>
<table border="1">
	<tr>
		<th rowspan="3" align="center">No</th>
		<th colspan="4" align="center" bgcolor="#f3f3f3">Items</th>
		<th colspan="3" rowspan="2" align="center" bgcolor="#92D050">Comercial Size (mm)</th>
		<th rowspan="3" align="center" bgcolor="#CCC0DA">Knock Down?</th>
		<th rowspan="3" align="center" bgcolor="#808000">Packing Remarks</td>
		<th colspan="18" align="center" bgcolor="#C5BE97">Box 1</td>
		<th colspan="16" align="center" bgcolor="#C5BE97">Box 2</td>
		<th colspan="16" align="center" bgcolor="#C5BE97">Box 3</td>
		<th rowspan="3" align="center">Total<br/>Vol. Box<br/>Outer<br>Order</td>
	</tr>
	<tr>
		<th rowspan="2" bgcolor="#f3f3f3">Code</th>
		<th rowspan="2" bgcolor="#f3f3f3" hidden="true">Photo</th>
		<th rowspan="2" bgcolor="#f3f3f3">Collection</th>
		<th rowspan="2" bgcolor="#f3f3f3">Description</th>
		<th>Type</th>
		<th colspan="3">Gap</th>
		<th colspan="3">Inner Size</th>
		<th colspan="3">+ Carton</th>
		<th colspan="3">Outer Size</th>
		<th rowspan="2">L Vertical</th>
		<th rowspan="2">L Horizontal</th>
		<th rowspan="2">Vol. Outer<br> / pcs</th>
		<th rowspan="2">Qty Box 1</th>
		<th rowspan="2">Remarks Box 1</th>
		<th>Type</th>
		<th colspan="3">Gap</th>
		<th colspan="3">Inner Size</th>
		<th colspan="3">+ Carton</th>
		<th colspan="3">Outer Size</th>
		<th rowspan="2">Vol. Outer<br> / pcs</th>
		<th rowspan="2">Qty Box 2</th>
		<th rowspan="2">Remarks Box 2</th>
		<th>Type</th>
		<th colspan="3">Gap</th>
		<th colspan="3">Inner Size</th>
		<th colspan="3">+ Carton</th>
		<th colspan="3">Outer Size</th>
		<th rowspan="2">Vol. Outer<br> / pcs</th>
		<th rowspan="2">Qty Box 3</th>
		<th rowspan="2">Remarks Box 3</th>
	</tr>
	<tr>
		<th bgcolor="#92D050">L</th>
		<th bgcolor="#92D050">W</th>
		<th bgcolor="#92D050">H</th>
		<th bgcolor="#C5BE97"></th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
		<th bgcolor="#C5BE97"></th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
		<th bgcolor="#C5BE97"></th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
		<th bgcolor="#C5BE97">L</th>
		<th bgcolor="#C5BE97">W</th>
		<th bgcolor="#C5BE97">H</th>
		<th bgcolor="#FDE9D9">L</th>
		<th bgcolor="#FDE9D9">W</th>
		<th bgcolor="#FDE9D9">H</th>
	</tr>
	<?php
		
		
		if($data->num_rows()>0) {
			$no = 1;
			$baris = 4;
			foreach($data->result() as $de) {

				//if ($de->product_photo!=''){
				//	$foto = '/xampp/htdocs/Linoti/asset/product_photo/'.$de->product_photo;
				//} else {
				//	$foto = '/xampp/htdocs/Linoti/asset/product_photo/unknown.jpg';
				//}
				//list($width, $height) = getimagesize($foto);
	?>
	<tr>
		<td><?=$no?></td>
		<td><?=$de->product_code?></td>
		<td></td>
		<td><?=$de->coll_name?></td>
		<td><?=$de->product_name?></td>
		<td><?=number_format($de->cm_length*10,0,'','')?></td>
		<td><?=number_format($de->cm_width*10,0,'','')?></td>
		<td><?=number_format($de->cm_height*10,0,'','')?></td>
	<?php
				$textdetail = "SELECT 	A.boxnumber, A.kdown, A.remarks_packing, A.remarks, A.lstyrofoam, A.wstyrofoam, A.hstyrofoam, A.linner, A.winner, A.hinner, A.lkarton, A.wkarton, A.hkarton, A.louter,A.wouter, 
										A.houter, A.volouter, A.qtyperbox,A.typebox, A.asize, A.bsize, A.lshape, A.remarks,A.qtybox
										FROM cotation_packing A
										JOIN  h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea
										WHERE B.product_code='".$de->product_code."' AND B.companyarea='".$de->companyarea."' ORDER BY A.boxnumber,A.typebox";
				$table =  $this->app_model->manualQuery($textdetail);
				$row = $table->num_rows();
				
				if ($row>0){
					$tmp = 1;
					$volbox1=0;
					$volbox2=0;
					$volbox3=0;
					$boxnumber1="";
					$boxnumber2="";
					$boxnumber3="";
					foreach ($table->result() as $dt){
						
						if (($boxnumber1=='' && $dt->boxnumber=='BOX 1') || ($boxnumber2=='' && $dt->boxnumber=='BOX 2') || ($boxnumber3=='' && $dt->boxnumber=='BOX 3')){
							if ($dt->boxnumber=='BOX 1' && $boxnumber1==''){
								$boxnumber1=$dt->boxnumber;
							}elseif($dt->boxnumber=='BOX 2' && $boxnumber2==''){
								$boxnumber2=$dt->boxnumber;	
							}elseif($dt->boxnumber=='BOX 3' && $boxnumber3=='') {
								$boxnumber3=$dt->boxnumber;	
							}
						if ($tmp==1){
		?>
								<td align="center"><?=$dt->kdown?></td>
								<td align="center"><?=$dt->remarks_packing?></td>
		<?php
							$volbox1 = $dt->volouter*$dt->qtybox;
						} else if ($tmp==2){
							$volbox2 = $dt->volouter*$dt->qtybox;
						} else if($tmp==3){
							$volbox3 = $dt->volouter*$dt->qtybox;
						}
		?>
							<td align="center"><?=$dt->typebox?></td>
							<td align="center"><?=number_format($dt->lstyrofoam,0,'','')?></td>
							<td align="center"><?=number_format($dt->wstyrofoam,0,'','')?></td>
							<td align="center"><?=number_format($dt->hstyrofoam,0,'','')?></td>
		<?php
							if ($dt->linner >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->linner);
								$fraction = $dt->linner - $whole;
								if (($de->cm_length*10)!=($dt->linner-$dt->lstyrofoam)){
									$warnalinner = ' bgcolor="#FFFF00" ';
								} else {
									$warnalinner = '';
								}
								if ($fraction > 0){
		?>
									<td align="center" <?php echo $warnalinner; ?>><?=number_format($dt->linner,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center" <?php echo $warnalinner; ?>><?=number_format($dt->linner,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->winner >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->winner);
								$fraction = $dt->winner - $whole;
								if ($de->cm_width*10!=($dt->winner-$dt->wstyrofoam)){
									$warnawinner = ' bgcolor="#FFFF00" ';
								} else {
									$warnawinner = '';
								}
								if ($fraction > 0){
		?>
									<td align="center" <?php echo $warnawinner; ?>><?=number_format($dt->winner,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center" <?php echo $warnawinner; ?>><?=number_format($dt->winner,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->hinner >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->hinner);
								$fraction = $dt->hinner - $whole;
								if ($de->cm_height*10!=($dt->hinner-$dt->hstyrofoam)){
									$warnahinner = ' bgcolor="#FFFF00" ';
								} else {
									$warnahinner = '';
								}
								if ($fraction > 0){
		?>
									<td align="center" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center" <?php echo $warnahinner; ?>><?=number_format($dt->hinner,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->lkarton >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->lkarton);
								$fraction = $dt->lkarton - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->lkarton,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->lkarton,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->wkarton >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->wkarton);
								$fraction = $dt->wkarton - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->wkarton,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->wkarton,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->hkarton >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->hkarton);
								$fraction = $dt->hkarton - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->hkarton,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->hkarton,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->louter >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->louter);
								$fraction = $dt->louter - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->louter,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->louter,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->wouter >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->wouter);
								$fraction = $dt->wouter - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->wouter,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->wouter,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->houter >0 ){
								$whole = 0;
								$fraction = 0.0;
								$whole = floor($dt->houter);
								$fraction = $dt->houter - $whole;
								if ($fraction > 0){
		?>
									<td align="center"><?=number_format($dt->houter,1,'','')?></td>
		<?php
								} else {
		?>
									<td align="center"><?=number_format($dt->houter,0,'','')?></td>
		<?php
								}
							} else {
		?>
								<td></td>
		<?php
							}
							
							if ($dt->boxnumber=='BOX 1'){
								if ($dt->asize > 0){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->asize);
									$fraction = $dt->asize - $whole;
									if ($fraction > 0){
		?>
							<td align="center"><?=number_format($dt->asize,1,'','')?></td>
		<?php
									}else{
		?>
							<td align="center"><?=number_format($dt->asize,0,'','')?></td>
		<?php
									}
								} else {
		?>
							<td></td>
		<?php
								}
								
								if ($dt->bsize > 0){
									$whole = 0;
									$fraction = 0.0;
									$whole = floor($dt->bsize);
									$fraction = $dt->bsize - $whole;
									if ($fraction > 0){
		?>
							<td align="center"><?=number_format($dt->bsize,1,'','')?></td>
		<?php
									} else {
		?>
							<td align="center"><?=number_format($dt->bsize,0,'','')?></td>
		<?php
									}
								}else{
		?>
							<td></td>
		<?php
								}
							}
		?>
							<td align="center"><?=$dt->volouter?></td>
							<td align="center"><?=$dt->qtybox?></td>
							<td align="center"><?=$dt->remarks?></td>
		<?php
							
							$tmp++;
						}
					}
					
					//if ($box1==1 && $box2==1 && $box3==1){
						if ($tmp-1<3){
							$tmp3=$tmp-1;
							while ($tmp3<3){
		?>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
								<td align="center" bgcolor="#ADADAD"></td>
		<?php
								$tmp3++;
							}
						}
		?>
						<!--<td align="center"><?=$volbox1?></td>-->
						<!--<td align="center"><?=$volbox2?></td>-->
						<!--<td align="center"><?=$volbox3?></td>-->
						<td align="center"><?=($volbox1+$volbox2+$volbox3)?></td>
		<?php
											
						
					//}
					
				}
	?>
	</tr>
	<?php
				$no++;
			
			}
		}
	?>
</table>