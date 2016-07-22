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
	/*
	$("#tgl_1").datepicker({
			dateFormat:"yy-mm-dd"
    });
	$("#tgl_2").datepicker({
			dateFormat:"yy-mm-dd"
    });
	*/
	$("#cari").click(function(){
	
		var mat_group = $("#mat_group").val();
		var kode = $("#kode_brg").val();
		var	pilih	= $(".pilih:checked").val();
		var departemen = $("#departemen").val();
		var jml_pilih = $(".pilih:checked");
		
		//var string = "tgl1="+tgl1+"&tgl2="+tgl2+"&pilih="+pilih+"&departemen="+departemen+"&kode="+kode+"&mat_group="+mat_group;
		var string = "pilih="+pilih+"&departemen="+departemen+"&kode="+kode+"&mat_group="+mat_group;
		/*
		if(tgl1.length == 0){
			var error = true;
			alert("Sorry, start date cannot leave empty");
		  $("#tgl_1").focus();
		  
			return (false);
    }
		if(tgl2.length == 0){
      var error = true;
      alert("Sorry, end date cannot leave empty");
		  $("#tgl_2").focus();
		  
			return (false);
    } */
		if(jml_pilih.length == 0){
      var error = true;
      alert("Sorry, You did not select any option");
		  
			return (false);
    }
		
		$("#tampil_data").html('');
		 
		var win = $.messager.progress({
			title:'Please wait',
			msg:'Loading data...',
			text: 'PROCESSING....'
		});
		 
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/lap_barang/lihat",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.progress('close');
				$("#tampil_data").html(data);
			}		
		});
		
		return false();	
	});
	
	$("#cetak").click(function(){
		//var tgl1 = $("#tgl_1").val();
		//var tgl2 = $("#tgl_2").val();
		var mat_group = $("#mat_group").val();
		var kode = $("#kode_brg").val();
		var dept = $("#departemen").val();
		var	pilih	= $(".pilih:checked").val();
		var jml_pilih = $(".pilih:checked");
		
		if(jml_pilih.length == 0){
      var error = true;
      alert("Sorry, You did not select any options");
		  
			return (false);
    }
		 
		//window.open('<?php echo site_url();?>/lap_barang/cetak/'+pilih+'/'+kode+dept+mat_group+'/'+tgl1+'/'+tgl2);
		window.open('<?php echo site_url();?>/lap_barang/cetak/'+pilih+'/'+kode+dept+mat_group);
		return false();
	});
});	
</script>
<fieldset class="atas">
<table width="100%">
<!--
<tr>    
	<td width="150">Start Date</td>
    <td><input type="text" name="tgl_1" id="tgl_1" size="12" maxlength="10" />
    to <input type="text" name="tgl_2" id="tgl_2" size="12" maxlength="10" />
    </td>
</tr> -->
<tr>
	<td><input type="radio" name="pilih" class="pilih" value="all" />All</td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="departemen" />Department</td>
    <td>
    <select name="departemen" id="departemen">
    <option value="">-SELECT-</option>
    <?php 
	foreach($l_dept->result() as $t){
	?>
    <option value="<?php echo $t->dept_code;?>"><?php echo $t->dept_name;?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>
	<td><input type="radio" name="pilih" class="pilih" value="group" />Material Group</td>
	<td>
		<select id="mat_group" name="mat_group">
			<option value="">-SELECT-</option>
			<option value="RAWRW">Assembling (RW)</option>
			<option value="RAWFR">Assembling (FR)</option>
			<option value="SUPFP">Final Process</option>
			<option value="SUPFN">Finishing</option>
			<option value="SUPGE">General</option>
			<option value="SUPUP">Upholstery</option>
		</select>
	</td>
</tr>
<tr>    
	<td width="150"><input type="radio" name="pilih" class="pilih" value="kode" />Item Code</td>
    
    <td><input type="text" name="kode_brg" id="kode_brg" size="18" maxlength="13" class="easyui-validatebox" data-options="required:true" /></td>
</tr>
</table>
</fieldset>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">SEARCH</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PRINT</button>
	<a href="<?php echo base_url();?>index.php/lap_barang">
	<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
	</a>
    <a href="<?php echo base_url();?>index.php/lap_barang/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>
<fieldset>
<div id="tampil_data"></div>
</fieldset>   