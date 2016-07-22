<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});
	//$("#dialog").on("load",$(this).hide());
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$('#departemen  > input.ui-autocomplete-input ').css('width','100%');
	//$("#price").attr("readonly","true");
	$("#supplier").attr("readonly","true");
	
	//if ($("#status").val()=='2'){
		$("#kode_brg").attr("readonly","true");
	//}
	//else {
	//	$("#kode_brg").removeAttr("readonly");
	//}
	var ppnbox = '<?=$ppn?>';
	if (ppnbox==1){
		
		$('#ppn').prop('checked',true);
	} else {
		$('#ppn').prop('checked', false);
	}
	
	$("#turunan").combogrid('setValue','<?=$turunan?>');
	$("#stok_awal").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	
	$('#family').combobox('setValue','<?php echo $family; ?>');
	$('#combo_type').combobox('setValue','<?php echo $type; ?>');
	
	$("#density_unit").each(function(){
      if($(this).val() == "")
         $(this).remove();
     });
	
	$(function() {
		$("#foto_brg").change(function() {
			//$("#message").empty(); // To remove the previous error message
			var file = this.files[0];
			var fileName = $(this).val();
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg","image/bmp"];
			
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
				$('#show_img').attr('src','noimage.png');
				//$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
				return false;
			}
			else
			{
				var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
				//$('#foto_brg').attr('value',fileName);
			}
		});
		/*
		if ($.cookie('showDialog') == undefined || $.cookie('showDialog') == null || $.cookie('showDialog') != 'false') {
			$("#supplier").dialog({ 
				width: 450, 
				modal: "true",
				hide: "fade",
				show: "fade",
				closeOnEscape: false, 
				draggable: true,
				resizable: false,
				title: 'Welcome to my site', 
				//close: function(event, ui){ 
				//	location.reload(true); 
				//},
				open: function(event, ui) { $(".ui-dialog-titlebar-close").hide();  }
			}).dialog("open");
			
			$(".ui-widget-overlay").css({background: "#000", opacity: 0.8});

			$.cookie('showDialog', 'false', { expires: 365 }); 
		} */
	});
	function imageIsLoaded(e) {
		//$("#file").css("color","green");
		//$('#image_preview').css("display", "block");
		$('#show_img').attr('src', e.target.result);
		//resizeImageWithAspectRatio(e.target.result);
		//$('#show_img').attr('width', '250px');
		//$('#show_img').attr('height', '250px');
	};
	/*
	function resizeImageWithAspectRatio(img) {
		var maxWidth = 250; // Max width for the image
		var maxHeight = 250;    // Max height for the image
		var ratio = 0;  // Used for aspect ratio
		var width = img.width();    // Current image width
		var height = img.height();  // Current image height
 
	// Check if the current width is larger than the max
		if(width > maxWidth){
			ratio = maxWidth / width;   // get ratio for scaling image
			img.css("width", maxWidth); // Set new width
			img.css("height", height * ratio);  // Scale height based on ratio
			height = height * ratio;    // Reset height to match scaled image
			width = width * ratio;    // Reset width to match scaled image
		}
 
	// Check if current height is larger than max
		if(height > maxHeight){
			ratio = maxHeight / height; // get ratio for scaling image
			img.css("height", maxHeight);   // Set new height
			img.css("width", width * ratio);    // Scale width based on ratio
			width = width * ratio;    // Reset width to match scaled image
		}
		
		$('#show_img').attr('width', width);
		$('#show_img').attr('height', height);
	}
	*/
	/*
	$("#foto_brg").change(function (){
		var fileName = $(this).val();
        $(".filename").html(fileName);
		$("#show_img").attr("src", "/"+fileName+"?timestamp=" + new Date().getTime());
	}); */
	/*
	$("#show_img").one("load", function() {
		// do stuff
	}).each(function() {
	  if(this.complete) $(this).load();
	}); */
	/*
	$(".dialog").dialog({
		autoOpen: false,
		width: 450, 
		modal: true,
		hide: 'fade',
		show: 'fade',
		closeOnEscape: false, 
		draggable: true,
		resizable: false,
		title: 'Supplier List'
	});
	*/
	$("#supplier").click(function(e) {
		//var viewPag = "<?php echo site_url();?>index.php/barang/supplier";
		 e.preventDefault();
		 /*
		 $.post('<?php echo base_url();?>index.php/barang/supplier',function(response){
			$('#dialog').html(response);
		 }); */
		  $("#dialog").load('<?php echo base_url();?>index.php/barang/supplier');
		 /*
		 $("#dialog").load('<?php echo base_url();?>index.php/barang/supplier').dialog({
			autoOpen: false,
			width: 450, 
			modal: true,
			hide: 'fade',
			show: 'fade',
			closeOnEscape: false, 
			draggable: true,
			resizable: false,
			title: 'Supplier List',
			open: function(){
				$(this).load('<?php echo base_url();?>index.php/barang/supplier');
			} 
		 });*/
		 //$("#dialog").dialog("open");
		 /*
		 $("#dialog").dialog({
			autoOpen: false,
			width: 450, 
			modal: true,
			hide: 'fade',
			show: 'fade',
			closeOnEscape: false, 
			draggable: true,
			resizable: false,
			title: 'Supplier List'
		}); */
		 /*
		 $('<div></div>').dialog({
			width: 450, 
			modal: true,
			hide: 'fade',
			show: 'fade',
			closeOnEscape: false, 
			draggable: true,
			resizable: false,
			title: 'Welcome to my site',
			//close: function(event, ui){ 
                //location.reload(true); 
            //},
			open : function (type, data){
				$(this).parent().appendTo($("form"));
			}
			
		 }); */
		 
		 
	});
	$("#simpan").click(function(){
		var data 		= new FormData($('#data')[0]);
		var kode_brg	= $("#kode_brg").val();
		var nama_brg	= $("#nama_brg").val();
		var departemen	= $("#departemen").combobox('getValue');
		var unit				= $("#satuan").combobox('getValue');
		var useper				= $("#useper").combobox('getValue');
		var departemenname	= $("#departemen").combobox('getText');
		var temp = [];
		var tempkode ='';
		var temppesan='';
		var string = $("#data").serialize();
		var ppn = 0;
		
		if ($('#ppn').is(':checked')==true){
			ppn = 1;
		}
		
		data.append("kode_brg",  $("#kode_brg").val());
		data.append("nama_brg",  $("#nama_brg").val());
		data.append("nama_brg_en",  $("#nama_brg_en").val());
		data.append("foto_brg",  $("#foto_brg").val());
		data.append("family",  $("#family").combobox('getValue'));
		data.append("ppn",  ppn);
		/*
		data.append("merek",  $("#merek").combobox('getValue'));
		data.append("jenis",  $("#jenis").combobox('getValue'));
		data.append("detail",  $("#detail").val());
		data.append("satuan",  $("#satuan").combobox('getValue'));
		data.append("size",  $("#size").val());
		data.append("berat",  $("#berat").val()); 
		data.append("material",  $("#material").val());
		data.append("finishing",  $("#finishing").val()); */
		
		if(departemen.length==0 || departemen=='-'){
			$.messager.show({
				title:'Info',
				msg:'Sorry, please select Department', 
				timeout:2000,
				showType:'show'
			});
			$("#departemen").focus();
			return false();
		}
		
		if (unit.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, please select Buy Per (Unit)', 
				timeout:2000,
				showType:'show'
			});
			$("#satuan").focus();
			return false();
		}
		
		if (useper.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, please select Use Per (Unit)', 
				timeout:2000,
				showType:'show'
			});
			$("#useper").focus();
			return false();
		}
		
		if(nama_brg.length==0 && nama_brg_en.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Name / Nama cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_brg").focus();
			return false();
		}
		
		var win = $.messager.progress({
			title:'Please wait',
			msg:'Saving data...',
			text: 'PROCESSING....'
		});
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/barang/simpan",
			data	: data,
			cache	: false,
			processData: false,  // tell jQuery not to process the data
			contentType: false,   // tell jQuery not to set contentType
			success	: function(data){
				$.messager.progress('close');
				if (data.indexOf(',') != -1){
					temp = data.split(",");
					tempkode = temp[1];
					temppesan = temp[0];
				} else {
					temppesan = data;
				}
				
				$.messager.show({
					title:'Info',
					msg:temppesan, 
					timeout:2000,
					showType:'slide'
				});
				if (tempkode!=''){
					$('#kode_brg').val(tempkode);
				}
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.progress('close');
				$.messager.show({
					title:'Info',
					msg: 'Server not responding :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		
		return false();		
	});
	
	checkdept(index=0);
	
});	
</script>	
<?php
	$widthlabelleft='8%';
	$widthlabelcenter='12%';
	$widthlabelright='6%';
	
	$widthdoubledot='1%';
	
	$widthinputleft='16%';
	$widthinputcenter='30%';
	$widthinputright='30%';
	
	$widthtable='100%';
	$widthtablelabelsize='10%';
	$widthtablelabeltype='18%';
	$widthtableinput='62%';
	$widthtableunit='5%';
	$widthtableblankrigth='10%';
