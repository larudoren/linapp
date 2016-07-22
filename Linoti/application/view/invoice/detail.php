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
	
	var dgPI = '#dgPInvoice';
	var dgAcc = '#dgAccessories';
	var dgBox = '#dgBox';
	var id_cotation ='';
	var PIEditIndex = undefined;
	var vpi_id = '<?php echo $pi_id; ?>';
	
	$("#cetak").click(function(){
		var kode	= $("#po").val();
		window.open('<?php echo site_url();?>/pembelian/cetak/'+kode);
		return false();
	});
	
	//var radios = $('input[type=radio][name=BrandType]');
	/*
	if(radios.is(':checked') === false) {
			radios.filter('[value=Upholstery]').prop('checked', true);
	}
	*/
	//var mybrand = $('input[type=radio][name=BrandType]:checked').val();;
	/*
	$( "input[type=radio][name=BrandType]" ).on( "click", function(){
		var MyOption = $('input[type=radio][name=BrandType]:checked').val();
		mybrand = MyOption;
		//PICustomGrid(MyOption);
		$(dgPI).datagrid('reload');
	}); */
	
	
	function AmbilDaftarAccessories(){
		var pi_id = $("#dpi_id").val();
		var seq 	= $("#dseq").val();
		var product_code 	= $("#dproduct_code").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataAccessories",
			data	: "pi_id="+pi_id+"&seq="+seq+"&product_code="+product_code,
			cache	: false,
			success	: function(data){
				$("#daftar_accessories").html(data);
			}
		});
	}
	
	function AmbilIDCotation(type){
		
		var product_code 	= '';
		var product_seq 	= '';
		if (type=='Accessories'){
			product_code = $("#dproduct_code").val();
			product_seq = $("#dseq").val();
		} else {
			product_code = $("#bproduct_code").val();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataIDCotation",
			data	: "product_code="+product_code,
			cache	: false,
			success	: function(data){
				
				var pi_id='';
				var urlac="";
				if (type=='Accessories'){
					$('#did_cotation').val(data);
					pi_id = $('#dpi_id').val();
					urlac = "<?php echo site_url(); ?>/invoice/DataAccessories/"+data+"/"+pi_id+"/"+product_code+"/"+product_seq;
					$(dgAcc).datagrid({url:urlac});
				} else {
					$('#bid_cotation').val(data);
					pi_id = $('#bpi_id').val();
					var seq = $('#bseq').val();
					var kdown = $('#bkdown').val();
					urlac = "<?php echo site_url(); ?>/invoice/DataBox/"+data+"/"+pi_id+"/"+seq+"/"+kdown;
					$(dgBox).datagrid({url:urlac});
				}
			}
		});
	}
	
	$('#dlgconfirm').dialog({
		align:'center',
		 buttons: [{
				text:'Yes',
				handler:function(){
					$('#dlgconfirm').dialog('close');
					var win = $.messager.progress({
						title:'Please wait',
						msg:'Create PO...',
						text: 'PROCESSING....'
					});
					
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/invoice/CreateAllPOPI",
						data	: "pi=<?php echo $pi_number;?>&date=<?php echo $pi_dateorder; ?>&pi_id=<?php echo $pi_id; ?>",
						cache	: false,
						success	: function(data){
							$.messager.progress('close');
							$.messager.show({
								title:'Info',
								msg: data,
								timeout:2000,
								showType:'slide'
							});
						},
						error : function(xhr, teksStatus, kesalahan) {
							$.messager.progress('close');
							$.messager.show({
								title:'Info',
								msg: 'Server not respond :'+kesalahan,
								timeout:2000,
								showType:'slide'
							});
						}
					});
					
				}
		},{
				text:'No',
				handler:function(){
					$('#dlgconfirm').dialog('close');
				}
		}]
	});
	
	$('#dlgconfirmbox').dialog({
		align:'center',
		 buttons: [{
				text:'Yes',
				handler:function(){
					$('#dlgconfirmbox').dialog('close');
					var win = $.messager.progress({
						title:'Please wait',
						msg:'Create PO...',
						text: 'PROCESSING....'
					});
					
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/invoice/CreatePOBox",
						data	: "pi=<?php echo $pi_number;?>&date=<?php echo $pi_dateorder; ?>&pi_id=<?php echo $pi_id; ?>",
						cache	: false,
						success	: function(data){
							$.messager.progress('close');
							var datas = data.split(",");
							$.messager.show({
								title:'Info',
								msg: datas[0],
								timeout:2000,
								showType:'slide'
							});
							
						},
						error : function(xhr, teksStatus, kesalahan) {
							$.messager.progress('close');
							$.messager.show({
								title:'Info',
								msg: 'Server not respond :'+kesalahan,
								timeout:2000,
								showType:'slide'
							});
						}
					});
					
				}
		},{
				text:'No',
				handler:function(){
					$('#dlgconfirmbox').dialog('close');
				}
		}]
	});
	
	$(dgPI).datagrid({
		title: "Product",
		width: 1200,
		height: 400,
		rownumbers:true,
		singleSelect:true,
		//selectOnCheck: false,
		//checkOnSelect: false,
		collapsible:true,
		onClickRow: PIOnClickRow,
		onBeforeLoad : function(param){
			param.pi_id = '<?php echo $pi_id; ?>';
		},
		url:"<?php echo site_url(); ?>/invoice/DataDetail/",
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			id :'AssInsert',
			handler: function(){PIInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			id :'AssRemove',
			handler: function(){PIRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			id :'AssSave',
			handler: function(){PIGetChanges();} 
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			id :'AssCancel',
			handler: function(){PIReject();}
		},'-',{
			iconCls: 'icon-menu',
			text :'Accessories',
			handler: function(){PIAccessories();} 
		},'-',{
			iconCls: 'icon-menu',
			text :'Create PO',
			handler: function(){PIPO();} 
		},'-',{
			iconCls: 'icon-menu',
			text :'Box',
			handler: function(){PIBox();} 
		},'-',{
			iconCls: 'icon-menu',
			text :'Create Box PO',
			handler: function(){PIPOBox();} 
		}],
			columns: [
			[
				{
					field:'pi_id',
					title:'pi id',
					rowspan:2,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'seq',
					title:'seq',
					rowspan:2,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'ck',
					checkbox:true
				},{
					field:'product_code',
					title:'Code',
					align:'center',
					rowspan:2,
					width:100,
					editor: {
						type: "combogrid",
						options: {
							panelWidth: 650,
							panelHeight: 350,
							required:true,
							rownumbers: true,
					    pageSize: 15,
							
							idField:'product_code',
							textField:'product_code',
							url:'<?php echo site_url(); ?>/ref_json/ComboboxProduct/',
							mode:'remote',
							pagination:true,
							pageSize: 10,  
							pageList: [10],
							onSelect: function(index, record){
								var ed_product_name = $(dgPI).datagrid('getEditor',{index:PIEditIndex,field:'product_name'});
								var ed_product_coll = $(dgPI).datagrid('getEditor',{index:PIEditIndex,field:'product_coll'});
								$(ed_product_name.target).val(record.product_name);
								$(ed_product_coll.target).val(record.coll_name);
							},
							columns: [[
								{field:'product_code',title:'Code',width:80},
								{field:'coll_name',title:'Collection',width:100},
								{field:'product_name',title:'Name',align:'left',width:200},
								{field:'category',title:'Category',align:'center',width:80}
							]],
							//fitColumns: true,
							filter: function(q, row){
								var opts = $(this).combogrid('options');
								return row[opts.textField].toLowerCase().indexOf(q.toLowerCase()) == 0;
							} 
						}
					}
				},{
					field:'product_coll',
					title:'Collection',
					align:'left',
					rowspan:2,
					width:100,
					editor: {
						type : 'text'
					}
				},{
					field:'product_name',
					title: 'Product Name',
					align:'left',
					rowspan:2,
					width:250,
					editor: {
						type : 'text'
					}
				},{
					field:'description',
					title: 'Description ( Finishing / Upholstery )',
					align:'left',
					rowspan:2,
					width:250,
					editor: {
						type : 'text'
					}
				},{
					field:'quantity',
					title:'Qty',
					align:'center',
					rowspan:2,
					width:70,
					editor: {
						type: "numberbox",
						options:{
							min: 1
						}
					}
				},{
					field:'remarks',
					title:'Remarks',
					rowspan:2,
					align:'center',
					width:150,
					editor: {
						type: "validatebox"
					}
				},{
					field:'kdown',
					title:'Knockdown?<br>( Packing )',
					rowspan:2,
					align:'center',
					width:100,
					editor:{
						type:'checkbox',
						options:{
							on:'KD',
							off:'NO'
						}
					}
				}
			]
		]
	});
	
	$(dgAcc).datagrid({
		title: "Accessories",
		//rownumbers:true,
		singleSelect:false,
		selectOnCheck: false,
		checkOnSelect: false,
		collapsible:true,
		onClickRow: PIOnClickRow,
		onBeforeLoad : function(param){
			//param.id_cotation = id_cotation;
		},
		onLoadSuccess : function(data){
			//alert(data['total']);
			for (i=0;i<data['total'];i++){
				if (data['rows'][i]['mycheck']!='0'){
					//alert(data['rows'][i]['mycheck']);
					$(this).datagrid('checkRow',i);
				}
				
			}
		},
		//url:"<?php echo site_url(); ?>/invoice/DataAccessories/",
		//url:"<?php echo site_url(); ?>/cotation/DataAccessories/",
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-save',
			text :'Save',
			id :'AssSave',
			handler: function(){AccSet();} 
		}],
		columns: [
			[
				{
					field:'id_cotation',
					title:'id_cotation',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'seq',
					title:'seq',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidekodebarang',
					title:'hidekodebarang',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidefoto',
					title:'hidefoto',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidenamabarang',
					title:'hidenamabarang',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidesize',
					title:'hidesize',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hideunit',
					title:'hideunit',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'brg_harga',
					title:'brg_harga',
					rowspan:3,
					hidden:true,
					editor: {
						type: "numberbox"
					}
				},{
					field:'type_id',
					title:'type_id',
					rowspan:3,
					hidden:true
				// Tambah checkbox
				},{
					field:'numberrec',
					title:'',
					align:'center',
					width: 25,
					rowspan:3	
				},{
					field:'ck',
					checkbox: true
				},{
					field:'acc_hard',
					title:'Use By',
					width: 150,
					rowspan:3	
				},{
					field:'code',
					title:'Code Linoti',
					align:'center',
					width:100,
					rowspan:3	
				},{
					field:'type',
					title:'Type',
					width:150,
					rowspan:3	
				},{
					title:'Photo',
					field:'photo',
					align:'center',
					formatter:function(value,row,index){
						if (row.hidefoto){
							var foto = '<?php echo base_url("asset/foto_produk/'+row.hidefoto+'"); ?>';
							return '<div style="width: 90px; height: 50px; border: no; overflow: hidden; position: relative;"><img src="'+foto+'" style="position: absolute;" onload="OnImageLoad(event);" /></div>'; 
						} else {
							var foto = '<?php echo base_url("asset/foto_produk/unknown.jpg"); ?>';
							return '<div style="width: 90px; height: 50px; border: no; overflow: hidden; position: relative;"><img src="'+foto+'" style="position: absolute;" onload="OnImageLoad(event);" /></div>';
						}
					},
					width:100
				},{
					title:'Name',
					field:'accessories_type',
					width:250,
					formatter:function(value,row,index){
						
						if (row.nama_barang){
							return row.nama_barang;
						} else {
							return row.hidenamabarang;
						} 
						//return row.family;
					}, 
					rowspan:3
					
				},{
					field:'size',
					title:'Size',
					align:'center',
					width:200,
					rowspan:3,
					formatter:function(value,row,index){
						if (row.hidesize==''){
							return '';
						} else {
							return row.hidesize;
						}
					}
				},{
					field:'finishing',
					title:'Finishing',
					align:'center',
					width:150,
					rowspan:3
				},{
					title:'Qty',
					field:'quantity',
					rowspan:3,
					align:'center',
					width:70,
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						//var fraction1 = 0.0;
						//var fraction2 = 0.00;
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					}
				},{
					field:'unit',
					title:'Unit',
					rowspan:3,
					align:'center',
					width:70,
					formatter:function(value,row,index){
						return row.hideunit;
					}
				}
			]
		]
	});
	
	$(dgBox).datagrid({
		title: "Box",
		height:400,
		//rownumbers:true,
		singleSelect:false,
		selectOnCheck: false,
		checkOnSelect: false,
		collapsible:true,
		onClickRow: PIOnClickRow,
		onLoadSuccess : function(data){
			//alert(data['total']);
			for (i=0;i<data['total'];i++){
				if (data['rows'][i]['mycheck']!='0'){
					//alert(data['rows'][i]['mycheck']);
					$(this).datagrid('checkRow',i);
				}
				
			}
		},
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-save',
			text :'Save',
			id :'AssSave',
			handler: function(){BoxSet();} 
		}],
		columns: [
			[
				{
					field:'id_cotation',
					title:'id_cotation',
					rowspan:2,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'seq',
					title:'seq',
					rowspan:2,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'numberrec',
					title:'',
					align:'center',
					width: 25,
					rowspan:3	
				},{
					field:'ck',
					rowspan:2,
					checkbox: true
				},{
					field:'boxnumber',
					title:'Box',
					align:'center',
					width: 100,
					rowspan:2	
				},{
					title:'Size',
					align:'center',
					colspan:3
				},{
					field:'kdown',
					title:'Knock Down?',
					align:'center',
					rowspan:2,
					width:100
				},{
					field:'typebox',
					title:'Type',
					align:'center',
					rowspan:2,
					width:100
				},{
					field:'remarks',
					title:'Packing<br>Remarks',
					align:'center',
					rowspan:2,
					width:150
				},{
					title:'Styrofoam',
					align:'center',
					colspan:3
				},{
					title:'Inner Size',
					align:'center',
					colspan:3
				},{
					title:'+ Tebal Karton',
					align:'center',
					colspan:3
				},{
					title:'Outer Size',
					align:'center',
					colspan:3
				},{
					field:'volouter',
					title:'Vol. Outer',
					align:'center',
					rowspan:2,
					width:100
				
				},{
					field:'qtybox',
					title:'Qty Box',
					align:'center',
					rowspan:2,
					width:50
				}
			],[
				{
					field:'lsize',
					title:'L',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'wsize',
					title:'W',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'hsize',
					title:'H',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'lstyrofoam',
					title:'L',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'wstyrofoam',
					title:'W',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'hstyrofoam',
					title:'H',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'linner',
					title:'L',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'winner',
					title:'W',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'hinner',
					title:'H',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'lkarton',
					title:'L',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'wkarton',
					title:'W',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'hkarton',
					title:'H',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'louter',
					title:'L',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'wouter',
					title:'W',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				},{
					field:'houter',
					title:'H',
					align:'center',
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							if (fraction > 0){
								return value;
							} else {
								return whole;
							}
						}
					},
					width:50
				}
			]
		]
	});
	
	PIInsertRow = function() {
		if (PIEndEditing()){
			$(dgPI).datagrid('insertRow',{index:0,row:{pi_id:vpi_id,quantity:1}});
			PIEditIndex = 0;
			$(dgPI).datagrid('selectRow', PIEditIndex)
					.datagrid('beginEdit', PIEditIndex);
		}
	};
	
	function PIEndEditing(){
		if (PIEditIndex == undefined){return true}
		if ($(dgPI).datagrid('validateRow', PIEditIndex)){
			$(dgPI).datagrid('endEdit', PIEditIndex);
			PIEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function PIRemoveIt(){
		if (PIEditIndex == undefined){return}
		var ed_product = $(dgPI).datagrid("getEditor", {index:PIEditIndex, field:'product_code'});
		var ed1 = $(dgPI).datagrid("getEditor", {index:PIEditIndex, field:'pi_id'});
		var ed_seq = $(dgPI).datagrid("getEditor", {index:PIEditIndex, field:'seq'});
		var product = $(ed_product.target).combogrid('getValue');
		var pi_id = $(ed1.target).val();
		var seq = $(ed_seq.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Do you want to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/invoice/hapus_detail",
						data	: "pi_id="+pi_id+"&product_code="+product+'&seq='+seq,
						cache	: false,
						success	: function(data){
							$(dgPI).datagrid('cancelEdit', PIEditIndex)
								.datagrid('deleteRow', PIEditIndex);
							$(dgPI).datagrid('reload');
							PIEditIndex = undefined;
						}
					});
				}
			});
		}else{
			$(dgPI).datagrid('cancelEdit', PIEditIndex)
				.datagrid('deleteRow', PIEditIndex);			
			PIEditIndex = undefined;
			//accessoriesStatus = 0;
		}
		
	}
	
	function PIReject(){
		$(dgPI).datagrid('rejectChanges');
		PIEditIndex = undefined;
		$(dgPI).datagrid('reload');
	}
	
	function PIGetChanges(){
		PIEndEditing();
		var rows = $(dgPI).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		//var brandtype = $('input[type=radio][name=BrandType]:checked').val();
		
		for (i=0;i<rows.length;i++){
			pesan += '&pi_id_'+i+'='+rows[i].pi_id+
								'&seq_'+i+'='+rows[i].seq+
								'&product_code_'+i+'='+rows[i].product_code+
								'&description_'+i+'='+rows[i].description+
								'&quantity_'+i+'='+rows[i].quantity+
								'&production_'+i+'='+rows[i].production+
								'&vendor_'+i+'='+rows[i].vendor+
								'&top_'+i+'='+rows[i].top+
								'&frame_'+i+'='+rows[i].frame+
								'&drawer_'+i+'='+rows[i].drawer+
								'&door_'+i+'='+rows[i].door+
								'&side_'+i+'='+rows[i].side+
								'&feet_'+i+'='+rows[i].feet+
								'&linen_'+i+'='+rows[i].linen+
								'&inside_'+i+'='+rows[i].inside+
								'&back_'+i+'='+rows[i].back+
								'&shelve_'+i+'='+rows[i].shelve+
								'&finish_'+i+'='+rows[i].finish+
								'&note_'+i+'='+rows[i].note+
								'&remarks_'+i+'='+rows[i].remarks+
								'&outside_'+i+'='+rows[i].outside+
								'&back_rest_'+i+'='+rows[i].back_rest+
								'&seat_base_'+i+'='+rows[i].seat_base+
								'&seat_cushion_'+i+'='+rows[i].seat_cushion+
								'&amrest_'+i+'='+rows[i].amrest+
								'&cushion_'+i+'='+rows[i].cushion+
								'&piping_'+i+'='+rows[i].piping+
								'&kdown_'+i+'='+rows[i].kdown+
								'&customize_'+i+'='+rows[i].customize;
			//alert(rows[i].pi_id);
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/invoice/simpan_detail",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgPI).datagrid('reload');
			}
		});
		
	}
	/*
	function PICustomGrid(MyOption){
	  var temp = 0;
		var dg = $(dgPI); 
		if (MyOption=='Upholstery'){
			$(dgPI).datagrid('hideColumn','top');
			$(dgPI).datagrid('hideColumn','drawer');
			$(dgPI).datagrid('hideColumn','door');
			$(dgPI).datagrid('hideColumn','side');
			$(dgPI).datagrid('hideColumn','inside');
			$(dgPI).datagrid('hideColumn','back');
			$(dgPI).datagrid('hideColumn','shelve');
			$(dgPI).datagrid('hideColumn','note');
			temp = 1;
			$(dgPI).datagrid('showColumn','outside');
			$(dgPI).datagrid('showColumn','back_rest');
			$(dgPI).datagrid('showColumn','seat_base');
			$(dgPI).datagrid('showColumn','seat_cushion');
			$(dgPI).datagrid('showColumn','amrest');
			$(dgPI).datagrid('showColumn','cushion');
			$(dgPI).datagrid('showColumn','piping');
			$(dgPI).datagrid('showColumn','customize');
		} else {
			$(dgPI).datagrid('showColumn','top');
			$(dgPI).datagrid('showColumn','drawer');
			$(dgPI).datagrid('showColumn','door');
			$(dgPI).datagrid('showColumn','side');
			$(dgPI).datagrid('showColumn','inside');
			$(dgPI).datagrid('showColumn','back');
			$(dgPI).datagrid('showColumn','shelve');
			$(dgPI).datagrid('showColumn','note');
			
			$(dgPI).datagrid('hideColumn','outside');
			$(dgPI).datagrid('hideColumn','back_rest');
			$(dgPI).datagrid('hideColumn','seat_base');
			$(dgPI).datagrid('hideColumn','seat_cushion');
			$(dgPI).datagrid('hideColumn','amrest');
			$(dgPI).datagrid('hideColumn','cushion');
			$(dgPI).datagrid('hideColumn','piping');
			$(dgPI).datagrid('hideColumn','customize');
		}
		
		
		
		var dc = dg.data('datagrid').dc;
    var fields = dg.datagrid('getColumnFields');
    var vcount = 0;
    $.map(fields, function(field){
        var col = dg.datagrid('getColumnOption', field);
        if ((!col.hidden && (field=='outside' || field=='back_rest')) || (col.hidden && (field=='outside' || field=='back_rest'))){
            vcount++;
        }
    });
		
		var columns = dg.datagrid('options').columns;
    if (columns.length>1){
        var htable = dc.header2.find('.datagrid-htable');
        var index = 0;
        htable.find('tr.datagrid-header-row:first td').each(function(){
            var colspan = parseInt($(this).attr('colspan'));
            if (colspan >= 2 && vcount>=1 && temp==0){
                $(this).hide();
            } else if (colspan >= 2 && vcount>=1 && temp==1){
							$(this).show();
						}
            index += colspan;
        })
    }
	} */
	
	function PIOnClickRow(index){
		if (PIEditIndex != index){
			
			if (PIEndEditing()){
				$(dgPI).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				PIEditIndex = index;
				
				var ed_product_code	= $(dgPI).datagrid('getEditor',{index:PIEditIndex,field:'product_code'});
			/*
				var ed_hidebarang 	= $(dgPI).datagrid('getEditor',{index:PDEditIndex,field:'hidebarang'});
				var ed_accessories 	= $(dgPI).datagrid('getEditor',{index:PDEditIndex,field:'accessories'});
				//var ed_currency = $(dgSandingAmplas).datagrid('getEditor',{index:PDEditIndex,field:'currency'});

				var hidebarang= $(ed_hidebarang.target).val();
				
				//$(ed_currency.target).attr('disabled','true');
				//var c =  $(ed_accessories.target).combogrid('grid');
				//c.datagrid('selectRecord',hidebarang);
				sandingStatus = 1; */
			} else{
				$(dgPD).datagrid('selectRow', PDEditIndex);
			}
		}
	}
	
	function AccSet(){
		var rows = $(dgAcc).datagrid('getChecked');
		var pesan ='';
		var pi_id = $('#dpi_id').val();
		var product_seq = $('#dseq').val();
		var product_code = $('#dproduct_code').val();
		
		for (i=0;i<rows.length;i++){
			pesan += '&pi_id_'+i+'='+pi_id+
								'&seq_'+i+'='+rows[i].seq+
								'&product_seq_'+i+'='+product_seq+
								'&product_code_'+i+'='+product_code+
								'&hidekodebarang_'+i+'='+rows[i].hidekodebarang;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/invoice/AccSet",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgAcc).datagrid('reload');
			}
		}); 
	}
	
	function BoxSet(){
		var rows = $(dgBox).datagrid('getChecked');
		var pesan ='';
		var pi_id = $('#bpi_id').val();
		var seq = $('#bseq').val();
		
		if (rows.length>0){
			for (i=0;i<rows.length;i++){
				pesan += '&pi_id_'+i+'='+pi_id+
									'&seq_'+i+'='+rows[i].seq+
									'&seq_pi_'+i+'='+seq;
			}
		}else {
			pesan += '&pi_id_'+i+'='+pi_id;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/invoice/BoxSet",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgBox).datagrid('reload');
			}
		}); 
		
	}
	
	function PIAccessories(){
		if (PIEndEditing()){
			var rows = $(dgPI).datagrid('getChecked');
			var pi_id ='';
			var seq ='';
			var product_code ='';
			var product_name ='';
			
			for (i=0;i<rows.length;i++){
				pi_id = rows[i].pi_id;
				seq = rows[i].seq;
				product_code= rows[i].product_code;
				product_name= rows[i].product_name;
			}
			
			$('#dpi_id').val(pi_id);
			$('#dseq').val(seq);
			$('#dproduct_code').val(product_code);
			
			if (pi_id!=''){
				//$('#did_cotation').val('');
				//$(dgAcc).datagrid({pageNumber:0});
				AmbilIDCotation('Accessories');
				//var tid_cot = $('#did_cotation').val();
				//var urlac = "<?php echo site_url(); ?>/cotation/DataAccessories/"+tid_cot;
				//$(dgAcc).datagrid({url:urlac});
				//$(dgAcc).datagrid('reload');
				$('#dlg').dialog({
					title : product_code+' - '+product_name
				});
				$('#dlg').dialog('open');
			}
		}
	}
	
	function PIBox(){
		if (PIEndEditing()){
			var rows = $(dgPI).datagrid('getChecked');
			var pi_id ='';
			var seq ='';
			var product_code ='';
			var product_name ='';
			var kdown ='';
			
			for (i=0;i<rows.length;i++){
				pi_id = rows[i].pi_id;
				seq = rows[i].seq;
				product_code= rows[i].product_code;
				kdown= rows[i].kdown;
			}
			
			$('#bpi_id').val(pi_id);
			$('#bseq').val(seq);
			$('#bproduct_code').val(product_code);
			$('#bkdown').val(kdown);
			
			if (pi_id!=''){
				AmbilIDCotation('Box');
				$('#dlgbox').dialog({
					title : product_code+' - '+product_name
				});
				$('#dlgbox').dialog('open');
			}
		}
	}
	
	function PIPO(){
		if (PIEndEditing()){
			if (vpi_id!=''){
				$('#dlgconfirm').dialog('open');
			}
		}
	}
	
	function PIPOBox(){
		if (PIEndEditing()){
			if (vpi_id!=''){
				$('#dlgconfirmbox').dialog('open');
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
			<th>PI No.</th>
			<th>Customer</th>
			<th>Date input PI</th>
			<th>Country</th>
		</tr>
		<?php
			if($pi_number!=''){
				?>    
				<tr>
					<td align="center"><?=$pi_number?></td>
					<td align="center"><?=urldecode($cust_name)?></td>
					<td align="center"><?=$this->app_model->tgl_indo($pi_dateorder)?></td>
					<td align="center"><?=$cust_state?></td>
			</tr>
			<?php
			
			}else{
			?>
				<tr>
					<td colspan="8" align="center" >Empty Data</td>
				</tr>
			<?php	
			}
		?>
		</table>
	</div>
	</td>
</tr>
<tr>
<td valign="top" width="50%">

	
    <fieldset>
    <table width="100%" border="0">
			<!--<tr>    
				<td width=""><b>Select Category : <input type="radio" name="BrandType" value="Upholstery" style="margin-left:50px;" >Upholstery<input type="radio" name="BrandType" value="Furniture" style="margin-left:50px;" >Furniture<input type="radio" name="BrandType" value="Decoration" style="margin-left:50px;" >Decoration<input type="radio" name="BrandType" value="Mirror" style="margin-left:50px;" >Mirror</b></td>
			</tr> -->
			<tr>
			<?php
			if($pi_number!=''){
				?>  
				<td><table id="dgPInvoice"></table></td>
			<?php 
				} else {
			?>
				<td><strong>Please set the PI Number to add the detail</strong></td>
			<?php
				}
			?>
			</tr>
	</table> 
	<table width="100%">
			<tr>
				<td colspan="3" align="center">
				<!--<button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>-->
				<!--<button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">CETAK</button>-->
				<a href="<?php echo base_url();?>index.php/invoice/">
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
<div id="dlg" class="easyui-dialog" title="Daftar Accessories" style="width:1000px;height:500px; padding:5px;" data-options="modal:true,closed:true">
	<input type="text" name="dpi_id" id="dpi_id" size="50" hidden="true" /> 
	<input type="text" name="dseq" id="dseq" size="50" hidden="true" /> 
	<input type="text" name="dproduct_code" id="dproduct_code" size="50" hidden="true" /> 
	<input type="text" name="did_cotation" id="did_cotation" class="easyui-validatebox" size="50" data-options="onChange : function(){$('#dgAccessories').datagrid('reload')}" hidden="true" /> 
	<!--
	<table id="dataTable">
		<tr>
			<th>Product Code</th>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table> -->
	<div id="dgAccessories"></div>
<script>
function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

    var result = { width: 0, height: 0, fScaleToTargetWidth: true };

    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }

    // scale to the target width
    var scaleX1 = targetwidth;
    var scaleY1 = (srcheight * targetwidth) / srcwidth;

    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight;
    var scaleY2 = targetheight;

    // now figure out which one we should use
		/*
    var fScaleOnWidth = (scaleX2 > targetwidth);
		
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
       fScaleOnWidth = !fLetterBox;
    }
		*/
		
		if (scaleX2 > targetwidth) {
        fScaleOnWidth = true;
    }
    else {
       fScaleOnWidth = false;
    }

    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    }
    else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);

    return result;
	}
	
	function OnImageLoad(evt) {

    var img = evt.currentTarget;

    // what's the size of this image and it's parent
    var w = $(img).width();
    var h = $(img).height();
    var tw = $(img).parent().width();
    var th = $(img).parent().height();
		
    // compute the new size and offsets
    var result = ScaleImage(w, h, tw, th, false);
		//alert(result.width+' '+result.height+' '+result.targetleft+' '+result.targettop);
    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
	}
