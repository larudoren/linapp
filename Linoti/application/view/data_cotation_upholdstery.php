	<script type="text/javascript">
	$(function() {
		$("#dataTable.detail tr:even").addClass("stripe1");
		$("#dataTable.detail tr:odd").addClass("stripe2");
		$("#dataTable.detail tr").hover(
			function() {
				$(this).toggleClass("highlight");
			},
			function() {
				$(this).toggleClass("highlight");
			}
		);
	});
	function edit(id_cotation,seq,komponen1,komponen2,komponen3,family,nama_barang,length,width,height,average_waste,special_waste){
		$("#dlgUphold").dialog('open');
		$("#v_komponen1").val(komponen1);
		$("#v_komponen2").val(komponen2);
		$("#v_komponen3").val(komponen3);
		$("#v_family").combobox('setValue',family);
		$("#v_material").combobox('setValue',nama_barang);
		$("#v_komponen1").focus();
		
	}
	</script>
	<table id="dataTable" class="detail" style="width:1200px;">
		<tr>
			<th rowspan="2" width="1%" hidden="true">No</th>
			<th colspan="3" hidden="true">Component</th>
			<th colspan="2" width="30%" hidden="true">Material</th>
			<th colspan="3" width="12%" hidden="true">Finished Size (mm)</th>
			<th rowspan="2" width="5%" hidden="true">Material Waste (%)</th>
			<th rowspan="2" width="5%" hidden="true">Component Waste (%)</th>
			<th rowspan="2" width="4%" hidden="true">Action</th>
		</tr>
		<tr>
			<th hidden="true"></th>
			<th hidden="true"></th>
			<th hidden="true"></th>
			<th width="10%" hidden="true">Family</th>
			<th width="20%" hidden="true">Name</th>
			<th hidden="true">L</th>
			<th hidden="true">W</th>
			<th hidden="true">H</th>
		</tr>
<?php
	if($data->num_rows()>0){
		$no =1;
		foreach($data->result_array() as $db){  
		?>    
    	<tr>
			<td align="center" width="25px"><?php echo $no; ?></td>
            <td align="left" width="152px"><?php echo $db['komponen1']; ?></td>
            <td align="left" width="152"><?php echo $db['komponen2']; ?></td>
            <td align="left" width="152"><?php echo $db['komponen3']; ?></td>
            <td align="left" width="115px"><?php echo $db['family']; ?></td>
            <td align="left" width="230px"><?php echo $db['nama_barang']; ?></td>
            <td align="right" width="35px"><?php echo $db['length']; ?></td>
            <td align="right" width="48px"><?php echo $db['width']; ?></td>
            <td align="right" width="40px"><?php echo $db['height']; ?></td>
            <td align="right" width="60px"><?php echo $db['average_waste']; ?></td>
            <td align="right" width="65px"><?php echo $db['special_waste']; ?></td>
            <td align="center">
            <a href="javascript:edit('<?php echo $db['id_cotation'];?>','<?php echo $db['seq'];?>','<?php echo $db['komponen1'];?>','<?php echo $db['komponen2'];?>','<?php echo $db['komponen3'];?>','<?php echo $db['family'];?>','<?php echo $db['nama_barang'];?>','<?php echo $db['length'];?>','<?php echo $db['width'];?>','<?php echo $db['height'];?>','<?php echo $db['average_waste'];?>','<?php echo $db['special_waste'];?>')" >
        	<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
        	</a> 
					<a href="<?php echo base_url();?>index.php/cotation/hapus_detail/<?php echo $db['id_cotation'];?>/<?php echo $db['komponen1'];?>" onClick="return confirm('Are you sure want to remove <?php echo $db['komponen1'].' '.$db['komponen2'].' '.$db['komponen3'];?> ?')" >
        	<img src="<?php echo base_url();?>asset/images/del.png" title='Edit'>
        	</a>
            </td>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="13" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
?>
</table>