?>
<br/>
<form name="data" id="data">
<fieldset class="atas">
<table width="1200px">
<tr>    
	<td width="<?=$widthlabelleft?>">Code Database</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputleft?>"><input type="text" name="kode_brg" id="kode_brg" size="20"  class="easyui-validatebox" value="<?=$kode_brg?>"/><input type="hidden" name="status" id="status" value="<?=$status?>" /></td>
	<td width="<?=$widthlabelcenter?>">Name</td>
	<td width="<?=$widthdoubledot?>">:</td>
	<td width="<?=$widthinputcenter?>"><input type="text" name="nama_brg_en" id="nama_brg_en" size="40"  class="easyui-validatebox" value="<?=$nama_brg_en?>" /></td>
	<td width="<?=$widthlabelright?>">Nama</td>
	<td width="<?=$widthdoubledot?>">:</td>
	<td width="<?=$widthinputright?>"><input type="text" name="nama_brg" id="nama_brg" size="40"  class="easyui-validatebox" value="<?=$nama_brg?>" /></td>
</tr>
<tr>    
	<td width="<?=$widthlabelleft?>">Code No. 2</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputleft?>"><input type="text" name="kode_spc" id="kode_spc" size="20"  class="easyui-validatebox" value="<?=$kode_brg_spc?>"/></td>   
    <td width="<?=$widthlabelcenter?>"></td>
    <td width="<?=$widthdoubledot?>"></td>
    <td width="<?=$widthinputright?>" colspan="4"></td>
