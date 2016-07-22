	var dgWood = '#dgWood';
	var dgStatus = 0;
	var imageurl = "<?php echo base_url('asset/images/Upholstery1.png') ?>";
	
	function wood_cari_harga(index, kode_barang){
		/*
		var ed_currency = $("#dgWood").datagrid("getEditor", {index:index, field:'currency'});
		var ed_harga = $("#dgWood").datagrid("getEditor", {index:index, field:'brg_harga'});
		var ed_lengthunit = $("#dgWood").datagrid("getEditor", {index:index, field:'length_unit'}); */
		var kode = kode_barang;
		var currency=0;
		var harga=0;
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/harga_cotation",
			data	: "kode="+kode+"&type=wood",
			dataType: 'json',
			cache	: false, 
			success	: function(data){
				var $response=$(data);
					/*
					$(ed_currency.target).val($response[0]['currency']);
					$(ed_harga.target).numberbox('setValue',$response[0]['harga']);
					$(ed_lengthunit.target).val($response[0]['length_unit']); */
			
			}
		});
	}
	
	
	$(dgWood).datagrid({
		title: "Wood Cotation",
		width: 1020,
		height: 400,
		rownumbers:true,
		singleSelect:true,
		//fitColumns:true,
		collapsible:true,
		onClickRow: WoodOnClickRow,
		/* onLoadSuccess: function (data) {
			var panel = $(this).datagrid("getPanel");
			var header_comp_name1 = panel.find("div.datagrid-header td[field='wood_type']");
			var header_comp_name2 = panel.find("div.datagrid-header td[field='comp_name2']");
			
			header_comp_name1.css("border-right","2px solid #000");
		}, */
		//scrollbarSize:10,
		url:"<?php echo site_url(); ?>/cotation/DataWood/<?php echo $id_cotation; ?>",
		style:'padding:1px;', 
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			handler: function(){WoodInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			handler: function(){WoodRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			handler: function(){WoodGetChanges();}
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			handler: function(){WoodReject();} /*
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){WoodPrint();} */
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
					field:'unit_name',
					title:'unit_name',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidebarang',
					title:'hidebarang',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hideglue',
					title:'hideglue',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidea',
					title:'hidea',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hideb',
					title:'hideb',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidec',
					title:'hidec',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hided',
					title:'hided',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidee',
					title:'hidee',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidef',
					title:'hidef',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					title:'Component',
					colspan:3,
					align:'center'
				},{
					title:'Wood Type',
					field:'wood_type',
					width:150,
					rowspan:3,
					align:'center',
					editor: {
						type: "combobox",
						options: {
							valueField:"kode_barang",
							textField:"nama_barang",
							required:true,
							url:'<?php echo site_url(); ?>/ref_json/DataMaterial1/wood',
							onSelect: function(rows){
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index'));
								var ed_price_log = $(dgWood).datagrid("getEditor",{index:idx,field:'price_log'});
								var ed_currency = $(dgWood).datagrid("getEditor",{index:idx,field:'currency'});
								var ed_unit_name = $(dgWood).datagrid("getEditor",{index:idx,field:'unit_name'});
								var ed_waste_log = $(dgWood).datagrid("getEditor",{index:idx,field:'waste_log_plank'});
								var ed_waste_plank = $(dgWood).datagrid("getEditor",{index:idx,field:'waste_plank_raw'});
								var ed_waste_raw = $(dgWood).datagrid("getEditor",{index:idx,field:'waste_raw_comp'});
								
								WoodClearMyEditor(idx);
								
								$(ed_price_log.target).numberbox('setValue',rows.brg_harga);
								$(ed_currency.target).val(rows.currency_name);
								$(ed_unit_name.target).val(rows.unit_name);
								$(ed_waste_log.target).numberbox('setValue',rows.waste_log_plank);
								$(ed_waste_plank.target).numberbox('setValue',rows.waste_plank_raw);
								$(ed_waste_raw.target).numberbox('setValue',rows.waste_raw_comp);
								//alert(rows.unit_name);
								WoodCost(rows.currency_name,rows.brg_harga,rows.rates,rows.unit_name,rows.waste_log_plank,rows.waste_plank_raw,rows.waste_raw_comp);
							}
						}
					}
				},{
					title:'Finished Size (mm)',
					colspan:7
				},{
					title:'Qty',
					field:'quantity',
					rowspan:3,
					align:'center',
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_vol_finished =  $(dgWood).datagrid('getEditor',{index:idx,field:'vol_finished'});
									var ed_total_finished =  $(dgWood).datagrid('getEditor',{index:idx,field:'total_vol_finished'});
									var ed_vol_raw =  $(dgWood).datagrid('getEditor',{index:idx,field:'vol_raw'});
									var ed_total_raw =  $(dgWood).datagrid('getEditor',{index:idx,field:'total_vol_raw'});
									
									$(ed_total_finished.target).numberbox('setValue',Number($(ed_vol_finished.target).numberbox('getValue'))*Number(newValue));
									$(ed_total_raw.target).numberbox('setValue',Number($(ed_vol_raw.target).numberbox('getValue'))*Number(newValue)); */
									SumVolFinished();
									SumVolRaw();
									InitializeFaces('faces_a');
									InitializeFaces('faces_b');
									InitializeFaces('faces_c');
									InitializeFaces('faces_d');
									InitializeFaces('faces_e');
									InitializeFaces('faces_f');
								}
							}
						}
					}
				},{
					title:'Shape<br/>Waste<br />%',
					field:'shape_waste',
					align:'center',
					rowspan:3,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									SumVolFinished();
									SumVolRaw();
								}
							}
						}
					}
				},{
					title:'Raw Size',
					colspan:3
				},{
					title:'Vol (Finished)<br>per component',
					field:'vol_finished',
					align:'center',
					width:100,
					rowspan:3,
					formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
					editor: {
						type : "numberbox",
						options: {
							precision:2,
							groupSeparator:','
						}
					}
				},{
					title:'Total<br>Vol (Finished)',
					field:'total_vol_finished',
					align:'center',
					width:100,
					rowspan:3,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type : "numberbox",
						options: {
							precision:2,
							groupSeparator:','
						}
					}
				},{
					title:'Vol (Raw)<br>per component',
					field:'vol_raw',
					align:'center',
					width:100,
					rowspan:3,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type : "numberbox",
						options: {
							precision:2,
							groupSeparator:','
						}
					}
				},{
					title:'Total<br>Vol (Raw)',
					field:'total_vol_raw',
					align:'center',
					width:100,
					rowspan:3,
					formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
					editor: {
						type : "numberbox",
						options: {
							precision:2,
							groupSeparator:','
						}
					}
				},{
					title:'Faces<br><img src="'+imageurl+'" height="80px" width="130px"/>',
					colspan:12
				},{
					title:'face a total',
					field:'faces_a_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'face b total',
					field:'faces_b_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'face c total',
					field:'faces_c_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'face d total',
					field:'faces_d_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'face e total',
					field:'faces_e_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'face f total',
					field:'faces_f_total',
					align:'center',
					//rowspan:2,
					hidden: true,
					width:70,
					editor: {
						type: "numberbox"
					}
				},{
					title:'Wastes',
					colspan:3
				},{
					title:'Cost / m3',
					colspan:8
				},{
					title:'Price / m3',
					hidden:true,
					colspan:3
				},{
					title:'Production<br>Cost<br>(Rp)',
					field:'production_cost',
					align:'center',
					width:70,
					rowspan:3,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor:{
						type:"numberbox",
						options:{
							groupSeparator:',',
							//precision:0
						}
					}
				}
			],[
				{
					title:'Module',
					field:'comp_module',
					align:'center',
					width:140,
					rowspan:2,
					editor: {
						type: "validatebox",
						options:{
							required:true
						}
					}
				},{
					title:'Name',
					field:'comp_name1',
					width:140,
					align:'center',
					rowspan:2,
					editor: {
						type: "validatebox",
						options:{
							required:true
						}
					}
				},{
					field:'comp_name2',
					title:'Name Detail',
					width:140,
					align:'center',
					rowspan:2,
					editor: {
						type: "validatebox"
					}
				},{
					title:'L',
					colspan:5
				},{
					title:'W',
					field:'width',
					align:'center',
					rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_raw_width = $(dgWood).datagrid('getEditor',{index:idx,field:'raw_width'});
									var myNewValue = Number(newValue)+5;
									$(ed_raw_width.target).numberbox('setValue',myNewValue);
									SumVolFinished();
									SumVolRaw(); */
									onChangeSizeFinished('width');
								}
							}
						}
					}
				},{
					title:'H',
					field:'height',
					align:'center',
					rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_raw_height = $(dgWood).datagrid('getEditor',{index:idx,field:'raw_height'});
									var myNewValue = Number(newValue)+5;
									$(ed_raw_height.target).numberbox('setValue',myNewValue);
									SumVolFinished();
									SumVolRaw(); */
									onChangeSizeFinished('height');
								}
							}
						}
					}
				},{
					title:'L',
					field:'raw_length',
					align:'center',
					width:70,
					rowspan:2,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor:{
						type:"numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									SumVolRaw();
								}
							}
						}
					},
					styler: function (value, row, index){
						if (value!=Number(row.length)+10 && value!=0 && value!='')
						return 'background-color:#99CCFF;color:red;';
					}
				},{
					title:'W',
					field:'raw_width',
					align:'center',
					width:70,
					rowspan:2,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor:{
						type:"numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									SumVolRaw();
								}
							}
						}
					},
					styler: function (value, row, idx){
					  if (value!=Number(row.width)+5 && value!=0 && value!='')
						return 'background-color:#99CCFF;color:red;';
					}
				},{
					title:'H',
					field:'raw_height',
					align:'center',
					width:70,
					rowspan:2,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor:{
						type:"numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									SumVolRaw();
								}
							}
						}
					},
					styler: function (value, row, index){
						//var ed_width = $(dgWood).datagrid('getEditor',{index:index,field:'width'});
						//var width = $(ed_width.target).numberbox('getValue');
						if (value!=Number(row.height)+5 && value!=0 && value!='')
						 return 'background-color:#99CCFF;color:red;';
					}
				},{
					title:'A',
					align:'center',
					colspan:2
				},{
					title:'B',
					align:'center',
					colspan:2
				},{
					title:'C',
					align:'center',
					colspan:2
				},{
					title:'D',
					align:'center',
					colspan:2
				},{
					title:'E',
					align:'center',
					colspan:2
				},{
					title:'F',
					align:'center',
					colspan:2
				},{
					title:'Log to<br />plank<br /> ( % )',
					field:'waste_log_plank',
					align:'center',
					rowspan:2,
					width:70,
					formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
					editor: {
						type: "numberbox",
						options: {
							precision: 2,
						}
					}
				},{
					title:'Plank to raw<br/>component<br/>( % )',
					field:'waste_plank_raw',
					align:'center',
					rowspan:2,
					width:100,
					formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
					},
					editor: {
						type: "numberbox",
						options: {
							precision: 2
						}
					}
				},{
					title:'Raw component to<br /> finished component<br/>( % )',
					field:'waste_raw_comp',
					align:'center',
					rowspan:2,
					width:140,
					formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
					editor: {
						type: "numberbox",
						options: {
							precision: 2,
						}
					}
				},{
					title:'Total<br/>( % )',
					field:'waste_total',
					align:'center',
					hidden: true,
					rowspan:2,
					width:70,
					editor: {
						type: "numberbox",
						options : {
							precision: 2
						}
					}
				
				},{
					title:'Log',
					align:'center',
					colspan:2
				},{
					title:'Plank',
					align:'center',
					colspan:2
				},{
					title:'Raw',
					align:'center',
					colspan:2
				},{
					title:'Finish',
					align:'center',
					colspan:2
				},{
					title:'Currency',
					field:'currency',
					align:'center',
					rowspan:2,
					hidden:true,
					width:80,
					editor: {
						type: "validatebox"
					}
				},{
					title:'Log',
					field:'price_log',
					align:'center',
					hidden:true,
					rowspan:2,
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							align:'right',
							precision:2
						}
					}
				},{
					title:'Component<br />finished',
					field:'price_finished',
					align:'center',
					hidden:true,
					rowspan:2,
					width:100,
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:','
						}
					}
				}
			],[
				{
					field:'length',
					title:'Total L',
					align:'center',
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_raw_length = $(dgWood).datagrid('getEditor',{index:idx,field:'raw_length'});
									$(ed_raw_length.target).numberbox('setValue',Number(newValue)+10);
									SumVolFinished();
									SumVolRaw(); */
									onChangeSizeFinished('length');
								}
							}
						}
					}
				},{
					field:'length_left',
					title:'Tenon left',
					align:'center',
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox"
					}
				},{
					field:'length_center',
					title:'Body',
					align:'center',
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							onChange : function(newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									onChangeSizeFinished('length');
								}
							}
						}
					}
				},{
					field:'length_right',
					title:'Tenon Right',
					align:'center',
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox"
					}
				},{
					field:'length_glue',
					title:'Type glue',
					align:'center',
					width:70,
					editor: {
						type :"combobox",
						options: {
							valueField:"kode_barang",
							textField:"nama_barang",
							url: '<?php echo site_url(); ?>/ref_json/DataMaterial1/glue',
						}
					}
					
				},{
					title:'Material',
					field:'faces_a',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								//var tr = $(this).closest('tr.datagrid-row');
								//var idx = parseInt(tr.attr('datagrid-row-index'));
								//var ed_face_a_amount = $(dgWood).datagrid("getEditor",{index:idx,field:'faces_a_amount'});
								//var ed_face_a_total = $(dgWood).datagrid("getEditor",{index:idx,field:'faces_a_total'});
								//var ed_face_a_total = $(dgWood).datagrid("getEditor",{index:idx,field:'faces_a_total'});
								//$(ed_face_a_amount.target).numberbox('setValue',100);
								//$(ed_face_a_total.target).numberbox('setValue',100);
								SetFaceAmount('faces_a');
								InitializeFaces('faces_a');
							}
						}
					}
				},{
					title:'%',
					field:'faces_a_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_a');
								}
							}
						}
					}
				},{
					title:'Material',
					field:'faces_b',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								SetFaceAmount('faces_b');
								InitializeFaces('faces_b');
							}
						}
					}
				},{
					title:'%',
					field:'faces_b_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_b');
								}
							}
						}
					}
				},{
					title:'Material',
					field:'faces_c',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								SetFaceAmount('faces_c');
								InitializeFaces('faces_c');
							}
						}
					}
				},{
					title:'%',
					field:'faces_c_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_c');
								}
							}
						}
					}
				},{
					title:'Material',
					field:'faces_d',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								SetFaceAmount('faces_d');
								InitializeFaces('faces_d');
							}
						}
					}
				},{
					title:'%',
					field:'faces_d_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_d');
								}
							}
						}
					}
				},{
					title:'Material',
					field:'faces_e',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								SetFaceAmount('faces_e');
								InitializeFaces('faces_e');
							}
						}
					}
				},{
					title:'%',
					field:'faces_e_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_e');
								}
							}
						}
					}
				},{
					title:'Material',
					field:'faces_f',
					align:'center',
					//rowspan:2,
					width:100,
					editor: {
						type:"combobox",
						options : {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/wood',
							onSelect : function (rows){
								SetFaceAmount('faces_f');
								InitializeFaces('faces_f');
							}
						}
					}
				},{
					title:'%',
					field:'faces_f_amount',
					align:'center',
					//rowspan:2,
					width:70,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options : {
							onChange: function (newValue,oldValue){
								if (newValue!=oldValue && dgStatus!=0){
									InitializeFaces('faces_f');
								}
							}
						}
					}
				},{
					title:'$',
					field:'cost_log_usd',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							precision:2
						}
					}
				},{
					title:'Rp',
					field:'cost_log_idr',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'style:{text-align:right};';
					},
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						align:'right',
						options: {
							groupSeparator:',',
							//align:'right',
							//precision:2
						}
					}
				},{
					title:'$',
					field:'cost_plank_usd',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							precision:2
						}
					}
				},{
					title:'Rp',
					field:'cost_plank_idr',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							//precision:2
						}
					}
				},{
					title:'$',
					field:'cost_raw_usd',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							precision:2
						}
					}
				},{
					title:'Rp',
					field:'cost_raw_idr',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							//precision:2
						}
					}
				},{
					title:'$',
					field:'cost_finish_usd',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							precision:2
						}
					}
				},{
					title:'Rp',
					field:'cost_finish_idr',
					align:'center',
					width:100,
					//textAlign:'right',
					styler: function(value,row,index){
						return 'text-align:right;';
					},
					editor: {
						type: "numberbox",
						options: {
							groupSeparator:',',
							//align:'right',
							//precision:2
						}
					}
				}
			]
		]
	});
	
	var WoodEditIndex = undefined;
	WoodInsertRow = function() {
		var vid_cotation = <?php echo $id_cotation; ?>;
			
		if (WoodEndEditing()){
			$(dgWood).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',comp_module:'',comp_name1:'',comp_name2:''}});
			WoodEditIndex = 0;
			$(dgWood).datagrid('selectRow', WoodEditIndex)
					.datagrid('beginEdit', WoodEditIndex);
			WoodDisableMyEditor(WoodEditIndex);
			dgStatus = 1;
		}
	};
	function WoodDisableMyEditor(index){
		var ed_price_finished = $(dgWood).datagrid('getEditor',{index:index,field:'price_finished'});
		var ed_price_log = $(dgWood).datagrid('getEditor',{index:index,field:'price_log'});
		var ed_waste_total = $(dgWood).datagrid('getEditor',{index:index,field:'waste_total'});
		var ed_currency = $(dgWood).datagrid('getEditor',{index:index,field:'currency'});
		var ed_vol_finished = $(dgWood).datagrid('getEditor',{index:index,field:'vol_finished'});
		var ed_total_finished = $(dgWood).datagrid('getEditor',{index:index,field:'total_vol_finished'});
		var ed_vol_raw = $(dgWood).datagrid('getEditor',{index:index,field:'vol_raw'});
		var ed_total_raw = $(dgWood).datagrid('getEditor',{index:index,field:'total_vol_raw'});
		var ed_waste_plank = $(dgWood).datagrid('getEditor',{index:index,field:'waste_log_plank'});
		var ed_waste_raw = $(dgWood).datagrid('getEditor',{index:index,field:'waste_plank_raw'});
		var ed_waste_finished = $(dgWood).datagrid('getEditor',{index:index,field:'waste_raw_comp'});
		var ed_cost_log_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_log_usd'});
		var ed_cost_log_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_log_idr'});
		var ed_cost_plank_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_plank_usd'});
		var ed_cost_plank_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_plank_idr'});
		var ed_cost_raw_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_raw_usd'});
		var ed_cost_raw_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_raw_idr'});
		var ed_cost_finish_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_finish_usd'});
		var ed_cost_finish_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_finish_idr'});
		var ed_production_cost = $(dgWood).datagrid('getEditor',{index:index,field:'production_cost'});
		
		$(ed_price_finished.target).numberbox('disable');
		$(ed_price_log.target).numberbox('disable');
		$(ed_waste_total.target).numberbox('disable');
		$(ed_currency.target).attr('disabled','true');
		$(ed_vol_finished.target).numberbox('disable');
		$(ed_total_finished.target).numberbox('disable');
		$(ed_vol_raw.target).numberbox('disable');
		$(ed_total_raw.target).numberbox('disable');
		$(ed_waste_plank.target).numberbox('disable');
		$(ed_waste_raw.target).numberbox('disable');
		$(ed_waste_finished.target).numberbox('disable');
		$(ed_cost_log_usd.target).numberbox('disable');
		$(ed_cost_log_idr.target).numberbox('disable');
		$(ed_cost_plank_usd.target).numberbox('disable');
		$(ed_cost_plank_idr.target).numberbox('disable');
		$(ed_cost_raw_usd.target).numberbox('disable');
		$(ed_cost_raw_idr.target).numberbox('disable');
		$(ed_cost_finish_usd.target).numberbox('disable');
		$(ed_cost_finish_idr.target).numberbox('disable');
		$(ed_production_cost.target).numberbox('disable');
	}
	
	function WoodClearMyEditor(index){
		var ed_price_finished = $(dgWood).datagrid('getEditor',{index:index,field:'price_finished'});
		var ed_price_log = $(dgWood).datagrid('getEditor',{index:index,field:'price_log'});
		var ed_waste_total = $(dgWood).datagrid('getEditor',{index:index,field:'waste_total'});
		var ed_currency = $(dgWood).datagrid('getEditor',{index:index,field:'currency'});
		var ed_cost_log_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_log_usd'});
		var ed_cost_log_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_log_idr'});
		var ed_cost_plank_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_plank_usd'});
		var ed_cost_plank_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_plank_idr'});
		var ed_cost_raw_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_raw_usd'});
		var ed_cost_raw_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_raw_idr'});
		var ed_cost_finish_usd = $(dgWood).datagrid('getEditor',{index:index,field:'cost_finish_usd'});
		var ed_cost_finish_idr = $(dgWood).datagrid('getEditor',{index:index,field:'cost_finish_idr'});
		
		$(ed_price_finished.target).val('');
		$(ed_price_log.target).val('');
		$(ed_waste_total.target).val('');
		$(ed_currency.target).val('');
		$(ed_cost_log_usd.target).numberbox('setValue','');
		$(ed_cost_log_idr.target).numberbox('setValue','');
		$(ed_cost_plank_usd.target).numberbox('setValue','');
		$(ed_cost_plank_idr.target).numberbox('setValue','');
		$(ed_cost_raw_usd.target).numberbox('setValue','');
		$(ed_cost_raw_idr.target).numberbox('setValue','');
		$(ed_cost_finish_usd.target).numberbox('setValue','');
		$(ed_cost_finish_idr.target).numberbox('setValue','');
	}
	
	function WoodEndEditing(){
		if (WoodEditIndex == undefined){return true}
		if ($(dgWood).datagrid('validateRow', WoodEditIndex)){ /*
			var ed = $(dgWood).datagrid('getEditor', {index:WoodEditIndex,field:'family_id'});
			var ed1 = $(dgWood).datagrid('getEditor', {index:WoodEditIndex,field:'kode_barang'});*/
			var ed_comp_module = $(dgWood).datagrid('getEditor', {index:WoodEditIndex,field:'comp_module'});
			var ed_comp_name1 = $(dgWood).datagrid('getEditor', {index:WoodEditIndex,field:'comp_name1'});
			var ed_comp_name2 = $(dgWood).datagrid('getEditor', {index:WoodEditIndex,field:'comp_name2'});
			var comp_module = $(ed_comp_module.target).val();
			var comp_name1 = $(ed_comp_name1.target).val();
			var comp_name2 = $(ed_comp_name2.target).val();/*
			var family = $(ed.target).combobox('getValue');
			var material = $(ed1.target).combobox('getValue');
			//alert($(dgWood).datagrid('getRows')[WoodEditIndex]['family'])
			$(dgWood).datagrid('getRows')[WoodEditIndex]['family_id'] = family;
			$(dgWood).datagrid('getRows')[WoodEditIndex]['kode_barang'] = material;*/
			$(ed_comp_module.target).val(ucFirst(comp_module));
			$(ed_comp_name1.target).val(ucFirst(comp_name1));
			$(ed_comp_name2.target).val(ucFirst(comp_name2)); 
			$(dgWood).datagrid('endEdit', WoodEditIndex);
			WoodEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function WoodOnClickRow(index){
		if (WoodEditIndex != index){
			
			if (WoodEndEditing()){
				
				$(dgWood).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				WoodEditIndex = index;

				var ed_hidebarang = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hidebarang'});
				var ed_hideglue = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hideglue'});
				var ed_hidea = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hidea'});
				var ed_hideb = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hideb'});
				var ed_hidec = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hidec'});
				var ed_hided = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hided'});
				var ed_hidee = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hidee'});
				var ed_hidef = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'hidef'});
				var ed_wood = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'wood_type'});
				var ed_length_left = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'length_left'});
				var ed_length_center = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'length_center'});
				var ed_length_right = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'length_right'});
				var ed_glue = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'length_glue'});
				//var ed_height = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'height'});
				var ed_face_a_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_a_amount'});
				var ed_face_b_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_b_amount'});
				var ed_face_c_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_c_amount'});
				var ed_face_d_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_d_amount'});
				var ed_face_e_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_e_amount'});
				var ed_face_f_amount = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'faces_f_amount'});
				
				var hidebarang = $(ed_hidebarang.target).val();
				var hideglue = $(ed_hideglue.target).val();
				var hidea = $(ed_hidea.target).val();
				var hideb = $(ed_hideb.target).val();
				var hidec = $(ed_hidec.target).val();
				var hided = $(ed_hided.target).val();
				var hidee = $(ed_hidee.target).val();
				var hidef = $(ed_hidef.target).val();
				var length_left = $(ed_length_left.target).numberbox('getValue');
				var length_center = $(ed_length_center.target).numberbox('getValue');
				var length_right = $(ed_length_right.target).numberbox('getValue');
				//var width = $(ed_width.target).numberbox('getValue');
				//var height = $(ed_height.target).numberbox('getValue');
				var faces_a_amount = $(ed_face_a_amount.target).numberbox('getValue');
				var faces_b_amount = $(ed_face_b_amount.target).numberbox('getValue');
				var faces_c_amount = $(ed_face_c_amount.target).numberbox('getValue');
				var faces_d_amount = $(ed_face_d_amount.target).numberbox('getValue');
				var faces_e_amount = $(ed_face_e_amount.target).numberbox('getValue');
				var faces_f_amount = $(ed_face_f_amount.target).numberbox('getValue');
				//var url = '<?php echo site_url(); ?>/ref_json/DataMaterial1/wood/';
				//var urlglue = '<?php echo site_url(); ?>/ref_json/DataMaterial1/glue/';
				WoodDisableMyEditor(WoodEditIndex);
				
				if (length_left==0)
					$(ed_length_left.target).numberbox('setValue','');
				if (length_center==0)
					$(ed_length_center.target).numberbox('setValue','');
				if (length_right==0)
					$(ed_length_right.target).numberbox('setValue','');
				//if (width==0)
				//	$(ed_width.target).numberbox('setValue','');
				//if (height==0)
				//	$(ed_height.target).numberbox('setValue','');
				if (faces_a_amount==0)
					$(ed_face_a_amount.target).numberbox('setValue','');
				if (faces_b_amount==0)
					$(ed_face_b_amount.target).numberbox('setValue','');
				if (faces_c_amount==0)
					$(ed_face_c_amount.target).numberbox('setValue','');
				if (faces_d_amount==0)
					$(ed_face_d_amount.target).numberbox('setValue','');
				if (faces_e_amount==0)
					$(ed_face_e_amount.target).numberbox('setValue','');
				if (faces_f_amount==0)
					$(ed_face_f_amount.target).numberbox('setValue','');
				//$(ed_wood.target).combobox('reload',url);
				$(ed_wood.target).combobox('select',hidebarang);
				//$(ed_glue.target).combobox('reload',urlglue);
				$(ed_glue.target).combobox('select',hideglue);
				dgStatus = 1;
			} else{
				
				$(dgWood).datagrid('selectRow', WoodEditIndex);
			}
		}
	}
	
	function WoodRemoveIt(){
		if (WoodEditIndex == undefined){return}
		var ed = $(dgWood).datagrid("getEditor", {index:WoodEditIndex, field:'seq'});
		var ed1 = $(dgWood).datagrid("getEditor", {index:WoodEditIndex, field:'id_cotation'});
		var seq = $(ed.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Are you sure to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=wood",
						cache	: false,
						success	: function(data){
							$(dgWood).datagrid('cancelEdit', WoodEditIndex)
								.datagrid('deleteRow', WoodEditIndex);
							$(dgWood).datagrid('reload');
							WoodEditIndex = undefined;
							dgStatus = 0;
						}
					});
				}
			});
		}else{
			$(dgWood).datagrid('cancelEdit', WoodEditIndex)
				.datagrid('deleteRow', WoodEditIndex);			
			WoodEditIndex = undefined;
			dgStatus = 0;
		}
	}
	
	function WoodGetChanges(){
		WoodEndEditing();
		var rows = $(dgWood).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&comp_module_'+i+'='+rows[i].comp_module+
								'&comp_name1_'+i+'='+rows[i].comp_name1+
								'&comp_name2_'+i+'='+rows[i].comp_name2+
								'&wood_type_'+i+'='+rows[i].wood_type+
								'&length_'+i+'='+rows[i].length+
								'&length_left_'+i+'='+rows[i].length_left+
								'&length_center_'+i+'='+rows[i].length_center+
								'&length_right_'+i+'='+rows[i].length_right+
								'&length_glue_'+i+'='+rows[i].length_glue+
								'&width_'+i+'='+rows[i].width+
								'&height_'+i+'='+rows[i].height+
								'&quantity_'+i+'='+rows[i].quantity+
								'&shape_waste_'+i+'='+rows[i].shape_waste+
								'&raw_length_'+i+'='+rows[i].raw_length+
								'&raw_width_'+i+'='+rows[i].raw_width+
								'&raw_height_'+i+'='+rows[i].raw_height+
								'&vol_raw_'+i+'='+rows[i].vol_raw+
								'&vol_finished_'+i+'='+rows[i].vol_finished+
								'&waste_log_plank_'+i+'='+rows[i].waste_log_plank+
								'&waste_plank_raw_'+i+'='+rows[i].waste_plank_raw+
								'&waste_raw_comp_'+i+'='+rows[i].waste_raw_comp+
								'&cost_log_usd_'+i+'='+rows[i].cost_log_usd+
								'&cost_log_idr_'+i+'='+rows[i].cost_log_idr+
								'&cost_plank_usd_'+i+'='+rows[i].cost_plank_usd+
								'&cost_plank_idr_'+i+'='+rows[i].cost_plank_idr+
								'&cost_raw_usd_'+i+'='+rows[i].cost_raw_usd+
								'&cost_raw_idr_'+i+'='+rows[i].cost_raw_idr+
								'&cost_finish_usd_'+i+'='+rows[i].cost_finish_usd+
								'&cost_finish_idr_'+i+'='+rows[i].cost_finish_idr+
								'&price_log_'+i+'='+rows[i].price_log+
								'&price_finished_'+i+'='+rows[i].price_finished+
								'&production_cost_'+i+'='+rows[i].production_cost+
								'&currency_'+i+'='+rows[i].currency;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_wood",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgWood).datagrid('reload');
				dgStatus =0;
			}
		});
	
	}
	
	function cotation_wood(idx){ 
		
	}
	
	function WoodReject(){
		$(dgWood).datagrid('rejectChanges');
		WoodEditIndex = undefined;
		$(dgWood).datagrid('reload');
		dgStatus = 0;
	}
	
	function WoodPrint(){
			window.open('<?php echo site_url();?>/cotation/print_wood/<?php echo $id_cotation; ?>');
			//return false();
	}
		
	function SumVolFinished(){ 
		var ed_width = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'width'});
		var ed_length = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'length'});
		var ed_height = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'height'});
		var ed_vol_finished = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'vol_finished'});
		var ed_shape_waste = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'shape_waste'});
		var ed_quantity = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'quantity'});
		var ed_total_finished = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'total_vol_finished'});
		
		var vol = Number($(ed_width.target).numberbox('getValue')) * Number($(ed_length.target).numberbox('getValue')) * Number($(ed_height.target).numberbox('getValue')) * (1 + (Number($(ed_shape_waste.target).numberbox('getValue')) / 100));
		var total = vol * Number($(ed_quantity.target).numberbox('getValue'));
		$(ed_vol_finished.target).numberbox('setValue',vol);
		$(ed_total_finished.target).numberbox('setValue',total); 
	}
	
	function SumVolRaw(){ 
		var ed_width = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'raw_width'});
		var ed_length = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'raw_length'});
		var ed_height = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'raw_height'});
		var ed_vol_raw = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'vol_raw'});
		var ed_shape_waste = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'shape_waste'});
		var ed_quantity = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'quantity'});
		var ed_total_raw = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'total_vol_raw'});
		
		var vol = Number($(ed_width.target).numberbox('getValue')) * Number($(ed_length.target).numberbox('getValue')) * Number($(ed_height.target).numberbox('getValue')) * (1 + (Number($(ed_shape_waste.target).numberbox('getValue')) / 100));
		var total = vol * Number($(ed_quantity.target).numberbox('getValue'));
		$(ed_vol_raw.target).numberbox('setValue',vol);
		$(ed_total_raw.target).numberbox('setValue',total); 
		ProductCost();
	}
	
	function WoodCost(currency,price,rates,unit_name,waste_log_plank,waste_plank_raw,waste_raw_comp){
		var ed_cost_log_usd = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_log_usd'});
		var ed_cost_log_idr = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_log_idr'});
		var ed_cost_plank_usd = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_plank_usd'});
		var ed_cost_plank_idr = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_plank_idr'});
		var ed_cost_raw_usd = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_raw_usd'});
		var ed_cost_raw_idr = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_raw_idr'});
		var ed_cost_finish_usd = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_finish_usd'});
		var ed_cost_finish_idr = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'cost_finish_idr'});
		var cost = 0;
		
		if (unit_name.toLowerCase().indexOf("log")!=-1){
			if (currency=='$'){
				$(ed_cost_log_usd.target).numberbox('setValue',price);
				$(ed_cost_log_idr.target).numberbox('setValue',price*rates);
				$(ed_cost_plank_usd.target).numberbox('setValue',price/(1-(waste_log_plank*0.01)));
				$(ed_cost_plank_idr.target).numberbox('setValue',(price*rates)/(1-(waste_log_plank*0.01)));
				$(ed_cost_raw_usd.target).numberbox('setValue',price/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01)));
				$(ed_cost_raw_idr.target).numberbox('setValue',(price*rates)/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01)));
				$(ed_cost_finish_usd.target).numberbox('setValue',price/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
				$(ed_cost_finish_idr.target).numberbox('setValue',(price*rates)/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
			} else if (currency=='Rp'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',price);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',price/(1-(waste_log_plank*0.01)));
				$(ed_cost_raw_usd.target).numberbox('setValue',0);
				$(ed_cost_raw_idr.target).numberbox('setValue',price/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01)));
				$(ed_cost_finish_usd.target).numberbox('setValue',0);
				$(ed_cost_finish_idr.target).numberbox('setValue',price/(1-(waste_log_plank*0.01))/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
			} 
		} else if (unit_name.toLowerCase().indexOf("edged")!=-1){
			if (currency=='$'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',price);
				$(ed_cost_plank_idr.target).numberbox('setValue',(price*rates));
				$(ed_cost_raw_usd.target).numberbox('setValue',price/(1-(waste_plank_raw*0.01)));
				$(ed_cost_raw_idr.target).numberbox('setValue',(price*rates)/(1-(waste_plank_raw*0.01)));
				$(ed_cost_finish_usd.target).numberbox('setValue',price/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
				$(ed_cost_finish_idr.target).numberbox('setValue',(price*rates)/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
			} else if (currency=='Rp'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',price);
				$(ed_cost_raw_usd.target).numberbox('setValue',0);
				$(ed_cost_raw_idr.target).numberbox('setValue',price/(1-(waste_plank_raw*0.01)));
				$(ed_cost_finish_usd.target).numberbox('setValue',0);
				$(ed_cost_finish_idr.target).numberbox('setValue',price/(1-(waste_plank_raw*0.01))/(1-(waste_raw_comp*0.01)));
			}
		} else if (unit_name.toLowerCase().indexOf("raw")!=-1){
			if (currency=='$'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',0);
				$(ed_cost_raw_usd.target).numberbox('setValue',price);
				$(ed_cost_raw_idr.target).numberbox('setValue',price*rates);
				$(ed_cost_finish_usd.target).numberbox('setValue',price/(1-(waste_raw_comp*0.01)));
				$(ed_cost_finish_idr.target).numberbox('setValue',(price*rates)/(1-(waste_raw_comp*0.01)));
			} else if (currency=='Rp'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',0);
				$(ed_cost_raw_usd.target).numberbox('setValue',0);
				$(ed_cost_raw_idr.target).numberbox('setValue',price);
				$(ed_cost_finish_usd.target).numberbox('setValue',0);
				$(ed_cost_finish_idr.target).numberbox('setValue',price/(1-(waste_raw_comp*0.01)));
			}
		} else if (unit_name.toLowerCase().indexOf("finished")!=-1){
			if (currency=='$'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',0);
				$(ed_cost_raw_usd.target).numberbox('setValue',0);
				$(ed_cost_raw_idr.target).numberbox('setValue',0);
				$(ed_cost_finish_usd.target).numberbox('setValue',price);
				$(ed_cost_finish_idr.target).numberbox('setValue',price*rates);
			} else if (currency=='Rp'){
				$(ed_cost_log_usd.target).numberbox('setValue',0);
				$(ed_cost_log_idr.target).numberbox('setValue',0);
				$(ed_cost_plank_usd.target).numberbox('setValue',0);
				$(ed_cost_plank_idr.target).numberbox('setValue',0);
				$(ed_cost_raw_usd.target).numberbox('setValue',0);
				$(ed_cost_raw_idr.target).numberbox('setValue',0);
				$(ed_cost_finish_usd.target).numberbox('setValue',0);
				$(ed_cost_finish_idr.target).numberbox('setValue',price);
			}
		}
		ProductCost();
	}
	
	function SetFaceAmount(faces){
		var ed_face_amount = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:faces+'_amount'});
		$(ed_face_amount.target).numberbox('setValue',100);
	}
	
	function InitializeFaces(faces){
		switch (faces){
			case 'faces_a':
			case 'faces_b':
				FaceArea('length','width',faces);
				break;
			case 'faces_c':
			case 'faces_d':
				FaceArea('length','height',faces);
				break;
			case 'faces_e':
			case 'faces_f':
				FaceArea('width','height',faces);
				break;
		}
	}
	
	function FaceArea(facesA,facesB,faces){ 
		var ed_A = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:facesA});
		var ed_B = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:facesB});
		var ed_length_body = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'length_center'});
		var ed_face = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:faces});
		var ed_face_amount = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:faces+'_amount'});
		var ed_face_total = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:faces+'_total'});
		var ed_quantity = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'quantity'});
		
		var quantity = $(ed_quantity.target).numberbox('getValue');
		var amount = $(ed_face_amount.target).numberbox('getValue');
		var face = $(ed_face.target).combobox('getValue');
		var length_body = $(ed_length_body.target).numberbox('getValue');
		var A = $(ed_A.target).numberbox('getValue');
		var B = $(ed_B.target).numberbox('getValue');
		var total = 0;
		
		if (facesA=='length' && length_body!='' && length_body>0){
			A = length_body;
		} else if (facesB=='length' && length_body!='' && length_body>0){
			B = length_body;
		}
		
		if (face!='' && amount!='')
			total = A*B*quantity*(amount*0.01);
		
		$(ed_face_total.target).numberbox('setValue',total); 
		//alert($(ed_face_total.target).numberbox('getValue'));
	}
	
	function onChangeSizeFinished(size){
		
		var ed_size_raw = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:'raw_'+size});
		var ed_size_finished = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:size});
		
		//var ed_size_finished = $(dgWood).datagrid('getEditor',{index:WoodEditIndex,field:size});
		var size_finished = $(ed_size_finished.target).numberbox('getValue');
		var addValue=0;
		if (size=='length'){
			addValue=10;
		}else{
			addValue=5;
		}
		size_finished = Number(size_finished) + addValue;
		if (size!='length_body')
			$(ed_size_raw.target).numberbox('setValue',size_finished);
		SumVolFinished();
		SumVolRaw();
		
		switch (size){
			case 'length':
				InitializeFaces('faces_a');
				InitializeFaces('faces_b');
				InitializeFaces('faces_c');
				InitializeFaces('faces_d');
				break;
			case 'width':
				InitializeFaces('faces_a');
				InitializeFaces('faces_b');
				InitializeFaces('faces_e');
				InitializeFaces('faces_f');
				break;
			case 'height':
				InitializeFaces('faces_a');
				InitializeFaces('faces_b');
				InitializeFaces('faces_c');
				InitializeFaces('faces_d');
				break;
		} 
	}
	
	function ProductCost(){
		var ed_cost_raw_idr = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'cost_raw_idr'});
		var ed_vol_raw = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'vol_raw'});
		var ed_production_cost = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'production_cost'});
		var ed_quantity = $(dgWood).datagrid("getEditor",{index:WoodEditIndex,field:'quantity'});
		
		var cost_raw_idr = $(ed_cost_raw_idr.target).numberbox("getValue");
		var vol_raw = $(ed_vol_raw.target).numberbox("getValue");
		var quantity = $(ed_quantity.target).numberbox("getValue");
		var production_cost = Number(vol_raw) / 1000000000 * Number (cost_raw_idr) * Number(quantity);
		$(ed_production_cost.target).numberbox("setValue",production_cost);
	}