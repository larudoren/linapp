<div title="Master Form" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
		<li data-options="iconCls:'icon-surat_keputusan'">
			<a href="<?=site_url('pengajuan')?>">Pengajuan Barang</a>
		</li>
	</ul>
    </div>
</div>
<div title="Master" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li data-options="iconCls:'icon-surat_perintah'">
    <a href="<?=site_url('pengguna')?>">Pengguna</a>
    </li>
	<!--<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('tipebarang')?>">Tipe Barang</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('grupbarang')?>">Grup Barang</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('jenisbarang')?>">Jenis Barang</a>
    </li>-->
    <li data-options="iconCls:'icon-surat_keputusan'">
    <a href="<?=site_url('barang')?>">Barang</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?=site_url('customer')?>">Customer</a>
    </li>
    <li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?=site_url('supplier')?>">Supplier</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('departemen')?>">Departemen</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('satuan')?>">Satuan</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('valuta')?>">Valuta</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?=site_url('brand')?>">Brand & Collection</a>
    </li>
    </ul>
    </div>
</div>
<div title="Purchasing" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li data-options="iconCls:'icon-surat_keputusan'">
    <a href="<?=site_url('pembelian')?>">Pembelian</a>
    </li>
    </ul>
    </div>
</div>
<div title="Logistic" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
	<li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?=site_url('penerimaan_barang')?>">Penerimaan Barang</a>
    </li>
    <li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?=site_url('pengeluaran_barang')?>">Pengeluaran Barang</a>
    </li>
    </ul>
    </div>
</div>
<div title="Production" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li>
    <span><a href="<?=site_url('invoice')?>">Perform Invoice</a></span>
    </li>
    </ul>
    </div>
</div>
<!--
<div title="Upload" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
	<li>
    <span><a href="<?=site_url('import_material')?>">Master Material</a></span>
    </li>
    <li>
    <span><a href="<?=site_url('import_barang')?>">Master Barang</a></span>
    </li>
	<li>
    <span><a href="<?=site_url('import_supplier')?>">Master Supplier</a></span>
    </li>
	<li>
    <span><a href="<?=site_url('import_customer')?>">Master Customer</a></span>
    </li>
	<li>
    <span><a href="<?=site_url('import_pembelian')?>">Transaksi Pembelian</a></span>
    </li>
    </ul>
    </div>
</div>
-->
<div title="Laporan" data-options="iconCls:'icon-print'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li>
    <span><a href="<?=site_url('lap_barang')?>">Stok Barang</a></span>
    </li>
    <li>
    <span><a href="<?=site_url('lap_beli')?>">Pembelian</a></span>
    </li>
    <!--<li>
    <span><a href="<?=site_url('lap_jual')?>">Penjualan</a></span>
    </li>
    <li>
    <span><a href="<?=site_url('profit')?>">Profit</a></span>
    </li>-->
    </ul>
    </div>
</div>
<div title="Grafik" data-options="iconCls:'icon-grafik'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li>
    <span><a href="<?=site_url('grafik_beli')?>">Pembelian</a></span>
    </li>
    <!--<li>
    <span><a href="<?=site_url('grafik_jual')?>">Penjualan</a></span>
    </li>-->
    </ul>
    </div>
</div>