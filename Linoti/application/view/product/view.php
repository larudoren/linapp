<script type="text/javascript" src="<?=base_url('asset/js/jquery.fancybox-1.3.4.pack.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('asset/css/jquery.fancybox-1.3.4.css')?>" media="screen" />
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
<div id="view">
<div style="float:left; padding-bottom:5px;">
<?php if ($code_cari=='PR' && $coll_cari!='PR' && $type_cari!='PR' && $category_cari!='PR') {?>
<a href="<?php echo base_url();?>index.php/product/tambah/<?=$code_cari?>/<?=$coll_cari?>/<?=$type_cari?>/<?=$category_cari?>/<?=$hal?>">
<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
</a>
<?php } ?>
<a href="<?php echo base_url();?>index.php/product/name/<?=$code_cari?>/<?=$coll_cari?>/<?=$type_cari?>/<?=$category_cari?>/<?=$hal?>">
<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
</a>
<a href="<?php echo base_url();?>index.php/brand?myheader=Product&mymenu=Research">
<button type="button" name="kembali" id="kembali" class="easyui-linkbutton" data-options="iconCls:'icon-back'">BACK</button>
</a>
</div><!--
<div style="float:right; padding-bottom:5px;">
<form name="form" method="post" action="<?php echo base_url();?>index.php/collection/name/<?=$collection?>">
Code & Product : <input type="text" name="txt_cari" id="txt_cari" size="50" />
<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
</form>
</div>-->
<div id="gird" style="float:left; width:100%;">
<table id="dataTable" width="100%">
	<tr>
    <th>No</th>
		<th>Code</th>
		<th>Photo</th>
    <th>Product</th>
    <th>Action</th>
	</tr>
<?php
	if($data->num_rows()>0){
		$no =1+$hal;
		foreach($data->result_array() as $db){
			if($db['product_photo']=="") {
				$foto = base_url('asset/product_photo/unknown.jpg');
			} else {
				$foto = base_url('asset/product_photo/'.$db['product_photo']);
			}
		?>    
    	<tr>
				<td align="center"><?=$no?></td>
				<td><?=$db['product_code']?></td>
				<td align="center"><a id="example6" class="picture" href="<?=$foto?>" title="<?=$db['product_name']?>"><img src="<?=$foto?>" height="60px" /></a></td>
				<td><?=$db['product_name']?></td>
				<td align="center" width="80"><!--
					<a href="<?php echo base_url();?>index.php/product/detail/<?=$db['coll_name']?>:<?=$db['product_code']?>:<?=$db['product_coll']?>:<?=$code_cari?>:<?=$coll_cari?>:<?=$type_cari?>:<?=$category_cari?>:<?=$hal?>">
						<img src="<?php echo base_url();?>asset/images/browse.png" title='Detail'>
					</a>-->
					<a href="<?php echo base_url();?>index.php/product/edit/<?=$db['coll_name']?>:<?=$db['product_code']?>:<?=$db['product_coll']?>:<?=$code_cari?>:<?=$coll_cari?>:<?=$type_cari?>:<?=$category_cari?>:<?=$hal?>">
						<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
					</a>
					<a href="<?php echo base_url();?>index.php/product/hapus/<?=$db['coll_name']?>:<?=$db['product_code']?>:<?=$db['product_coll']?>:<?=$code_cari?>:<?=$coll_cari?>:<?=$type_cari?>:<?=$category_cari?>:<?=$hal?>"
								onClick="return confirm('Do you want to delete the data?')">
						<img src="<?php echo base_url();?>asset/images/del.png" title='Delete'>
					</a>
				</td>
			</tr>
    <?php
		$no++;
		}
	}else{
	?>
    	<tr>
        <td colspan="7" align="center">Empty Data</td>
      </tr>
  <?php	
	}
?>
</table>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
</div>
</div>