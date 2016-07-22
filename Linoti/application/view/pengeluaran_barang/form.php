<script type="text/javascript">
$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	
	tampil_data();
	
	function tampil_data(){
		var kode = $("#kode_keluar").val();
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pengeluaran_barang/DataDetail",
			data	: "kode="+kode,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
			}
		});
		//return false();
	}
	
	$("#tgl").datepicker({
			dateFormat:"yy-mm-dd"
    });
	
	$("#nama_brg").focus();
	/*
	$("#kode_brg").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$("#kode_brg").focus(function(e){
		var isi = $(e.target).val();
		CariBarang();
	});
	
	$("#kode_brg").keyup(function(){
		CariBarang();
		
	});
	*/
	function CariBarang(){
		var kode = $("#kode_brg").val();
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/InfoTerima",
			data	: "kode="+kode,
			cache	: false,
			dataType : "json",
			success	: function(data){
				$("#nama_brg").val(data.nama_barang);
				$("#satuan").val(data.satuan);
				$("#harga").val(data.harga);
			}
		});
	}
	
	$("#harga").keypress(function(data){
		if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			return false;
		}
	});
	//$("#jml").keypress(function(data){
		//if (data.which!=8 && data.which!=0 && (data.which<48 || data.which>57)) {
			//return false;
		//}
	//});
	
	function hitung(){
		var jml = $("#jml").val();
		var harga = $("#harga").val();
		
		var total = parseInt(jml)*parseInt(harga);
		$("#total").val(total);
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga").keyup(function(){
		hitung();
	});
	
	$("#simpan").click(function(){
		var kode	= $("#kode_keluar").val();
		var tgl		= $("#tgl").val();
		var nama_brg	= $("#nama_brg").combogrid('getValue');
		var jml	= $("#jml").val();
		var total		= $("#total").val();
		var departemen		= $("#departemen").val();
		var pi		= $("#pi").val();
		var receiver		= $("#receiver").val();
		
		var string = $("#form").serialize();
		
		if(nama_brg.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Material cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#nama_brg").focus();
			return false;
		}
		if(departemen.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Departement cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#departemen").focus();
			return false;
		}
		if(pi.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, PI cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#pi").focus();
			return false;
		}
		if(receiver.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Receiver cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#receiver").focus();
			return false;
		}
		if(jml.length==0){
			$.messager.show({
				title:'Info',
				msg:'Sorry, Quantity cannot leave empty', 
				timeout:2000,
				showType:'show'
			});
			$("#jml").focus();
			return false;
		}
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/pengeluaran_barang/simpan",
			data	: string+'&nama_brg='+nama_brg,
			cache	: false,
			success	: function(data){
				$.messager.show({
					title:'Info',
					msg:data, 
					timeout:2000,
					showType:'slide'
				});
				tampil_data();
			},
			error : function(xhr, teksStatus, kesalahan) {
				$.messager.show({
					title:'Info',
					msg: 'Server not respond :'+kesalahan,
					timeout:2000,
					showType:'slide'
				});
			}
		});
		return false();		
	});
	
	$("#tambah_data").click(function(){
		$(".detail").val('');
		//$("#kode_brg").val('');
		$("#nama_brg").val('');
		$("#nama_brg").focus();
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kode_keluar").val();
		window.open('<?php echo site_url();?>/pengeluaran_barang/cetak/'+kode);
		return false();
	});
	
	$("#cari_barang").click(function(){
		AmbilDaftarBarang();
		$("#dlg").dialog('open');
	});
	
	$("#txt_cari").keyup(function(){
		AmbilDaftarBarang();
		//$("#dlg").dialog('open');
	});
	
	function AmbilDaftarBarang(){
		var cari = $("#txt_cari").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/ref_json/DataTerima",
			data	: "cari="+cari,
			cache	: false,
			success	: function(data){
				$("#daftar_barang").html(data);
			}
		});
	}
});	
</script>
<table width="100%">
<tr>
<td valign="top" width="50%">
<form name="form" id="form">
    <fieldset>
    <table width="100%">
    <tr>    
        <td width="150">Code</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_keluar" id="kode_keluar" size="12" readonly="readonly" value="<?php echo $kode_keluar;?>" /></td>
    </tr>
    <tr>
        <td>Date</td>
        <td>:</td>
        <td><input type="text" name="tgl" id="tgl"  size="12" value="<?php echo $tgl_keluar;?>"/></td>
    </tr>
	<tr>    
        <td>Departement</td>
        <td>:</td>
        <td>
			<select name="departemen" id="departemen">
				<?php 
				if(empty($departemen)){
				?>
				<option value="">-SELECT-</option>
				<?php
				}
				foreach($l_dept->result() as $t){
					if($departemen==$t->dept_code){
				?>
				<option value="<?php echo $t->dept_code;?>" selected="selected"><?php echo $t->dept_name;?></option>
				<?php }else { ?>
				<option value="<?php echo $t->dept_code;?>"><?php echo $t->dept_name;?></option>
				<?php }
				} ?>
			</select>
		</td>
    </tr>
	<tr>    
        <td width="150">Porforma Invoice</td>
        <td width="5">:</td>
        <td><input type="text" name="pi" id="pi" size="21" value="<?php echo $pi;?>" /></td>
    </tr>
	<tr>    
        <td>Customer</td>
        <td>:</td>
        <td>
		<select name="customer" id="customer">
				<?php 
				if(empty($customer)){
				?>
				<option value="--">-SELECT-</option>
				<?php
				}
				foreach($l_cust->result() as $f){
					if($customer==$f->cust_code){
				?>
				<option value="<?php echo $f->cust_code;?>" selected="selected"><?php echo urldecode($f->cust_name);?></option>
				<?php }else { ?>
				<option value="<?php echo $f->cust_code;?>"><?php echo urldecode($f->cust_name);?></option>
				<?php }
				} ?>
		</select>
		</td>
    </tr>
	<tr>    
        <td width="150">Receiver</td>
        <td width="5">:</td>
        <td><input type="text" name="receiver" id="receiver" size="20" value="<?php echo $receiver;?>" /></td>
    </tr>
    </table>
    </fieldset>
