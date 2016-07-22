<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>-->
<script type="text/javascript" src="<?=base_url('asset/js/jquery.mousewheel-3.0.4.pack.js')?>"></script>
<!--<script type="text/javascript" src="<?=base_url('asset/js/jquery.min.js')?>"></script> -->
<script type="text/javascript" src="<?=base_url('asset/js/jquery.fancybox-1.3.4.pack.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('asset/css/jquery.fancybox-1.3.4.css')?>" media="screen" />
<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
</script>
<script type="text/javascript">
		$(document).ready(function() { 
			$("a#example6").fancybox({
				'titlePosition'		: 'inside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9,
				'closeClick'			: false,
				'autoDimenstions'	: true, 
				'closeButton'			: true,
				'border'					: true,
				'hideOnOverlayClick' : false,
			}); 
			
			$("a.picture").click(function (e){
				e.preventDefault();
				//$("#popfoto").attr('width','260px');
				//$("#popfoto").load($(this).attr('href'));
				$(this).fancybox({
				  'titlePosition'		: 'inside',
					'overlayColor'		: '#000',
					'autoDimenstions'	: true,
					'overlayOpacity'	: 0.9,
					'closeClick'			: false,
					'href'						: $(this).href,
					'closeButton'			: true,
					'width'						: '260px', /*
					'height'					: 340, */
					'hideOnOverlayClick' : false,
					'title' : $(this).attr('title')
				});
				//return false(); */
			});

		});
	</script>
<script>
	
</script>
<div id="view">
<?php
//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
?>
<div style="float:left; padding-bottom:5px;">
<a href="<?=site_url('barang/tambah')?>">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<a href="<?=site_url('barang')?>">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<a href="<?=site_url('barang/clear')?>">
<button type="button" class="easyui-linkbutton" >Clear search result</button>
</a>

</div>
<?php
//}
?>
<!--
<br/><div style="float:left; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url('index.php/barang');?>">
Code database Linoti : 
&nbsp;&nbsp;&nbsp; Name : 
&nbsp;&nbsp;&nbsp; Department : 
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div> -->

<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">

<tr>
	<form name="form" method="post" action="<?php echo base_url('index.php/barang');?>">
	<td></td>
	<td><input type="text" name="code_cari" id="code_cari" size="10" value="<?=$this->session->userdata('barang_code_cari')?>" /></td>
	<td></td>
	<td><input type="text" name="name_cari" id="name_cari" size="45" value="<?=$this->session->userdata('barang_name_cari')?>" /></td>
	<td><input type="text" name="unit_cari" id="unit_cari" size="10" value="<?=$this->session->userdata('barang_unit_cari')?>" /></td>
	<td><input type="text" name="type_cari" id="type_cari" size="15" value="<?=$this->session->userdata('barang_type_cari')?>" /></td>
	<td><input type="text" name="finish_cari" id="finish_cari" size="20" value="<?=$this->session->userdata('barang_finish_cari')?>" /></td>
	<td><input type="text" name="dept_cari" id="dept_cari" size="25" value="<?=$this->session->userdata('barang_dept_cari')?>" /></td>
	<td></td>
	<td></td>
	<td><button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button></td>
	</form>
</tr> <!--
<tr height="15">
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr> -->
<tr>
	<th>No</th>
    <!--<th><font size="1">Database Code</font></th>-->
    <th>Code</th>
    <th>Photo</th>
    <th>Name</th>
    <th>Unit</th>
    <th>Type</th>
    <th>Finishing</th>
    <th>Department</th>
    <th>Live Stok</th>
    <th>Dead Stok</th>
    <th>Position</th>
	<?php
		//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
	?>
    <th>Action</th>
	<?php
		//}
	?>
</tr>
<?php
	$awal = date('Y-m-01');
	$sekarang = date('Y-m-d');
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){
			$stok = $this->app_model->CariLiveStock($db['kode_barang'], $awal, $sekarang);
			$stokmati = $this->app_model->CariDeadStock($db['kode_barang'], $awal, $sekarang);
			if($db['foto_barang']=="") {
				$foto = base_url('asset/foto_produk/unknown.jpg');
			} else {
				$foto = base_url('asset/foto_produk/'.$db['foto_barang']);
			}
			$position='';
			if ($db['pos_rack']!=''){
				$position = $db['pos_rack'];
				if ($db['pos_row']!='' && $db['pos_column']!=''){
					$position .= '.'.$db['pos_row'].'.'.$db['pos_column'];
				}
			}
		?>    
    	<tr>
			<td align="center"><?=$no?></td>
           <!-- <td width="70" align="center"><font size="1"><?=$db['kode_barang']?></font></td>-->
            <td width="10" align="center"><?=$db['kode_barang_spc']?></td>
            <td align="center"><a id="example6" class="picture" href="<?=$foto?>" title="<?=$db['nama_barang']?>"><img src="<?=$foto?>" width="60px" /></a></td>
            <td width="45"><?=$db['nama_barang']?></td>
            <td width="10" align="center"><?=$db['unit_name']?></td>
            <td width="15"align="center"><?=$db['type']?></td>
            <td width="20" align="center"><?=$db['finishing']?></td>
            <td width="25" align="left"><?=$db['dept_name']?></td>
            <td align="center"><?=$stok?></td>
            <td align="center"><!--<?=$stokmati?>--></td>
            <td align="center"><?=$position?></td>
			<?php
			//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
			?>
            <td width="10" align="center">
            <a href="<?php echo base_url();?>index.php/barang/edit/<?php echo $db['kode_barang'];?>/<?php echo $hal; ?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/barang/hapus/<?php echo $db['kode_barang'];?>/<?php echo $hal; ?>"
            onClick="return confirm('Do you want to delete the data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
            </td>
			<?php //} ?>
    </tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        	<td colspan="10" align="center" >Empty Data</td>
        </tr>
    <?php	
	}
?>
</table>
<div id="popfoto" width="250px" height="250px" style="display:none"></div>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>