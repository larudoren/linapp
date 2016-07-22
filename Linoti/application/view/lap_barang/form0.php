<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#stok").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	$("#cari").click(function(){
		var kode = $("#kode_brg").val();
		var	pilih	= $(".pilih:checked").val();
		var departemen = $("#departemen").val();
		var jml_pilih = $(".pilih:checked");
		
		var string = "kode="+kode+"&pilih="+pilih+"&departemen="+departemen;
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/lap_barang/lihat",
			data	: string,
			cache	: false,
			success	: function(data){
				var win = $.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
				});
				setTimeout(function(){
					$.messager.progress('close');
					$("#tampil_data").html(data);
				},2800)
			}		
		});
		return false();	
	});
	
	$("#cetak").click(function(){
		var kode = $("#kode_brg").val();
		var dept = $("#departemen").val();
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		 
		window.open('<?php echo site_url();?>/lap_barang/cetak/'+pilih+'/'+kode+dept);
		return false();
	});
});	
</script>
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="all" checked="checked" />Semua Data</td>
    <td width="5"></td>
    <td></td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="departemen" />Departemen</td>
    <td width="5"></td>
    <td>
    <select name="departemen" id="departemen">
    <option value="">-PILIH-</option>
    <?php 
	foreach($l_dept->result() as $t){
	?>
    <option value="<?php echo $t->dept_code;?>-<?php echo $t->dept_name;?>"><?php echo $t->dept_code;?>-<?php echo $t->dept_name;?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="kode" />Kode Barang</td>
    <td width="5"></td>
    <td><input type="text" name="kode_brg" id="kode_brg" size="15" maxlength="13" class="easyui-validatebox" data-options="required:true,validType:'length[13]'" /></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/lap_barang/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   