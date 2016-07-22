<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	$("#cetak").click(function(){
		var kode	= $("#kodebarang").val();
		window.open('<?php echo site_url();?>/export_packing/export/'+kode);
		return false();
	});
});
</script>
<form name="form" id="form">
<fieldset class="atas">
<table width="100%">
	<tr>
		<td align="right">Kode Product</td>
		<td>:</td>
		<td><input name="kodebarang" type="text" id="kodebarang"></td>
	</tr>
</table>
</fieldset>

<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <input type="submit" name="cetak" id="cetak" value="Download" class="easyui-linkbutton" data-options="iconCls:'icon-save'" />
	<a href="<?=site_url('export_packing')?>">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
	</a>
    </td>
</tr>
</table>  
</form>
</fieldset>
<fieldset>