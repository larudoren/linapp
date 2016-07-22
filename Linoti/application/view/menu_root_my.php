<?php
	$loc = $this->session->userdata('companyarea');
	$user = $this->session->userdata('username');
	$queryheader = "SELECT C.TEXTCHILD,C.MENUID from menusource C INNER JOIN (SELECT DISTINCT(PARENTID)  FROM menusource A INNER JOIN otorisasi B ON B.COMPANYAREA=A.COMPANYAREA AND B.MENUID=A.MENUID AND B.OPERATORID='$user' AND B.`VIEW`='1'  WHERE A.COMPANYAREA='$loc') D ON D.PARENTID=C.MENUID WHERE C.STATUS='1' ORDER BY C.MENUID";
	$data = $this->app_model->manualQuery($queryheader);
	
	foreach ($data->result() as $head)
	{
		if ($head->TEXTCHILD=='Grafik')
			$myicon='icon-grafik';
		elseif ($head->TEXTCHILD=='Laporan')
			$myicon='icon-print';
		else
			$myicon='icon-tip';
?>
<div title="<?php echo $head->TEXTCHILD; ?>" data-options="iconCls:'<?php echo $myicon; ?>'" style="overflow:auto;padding:5px 0px;">
    <!-- <div data-options="iconCls:'icon-search'" style="padding:0px;">-->
    <ul class="easyui-tree">
		
<?php
		$querydetail = "SELECT A.LINKCHILD,A.TEXTCHILD,A.MENUTIPS,A.MENUID FROM menusource A INNER JOIN otorisasi B ON B.COMPANYAREA=A.COMPANYAREA AND B.MENUID=A.MENUID AND B.OPERATORID='$user' AND B.`VIEW`='1'  WHERE A.COMPANYAREA='$loc' and A.Status='1' AND PARENTID='".$head->MENUID."' ORDER BY A.HEADER_SORT";
		$data = $this->app_model->manualQuery($querydetail);
		foreach ($data->result() as $dt)
		{
?>
		<li data-options="iconCls:'icon-surat_keputusan'">
			<a href="<?=site_url($dt->LINKCHILD)?>?myheader=<?=$head->TEXTCHILD?>&mymenu=<?=$dt->TEXTCHILD?>" title="<?php echo $dt->MENUTIPS; ?>" class="easyui-tooltip"><?php echo $dt->TEXTCHILD ?></a>

		</li>
<?php
		}
?>
	</ul>
    <!--</div>-->
</div>
<?php
	}
?>
