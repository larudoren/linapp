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
	$("#tgl_1").datepicker({
			dateFormat:"dd-mm-yy"
    });
	$("#tgl_2").datepicker({
			dateFormat:"dd-mm-yy"
    });
	$("#cari").click(function(){
		var kode = $("#kode_brg").val();
		var tgl1 = $("#tgl_1").val();
		var tgl2 = $("#tgl_2").val();
		var supplier = $("#supplier").val();
		var departemen = $("#departemen").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		var string = "kode="+kode+"&pilih="+pilih+"&tgl1="+tgl1+"&tgl2="+tgl2+"&supplier="+supplier+"&departemen="+departemen;
		
		 $("#tampil_data").html('');
		 $.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/lap_beli/lihat",
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
		var tgl1 = $("#tgl_1").val();
		var tgl2 = $("#tgl_2").val();
		var supplier = $("#supplier").val();
		var departemen = $("#departemen").val();
		
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		if(pilih=='supplier'){
			var string = pilih+"/"+supplier+"/tgl1/"+tgl1+"/tgl2/"+tgl2;
		}else if(pilih=='departemen'){
			var string = pilih+"/"+departemen+"/tgl1/"+tgl1+"/tgl2/"+tgl2;
		}else{
			var string = pilih+"/"+kode+"/tgl1/"+tgl1+"/tgl2/"+tgl2;
		}
		
		if(jml_pilih.length == 0){
           var error = true;
           alert("Maaf, Anda belum memilih");
		   return (false);
         }
		
		window.open('<?php echo site_url();?>/lap_beli/cetak/'+string);
		 
		return false();	
	});
	
});	
</script>
<fieldset class="atas">
<table width="100%">
<tr>    
	<td width="150">Tanggal</td>
    <td width="5"></td>
    <td><input type="text" name="tgl_1" id="tgl_1" size="12" maxlength="12" />
    s.d <input type="text" name="tgl_2" id="tgl_2" size="12" maxlength="12" />
    </td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="supplier" />Supplier</td>
    <td width="5"></td>
    <td>
    <select name="supplier" id="supplier">
    <option value="">-PILIH-</option>
    <?php 
	foreach($l_supp->result() as $t){
	?>
    <option value="<?php echo $t->supplier_code;?>"><?php echo $t->supplier_name;?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="departemen" />Departemen</td>
    <td width="5"></td>
    <td>
    <select name="departemen" id="departemen">
    <option value="">-PILIH-</option>
    <?php 
	foreach($l_dept->result() as $u){
	?>
    <option value="<?php echo $u->dept_code;?>"><?php echo $u->dept_code;?>-<?php echo $u->dept_name;?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="kode" />Kode Barang</td>
    <td width="5"></td>
    <td><input type="text" name="kode_brg" id="kode_brg" size="15" maxlength="15" /></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">CARI</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>
    <a href="<?php echo base_url();?>index.php/lap_beli/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">KEMBALI</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   