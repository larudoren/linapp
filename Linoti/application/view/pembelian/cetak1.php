<?php
$kiri = "<img src='".base_url('asset/images/chakranaga.jpg')."' width='60%' height='10%'/>";
$kiri .= '<h1>'.$instansi.'</h1>';
$kiri .= '<p>'.$alamat_instansi.'</p>';

$kanan = "<table class='kanan' width='100%'>
		  <tr>
		  	<td>Kode</td>
			<td width='5'>:</td>
			<td><b>$kode_beli</b></td>
		  </tr>
		  <tr>
		  	<td>Tanggal</td>
			<td width='5'>:</td>
			<td>$tgl_beli</td>
		  </tr>
		  <tr>
		  	<td>Supplier</td>
			<td width='5'>:</td>
			<td>$supplier</td>
		  </tr>
		  </table>";
function myheader($kiri,$kanan,$judul){
?>
<div class="atas">
<table width="100%">
<tr>
	<td width="60%" valign="top">
   		<?php echo $kiri;?>
    </td>
	<td width="40%" valign="top">
    	<?php echo $kanan;?>
    </td>
</tr>    
</table>
<center><h1><?php echo $judul;?></h1></center>
</div>
<table class="grid" width="100%">
	<tr>
    	<th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Satuan</th>
        <th>Jumlah</th>
        <th>Valuta</th>
        <th>Harga</th>
        <th>Total</th>
	</tr>        
<?php
}
function myfooter(){	
	echo "</table>";
}
	$g_total=0;
	$no=1;
	$page =1;
	foreach($data->result_array() as $r){
	$total = $r['jmlbeli']*$r['harga'];
	if(($no%25) == 1){
   	if($no > 1){
        myfooter();
        echo "<div class=\"pagebreak\" align='right'>
		<div class='page' align='center'>Hal - $page</div>
		</div>";
		$page++;
  	}
   	myheader($kiri,$kanan,$judul);
	}
	?>
    <tr>
    	<td align="center"><?php echo $no;?></td>
        <td align="center"><?php echo $r['kode_barang'];?></td>
        <td ><?php echo $r['nama_barang'];?></td>
        <td align="center"><?php echo $r['unit_name'];?></td>
        <td align="center"><?php echo $r['jmlbeli'];?></td>
        <td align="center"><?php echo $r['currency_name'];?></td>
        <td align="right"><?php echo number_format($r['harga']);?></td>
        <td align="right"><?php echo number_format($total);?></td>
    </tr>
    <?php
	$no++;
	$g_total = $g_total+$total;
	}
	echo "<tr>
			<td colspan='7' align='center'>Total</td>
			<td align='right'>".$r['currency_name'].". ".number_format($g_total)."</td>
		</tr>";
myfooter();	
	echo "</table>";
	echo "<div class='page' align='center'>Hal - ".$page."</div>";
?>