	var dgAccessories = '#dgAccessories';
	var accessoriesStatus = 0;
	var AccessoriesEditIndex = undefined;
	var vFam = '';
	var vType = '';
	
	$.extend($.fn.datagrid.defaults.editors, {
		combogrid: {
			init: function(container, options){
				var combo = $('<input type="text">').appendTo(container);
				combo.combogrid(options);
				return combo;
			},
			destroy: function(target){
				$(target).combogrid('destroy');
			},
			getValue: function(target){
				var opts = $(target).combogrid('options');
				if (opts.multiple){
					return $(target).combogrid('getValues').join(opts.separator);
				} else {
					return $(target).combogrid('getValue');
				}
			},
			setValue: function(target, value){
				var opts = $(target).combogrid('options');
				if (opts.multiple){
					if (value){
						$(target).combogrid('setValues', value.split(opts.separator));
					} else {
						$(target).combogrid('clear');
					}
				} else {
					$(target).combogrid('setValue', value);
				}
			},
			resize: function(target, width){
				$(target).combogrid('resize', width)
			}
		}
	});
	/*
	var myview = $.extend({}, $.fn.datagrid.defaults.view, {
		onAfterRender: function(target){
			$.fn.datagrid.defaults.view.onAfterRender.call(this, target);
			var opts = $(target).datagrid('options');
			if (opts.rownumber){
				var lastTr = opts.finder.getTr(target, null, 'first');
				var tmp = $('<div style="position:absolute;padding:0 6px;left:-999999;height:50px;"></div>').appendTo('body');
				tmp.html(lastTr.find('div.datagrid-cell-rownumber').html());
				var width = tmp._outerWidth();
				var height = tmp._outerHeight();
				tmp.remove();
				
				$(target).datagrid('datagrid').css.add([
					['.datagrid-cell-rownumber',width+'px']//,
					//['.datagrid-header-rownumber',width+'px']
				]);
				setTimeout(function(){
					$(target).datagrid('fitColumns');
				},0);
			}
		}
	}); */
		
	$(dgAccessories).datagrid({
		title: "Accessories & Hardware Cotation",
		//width: 1020,
		height: 300,
		rownumbers:true,
		//view:myview,
		singleSelect:false,
		nowrap:false,
		selectOnCheck: false,
		checkOnSelect: false,
		collapsible:true,
		onClickRow: AccessoriesOnClickRow,
		//showFooter:true,
		//onRowContextMenu:AccessoriesRowMenu,
		url:"<?php echo site_url(); ?>/cotation/DataAccessories/<?php echo $id_cotation; ?>",
		onLoadSuccess : function(data){
			/*
			var panel = $(this).datagrid("getPanel");
			
			var myrownumbercol = panel.find("div.datagrid-cell-rownumber");
			var myfittingcol = panel.find("div.datagrid-cell-acc_hard");
			//myrownumbercol.css("height","auto");
			alert(myrownumbercol.toSource());*/
			$(this).datagrid('resize');
		},
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			handler: function(){AccessoriesInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			handler: function(){AccessoriesRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			handler: function(){AccessoriesGetChanges();}
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			handler: function(){AccessoriesReject();}
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){AccessoriesPrint();}
		},'-',{
			iconCls: 'icon-master',
			text :'Add Accessories / Hardware',
			handler: function(){AccessoriesAdd();}
		},'-',{
			iconCls: 'icon-docexcel',
			text :'Import',
			handler: function(){accessories_import();}
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
					field:'hidefinishing',
					title:'hidefinishing',
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
					hidden:true,
					editor: {
						type: "numberbox"
					}
				// Tambah checkbox
				},{
					field:'ck',
					checkbox: true
				},{
					field:'acc_hard',
					title:'Use By',
					width: 150,
					rowspan:3,
					editor: {
						type: "combobox",
						options : {
							textField:'label',
							valueField:'value',
							required:true,
							data:[{label:'Assembling',value:'Assembling'},{label:'Fitting',value:'Fitting'},{label:'Assembling+Fitting',value:'Assembling+Fitting' }],
							onSelect : function (record){
								//var urlcode = '<?php echo site_url(); ?>/ref_json/ComboboxCodeSpc/'+record.value;
								//var urltype = '<?php echo site_url(); ?>/ref_json/ComboboxType/'+record.value;
								//var urlnama = '<?php echo site_url(); ?>/ref_json/ComboboxAccHrd/'+record.value;
								//var ed_code = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'code'});
								//var ed_type = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'type'});
								//var ed_nama = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'accessories_type'});
								
								//var grid = $(ed_nama.target).combogrid('grid');
								vFam = record.value;
								vType ='';
								//$(ed_code.target).combobox('reload',urlcode);
								//$(ed_type.target).combobox('reload',urltype);
								//grid.datagrid('reload');
								//$(ed_code.target).combobox('clear');
								//$(ed_type.target).combobox('clear');
								//$(ed_nama.target).combogrid('clear');
							}
						}
					}	
				},{
					field:'code',
					title:'Code Linoti',
					align:'center',
					width:100,
					rowspan:3,
					editor: {
						type: "combobox",
						options: {
							valueField:"kode_barang_spc",
							textField:"kode_barang_spc",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxCodeSpc/',
							mode:'remote',
							onSelect: function (rows){
								var ed_type = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'type'});
								var ed_nama = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'accessories_type'});
								var ed_hidekodebarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidekodebarang'});
								var ed_hidenamabarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidenamabarang'});
								var ed_hidefoto = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidefoto'});
								//var ed_size = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'size'});
								var ed_hidesize = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidesize'});
								var ed_hideunit = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hideunit'});
								var ed_hidefinishing = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidefinishing'});
								$(ed_type.target).combobox('setValue',rows.type);
								//$(ed_nama.target).combogrid('datagrid').datagrid('reload');
								
								$(ed_hidekodebarang.target).val(rows.kode_barang);
								$(ed_hidenamabarang.target).val(rows.nama_barang);
								var namat = rows.nama_barang;
								$(ed_hidefoto.target).val(rows.foto_barang);
								$(ed_nama.target).combogrid('setValue',rows.nama_barang);
								//$(ed_size.target).val(rows.size);
								$(ed_hidesize.target).val(rows.hidesize);
								$(ed_hideunit.target).val(rows.unit_name);
								$(ed_hidefinishing.target).val(rows.finishing);
							},
							filter: function(q,row){
								return row.kode_barang_spc.toLowerCase().indexOf(q.toLowerCase())==0;
							}
						}
					}	
				},{
					field:'type',
					title:'Type',
					width:150,
					rowspan:3,
					editor: {
						type: "combobox",
						options: {
							valueField:'type',
							textField:'type',
							url:'<?php echo site_url(); ?>/ref_json/ComboboxType/',
							mode:'remote',
							onSelect: function(rows){
								var ed_acc_hrd = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'acc_hard'});
								var acc_hrd = $(ed_acc_hrd.target).combobox('getValue');
								var urlcode = '<?php echo site_url(); ?>/ref_json/ComboboxCodeSpc/'+acc_hrd+'/'+rows.type;
								//var urlnama = '<?php echo site_url(); ?>/ref_json/ComboboxAccHrd/'+acc_hrd+'/'+rows.type;
								var ed_code = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'code'});
								var ed_nama = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'accessories_type'});
								$(ed_code.target).combobox('reload',urlcode);
								//$(ed_nama.target).combobox('reload',urlnama);
								vType = rows.type;
								$(ed_code.target).combobox('clear');
								$(ed_nama.target).combogrid('clear');
							},
							filter: function(q,row){
								return row.type.toLowerCase().indexOf(q.toLowerCase())==0;
							}
						}
					}	
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
					rowspan:3,
					//align:'center',
					editor: {
						type: 'combogrid',
						options: {
							panelWidth: 650,
							panelHeight: 350,
							prompt: 'Server ...',
					    //rownumbers: true,
					    singleSelect:true,
					    autoRowHeight:false,
							idField:"nama_barang",
							textField:"nama_barang", 
							mode: 'remote',
							method:'post',
							required:true,
							columns: [[
								{field:'kode_barang',title:'Kode Barang',width:80, hidden:true},
								{field:'unit_name',title:'Unit',width:80, hidden:true},
								{field:'type',title:'Type',width:80, hidden:true},
								{field:'foto_barang',title:'Foto',width:80, hidden:true},
								{field:'kode_barang_spc',title:'Code',width:80},
								{field:'nama_barang',title:'Name',width:200},
								{field:'hidesize',title:'Size', align:'center', width:220},
								{field:'finishing',title:'Finishing', align:'center', width:120}
							]],
							url:'<?php echo site_url(); ?>/ref_json/ComboboxAccHrd/',
							
							onSelect: function(index, record){
								var ed_code = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'code'});
								var ed_type = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'type'});
								var ed_hidekodebarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidekodebarang'});
								var ed_hidenamabarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidenamabarang'});
								var ed_hidefoto = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidefoto'});
								var ed_hidesize = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidesize'});
								var ed_hideunit = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hideunit'});
								var ed_hidefinishing = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidefinishing'});
								$(ed_hidekodebarang.target).val(record.kode_barang);
								$(ed_hidenamabarang.target).val(record.nama_barang);
								$(ed_hidefoto.target).val(record.foto_barang);
								$(ed_code.target).combobox('setValue',record.kode_barang_spc);
								$(ed_type.target).combobox('setValue',record.type);
								$(ed_hidesize.target).val(record.hidesize);
								$(ed_hideunit.target).val(record.unit_name);
								$(ed_hidefinishing.target).val(record.finishing);
							}, 
							onBeforeLoad:function(param){
								param.fam = vFam;
								param.type =vType;
							},
							filter: function(q, row){
									var opts = $(this).combogrid('options');
									return row[opts.textField].indexOf(q) == 0;
							},
							pagination:true 
						}
					}
					
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
					rowspan:3,
					/*
					editor: {
						type: "combobox",
						options : {
							valueField:'finishing',
							textField:'finishing',
							url:'<?php echo site_url(); ?>/ref_json/ComboboxFinishing/',
							filter: function(q,row){
								return row.finishing.toLowerCase().indexOf(q.toLowerCase())==0;
							}
						}
						
					} */
					formatter:function(value,row,index){
						if (row.hidefinishing==''){
							return '';
						} else {
							return row.hidefinishing;
						}
					}
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
					},
					editor: {
						type: "numberbox",
						options : {
							precision:3,
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && newValue!='' && accessoriesStatus!=0){
									//AccessoriesProductCost();
								}
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
	
	
	
	var vid_cotation = '<?php echo $id_cotation; ?>';
	AccessoriesInsertRow = function() {
		
		if (AccessoriesEndEditing()){
			$(dgAccessories).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',quantity:0}});
			AccessoriesEditIndex = 0;
			$(dgAccessories).datagrid('selectRow', AccessoriesEditIndex)
					.datagrid('beginEdit', AccessoriesEditIndex);
			//var ed_currency = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'currency'});
			//$(ed_currency.target).attr('disabled','true');
			accessoriesStatus = 1;
			vFam = '';
			vType = '';
		}
	};
	
	
	
	function AccessoriesEndEditing(){
		if (AccessoriesEditIndex == undefined){return true}
		if ($(dgAccessories).datagrid('validateRow', AccessoriesEditIndex)){
			$(dgAccessories).datagrid('endEdit', AccessoriesEditIndex);
			AccessoriesEditIndex = undefined;
			vFam = '';
			vType = '';
			return true;
		} else {
			return false;
		}
	}
	
	function AccessoriesOnClickRow(index){
		if (AccessoriesEditIndex != index){
			
			if (AccessoriesEndEditing()){
				$(dgAccessories).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				AccessoriesEditIndex = index;
				
				var ed_seq = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'seq'});
				var ed_acc_hrd = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'acc_hard'});
				var ed_hidekodebarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidekodebarang'});
				var ed_hidenamabarang = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'hidenamabarang'});
				var ed_code = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'code'});
				var ed_type = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'type'});
				var ed_finishing = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'finishing'});
				var ed_accessories_type = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'accessories_type'});

				var seq = $(ed_seq.target).val();
				var acc_hard = $(ed_acc_hrd.target).combobox('getValue');
				var code = $(ed_code.target).combobox('getValue');
				var type = $(ed_type.target).combobox('getValue');
				var finishing = $(ed_finishing.target).combobox('getValue');
				var hidekodebarang= $(ed_hidekodebarang.target).val();
				var hidenamabarang= $(ed_hidenamabarang.target).val();
				
				var urlcode = '<?php echo site_url(); ?>/ref_json/ComboboxCodeSpc/'+acc_hard;
				var urltype = '<?php echo site_url(); ?>/ref_json/ComboboxType/'+acc_hard;
				//var urlnama = '<?php echo site_url(); ?>/ref_json/ComboboxAccHrd/'+acc_hard;
								
				//$(ed_currency.target).attr('disabled','true');
				$(ed_acc_hrd.target).combobox('select',acc_hard);
				
				$(ed_code.target).combobox('reload',urlcode);
				$(ed_type.target).combobox('reload',urltype);
				$(ed_accessories_type.target).combogrid('grid').datagrid('reload');
				$(ed_finishing.target).combobox('reload');
				
				$(ed_code.target).combobox('setValue',code);
				$(ed_type.target).combobox('setValue',type);
				$(ed_finishing.target).combobox('setValue',finishing);
				$(ed_accessories_type.target).combogrid('setValue',hidenamabarang);
				vFam = acc_hard;
				vType = type;
				accessoriesStatus = 1;
			} else{
				$(dgAccessories).datagrid('selectRow', AccessoriesEditIndex);
			}
		}
	}
	
	function AccessoriesRemoveIt(){
		if (AccessoriesEditIndex == undefined){return}
		var ed_seq = $(dgAccessories).datagrid("getEditor", {index:AccessoriesEditIndex, field:'seq'});
		var ed1 = $(dgAccessories).datagrid("getEditor", {index:AccessoriesEditIndex, field:'id_cotation'});
		var seq = $(ed_seq.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Are you sure to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=accessories",
						cache	: false,
						success	: function(data){
							$(dgAccessories).datagrid('cancelEdit', AccessoriesEditIndex)
								.datagrid('deleteRow', AccessoriesEditIndex);
							$(dgAccessories).datagrid('reload');
							AccessoriesEditIndex = undefined;
							accessoriesStatus = 0;
						}
					});
					vFam = '';
					vType = '';
				}
			});
		}else{
			$(dgAccessories).datagrid('cancelEdit', AccessoriesEditIndex)
				.datagrid('deleteRow', AccessoriesEditIndex);			
			AccessoriesEditIndex = undefined;
			vFam ='';
			vType = '';
			accessoriesStatus = 0;
		}
		
	}
	
	function AccessoriesGetChanges(){
		AccessoriesEndEditing();
		var rows = $(dgAccessories).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&acc_hard_'+i+'='+rows[i].acc_hard+
								'&kode_barang_spc_'+i+'='+rows[i].code+
								'&accessories_type_'+i+'='+rows[i].hidekodebarang+
								'&size_'+i+'='+rows[i].size+
								'&hidesize_'+i+'='+rows[i].hidesize+
								'&finishing_'+i+'='+rows[i].finishing+
								'&quantity_'+i+'='+rows[i].quantity+
								'&unit_'+i+'='+rows[i].unit;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_accessories",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgAccessories).datagrid('reload');
				accessoriesStatus =0;
			}
		});
		
		vFam = '';
		vType = '';
		
	}
	
	function AccessoriesReject(){
		$(dgAccessories).datagrid('rejectChanges');
		AccessoriesEditIndex = undefined;
		$(dgAccessories).datagrid('reload');
		vFam = '';
		vType = '';
		accessoriesStatus = 0;
	}
	
	function AccessoriesPrint(){
		var rows = $(dgAccessories).datagrid('getChecked');
		var kode_barang_ass ='-';
		var kode_barang_fit ='-';
		var kode_barang_assfit ='-';
		//var pesan='';
		for (i=0;i<rows.length;i++){
			if (rows[i].acc_hard=='Assembling'){
				kode_barang_ass += rows[i].hidekodebarang+'-';
			} else { 
				if (rows[i].acc_hard=='Fitting') {
					kode_barang_fit += rows[i].hidekodebarang+'-';
				} else{
					kode_barang_assfit += rows[i].hidekodebarang+'-';
				}
			}
			//if(pesan==''){
			//	pesan=rows[i].ck;
			//}
		}
		//alert(kode_barang_ass+' : '+kode_barang_fit+' : '+kode_barang_assfit);
		//alert(pesan);
			window.open('<?php echo site_url();?>/cotation/print_accessories/<?php echo $id_cotation; ?>/'+kode_barang_ass+'/'+kode_barang_fit+'/'+kode_barang_assfit);
			//return false();
	}
	
	function accessories_import(){
		var id_cotation = '<?php echo $id_cotation ?>';
		$("#dialogImpAcc").load('<?php echo base_url();?>index.php/cotation/showImportAcc/'+id_cotation+'/',function(){
			$("#dialogImpAcc").dialog({
				autoOpen: false,
				width: 700, 
				modal: true,
				hide: 'fade',
				show: 'fade',
				closeOnEscape: false, 
				draggable: true,
				resizable: true,
				title: 'Import Data '
			});
			
			$('#dialogImpAcc').dialog('open');
		});
	}
	
	function AccessoriesCost(currency,price,rates,unit_name){
		
		var ed_harga = $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'brg_harga'});
		if (currency!='Rp'){
			price = Number(price) * Number(rates);
		} else {
		  price = Number(price);
		}
		
		if (price=='')
			price = 0;
		
		$(ed_harga.target).numberbox('setValue',price);
		AccessoriesProductCost();
	}
	
	function AccessoriesProductCost(){
	
		var ed_production_cost	= $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'production_cost'});
		var ed_quantity	= $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'quantity'});
		var ed_harga	= $(dgAccessories).datagrid('getEditor',{index:AccessoriesEditIndex,field:'brg_harga'});
		var Cost = 0;
		
		var Cost = Number($(ed_harga.target).numberbox('getValue')) * Number($(ed_quantity.target).numberbox('getValue'));
		
		$(ed_production_cost.target).numberbox('setValue',Cost);
	}
	
	function AccessoriesAdd(){
		$("#dialogAcc").load('<?php echo base_url();?>index.php/cotation/showAccessories',function(){
			$("#dialogAcc").dialog({
				autoOpen: false,
				width: 1300, 
				modal: true,
				hide: 'fade',
				show: 'fade',
				closeOnEscape: false, 
				draggable: true,
				resizable: true,
				title: 'New Accessories / Hardware '
			});
			
			$('#dialogAcc').dialog('open');
		});
	}
	