</script>
</div>
<div id="dlgconfirm" align="center" class="easyui-dialog" title="Confirmation" style="width:420px;height:190px;padding:10px;" data-options="modal:true,closed:true">
	<table width="100%">
	<tr><td>Before Create PO, make sure you have already</td></tr>
	<tr><td><strong>1. Set the right accessories use for each of Product in Cotation.</strong></td></tr>
	<tr><td><strong>2. Checked and save all accessories used for each Product in this PI.</strong></td></tr>
	<tr><td>Do you want to continue Create PO?</td></tr>
	</table>
</div>
<div id="dlgbox" class="easyui-dialog" title="Daftar Accessories" style="width:1000px;height:500px; padding:5px;" data-options="modal:true,closed:true">
	<input type="text" name="bpi_id" id="bpi_id" size="50" hidden="true" /> 
	<input type="text" name="bseq" id="bseq" size="50" hidden="true" /> 
	<input type="text" name="bproduct_code" id="bproduct_code" size="50" hidden="true" /> 
	<input type="text" name="bkdown" id="bkdown" size="50" hidden="true" /> 
	<input type="text" name="bid_cotation" id="bid_cotation" class="easyui-validatebox" size="50" data-options="onChange : function(){$('#dgBox').datagrid('reload')}" hidden="true" /> 
	<!--
	<table id="dataTable">
		<tr>
			<th>Product Code</th>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table> -->
	<div id="dgBox"></div>
</div>
<div id="dlgconfirmbox" align="center" class="easyui-dialog" title="Confirmation" style="width:420px;height:190px;padding:10px;" data-options="modal:true,closed:true">
	<table width="100%">
	<tr><td>Before Create PO for Box, make sure you have already</td></tr>
	<tr><td><strong>1. Set the right box use for each of Product in Cotation.</strong></td></tr>
	<tr><td><strong>2. Checked and save all box used for each Product in this PI.</strong></td></tr>
	<tr><td>Do you want to continue Create PO for Box?</td></tr>
	</table>
</div>
<!--
<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="Daftar Barang" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Cari : <input type="text" name="text_cari" id="text_cari" size="50" />
	<div id="daftar_barang"></div>
</div>-->