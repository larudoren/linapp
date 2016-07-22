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

	$('#dlgdel').dialog({
		 buttons: [{
				text:'Yes',
				//iconCls:'icon-del',
				handler:function(){
					ok_del($('#hide_sup').val(),$('#hide_kode').val(),$('#hide_tgl').val());
				}
		},{
				text:'No',
				handler:function(){
						$('#dlgdel').dialog('close');
				}
		}]
	});
	
	
	function ok_del(supplier_code,kode_barang,tgl){
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>/supplier_barang/hapus_detail",
			data	: "supplier_code="+supplier_code+"&kode_barang="+kode_barang+'&tgl='+tgl,
			cache	: false,
			success	: function(data){
				$('#dlgdel').dialog('close');
				$.ajax({
					type	: 'POST',
					url		: "<?php echo site_url(); ?>/supplier_barang/DataDetail",
					data	: "kode="+kode_barang,
					cache	: false,
					success	: function(data){
						$("#tampil_data").html(data);
					}
				});
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
	}
	

function funct_del(supplier_code,kode_barang,tgl){
	$('#hide_sup').val(supplier_code);
	$('#hide_kode').val(kode_barang);
	$('#hide_tgl').val(tgl);
	$('#dlgdel').dialog('open');
}
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
<div class="view">
<table id="dataTable" width="100%">
<tr>
	<th>No</th>
	<th>Supplier</th>
	<th>Date</th>
	<th>Min Qty</th>
	<th>Price</th>
	<th>Remarks</th>
	<th>Action</th>
</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		$count = 0;
		foreach($data->result_array() as $db){
			
			if ($db['currency']=='Rp'){
				$harga = number_format($db['harga'],0,',','.');
			} else {
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['harga']);
				$fraction = $db['harga'] - $whole;
				$fraction_str = ''.number_format($db['harga'], 3,',','.');
							
		
								
				if ($fraction > 0){
					if(substr($fraction_str,-1)!='0'){
						$harga = number_format($db['harga'],3,',','.');
					} elseif(substr($fraction_str,-2,1)!='0'){
						$harga = number_format($db['harga'],2,',','.');
					} else {
						$harga = number_format($db['harga'],1,',','.');
					}
				} else {
					$harga = number_format($db['harga'],0,',','.');
				}
			}
			
			$tanggal = DateTime::createFromFormat('Y-m-d', $db['tgl'])->format('d-M-Y');
			
		?>    
    	<tr>
				<td align="center"><?php echo $no.'.'; ?></td>
				<td><?=$db['supplier_name']?></td>
				<td align="center"><?=$tanggal?></td>
				<td align="center"><?=$db['min_qty'].' '.$db['unit_name']?></td>
				<td align="right"><?=$db['currency'].'  '.$harga?></td>
				<td><?=$db['remarks']?></td>
				<td align="center">
					<!--
					<a id="aedit" name="aedit" href="javascript:void(0)" onclick="funct_edit(<?=$db['supplier_code']?>,<?=$tgl?>);">
						<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
					</a>-->
					<a id="aedit" name="aedit" href="javascript:void(0);"
            onClick="funct_del('<?=$db['supplier_code']?>','<?=$db['kode_barang']?>','<?=$db['tgl']?>');">
						<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
					</a>
        </td>
    </tr>
    <?php
		$no++;
		}
	}else{
		$count=0;
	?>
    	<tr>
        	<td colspan="11" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
</div>

<div id="dlgdel" align="center" class="easyui-dialog" title="Confirmation" style="width:250px;height:120px;padding:10px;" data-options="modal:true,closed:true">
	Are you sure want to delete the data?
	<input type="text" id="hide_sup" name="hide_sup" hidden="true" />
	<input type="text" id="hide_kode" name="hide_kode" hidden="true" />
	<input type="text" id="hide_tgl" name="hide_tgl" hidden="true" />
</div>
