 <script type="text/javascript">
	$(document).ready(function(){
		$(':input:not([type="submit"])').each(function() {
			$(this).focus(function() {
				$(this).addClass('hilite');
			}).blur(function() {
				$(this).removeClass('hilite');});
		});
		
		$('#currency').numberbox({});
		
	});
 </script>
 <script>
		
	$(function() {
			$("#foto_brg").change(function() {
				var file = this.files[0];
				var fileName = $(this).val();
				var imagefile = file.type;
				var match= ["image/jpeg","image/png","image/jpg","image/bmp"];
				
				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
				{
					$('#show_img').attr('src','noimage.png');
					return false;
				}
				else
				{
					var reader = new FileReader();
					reader.onload = imageIsLoaded;
					reader.readAsDataURL(this.files[0]);
				}
			});
			
			$('#kembali1').click(function(){
				$('#data').form('clear');
				$('#dialogAcc').dialog('close');
			});
		});
		
		function imageIsLoaded(e) {
			$('#show_img').attr('src', e.target.result);
		};
		
		$("#departemen").attr("readonly","true");
		
		$("#nama_brg").validatebox({
			required : true
		});
		
		$("#price").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#psecure").numberbox({
			precision: 0,
			min:0,
			groupSeparator:','
		});
		
		
		$("#size_length").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_width").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_height").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_weight").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_volume").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_area").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_density").numberbox({
			precision: 2,
			min:0,
			groupSeparator:','
		});
		
		$("#size_diameter").numberbox({
			precision: 2,
			min:0,
			//groupSeparator:','
		});
		
		$("#size_diameterin").numberbox({
			precision: 2,
			min:0,
			//groupSeparator:','
		});
		
		
		$("#simpan").click(function(){
			
			var data 		= new FormData($('#data')[0]);
			var kode_brg	= $("#kode_brg").val();
			var nama_brg	= $("#nama_brg").val();
			//var departemen	= $("#departemen").combobox('getValue');
			var departemen	= $("#departemen option:selected").val();
			//alert(departemen);
			//var departemenname	= $("#departemen").combobox('getText');
			var temp = [];
			var tempkode ='';
			var temppesan='';
			var string = $("#data").serialize();
		
			data.append("kode_brg",  $("#kode_brg").val());
			data.append("nama_brg",  $("#nama_brg").val());
			data.append("nama_brg_en",  $("#nama_brg_en").val());
			data.append("foto_brg",  $("#foto_brg").val());
			data.append("family",  $("#family option:selected").val());
		
			if(departemen.length==0 || departemen=='-'){
				$.messager.show({
					title:'Info',
					msg:'Sorry, please select Departement', 
					timeout:2000,
					showType:'show'
				});
				$("#departemen").focus();
				return false();
			}
			if(nama_brg.length==0){
				$.messager.show({
					title:'Info',
					msg:'Sorry, Nama cannot leave empty', 
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
		
</script>
<div style="float:left; width:100%;">
<?php
	$widthlabelleft='8%';
	$widthlabelcenter='12%';
	$widthlabelright='6%';
	
	$widthdoubledot='1%';
	
	$widthinputleft='19%';
	$widthinputcenter='30%';
	$widthinputright='30%';
	
	$widthtable='100%';
	$widthtablelabelsize='10%';
	$widthtablelabeltype='18%';
	$widthtableinput='62%';
	$widthtableunit='5%';
	$widthtableblankrigth='7%';
?>
<form name="data" id="data">
<fieldset class="atas">
	<table width="100%">
		<tr>    
			<td width="<?=$widthlabelleft?>">Code Database</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputleft?>"><input type="text" name="kode_brg" id="kode_brg" size="24"  class="easyui-validatebox" readonly="readonly" /><input type="hidden" name="status" id="status" /></td>
			<td width="<?=$widthlabelcenter?>">Name</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>"><input type="text" name="nama_brg_en" id="nama_brg_en" size="40"  class="easyui-validatebox" /></td>
			<td width="<?=$widthlabelright?>">Nama</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputright?>"><input type="text" name="nama_brg" id="nama_brg" size="40" /></td>
		</tr>
		<tr>    
			<td width="<?=$widthlabelleft?>">Code No. 2</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthinputleft?>"><input type="text" name="kode_spc" id="kode_spc" size="24"  class="easyui-validatebox" /></td>   
				<td width="<?=$widthlabelcenter?>"></td>
				<td width="<?=$widthdoubledot?>"></td>
				<td width="<?=$widthinputright?>" colspan="4"></td>
		</tr>
		<tr> 
			<td width="<?=$widthlabelleft?>">Department</td>
				<td width="<?=$widthdoubledot?>">:</td>
				<td width="<?=$widthinputleft?>">
					<select class="easyui-combobox" data-options="
									required:true" 
									id="departemen" name="departemen" style="width:170px"> 
						<?php
							foreach($l_dept->result() as $dept) {
								if ($dept->dept_code=='ACCHRD'){
						?>
							<option value="<?=$dept->dept_code?>"> <?=$dept->dept_name?></option>
						<?php
								}
							}
						?>
					</select>
				</td>
				<td width="<?=$widthlabelcenter?>" class="tdfamily" id="tdfamily">Family</td>
				<td width="<?=$widthdoubledot?>"class="tdfamily1" id="tdfamily1">:</td>
				<td width="<?=$widthinputcenter?>" colspan="4"class="tdfamily2" id="tdfamily2">
					<select class="easyui-combobox" id="family" name="family" style="width:200px">
						<?php
							foreach($l_fam->result() as $fam) {
						?>
						<option value="<?=$fam->family_id?>"> <?=$fam->family?></option>
						<?php
							}
						?>
					</select>
				</td>
		</tr>
<?php
	//if ($foto_brg=="")
		$foto = base_url('asset/foto_produk/unknown.jpg');
	//else
	//	$foto = base_url('asset/foto_produk/'.$foto_brg);
?>
		<tr>    
			<td width="<?=$widthlabelleft?>"></td>
			<td width="<?=$widthdoubledot?>"></td>
			<td width="<?=$widthinputleft?>"></td>
			<td width="<?=$widthlabelcenter?>"  hidden="hidden">Category</td>
			<td width="<?=$widthdoubledot?>"  hidden="hidden">:</td>
			<td width="<?=$widthinputcenter?>" colspan="4" hidden="hidden">
				<select class="easyui-combobox" id="category" name="category" style="width:200px">
				</select>
			</td>
		</tr>
		<tr>    
			<td width="65" colspan="3" rowspan="10" align="center" valign="top"><img id="show_img" src="<?=$foto?>" width="260px" /><br/><input type="file" name="foto_brg" id="foto_brg" size="20"/></td>
			<td width="<?=$widthlabelcenter?>">Type</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>">
				<select class="easyui-combobox" id="type" name="type" style="width:200px">
					<?php
						foreach($l_type->result() as $type) {
							if ($type->type=='-'){
					?>
						<option value="<?=$type->type_id?>" selected="selected"> <?=$type->type?></option>
					<?php
							} else {
					?>
						<option value="<?=$type->type_id?>"> <?=$type->type?></option>
					<?php
							}
						}
					?>
				</select>
			</td>
			<td colspan="3" rowspan="4" valign="top"><div style="border:1px solid black;">
				<table border="0" width="100%">
					<tr>
						<td colspan="3" align="center"><u>Storage Posisition</u></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>No. Rack</td>
						<td>:&nbsp;&nbsp;<input type="text" name="rack" id="rack" size="10" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Row</td>
						<td>:&nbsp;&nbsp;<input type="text" name="row" id="row" size="10" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Column</td>
						<td>:&nbsp;&nbsp;<input type="text" name="column" id="column" size="10" /></td>
					</tr>
				</table></div>
			</td>
		</tr>
		<tr class="trmerk" id="trmerk">  
			<td width="<?=$widthlabelcenter?>">Merk</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>">
				<select class="easyui-combobox" id="merk" name="merk" style="width:200px">
					<option value=""> -- Select --</option>
					<?php
						foreach($l_merk->result() as $merk) {
					?>
					<option value="<?=$merk->merk_id?>"> <?=$merk->merk?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
		<tr class="trdetail" id="trdetail">    
			<td width="<?=$widthlabelcenter?>">Detail</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>"><input type="text" name="detail" id="detail" size="40" class="easyui-validatebox"/></td>
		</tr>
		<tr class="trbyper" id="trbyper">    
			<td width="<?=$widthlabelcenter?>">Buy Per</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>">
				<select class="easyui-combobox" data-options="required:true" id="satuan" name="satuan" style="width:200px">
					<?php
						foreach($l_satuan->result() as $satuan) {
							if ($satuan->unit_name=='Pcs'){
					?>
					<option value="<?=$satuan->unit_code?>" selected="selected"> <?=$satuan->unit_name?></option>
					<?php
							} else {
					?>
					<option value="<?=$satuan->unit_code?>"> <?=$satuan->unit_name?></option>
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
						<?php
							foreach($l_useper->result() as $unit) {
								if ($unit->unit_name=='Pcs'){
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
		<tr class="traveragewaste" id="traveragewaste">    
			<td width="<?=$widthlabelcenter?>" hidden="hidden">Average Waste</td>
			<td width="<?=$widthdoubledot?>" hidden="hidden">:</td>
			<td width="<?=$widthinputcenter?>" hidden="hidden"><input type="text" name="average_waste" id="average_waste" size="15"  class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" />&nbsp;&nbsp;&nbsp;( &#37; )</td>
		</tr>
		<tr class="trprice" id="trprice">    
			<td width="<?=$widthlabelcenter?>">Price</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>">
				<select name="currency" id="currency">
				<?php 
					foreach($l_curr->result() as $valuta) {
				?>
					<option value="<?=$valuta->currency_code?>"><?=$valuta->currency_name?></option>
				<?php
						
					}
				?>
				</select>
				<input type="text" name="price" id="price" size="20" style="text-align:right" />
			</td>
		</tr>
		<tr class="trpsecure" id="trpsecure">    
			<td width="<?=$widthlabelcenter?>">Price Secure</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>"><input type="text" name="psecure" id="psecure" size="15" style="text-align:right" />&nbsp;&nbsp;&nbsp;( &#37; )</td>
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
						<td width="<?=$widthtableinput?>" align="right" class="tdlength2" id="tdlength2">L &nbsp;<input type="text" name="size_length" id="size_length" size="10" style="text-align:right" data-options="onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; W &nbsp;<input type="text" name="size_width" id="size_width" size="10" style="text-align:right" data-options="onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; H &nbsp;<input type="text" name="size_height" id="size_height" size="10" style="text-align:right" data-options="onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('length');}}" /></td>
						<td width="<?=$widthtableunit?>" align="right" class="tdlength3" id="tdlength3">
							<select class="easyui-combobox" id="size_length_unit" name="size_length_unit" style="width:60px" data-options="onSelect:function(rec){onChangeFunction('length');}">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='length'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>" class="tdlength4" id="tdlength4"></td>
					</tr>
					<tr class="trweight" id="trweight">
						<td width="<?=$widthtablelabeltype?>">Weight</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_weight" id="size_weight" size="10"  style="text-align:right" data-options="onChange:function(newValue,oldValue){if (newValue!=oldValue){onChangeFunction('weight');}}" /></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_weight_unit" name="size_weight_unit" style="width:60px" data-options="onSelect:function(rec){onChangeFunction('weight');}">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='weight'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr>
						<td width="<?=$widthtablelabeltype?>">Volume</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_volume" id="size_volume" size="10"  style="text-align:right" /></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_volume_unit" name="size_volume_unit" style="width:60px">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='volume'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr class="trarea" id="trarea">
						<td width="<?=$widthtablelabeltype?>">Area</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_area" id="size_area" size="10" style="text-align:right" /></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_area_unit" name="size_area_unit" style="width:60px">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='area'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr class="trvolume" id="trvolume">
						<td width="<?=$widthtablelabeltype?>">Density</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_density" id="size_density" size="10" style="text-align:right"/></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_density_unit" name="size_density_unit" style="width:60px">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='density'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr class="trdiameterout" id="trdiameterout">
						<td width="<?=$widthtablelabeltype?>">Diameter out (&#8960; out)</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_diameter" id="size_diameter" size="10" style="text-align:right"/></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_diameter_unit" name="size_diameter_unit" style="width:60px">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='length'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr class="trdiameterin" id="trdiameterin">
						<td width="<?=$widthtablelabeltype?>">Diameter in (&#8960; in)</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_diameterin" id="size_diameterin" size="10"  style="text-align:right"/></td>
						<td width="<?=$widthtableunit?>" align="right">
							<select class="easyui-combobox" id="size_diameterin_unit" name="size_diameterin_unit" style="width:60px">
								<option value="">-Unit-</option>
								<?php
									foreach($l_ukuran->result() as $unit) {
										if ($unit->type=='length'){
								?>
									<option value="<?=$unit->unit_ukuran_id?>"> <?=$unit->simbol?><sup><?php echo $unit->ss_symbol; ?></sup></option>
								<?php
										}
									}
								?>
							</select>
						</td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
					<tr class="trthread" id="trthread">
						<td width="<?=$widthtablelabeltype?>">Thread</td>
						<td width="<?=$widthdoubledot?>">:</td>
						<td width="<?=$widthtableinput?>" align="right"><input type="text" name="size_thread" id="size_thread" size="10"  class="easyui-textbox" /></td>
						<td width="<?=$widthtableunit?>" align="right"></td>
						<td width="<?=$widthtableblankrigth?>"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="trspace01" id="trspace01">    
			<td width="<?=$widthlabelcenter?>">&nbsp;</td>
			<td width="<?=$widthdoubledot?>">&nbsp;</td>
			<td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
		</tr>
		<tr class="trwaste" id="trwaste">    
			<td width="<?=$widthtable?>" colspan="6" hidden="hidden">
				<table width="<?=$widthtable?>" border="0">
					<tr>
						<td width="<?=$widthtablelabelsize?>" rowspan="2">Waste</td>
						<td width="<?=$widthdoubledot?>" rowspan="2">:</td>
						<td width="<?=$widthtablelabeltype?>">Log to Plank ( % )</td>
						<td width="<?=$widthtablelabeltype?>">Plank to Raw ( % )</td>
						<td width="<?=$widthtablelabeltype?>">Raw to Finish ( % )</td>
					</tr>
					<tr>
						<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_log_plank" id="waste_log_plank" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" /></td>
						<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_plank_raw" id="waste_plank_raw" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" /></td>
						<td width="<?=$widthtablelabeltype?>"><input type="text" name="waste_raw_comp" id="waste_raw_comp" size="10" class="easyui-numberbox" style="text-align:right" data-options="min:0,precision:2" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="trspace02" id="trspace02">    
			<td width="<?=$widthlabelcenter?>">&nbsp;</td>
			<td width="<?=$widthdoubledot?>">&nbsp;</td>
			<td width="<?=$widthinputcenter?>" colspan="4">&nbsp;</td>
		</tr>
		<tr class="trmaterial" id="trmaterial">    
			<td width="<?=$widthlabelleft?>"></td>
			<td width="<?=$widthdoubledot?>"></td>
			<td width="<?=$widthinputleft?>"></td>
			<td width="<?=$widthlabelcenter?>">Material</td>
			<td width="<?=$widthdoubledot?>">:</td>
			<td width="<?=$widthinputcenter?>" colspan="4">
				<select class="easyui-combobox" id="material" name="material" style="width:200px">
					<?php
						foreach($l_material->result() as $tmaterial) {
							if ($tmaterial->material=='-'){
					?>
						<option value="<?=$tmaterial->material_id?>" selected="selected"><?=$tmaterial->material?></option>
					<?php
							} else {
					?>
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
					<option value="">-- Select --</option>
					<?php
						foreach($l_finishing->result() as $tfinishing) {
					?>
						<option value="<?=$tfinishing->finishing_id?>"><?=$tfinishing->finishing?></option>
					<?php
						}
					?>
				</select>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset class="bawah">
	<table width="1200px">
		<tr>
			<td colspan="3" align="center">
				<button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
				<button type="button" name="kembali1" id="kembali1" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CLOSE</button>
				</a>
			</td>
		</tr>
	</table>  
</fieldset> 
</form>
 </div>
 <script>
 /*
	function onChangeFunction(sizetype){
			//if (deptStatus!=0){
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
					height = Number(height)/100;
				} else if (length_unit.indexOf('km')!=-1){
					length = Number(length)*1000;
					width = Number(width)*1000;
					height = Number(height)*1000;
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
				
			//}
		}; */
 </script>
 

