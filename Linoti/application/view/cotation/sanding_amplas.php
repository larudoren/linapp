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

<!--<form name="form" id="form">-->
<tr><td>
<table> 
	<tr>
		<td valign="top">
			<fieldset class="atas">
			<table width="100%" border="0"> <!--
				<tr>    
					<td width="<?=$widthpx1?>">Total Area Wood</td>
					<td width="<?=$widthpx2_1?>">:</td>
					<td colspan="4" width="<?=$widthpx2_2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>"><input type="text" class="easyui-numberbox" name="totalwood" id="totalwood" data-options="disabled:true" value="<?=$wood?>" /> (mm2)</td>
				</tr>
				<tr>    
					<td width="<?=$widthpx1?>">Total Area Panel</td>
					<td width="<?=$widthpx2_1?>">:</td>
					<td colspan="4" width="<?=$widthpx2_2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>"><input type="text" class="easyui-numberbox" name="totalpanel" id="totalpanel" data-options="disabled:true" value="<?=$panel?>" /> (mm2)</td>
				</tr>
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr> -->
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgWoodSandingAmplas"  class="tableWoodSandingAmplas easyui-datagrid"></table>
					</td>
				</tr> 
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr>
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgVeneerSandingAmplas" class="tableVeneerSandingAmplas easyui-datagrid"></table>
					</td>
				</tr> 
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr>
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgFinishingSandingAmplas"></table>
					</td>
				</tr> <!--
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>" align="center">&nbsp;</td>
				</tr> -->
				<tr>    
					<td colspan="6" width="<?=$widthpx1+$widthpx2+$widthpx3+$widthpx4+$widthpx5+$widthpx5_1?>">
						<table id="dgSandingAmplas" class="tableSandingAmplas easyui-datagrid"></table>
					</td>
				</tr> 
			</table>
			</fieldset>
		</td>
	</tr>
</table> 
<!--</form>-->
</td></tr>