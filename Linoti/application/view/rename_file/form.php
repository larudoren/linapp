<form name="multiform" id="multiform" action="<?=site_url('rename_file/myrename')?>" method="POST" enctype="multipart/form-data">
<fieldset class="atas">
Test Rename File
</fieldset>

<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <input type="submit" name="simpan" id="simpan" value="Rename" class="easyui-linkbutton" data-options="iconCls:'icon-save'" />
	<a href="<?=site_url('rename_file')?>">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
	</a>
    </td>
</tr>
</table>  
</form>
</fieldset>
<fieldset>