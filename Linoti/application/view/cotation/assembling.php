
<?php
/*
	$widthlabelleft='10%';
	$widthlabelcenter='8%';
	$widthlabelright='11%';
	
	$widthdoubledot='1%';
	
	$widthinputleft='16%';
	$widthinputleft1='8%';
	$widthinputleft2='20%';
	$widthinputcenter='30%';
	$widthinputright='30%';
	
	$widthtable='100%';
	$widthtablelabelsize='10%';
	$widthtablelabeltype='15%';
	$widthtableinput='40%';
	$widthtableunit='5%';
	$widthtableblankrigth='29%';
	*/
	$widthpx1='160px';
	$widthpx2='160px';
	$widthpx2_1='20px';
	$widthpx2_2='140px';
	$widthpx3='160px';
	$widthpx4='160px';
	$widthpx5='160px';
	$widthpx5_1='100px';
?>

<!--<form name="form" id="form">-->
<tr><td>
<table> 
	<tr>
		<td valign="top">
			<fieldset class="atas">
			<table width="100%" border="0">
				<tr>    
					<td width="<?=$widthpx1?>">Select Assembling Type</td>
					<td width="<?=$widthpx2_1?>">:</td>
					<td colspan="4" width="<?=$widthpx2_2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>"><input type="radio" name="AssType" value="Outdoor" <?php echo ($asstype=='Outdoor')?'checked':''; ?>>Outdoor<input type="radio" name="AssType" value="Indoor" style="margin-left:50px;" <?php echo ($asstype=='Indoor')?'checked':''; ?>>Indoor<input type="radio" name="AssType" value="InOutdoor" style="margin-left:50px;" <?php echo ($asstype=='InOutdoor')?'checked':''; ?>>Indoor + Outdoor</td>
				</tr>
				<tr class="trass">    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr>
					<script type="text/javascript">
						function myformatter(date){
							var y = date.getFullYear();
							var m = date.getMonth()+1;
							var d = date.getDate();
							return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y;
						}
						
						function myparser(s){
							if (!s) return new Date();
							var ss = (s.split('/'));
							var y = parseInt(ss[0],10);
							var m = parseInt(ss[1],10);
							var d = parseInt(ss[2],10);
							if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
									return new Date(d,m-1,y);
							} else {
									return new Date();
							}
						}
					</script>
				<tr class="trindoor">    
					<td width="<?=$widthpx1?>">Select Indoor Type</td>
					<td width="<?=$widthpx2_1?>">:</td>
					<td colspan="4" width="<?=$widthpx2_2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>"><input type="radio" name="IndoorType" value="Harian" <?php echo ($indoortype=='Harian')?'checked':''; ?>>Harian<input type="radio" name="IndoorType" value="Borongan" style="margin-left:60px;" <?php echo ($indoortype=='Borongan')?'checked':''; ?>>Borongan</td> 
				</tr><!--
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr> -->
				<tr class="trinoutdoor">
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgIndoorOutdoor"></table>
					</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
</table> 
<!--</form>-->
</td></tr>