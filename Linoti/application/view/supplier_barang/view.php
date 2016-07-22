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
<!--
<a href="<?=site_url('barang/tambah')?>">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>-->
<a href="<?=site_url('supplier_barang')?>">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<a href="<?=site_url('supplier_barang/clear')?>">
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
	<form name="form" method="post" action="<?php echo base_url('index.php/supplier_barang');?>">
	<td></td>
	<td><input type="text" name="code_cari" id="code_cari" size="15" value="<?=$this->session->userdata('dbarang_code_cari')?>" /></td>
	<td></td>
	<td><input type="text" name="name_cari" id="name_cari" size="50" value="<?=$this->session->userdata('dbarang_name_cari')?>" /></td>
	<td></td>
	<td><!--<input type="text" name="type_cari" id="type_cari" size="15" value="<?=$this->session->userdata('barang_type_cari')?>" />--></td>
	<!--<td><input type="text" name="finish_cari" id="finish_cari" size="20" value="<?=$this->session->userdata('barang_finish_cari')?>" /></td>-->
	<!--
	<td><input type="text" name="dept_cari" id="dept_cari" size="25" value="<?=$this->session->userdata('barang_dept_cari')?>" /></td>
	<td></td>
	<td></td>-->
	<td></td>
	<td></td>
	<td></td>
	<td align="center"><button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button></td>
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
    <!--<th>Unit</th>-->
    <th>Size</th>
    <th>Type</th>
    <th>Finishing</th>
    <th>Supplier</th>
    <th>Date</th>
    <th>Price</th>
		<!--
    <th>Department</th>
    <th>Live Stok</th>
    <th>Position</th>-->
	<?php
		//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
	?>
    <!--<th>Action</th>-->
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
			if($db['foto_barang']=="") {
				$foto = base_url('asset/foto_produk/unknown.jpg');
			} else {
				$foto = base_url('asset/foto_produk/'.$db['foto_barang']);
			}
			$size ='';
			if ($db['size_length']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_length']);
				$fraction = $db['size_length'] - $whole;
				if ($fraction > 0){
					$size .= 'L '.number_format($db['size_length'], 1,',','.').' x ';
				} else {
					$size .= 'L '.number_format($db['size_length'], 0,',','.').' x ';
				}
			}
					
			if ($db['size_width']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_width']);
				$fraction = $db['size_width'] - $whole;
				if ($fraction > 0){
					$size .= 'W '.number_format($db['size_width'], 1,',','.').' x ';
				} else {
					$size .= 'W '.number_format($db['size_width'], 0,',','.').' x ';
				}
			}
			
			if ($db['size_height']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_height']);
				$fraction = $db['size_height'] - $whole;
				if ($fraction > 0){
					$size .= 'H '.number_format($db['size_height'], 1,',','.').' x ';
				} else {
					$size .= 'H '.number_format($db['size_height'], 0,',','.').' x ';
				}
			}
			
			if ($size!=''){
				$size = substr($size,0,-3);
				if (empty($db['size_length_unit'])){
					$size .= '; ';
				} else {
					$size .= ' '.$db['size_length_unit'].'; ';
				}
			}
			
			if ($db['size_diameter'] > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_diameter']);
				$fraction = $db['size_diameter'] - $whole;
				if ($fraction > 0){
					$size = $size.'&#216; out '.number_format($db['size_diameter'],1,',','.');
				} else {
					$size = $size.'&#216; out '.number_format($db['size_diameter'],0,',','.');
				}
				if (empty($db['size_diameter_unit'])){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$db['size_diameter_unit'].'; ';
				}
			}
					
			if ($db['size_diameterin'] > 0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_diameterin']);
				$fraction = $db['size_diameterin'] - $whole;
				if ($fraction > 0){
					$size = $size.'&#216; in '.number_format($db['size_diameterin'],1,',','.');
				} else {
					$size = $size.'&#216; in '.number_format($db['size_diameterin'],0,',','.');
				}
				if (empty($db['size_diameterin_unit'])){
					$size = $size.'; ';
				} else {
					$size = $size.' '.$db['size_diameterin_unit'].'; ';
				}
			}
			
			if ($db['size_density']>0){
				$whole = 0;
				$fraction = 0.0;
				$whole = floor($db['size_density']);
				$fraction = $db['size_density'] - $whole;
				if ($fraction > 0){
					$size = $size.'D'.number_format($db['size_density'],1,',','.').'; ';
				} else {
					$size = $size.'D'.number_format($db['size_density'],0,',','.').'; ';
				}
			}
			
			if (!empty($db->size_thread)){
				$size		= $size.$db->size_thread.'; ';
			}
			
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
			
		?>    
    	<tr>
			<td align="center" width="30"><?=$no?></td>
           <!-- <td width="70" align="center"><font size="1"><?=$db['kode_barang']?></font></td>-->
            <td align="center" width="40"><?=$db['kode_barang_spc']?></td>
            <td align="center" width="100"><a id="example6" class="picture" href="<?=$foto?>" title="<?=$db['nama_barang']?>"><img src="<?=$foto?>" width="60px" /></a></td>
            <td><a href="<?php echo base_url();?>index.php/supplier_barang/edit/<?php echo $db['kode_barang'];?>"><?=$db['nama_barang']?></a></td>
            <!--<td width="10" align="center"><?=$db['unit_name']?></td>-->
            <td width="200"align="center"><?=$size?></td>
            <td width="100"align="center"><?=$db['type']?></td>
            <td width="200" align="center"><?=$db['finishing']?></td>
            <td width="200" align="center"><?=$db['supplier_name']?></td>
            <td width="50" align="center"><?=$db['tgl']?></td>
            <td width="50" align="center"><?=$db['currency'].'  '.$harga?></td>
						<!--
            <td width="25" align="left"><?=$db['dept_name']?></td>
            <td align="center"><?=$stok?></td>
            <td align="center"><?=$position?></td>-->
			<?php
			//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
			?>
            <!--<td width="10" align="center">
            <a href="<?php echo base_url();?>index.php/barang/edit/<?php echo $db['kode_barang'];?>/<?php echo $hal; ?>">
			<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
			</a>
            <a href="<?php echo base_url();?>index.php/barang/hapus/<?php echo $db['kode_barang'];?>/<?php echo $hal; ?>"
            onClick="return confirm('Do you want to delete the data?')">
			<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
			</a>
            </td>-->
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