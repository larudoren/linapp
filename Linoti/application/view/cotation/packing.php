<!--<script>
			!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script> -->
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
<script>
	var cm_length = '<?=$cm_length?>';
	var cm_width = '<?=$cm_width?>';
	var cm_height = '<?=$cm_height?>';
</script>
<!--<form name="form" id="form">-->
<tr><td>
<table width="100%"> 
	<tr>
		<td valign="top">
			<fieldset class="atas">
			<table width="100%" border="0"> 
				<tr>
					<td colspan="6">
						<table width="100%">
							<td width="15%">Product Size ( Overall )</td>
							<td>:</td>
							<td class="myid">L&nbsp;&nbsp;<?=$cm_length?>&nbsp;&nbsp;x&nbsp;&nbsp;W&nbsp;&nbsp;<?=$cm_width?>&nbsp;&nbsp;x&nbsp;&nbsp;H&nbsp;&nbsp;<?=$cm_height?>&nbsp;&nbsp;(cm)</td>
						</table>
					</td>
				</tr><!--
				<tr>
					<td colspan="6">Testing 2 &nbsp;</td>
				</tr> -->
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr> 
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgPacking" class="easyui-datagrid"></table>
					</td>
				</tr> 
			</table> 
			</fieldset>
		</td>
	</tr>
</table> 
<!--</form>-->
</td></tr>