</td>
<td valign="top" width="50%">
    <fieldset class="atas">
    <table width="100%"><!-- 
    <tr>    
        <td width="150">Kode Barang</td>
        <td width="5">:</td>
        <td><input type="text" name="kode_brg" id="kode_brg" size="17" maxlength="15" class="easyui-validatebox" data-options="required:true,validType:'length[13,15]'" />
        <!--<button type="button" name="cari_barang" id="cari_barang" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Cari</button> 
        </td>
    </tr> -->
    <tr>    
        <td>Material</td>
        <td>:</td>
        <td>
					<select name="nama_brg" id="nama_brg"  style="width:200px" class="easyui-combogrid" data-options="
						panelWidth: 500,
						panelHeight: 400,
						idField: 'kode_barang',
						textField: 'nama_barang',
						url: '<?php echo site_url(); ?>/ref_json/DataBarang1',
						method: 'post',
						mode:'remote',
						columns: [[
							{field:'kode_barang',title:'Kode Barang',width:80, hidden:true},
							{field:'kode_lama',title:'Kode Lama',width:120, hidden:true},
							{field:'nama_barang',title:'Nama Barang',width:200},
							{field:'unit_name',title:'Unit',width:80},
							{field:'dept_name',title:'Departemen',width:150}
						]],
						fitColumns: true,
						filter: function(q, row){
							var opts = $(this).combogrid('options');
							return row[opts.textField].indexOf(q) == 0;
						},
						pagination:true"/>
				</td>
