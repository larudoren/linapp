<script type="text/javascript" src="<?=base_url('asset/js/datagrid-scrollview.js')?>"></script>
<script type="text/javascript">

$.extend($.fn.datagrid.defaults.editors, {
	combogrid: {
		init: function(container, options){
			var input = $('<input type="text" class="datagrid-editable-input">').appendTo(container); 
			input.combogrid(options);
			return input;
		},
		destroy: function(target){
			$(target).combogrid('destroy');
		},
		getValue: function(target){
			return $(target).combogrid('getValue');
		},
		setValue: function(target, value){
			$(target).combogrid('setValue', value);
		},
		resize: function(target, width){
			$(target).combogrid('resize',width);
		}
	}
});

$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	var dgPD = '#dgProductDetail';
	var status_dg =0;
	
	$(dgPD).datagrid({
		title: "Product Accessories",
		width: 920,
		height: 500,
		rownumbers:true,
		singleSelect:true,
		collapsible:true,
		striped:true,
		onClickRow: PDOnClickRow,
		onBeforeLoad : function(param){
			param.product_code = '<?php echo $product_code; ?>';
		},
		url:"<?php echo site_url(); ?>/product/DataDetail/",
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			id :'AssInsert',
			handler: function(){PDInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			id :'AssRemove',
			handler: function(){PDRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			id :'AssSave',
			handler: function(){PDGetChanges();} 
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			id :'AssCancel',
			handler: function(){PDReject();}
		}],
			columns: [
			[
				{
					field:'product_code',
					title:'product code',
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidebarang',
					title:'hidebarang',
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'sequence',
					title:'sequence',
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'accessories',
					title:'Accessories',
					align:'left',
					width:250,
					editor: {
						type: "combogrid",
						options: {
							panelWidth: 650,
							panelHeight: 350,
							required:true,
							rownumbers: true,
							
							//view:scrollview,
					    pageSize: 15,
							
							idField:'kode_barang',
							textField:'nama_barang',
							url:'<?php echo site_url(); ?>/ref_json/ComboboxAccessories/',
							//method: 'post',
							mode:'remote',
							 pagination:true,
							 pageSize: 10,  
							 pageList: [10],
							onSelect: function(rows){
								//var tr = $(this).closest('tr.datagrid-row');
								//var idx = parseInt(tr.attr('datagrid-row-index')); 
								var ed_hidebarang = $(dgPD).datagrid('getEditor',{index:PDEditIndex,field:'hidebarang'});
								$(ed_hidebarang.target).val(rows.kode_barang);
								//status_dg = 0;
							},
							columns: [[
								{field:'kode_barang',title:'Code',width:80, hidden:true},
								{field:'nama_barang',title:'Name',width:200},
								{field:'kode_barang_spc',title:'Code 2',align:'center',width:80},
								{field:'length',title:'Length',align:'center',width:80},
								{field:'width',title:'Width',align:'center',width:80},
								{field:'height',title:'Height',align:'center',width:80}
							]],
							//fitColumns: true,
							filter: function(q, row){
								var opts = $(this).combogrid('options');
								return row[opts.textField].toLowerCase().indexOf(q.toLowerCase()) == 0;
							} 
						}
					}
				}
			]
		]
	});
	
	var PDEditIndex = undefined;
	var vproduct_code = '<?php echo $product_code; ?>';
	
	PDInsertRow = function() {
		if (PDEndEditing()){
			$(dgPD).datagrid('insertRow',{index:0,row:{product_code:vproduct_code,kode_barang:''}});
			PDEditIndex = 0;
			$(dgPD).datagrid('selectRow', PDEditIndex)
					.datagrid('beginEdit', PDEditIndex);
			status_dg = 1;
			//PDOnClickRow(PDEditIndex);
		}
	};
	
	function PDEndEditing(){
		if (PDEditIndex == undefined){return true}
		
		var ed_barang = $(dgPD).datagrid('getEditor',{index:PDEditIndex, field:'accessories'});
		var kode_barang = $(ed_barang.target).combogrid('getValue');
		
		if ($(dgPD).datagrid('validateRow', PDEditIndex)){
			$(dgPD).datagrid('endEdit', PDEditIndex);
			PDEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function PDRemoveIt(){
		if (PDEditIndex == undefined){return}
		var ed_seq = $(dgPD).datagrid("getEditor", {index:PDEditIndex, field:'sequence'});
		//var seq = $(ed_seq).datagrid("getEditor", {index:PDEditIndex, field:'pi_number'});
		var seq = $(ed_seq).val();
		var product = vproduct_code;

		if (seq!=''){
			$.messager.confirm('Confirm', 'Do you want to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/product/hapus_detail",
						data	: "product_code="+product+"&seq="+seq,
						cache	: false,
						success	: function(data){
							$(dgPD).datagrid('cancelEdit', PDEditIndex)
								.datagrid('deleteRow', PDEditIndex);
							$(dgPD).datagrid('reload');
							PDEditIndex = undefined;
						}
					});
				}
			});
		}else{
			$(dgPD).datagrid('cancelEdit', PDEditIndex)
				.datagrid('deleteRow', PDEditIndex);			
			PDEditIndex = undefined;
			//accessoriesStatus = 0;
		}
		
	}
	
	function PDReject(){
		$(dgPD).datagrid('rejectChanges');
		PDEditIndex = undefined;
		$(dgPD).datagrid('reload');
	}
	
	function PDGetChanges(){
		PDEndEditing();
		var rows = $(dgPD).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		
		for (i=0;i<rows.length;i++){
			pesan += '&product_code_'+i+'='+rows[i].product_code+
								'&seq_'+i+'='+rows[i].sequence+
								'&kode_barang_'+i+'='+rows[i].accessories;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/product/simpan_detail",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgPD).datagrid('reload');
			}
		});
		
	}
	
	function PDOnClickRow(index){
		if (PDEditIndex != index){
			
			if (PDEndEditing()){
				$(dgPD).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				PDEditIndex = index;
			
				var ed_hidebarang 	= $(dgPD).datagrid('getEditor',{index:PDEditIndex,field:'hidebarang'});
				var ed_accessories 	= $(dgPD).datagrid('getEditor',{index:PDEditIndex,field:'accessories'});
				//var ed_currency = $(dgSandingAmplas).datagrid('getEditor',{index:PDEditIndex,field:'currency'});

				var hidebarang= $(ed_hidebarang.target).val();
				
				//$(ed_currency.target).attr('disabled','true');
				//var c =  $(ed_accessories.target).combogrid('grid');
				//c.datagrid('selectRecord',hidebarang);
				sandingStatus = 1;
			} else{
				$(dgPD).datagrid('selectRow', PDEditIndex);
			}
		}
	}
	
	
});
</script>
<form name="form" id="form">
<table width="100%">
	<tr>
		<td valign="top" width="50%">
			<div id="gird" style="float:left; width:100%;">
				<table id="dataTable" width="100%">
					<tr>
						<th>Code</th>
						<th>Collection</th>
						<th>Name</th>
						<th>Category</th>
						<th>Photo</th>
					</tr>
					<?php
						if($product_photo=="") {
							$foto = base_url('asset/product_photo/unknown.jpg');
						} else {
							$foto = base_url('asset/product_photo/'.$product_photo);
						}
					?>
					<tr>
						<td align="center"><?=$product_code?></td>
						<td align="center"><?=$coll_name?></td>
						<td align="center"><?=$product_name?></td>
						<td align="center"><?=$category?></td>
						<td align="center"><img src="<?=$foto?>" height="60px" /></td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
			<fieldset>
			<table width="100%" border="0">
				<tr>
					<td><table id="dgProductDetail"></table></td>
				</tr>
			</table> 
			<table width="100%">
				<tr>
					<td colspan="3" align="center">
						<a href="<?php echo base_url();?>index.php/product/name/<?=$code_cari?>/<?=$coll_cari?>/<?=$type_cari?>/<?=$category_cari?>/<?=$hal?>">
							<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">CLOSE</button>
						</a>
					</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
</table>
</form>