<form name="multiform" id="multiform" action="<?=site_url('import_pembelian/import')?>" method="POST" enctype="multipart/form-data">
<fieldset class="atas">
Pilih File Excel*: <input name="fileexcel" type="file" id="fileexcel">
<br/>
* file yang bisa di upload adalah .xls (Excel 2003).<br/>
Download Excel template <a href="<?=base_url('asset/template/Pembelian.xls')?>"><img src="<?=base_url('asset/img/excel.png')?>" width="25px" /></a>
</fieldset>

<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <input type="submit" name="simpan" id="simpan" value="Upload" class="easyui-linkbutton" data-options="iconCls:'icon-save'" />
	<a href="<?=site_url('import_pembelian')?>">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
	</a>
    </td>
</tr>
</table>  
</form>
</fieldset>
<fieldset>