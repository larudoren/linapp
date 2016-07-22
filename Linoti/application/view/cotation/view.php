
	<!--<script type="text/javascript" src="<?=base_url('asset/js/jquery.mousewheel-3.0.4.pack.js')?>"></script>-->


	<script type="text/javascript" src="<?=base_url('asset/js/jquery.fancybox-1.3.4.pack.js')?>"></script>
	<!--<script type="text/javascript" src="<?=base_url('asset/js/jquery.edatagrid.js')?>"></script>-->
	<!--<script type="text/javascript" src="<?=base_url('asset/js/datagrid-scrollview.js')?>"></script>-->
	<link rel="stylesheet" type="text/css" href="<?=base_url('asset/css/jquery.fancybox-1.3.4.css')?>" media="screen" />
	<!--
	<script>
			!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>-->
	<script type="text/javascript">
		$(document).ready(function() {

			$("a#example6").fancybox({
				'titlePosition'		: 'outside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9
			});
			
			$("#example6").click(function (e){
				e.preventDefault();
				$("#popfoto").attr('width','260px');
				$("#popfoto").load($(this).attr('href'));
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
			<a href="<?=site_url('cotation/tambah')?>">
				<button type="button" name="tambah" id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'">Add Data</button>
			</a>
			<a href="<?=site_url('cotation')?>">
				<button type="button" name="refresh" id="refresh" class="easyui-linkbutton" data-options="iconCls:'icon-reload'">Refresh</button>
			</a>
			<a href="<?=site_url('cotation/clear')?>">
				<button type="button" class="easyui-linkbutton" >Clear search result</button>
			</a>

		</div>
		<?php
		//}
		?>
		<div style="float:right; padding-bottom:5px;">
			<form name="form" method="post" action="<?php echo base_url('index.php/cotation');?>">
				Search (Code / Collection / Name / Finishing) : <input type="text" name="txt_cari" id="txt_cari" size="50" />
				<button type="submit" name="cari" id="cari" class="easyui-linkbutton" data-options="iconCls:'icon-search'">Search</button>
			</form>
		</div>
		<div id="gird" style="float:left; width:100%;">
			<table id="dataTable" width="100%">
				<tr>
					<th>No</th>
					<th>Code</th>
					<th>Collection</th>
					<th>Name</th>
					<th>Finishing</th>
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
	?>    
				<tr>
					<td align="center"><?=$no?></td>
					<td align="center"><?=$db['product_code']?></td>
					<td><?=$db['collection']?></td>
					<td><?=$db['name']?></td>
					<td><?=$db['finishing']?></td>
					<?php
					//if($this->session->userdata('level')=='01' || $this->session->userdata('level')=='04' || $this->session->userdata('level')=='08'){
					?>
          <td align="center">
						<a href="<?php echo base_url();?>index.php/cotation/detail/<?php echo $db['id_cotation'];?>/<?php echo $db['product_code'];?>/<?php echo $db['finishing'];?>/<?php echo $hal; ?>">
							<img src="<?php echo base_url();?>asset/images/browse.png" title='Detail'>
						</a>
						<a href="<?php echo base_url();?>index.php/cotation/edit/<?php echo $db['id_cotation'];?>/<?php echo $db['finishing'];?>/<?php echo $hal; ?>">
							<img src="<?php echo base_url();?>asset/images/ed.png" title='Edit'>
						</a>
            <a href="<?php echo base_url();?>index.php/cotation/hapus/<?php echo $db['id_cotation'];?>" onClick="return confirm('Do you want to delete the data?')">
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
			<div id="popfoto"></div>
<?php echo "<table align='center'><tr><td>".$paginator."</td></tr></table>"; ?>
		</div>
	</div>