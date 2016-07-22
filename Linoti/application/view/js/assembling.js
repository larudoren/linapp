	var dgAssembling = '#dgAssembling';
	var dgInOut= '#dgIndoorOutdoor';
	var panAssembling = '#panAssembling';
	var accessoriesStatus = 0;
	function wood_cari_harga(index, kode_barang){
		/*
		var ed_currency = $("#dgAssembling").datagrid("getEditor", {index:index, field:'currency'});
		var ed_harga = $("#dgAssembling").datagrid("getEditor", {index:index, field:'brg_harga'});
		var ed_lengthunit = $("#dgAssembling").datagrid("getEditor", {index:index, field:'length_unit'}); */
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
					/*
					$(ed_currency.target).val($response[0]['currency']);
					$(ed_harga.target).numberbox('setValue',$response[0]['harga']);
					$(ed_lengthunit.target).val($response[0]['length_unit']); */
			
			}
		});
	}
	
	//$('<div><input type="radio" name="AssCheck" id="AssCheck" value="0">Outdoor</div><div><input type="radio" name="AssCheck" id="AssCheck" value="1">Indoor</div>').prependTo('#assembling');
	/*$(panAssembling).panel({
		width: 980,
		title:'Cotation Assembling',
		height: 500,
		//href:"views/cotation/assembling.php",
		collapsible:true,
		//content:'<form name="data" id="data"><table id="dataTable"><tr><td colspan="2" width="980"><input type="radio" name="AssCheck" value="0"/>Outdoor</td></tr><tr class="trOut"><td width="20px">&nbsp;</td><td width="980">Testing</td></tr><tr><td colspan="2"><input type="radio" name="AssCheck" value="1">Indoor</td></tr><tr class="trInCheck"><td width="20px">&nbsp;</td><td><input type="radio" name="InCheck" value="0">Harian</td></tr><tr class="trInCheck"><td width="20px">&nbsp;</td><td><input type="radio" name="InCheck" value="1">Borongan</td></tr><tr><td colspan="2"><input type="radio" name="AssCheck" value="2">Indoor + Outdoor</td></tr></table></form>'
	});*/
	//$(panAssembling).panel('refresh','views/cotation/assembling.php');
	
	
	
	$('tr.trInCheck').hide();
	$('tr.trOut').hide();
	
	
	
	
	$( "input[type=radio][name=AssType]" ).on( "click", function(){
		var MyOption = $('input[type=radio][name=AssType]:checked').val();
		if (MyOption=='Indoor'){
			$('tr.trindoor').show();
			$('tr.trass').hide();
			//$('tr.trinoutdoor').hide();
			
		} else if (MyOption=='Outdoor') {
			$('tr.trindoor').hide();
			$('tr.trass').show();
			//$('tr.trinoutdoor').hide();
			//AssemblingDgButtonEnable();
		} else {
			$('tr.trindoor').hide();
			$('tr.trass').show();
			//$('tr.trinoutdoor').show();
			//AssemblingDgButtonEnable();
		}
		//AssemblingReject();
		AssemblingCustomGrid(MyOption);
		//AssemblingReject();
	}); 
	
	$( "input[type=radio][name=IndoorType]" ).on( "click", function(){
		//AssemblingReject();
		AssemblingCustomGrid('Indoor');
		
		if ($('input[type=radio][name=IndoorType]:checked').val()=='Harian' /* || $('input[type=radio][name=IndoorType]:checked').val()=='' */){ 
			
			AssemblingDgButtonDisable();
			//$('#AssInsert').linkbutton('disable');
			//$('#AssRemove').linkbutton('disable');
			//$('#AssCancel').linkbutton('disable');
		} else { 
			AssemblingDgButtonEnable();
			//$('#AssInsert').linkbutton('enable');
			//$('#AssRemove').linkbutton('enable');
			//$('#AssCancel').linkbutton('enable');
		}
		
		//AssemblingReject();
	});
	
	$(dgInOut).datagrid({
		title: "Assembling Outdoor Cotation",
		width: 920,
		height: 300,
		rownumbers:true,
		singleSelect:true,
		collapsible:true,
		onClickRow: AssemblingOnClickRow,
		showFooter:true,
		//onRowContextMenu:AccessoriesRowMenu,
		url:"<?php echo site_url(); ?>/cotation/DataAssembling/<?php echo $id_cotation; ?>/", 
		onLoadSuccess : function(data){
			if ($('input[type=radio][name=AssType]:checked').val()=='Indoor' && $('input[type=radio][name=IndoorType]:checked').val()=='Harian'){
				AssemblingInsertHarian();
			}
		},
		onBeforeLoad : function(param){
			param.asstype = $('input[type=radio][name=AssType]:checked').val();
			param.indoortype = $('input[type=radio][name=IndoorType]:checked').val();
		},
		style:'padding:1px;',
		toolbar: [{
			iconCls: 'icon-add',
			text :'Insert',
			id :'AssInsert',
			handler: function(){AssemblingInsertRow();}
		},'-',{
			iconCls: 'icon-remove',
			text :'Remove',
			id :'AssRemove',
			handler: function(){AssemblingRemoveIt();}
		},'-',{
			iconCls: 'icon-save',
			text :'Save',
			id :'AssSave',
			handler: function(){AssemblingGetChanges();} 
		},'-',{
			iconCls: 'icon-undo',
			text :'Cancel',
			id :'AssCancel',
			handler: function(){AssemblingReject();}/*
		},'-',{
			iconCls: 'icon-print',
			text :'Print',
			handler: function(){AssemblingPrint();} */
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
					field:'hidebarang',
					title:'hidebarang',
					rowspan:2,
					hidden:true,
					editor: {
						type: "validatebox"
					}
				},{
					title:'Component',
					colspan:2,
					align:'center'
				},{
					title:'Quantity',
					field:'quantity',
					width:70,
					rowspan:2,
					align:'center',
					editor: {
						type: "numberbox",
						options : {
							required : true
						}
					}
				},{
					title:'Supplier',
					field:'supplier',
					width:250,
					rowspan:2,
					align:'center',
					editor : {
						type : 'validatebox',
						options : {
							required : true
						}
					}
				},{
					title:'Price',
					field:'price',
					width:100,
					rowspan:2,
					align:'center',
					formatter : function(value,row,index){
						return 'Rp. '+value;
					},
					editor : {
						type : 'numberbox',
						options :{
							precision :0,
							min:0,
							required : true,
							prefix:'Rp',
							groupSeparator:','
						}
					}
				},{
					title:'Date',
					field:'date',
					width:100,
					rowspan:2,
					align:'center',
					editor : {
						type : 'datebox',
						options :{
							formatter : myformatter,
							required : true,
							parser:myparser
						}
					}
				}
			],[
				{
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
				}
			]
		]
	});
	
	var AssemblingEditIndex = undefined;
	
	var vid_cotation = <?php echo $id_cotation; ?>;
	AssemblingInsertRow = function() {
		//var asstype = $('input[type=radio][name=AssType]:checked').val();
		//var indoortype = $('input[type=radio][name=IndoorType]:checked').val();
		
		if (AssemblingEndEditing()){
			//if ((asstype=='Indoor' && indoortype!='') || (asstype!='Indoor' && asstype!='')){
			$(dgInOut).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:''}});
			AssemblingEditIndex = 0;
			$(dgInOut).datagrid('selectRow', AssemblingEditIndex)
					.datagrid('beginEdit', AssemblingEditIndex);
			var ed_price = $(dgInOut).datagrid('getEditor',{index: AssemblingEditIndex, field: 'price'});
			$(ed_price.target).numberbox('enable');
			//}
		}
	};
	
	function AssemblingEndEditing(){
		if (AssemblingEditIndex == undefined){return true}
		if ($(dgInOut).datagrid('validateRow', AssemblingEditIndex)){
			$(dgInOut).datagrid('endEdit', AssemblingEditIndex);
			AssemblingEditIndex = undefined;
			return true;
		} else {
			return false;
		}
	}

	function AssemblingDgButtonDisable(){
		$('#AssInsert').linkbutton('disable');
		$('#AssRemove').linkbutton('disable');
		//$('#AssSave').linkbutton('disable');
		$('#AssCancel').linkbutton('disable');
	}
	function AssemblingDgButtonEnable(){
		$('#AssInsert').linkbutton('enable');
		$('#AssRemove').linkbutton('enable');
		//$('#AssSave').linkbutton('enable');
		$('#AssCancel').linkbutton('enable');
	}
	
	function AssemblingInsertHarian(){
		var row = $(dgInOut).datagrid('getRows');
		var temp = 0;
		for (i=0;i<row.length;i++){
			if (row[i].indoortype=='Harian'){
				temp=temp+1;
			}
		}
		if (temp==0){
			$(dgInOut).datagrid('insertRow',{index:0,row:{id_cotation:vid_cotation,seq:'',price:0,comp_name1:'',comp_name2:'',quantity:0,date:''}});
			AssemblingEditIndex = 0;
			$(dgInOut).datagrid('selectRow', AssemblingEditIndex)
				.datagrid('beginEdit', AssemblingEditIndex);
			var ed_price = $(dgInOut).datagrid('getEditor',{index: AssemblingEditIndex, field: 'price'});
			$(ed_price.target).numberbox('disable');
		}
		
	}

	function AssemblingRemoveIt(){
		if (AssemblingEditIndex == undefined){return}
		var ed_seq = $(dgInOut).datagrid("getEditor", {index:AssemblingEditIndex, field:'seq'});
		var ed1 = $(dgInOut).datagrid("getEditor", {index:AssemblingEditIndex, field:'id_cotation'});
		var seq = $(ed_seq.target).val();
		var id_cotation = $(ed1.target).val();
		if (seq!=''){
			$.messager.confirm('Confirm', 'Do you want to delete this record?', function(r){
				if (r){
					$.ajax({
						type	: 'POST',
						url		: "<?php echo site_url(); ?>/cotation/hapus_cotation",
						data	: "id_cotation="+id_cotation+"&seq="+seq+"&type=assembling",
						cache	: false,
						success	: function(data){
							$(dgInOut).datagrid('cancelEdit', AssemblingEditIndex)
								.datagrid('deleteRow', AssemblingEditIndex);
							$(dgInOut).datagrid('reload');
							AssemblingEditIndex = undefined;
							//accessoriesStatus = 0;
						}
					});
				}
			});
		}else{
			$(dgInOut).datagrid('cancelEdit', AssemblingEditIndex)
				.datagrid('deleteRow', AssemblingEditIndex);			
			AssemblingEditIndex = undefined;
			//accessoriesStatus = 0;
		}
		
	}
	
	function AssemblingReject(){
		$(dgInOut).datagrid('rejectChanges');
		AssemblingEditIndex = undefined;
		$(dgInOut).datagrid('reload');
		//accessoriesStatus = 0;
	}
	
	function AssemblingGetChanges(){
		AssemblingEndEditing();
		var rows = $(dgInOut).datagrid('getChanges');
		var temp = [];
		var pesan ='';
		var asstype = $('input[type=radio][name=AssType]:checked').val();
		var indoortype = $('input[type=radio][name=IndoorType]:checked').val();
		//var rows = $(dgInOut).datagrid('getChanges');
		//if (asstype=='Indoor' && indoortype=='Harian'){
		//	rows = $(dgInOut).datagrid('getChanges','inserted');
		//}
		if (asstype!='Indoor'){
			indoortype = '';
		}
		
		for (i=0;i<rows.length;i++){
			pesan += '&id_cotation_'+i+'='+rows[i].id_cotation+
								'&seq_'+i+'='+rows[i].seq+
								'&comp_name1_'+i+'='+rows[i].comp_name1+
								'&comp_name2_'+i+'='+rows[i].comp_name2+
								'&quantity_'+i+'='+rows[i].quantity+
								'&asstype_'+i+'='+asstype+
								'&indoortype_'+i+'='+indoortype+
								'&supplier_'+i+'='+rows[i].supplier+
								'&date_'+i+'='+rows[i].date+
								'&harga_'+i+'='+rows[i].price;
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/cotation/simpan_assembling",
			data	: "nArray="+rows.length+pesan,
			cache	: false,
			success	: function(data){
				$(dgInOut).datagrid('reload');
				//accessoriesStatus =0;
			}
		});
		
	}
	
	function AssemblingOnClickRow(index){
		if (AssemblingEditIndex != index){
			var asstype = $('input[type=radio][name=AssType]:checked').val();
			var indoortype = $('input[type=radio][name=IndoorType]:checked').val();
			if (asstype!='Indoor'){
				indoortype='';
			}
			if (AssemblingEndEditing() && asstype!='' && ((asstype!='Indoor') || (asstype=='Indoor' && indoortype!='Harian'))){
				$(dgInOut).datagrid('selectRow', index)
							.datagrid('beginEdit', index);
				AssemblingEditIndex = index;
				
				//accessoriesStatus = 1;
			} else{
				$(dgInOut).datagrid('selectRow', AssemblingEditIndex);
			}
		}
	}
	
	function AssemblingCustomGrid(MyOption){
	  var temp = 0;
		var dg = $(dgInOut);
		var op_comp_name1 = dg.datagrid('getColumnOption','comp_name1');
		var op_quantity = dg.datagrid('getColumnOption','quantity');
		var op_supplier = dg.datagrid('getColumnOption','supplier');
		var op_date = dg.datagrid('getColumnOption','date');
		//AssemblingReject();
		if (MyOption=='Outdoor'){
			//dg.datagrid('reload');
			$(dgInOut).datagrid('hideColumn','quantity');
			$(dgInOut).datagrid('hideColumn','comp_name1');
			$(dgInOut).datagrid('hideColumn','comp_name2');
			$(dgInOut).datagrid('showColumn','supplier');
			$(dgInOut).datagrid('showColumn','date');
			//dg.options('title','Assembling Outdoor Cotation');
			//options.title('Assembling Outdoor Cotation');
			dg.datagrid({title:'Assembling Outdoor Cotation'});
			op_comp_name1.editor.options.required = false;
			op_quantity.editor.options.required = false;
			//$(op_comp_name1.editor.options)[0].required = false;
			//$(op_quantity.editor.options)[0].required = false;
			AssemblingDgButtonEnable();
		} else if (MyOption=='Indoor'){
			//dg.datagrid('reload');
			$(dgInOut).datagrid('hideColumn','quantity');
			$(dgInOut).datagrid('hideColumn','comp_name1');
			$(dgInOut).datagrid('hideColumn','comp_name2');
			//dg.options('title','Assembling Indoor Cotation');
			//options.title('Assembling Indoor Cotation');
			op_quantity.editor.options.required = false;
			op_comp_name1.editor.options.required = false;
			dg.datagrid({title:'Assembling Indoor Cotation'});
			if ($('input[type=radio][name=IndoorType]:checked').val()=='Harian'){
				$(dgInOut).datagrid('hideColumn','supplier');
				$(dgInOut).datagrid('hideColumn','date');
				op_supplier.editor.options.required = false;
				op_date.editor.options.required = false;
				AssemblingDgButtonDisable(); 
				//$('#AssInsert').linkbutton('disable');
				//$('#AssRemove').linkbutton('disable');
				//$('#AssCancel').linkbutton('disable');
			} else {
				$(dgInOut).datagrid('showColumn','supplier');
				$(dgInOut).datagrid('showColumn','date');
				op_supplier.editor.options.required = true;
				op_date.editor.options.required = true;
				AssemblingDgButtonEnable();
				//$('#AssInsert').linkbutton('enable');
				//$('#AssRemove').linkbutton('enable');
				//$('#AssCancel').linkbutton('enable');
			} 
		} else {
			//dg.datagrid('reload');
			$(dgInOut).datagrid('showColumn','quantity');
		  $(dgInOut).datagrid('showColumn','comp_name1');
			$(dgInOut).datagrid('showColumn','comp_name2');
			$(dgInOut).datagrid('showColumn','supplier');
			$(dgInOut).datagrid('showColumn','date');
			dg.datagrid({title:'Assembling Indoor + Outdoor Cotation'});
			temp = 1;
			op_comp_name1.editor.options.required = true;
			op_quantity.editor.options.required = true;
		//	$(op_comp_name1.editor.options)[0].required = true;
			//$(op_quantity.editor.options)[0].required = true;
			AssemblingDgButtonEnable();
		}
		
		
		
    var dc = dg.data('datagrid').dc;
    var fields = dg.datagrid('getColumnFields');
    var vcount = 0;
    $.map(fields, function(field){
        var col = dg.datagrid('getColumnOption', field);
        if ((!col.hidden && (field=='comp_name1' || field=='comp_name2')) || (col.hidden && (field=='comp_name1' || field=='comp_name2'))){
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

	}
	
	if ($('input[type=radio][name=AssType]:checked').val()!='Indoor'){
		$('tr.trindoor').hide();
		$('tr.trass').show();
		AssemblingCustomGrid($('input[type=radio][name=AssType]:checked').val());
	} else if ($('input[type=radio][name=AssType]:checked').val()=='Indoor') {
		$('tr.trindoor').show();
		$('tr.trass').hide();
		AssemblingCustomGrid('Indoor');
		if ($('input[type=radio][name=IndoorType]:checked').val()=='Harian'){
			AssemblingDgButtonDisable();
		} else if ($('input[type=radio][name=IndoorType]:checked').val()=='Borongan'){
			AssemblingDgButtonEnable();
		}
	}
	
	