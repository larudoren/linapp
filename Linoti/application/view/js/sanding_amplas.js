	var dgSandingAmplas = '#dgSandingAmplas';
	var dgWoodSandingAmplas = '#dgWoodSandingAmplas';
	var dgVenerrSandingAmplas = '#dgVeneerSandingAmplas';
	var sandingStatus = 0;
	
	function wood_cari_harga(index, kode_barang){
		
		var kode = kode_barang;
		var currency=0;
		var harga=0;
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/harga_wood",
			data	: "kode="+kode,
			dataType: 'json',
			cache	: false, 
			success	: function(data){
				var $response=$(data);
				
			
			}
		});
	}
	
	$(dgWoodSandingAmplas).datagrid({
		title: "Total Area Per Wood Type",
		width: 880,
		rownumbers: true,
		singleSelect:true,
		collapsible:true,
		url:"<?php echo site_url(); ?>/cotation/DataWoodSandingAmplas/<?php echo $id_cotation; ?>",
		style:'padding:1px;',
		columns: [
			[
				{
					title:'Wood Type',
					field:'wood_type',
					width:200,
					align:'left'
				},{
					title:'Total Area (m2)',
					field:'total_area',
					width:100,
					align:'right'
				}
			]
		]
	});
	
	$(dgVenerrSandingAmplas).datagrid({
		title: "Total Area Per Veneer Type on Panel",
		width: 880,
		rownumbers: true,
		singleSelect:true,
		collapsible:true,
		url:"<?php echo site_url(); ?>/cotation/DataVeneerSandingAmplas/<?php echo $id_cotation; ?>",
		style:'padding:1px;',
		columns: [
			[
				{
					title:'Veneer Type',
					field:'veneer_type',
					width:200,
					align:'left'
				},{
					title:'Total Area (m2)',
					field:'total_area',
					width:100,
					align:'right'
				}
			]
		]
	});
		
	$(dgSandingAmplas).datagrid({
		title: "Sanding Amplas Cotation",
		width: 880,
		height: 500,
		rownumbers:true,
		singleSelect:true,
		collapsible:true,
		onClickRow: SandingOnClickRow,
		showFooter:true,
		//onRowContextMenu:AccessoriesRowMenu,
		url:"<?php echo site_url(); ?>/cotation/DataSandingAmplas/<?php echo $id_cotation; ?>",
		onLoadSuccess : function(data){
			
		},
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			handler: function(){SandingInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			handler: function(){SandingRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			handler: function(){SandingGetChanges();}
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			handler: function(){SandingReject();} /*
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){SandingPrint();} */
		}],
		columns: [
			[
				{
					field:'id_cotation',
					title:'id_cotation',
					//rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'seq',
					title:'seq',
					//rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					field:'hidebarang',
					title:'hidebarang',
					//rowspan:3,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					title:'Hardware',
					field:'hardware',
					width:250,
					align:'center',
					editor: {
						type: "combobox",
						options: {
							valueField:"kode_barang",
							textField:"nama_barang",
							required:true,
							url:'<?php echo site_url(); ?>/ref_json/DataMaterial1/accessories',
							onSelect: function(rows){
								var tr = $(this).closest('tr.datagrid-row');
								var idx = parseInt(tr.attr('datagrid-row-index')); 
								//var ed_currency = $(dgSandingAmplas).datagrid('getEditor',{index:idx,field:'currency'});
								var ed_hidebarang = $(dgSandingAmplas).datagrid('getEditor',{index:idx,field:'hidebarang'});
								//$(ed_currency.target).val(rows.currency_name);
								$(ed_hidebarang.target).val(rows.kode_barang);
								//SandingCost(rows.currency_name,rows.brg_harga,rows.rates,rows.unit_name);
							}
						}
					}
				},{
					title:'Estimate Area (m2)',
					field:'estimate',
					align:'center',
					width:130,
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
							min:0,
							precision:2,
							required:true,
							onChange : function(newValue,oldValue){
								//var tr = $(this).closest('tr.datagrid-row');
								//var idx = parseInt(tr.attr('datagrid-row-index')); 
								//var ed_quantity = $(dgSandingAmplas).datagrid('getEditor',{index:idx,field:'quantity'});
								//var seq_det = $(ed_seq_det.target).val();
								if (newValue!=oldValue && newValue!='' && sandingStatus!=0){
									SandingTotal();
								}
							}
						}
					}
				},{
					title:'Qty',
					field:'quantity',
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
								if (newValue!=oldValue && newValue!='' && sandingStatus!=0){
									SandingTotal();
								}
							}
						}
					}
				},{
					field:'total',
					title:'Total',
					align:'center',
					formatter:function(value,row,index){
						if (value==0){
							return '';
						} else {
							return value;
						}
					},
					width:70,
					editor: {
						type: "numberbox",
						options:{
							min:0,
							precision:2,
							disabled: true
						}
					}
				}
			]
		]
	});
	
	var SandingEditIndex = undefined;
	
	var vid_cotation = <?php echo $id_cotation; ?>;
	SandingInsertRow = function() {
		
		if (SandingEndEditing()){
			$(dgSandingAmplas).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',quantity:0}});
			SandingEditIndex = 0;
			$(dgSandingAmplas).datagrid('selectRow', SandingEditIndex)
					.datagrid('beginEdit', SandingEditIndex);
			//var ed_currency = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'currency'});
			//$(ed_currency.target).attr('disabled','true');
			sandingStatus = 1;
		}
	};
	
	
	
	function SandingEndEditing(){
		if (SandingEditIndex == undefined){return true}
		if ($(dgSandingAmplas).datagrid('validateRow', SandingEditIndex)){
			$(dgSandingAmplas).datagrid('endEdit', SandingEditIndex);
			SandingEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	
	function SandingOnClickRow(index){
		if (SandingEditIndex != index){
			
			if (SandingEndEditing()){
				$(dgSandingAmplas).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				SandingEditIndex = index;
				
				var ed_seq = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'seq'});
				var ed_hidebarang = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'hidebarang'});
				var ed_sanding_type = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'hardware'});
				//var ed_currency = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'currency'});

				var seq = $(ed_seq.target).val();
				var hidebarang= $(ed_hidebarang.target).val();
				
				//$(ed_currency.target).attr('disabled','true');
				$(ed_sanding_type.target).combobox('select',hidebarang);
				sandingStatus = 1;
			} else{
				$(dgSandingAmplas).datagrid('selectRow', SandingEditIndex);
			}
		}
	}
	
	function SandingRemoveIt(){
		if (SandingEditIndex == undefined){return}
		var ed_seq = $(dgSandingAmplas).datagrid("getEditor", {index:SandingEditIndex, field:'seq'});
		var ed1 = $(dgSandingAmplas).datagrid("getEditor", {index:SandingEditIndex, field:'id_cotation'});
		var seq = $(ed_seq.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Are you sure to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=sanding_amplas",
						cache	: false,
						success	: function(data){
							$(dgSandingAmplas).datagrid('cancelEdit', SandingEditIndex)
								.datagrid('deleteRow', SandingEditIndex);
							$(dgSandingAmplas).datagrid('reload');
							SandingEditIndex = undefined;
							sandingStatus = 0;
						}
					});
				}
			});
		}else{
			$(dgSandingAmplas).datagrid('cancelEdit', SandingEditIndex)
				.datagrid('deleteRow', SandingEditIndex);			
			SandingEditIndex = undefined;
			sandingStatus = 0;
		}
		
	}
	
	function SandingGetChanges(){
		SandingEndEditing();
		var rows = $(dgSandingAmplas).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&hardware_'+i+'='+rows[i].hardware+
								'&estimate_'+i+'='+rows[i].estimate+
								'&quantity_'+i+'='+rows[i].quantity;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_sanding",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgSandingAmplas).datagrid('reload');
				sandingStatus =0;
			}
		});
		
	}
	
	function SandingReject(){
		$(dgSandingAmplas).datagrid('rejectChanges');
		SandingEditIndex = undefined;
		$(dgSandingAmplas).datagrid('reload');
		sandingStatus = 0;
	}
	
	function SandingPrint(){
			window.open('<?php echo site_url();?>/cotation/print_sanding/<?php echo $id_cotation; ?>');
			//return false();
	}
	
	
	function SandingCost(currency,price,rates,unit_name){
		
	//	var ed_harga = $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'brg_harga'});
		if (currency!='Rp'){
			price = Number(price) * Number(rates);
		} else {
		  price = Number(price);
		}
		
		if (price=='')
			price = 0;
		
	//	$(ed_harga.target).numberbox('setValue',price);
		//SandingProductCost();
	}
	
	function SandingTotal(){
	
		var ed_estimate	= $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'estimate'});
		var ed_quantity	= $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'quantity'});
		var ed_total	= $(dgSandingAmplas).datagrid('getEditor',{index:SandingEditIndex,field:'total'});
		
		
		var total = Number($(ed_estimate.target).numberbox('getValue')) * Number($(ed_quantity.target).numberbox('getValue'));
		
		$(ed_total.target).numberbox('setValue',total);
	} 
	