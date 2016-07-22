		var myload =0;
		var dgUpholdstery = '#dgUpholdstery';
		var dgUpholdsteryDetail = '#dgUpholdsteryDetail';
		var editIndex = undefined;
		
		function ukuranBarang(index, kode){
			var ed_realsize_unit = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'real_size_unit'});
			var ed_realsize_length = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'real_size_length'});
			var ed_realsize_width = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'real_size_width'});
			var ed_realsize_height = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'real_size_height'});
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/cotation/ukuranBarang",
				data	: "kode="+kode+"&type=fabric",
				dataType: 'json',
				cache	: false, 
				success	: function(data){
					var $response=$(data);
					//alert($response[0]['length_unit']);
					$(ed_realsize_unit.target).val($response[0]['length_unit']);
					$(ed_realsize_length.target).val($response[0]['size_length']);
					$(ed_realsize_width.target).val($response[0]['size_width']);
					$(ed_realsize_height.target).val($response[0]['size_height']);
						//$(ed_harga.target).numberbox('setValue',$response[0]['harga']);
						//$(ed_lengthunit.target).val($response[0]['length_unit']);
					//$hasil = $(data);
					//hasil = $response.slice(0);
					//return $response;
				}
			});
			//alert(length_unit);
			//return length_unit;
		}
		
		function hargaUpholstery(index, kode_barang){
			//var ed = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'kode_barang'});
			var ed_currency = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'currency'});
			var ed_harga = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'brg_harga'});
			var ed_mat_waste = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'mat_waste'});
			var kode = kode_barang;
			var currency=0;
			var harga=0;
			
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/cotation/harga_cotation",
				data	: "kode="+kode+"&type=upholstery",
				dataType: 'json',
				cache	: false, 
				success	: function(data){
					var $response=$(data);
						$(ed_currency.target).val($response[0]['currency']);
						$(ed_harga.target).numberbox('setValue',$response[0]['harga']);
						$(ed_mat_waste.target).numberbox('setValue',$response[0]['mat_waste']);
				
				}
			});
			
			//return currency+','+harga;
		}
		//$('#wood').tabs('hideHeader');
		//$('#cotation').tabs('disableTab',2);
		//$('#cotation').tabs('disableTab','wood');
		//$('#cotation div wood').attr('disableTab',index);
		
		function ucFirst(string) {
			return string.substring(0, 1).toUpperCase() + string.substring(1).toLowerCase();
		}
		/*
		function insertSum(){
		  if (myload==1){
			//var mydata = $(dgUpholdstery).datagrid("getData");
			var mydatafoot = $(dgUpholdstery).datagrid("getFooterRows");
			var mydatasum = $(dgUpholdsteryDetail).datagrid("getData");
			//var datafooter = mydata['footer'];
			for (k=1;k<mydatasum.length;k++){
			  var index = $(dgUpholdsteryDetail).datagrid('getRowIndex',rows[k].kode_barang);
				$(dgUpholdsteryDetail).datagrid('deleteRow',index);
			}
			for (i=0;i<2;i++){
				//for (j=0;j<mydatasum.length;j++){
				//	if (mydatasum['kode_barang']!)
					$(dgUpholdsteryDetail).datagrid("appendRow",{kode_barang:mydatafoot[i]['kode_barang'],sqf25:mydatafoot[i]['sqf25'],sqf28:mydatafoot[i]['sqf28'],sqf3048:mydatafoot[i]['sqf3048'],runningmeter140:mydatafoot[i]['runningmeter140'],runningmeter150:mydatafoot[i]['runningmeter150'],runningmeter160:mydatafoot[i]['runningmeter160'],runningmeter047:mydatafoot[i]['runningmeter047'],runningmeter050:mydatafoot[i]['runningmeter050'],runningmeter057:mydatafoot[i]['runningmeter057'],kilo:mydatafoot[i]['kilo'],pieces:mydatafoot[i]['pieces']});
				//}
			}}
		} */
		
		/* Data Grid */
		$(dgUpholdstery).datagrid({
        title: "Component Cotation",
        width: 1020,
        height: 350,
				rownumbers:true,
				singleSelect:false,
				nowrap:false,
				selectOnCheck: false,
				checkOnSelect: false,
				collapsible:true,
				style:'padding:1px;',
				url:"<?php echo site_url(); ?>/cotation/DataDetail/<?php echo $id_cotation; ?>",
				onClickRow: onClickRow,
				/*
				onBeforeLoad :function (data){
					myload = 0;
				}, */
				/*
				onLoadSuccess: function (data) {
					var panel = $(this).datagrid("getPanel");
					//var mydata = $(this).datagrid("getData");
					var headerCol = panel.find("div.datagrid-view2 > div.datagrid-header tr:first > td[field='mat_waste']");
					//var myheaderCol = panel.find("div.datagrid-header td[field='quantity'] > div.datagrid-cell");
					var myheaderCol = panel.find("div.datagrid-header td[field='quantity']");
					var myheaderCol1 = panel.find("div.datagrid-header td[field='comp_waste']");
					//var myheaderCol2 = panel.find("div.datagrid-header td[field='pieces']");
					var myfooter = panel.find("div.datagrid-footer");
					var exist='';
					
				//	var myheaderCol1 = panel.find("div.datagrid-header td[field='quantity']");
					//var child = myheaderCol.children();
					//child.css('border-right','2px');
					//headerCol.css = 'border-right:2px solid #000;';
					//headerCol.add.css('border-top','12px');
					myheaderCol.css("border-right","2px dotted #fece2f");
					myheaderCol1.css("border-right","2px dotted #fece2f");
					//myheaderCol2.css("border-right","2px dotted #fece2f");
					myfooter.height('auto');
					//panel.panel().attr("collapsed",false);
					//myfooter.background(true);
					//var datafooter = mydata['footer'];
					
					//for (i=0;i<datafooter.length;i++){
					  //var kode_barang = datafooter[i]['kode_barang'];
					  //if (exist.indexOf(kode_barang)==-1){
						//	$(dgUpholdsteryDetail).datagrid("appendRow",{kode_barang:datafooter[0]['kode_barang'],sqf25:datafooter[0]['sqf25']});
							//exist = exist + ' ' + kode_barang;
						//}
						
					//}
					//myheaderCol.css("height","30px");
					//myheaderCol.css("vertical-align","middle");
					//myheaderCol1.align("center");
					//myload = 1;
					//insertSum();
					//$(dgUpholdsteryDetail).datagrid('reload');
				}, */
				toolbar: [{
					iconCls: 'icon-add',
					text :'Insert',
					handler: function(){insertRow();}
				},'-',{
					iconCls: 'icon-remove',
					text :'Remove',
					handler: function(){removeit();}
				},'-',{
					iconCls: 'icon-save',
					text :'Save',
					handler: function(){getChanges();}
				},'-',{
					iconCls: 'icon-undo',
					text :'Cancel',
					handler: function(){reject();}
				},'-',{
					iconCls: 'icon-print',
					text :'Print',
					handler: function(){print();}
				},'-',{
					iconCls: 'icon-pinjaman',
					text : 'Update',
					handler:function(){update();}
				},'-',{
					iconCls: 'icon-sum',
					text : 'Calculate',
					handler:function(){calc();}
				},'-',{
					iconCls: 'icon-docexcel',
					text : 'Import',
					handler:function(){upholstery_import();}
				}],
        columns: [
					[{
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
						field:'material_family',
						title:'material_family',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'hidden_family',
						title:'hidden_family',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'hidden_name',
						title:'hidden_name',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'convertion_hrg',
						title:'convertion_hrg',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'unit_name',
						title:'unit_name',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'length_unit',
						title:'length_unit',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'type',
						title:'type',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'convertion',
						title:'convertion',
						rowspan:2,
						hidden:true,
						editor: {
              type: "numberbox"
						}
					},{
						field:'brg_harga',
						title:'brg_harga',
						rowspan:2,
						hidden:true,
						editor: {
              type: "numberbox",
							options:{
								precision:8
							}
						}
					},{
						field:'material',
						title:'material',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'hidden_comp_waste',
						title:'hidden_comp_waste',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'real_size_unit',
						title:'real_size_unit',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'real_size_length',
						title:'real_size_length',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'real_size_width',
						title:'real_size_width',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'real_size_height',
						title:'real_size_height',
						rowspan:2,
						hidden:true,
						editor: {
              type: "validatebox"
						}
					},{
						field:'ck',
						checkbox: true,
						rowspan:2
					},{
						title:'Component',
						colspan:3
					},{
						title:'Material',
						colspan:2
					},{
						title:'Finished Size (mm)',
						colspan:3
					},{
						field:'volume',
						title:'Kg /<br />Component',
						align:"center",
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
							options:{
								precision:2,
								onChange : function(newValue, oldValue){
									if (newValue!=oldValue){
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										cotation_uphold(idx);
									}
								}
							}
						}
					},{
						field:'inpieces',
						title:'Piece(s) /<br />Component',
						align:"center",
						hidden: true,
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
							type:"numberbox"
						}
					},{
						field:'quantity',
						title:'Qty',
						align:"center",
						width:35,
						rowspan:2,
						styler: function (value, row, index){
						  //var th = $(this).closest('th.datagrid-field');
							//var child = th.child('div.datagrid-header').css('border-right:2px solid #000;');
							return 'border-right:2px solid #000;header-border-right:2px solid #000;';
						},
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
								onChange: function(newValue,oldValue){
									if (newValue!=oldValue){
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										cotation_uphold(idx);
									}
								}
							}
						}
					},{
						field:"mat_waste", 
						title:'Average <br/>Material <br/>Waste (%)',
						align:"center", 
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
							type:"numberbox"
						}
					},{
						field:"comp_waste", 
						title:"Component<br/>Waste (%)",
						align:"center", 
						width:70,
						rowspan:2,
						styler: function (value, row, index){
							return 'border-right:2px solid #000;header-border-right:2px solid #000;';
						},
						formatter:function(value,row,index){
							if (value==0){
								return row.hidden_comp_waste;
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options:{
								onChange: function(newValue,oldValue){
									if (newValue!=oldValue){
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										var ed_h_comp_waste = $(dgUpholdstery).datagrid("getEditor",{index:idx, field:"hidden_comp_waste"});
										$(ed_h_comp_waste.target).val(newValue);
										cotation_uphold(idx);
									}
								}
							}
						} 
					},{
						field:"consumption",
						align:'center',
						title:'Consumption<br/>(wastes included)<br/>(mm2)',
						width:95,
						rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox"
						}
					},{
						field:"consumption_m2",
						align:'center',
						title:'Consumption<br/>(wastes included)<br/>(m2)',
						width:95,
						rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								var whole=0;
								var fraction=0;
								var fraction_char='';
								var newVal='';
								whole = Math.floor(value);
								fraction = Number(value-whole);
								fraction_char = fraction+'';
								if (fraction>0){
									for (i=7;i>2;i--){
										if (fraction_char.substring(Number(i-1),i)=='' || fraction_char.substring(Number(i-1),i)=='0'){
											if (i==3){
												newVal=whole;
											}
										}else{
											newVal = whole+','+fraction_char.substring(2,i);
											break;
										}
									}
									return newVal;
								}else{
									return whole;
								}
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 5,
								decimalSeparator:','
							}
						}
					},{
						field:"consumption_m",
						align:'center',
						title:'Consumption<br/>(wastes included)<br/>(m)',
						width:95,
						rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								var whole=0;
								var fraction=0;
								var fraction_char='';
								var newVal='';
								whole = Math.floor(value);
								fraction = Number(value-whole);
								fraction_char = fraction+'';
								if (fraction>0){ 
									for (i=7;i>2;i--){
										if (fraction_char.substring(Number(i-1),i)=='' || fraction_char.substring(Number(i-1),i)=='0'){
											if (i==3){
												newVal=whole;
											}
										}else{
											newVal = whole+','+fraction_char.substring(2,i);
											break;
										}
									}
									return newVal;
								}else{
									return whole;
								}
								
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 5,
								decimalSeparator:','
							}
						}
					},{
						field:"sqf25",
						align:'center',
						title:'Sqf<br />(25 x 25)',
						rowspan:2,
						width:50,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"sqf28",
						align:'center',
						title:'Sqf<br />(28 x 28)',
						rowspan:2,
						width:50,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"sqf3048",
						align:'center',
						title:'Sqf<br />(30.48 x 30.48)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter140",
						align:'center',
						title:'Runing<br />Meter<br /> (140 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 3
							}
						}
					},{
						field:"runningmeter150",
						align:'center',
						title:'Runing<br />Meter<br /> (150 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 3
							}
						}
					},{
						field:"runningmeter160",
						align:'center',
						title:'Runing<br />Meter<br /> (160 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 3
							}
						}
					},{
						field:"runningmeter047",
						align:'center',
						title:'Runing<br /> Meter<br /> (47 mm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter050",
						align:'center',
						title:'Runing<br /> Meter<br /> (50 mm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter057",
						align:'center',
						title:'Runing<br /> Meter<br /> (57 mm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"kilo",
						align:'center',
						title:'Kg',
						rowspan:2,
						hidden: true,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"pieces",
						align:'center',
						title:'Piece(s)',
						rowspan:2,
						hidden: true,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						//styler: function (value, row, index){
						//	return 'border-right:2px solid #000;header-border-right:2px solid #000;';
						//},
						editor:{
							type:"numberbox",
							options : {
								precision: 0
							}
						}
					},{
						field:'currency',
						title:'Currency',
						align:"center",
						hidden:true,
						rowspan:2,
						editor: {
              type: "validatebox",
						}
					},{
						field:"cost",
						align:'center',
						title:'Cost',
						width:80,
						hidden:true,
						rowspan:2,
						editor:{
							type:"numberbox",
							options : {
								precision: 2
							}
						} 
					}],[{
						field: "komponen1", 
						title: "", 
						width: 140, 
						//rowspan:2,
						editor: {
							type: "validatebox",
							options:{
								required:true
							}
						}
					},{
						field: "komponen2", 
						title: "", 
						width: 140,
						//rowspan:2,							
						editor: {
							type: "validatebox"
						}
					},{
						field: "komponen3", 
						title: "", 
						width: 140, 
						//rowspan:2,
						editor: {
							type: "validatebox"
						}
					},{
						field: "family_id", 
						title: "Family", 
						//rowspan:2,
						width: 150, 
						formatter:function(value,row,index){
						
							if (row.family){
								return row.family;
							} else {
								return row.hidden_family;
							} 
							//return row.family;
						}, 
						editor: {
							type: "combobox",
							options: {
								valueField :"family_id",
								textField :"family",
								required:true,
								url:'<?php echo site_url(); ?>/ref_json/DataFamilyCot',
								onChange: function(value){ 
									var url = '<?php echo site_url(); ?>/ref_json/DataMaterial1/upholstery/'+value; 
									//var ed = $('dgUpholdstery').datagrid('getEditors',{index:1,field:'material'});
									//$(ed.target).combobox('reload',url);
									//var editors = $(dgUpholdstery).datagrid('getEditors', rowIndex);
									//var n3 = $(editors[3].target);
									//var n4 = $(editors[4].target);
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'kode_barang'});
									//var text = $(this).combobox('getData');
									//var mypos = text.indexOf(value);
									//var n3 = $(editors[2].target);
									//n3.combobox('reload',url);
									 $(ed.target).combobox("reload", url);
									 $(ed.target).combobox('setValue', '');
								},
								filter: function(q,row){
									return row.family.toLowerCase().indexOf(q.toLowerCase())==0;
								}
							}
						}
					},{
						field: "kode_barang", 
						title: "Name", 
						//align: "center",
						//rowspan:2,
						width: 260, 
						formatter:function(value,row,index){
						
							if (row.nama_barang){
								return row.nama_barang;
							} else {
								return row.hidden_name;
							} 
							//return row.family;
						}, 
						editor: {
							type: "combobox",
							options: {
								valueField:"kode_barang",
								textField:"nama_barang",
								required:true,
								mode:'remote',
								url:'<?php echo site_url(); ?>/ref_json/DataMaterial1/upholstery',
								onSelect: function(rows){
									//var dgrid = $(this).closest('datagrid');
									var tr = $(this).closest('tr.datagrid-row');
									var idx = parseInt(tr.attr('datagrid-row-index'));
									var ed = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'family_id'});
									var ed1 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'material_family'});
									var ed0 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'hidden_family'});
									var ed01 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'hidden_name'});
									var ed2 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'material'});
									var ed3 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'mat_waste'});
									var ed_comp = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'comp_waste'});
									var ed4 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'convertion'});
									var ed5 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'convertion_hrg'});
									var ed6 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'brg_harga'});
									var ed7 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'currency'});
									//var ed8 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'cost'});
									var ed_length = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'length'});
									var ed_width = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'width'});
									var ed_height = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'height'});
									var ed_volume = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'volume'});
									var ed_unit = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'unit_name'});
									var ed_lengthunit = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'length_unit'});
									var ed_type = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'type'});
									var ed_inpieces = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'inpieces'});
									var ed_cons = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'consumption'});
									var ed_cons_m = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'consumption_m'});
									var ed_cons_m2 = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'consumption_m2'});
									var ed_qty = $(dgUpholdstery).datagrid("getEditor", {index:idx, field:'quantity'});
									
									clearMyEditor(idx);
									$(ed.target).combobox("select", rows.family);
									$(ed3.target).numberbox('setValue',rows.average_waste);
									$(this).combobox('setValue', rows.kode_barang);
									var family = $(ed1.target).val();
									var lengtunit =rows.length_unit;
									var size_width=0;
									$(ed_comp.target).numberbox('enable');
									$(ed_qty.target).numberbox('enable');
									if (rows.family_name=='Leather' || rows.family_name=='Fabric' || rows.family_name=='Glue' || rows.family_name=='Yarn' || rows.family_name=='Webbing' || rows.family_name=='Perekat' || rows.family_name=='Zipper'){
										$(ed_height.target).numberbox('setValue','');
										$(ed_height.target).numberbox('disable');
										$(ed_length.target).numberbox('enable');
										$(ed_width.target).numberbox('enable');
										$(ed_volume.target).numberbox('disable');
										$(ed_inpieces.target).numberbox('disable');
										if (rows.family_name=='Fabric'){
											//$(ed_width.target).numberbox('disable');
											$(ed_lengthunit.target).val(rows.length_unit);
											if (lengtunit.toLowerCase()=='m'){
												size_width = rows.size_width * 1000;
												
											} else if (lengtunit.toLowerCase()=='cm'){
												size_width = rows.size_width * 10;
											} else if (lengtunit.toLowerCase()=='mm'){
												size_width = rows.size_width;
											}
											//$(ed_width.target).numberbox('setValue',size_width);
											
										}
										if (rows.family_name=='Yarn' || rows.family_name=='Webbing' || rows.family_name=='Perekat'){
											$(ed_width.target).numberbox('setValue','');
											$(ed_width.target).numberbox('disable'); 
											if (rows.family_name=='Webbing' || rows.family_name=='Perekat'){
												$(ed_width.target).numberbox('setValue',rows.size_width);
											}
										} else if(rows.family_name=='Zipper') {
											$(ed_width.target).numberbox('setValue','');
											$(ed_width.target).numberbox('disable');
											if (rows.unit_name.toLowerCase().indexOf("roll")!=-1 || rows.unit_name.toLowerCase().indexOf("meter")!=-1){
												$(ed_inpieces.target).numberbox('setValue','');
												$(ed_inpieces.target).numberbox('disable');
												$(ed_qty.target).numberbox('enable');
												$(ed_qty.target).numberbox('setValue',''); 
											} else {
												$(ed_length.target).numberbox('setValue','');
												$(ed_length.target).numberbox('disable');
												$(ed_comp.target).numberbox('setValue','');
												$(ed_comp.target).numberbox('disable');
												$(ed_inpieces.target).numberbox('setValue',''); 
												$(ed_inpieces.target).numberbox('disable');
												$(ed_qty.target).numberbox('enable');
												$(ed_qty.target).numberbox('setValue',''); 
												
											} 
										}
									} else if (rows.family_name=='Foam'){
										
										$(ed_height.target).numberbox('disable');
										//$(ed_width.target).numberbox('setValue',rows.size_width);
										$(ed_width.target).numberbox('enable');
										$(ed_length.target).numberbox('enable');
										$(ed_inpieces.target).numberbox('disable');
										$(ed_volume.target).numberbox('disable');
										if (rows.type=='Dacron' && rows.nama_barang.toLowerCase().indexOf("gulung")==-1 && rows.unit_name.toLowerCase().indexOf("kg")!=-1){
											$(ed_volume.target).numberbox('enable');
											$(ed_length.target).numberbox('disable');
											$(ed_width.target).numberbox('disable');
											$(ed_comp.target).numberbox('disable');
											$(ed_height.target).numberbox('setValue','');
											$(ed_width.target).numberbox('setValue','');
										} else if ((rows.type=='Dacron' && rows.nama_barang.toLowerCase().indexOf("gulung")!=-1) /* || (rows.type=='Dacron' && rows.nama_barang.toLowerCase().indexOf("gulung")==-1 && rows.unit_name.toLowerCase().indexOf("kg")==-1) */){
											$(ed_volume.target).numberbox('disable');
											$(ed_length.target).numberbox('enable');
											$(ed_height.target).numberbox('setValue','');
											$(ed_width.target).numberbox('enable');
											$(ed_width.target).numberbox('setValue','');
										} else if (rows.type=='Foam' &&  rows.unit_name.toLowerCase().indexOf("kg")!=-1){
											$(ed_volume.target).numberbox('enable');
											$(ed_length.target).numberbox('disable');
											$(ed_width.target).numberbox('disable');
											$(ed_comp.target).numberbox('disable');
											$(ed_height.target).numberbox('setValue','');
											$(ed_width.target).numberbox('setValue','');
										} else if (rows.type!='Dacron'){
											$(ed_height.target).numberbox('setValue',rows.size_height);
										}
									}else if (rows.family_name=='Hardware' || rows.family_name=='Connector'){
										if (rows.unit_name.toLowerCase().indexOf("yds")!=-1 || rows.unit_name.toLowerCase().indexOf("roll")!=-1){
											$(ed_inpieces.target).numberbox('disable');
											$(ed_length.target).numberbox('enable');
										} else {
											$(ed_inpieces.target).numberbox('disable');
											$(ed_length.target).numberbox('disable');
										}
										$(ed_height.target).numberbox('setValue','');
										$(ed_height.target).numberbox('disable');
										$(ed_volume.target).numberbox('disable');
										$(ed_width.target).numberbox('disable');
									}
										
									$(ed0.target).val(rows.family_name);
									$(ed01.target).val(rows.nama_barang);
									$(ed1.target).val(rows.family);
									$(ed2.target).val(rows.kode_barang);
									$(ed6.target).val(rows.brg_harga);
									$(ed7.target).val(rows.currency_name);
									$(ed_unit.target).val(rows.unit_name);
									$(ed_type.target).val(rows.type);
									//var opts = $(ed8.target).numberbox('options');
									//opts.prefix = rows.currency_name;
									//$(ed8.target).numberbox('setValue',1000);
									//var col = $(dgUpholdstery).datagrid('getColumnOption', mat_waste);
									hargaUpholstery(idx,rows.kode_barang);
								},
								filter: function(q,row){
									return row.nama_barang.toLowerCase().indexOf(q.toLowerCase())==0;
								}
							}
						}
					},{
						field: "length", 
						title: "L", 
						align: "center",
						//rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						width: 40, 
						editor: {
							type: "numberbox",
							options:{
								onChange: function(newValue,oldValue){
									if (newValue!=oldValue){
										
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										
										cotation_uphold(idx);
									}
								}
							}
						}
					},{
						field: "width", 
						title: "W", 
						align: "center",
						//rowspan:2,
						width: 40, 
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor: {
							type: "numberbox",
							options:{
								onChange: function(newValue,oldValue){
									if (newValue!=oldValue){
										
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										cotation_uphold(idx);
									}
								}
							}
						}
					},{
						field: "height", 
						title: "H", 
						align: "center",
						//rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						width: 40, 
						editor: {
							type: "numberbox",
								options:{
								onChange: function(newValue,oldValue){
									if (newValue!=oldValue){
										var tr = $(this).closest('tr.datagrid-row');
										var idx = parseInt(tr.attr('datagrid-row-index'));
										cotation_uphold(idx);
									}
								}
							}
						}
					}]
				]
    });
		
		$(dgUpholdsteryDetail).datagrid({
				title: "Raw-Material Needs",
        width: 1020,
        height: 350,
				rownumbers:true,
				singleSelect:true,
				//collapsible:true,
				selectOnCheck: false,
				checkOnSelect: false,
				collapsible:true,
				//collapsed:false,
				//showFooter: true,
				autoLoad:false,
				url:"<?php echo site_url(); ?>/cotation/Calculation_Component",
				style:'padding:1px;',
				onLoadSuccess:function (data){
					var panel = $(this).datagrid("getPanel");
					var myheaderCol = panel.find("div.datagrid-header td[field='pieces']");
					myheaderCol.css("border-right","2px dotted #fece2f");
					//panel.panel('collapse', true);
				},
				toolbar: [{
					iconCls: 'icon-print',
					text :'Print',
					handler: function(){PrintDet();}
				}],
				columns:[[{
					field:'ck',
					checkbox: true,
					rowspan:2
				},{
					field:'kode_barang',
					align:"center",
					title:'Name',
					width:260
				},{
					field:'family',
					align:"center",
					title:'family',
					hidden: true,
					width:260
				},{
					field:'ppn',
					align:"center",
					title:'ppn',
					hidden: true,
					width:5
				},{
					field:"consumption_m",
					align:'center',
					title:'Meter',
					rowspan:2,
					width:50,
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					editor:{
						type:"numberbox",
						options : {
							precision: 1
						}
					}
				},{
						field:"sqf25",
						align:'center',
						title:'Sqf<br />(25 x 25)',
						rowspan:2,
						width:50,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"sqf28",
						align:'center',
						title:'Sqf<br />(28 x 28)',
						rowspan:2,
						width:50,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"sqf3048",
						align:'center',
						title:'Sqf<br />(30.48 x 30.48)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter140",
						align:'center',
						title:'Running<br />Meter<br /> (140 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter150",
						align:'center',
						title:'Running<br />Meter<br /> (150 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter160",
						align:'center',
						title:'Running<br />Meter<br /> (160 cm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter047",
						align:'center',
						title:'Running<br /> Meter<br /> (47 mm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter050",
						align:'center',
						title:'Running<br /> Meter<br /> (50 mm)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"runningmeter057",
						align:'center',
						title:'Running<br /> Meter<br /> (57 mm)',
						rowspan:2,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						width:80,
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"kilo",
						align:'center',
						title:'Kg',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"consumption_m2",
						align:'center',
						title:'Square<br />Meter',
						rowspan:2,
						width:50,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 1
							}
						}
					},{
						field:"pieces",
						align:'center',
						title:'Piece(s)',
						rowspan:2,
						width:80,
						formatter:function(value,row,index){
							if (value==0){
								return '';
							} else {
								return value;
							}
						},
						styler: function (value, row, index){
							return 'border-right:2px solid #000;header-border-right:2px solid #000;';
						},
						editor:{
							type:"numberbox",
							options : {
								precision: 0
							}
						}
					},{
						field:'currency',
						title:'Currency',
						width:70,
						align:"center",
						rowspan:2,
						editor: {
              type: "validatebox",
						}
					},{
						field:"cost",
						align:'right',
						title:'Cost',
						width:80,
						rowspan:2,
						editor:{
							type:"numberbox",
							options : {
								precision: 2
							}
						},
						styler: function (value, row, index){
							return 'font-weight:bold;';
						}
				}]]
		});
		
		//var panelUplholstery = $(dgUpholdstery).datagrid('getPanel');
		//$(dgUpholdstery).datagrid('getPanel').children().prop("collapsed",false);
		var panel = $(dgUpholdsteryDetail).datagrid("getPanel");
		panel.panel('collapse',true);
		
		insertRow = function() {
			var vid_cotation = <?php echo $id_cotation; ?>;
			
			if (endEditing()){
				$(dgUpholdstery).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',komponen1:'',komponen2:'',komponen3:'',family_id:'',kode_barang:'',length:'',width:'',height:'',quantity:'0',mat_waste:'0',comp_waste:'0'}});
				editIndex = 0;
				$(dgUpholdstery).datagrid('selectRow', editIndex)
						.datagrid('beginEdit', editIndex);
				disableMyEditor(editIndex);
			}
		};
		
		//$("table#dgUpholdstery > th[field='mat_waste']").css("border-right","2px solid #000");
		
		function disableMyEditor(index){
			var ed = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'mat_waste'});
			var ed1 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption'});
			var ed2 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'cost'});
			var ed3 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'currency'});
			var ed4 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption_m2'});
			var ed5 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption_m'});
			var ed_sqf25 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf25'});
			var ed_sqf28 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf28'});
			var ed_sqf3048 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf3048'});
			var ed_runningmeter140 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter140'});
			var ed_runningmeter150 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter150'});
			var ed_runningmeter160 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter160'});
			var ed_runningmeter047 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter047'});
			var ed_runningmeter050 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter050'});
			var ed_runningmeter057 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter057'});
			var ed_kilo = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'kilo'});
			var ed_pieces = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'pieces'});
			$(ed.target).numberbox('disable');
			$(ed1.target).numberbox('disable');
			$(ed2.target).numberbox('disable');
			$(ed3.target).attr('disabled','true');
			$(ed4.target).numberbox('disable');
			$(ed5.target).numberbox('disable');
			$(ed_sqf25.target).numberbox('disable');
			$(ed_sqf28.target).numberbox('disable');
			$(ed_sqf3048.target).numberbox('disable');
			$(ed_runningmeter140.target).numberbox('disable');
			$(ed_runningmeter150.target).numberbox('disable');
			$(ed_runningmeter160.target).numberbox('disable');
			$(ed_runningmeter047.target).numberbox('disable');
			$(ed_runningmeter050.target).numberbox('disable');
			$(ed_runningmeter057.target).numberbox('disable');
			$(ed_kilo.target).numberbox('disable');
			$(ed_pieces.target).numberbox('disable');
		}
		
		function clearMyEditor(index){
			//var ed_material_family = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'material_family'});
			var ed_hidden_family = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'hidden_family'});
			var ed_hidden_name = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'hidden_name'});
			var ed_convertion_hrg = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'convertion_hrg'});
			var ed_unit_name = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'unit_name'});
			var ed_lengthunit = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'length_unit'});
			var ed_type = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'type'});
			var ed_convertion = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'convertion'});
			var ed_brg_harga = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'brg_harga'});
			var ed_material = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'material'});
			var ed_length = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'length'});
			var ed_width = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'width'});
			var ed_height = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'height'});
			var ed_volume = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'volume'});
			var ed_inpieces = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'inpieces'});
			var ed_quntity = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'quantity'});
			var ed_mat_waste = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'mat_waste'});
			var ed_comp_waste = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'comp_waste'});
			var ed_cons = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption'});
			var ed_cons_m = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption_m'});
			var ed_cons_m2 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'consumption_m2'});
			var ed_sqf25 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf25'});
			var ed_sqf28 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf28'});
			var ed_sqf3048 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'sqf3048'});
			var ed_runningmeter140 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter140'});
			var ed_runningmeter150 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter150'});
			var ed_runningmeter160 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter160'});
			var ed_runningmeter047 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter047'});
			var ed_runningmeter050 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter050'});
			var ed_runningmeter057 = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'runningmeter057'});
			var ed_kilo = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'kilo'});
			var ed_pieces = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'pieces'});
			var ed_currency = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'currency'});
			var ed_cost = $(dgUpholdstery).datagrid("getEditor", {index:index, field:'cost'});
			
			//$(ed_material_family.target).val('');
			$(ed_hidden_family.target).val('');
			$(ed_hidden_name.target).val('');
			$(ed_convertion_hrg.target).val('');
			$(ed_unit_name.target).val('');
			$(ed_lengthunit.target).val('');
			$(ed_type.target).val('');
			$(ed_convertion.target).val('');
			$(ed_brg_harga.target).val('');
			$(ed_material.target).val('');
			$(ed_length.target).numberbox('setValue','');
			$(ed_width.target).numberbox('setValue','');
			$(ed_height.target).numberbox('setValue','');
			$(ed_volume.target).numberbox('setValue','');
			$(ed_inpieces.target).numberbox('setValue','');
			$(ed_quntity.target).numberbox('setValue','');
			$(ed_mat_waste.target).numberbox('setValue','');
			$(ed_comp_waste.target).numberbox('setValue','');
			$(ed_cons.target).numberbox('setValue','');
			$(ed_cons_m.target).numberbox('setValue','');
			$(ed_cons_m2.target).numberbox('setValue','');
			$(ed_sqf25.target).numberbox('setValue','');
			$(ed_sqf28.target).numberbox('setValue','');
			$(ed_sqf3048.target).numberbox('setValue','');
			$(ed_runningmeter140.target).numberbox('setValue','');
			$(ed_runningmeter150.target).numberbox('setValue','');
			$(ed_runningmeter160.target).numberbox('setValue','');
			$(ed_runningmeter047.target).numberbox('setValue','');
			$(ed_runningmeter050.target).numberbox('setValue','');
			$(ed_runningmeter057.target).numberbox('setValue','');
			$(ed_kilo.target).numberbox('setValue','');
			$(ed_pieces.target).numberbox('setValue','');
			$(ed_currency.target).val('');
			$(ed_cost.target).numberbox('setValue','');
		}
		
		function endEditing(){
			if (editIndex == undefined){return true}
			if ($(dgUpholdstery).datagrid('validateRow', editIndex)){
				var ed = $(dgUpholdstery).datagrid('getEditor', {index:editIndex,field:'family_id'});
				var ed1 = $(dgUpholdstery).datagrid('getEditor', {index:editIndex,field:'kode_barang'});
				var ed_comp1 = $(dgUpholdstery).datagrid('getEditor', {index:editIndex,field:'komponen1'});
				var ed_comp2 = $(dgUpholdstery).datagrid('getEditor', {index:editIndex,field:'komponen2'});
				var ed_comp3 = $(dgUpholdstery).datagrid('getEditor', {index:editIndex,field:'komponen3'});
				var komponen1 = $(ed_comp1.target).val();
				var komponen2 = $(ed_comp2.target).val();
				var komponen3 = $(ed_comp3.target).val();
				var family = $(ed.target).combobox('getValue');
				var material = $(ed1.target).combobox('getValue');
				$(dgUpholdstery).datagrid('getRows')[editIndex]['family_id'] = family;
				$(dgUpholdstery).datagrid('getRows')[editIndex]['kode_barang'] = material;
				$(ed_comp1.target).val(ucFirst(komponen1));
				$(ed_comp2.target).val(ucFirst(komponen2));
				$(ed_comp3.target).val(ucFirst(komponen3));
				$(dgUpholdstery).datagrid('endEdit', editIndex);
				editIndex = undefined;
				return true;
			} else {
				return false;
			}
		}
		function onClickRow(index){
			if (editIndex != index){
				if (endEditing()){
					$(dgUpholdstery).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
					editIndex = index;
					//var tr = $(this).closest('tr.datagrid-row');
					//var idx = parseInt(tr.attr('datagrid-row-index'));
					
					var ed = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'family_id'});
					var ed1 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'kode_barang'});
					var ed2 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'material_family'});
					var ed0 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'hidden_family'});
					var ed01 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'hidden_name'});
					var ed3 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'material'});
					var ed_comp1 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'komponen1'});
					var ed_comp2 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'komponen2'});
					var ed_comp3 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'komponen3'});
					var ed_length = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'length'});
					var ed_width = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'width'});
					var ed_height = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'height'});
					var ed_volume = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'volume'});
					var ed_inpieces = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'inpieces'});
					var ed_type = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'type'});
					var ed_unit = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'unit_name'});
					var ed_h_comp_waste = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'hidden_comp_waste'});
					var ed_comp_waste = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'comp_waste'});
					var ed_qty = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'quantity'});
					var ed_currency = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'currency'});
				
					var komponen1 = $(ed_comp1.target).val();
					var komponen2 = $(ed_comp2.target).val();
					var komponen3 = $(ed_comp3.target).val();
					var height = $(ed_height.target).val();
					var family = $(ed2.target).val();
					var hidden_family = $(ed0.target).val();
					var family_name = $(ed.target).combobox('getText');
					var data_combo =  $(ed.target).combobox('getData');
					var material = $(ed3.target).val();
					var currency = $(ed_currency.target).val();
					var type = $(ed_type.target).val();
					var unit_name = $(ed_unit.target).val();
					var hidden_name = $(ed01.target).val();
					var hidden_comp_waste = $(ed_h_comp_waste.target).val();
					var url = '<?php echo site_url(); ?>/ref_json/DataMaterial1/upholstery/'+family;
					disableMyEditor(editIndex);
					
					$(ed.target).combobox('setValue', family);
					$(ed1.target).combobox('reload', url);
					$(ed1.target).combobox('select', material);
					$(ed_comp_waste.target).numberbox('setValue',hidden_comp_waste);
					$(ed_currency.target).val(currency);
					$(ed_qty.target).numberbox('enable');
					if (hidden_family=='Leather' || hidden_family=='Fabric' || hidden_family=='Glue' || hidden_family=='Foam' || hidden_family=='Yarn' || hidden_family=='Webbing' || hidden_family=='Perekat' || hidden_family=='Zipper'){
						$(ed_height.target).numberbox('disable');
						$(ed_volume.target).numberbox('disable');
						$(ed_inpieces.target).numberbox('disable');
						if (hidden_family=='Foam' && type.toLowerCase().indexOf("dacron")!=-1 && hidden_name.toLowerCase().indexOf("gulung")==-1 && unit_name.toLowerCase().indexOf("kg")!=-1){
							$(ed_length.target).numberbox('disable');
							$(ed_volume.target).numberbox('enable');
							$(ed_width.target).numberbox('disable');
						} else if ((hidden_family=='Foam'  && type.toLowerCase().indexOf("dacron")!=-1 && hidden_name.toLowerCase().indexOf("gulung")!=-1) /*|| (hidden_family=='Foam'  && type.toLowerCase().indexOf("dacron")!=-1 && hidden_name.toLowerCase().indexOf("gulung")==-1 && unit_name.toLowerCase().indexOf("kg")==-1) */){
							$(ed_length.target).numberbox('enable');
							$(ed_volume.target).numberbox('disable');
							$(ed_width.target).numberbox('enable');
						} else if (hidden_family=='Foam' && unit_name.toLowerCase().indexOf("kg")!=-1){
							$(ed_length.target).numberbox('disable');
							$(ed_volume.target).numberbox('enable');
							$(ed_width.target).numberbox('disable');
						}
						else if (hidden_family=='Fabric'){
							$(ed_length.target).numberbox('enable');
							$(ed_width.target).numberbox('enable');
						}
						else if (hidden_family=='Leather'){
							$(ed_length.target).numberbox('enable');
							$(ed_width.target).numberbox('enable');
						}
						else if (hidden_family=='Yarn' || hidden_family=='Webbing' || hidden_family=='Perekat'){
							$(ed_length.target).numberbox('enable');
							$(ed_width.target).numberbox('disable');
						} else if (hidden_family=='Zipper'){
							$(ed_width.target).numberbox('disable');
							if (unit_name.toLowerCase().indexOf("roll")!=-1){
								$(ed_width.target).numberbox('disable');
							} else {
								$(ed_inpieces.target).numberbox('disable');
								//$(ed_qty.target).numberbox('disable');
								$(ed_length.target).numberbox('disable');
								$(ed_comp_waste.target).numberbox('disable');
							}
						}
					//} else if (family_name=='Foam'){
					} else if (hidden_family=='Hardware' || hidden_family=='Connector'){
						$(ed_height.target).numberbox('disable');
						$(ed_volume.target).numberbox('disable');
						$(ed_inpieces.target).numberbox('disable');
						$(ed_width.target).numberbox('disable');
						if (unit_name.toLowerCase().indexOf("roll")!=-1 || unit_name.toLowerCase().indexOf("yds")!=-1){
							$(ed_length.target).numberbox('enable');
						} else{
							$(ed_length.target).numberbox('disable');
							$(ed_inpieces.target).numberbox('disable');
						}
					}
					//if (height=='')
					//	$(ed_height.target).numberbox('disable');
					
					//cotation_uphold(editIndex);
				} else {
					$(dgUpholdstery).datagrid('selectRow', editIndex);
					//cotation_uphold(editIndex);
				}
			}
		}
		
		function removeit(){
			if (editIndex == undefined){return}
			var ed = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'seq'});
			var ed1 = $(dgUpholdstery).datagrid("getEditor", {index:editIndex, field:'id_cotation'});
			var seq = $(ed.target).val();
			var id_cotation = $(ed1.target).val();
			if (seq!=''){
				$.messager.confirm('Confirm', 'Do you want to delete this data?', function(r){
					if (r){
						//$(dgUpholdstery).datagrid('cancelEdit', editIndex)
						//		.datagrid('deleteRow', editIndex);
						//editIndex = undefined;
						$.ajax({
							type	: 'POST',
							url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
							data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=upholstery",
							cache	: false,
							success	: function(data){
								$(dgUpholdstery).datagrid('cancelEdit', editIndex)
									.datagrid('deleteRow', editIndex);
								$(dgUpholdstery).datagrid('reload');
								//$(dgUpholdsteryDetail).datagrid('reload');
								editIndex = undefined;
							}
						});
					}
				});
			}else{
				$(dgUpholdstery).datagrid('cancelEdit', editIndex)
					.datagrid('deleteRow', editIndex);			
				editIndex = undefined;
			}
		}
		
		function getChanges(){
			endEditing();
			var rows = $(dgUpholdstery).datagrid('getChanges');
			var temp = [];
			var pesan ='';
			for (i=0;i<rows.length;i++){
				//pesan = pesan + rows[i].komponen1 + ' ' + rows[i].family + ' ' + rows[i].material + '\n';
				pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&komponen1_'+i+'='+rows[i].komponen1+
								'&komponen2_'+i+'='+rows[i].komponen2+
								'&komponen3_'+i+'='+rows[i].komponen3+
								'&family_id_'+i+'='+rows[i].family_id+
								'&kode_barang_'+i+'='+rows[i].material+
								'&length_'+i+'='+rows[i].length+
								'&width_'+i+'='+rows[i].width+
								'&height_'+i+'='+rows[i].height+
								'&inpieces_'+i+'='+rows[i].inpieces+
								'&volume_'+i+'='+rows[i].volume+
								'&quantity_'+i+'='+rows[i].quantity+
								'&mat_waste_'+i+'='+rows[i].mat_waste+
								'&comp_waste_'+i+'='+rows[i].comp_waste+
								'&h_comp_waste_'+i+'='+rows[i].comp_waste+
								'&consumption_'+i+'='+rows[i].consumption+
								'&consumption_m_'+i+'='+rows[i].consumption_m+
								'&sqf25_'+i+'='+rows[i].sqf25+
								'&sqf28_'+i+'='+rows[i].sqf28+
								'&sqf3048_'+i+'='+rows[i].sqf3048+
								'&runningmeter140_'+i+'='+rows[i].runningmeter140+
								'&runningmeter150_'+i+'='+rows[i].runningmeter150+
								'&runningmeter160_'+i+'='+rows[i].runningmeter160+
								'&runningmeter1047_'+i+'='+rows[i].runningmeter047+
								'&runningmeter1050_'+i+'='+rows[i].runningmeter050+
								'&runningmeter1057_'+i+'='+rows[i].runningmeter057+
								'&kilo_'+i+'='+rows[i].kilo+
								'&pieces_'+i+'='+rows[i].pieces+
								'&harga_mat_'+i+'='+rows[i].brg_harga+
								'&currency_'+i+'='+rows[i].currency;
			}
			
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/cotation/simpan_uphold",
				data	: "nArray="+rows.length+pesan,
				cache	: false,
				success	: function(data){
					//$.messager.alert('',data,'info');
					$(dgUpholdstery).datagrid('reload');
					//$(dgUpholdsteryDetail).datagrid('reload');
				}
			});
		}
		
		function cotation_uphold(idx){ 
			//var tr 				= $(this).closest('tr.datagrid-row');
			//var idx 			= parseInt(tr.attr('datagrid-row-index'));
			//endEditing();
			var my_idx 				= idx; 
			var ed_realsize_unit = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'real_size_unit'});
			var ed_realsize_length = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'real_size_length'});
			var ed_realsize_width = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'real_size_width'});
			var ed_realsize_height = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'real_size_height'});
			var ed_code				= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'material'}); 
			var ed_name				= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'hidden_name'}); 
			var ed 						= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'family_id'}); 
			var ed_length			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'length'});
			var ed_width 			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'width'});
			var ed_height 		= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'height'});
			var ed_lengthunit = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'length_unit'});
			var ed_volume 		= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'volume'});
			var ed_qty 				= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'quantity'});
			var ed_mat 				= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'mat_waste'});
			var ed_comp 			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'comp_waste'});
			var ed_cons 			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'consumption'}); 
			var ed_cons_m2		= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'consumption_m2'}); 
			var ed_cons_m			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'consumption_m'}); 
			var ed_cost 						= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'cost'});
			var ed_hrg 							= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'brg_harga'});
			var ed_unit 						= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'unit_name'});
			var ed_lengthunit 			= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'length_unit'});
			var ed_sqf25 						= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'sqf25'});
			var ed_sqf28 						= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'sqf28'});
			var ed_sqf3048 					= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'sqf3048'});
			var ed_runningmeter140 	= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'runningmeter140'});
			var ed_runningmeter150 	= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'runningmeter150'});
			var ed_runningmeter160 	= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'runningmeter160'});
			var ed_kilo 		= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'kilo'});
			var ed_type 		= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'type'});
			var ed_inpieces = $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'inpieces'});
			var ed_pieces 	= $(dgUpholdstery).datagrid("getEditor", {index:my_idx, field:'pieces'});
			var family 			= $(ed.target).combobox('getText');
			var nama_barang = $(ed_name.target).val();
			
			var kode_barang = $(ed_code.target).val();
			var length 		= $(ed_length.target).val();
			var width 		= $(ed_width.target).val();
			var height 		= $(ed_height.target).val();
			var volume 		= $(ed_volume.target).val();
			var length_unit 	= $(ed_lengthunit.target).val();
			var quantity 	= $(ed_qty.target).val();
			var material 	= $(ed_mat.target).val();
			var component	= $(ed_comp.target).val();
			var harga			= $(ed_hrg.target).val();
			var unit_name = $(ed_unit.target).val();
			//var length_unit = $(ed_lengthunit.target).val();
			var type = $(ed_type.target).val();
			var inpieces = $(ed_inpieces.target).val();
			var A,Am,Acm,B,sqf,tempHarga,run_m,pieces= 0;
			
			
			if ( family.toLowerCase().indexOf("fabric")!=-1 || family.toLowerCase().indexOf("foam")!=-1 || family.toLowerCase().indexOf("leather")!=-1 || (family.toLowerCase().indexOf("glue")!=-1 && unit_name.toLowerCase().indexOf("galon")!=-1)){
				if (family.toLowerCase().indexOf("foam")!=-1 && type.toLowerCase().indexOf("dacron")!=-1 && nama_barang.toLowerCase().indexOf("gulung")==-1){
					A = volume*quantity;
				}else {
					A = Number((length*width*quantity)*(1+(material/100)+(component/100)));
				}
			}
			else if (family.toLowerCase().indexOf("yarn")!=-1 || family.toLowerCase().indexOf("webbing")!=-1 || family.toLowerCase().indexOf("perekat")!=-1){
				A = Number((length*quantity)*(1+(material/100)+(component/100)));
			} else if (family.toLowerCase().indexOf("zipper")!=-1) {
				if (unit_name.toLowerCase().indexOf("roll")!=-1 || unit_name.toLowerCase().indexOf("meter")!=-1){
					A = Number((length*quantity)*(1+(material/100)+(component/100)));
				} else{
					A = inpieces*quantity;
				}
			} else if (family.toLowerCase().indexOf("hardware")!=-1) {
				$(ed_comp.target).numberbox('disable');
				if (unit_name.toLowerCase().indexOf("yds")!=-1 || unit_name.toLowerCase().indexOf("roll")!=-1){
					A =  Number((length*quantity)*(1+(material/100)+(component/100)));
				} else {
					A = inpieces*quantity;
					//$(ed_pieces.target).numberbox('setValue',A);
				}
			//} else if (family.toLowerCase().indexOf("glue")!=-1 && unit_name.toLowerCase().indexOf("galon")!=-1) {
				
			}
			Acm = Number(A/100);
			Am = Number(A/1000000);
			B = Number(A*harga);
			
			if (unit_name.toLowerCase().indexOf("square feet")!=-1 && family=='Leather'){
				if (unit_name.toLowerCase().indexOf("25")!=-1){
					sqf = Number(Acm/(25*25));
					//sqf = Math.ceil(sqf);
					$(ed_sqf25.target).numberbox('setValue',sqf);
					$(ed_sqf28.target).numberbox('setValue','');
					$(ed_sqf3048.target).numberbox('setValue','');
				}
				else if (unit_name.toLowerCase().indexOf("28")!=-1 && family=='Leather'){
					sqf = Number(Acm/(28*28));
					//sqf = Math.ceil(sqf);
					$(ed_sqf28.target).numberbox('setValue',sqf);
					$(ed_sqf25.target).numberbox('setValue','');
					$(ed_sqf3048.target).numberbox('setValue','');
				} 
				else if (unit_name.toLowerCase().indexOf("30.48")!=-1 && family=='Leather'){
					sqf = Number(Acm/(30.48*30.48));
					//sqf = Math.ceil(sqf);
					$(ed_sqf3048.target).numberbox('setValue',sqf);
					$(ed_sqf28.target).numberbox('setValue','');
					$(ed_sqf25.target).numberbox('setValue','');
				}
				B = Number(sqf*harga);
			}else {
				$(ed_sqf3048.target).numberbox('setValue','');
				$(ed_sqf28.target).numberbox('setValue','');
				$(ed_sqf25.target).numberbox('setValue','');
			}			
			if (family.toLowerCase().indexOf("fabric")!=-1 && (unit_name.toLowerCase().indexOf("meter")!=-1 || unit_name.toLowerCase().indexOf("running meter")!=-1 || unit_name.toLowerCase().indexOf("roll")!=-1)){
				var t_width = 0;
				var t_length = 0;
				//var size = 
				ukuranBarang(my_idx, kode_barang);
				var real_width = $(ed_realsize_width.target).val();
				var real_length_unit = $(ed_realsize_unit.target).val();
				
				if (real_length_unit=='m'){
					t_width = Number(real_width*1000);
					t_length = Number(real_width*1000);
				} else if(real_length_unit=='cm'){
					t_width = Number(real_width*100);
				} else if(real_length_unit=='mm'){
					t_width = real_width;
				}
				//alert(size[0]['length_unit']);
				if (t_width==1400 || t_width==1370 || t_width==1380 || t_width==1450){
					/*
					if (length>real_width && (length/1000)>1.4){
						run_m = Number(length/1000/1.4);
					} else {
						run_m = Number(width/1000/1.4);
					} */
					if (t_width==1400){
						run_m = Number((A)/1000000/1.4);
					} else if(t_width==1370){
						run_m = Number((A)/1000000/1.37);
					} else if(t_width==1380){
						run_m = Number((A)/1000000/1.38);
					} else {
						run_m = Number((A)/1000000/1.45);
					}
					
					$(ed_runningmeter140.target).numberbox('setValue',run_m);
					$(ed_runningmeter150.target).numberbox('setValue','');
					$(ed_runningmeter160.target).numberbox('setValue','');
				} else if (t_width==1500){
					/*
					if (length>real_width && (length/1000)>1.5){
						run_m = Number(length/1000/1.5);
					} else{
						run_m = Number(width/1000/1.5);
					} */
					run_m = Number((A)/1000000/1.5);
					
					$(ed_runningmeter140.target).numberbox('setValue','');
					$(ed_runningmeter150.target).numberbox('setValue',run_m);
					$(ed_runningmeter160.target).numberbox('setValue','');
				} else if (t_width==1600){
					/*
					if (length>real_width && (length/1000)>1.6){
						run_m = Number(length/1000/1.6);
					} else{
						run_m = Number(width/1000/1.6);
					} */
					run_m = Number((A)/1000000/1.6);
					
					$(ed_runningmeter140.target).numberbox('setValue','');
					$(ed_runningmeter150.target).numberbox('setValue','');
					$(ed_runningmeter160.target).numberbox('setValue',run_m);
				}
		//	} else if (family.toLowerCase().indexOf("hardware")!=-1 && unit_name.toLowerCase().indexOf("yds")!=-1){
				
			}
			
			if (family.toLowerCase().indexOf("foam")!=-1 && type.toLowerCase().indexOf("dacron")!=-1 && nama_barang.toLowerCase().indexOf("gulung")==-1){
				$(ed_cons.target).numberbox('setValue',''); 
				$(ed_cons_m2.target).numberbox('setValue','');
				$(ed_pieces.target).numberbox('setValue','');
				$(ed_kilo.target).numberbox('setValue',A); 
			} else if (family.toLowerCase().indexOf("hardware")!=-1){
				if (unit_name.toLowerCase().indexOf("yds")!=-1 || unit_name.toLowerCase().indexOf("roll")!=-1){
					$(ed_pieces.target).numberbox('setValue','');
					$(ed_cons.target).numberbox('setValue',A);
					$(ed_cons_m2.target).numberbox('setValue',Am);
				} else {
					$(ed_pieces.target).numberbox('setValue',A);
					$(ed_cons.target).numberbox('setValue','');
					$(ed_cons_m2.target).numberbox('setValue','');
				}
			}else if (family.toLowerCase().indexOf("zipper")!=-1) {
				$(ed_cons.target).numberbox('setValue',''); 
				$(ed_cons_m2.target).numberbox('setValue','');
				if (unit_name.toLowerCase().indexOf("roll")!=-1 || unit_name.toLowerCase().indexOf("meter")!=-1){
					$(ed_pieces.target).numberbox('setValue','');
					$(ed_cons_m.target).numberbox('setValue',A/1000);
				} else {
					$(ed_cons_m.target).numberbox('setValue','');
					$(ed_pieces.target).numberbox('setValue',A);
				}
			}else if (family.toLowerCase().indexOf("yarn")!=-1 || family.toLowerCase().indexOf("webbing")!=-1 || family.toLowerCase().indexOf("perekat")!=-1 ) {
				$(ed_cons.target).numberbox('setValue',''); 
				$(ed_cons_m2.target).numberbox('setValue','');
				$(ed_cons_m.target).numberbox('setValue',A/1000);
			}else {
				$(ed_cons.target).numberbox('setValue',A); 
				$(ed_cons_m2.target).numberbox('setValue',Am);
			}
			$(ed_cost.target).numberbox('setValue',B);
		} 
		
		function accept(){
			if (endEditing()){
				$(dgUpholdstery).datagrid('acceptChanges');
				var rows = $(dgUpholdstery).datagrid('getChanges');
				var pesan ='';
				for (i=0;i<rows.length;i++){
					pesan = pesan + rows[i].komponen1 + ' ' + rows[i].family + ' ' + rows[i].material + '\n';
				}
			}
		}
		
		function reject(){
			$(dgUpholdstery).datagrid('rejectChanges');
			editIndex = undefined;
			$(dgUpholdstery).datagrid('reload');
		}
		
		function print(){
			var rows = $(dgUpholdstery).datagrid('getChecked');
			var kode_barang_print = '-';
			
			for (i=0;i<rows.length;i++){
				kode_barang_print += rows[i].seq+'-';
			}
			
			window.open('<?php echo site_url();?>/cotation/print_upholstery/<?php echo $id_cotation; ?>/'+kode_barang_print);
			//return false();
		}
		
		function PrintDet(){
			var rows = $(dgUpholdsteryDetail).datagrid('getChecked');
			var pesan='';
			//var databarang = [];
			var id_cotation = '<?php echo $id_cotation ?>';
			for (i=0;i<rows.length;i++){
			
				pesan += '&kode_barang_'+i+'='+rows[i].kode_barang+
								 '&family_'+i+'='+rows[i].family+
								 '&consumption_m_'+i+'='+rows[i].consumption_m+
								 '&sqf25_'+i+'='+rows[i].sqf25+
								 '&sqf28_'+i+'='+rows[i].sqf28+
								 '&sqf3048_'+i+'='+rows[i].sqf3048+
								 '&runningmeter140_'+i+'='+rows[i].runningmeter140+
								 '&runningmeter150_'+i+'='+rows[i].runningmeter150+
								 '&runningmeter160_'+i+'='+rows[i].runningmeter160+
								 '&runningmeter047_'+i+'='+rows[i].runningmeter047+
								 '&runningmeter050_'+i+'='+rows[i].runningmeter050+
								 '&runningmeter057_'+i+'='+rows[i].runningmeter057+
								 '&ppn_'+i+'='+rows[i].ppn+
								 '&kilo_'+i+'='+rows[i].kilo+
								 '&pieces_'+i+'='+rows[i].pieces+
								 '&brg_harga_'+i+'='+rows[i].brg_harga+
								 '&consumption_m2_'+i+'='+rows[i].consumption_m2+
								 '&cost_'+i+'='+rows[i].cost;
								 /*
				databarang.push({
						"kode_barang":rows[i].kode_barang,
						"consumption_m":rows[i].consumption_m,
						"sqf25":rows[i].sqf25,
						"sqf28":rows[i].sqf28,
						"sqf3048":rows[i].sqf3048,
						"runningmeter140":rows[i].runningmeter140,
						"runningmeter150":rows[i].runningmeter150,
						"runningmeter160":rows[i].runningmeter160,
						"runningmeter047":rows[i].runningmeter047,
						"runningmeter050":rows[i].runningmeter050,
						"runningmeter057":rows[i].runningmeter057,
						"kilo":rows[i].kilo,
						"pieces":rows[i].pieces,
						"consumption_m2":rows[i].consumption_m2,
						"cost":rows[i].cost,
				}); */
			}
			
			$.ajax({
				type	: 'POST',
				url		: "<?php echo site_url(); ?>/cotation/getDataPrint_Upholstery",
				data	: "nArray="+rows.length+'&id_cotation='+id_cotation+pesan,
				cache	: false,
				success	: function(data){
					window.open('<?php echo site_url();?>/cotation/printCost_upholstery/<?php echo $id_cotation; ?>');
				}
			});
			
			
			
		}
		
		function calc(){
			
			var rows = $(dgUpholdstery).datagrid('getChecked');
			var pesan='';
			var id_cotation = '<?php echo $id_cotation ?>';
			var urldet = "<?php echo site_url(); ?>/cotation/Calculation_Component";
			
			for (i=0;i<rows.length;i++){
				pesan += rows[i].seq+'-';
			}
			
			if (pesan!=''){
				//urldet = urldet+"/"+id_cotation+"/"+pesan;
				$(dgUpholdsteryDetail).datagrid({
					onBeforeLoad:function (param){
						param.id_cotation = id_cotation;
						param.pesan = pesan;
					}
				});
			}
		}
		
		
		function upholstery_import(){
			var id_cotation = '<?php echo $id_cotation ?>';
			$("#dialogUp").load('<?php echo base_url();?>index.php/cotation/showUpholstery/'+id_cotation+'/',function(){
				$("#dialogUp").dialog({
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
				
				$('#dialogUp').dialog('open');
			});
		}
		
		
		function update(){
			var pesan='';
			var dg =$(dgUpholdstery);
			var id_cotation = '<?php echo $id_cotation ?>';
			/*
				var win = $.messager.progress({
					title:'Please wait',
					msg:'Updating data...',
					text: 'PROCESSING....'
				});
			*/
			$.map(dg.datagrid('getChecked'), function(row){
				var index = dg.datagrid('getRowIndex', row);
				
				var harga=0;
				var mat_waste=0;
				var kode='';
				
				harga = row.brg_harga;
				mat_waste = row.mat_waste;
				kode = row.material;
				fam = row.material_family
				
				
				$.ajax({
					type	: 'POST',
					url		: "<?php echo site_url(); ?>/cotation/harga_cotation",
					data	: "kode="+kode+"&type=upholstery",
					dataType	: 'json',
					cache	: false,
					success	: function(data){
						var $response=$(data);
						
						if (harga!=$response[0]['harga'] && mat_waste!=$response[0]['mat_waste']){
							//onClickRow(index);
							//alert(fam);
							dg.datagrid('beginEdit',index);
							var ed_mat_waste = dg.datagrid('getEditor', {index:index, field:'mat_waste'});
							var ed_brg_harga = dg.datagrid('getEditor', {index:index, field:'brg_harga'});
							var ed_family = dg.datagrid('getEditor', {index:index, field:'family_id'});
							var ed_kode_barang = dg.datagrid('getEditor', {index:index, field:'kode_barang'});
							
							
							//if (harga!=$response[0]['harga']){
							$(ed_brg_harga.target).numberbox('setValue',$response[0]['harga']);
							//}
							//if (mat_waste!=$response[0]['mat_waste']){
							$(ed_mat_waste.target).numberbox('setValue',$response[0]['mat_waste']);
							//}
							cotation_uphold(index);
							$(ed_family.target).combobox('setValue',fam);
							$(ed_kode_barang.target).combobox('setValue',kode);
							dg.datagrid('endEdit',index);
						}
					}
				});
				 
				//alert(kode);
				
				
				//$(ed_mat_waste.target).numberbox('setValue',mat_waste);
				//$(ed_brg_harga.target).numberbox('setValue',Number(harga));
				//hargaUpholstery(index, kode);
				//$(ed_mat_waste.target).numberbox('setValue','35');
				//var material ='';
				
				
				//dg.datagrid('endEdit',index);
			});
			//$.messager.progress('close');
			
			
			//alert(pesan);
			
		}