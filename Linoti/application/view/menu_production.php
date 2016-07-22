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
    <li data-options="iconCls:'icon-surat_keputusan'">
    <a href="<?php echo base_url();?>index.php/barang">Barang</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?php echo base_url();?>index.php/customer">Customer</a>
    </li>
    <li data-options="iconCls:'icon-surat_keluar'">
    <a href="<?php echo base_url();?>index.php/supplier">Supplier</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?php echo base_url();?>index.php/satuan">Satuan</a>
    </li>
	<li data-options="iconCls:'icon-surat_keluar'">
	<a href="<?php echo base_url();?>index.php/brand">Brand & Collection</a>
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
<div title="Upload" data-options="iconCls:'icon-tip'" style="overflow:auto;padding:5px 0px;">
    <div title="TreeMenu" data-options="iconCls:'icon-search'" style="padding:0px;">
    <ul class="easyui-tree">
    <li>
    <span><a href="<?php echo base_url();?>index.php/import_supplier">Master Supplier</a></span>
    </li>
    </ul>
    </div>
</div>