</tr>
<tr> 
	<td width="<?=$widthlabelleft?>">Department</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputleft?>">
		<select class="easyui-combobox" data-options="
						required:true,onSelect:checkdept" 
						id="departemen" name="departemen" style="width:150px">
						<?php if (empty($departemen)){ ?>
						<option value="-"> -- Select --</option>
						<?php
						}
							foreach($l_dept->result() as $dept) {
								//$dept_code = $dept->dept_code;
								//$dept_name = $dept->dept_name;
								if ($departemen==$dept->dept_code){
						?>
						<option value="<?=$dept->dept_code?>" selected="selected"> <?=$dept->dept_name?></option>
						<?php } else { ?>
						<option value="<?=$dept->dept_code?>"> <?=$dept->dept_name?></option>
						<?php
							}
							}
						?>
		</select>
	</td>
	<td width="<?=$widthlabelcenter?>" class="tdfamily" id="tdfamily">Category</td>
    <td width="<?=$widthdoubledot?>"class="tdfamily1" id="tdfamily1">:</td>
    <td width="<?=$widthinputcenter?>" colspan="1"class="tdfamily2" id="tdfamily2">
			<select class="easyui-combobox" data-options="valueField:'category_id',textField:'category',onSelect:function(rec){var dept = $('#departemen').combobox('getValue'); var url = '<?php echo site_url(); ?>/ref_json/DataFamily/'+dept+'/'+rec.category_id; $('#family').combobox('reload',url);}, onLoadSuccess:function(){$(this).combobox('select','<?php echo $category; ?>')}, url:'<?php echo site_url(); ?>/ref_json/DataCategory/<?php echo $departemen; ?>'" id="category" name="category" style="width:200px" />
		</td>
		<td class="tdfamily3" id="tdfamily3">Turunan</td>
		<td class="tdfamily4" id="tdfamily4">:</td>
		<td class="tdfamily5" id="tdfamily5">
			<select name="turunan" id="turunan" style="width:200px" class="easyui-combogrid" data-options="
			panelWidth: 550,
								panelHeight: 400,
								idField: 'kode_barang',
								textField: 'nama_barang',
								url: '<?php echo site_url(); ?>/ref_json/ComboboxAllMaterialTurunan',
								method: 'post',
								mode:'remote',
								columns: [[
									{field:'kode_barang',title:'Kode Barang',width:80, hidden:true},
									{field:'kode_barang_spc',title:'Code',width:70},
									{field:'nama_barang',title:'Name', align:'left', width:300},
									{field:'finishing',title:'Finishing', align:'left', width:100}
								]],
								fitColumns: true,
								filter: function(q, row){
									var opts = $(this).combogrid('options');
									return row[opts.textField].indexOf(q) == 0;
								},
								queryParams:{
									turunan: '<?=$turunan?>',
									departemen: $('#departemen').combobox('getValue'),
									nama_barang: $('#nama_brg').val()
								},
								pagination:true" />
		</td>
</tr>
<?php
	if ($foto_brg=="")
		$foto = base_url('asset/foto_produk/unknown.jpg');
	else
		$foto = base_url('asset/foto_produk/'.$foto_brg);
?>
<tr>    
    <td width="<?=$widthlabelleft?>"></td>
    <td width="<?=$widthdoubledot?>"></td>
    <td width="<?=$widthinputleft?>"></td>
	<td width="<?=$widthlabelcenter?>">Family</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>" colspan="4">
		<select class="easyui-combobox" data-options="valueField:'family_id',textField:'family', onLoadSuccess:function(){$(this).combobox('select','<?php echo $family; ?>')}, url:'<?php echo site_url(); ?>/ref_json/DataFamily/<?php echo $departemen; ?>/<?php echo $category; ?>', onSelect: function(rec){var dept = $('#departemen').combobox('getValue'); var turl ='<?php echo site_url(); ?>/ref_json/DataType/'+dept+'/'+rec.family_id; $('#combo_type').combobox('reload',turl);}" id="family" name="family" style="width:200px"/>
		
	</td>
</tr>
<tr>    
	<td width="65" colspan="3" rowspan="12" align="center" valign="top"><img id="show_img" src="<?php echo $foto; ?>" width="260px" /><br/><input type="file" name="foto_brg" id="foto_brg" size="20"/></td>
	<td width="<?=$widthlabelcenter?>">Type</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>">
		<select class="easyui-combobox" data-options="valueField:'type_id',textField:'type', url:'<?php echo site_url(); ?>/ref_json/DataType/<?php echo $departemen; ?>'" id="combo_type" name="combo_type" style="width:200px" />
	</td>
	<td colspan="3" rowspan="4" valign="top"><div style="border:1px solid black;">
		<table border="0" width="100%">
			<tr>
				<td colspan="3" align="center"><u>Storage Posisition</u></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>No. Rack</td>
				<td>:&nbsp;&nbsp;<input type="text" name="rack" id="rack" size="10" value="<?=$rack?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Row</td>
				<td>:&nbsp;&nbsp;<input type="text" name="row" id="row" size="10" value="<?=$row?>" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>Column</td>
				<td>:&nbsp;&nbsp;<input type="text" name="column" id="column" size="10" value="<?=$column?>" /></td>
			</tr>
		</table></div>
	</td>
