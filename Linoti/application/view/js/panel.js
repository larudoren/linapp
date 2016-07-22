	var dgPanel = '#dgPanel';
	var panelStatus = 0;
	
	function ucFirst(string){
		 return string.charAt(0).toUpperCase() + string.slice(1);
	}
	$(dgPanel).datagrid({
		title: "Panel Cotation",
		width: 1020,
		height: 400,
		rownumbers:true,
		singleSelect:true,
		collapsible:true,
		onClickRow: PanelOnClickRow,
		onRowContextMenu:PanelRowMenu,
		url:"<?php echo site_url(); ?>/cotation/DataPanel/<?php echo $id_cotation; ?>",
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			handler: function(){PanelInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			handler: function(){PanelRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			handler: function(){PanelGetChanges();}
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			handler: function(){PanelReject();}
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){PanelPrint();}
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
					field:'statuscopy',
					title:'statuscopy',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'seq_det',
					title:'seq_det',
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
					field:'hidetype_material_a',
					title:'hidetype_material_a',
					rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidetype_material_b',
					title:'hidetype_material_b',
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
					title:'Component',
					rowspan:2,
					colspan:3,
					align:'center'
				},{
					title:'Panel Type',
					field:'panel_type',
					width:150,
					rowspan:3,
					align:'center',
					editor: {
						type: "combobox",
						options: {
							valueField:"kode_barang",
							textField:"nama_barang",
							required:true,
							url:'<?php echo site_url(); ?>/ref_json/DataMaterial1/panel',
							onSelect: function(rows){
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index')); 
								var ed_height = $(dgPanel).datagrid("getEditor",{index:idx,field:'height'});
								var ed_raw_height = $(dgPanel).datagrid("getEditor",{index:idx,field:'raw_height'});
								$(ed_height.target).numberbox('setValue',rows.size_height);
								$(ed_raw_height.target).numberbox('setValue',rows.size_height);
								PanelCost(rows.currency_name,rows.brg_harga,rows.rates,rows.size_length,rows.size_width,rows.length_unit);
							}
						}
					}
				},{
					title:'Finished Size (mm)',
					rowspan:2,
					colspan:3
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									PanelAreaRaw();
									PanelFaceArea('length','width','faces_a');
									PanelFaceArea('length','width','faces_b');
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									PanelAreaRaw();
								}
							}
						}
					}
				},{
					title:'Raw Size',
					rowspan:2,
					colspan:3
				},{
					title:'Area Panel Include Waste',
					field:'area_panel_total',
					rowspan:3,
					width:100,
					hidden:true,
					editor:{
						type:'numberbox',
						options:{
							onChange :function(newValue,oldValue) {
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index')); 
								var ed_seq_det = $(dgPanel).datagrid('getEditor',{index:idx,field:'seq_det'});
								var seq_det = $(ed_seq_det.target).val();
								if (newValue!=oldValue && panelStatus!=0 && seq_det=='0' && newValue!=''){
									PanelProductCost();
								}
							}
						}
					}
				},{
					title:'Area Panel ',
					field:'area_panel',
					rowspan:3,
					width:100,
					hidden:true,
					editor:{
						type:'numberbox',
						options: {
							onChange : function(newValue,oldValue){
							  var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index')); 
								var ed_seq_det = $(dgPanel).datagrid('getEditor',{index:idx,field:'seq_det'});
								var seq_det = $(ed_seq_det.target).val();
								if (newValue!=oldValue && panelStatus!=0 && seq_det=='0' && newValue!=''){
									//PanelRecountDetail(Number(newValue));
								}
							}
						}
					}
					},{
					title:'Finished Area Panel ',
					field:'finished_area_panel',
					rowspan:3,
					width:100,
					hidden:true,
					editor:{
						type:'numberbox',
						options: {
							onChange : function(newValue,oldValue){
							  var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index')); 
								var ed_seq_det = $(dgPanel).datagrid('getEditor',{index:idx,field:'seq_det'});
								var seq_det = $(ed_seq_det.target).val();
								if (newValue!=oldValue && panelStatus!=0 && seq_det=='0' && newValue!=''){
									PanelRecountDetail(Number(newValue));
								}
							}
						}
					}
				},{
					title:'Faces',
					colspan:6
				},{
					title:'Faces A Total ',
					field:'faces_a_total',
					hidden:true,
					width:100,
					rowspan:3,
					editor: {
						type:'numberbox'
					}
				},{
					title:'Faces B Total ',
					field:'faces_b_total',
					hidden:true,
					width:100,
					rowspan:3,
					editor: {
						type:'numberbox'
					}
				},{
					title:'Cost<br>Production<br>(Rp)',
					field:'production_cost',
					align:'center',
					width:100,
					rowspan:3,
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							groupSeparator:','
						}
					}
				},{
					title:'Raw Cost per mm2',
					field:'raw_cost',
					align:'center',
					hidden:true,
					width:100,
					rowspan:3,
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:8,
							groupSeparator:','
						}
					}
				}
			],[
				{
					title:'A',
					colspan:3
				},{
					title:'B',
					colspan:3
				}
			],[
				{
					title:'Module',
					field:'comp_module',
					align:'center',
					width:140,
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
					editor: {
						type: "validatebox"
					}
				},{
					title:'L',
					field:'length',
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_raw_width = $(dgPanel).datagrid('getEditor',{index:idx,field:'raw_width'});
									var myNewValue = Number(newValue)+5;
									$(ed_raw_width.target).numberbox('setValue',myNewValue);
									SumVolFinished();
									SumVolRaw(); */
				
									panelChangeSizeFinished('length');
								}
							}
						}
					}
				},{
					title:'W',
					field:'width',
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){ 
									panelChangeSizeFinished('width');
								}
							}
						}
					}
				},{
					title:'H',
					field:'height',
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){ /*
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed_raw_height = $(dgPanel).datagrid('getEditor',{index:idx,field:'raw_height'});
									var myNewValue = Number(newValue)+5;
									$(ed_raw_height.target).numberbox('setValue',myNewValue);
									SumVolFinished();
									SumVolRaw(); */
									//panelChangeSizeFinished('height');
								}
							}
						}
					}
				},{
					title:'L',
					field:'raw_length',
					align:'center',
					width:70,
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									PanelAreaRaw();
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
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									PanelAreaRaw();
								}
							}
						}
					},
					styler: function (value, row, idx){
					  if (value!=Number(row.width)+10 && value!=0 && value!='')
						return 'background-color:#99CCFF;color:red;';
					}
				},{
					title:'H',
					field:'raw_height',
					align:'center',
					width:70,
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
								if (newValue!=oldValue && panelStatus!=0){
									//PanelAreaRaw();
								}
							}
						}
					},
					styler: function (value, row, index){
						//var ed_width = $(dgPanel).datagrid('getEditor',{index:index,field:'width'});
						//var width = $(ed_width.target).numberbox('getValue');
						if (value!=Number(row.height) && value!=0 && value!='')
						 return 'background-color:#99CCFF;color:red;';
					}
				},{
					title:'Material',
					field:'faces_a',
					align:'center',
					width:100,
					editor:{
						type:'combobox',
						options: {
							valueField: "layer_id",
							textField: "layer",
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/panel',
							onSelect: function(rec){
								var urls = '<?php echo site_url(); ?>/ref_json/DataTypeMaterial/'+rec.layer;
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index'));
								var ed = $(dgPanel).datagrid('getEditor',{index:idx,field:'type_material_a'});
								$(ed.target).combobox('reload',urls);
							}
						}
					}
				},{
					title:'%',
					field:'faces_a_amount',
					align:'center',
					width:70,
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
							precision:2,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									var ed_a_total = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex, field:'faces_a_total'});
									var ed_finished_area = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex, field:'finished_area_panel'});
									var finished_area = $(ed_finished_area.target).numberbox('getValue');
									$(ed_a_total.target).numberbox('setValue',Number(newValue/100*finished_area));
								}
							}
						}
					}
				},{
					title:'Type of Material',
					field:'type_material_a',
					align:'center',
					width:150,
					editor:{
						type:'combobox',
						options:{
							valueField:'kode_material',
							textField:'nama_material'
						}
					}
				},{
					title:'Material',
					field:'faces_b',
					align:'center',
					width:100,
					editor:{
						type:'combobox',
						options: {
							valueField: "layer_id",
							textField: "layer",
							//multiple:true,
							url:'<?php echo site_url(); ?>/ref_json/ComboboxLayer/panel',
							onSelect: function(rec){
								var urls = '<?php echo site_url(); ?>/ref_json/DataTypeMaterial/'+rec.layer;
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index'));
								var ed = $(dgPanel).datagrid('getEditor',{index:idx,field:'type_material_b'});
								$(ed.target).combobox('reload',urls);
							}
						}
					}
				},{
					title:'%',
					field:'faces_b_amount',
					align:'center',
					width:70,
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
							precision:2,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && panelStatus!=0){
									var ed_b_total = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex, field:'faces_b_total'});
									var ed_finished_area = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex, field:'finished_area_panel'});
									var finished_area = $(ed_finished_area.target).numberbox('getValue');
									$(ed_b_total.target).numberbox('setValue',Number(newValue/100*finished_area));
								}
							}
						}
					}
				},{
					title:'Type of Material',
					field:'type_material_b',
					align:'center',
					width:150,
					editor:{
						type:'combobox',
						options:{
							//multiple:false,
							valueField:'kode_material',
							textField:'nama_material'
						}
					}
				}
			]
		]
	});
	
	var PanelEditIndex = undefined;
	var statusCopy = 0;
	var vid_cotation = <?php echo $id_cotation; ?>;
	PanelInsertRow = function() {
		
		if (PanelEndEditing()){
			$(dgPanel).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',comp_module:'',comp_name1:'',comp_name2:'',length:0,width:0,raw_length:10,raw_width:10,quantity:0,shape_waste:20,seq_det:'0'}});
			PanelEditIndex = 0;
			$(dgPanel).datagrid('selectRow', PanelEditIndex)
					.datagrid('beginEdit', PanelEditIndex);
			PanelDisableMyEditor(PanelEditIndex);
			panelStatus = 1;
		}
	};

	function PanelDisableMyEditor(index){
		var ed_height = $(dgPanel).datagrid('getEditor',{index:index,field:'height'});
		var ed_raw_height = $(dgPanel).datagrid('getEditor',{index:index,field:'raw_height'});
		
		$(ed_height.target).numberbox('disable');
		$(ed_raw_height.target).numberbox('disable');
	}
	
	function PanelDisableEditor_Duplicate(index){
		var ed_comp_module = $(dgPanel).datagrid('getEditor',{index:index,field:'comp_module'});
		var ed_comp_name1 = $(dgPanel).datagrid('getEditor',{index:index,field:'comp_name1'});
		var ed_comp_name2 = $(dgPanel).datagrid('getEditor',{index:index,field:'comp_name2'});
		var ed_panel_type = $(dgPanel).datagrid('getEditor',{index:index,field:'panel_type'});
		var ed_length = $(dgPanel).datagrid('getEditor',{index:index,field:'length'});
		var ed_width = $(dgPanel).datagrid('getEditor',{index:index,field:'width'});
		var ed_height = $(dgPanel).datagrid('getEditor',{index:index,field:'height'});
		var ed_quantity = $(dgPanel).datagrid('getEditor',{index:index,field:'quantity'});
		var ed_shape_waste = $(dgPanel).datagrid('getEditor',{index:index,field:'shape_waste'});
		var ed_raw_length = $(dgPanel).datagrid('getEditor',{index:index,field:'raw_length'});
		var ed_raw_width = $(dgPanel).datagrid('getEditor',{index:index,field:'raw_width'});
		var ed_raw_height = $(dgPanel).datagrid('getEditor',{index:index,field:'raw_height'});
		
		$(ed_comp_module.target).attr('disabled','true');
		$(ed_comp_name1.target).attr('disabled','true');
		$(ed_comp_name2.target).attr('disabled','true');
		$(ed_panel_type.target).combobox('disable');
		$(ed_length.target).numberbox('disable');
		$(ed_width.target).numberbox('disable');
		$(ed_height.target).numberbox('disable');
		$(ed_quantity.target).numberbox('disable');
		$(ed_shape_waste.target).numberbox('disable');
		$(ed_raw_length.target).numberbox('disable');
		$(ed_raw_width.target).numberbox('disable');
		$(ed_raw_height.target).numberbox('disable');
	
	}
	
	function PanelEndEditing(){
		if (PanelEditIndex == undefined){return true}
		if ($(dgPanel).datagrid('validateRow', PanelEditIndex)){
			var ed_comp_module = $(dgPanel).datagrid('getEditor', {index:PanelEditIndex,field:'comp_module'});
			var ed_comp_name1 = $(dgPanel).datagrid('getEditor', {index:PanelEditIndex,field:'comp_name1'});
			var ed_comp_name2 = $(dgPanel).datagrid('getEditor', {index:PanelEditIndex,field:'comp_name2'});
			var comp_module = $(ed_comp_module.target).val();
			var comp_name1 = $(ed_comp_name1.target).val();
			var comp_name2 = $(ed_comp_name2.target).val();
			
			$(ed_comp_module.target).val(ucFirst(comp_module));
			$(ed_comp_name1.target).val(ucFirst(comp_name1));
			$(ed_comp_name2.target).val(ucFirst(comp_name2)); 
			$(dgPanel).datagrid('endEdit', PanelEditIndex);
			PanelEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function PanelOnClickRow(index){
		if (PanelEditIndex != index){
			
			if (PanelEndEditing()){
				$(dgPanel).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				PanelEditIndex = index;
				var ed_seq_det = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'seq_det'});
				var ed_seq = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'seq'});
				var ed_hidebarang = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'hidebarang'});
				var ed_hidetype_material_a = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'hidetype_material_a'});
				var ed_hidetype_material_b = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'hidetype_material_b'});
				var ed_type_material_a = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'type_material_a'});
				var ed_type_material_b = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'type_material_b'});
				var ed_hidea = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'hidea'});
				var ed_hideb = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'hideb'});
				var ed_panel_type = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'panel_type'});
				var ed_faces_a = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'faces_a'});
				var ed_faces_b = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'faces_b'});
				var ed_statuscopy = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'statuscopy'});
				var ed_type_material_a = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'type_material_a'});
				var ed_type_material_b = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'type_material_b'});
				var seq_det = $(ed_seq_det.target).val();
				var seq = $(ed_seq.target).val();
				var hidebarang= $(ed_hidebarang.target).val();
				var hidetype_material_a = $(ed_hidetype_material_a.target).val();
				var hidetype_material_b = $(ed_hidetype_material_b.target).val();
				var hidea= $(ed_hidea.target).val();
				var hideb= $(ed_hideb.target).val();
				var statuscopy= $(ed_statuscopy.target).val();
				if ((statuscopy!='1' && statuscopy!='') || (seq_det!='' && seq_det=='0')){
					PanelDisableMyEditor(PanelEditIndex);
				} else {
					PanelDisableEditor_Duplicate(index);
				}
				
				$(ed_panel_type.target).combobox('select',hidebarang);
				var faces_a = $(ed_faces_a.target).combobox('getText');
				var faces_b = $(ed_faces_b.target).combobox('getText');
				$(ed_faces_a.target).combobox('select',hidea);
				$(ed_faces_b.target).combobox('select',hideb);
				
				var urls_a = '<?php echo site_url(); ?>/ref_json/DataTypeMaterial/'+faces_a;
				var urls_b = '<?php echo site_url(); ?>/ref_json/DataTypeMaterial/'+faces_b;
				$(ed_type_material_a.target).combobox('reload',urls_a);
				$(ed_type_material_a.target).combobox('select',hidetype_material_a);
				$(ed_type_material_b.target).combobox('reload',urls_b);
				$(ed_type_material_b.target).combobox('select',hidetype_material_b);
				panelStatus = 1;
			} else{
				$(dgPanel).datagrid('selectRow', PanelEditIndex);
			}
			statusCopy = 0;
		}
	}
	
	function PanelRowMenu(e, rowIndex, rowData){
		
		if (PanelEditIndex!=rowIndex){
			if (PanelEndEditing()){
				e.preventDefault();
				$(this).datagrid('unselectAll');
				$(this).datagrid('selectRow', rowIndex);
				
				if (rowData.seq!='' && rowData.seq_det==0 && rowData.seq_det!='' && ((rowData.faces_a!='' && rowData.faces_a_amount!='' && rowData.faces_a_amount!=0) || (rowData.faces_b!='' && rowData.faces_b_amount!=0 && rowData.faces_b_amount!=''))){
					if (!$('#tmenu').length){
						var tmenu = $('<div id="tmenu" style="width:150px;"></div>').appendTo('body');
						$('<div iconCls="icon-copy" />').html('Copy Row Record').appendTo(tmenu); /*
						$('<div />').html('Import').appendTo(tmenu);					
						$('<div />').html('Lock').appendTo(tmenu);					
						$('<div />').html('Unlock').appendTo(tmenu);					
						$('<div />').html('Activate').appendTo(tmenu);
						$('<div />').html('Deactivate').appendTo(tmenu);					
						$('<div />').html('Clear').appendTo(tmenu); */
					}
					else {
						var tmenu = $('#tmenu');
					}
					
					tmenu.menu({
							onClick: function(item){
								// do smth 
								var rows = $(dgPanel).datagrid('getRows');
								var myIndex = Number(rowIndex)+1;
								
								$(dgPanel).datagrid('insertRow',{index:myIndex,row:{id_cotation:rowData.id_cotation,seq:rowData.seq,comp_module:rowData.comp_module,comp_name1:rowData.comp_name1,comp_name2:rowData.comp_name2,faces_a_amount:rowData.faces_a_amount,faces_b_amount:rowData.faces_b_amount,hidebarang:rowData.hidebarang,hidea:rowData.hidea,hideb:rowData.hideb,seq_det:'',area_panel:rowData.area_panel,finished_area_panel:rowData.finished_area_panel,statuscopy:'1'}});
								statusCopy = 1;
								PanelOnClickRow(myIndex); 
							}
						});
					if(rowData.state=='Open'){
						// update menu for record with is 'Open'
					}
					if(rowData.state=='Locked'){
						// update menu for record with is 'Locked'
					}
					if(rowData.state=='Inactive'){
						// update menu for record with is 'Inactive'
					}
					$('#tmenu').menu('show', {
						left:e.pageX,
						top:e.pageY
					});
				}
			}
		}
	}
	
	function PanelRemoveIt(){
		if (PanelEditIndex == undefined){return}
		var ed_seq = $(dgPanel).datagrid("getEditor", {index:PanelEditIndex, field:'seq'});
		var ed_seq_det = $(dgPanel).datagrid("getEditor", {index:PanelEditIndex, field:'seq_det'});
		var ed1 = $(dgPanel).datagrid("getEditor", {index:PanelEditIndex, field:'id_cotation'});
		var seq = $(ed_seq.target).val();
		var seq_det = $(ed_seq_det.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Are you sure to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=panel&seq_det="+seq_det,
						cache	: false,
						success	: function(data){
							$(dgPanel).datagrid('cancelEdit', PanelEditIndex)
								.datagrid('deleteRow', PanelEditIndex);
							$(dgPanel).datagrid('reload');
							PanelEditIndex = undefined;
							panelStatus = 0;
						}
					});
				}
			});
		}else{
			$(dgPanel).datagrid('cancelEdit', PanelEditIndex)
				.datagrid('deleteRow', PanelEditIndex);			
			PanelEditIndex = undefined;
			panelStatus = 0;
		}
		
	}
	
	function PanelGetChanges(){
		PanelEndEditing();
		var rows = $(dgPanel).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&seq_det_'+i+'='+rows[i].seq_det+
								'&comp_module_'+i+'='+rows[i].comp_module+
								'&comp_name1_'+i+'='+rows[i].comp_name1+
								'&comp_name2_'+i+'='+rows[i].comp_name2+
								'&panel_type_'+i+'='+rows[i].panel_type+
								'&length_'+i+'='+rows[i].length+
								'&width_'+i+'='+rows[i].width+
								'&height_'+i+'='+rows[i].height+
								'&quantity_'+i+'='+rows[i].quantity+
								'&shape_waste_'+i+'='+rows[i].shape_waste+
								'&raw_length_'+i+'='+rows[i].raw_length+
								'&raw_width_'+i+'='+rows[i].raw_width+
								'&raw_height_'+i+'='+rows[i].raw_height+
								'&faces_a_'+i+'='+rows[i].faces_a+
								'&faces_a_amount_'+i+'='+rows[i].faces_a_amount+
								'&type_material_a_'+i+'='+rows[i].type_material_a+
								'&faces_a_total_'+i+'='+rows[i].faces_a_total+
								'&faces_b_'+i+'='+rows[i].faces_b+
								'&faces_b_amount_'+i+'='+rows[i].faces_b_amount+
								'&type_material_b_'+i+'='+rows[i].type_material_b+
								'&faces_b_total_'+i+'='+rows[i].faces_b_total+
								'&area_panel_total_'+i+'='+rows[i].area_panel_total+
								'&finished_area_panel_'+i+'='+rows[i].finished_area_panel+
								'&area_panel_'+i+'='+rows[i].area_panel+
								'&raw_cost_'+i+'='+rows[i].raw_cost+
								'&production_cost_'+i+'='+rows[i].production_cost;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_panel",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgPanel).datagrid('reload');
				panelStatus =0;
			}
		});
		
	}
	
	function PanelReject(){
		$(dgPanel).datagrid('rejectChanges');
		PanelEditIndex = undefined;
		$(dgPanel).datagrid('reload');
		panelStatus = 0;
	}
	
	function PanelPrint(){
			window.open('<?php echo site_url();?>/cotation/print_panel/<?php echo $id_cotation; ?>');
			//return false();
	}
	
	function PanelAreaRaw(){ 
		var ed_width = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'raw_width'}); 
		var ed_ori_width = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'width'}); 
		var ed_length = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'raw_length'});
		var ed_ori_length = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'length'});
		var ed_area_panel_total = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'area_panel_total'});
		var ed_area_panel = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'area_panel'});
		var ed_finished_area = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'finished_area_panel'});
		var ed_shape_waste = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'shape_waste'});
		var ed_quantity = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'quantity'});
		
		var area_n_waste = Number($(ed_width.target).numberbox('getValue')) * Number($(ed_length.target).numberbox('getValue')) * Number($(ed_quantity.target).numberbox('getValue')) * (1 + (Number($(ed_shape_waste.target).numberbox('getValue')) / 100));
		var area = Number($(ed_width.target).numberbox('getValue')) * Number($(ed_length.target).numberbox('getValue')) * Number($(ed_quantity.target).numberbox('getValue'));
		var area_ori = Number($(ed_ori_width.target).numberbox('getValue')) * Number($(ed_ori_length.target).numberbox('getValue')) * Number($(ed_quantity.target).numberbox('getValue'));
		$(ed_area_panel_total.target).numberbox('setValue',area_n_waste);
		$(ed_area_panel.target).numberbox('setValue',area);  
		$(ed_finished_area.target).numberbox('setValue',area_ori);  
	}
	
	function PanelFaceArea(facesA,facesB,faces){ 
		var ed_A = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:facesA});
		var ed_B = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:facesB});
		var ed_face = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:faces});
		var ed_face_amount = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:faces+'_amount'});
		var ed_face_total = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:faces+'_total'});
		var ed_quantity = $(dgPanel).datagrid("getEditor",{index:PanelEditIndex,field:'quantity'});
		
		var quantity = $(ed_quantity.target).numberbox('getValue');
		var amount = $(ed_face_amount.target).numberbox('getValue');
		var face = $(ed_face.target).combobox('getValue');
		var A = $(ed_A.target).numberbox('getValue');
		var B = $(ed_B.target).numberbox('getValue');
		var total = 0;
		
		if (face!='' && amount!='')
			total = A*B*quantity*(amount*0.01);
		
		$(ed_face_total.target).numberbox('setValue',total); 
	}
	
	function panelChangeSizeFinished(size){ 
		var ed_size_raw = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'raw_'+size});
		var ed_size_finished = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:size});
		
		var size_finished = $(ed_size_finished.target).numberbox('getValue');
		var addValue=0;
		if (size=='length' || size=='width'){
			addValue=10;
		}
		
		size_finished = Number(size_finished) + addValue;
		$(ed_size_raw.target).numberbox('setValue',size_finished); 
		PanelAreaRaw();
		//PanelProductCost();
		
		switch (size){
			case 'length':
			case 'width':
				PanelFaceArea('length','width','faces_a');
				PanelFaceArea('length','width','faces_b');
				break;
		}
		
	}
	
	function PanelRecountDetail(area){
		var rows = $(dgPanel).datagrid('getRows');
		var ed_seq = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'seq'});
		var seq = $(ed_seq.target).val();
		var total_a = 0;
		var total_b = 0;
		for (i=0;i<rows.length;i++){
			if (rows[i].seq==seq && (rows[i].seq_det!=0 || rows[i].seq_det=='')){
				$(dgPanel).datagrid('updateRow',{index:i,row:{finished_area_panel:area}});
				if (rows[i].faces_a!='' && rows[i].faces_a_amount!='' && rows[i].faces_a_amount!=0){
					total_a = Number(area) * Number(rows[i].faces_a_amount/100);
					$(dgPanel).datagrid('updateRow',{index:i,row:{faces_a_total:total_a}});
				}
				if (rows[i].faces_b!='' && rows[i].faces_b_amount!='' && rows[i].faces_b_amount!=0){
					total_b = Number(area) * Number(rows[i].faces_b_amount/100);
					$(dgPanel).datagrid('updateRow',{index:i,row:{faces_b_total:total_b}});
				}
			}
		}
		
		
	}
	
	function PanelCost(currency,price,rates,length,width,length_unit){
		var per_mm2 = 0;
		var mm2 =0;
		
		var ed_raw_cost = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'raw_cost'});
		if (currency!='Rp'){
			price = Number(price) * Number(rates);
		} else {
		  price = Number(price);
		}
		
		mm2 = Number(length)*Number(width);
		
		if (length_unit=='m'){
			mm2 = mm2 * 1000000;
		} else if (length_unit=='cm'){
			mm2 = mm2 * 100;
		}
		
		per_mm2 = price / mm2;
		
		$(ed_raw_cost.target).numberbox('setValue',per_mm2);
		PanelProductCost();
	}
	
	function PanelProductCost(){
		var ed_production_cost	= $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'production_cost'});
		var ed_raw_cost = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'raw_cost'});
		var ed_area_panel_total = $(dgPanel).datagrid('getEditor',{index:PanelEditIndex,field:'area_panel_total'});
		var Cost = 0;
		
		var raw_cost = $(ed_raw_cost.target).numberbox('getValue');
		var area_panel_total = $(ed_area_panel_total.target).numberbox('getValue');
		
		Cost = Number(raw_cost) * Number(area_panel_total);
		
		$(ed_production_cost.target).numberbox('setValue',Cost);
	}
	