<script type="text/javascript">
		(function($){
            function pagerFilter(data){
                if ($.isArray(data)){    // is array
                    data = {
                        total: data.length,
                        rows: data
                    }
                }
                var dg = $(this);
                var state = dg.data('datagrid');
                var opts = dg.datagrid('options');
                if (!state.allRows){
                    state.allRows = (data.rows);
                }
                var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
                var end = start + parseInt(opts.pageSize);
                data.rows = $.extend(true,[],state.allRows.slice(start, end));
                return data;
            }
						
					
						
            var loadDataMethod = $.fn.datagrid.methods.loadData;
            $.extend($.fn.datagrid.methods, {
                clientPaging: function(jq){
                    return jq.each(function(){
                        var dg = $(this);
                        var state = dg.data('datagrid');
                        var opts = state.options;
                        opts.loadFilter = pagerFilter;
                        var onBeforeLoad = opts.onBeforeLoad;
                        opts.onBeforeLoad = function(param){
                            state.allRows = null;
                            return onBeforeLoad.call(this, param);
                        }
                        dg.datagrid('getPager').pagination({
														showPageList:false,
														//buttons: $('#mbuttons').clone(),
                            onSelectPage:function(pageNum, pageSize){
                                opts.pageNumber = pageNum;
                                opts.pageSize = pageSize;
                                $(this).pagination('refresh',{
                                    pageNumber:pageNum,
                                    pageSize:pageSize
                                });
                                dg.datagrid('loadData',state.allRows);
                            }
                        });
                        $(this).datagrid('loadData', state.data);
                        if (opts.url){
                            $(this).datagrid('reload');
                        }
                    });
                },
                loadData: function(jq, data){
                    jq.each(function(){
                        $(this).data('datagrid').allRows = null;
                    });
                    return loadDataMethod.call($.fn.datagrid.methods, jq, data);
                },
                getAllRows: function(jq){
                    return jq.data('datagrid').allRows;
                }
            })
        })(jQuery);
        
        $(function(){
            var grid = $('#nama_brg').combogrid('grid');
						var page = grid.datagrid('getPager');
						//page.pagination({buttons:$('#mbuttons').clone()});
						//alert(page.next().toSource());
						
						grid.datagrid({
							onSelect:function(index, row){
								//$('#kode_brg').val(row.kode_barang);
								$('#satuan').val(row.unit_name);
							}
						}); 
						grid.datagrid('clientPaging');
						
        });
				
		
	</script>
    </tr>
    <tr>    
        <td>Unit</td>
        <td>:</td>
        <td><input type="text" name="satuan" id="satuan"  size="20" class="detail" maxlength="20" readonly="readonly"/></td>
    </tr>
    <tr>    
        <td>Quantity</td>
        <td>:</td>
        <td><input type="text" name="jml" id="jml"  size="20" class="detail" maxlength="20"/></td>
    </tr>
		<tr>    
        <td>Remarks</td>
        <td>:</td>
        <td><input type="text" name="remarks" id="remarks" class="detail" size="20" maxlength="20" /></td>
    </tr>
		<tr>    
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
		<tr>    
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
		<tr>    
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </table>
    </fieldset>
</td>
</tr>
</table>    
<fieldset class="bawah">
<table width="100%">
<tr>
	<td colspan="3" align="center">
	<button type="button" name="tambah_data" id="tambah_data" class="easyui-linkbutton" data-options="iconCls:'icon-add'">ADD</button>
    <button type="button" name="simpan" id="simpan" class="easyui-linkbutton" data-options="iconCls:'icon-save'">SAVE</button>
    <button type="button" name="cetak" id="cetak" class="easyui-linkbutton" data-options="iconCls:'icon-print'">PRINT</button>
    <a href="<?php echo base_url();?>index.php/pengeluaran_barang/">
    <button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-logout'">CLOSE</button>
    </a>
    </td>
</tr>
</table>  
</fieldset>   
</form>
<fieldset>
<div id="tampil_data"></div>
</fieldset>
<div id="dlg" class="easyui-dialog" title="Daftar Barang" style="width:900px;height:400px; padding:5px;" data-options="closed:true">
	Search : <input type="text" name="txt_cari" id="txt_cari" size="50" />
	<div id="daftar_barang"></div>
</div> <!--
<div id="mbuttons" name="mbuttons" style="display:none" align="right">
        
     <span><input class="easyui-searchbox" name="btncaribrg" id="btncaribrg" style="width:150px"></span>
         
 </div> -->