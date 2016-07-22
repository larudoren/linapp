<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});
	
	$("#product_code").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$("#collection").keyup(function(e){
		var isi = $(e.target).val();
		//var f = isi.charAt(0).toUpperCase();
		//$(e.target).val(f+isi.substr(1));
		$(e.target).val(isi.toUpperCase());
	});
	
	if ($("#status").val()=='2'){
		$("#product_code").attr("readonly","true");
	}
	else {
		$("#product_code").removeAttr("readonly");
	}	
	
	$("#collection").attr("readonly","true");
	$("#name").attr("readonly","true");
	
	$('#product_code').keypress(function (event){
		var vproduct_code = '<?php echo $product_code;?>';
		if (vproduct_code.length==0){
			if (event.which==13){
				AmbilProduct();
			}
		}
	});
	
	function AmbilProduct(){
		var kode = $("#product_code").val();
		var jdata = [];
		
		var win = $.messager.progress({
			title:'Please wait',
			msg:'Loading data...',
			text: 'PROCESSING....'
		});
			
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/AmbilProduct",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$.messager.progress('close');
				jdata = JSON.parse(data);
				if(jdata[0]==undefined){
					$("#collection").val('');
					$("#name").val('');
				} else {
					$("#collection").val(jdata[0]['collection'].toUpperCase());
					$("#name").val(jdata[0]['name']);
				}
			}
		});
	}
	
	$("#simpan").click(function(){
		//var data 		= new FormData($('#data')[0]);
		var product_code	= $("#product_code").val();
		var collection		= $("#collection").val();
		var name					= $("#name").val();
		var finishing			= $("#finishing").val();
		
		var string = $("#form").serialize();
		
		if(product_code.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Code field cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#product_code").focus();
			return false();
		} 
		if(collection.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Collection field cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#collection").focus();
			return false();
		}
		if(name.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Name field cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#name").focus();
			return false();
		}
		if(finishing.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Main Finishing field cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#finishing").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				CariSimpanan();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server not respond :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		
		return false();		
	});
	
	
	
});	
</script>	
<?php
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
?>
<br/>
<form name="form" id="form">
<table width="100%">
	<tr>
		<td valign="top" width="50%">
			<fieldset class="atas">
			<table width="100%" border="0">
				<tr>    
					<td width="<?=$widthlabelleft?>">Code</td>
					<td width="<?=$widthdoubledot?>">:</td>
					<td width="<?=$widthinputleft?>"><input type="text" name="product_code" id="product_code" size="20"  class="easyui-validatebox" data-options="required:true" value="<?=$product_code?>"/><input type="hidden" name="status" id="status" value="<?=$status?>" /><input type="hidden" name="id_cotation" id="id_cotation" value="<?=$id_cotation?>" /></td>
					<td></td>
				</tr>
				<tr>    
					<td width="<?=$widthlabelleft?>">Collection</td>
					<td width="<?=$widthdoubledot?>">:</td>
					<td width="<?=$widthinputleft?>"><input type="text" name="collection" id="collection" size="50" class="easyui-validatebox" value="<?=$collection?>"/></td>   
				</tr>
				<tr>    
					<td width="<?=$widthlabelleft?>">Name</td>
					<td width="<?=$widthdoubledot?>">:</td>
					<td width="<?=$widthinputleft?>"><input type="text" name="name" id="name" size="50" class="easyui-validatebox" value="<?=$name?>" /></td>
				</tr>
				<tr>
					<td width="<?=$widthlabelleft?>">Main Finishing</td>
					<td width="<?=$widthdoubledot?>">:</td>
					<td width="<?=$widthinputleft?>"><input type="text" name="finishing" id="finishing" class="easyui-validatebox" size="50" data-options="required:true" value="<?=$finishing?>" /></td> 
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset class="bawah">
			<table width="100%">
				<tr>
					<td colspan="3" align="center">
						<button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
						<a href="<?php echo base_url();?>index.php/cotation/tambah">
						<button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
						</a>
						<a href="<?php echo base_url();?>index.php/cotation/index/<?php echo $hal;?>">
						<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
						</a>
					</td>
				</tr>
			</table>  
			</fieldset>   
		</td>
	</tr>
</table>
</form>