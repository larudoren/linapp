<!--<script type="text/javascript" src="<?=base_url('asset/js/datagrid-filter.js')?>"></script>-->
<script type="text/javascript">
$(function() {
	$("#dataTable tr:even").addClass("stripe1");
	$("#dataTable tr:odd").addClass("stripe2");
	$("#dataTable tr").hover(
		function() {
			$(this).toggleClass("highlight");
		},
		function() {
			$(this).toggleClass("highlight");
		}
	);
	
});

$(document).ready(function(){
	var dgPA = '#dgProductAccessories';
	var PAEditIndex = undefined;
	
	$(dgPA).datagrid({
		title: 'Accessories Card Items',
		collapsible: true,
		rownumbers:true,
		multiSelect:true,
		style:'padding:1px;',
		onDblClickCell: function(index,field,value){
			if (PAEditIndex==undefined){
				$(this).datagrid('beginEdit', index);
				var ed = $(this).datagrid('getEditor', {index:index,field:field});
				$(ed.target).focus();
				PAEditIndex = index;
			} else {
				$(this).datagrid('endEdit',PAEditIndex);
				$(this).datagrid('beginEdit', index);
				var ed = $(this).datagrid('getEditor', {index:index,field:field});
				$(ed.target).focus();
				PAEditIndex = index;
			}
		},
		onLoadSuccess:function(data){
			var rows = $(this).datagrid('getRows');
			for(i=0;i<rows.length;++i){
					if(rows[i]['ck']==1) $(this).datagrid('checkRow',i);
			}
		},
		url:"<?php echo site_url(); ?>/accessories_product/DataDetail/<?php echo $pi_number.':'.$seq.':'.$product_code; ?>",
		toolbar: [{
			iconCls: 'icon-save',
			text :'Save',
			id :'PASave',
			handler: function(){PAGetChanges();} 
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			id :'PACancel',
			handler: function(){PAReject();}
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){print();} 
		}],
		columns: [
			[
				{
					field:'ck',
					width:100,
					align:'center',
					checkbox:true,
				},{
					title:'Code',
					field:'kode_barang',
					hidden:true,
					align:'center',
					width:150
				},{
					title:'Description',
					field:'nama_barang',
					align:'left',
					width:300
				},{
					title:'Length',
					field:'size_length',
					align:'center',
					width:70,
					formatter: function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					}
				},{
					title:'Width',
					field:'size_width',
					align:'center',
					width:70,
					formatter: function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					}
				},{
					title:'Height',
					field:'size_height',
					align:'center',
					width:70,
					formatter: function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					}
				},{
					title:'&#216 in',
					field:'size_diameterin',
					align:'center',
					width:70,
					formatter: function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					}
				},{
					title:'&#216; out',
					field:'size_diameter',
					align:'center',
					width:70,
					formatter: function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					}
				},{
					title:'Thread',
					field:'size_thread',
					align:'center',
					width:70
				},{
					title:'Quantity',
					field:'quantity',
					align:'center',
					width:100,
					editor:{
						type:'numberbox'
					}
				}
			]
		]
	});
	
	
	
	function PAEndEditing(){
		if (PAEditIndex == undefined){return true}
		if ($(dgPA).datagrid('validateRow', PAEditIndex)){
			$(dgPA).datagrid('endEdit', PAEditIndex);
			PAEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function PAGetChanges(){
		PAEndEditing();
		var rows = $(dgPA).datagrid('getChecked');
		var temp = [];
		var pesan ='';
		var pi_number = '<?php echo $pi_number; ?>';
		var seq = '<?php echo $seq; ?>';
		
		for (i=0;i<rows.length;i++){
			pesan += '&pi_number_'+i+'='+pi_number+
								'&seq_'+i+'='+seq+
								'&kode_barang_'+i+'='+rows[i].kode_barang+
								'&quantity_'+i+'='+rows[i].quantity;
			
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/accessories_product/simpan",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgPA).datagrid('reload');
				
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
			}
		}); 
		
	}
	
	function PAReject(){
		$(dgPA).datagrid('rejectChanges');
		PAEditIndex = undefined;
		$(dgPA).datagrid('reload');
	}
	
	function print(){
			window.open('<?php echo site_url();?>/accessories_product/cetak/<?php echo $pi_number.'-'.$seq; ?>');
		}
	
});

</script>
<style type="text/css">
.stripe1 {
    background-color:#FBEC88;
}
.stripe2 {
    background-color:#FFF;
}
.highlight {
	-moz-box-shadow: 1px 1px 2px #fff inset;
	-webkit-box-shadow: 1px 1px 2px #fff inset;
	box-shadow: 1px 1px 2px #fff inset;		  
	border:             #aaa solid 1px;
	background-color: #fece2f;
}
</style>
<table id="dataTable" width="100%">
	<tr>
		<th>PI Number</th>
		<th>Customer</th>
		<th>Collection</th>
		<th>Code</th>
		<th>Product</th>
		<th>Photo</th>
	</tr>
	<tr>
		<td align="center" ><?php echo $pi_number;?></td>
		<td align="center" ><?php echo $cust_name;?></td>
		<td align="center" ><?php echo $collection;?></td>
		<td align="center" ><?php echo $product_code;?></td>
		<td align="center" ><?php echo $product_name;?></td>
<?php if ($product_photo==''){
				$foto = base_url('asset/product_photo/unknown.jpg');
			} else {
				$foto = base_url('asset/product_photo/'.$product_photo);
			}
?>
		<td align="center"><img src="<?=$foto?>" width="60px" /></td>
	</tr>
   
</table>
<table width="100%">
			<tr>
				<td colspan="3" align="center">
				<a href="<?php echo base_url();?>index.php/accessories_product/">
				<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">CLOSE</button>
				</a>
				</td>
			</tr>
</table>

<table id="dgProductAccessories" width="100%"></table>