</tr>
<tr class="trmerk" id="trmerk">  
    <td width="<?=$widthlabelcenter?>">Merk</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>">
		<select class="easyui-combobox" data-options="required:true" id="merk" name="merk" style="width:200px">
			<?php if (empty($merk)){ ?>
			<option value="-"> -- Merk --</option>
			<?php
			}
				foreach($l_merk->result() as $merek) {
					//$dept_code = $dept->dept_code;
					//$dept_name = $dept->dept_name;
					if ($merk==$merek->merk_id){
			?>
			<option value="<?=$merek->merk_id?>" selected="selected"><?=$merek->merk?></option>
			<?php } else { ?>
			<option value="<?=$merek->merk_id?>"><?=$merek->merk?></option>
			<?php
				}
				}
			?>
		</select>
	</td>
</tr>
<tr class="trdetail" id="trdetail">    
    <td width="<?=$widthlabelcenter?>">Detail</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>"><input type="text" name="detail" id="detail" size="40"  class="easyui-validatebox" value="<?=$detail?>" /></td>
</tr>
<tr class="trbyper" id="trbyper">    
    <td width="<?=$widthlabelcenter?>">Buy Per</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>">
			<select class="easyui-combobox" data-options="required:true" id="satuan" name="satuan" style="width:200px">
			<?php if (empty($satuan) || $satuan==0){ ?>
				<option value=""> -- Unit --</option>
				<?php
				}
					foreach($l_satuan->result() as $unit) {
						//$unit_code = $unit->unit_code;
						//$unit_name = $unit->unit_name;
						if ($satuan==$unit->unit_code){
				?>
				<option value="<?=$unit->unit_code?>" selected="selected"> <?=$unit->unit_name?></option>
				<?php } else { ?>
				<option value="<?=$unit->unit_code?>"> <?=$unit->unit_name?></option>
				<?php
					}
					}
				?>
			</select>
	</td>
</tr>
<tr class="trbyper">
	<td width="<?=$widthlabelcenter?>">Use Per</td>
	<td width="<?=$widthdoubledot?>">:</td>
	<td width="<?=$widthinputcenter?>">
		<select class="easyui-combobox" data-options="required:true" id="useper" name="useper" style="width:200px">
		<?php if (empty($useper) || $useper==0){ ?>
				<option value=""> -- Unit --</option>
				<?php
				}
					foreach($l_useper->result() as $unit) {
						//$unit_code = $unit->unit_code;
						//$unit_name = $unit->unit_name;
						if ($useper==$unit->unit_code){
				?>
				<option value="<?=$unit->unit_code?>" selected="selected"> <?=$unit->unit_name?></option>
				<?php } else { ?>
				<option value="<?=$unit->unit_code?>"> <?=$unit->unit_name?></option>
				<?php
					}
					}
				?>
		</select>
	</td>
</tr>
<!--
<tr>
	<td width="<?=$widthlabelcenter?>">Min Qty Buy</td>
	<td width="<?=$widthdoubledot?>">:</td>
	<td width="<?=$widthinputcenter?>">
		<input type="text" name="min_qty" id="min_qty" size="15"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$min_qty?>" />
	</td>
</tr> -->
<tr class="traveragewaste" id="traveragewaste">    
    <td width="<?=$widthlabelcenter?>">Average Waste</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>"><input type="text" name="average_waste" id="average_waste" size="15"  class="easyui-numberbox" style="text-align:right" data-options="precision:2" value="<?=$average_waste?>" />&nbsp;&nbsp;&nbsp;( &#37; )</td>
</tr>
<tr class="trprice" id="trprice">    
    <td width="<?=$widthlabelcenter?>">Price for calculation</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>"><select name="currency" id="currency" hidden="true">
				<?php 
					foreach($l_curr->result() as $valuta) {
					  if ($currency==$valuta->currency_code){
				?>
				<option value="<?=$valuta->currency_code?>" selected="selected"><?=$valuta->currency_name?></option>
				<?php
				    } else {
				?>
					<option value="<?=$valuta->currency_code?>"><?=$valuta->currency_name?></option>
				<?php
						}
					}
				?>
			</select>
			<input type="text" name="price" id="price" size="15"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:0,groupSeparator:','" value="<?=$price?>" /> ,  <input type="checkbox" name="ppn" id="ppn" /> PPN already include</td>
