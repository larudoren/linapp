<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#pusername").focus();
	
	if ($("#status").val()=='2'){
		$("#pusername").attr("readonly","true");
	}
	else {
		$("#pusername").removeAttr("readonly");
	}
	
	$("#simpan").click(function(){
		var pusername		= $("#pusername").val();
		var pnama_lengkap	= $("#pnama_lengkap").val();
		var pwd				= $("#pwd").val();
		
		var string = $("form").serialize();
		
		if(pusername.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Username cannot leave blank', 
				timeout:2000,
				showType:'show'
			});
			$("#username").focus();
			return false();
		}
		if(pnama_lengkap.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Full Name cannot leave blank', 
				timeout:2000,
				showType:'show'
			});
			$("#pnama_lengkap").focus();
			return false();
		}
		/*
		if(pwd.length==0){
			$.messager.show({
				title:'Info',
				msg:'Maaf, Password tidak boleh kosong', 
				timeout:2000,
				showType:'show'
			});
			$("#pwd").focus();
			return false();
		}
		*/
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pengguna/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				//CariSimpanan();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server tidak merespon :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();		
	});
	
});	
</script>
<form name="form" id="form">
	<table width="100%">
		<tr>
			<td valign="top" width="50%">

<fieldset class="atas">
				<table width="100%">
					<tr>    
						<td width="150">Username</td>
							<td width="5">:</td>
							<td><input type="text" name="pusername" id="pusername" size="20" maxlength="20" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $pusername;?>" /><input type="hidden" name="status" id="status" value="<?php echo $status; ?>" /></td>
					</tr>
					<tr>    
						<td>Full Name</td>
							<td>:</td>
							<td><input type="text" name="pnama_lengkap" id="pnama_lengkap"  size="50" maxlength="50" class="easyui-validatebox" data-options="required:true,validType:'length[3,10]'" value="<?php echo $pnama_lengkap;?>"/></td>
					</tr>
					<tr>    
						<td>Password</td>
							<td>:</td>
							<td><input type="password" name="pwd" id="pwd"  size="20" maxlength="20"/>
							To change the password, please input the new combination 
							</td>
					</tr>
					<tr>    
						<td>Level</td>
						<td>:</td>
						<td>
							<select name="level" id="level">
								<?php 
								if(empty($level)){
								?>
								<option value="">-PILIH-</option>
								<?php
								}
								foreach($l_level->result() as $t){
									if($level==$t->id_level){
								?>
								<option value="<?php echo $t->id_level;?>" selected="selected"><?php echo $t->level;?></option>
									<?php }else{ ?>
								<option value="<?php echo $t->id_level;?>"><?php echo $t->level;?></option>
								<?php }
								} ?>
							</select></td>
					</tr>
				</table>
</fieldset>
</td>
</tr>
<tr>
<td valign="top" width="50%">
    <fieldset class="atas">
		<div id="pengguna" class="easyui-tabs" style="width:900px">
		<div title="Menu" id="menu">
			<table id="dataTable" width="100%">
		<th>Module</th>
		<th width="10%">View</th>
	<?php
		$no=1;
		foreach($l_menu_h->result() as $h){
			$menu = $h->MENUID;
	?>
			<tr>
				<td><?php echo $no.' - '.$h->TEXTCHILD;?></td>
				<td>&nbsp;</td>
			</tr>
	<?php	
				foreach($l_menu_d->result() as $dt){
					if ($dt->PARENTID==$menu){
						if (empty($dt->view) || $dt->view==0){
	?>
							<tr>
								<td style="padding-left:25px"><?php echo $dt->TEXTCHILD;?></td>
								<td align="center"><input type="checkbox" name="<?php echo 'menu_'.$dt->MENUID; ?>" id="<?php echo 'menu_'.$dt->MENUID; ?>" value="<?php echo $dt->MENUID ?>" /></td>
							</tr>	
	<?php
						} else{
	?>
							<tr>
								<td style="padding-left:25px"><?php echo $dt->TEXTCHILD;?></td>
								<td align="center"><input type="checkbox" name="<?php echo 'menu_'.$dt->MENUID; ?>" id="<?php echo 'menu_'.$dt->MENUID; ?>" value="<?php echo $dt->MENUID ?>" checked="checked" /></td>
							</tr>
	<?php
						}
					}
				}
			$no++;
		}
	?>
			</table>
			</div>
			<div title="Cotation" id="cotation">
				<table id="dataTable" width="100%">
					<th>Cotation</th>
					<th width="10%">View</th>
	<?php	
				foreach($l_cotation_d->result() as $dt){
				//	if ($dt->PARENTID==$menu){
						if (empty($dt->view) || $dt->view==0){
	?>
							<tr>
								<td style="padding-left:25px"><?php echo $dt->TEXTCHILD;?></td>
								<td align="center"><input type="checkbox" name="<?php echo 'cotation_'.$dt->COTATIONID; ?>" id="<?php echo 'cotation_'.$dt->COTATIONID; ?>" value="<?php echo $dt->COTATIONID ?>" /></td>
							</tr>	
	<?php
						} else{
	?>
							<tr>
								<td style="padding-left:25px"><?php echo $dt->TEXTCHILD;?></td>
								<td align="center"><input type="checkbox" name="<?php echo 'cotation_'.$dt->COTATIONID; ?>" id="<?php echo 'cotation_'.$dt->COTATIONID; ?>" value="<?php echo $dt->COTATIONID ?>" checked="checked" /></td>
							</tr>
	<?php
						}
					//}
				}
	?>
				</table>
			</div>
		</div>
    </fieldset>
</td>
</tr>
</table>
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <a href="<?php echo base_url();?>index.php/pengguna/tambah">
    <button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    </a>
    <a href="<?php echo base_url();?>index.php/pengguna/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">CLOSE</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>