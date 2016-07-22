	var dgPacking = '#dgPacking';
	var PackingStatus = 0;
	var PackingEditIndex = undefined;

	$(dgPacking).datagrid({
		title: "Packing Cotation",
	//	width: 880,
		height: 300,
		rownumbers:true,
		singleSelect:true,
		collapsible:true,
		onClickRow: PackingOnClickRow,
		showFooter:true,
		//onLoadSuccess: onLoadSuccess,
		//onRowContextMenu:AccessoriesRowMenu,
		url:"<?php echo site_url(); ?>/cotation/DataPacking/<?php echo $id_cotation; ?>",
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			handler: function(){PackingInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			handler: function(){PackingRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			handler: function(){PackingGetChanges();}
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			handler: function(){PackingReject();} /*
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){PackingPrint();} */
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
					title:'Box',
					field:'boxnumber',
					rowspan:2,
					width:90,
					align:'center',
					editor: {
						type:'combobox',
						options:{
							textField:'label',
							valueField:'value',
							required: true,
							data:[{label:'BOX 1',value:'BOX 1'},{label:'BOX 2',value:'BOX 2'},{label:'BOX 3',value:'BOX 3'}],
							onChange: function(value){
								if (PackingStatus==1){
									var ed_lshape = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'lshape'});
									var ed_asize = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'asize'});
									var ed_bsize = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'bsize'});
									//var ed_astyrofoam = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'astyrofoam'});
									//var ed_bstyrofoam = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'bstyrofoam'});
									
									if (value=='BOX 1'){
										$(ed_lshape.target).combobox('setValue','');
										$(ed_lshape.target).combobox('enable');
										$(ed_asize.target).attr('disabled',false);
										$(ed_bsize.target).attr('disabled',false);
										//$(ed_astyrofoam.target).attr('disabled',false);
										//$(ed_bstyrofoam.target).attr('disabled',false);
									} else{
										$(ed_lshape.target).combobox('setValue','NO');
										$(ed_lshape.target).combobox('disable');
										$(ed_asize.target).attr('disabled',true);
										$(ed_bsize.target).attr('disabled',true);
										//$(ed_astyrofoam.target).attr('disabled',true);
										//$(ed_bstyrofoam.target).attr('disabled',true);
									}
								}
							}
						}
					}
				},{
					title: 'For<br>Customer',
					field:'customer',
					rowspan:2,
					align:'center',
					width:150,
					editor:{
						type:'combobox',
						options:{
							textField:'cust_name',
							valueField:'cust_code',
							url: "<?php echo site_url(); ?>/ref_json/ComboboxCustomerPacking"
						}
					}
				},{
					title:'L<br>Shape ?',
					field:'lshape',
					rowspan:2,
					width:90,
					align:'center',
					editor:{
						type:'combobox',
						options: {
							textField:'label',
							valueField:'value',
							required:true,
							data:[{label:'YES', value:'YES'},{label:'NO',value:'NO'}],
							onChange: function(value){
								//alert('A');
								if (PackingStatus==1){
									var ed_asize = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'asize'});
									var ed_bsize = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'bsize'});
									//var ed_astyrofoam = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'astyrofoam'});
									//var ed_bstyrofoam = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'bstyrofoam'});
									var ed_remarks = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'boxremarks'});
									var ed_kdown = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'kdown'});
									var ed_typebox = $(dgPacking).datagrid("getEditor",{index:PackingEditIndex, field:'typebox'});
									var ed_lkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lkarton'});
									var ed_wkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wkarton'});
									var ed_hkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hkarton'});
									
									//$(ed_typebox.target).combobox('reload');
									
									if (value=='YES'){
										$(ed_typebox.target).combobox({onBeforeLoad:function(param){
											param.lshape = 'YES';
										}});
										$(ed_typebox.target).combobox('setValue','L Shape');
										$(ed_typebox.target).combobox('disable');
										$(ed_kdown.target).attr('disabled', true);
										$(ed_asize.target).attr('disabled',false);
										$(ed_bsize.target).attr('disabled',false);
										//$(ed_astyrofoam.target).attr('disabled',false);
										//$(ed_bstyrofoam.target).attr('disabled',false);
										$(ed_lkarton.target).numberbox('setValue',15);
										$(ed_wkarton.target).numberbox('setValue',15);
										$(ed_hkarton.target).numberbox('setValue',30);
										$(ed_remarks.target).val('L Shape');
										
									} else {
										$(ed_typebox.target).combobox('setValue','');
										$(ed_typebox.target).combobox('enable');
										$(ed_kdown.target).attr('disabled',false);
										$(ed_asize.target).attr('disabled',true);
										$(ed_bsize.target).attr('disabled',true);
										//$(ed_astyrofoam.target).attr('disabled',true);
										//$(ed_bstyrofoam.target).attr('disabled',true);
										$(ed_remarks.target).val('');
									}
								}
							}
						}
					}
				},{
					title:'Size Product Before Packing (mm)',
					colspan:3
				},{
					title:'Knock<br>Down ?',
					field:'kdown',
					rowspan:2,
					width:90,
					align:'center',
					editor:{
						type:'checkbox',
						options : {
							on : 'KD',
							off: 'NO'
						}
					}
				},{
					title:'Type',
					field:'typebox',
					rowspan:2,
					width:70,
					align:'center',
					editor: {
						type:'combobox',
						options: {
							textField:'label',
							valueField:'value',
							required: true,
							//data:[{label:'TB',value:'TB'},{label:'A1',value:'A1'},{label:'A3',value:'A3'},{label:'L Shape',value:'L Shape'}],
							url:"<?php echo site_url(); ?>/ref_json/ComboboxTypebox",/*
							onBeforeLoad: function (param){
								var ed_lshape = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lshape'});
								var lshape = $(ed_lshape.target).combobox('getValue');
								param.lshape = lshape;
							},*/
							onSelect: function(rows){
								if(PackingStatus==1){
									var ed_lkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lkarton'});
									var ed_wkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wkarton'});
									var ed_hkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hkarton'});
									//var ed_akarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'akarton'});
									//var ed_bkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bkarton'});
									//var ed_lshape  = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lshape'});
									//var lshape = $(ed_lshape.target).combobox('getValue');
									
									if (rows.value=='TB'){
										$(ed_lkarton.target).numberbox('setValue',30);
										$(ed_wkarton.target).numberbox('setValue',30);
										$(ed_hkarton.target).numberbox('setValue',15);
									}else {
										$(ed_lkarton.target).numberbox('setValue',15);
										$(ed_wkarton.target).numberbox('setValue',15);
										$(ed_hkarton.target).numberbox('setValue',30);
										//if (lshape=='YES'){
											//$(ed_akarton.target).numberbox('setValue',3);
											//$(ed_bkarton.target).numberbox('setValue',1.5);
										//}
									}
								}
							}
						}
					}
				},{
					title:'Packing <br>Remarks',
					field:'packingremarks',
					rowspan:2,
					width:150,
					align:'center',
					editor:{
						type:'validatebox'
					}
				},{
					title:'Styrofoam',
					colspan:3
				},{
					title:'Inner Size (mm)',
					colspan:5
				},{
					title:'Tambah Tebal Karton Box',
					colspan:3
				},{
					title:'Outer Size (mm)',
					colspan:3
				},{
					title:'Vol. Box<br>Outer (m3)',
					field:'volouter',
					rowspan:2,
					width:100,
					align:'center',
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:3
						}
					}
				},{
					title:'Box<br>Weight (Kg)',
					field:'boxweight',
					rowspan:2,
					width:80,
					align:'center',/*
					formatter:function(value,row,index){
						var whole = 0;
						var fraction = 0.0;
						var newVal='';
						
						if (value==0){
							return '';
						} else {
							whole = Math.floor(value);
							fraction = value - whole;
							fraction_char = fraction+'';
							if (fraction > 0){
								if (fraction_char.substring(3,4)=='0'){
									newVal = whole+'.'+fraction_char.substring(2,3);
								}else{
									newVal = value;
								}
								return newVal;
							} else {
								return whole;
							}
						}
					},*/
					editor:{
						type:'numberbox',
						options:{
							precision:2
						}
					}
				},{
					title:'Box<br>Remarks',
					field:'boxremarks',
					rowspan:2,
					width:150,
					align:'center',
					editor:{
						type:'validatebox'
					}
				},{
					title:'Qty Box',
					field:'qtybox',
					rowspan:2,
					width:70,
					align:'center',
					editor:{
						type:'numberbox',
						options:{
							min:1
						}
					}
				},{
					title:'Product / <br> Box',
					field:'qtyperbox',
					rowspan:2,
					width:70,
					align:'center',
					editor:{
						type:'numberbox',
						options:{
							min:1
						}
					}
				}
			],[
				{
					title:'L',
					field:'lsize',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							precision:1,
							onChange: function(newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_lstyrofoam = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lstyrofoam'});
									var ed_linner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'linner'});
									var lstyrofoam = $(ed_lstyrofoam.target).numberbox('getValue');
									if (lstyrofoam=='' || lstyrofoam==null){
										lstyrofoam=0;
									}
									$(ed_linner.target).numberbox('setValue',Number(newValue)+Number(lstyrofoam));
								}
							}
						}
					}
				},{
					title:'W',
					field:'wsize',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							precision:1,
							onChange: function(newValue, oldValue){
									if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
										var ed_wstyrofoam = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wstyrofoam'});
										var ed_winner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'winner'});
										var wstyrofoam = $(ed_wstyrofoam.target).numberbox('getValue');
										if (wstyrofoam==''){
											wstyrofoam=0;
										}
										$(ed_winner.target).numberbox('setValue',Number(newValue)+Number(wstyrofoam));
									}
							}
						}
					}
				},{
					title:'H',
					field:'hsize',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							precision:1,
							onChange: function(newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_hstyrofoam = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hstyrofoam'});
									var ed_hinner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hinner'});
									var hstyrofoam = $(ed_hstyrofoam.target).numberbox('getValue');
									if (hstyrofoam==''){
										hstyrofoam=0;
									}
									$(ed_hinner.target).numberbox('setValue',Number(newValue)+Number(hstyrofoam));
								}
							}
						}
					}
				},{
					title:'L',
					field:'lstyrofoam',
					width:70,
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
					editor:{
						type:"numberbox",
						options: {
							onChange: function(newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_lsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lsize'});
									var ed_linner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'linner'});
									var lsize = $(ed_lsize.target).numberbox('getValue');
									if (lsize==''){
										lsize = 0;
									}
									$(ed_linner.target).numberbox('setValue',Number(newValue)+Number(lsize));
								}
							}
						}
					}
				},{
					title:'W',
					field:'wstyrofoam',
					width:70,
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
					editor:{
						type:'numberbox',
						options: {
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_wsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wsize'});
									var ed_winner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'winner'});
									var wsize = $(ed_wsize.target).numberbox('getValue');
									if(wsize==''){
										lsize=0;
									}
									$(ed_winner.target).numberbox('setValue',Number(newValue)+Number(wsize));
								}
							}
						}
					}
				},{
					title:'H',
					field:'hstyrofoam',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_hsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hsize'});
									var ed_hinner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hinner'});
									var hsize = $(ed_hsize.target).numberbox('getValue');
									if(hsize==''){
										hsize=0;
									}
									$(ed_hinner.target).numberbox('setValue',Number(newValue)+Number(hsize));
								}
							}
						}
					} /*
				},{
					title:'a',
					field:'astyrofoam',
					width:70,
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
					editor: {
						type:'numberbox',
						options:{
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
									var ed_ainner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'ainner'});
									var asize = $(ed_asize.target).numberbox('getValue');
									if (asize==''){
										asize=0;
									}
									$(ed_ainner.target).numberbox('setValue',Number(newValue)+Number(asize));
								}
							}
						}
					}
				},{
					title:'b',
					field:'bstyrofoam',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							onChange: function (newValue, oldValue){
								var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
								var ed_binner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'binner'});
								var bsize = $(ed_bsize.target).numberbox('getValue');
								if (bsize==''){
									bsize=0;
								}
								$(ed_binner.target).numberbox('setValue',Number(newValue)+Number(bsize));
							}
						}
					} */
				},{
					title:'L',
					field:'linner',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_lkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lkarton'});
									var lkarton = $(ed_lkarton.target).numberbox('getValue');
									if (lkarton==''){
										lkarton=0;
									}
									$(ed_louter.target).numberbox('setValue',Number(newValue)+Number(lkarton));
								}
							}
						}
					}
				},{
					title:'W',
					field:'winner',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_wkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wkarton'});
									var wkarton = $(ed_wkarton.target).numberbox('getValue');
									if (wkarton==''){
										wkarton=0;
									}
									$(ed_wouter.target).numberbox('setValue',Number(newValue)+Number(wkarton));
								}
							}
						}
					}
				},{
					title:'H',
					field:'hinner',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var ed_hkarton = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hkarton'});
									var hkarton = $(ed_hkarton.target).numberbox('getValue');
									if (hkarton==''){
										hkarton=0;
									}
									$(ed_houter.target).numberbox('setValue',Number(newValue)+Number(hkarton));
								}
							}
						}
					}/*
				},{
					title:'a',
					field:'ainner',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
						}
					}
				},{
					title:'b',
					field:'binner',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
						}
					} */
				},{
					title:'L vertical',
					field:'asize',
					width:70,
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
					editor: {
						type:'numberbox',
						options:{
							precision:1,
							onChange: function(newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_volouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'volouter'});
									var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var bsize = $(ed_bsize.target).numberbox('getValue');
									var louter = $(ed_louter.target).numberbox('getValue');
									var wouter = $(ed_wouter.target).numberbox('getValue');
									var houter = $(ed_houter.target).numberbox('getValue');
									
									if (bsize==''){
										bsize=0;
									}
									
									if (louter==''){
										louter=0;
									}
									
									if (wouter==''){
										wouter=0;
									}
									
									if (houter==''){
										houter=0;
									}
									
									$(ed_volouter.target).numberbox('setValue',((Number(wouter)*Number(houter))-(Number(newValue)*Number(bsize)))*Number(louter)/1000000000);
								}
							}
						}
					}
				},{
					title:'L horizontal',
					field:'bsize',
					width:70,
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
					editor: {
						type:'numberbox',
						options:{
							precision:1,
							onChange: function(newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_volouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'volouter'});
									var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var asize = $(ed_asize.target).numberbox('getValue');
									var louter = $(ed_louter.target).numberbox('getValue');
									var wouter = $(ed_wouter.target).numberbox('getValue');
									var houter = $(ed_houter.target).numberbox('getValue');
									
									if (asize==''){
										asize=0;
									}
									
									if (louter==''){
										louter=0;
									}
									
									if (wouter==''){
										wouter=0;
									}
									
									if (houter==''){
										houter=0;
									}
									
									$(ed_volouter.target).numberbox('setValue',((Number(wouter)*Number(houter))-(Number(newValue)*Number(asize)))*Number(louter)/1000000000);
								}
							}
						}
					}
				},{
					title:'L',
					field:'lkarton',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_linner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'linner'});
									var linner = $(ed_linner.target).numberbox('getValue');
									if (linner==''){
										linner=0;
									}
									$(ed_louter.target).numberbox('setValue',Number(newValue)+Number(linner));
								}
							}
						}
					}
				},{
					title:'W',
					field:'wkarton',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange: function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_winner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'winner'});
									var winner = $(ed_winner.target).numberbox('getValue');
									if (winner==''){
										winner=0;
									}
									$(ed_wouter.target).numberbox('setValue',Number(newValue)+Number(winner));
								}
							}
						}
					}
				},{
					title:'H',
					field:'hkarton',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var ed_hinner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hinner'});
									var hinner = $(ed_hinner.target).numberbox('getValue');
									if (hinner==''){
										hinner=0;
									}
									$(ed_houter.target).numberbox('setValue',Number(newValue)+Number(hinner));
								}
							}
						}
					}/*
				},{
					title:'a',
					field:'akarton',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_aouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'aouter'});
									var ed_ainner = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'ainner'});
									var ainner = $(ed_ainner.target).numberbox('getValue');
									if (ainner==''){
										ainner=0;
									}
								}
							}
						}
					}
				},{
					title:'b',
					field:'bkarton',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
						}
					} */
				},{
					title:'L',
					field:'louter',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_volouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'volouter'});
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
									var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
									var wouter = $(ed_wouter.target).numberbox('getValue');
									var houter = $(ed_houter.target).numberbox('getValue');
									var asize = $(ed_asize.target).numberbox('getValue');
									var bsize = $(ed_bsize.target).numberbox('getValue');
									
									if (wouter==''){
										wouter=0;
									}
									
									if (houter==''){
										houter=0;
									}
									
									if (asize==''){
										asize=0;
									}
									
									if (bsize==''){
										bsize=0;
									}
									
									$(ed_volouter.target).numberbox('setValue',((Number(wouter)*Number(houter))-(Number(asize)*Number(bsize)))*Number(newValue)/1000000000);
								}
							}
						}
					}
				},{
					title:'W',
					field:'wouter',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_volouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'volouter'});
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_houter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'houter'});
									var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
									var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
									var louter = $(ed_louter.target).numberbox('getValue');
									var houter = $(ed_houter.target).numberbox('getValue');
									var asize = $(ed_asize.target).numberbox('getValue');
									var bsize = $(ed_bsize.target).numberbox('getValue');
									
									if (louter==''){
										louter=0;
									}
									
									if (houter==''){
										houter=0;
									}
									
									if (asize==''){
										asize=0;
									}
									
									if (bsize==''){
										bsize=0;
									}
									
									$(ed_volouter.target).numberbox('setValue',((Number(newValue)*Number(houter))-(Number(asize)*Number(bsize)))*Number(louter)/1000000000);
								}
							}
						}
					}
				},{
					title:'H',
					field:'houter',
					width:70,
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
					editor:{
						type:'numberbox',
						options:{
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
								if (newValue!=oldValue && newValue!='' && newValue!=0 && PackingStatus==1){
									var ed_volouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'volouter'});
									var ed_louter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'louter'});
									var ed_wouter = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'wouter'});
									var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
									var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
									var louter = $(ed_louter.target).numberbox('getValue');
									var wouter = $(ed_wouter.target).numberbox('getValue');
									var asize = $(ed_asize.target).numberbox('getValue');
									var bsize = $(ed_bsize.target).numberbox('getValue');
									
									if (louter==''){
										louter=0;
									}
									
									if(wouter==''){
										wouter=0;
									}
									
									if (asize==''){
										asize=0;
									}
									
									if (bsize==''){
										bsize=0;
									}
									
									$(ed_volouter.target).numberbox('setValue',((Number(newValue)*Number(wouter))-(Number(asize)*Number(bsize)))*Number(louter)/1000000000);
								}
							}
						}
					} /*
				},{
					title:'a',
					field:'aouter',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
							onChange : function (newValue, oldValue){
							}
						}
					}
				},{
					title:'b',
					field:'bouter',
					width:70,
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
					editor: {
						type:'numberbox',
						options: {
							disabled:true,
							precision:1,
						}
					} */
				}
			]
		]
	});
	
	var vid_cotation = <?php echo $id_cotation; ?>;
	
	PackingInsertRow = function() {
		if (PackingEndEditing()){
			$(dgPacking).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',quantity:0,lsize:Number(cm_length*10),wsize:Number(cm_width*10),hsize:Number(cm_height*10)}});
			PackingEditIndex = 0;
			$(dgPacking).datagrid('selectRow', PackingEditIndex)
					.datagrid('beginEdit', PackingEditIndex);
			//var ed_currency = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'currency'});
			//$(ed_currency.target).attr('disabled','true');
			PackingStatus = 1;
		}
	};
	
	
	
	function PackingEndEditing(){
		PackingStatus=0;
		if (PackingEditIndex == undefined){return true}
		if ($(dgPacking).datagrid('validateRow', PackingEditIndex)){
			$(dgPacking).datagrid('endEdit', PackingEditIndex);
			PackingEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function onLoadSuccess(data){
		$(dgPacking).datagrid('mergeCells', {
			type: 'footer',
			index: 1,
			field: 'boxnumber',
			colspan: 2,
		});
	}
	
	function PackingOnClickRow(index){
		if (PackingEditIndex != index){
			
			if (PackingEndEditing()){
				$(dgPacking).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				PackingEditIndex = index;
				
				var ed_seq = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'seq'});
				var ed_box = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'boxnumber'});
				var ed_customer = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'customer'});
				var ed_lshape = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'lshape'});
				var ed_asize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'asize'});
				var ed_bsize = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'bsize'});
				var ed_kdown = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'kdown'});
				var ed_typebox = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'typebox'});
				//var ed_hidebarang = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hidebarang'});
				//var ed_packing_type = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'hardware'});
				//var ed_currency = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex,field:'currency'});
				//var ed_lshape = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex, field:'lshape'});
				var ed_packingremarks = $(dgPacking).datagrid('getEditor',{index:PackingEditIndex, field:'packingremarks'});

				var seq = $(ed_seq.target).val();
				var box = $(ed_box.target).combobox('getValue');
				var lshape = $(ed_lshape.target).combobox('getValue');
				var customer = $(ed_customer.target).combobox('getValue');
				var typebox = $(ed_typebox.target).combobox('getValue');
				$(ed_typebox.target).combobox({onBeforeLoad:function(param){
											param.lshape = lshape;
										}});
				$(ed_typebox.target).combobox('setValue',typebox);
				if (box!='BOX 1'){
					//$(ed_lshape.target).combobox('setValue','NO');
					if (lshape==''){
						$(ed_lshape.target).combobox('setValue','NO');
					}
					
					$(ed_asize.target).attr('disabled',true);
					$(ed_bsize.target).attr('disabled',true);
					$(ed_kdown.target).attr('disabled',true);
					$(ed_typebox.target).combobox('enable');
						
					$(ed_lshape.target).combobox('disable');
				} else {
					$(ed_lshape.target).combobox('enable');
					//$(ed_packingremarks.target).validatebox('enable');
					$(ed_packingremarks.target).attr('disabled',false);
					if (lshape=='YES'){
						$(ed_asize.target).attr('disabled',false);
						$(ed_bsize.target).attr('disabled',false);
						$(ed_kdown.target).attr('disabled',true);
						$(ed_typebox.target).combobox('disable');
					} else {
						$(ed_asize.target).attr('disabled',true);
						$(ed_bsize.target).attr('disabled',true);
						$(ed_kdown.target).attr('disabled',true);
						$(ed_typebox.target).combobox('enable');
					}
				}
				//var lshape = $(ed_lshape.target).combobox('getValue');
				//var hidebarang= $(ed_hidebarang.target).val();
				
				//$(ed_currency.target).attr('disabled','true');
				//$(ed_packing_type.target).combobox('select',hidebarang);
				//if (lshape==''){
				//	$(ed_lshape.target).combobox('setValue','NO');
				//}
				
				PackingStatus = 1;
			} else{
				$(dgPacking).datagrid('selectRow', PackingEditIndex);
			}
		}
	}
	
	function PackingRemoveIt(){
		if (PackingEditIndex == undefined){return}
		var ed_seq = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'seq'});
		var ed1 = $(dgPacking).datagrid("getEditor", {index:PackingEditIndex, field:'id_cotation'});
		var seq = $(ed_seq.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Are you sure to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=packing",
						cache	: false,
						success	: function(data){
							$(dgPacking).datagrid('cancelEdit', PackingEditIndex)
								.datagrid('deleteRow', PackingEditIndex);
							$(dgPacking).datagrid('reload');
							PackingEditIndex = undefined;
							PackingStatus = 0;
						}
					});
				}
			});
		}else{
			$(dgPacking).datagrid('cancelEdit', PackingEditIndex)
				.datagrid('deleteRow', PackingEditIndex);			
			PackingEditIndex = undefined;
			PackingStatus = 0;
		}
		
	}
	
	function PackingGetChanges(){
		PackingEndEditing();
		var rows = $(dgPacking).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&boxnumber_'+i+'='+rows[i].boxnumber+
								'&customer_'+i+'='+rows[i].customer+
								'&lshape_'+i+'='+rows[i].lshape+
								'&lsize_'+i+'='+rows[i].lsize+
								'&wsize_'+i+'='+rows[i].wsize+
								'&hsize_'+i+'='+rows[i].hsize+
								'&asize_'+i+'='+rows[i].asize+
								'&bsize_'+i+'='+rows[i].bsize+
								'&kdown_'+i+'='+rows[i].kdown+
								'&typebox_'+i+'='+rows[i].typebox+
								'&lstyrofoam_'+i+'='+rows[i].lstyrofoam+
								'&wstyrofoam_'+i+'='+rows[i].wstyrofoam+
								'&hstyrofoam_'+i+'='+rows[i].hstyrofoam+
								'&linner_'+i+'='+rows[i].linner+
								'&winner_'+i+'='+rows[i].winner+
								'&hinner_'+i+'='+rows[i].hinner+
								'&lkarton_'+i+'='+rows[i].lkarton+
								'&wkarton_'+i+'='+rows[i].wkarton+
								'&hkarton_'+i+'='+rows[i].hkarton+
								'&louter_'+i+'='+rows[i].louter+
								'&wouter_'+i+'='+rows[i].wouter+
								'&houter_'+i+'='+rows[i].houter+
								'&volouter_'+i+'='+rows[i].volouter+
								'&boxweight_'+i+'='+rows[i].boxweight+
								'&qtybox_'+i+'='+rows[i].qtybox+
								'&qtyperbox_'+i+'='+rows[i].qtyperbox+
								'&boxremarks_'+i+'='+rows[i].boxremarks+
								'&packingremarks_'+i+'='+rows[i].packingremarks;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_packing",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgPacking).datagrid('reload');
				PackingStatus =0;
			}
		});
		
	}
	
	function PackingReject(){
		$(dgPacking).datagrid('rejectChanges');
		PackingEditIndex = undefined;
		$(dgPacking).datagrid('reload');
		PackingStatus = 0;
	}
	
	function PackingPrint(){
			window.open('<?php echo site_url();?>/cotation/print_packing/<?php echo $id_cotation; ?>');
			//return false();
	}
	
	