</tr>
<tr class="trpsecure" id="trpsecure">    
    <td width="<?=$widthlabelcenter?>">Price Secure</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>"><input type="text" name="psecure" id="psecure" size="15"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$psecure?>" />&nbsp;&nbsp;&nbsp;( &#37; )</td>
</tr>
<tr class="trspace0" id="trspace0">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>">&nbsp;</td>
</tr>
<tr>    
    <td width="<?=$widthtable?>" colspan="6">
		<table width="<?=$widthtable?>" border="0">
			<tr>
				<td width="<?=$widthtablelabelsize?>" rowspan="8" valign="top">Size</td>
				<td width="<?=$widthtablelabeltype?>" class="tdlength" id="tdlength">Length</td>
				<td width="<?=$widthdoubledot?>" class="tdlength1" id="tdlength1">:</td>
				<td width="<?=$widthtableinput?>" align="right" class="tdlength2" id="tdlength2">L &nbsp;<input type="text" name="size_length" id="size_length" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" value="<?=$size_length?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; W &nbsp;<input type="text" name="size_width" id="size_width" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" value="<?=$size_width?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; H &nbsp;<input type="text" name="size_height" id="size_height" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" value="<?=$size_height?>" /></td>
				<td width="<?=$widthtableunit?>" align="right" class="tdlength3" id="tdlength3">
					<select class="easyui-combobox" id="size_length_unit" name="size_length_unit" style="width:60px" data-options="onSelect:function(rec){onChangeFunction('length');}">
<?php 
						if (empty($size_length_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='length'){
						if ($size_length_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>" class="tdlength4" id="tdlength4"></td>
			</tr>
			<tr class="trweight" id="trweight">
				<td width="<?=$widthtablelabeltype?>">Weight</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_weight" id="size_weight" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2,onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('weight');}}" value="<?=$size_weight?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_weight_unit" name="size_weight_unit" style="width:60px" data-options="onSelect:function(rec){onChangeFunction('weight');}">
<?php 
						if (empty($size_weight_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='weight'){
						if ($size_weight_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr>
				<td width="<?=$widthtablelabeltype?>">Volume</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_volume" id="size_volume" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$size_volume?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_volume_unit" name="size_volume_unit" style="width:60px">
<?php 
						if (empty($size_volume_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='volume'){
						if ($size_volume_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr class="trarea" id="trarea">
				<td width="<?=$widthtablelabeltype?>">Area</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_area" id="size_area" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$size_area?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_area_unit" name="size_area_unit" style="width:60px">
<?php 
						if (empty($size_area_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='area'){
						if ($size_area_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr class="trvolume" id="trvolume">
				<td width="<?=$widthtablelabeltype?>">Density</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_density" id="size_density" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$size_density?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_density_unit" name="size_density_unit" style="width:60px">
<?php 
						if (empty($size_density_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='density'){
						if ($size_density_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr class="trdiameterout" id="trdiameterout">
				<td width="<?=$widthtablelabeltype?>">Diameter out (&#8960; out)</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_diameter" id="size_diameter" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$size_diameter?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_diameter_unit" name="size_diameter_unit" style="width:60px">
<?php 
						if (empty($size_diameter_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
						if ($unit->type=='length'){
						if ($size_diameter_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr class="trdiameterin" id="trdiameterin">
				<td width="<?=$widthtablelabeltype?>">Diameter in (&#8960; in)</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_diameterin" id="size_diameterin" size="10"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?=$size_diameterin?>" /></td>
				<td width="<?=$widthtableunit?>" align="right">
					<select class="easyui-combobox" id="size_diameterin_unit" name="size_diameterin_unit" style="width:60px">
<?php 
						if (empty($size_diameterin_unit)){ 
?>
							<option value=""> Unit</option>
<?php
						}
						foreach($l_ukuran->result() as $unit) {
						if ($unit->type=='length'){
						if ($size_diameterin_unit==$unit->unit_ukuran_id){
			?>
			<option value="<?=$unit->unit_ukuran_id?>" selected="selected"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol;?></sup></option>
			<?php
				}
				}}
			?>
					</select>
				</td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr>
			<tr class="trthread" id="trthread">
				<td width="<?=$widthtablelabeltype?>">Thread</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_thread" id="size_thread" size="10"  class="easyui-textbox" value="<?php echo $size_thread;?>" /></td>
				<td width="<?=$widthtableunit?>" align="right"></td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr><!--
			<tr class="trvolume" id="trvolume">
				<td width="<?=$widthtablelabeltype?>">Density</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_density_code" id="size_density_code" size="10"  class="easyui-textbox" value="<?php echo $size_thread;?>" /></td>
				<td width="<?=$widthtableunit?>" align="right"></td>
				<td width="<?=$widthtableblankrigth?>"></td>
			</tr> -->
		</table>
	</td>
</tr>
<tr class="trspace01" id="trspace01">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr class="trwaste" id="trwaste">    
	<td width="<?=$widthtable?>" colspan="6">
		<table width="<?=$widthtable?>" border="0">
			<tr>
				<td width="<?=$widthtablelabelsize?>" rowspan="2">Waste</td>
				<td width="<?=$widthdoubledot?>" rowspan="2">:</td>
				<td width="<?=$widthtablelabeltype?>">Log to Plank ( % )</td>
				<td width="<?=$widthtablelabeltype?>">Plank to Raw ( % )</td>
				<td width="<?=$widthtablelabeltype?>">Raw to Finish ( % )</td>
			</tr>
			<tr>
				<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_log_plank" id="waste_log_plank" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?php echo $waste_log_plank;?>" /></td>
				<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_plank_raw" id="waste_plank_raw" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?php echo $waste_plank_raw;?>" /></td>
				<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_raw_comp" id="waste_raw_comp" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" value="<?php echo $waste_raw_comp;?>" /></td>
			</tr>
		</table>
	</td>
</tr>
<tr class="trspace02" id="trspace02">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<!--
<tr>    
    <td width="100">Berat</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="200" colspan="4"><input type="text" name="berat" id="berat" size="50"  class="easyui-validatebox"/></td>
</tr>
-->
<tr class="trmaterial" id="trmaterial">    
		<td width="<?=$widthlabelleft?>"></td>
    <td width="<?=$widthdoubledot?>"></td>
    <td width="<?=$widthinputleft?>"></td>
    <td width="<?=$widthlabelcenter?>">Material</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>" colspan="4">
		<select class="easyui-combobox" id="material" name="material" style="width:200px">
		<?php 
			if (empty($material) OR !isset($material) || $material=='-'){ ?>
			<option value=""> -- Material --</option>
			<?php
			}
				foreach($l_material->result() as $tmaterial) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
					if ($material==$tmaterial->material_id){
			?>
			<option value="<?=$tmaterial->material_id?>" selected="selected"><?=$tmaterial->material?></option>
			<?php } else { ?>
			<option value="<?=$tmaterial->material_id?>"><?=$tmaterial->material?></option>
			<?php
				}
				}
			?>
		</select>
	</td>
</tr>
<tr class="trfinishing" id="trfinishing">  
		<td width="<?=$widthlabelleft?>"></td>
    <td width="<?=$widthdoubledot?>"></td>
    <td width="<?=$widthinputleft?>"></td>
    <td width="<?=$widthlabelcenter?>">Material Finishing</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>" colspan="4">
		<select class="easyui-combobox" id="finishing" name="finishing" style="width:200px">
		<?php if (empty($finishing) OR !isset($material) || $material=='-'){ ?>
			<option value=""> -- Finishing --</option>
			<?php
			}
				foreach($l_finishing->result() as $tfinishing) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
					if ($finishing==$tfinishing->finishing_id){
			?>
			<option value="<?=$tfinishing->finishing_id?>" selected="selected"><?=$tfinishing->finishing?></option>
			<?php } else { ?>
			<option value="<?=$tfinishing->finishing_id?>"><?=$tfinishing->finishing?></option>
			<?php
				}
				}
			?>
		</select>
	</td>
</tr>
<tr class="trspace" id="trspace">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr>  
	<td width="<?=$widthlabelleft?>" class="tdsupplier" id="tdsupplier"></td>
    <td width="<?=$widthdoubledot?>" class="tdsupplier1" id="tdsupplier1"></td>
    <td width="<?=$widthinputleft?>" class="tdsupplier2" id="tdsupplier2"></td>
	<td width="<?=$widthlabelcenter?>">Supplier</td>
    <td width="<?=$widthdoubledot?>">:</td>
    <td width="<?=$widthinputcenter?>" colspan="4">
		<button name="supplier" id="supplier" size="50">View</button>
		<div id="dialog">
		</div>
	</td>
</tr>
<tr class="trhide1" id="trhide1">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr class="trhide2" id="trhide2">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr class="trhide3" id="trhide3">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr class="trhide4" id="trhide4">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<tr class="trhide5" id="trhide5">    
    <td width="<?=$widthlabelcenter?>">&nbsp;</td>
    <td width="<?=$widthdoubledot?>">&nbsp;</td>
    <td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
</tr>
<!--
<tr>    
	<td width="100">Nama Barang</td>
    <td width="5">:</td>
    <td width="50"><input type="text" name="nama_brg" id="nama_brg"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $nama_brg;?>"/></td>
</tr> 
<tr>    
	<td width="100">Satuan</td>
    <td width="5">:</td>
    <td width="100">
		<select class="easyui-combobox" data-options="required:true" id="satuan" name="satuan">
			<?php if (empty($satuan)){ ?>
			<option value="-"> -- Satuan --</option>
			<?php
			}
				foreach($l_satuan->result() as $unit) {
					//$unit_code = $unit->unit_code;
					//$unit_name = $unit->unit_name;
					if ($satuan==$unit->unit_code){
			?>
			<option value="<?=$unit->unit_code?>" selected="selected"><?=$unit->unit_name?></option>
			<?php } else { ?>
			<option value="<?=$unit->unit_code?>"><?=$unit->unit_name?></option>
			<?php
				}
				}
			?>
		</select>
		
</tr>
<tr>    
	<td width="100">Departemen</td>
    <td width="5">:</td>
    <td width="100">
	<select class="easyui-combobox" data-options="required:true" id="departemen" name="departemen">
			<?php if (empty($departemen)){ ?>
			<option value="-"> -- Departemen --</option>
			<?php
			}
				foreach($l_dept->result() as $dept) {
					//$dept_code = $dept->dept_code;
					//$dept_name = $dept->dept_name;
					if ($departemen==$dept->dept_code){
			?>
			<option value="<?=$dept->dept_code?>" selected="selected"><?=$dept->dept_name?></option>
			<?php } else { ?>
			<option value="<?=$dept->dept_code?>"><?=$dept->dept_name?></option>
			<?php
				}
				}
			?>
		</select>
	</td>
</tr> -->
</table>
</fieldset>
<fieldset class="bawah">
<table width="1200px">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/barang/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a> 
		<?php if ($status=='2'){?>
    <a href="<?php echo base_url();?>index.php/barang/index/<?php echo $hal; ?>">
		<?php } else { ?>
    <a href="<?php echo base_url();?>index.php/barang/">
		<?php } ?>
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
<script>
  $('tr.trhide1').hide();
  $('tr.trhide2').hide();
  $('tr.trhide3').hide();
  $('tr.trhide4').hide();
  $('tr.trhide5').hide();
	checkdept(index=0);
	checkcategory(index=0);
	var deptStatus = 0;
	
	function checkcategory(index){
		var mycat = '';
		var urlfamily = '<?php echo site_url(); ?>/ref_json/DataFamily/';
		mycat = $('#category').combobox('getText');
		$('#family').combobox('reload',urlfamily+mycat);
	};
	
	function checkdept(index){
		//return 
		
		var mydept = '';
		var urltype = '<?php echo site_url(); ?>/ref_json/DataType/';
		var urlcategory = '<?php echo site_url(); ?>/ref_json/DataCategory/';
		var urlturunan = '<?php echo site_url(); ?>/ref_json/ComboboxAllMaterialTurunan';
		var dept_code = $('#departemen').combobox('getValue');
		mydept = $('#departemen').combobox('getText');
		$('#size_volume').numberbox('enable');
		$('#size_volume_unit').combobox('select','');
		$('#size_volume_unit').combobox('enable');
		$('#size_area').numberbox('enable');
		$('#size_area_unit').combobox('select','');
		$('#size_area_unit').combobox('enable');
		$('#size_density').numberbox('enable');
		//$('#size_density_unit').combobox('select','');
		$('#size_density_unit').combobox('enable');
		$('#category').combobox('clear');
		$('#family').combobox('clear');
		if (mydept.indexOf('Wood')!=-1){
			mydept = 'Wood';
			$('tr.trmerk').hide();
			$('td.tdfamily').hide();
			$('td.tdfamily1').hide();
			$('td.tdfamily2').hide(); 
			$('td.tdfamily3').hide(); 
			$('td.tdfamily4').hide(); 
			$('td.tdfamily5').hide(); 
			$('tr.trdetail').hide(); 
			//$('tr.trbyper').hide(); 
			$('tr.traveragewaste').hide(); 
			$('tr.trmaterial').hide(); 
			$('tr.trfinishing').hide(); 
			$('td.tdsupplier').hide(); 
			$('td.tdsupplier1').hide(); 
			$('td.tdsupplier2').hide(); 
			$('td.tdlength').hide(); 
			$('td.tdlength1').hide(); 
			$('td.tdlength2').hide(); 
			$('td.tdlength3').hide(); 
			$('td.tdlength4').hide(); 
			$('tr.trweight').hide(); 
			$('tr.trvolume').hide(); 
			$('tr.trarea').hide(); 
			$('tr.trdiameterin').hide(); 
			$('tr.trdiameterout').hide(); 
			$('tr.trthread').hide(); 
			$('tr.trhide1').show();
			$('tr.trhide2').show();
			$('tr.trhide3').show();
			$('tr.trhide4').show();
			$('tr.trhide5').show();
			$('tr.trspace').hide();
			$('tr.trwaste').show();
			//$('tr.trspace0').hide();
			deptStatus = 0;
		} else if (mydept.indexOf('Panel')!=-1){
			mydept = 'Panel';
			$('tr.trmerk').hide();
			$('td.tdfamily').hide();
			$('td.tdfamily1').hide();
			$('td.tdfamily2').hide(); 
			$('td.tdfamily3').hide(); 
			$('td.tdfamily4').hide(); 
			$('td.tdfamily5').hide(); 
			$('tr.trdetail').hide(); 
			//$('tr.trbyper').hide(); 
			$('tr.traveragewaste').hide(); 
			$('tr.trmaterial').hide(); 
			$('tr.trfinishing').hide(); 
			$('td.tdsupplier').hide(); 
			$('td.tdsupplier1').hide(); 
			$('td.tdsupplier2').hide(); 
			$('td.tdlength').show(); 
			$('td.tdlength1').show(); 
			$('td.tdlength2').show(); 
			$('td.tdlength3').show(); 
			$('td.tdlength4').show(); 
			$('tr.trweight').show(); 
			$('tr.trvolume').show(); 
			$('tr.trarea').show(); 
			$('tr.trdiameterin').hide(); 
			$('tr.trdiameterout').hide(); 
			$('tr.trthread').hide(); 
			$('tr.trhide1').show();
			$('tr.trhide2').show();
			$('tr.trhide3').show();
			$('tr.trhide4').show();
			$('tr.trhide5').show();
			$('tr.trspace').hide();
			$('tr.trwaste').hide();
			$('#size_volume').numberbox('disable');
			$('#size_volume_unit').combobox('select','17');
			$('#size_volume_unit').combobox('disable');
			$('#size_area').numberbox('disable');
			$('#size_area_unit').combobox('select','18');
			$('#size_area_unit').combobox('disable');
			$('#size_density').numberbox('disable');
			$('#size_density_unit').combobox('select','22');
			$('#size_density_unit').combobox('disable');
			deptStatus = 1;
		} else {
			if (mydept.indexOf('Accessories')!=-1){
				mydept = 'Accessories';
			} else if (mydept.indexOf('Upholstery')!=-1){
				mydept =  'Upholstery';
			} else if (mydept.indexOf('Finishing')!=-1){
				mydept =  'Finishing';
			} else if (mydept.indexOf('Sanding')!=-1){
				mydept =  'Sanding';
			} else if (mydept.indexOf('Veneer')!=-1){
				mydept =  'Veneer';
			} else if (mydept.indexOf('Packing')!=-1){
				mydept =  'Packing';
			} else if (mydept.indexOf('Glass')!=-1){
				mydept =  'Glass';
			} else if (mydept.indexOf('Assembling')!=-1){
				mydept =  'Assembling';
			}
			
			$('tr.trmerk').show();
			$('td.tdfamily').show();
			$('td.tdfamily1').show();
			$('td.tdfamily2').show();
			$('td.tdfamily3').show();
			$('td.tdfamily4').show();
			$('td.tdfamily5').show();
			$('tr.trdetail').show(); 
			//$('tr.trbyper').show(); 
			$('tr.traveragewaste').show(); 
			$('tr.trmaterial').show(); 
			$('tr.trfinishing').show(); 
			$('td.tdsupplier').show(); 
			$('td.tdsupplier1').show(); 
			$('td.tdsupplier2').show(); 
			$('td.tdlength').show(); 
			$('td.tdlength1').show(); 
			$('td.tdlength2').show(); 
			$('td.tdlength3').show(); 
			$('td.tdlength4').show(); 
			$('tr.trweight').show(); 
			$('tr.trvolume').show(); 
			$('tr.trarea').show(); 
			$('tr.trdiameterin').show(); 
			$('tr.trdiameterout').show(); 
			$('tr.trthread').show(); 
			$('tr.trhide1').hide();
			$('tr.trhide2').hide();
			$('tr.trhide3').hide();
			$('tr.trhide4').hide();
			$('tr.trhide5').hide();
			$('tr.trspace').show();
			$('tr.trwaste').hide();
			//$('tr.trspace0').show();
			deptStatus = 0;
		}
		
		$('#category').combobox('reload',urlcategory+mydept);
		$('#combo_type').combobox('reload',urltype+dept_code);
		/*
		$('#turunan').combogrid({
			queryParams: {
				departemen: $('#departemen').combobox('getValue'),
				//q:'<?=$nama_turunan?>'
			}
		});
		$('#turunan').combogrid('grid').datagrid('reload',urlturunan);
		*/
	};
	
	function onChangeFunction(sizetype){
		if (deptStatus!=0){
			var length = $('#size_length').numberbox('getValue');
			var width = $('#size_width').numberbox('getValue');
			var height = $('#size_height').numberbox('getValue');
			var weight = $('#size_weight').numberbox('getValue');
			
			var length_unit = '';
			var weight_unit = '';
			var V=0;
			var A=0;
			var D=0;
			
			length_unit = $('#size_length_unit').combobox('getText');
			weight_unit = $('#size_weight_unit').combobox('getText');
			
			if (length_unit.indexOf('mm')!=-1){
				length = Number(length)/1000;
				width = Number(width)/1000;
				height = Number(height)/1000;
			} else if (length_unit.indexOf('cm')!=-1){
				length = Number(length)/100;
				width = Number(width)/100;
				height = Number(height)/100; /*
			} else if (length_unit.indexOf('km')!=-1){
				length = Number(length)*1000;
				width = Number(width)*1000;
				height = Number(height)*1000; */
			} else if (length_unit.indexOf('ft')!=-1){
				length = Number(length)/3.28;
				width = Number(width)/3.28;
				height = Number(height)/3.28;
			} else if (length_unit.indexOf('in')!=-1){
				length = Number(length)/39.37;
				width = Number(width)/39.37;
				height = Number(height)/39.37;
			} else if (length_unit.indexOf('m')==-1){
				length = 0;
				width = 0;
				height = 0;
			}
			
			if (weight_unit.indexOf('g')!=-1 && weight_unit.indexOf('mg')==-1 && weight_unit.indexOf('kg')==-1){
				weight = Number(weight) / 1000;
			} else if (weight_unit.indexOf('kg')==-1) {
				weight = 0;
			}
			V = length*width*height;
			A = length*width;
			D = Number(weight)/V;
			if (sizetype.indexOf('length')!=-1){
				$('#size_volume').numberbox('setValue',V);
				$('#size_area').numberbox('setValue',A);
			}
			
			$('#size_density').numberbox('setValue',D);
			
		}
	};
</script>
