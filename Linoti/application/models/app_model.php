<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_Model extends CI_Model {

	/**
	 * @author : Deddy Rusdiansyah
	 * @web : http://deddyrusdiansyah.blogspot.com
	 * @keterangan : Model untuk menangani semua query database aplikasi
	 **/
	
	
	
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
		
	//select table
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	//update table
	function updateData($table,$data,$field_key)
	{
		if(!$this->db->update($table,$data,$field_key)){
			echo 'Update Data Failed!';
		} else{
			echo 'Update Data Successful!';
		}
	}
	
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		if (!$this->db->insert($table,$data)){
			$data = 'Save Data Failed!';
		} else {
			$data = 'Save Data Successful!';
		}
		return $data;
	}
	
	//Query manual
	function manualQuery($q)
	{
		return $this->db->query($q);
	}
	
	public function myaccess($id){
		$user = $this->session->userdata('username');
		$loc = $this->session->userdata('companyarea');
		
		$text = "SELECT A.`view` 
				 FROM otorisasi A 
				 LEFT OUTER JOIN menusource B on B.companyarea=A.companyarea and B.menuid=A.menuid 
				 WHERE A.companyarea='$loc' and B.linkchild='$id' and A.OPERATORID='$user' and A.`view`='1'";
		$d = $this->app_model->manualQuery($text);
		$r = $d->num_rows();
		if ($r>0)
			{$hasil ='1';}
		else
		{ $hasil='0';}
		return $hasil;
	}
	
	public function NamaSupp($id){
		$t = "SELECT * FROM supplier WHERE supplier_code='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->supplier_name;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function NamaDept($id){
		$t = "SELECT * FROM departemen WHERE dept_code='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->dept_name;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function CariLevel($id){
		$t = "SELECT * FROM level WHERE id_level='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->level;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function ItemBeli($id){
		$t = "SELECT po FROM d_beli WHERE po='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemTerima($id){
		$t = "SELECT kode_terima FROM d_terima WHERE kode_terima='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemKeluar($id){
		$t = "SELECT kode_keluar FROM d_keluar WHERE kode_keluar='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlBeli($id){
		$t = "SELECT sum(qty_order * hargabeli) as jml FROM d_beli WHERE po='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlTerima($id){
		$t = "SELECT sum(jml_terima * harga_terima) as jml FROM d_terima WHERE kode_terima='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemJual($id){
		$t = "SELECT kodejual FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlJual($id){
		$t = "SELECT sum(jmljual * hargajual) as jml FROM d_jual WHERE kodejual='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokOpname($kode){
		$loc = $this->session->userdata('companyarea');
		$t = "SELECT A.quantity,DATE_FORMAT(B.tanggal,'%Y-%m-%d') as tanggal
					FROM stock_opname A 
					LEFT OUTER JOIN h_stock B ON B.stock_id=A.stock_id and B.companyarea=A.companyarea 
					WHERE A.companyarea='$loc' and A.kode_barang='$kode'
					ORDER BY B.tanggal DESC
					LIMIT 1";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil[0] = $h->quantity;
				$hasil[1] = $h->tanggal;
			}
		}else{
			$hasil[0] = 0;
			$hasil[1] = '';
		}
		return $hasil;
	}
	
	public function CariStokAwal($kode,$console){
		$kemarin = date('Y-m-d',strtotime('-1 day',strtotime($console)));
		$bulan_lalu = date('Y-m-d',strtotime('-2 month',strtotime($console)));
		
		$where = "WHERE kode_barang='$kode'";
		
		$cek = "SELECT COUNT(*) AS ccount FROM stok_keluar WHERE kode_barang='$kode' AND tgl_keluar BETWEEN '$bulan_lalu' AND '$kemarin'";
		$cek_hasil = $this->app_model->manualQuery($cek);
		$cek_row = $cek_hasil->row();
		if($cek_row->ccount > 0) {
			$t = "SELECT kode_barang,(SELECT SUM(masuk) FROM stok_masuk WHERE kode_barang='$kode' AND tgl_terima BETWEEN '$bulan_lalu' AND '$kemarin')-(SELECT SUM(keluar) FROM stok_keluar WHERE kode_barang='$kode' AND tgl_keluar BETWEEN '$bulan_lalu' AND '$kemarin') AS stok_awal FROM stok_masuk $where GROUP BY kode_barang";
		} else {
			$t = "SELECT kode_barang, SUM(masuk) AS stok_awal FROM stok_masuk WHERE kode_barang='$kode' AND tgl_terima BETWEEN '$bulan_lalu' AND '$kemarin'";
		}
		
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->stok_awal;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlBeli($kode){
		$t = "SELECT kode_barang,sum(jmlbeli) as jml FROM d_beli WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlTerima0($kode){
		$t = "SELECT kode_barang,sum(jml_terima) as jml FROM d_terima WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlTerima($kode,$var1,$var2){
		//$t = "SELECT kode_barang,sum(jml_terima) as jml FROM d_terima WHERE kode_barang='$kode' GROUP BY kode_barang";
		if (empty($var1)){
			$where = " AND B.tgl_terima <= '$var2'";
		}else{
			$where = " AND B.tgl_terima BETWEEN '$var1' AND '$var2'";
		}
		
		$t = "SELECT A.kode_barang, SUM(A.jml_terima) AS jml FROM d_terima A LEFT OUTER JOIN h_terima B ON B.kode_terima=A.kode_terima AND B.companyarea=A.companyarea WHERE A.kode_barang='$kode' $where";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		
		return $hasil;
	}
	
	public function CariJmlJual($kode){
		$t = "SELECT kode_barang,sum(jmljual) as jml FROM d_jual WHERE kode_barang='$kode' GROUP BY kode_barang";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlKeluar($kode,$var1,$var2){
		//$t = "SELECT kode_barang,sum(jml_keluar) as jml FROM d_keluar WHERE kode_barang='$kode' GROUP BY kode_barang";
		if (empty($var1)){
			$where = " AND B.tgl_keluar <= '$var2'";
		}else{
			$where = " AND B.tgl_keluar BETWEEN '$var1' AND '$var2'";
		}
		
		$t = "SELECT A.kode_barang, SUM(A.jml_keluar) AS jml FROM d_keluar A LEFT OUTER JOIN h_keluar B ON B.kode_keluar=A.kode_keluar AND B.companyarea=A.companyarea WHERE A.kode_barang='$kode' $where";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlPermintaan($kode,$var1,$var2){
		if (empty($var1)){
			$where = " AND B.tglbeli <= '$var2'";
		}else{
			$where = " AND B.tglbeli BETWEEN '$var1' AND '$var2'";
		}
		
		$t = "SELECT A.kode_barang, SUM(A.jmlbeli) AS jml FROM d_beli A LEFT OUTER JOIN h_beli B ON B.po=A.po AND B.companyarea=A.companyarea WHERE A.kode_barang='$kode' $where";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		
		return $hasil;
	}
	
	public function GrafikBeli($bln,$thn){
		$t = "SELECT month(a.tglbeli) as bln, year(a.tglbeli) as th, count(*) as jml 
			FROM h_beli as a
			JOIN d_beli as b
			ON a.po=b.po 
			WHERE month(a.tglbeli)='$bln' AND year(a.tglbeli)='$thn'
			GROUP BY month(a.tglbeli),year(a.tglbeli)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function GrafikJual($bln,$thn){
		$t = "SELECT month(a.tgljual) as bln, year(a.tgljual) as th, count(*) as jml 
			FROM h_jual as a
			JOIN d_jual as b
			ON a.kodejual=b.kodejual 
			WHERE month(a.tgljual)='$bln' AND year(a.tgljual)='$thn'
			GROUP BY month(a.tgljual),year(a.tgljual)";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAkhir($kode,$var1,$var2){
		$awal = $this->app_model->CariStokAwal($kode,$var1);
		//$beli = $this->app_model->CariJmlBeli($kode);
		$terima = $this->app_model->CariJmlTerima($kode,$var1,$var2);
		//$jual = $this->app_model->CariJmlJual($kode);
		$keluar = $this->app_model->CariJmlKeluar($kode,$var1,$var2);
		$hasil = ($awal+$terima)-$keluar;
		
		return $hasil;
	}
	
	public function CariLiveStock($kode,$var1,$var2){
		$stokopname = $this->app_model->CariStokOpname($kode);
		if ($stokopname[0]>0){
			$awal = $stokopname[0];
			$tgl 	= $stokopname[1];
		} else {
			$awal = $this->app_model->CariStokAwal($kode,$var1);
			$tgl = '';
		}
		
		$terima = $this->app_model->CariJmlTerima($kode,$tgl,$var2);
		//$jual = $this->app_model->CariJmlJual($kode);
		$keluar = $this->app_model->CariJmlKeluar($kode,$tgl,$var2);
		$hasil = ($awal+$terima)-$keluar;
		
		return $hasil;
	}
	
	public function CariDeadStock($kode,$var1,$var2){
		$stokopname = $this->app_model->CariStokOpname($kode);
		if ($stokopname[0]>0){
			$awal = $stokopname[0];
			$tgl 	= $stokopname[1];
		} else {
			$awal = $this->app_model->CariStokAwal($kode,$var1);
			$tgl = '';
		}
		$terima = $this->app_model->CariJmlTerima($kode,$tgl,$var2);
		//$jual = $this->app_model->CariJmlJual($kode);
		$keluar = $this->app_model->CariJmlKeluar($kode,$tgl,$var2);
		$minta = $this->app_model->CariJmlPermintaan($kode,$tgl,$var2);
		$hasil = ($awal+$terima)-$keluar-$minta;
		
		return $hasil;
	}
	
	public function cost_average($var) {
		$this->db->select('kode_barang, average');
		$this->db->from('cost_masuk');
		$this->db->where('kode_barang', $var);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function CariNamaPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->nama_lengkap;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function CariOnlineUser(){
		$query=$this->db->select('user_data')->get('ci_sessions');
		$user = array();
		
		$j=0;$k=0;
		 
    foreach ($query->result() as $row)
    {
        $udata = unserialize($row->user_data);
        /* put data in array using username as key */
				
        if(isset($udata['logged_in']))
        {

            //if($udata['yourlogin_data']['User_cat']==2)
            //{
                $user[$j]['userId'] = $udata['username'];
                $user[$j]['userName'] = $udata['nama_lengkap'];
                $j++;
           // }




        }

    }
		return json_encode($user);
	}
	
	public function CariFotoPengguna(){
		$id = $this->session->userdata('username');
		$t = "SELECT * FROM admins WHERE username='$id'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->foto;
			}
		}else{
			$hasil = '';
		}
		return $hasil;
	}
	
	public function TotalBeli($tgl1,$tgl2){
		$t = "SELECT sum(a.jmlbeli * a.hargabeli) as jml 
			FROM d_beli as a
			JOIN h_beli as b
			ON a.kodebeli=a.kodebeli 
			WHERE b.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function TotalJual($tgl1,$tgl2){
		$t = "SELECT sum(a.jmljual * a.hargajual) as jml 
				FROM d_jual as a
				JOIN h_jual as b
				ON a.kodejual=b.kodejual 
				WHERE b.tgljual BETWEEN '$tgl1' AND '$tgl2'";
		$d = $this->app_model->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function MaxKodeBeli(){
		$thn = date('ymd');
		$text = "SELECT max(kodebeli) as no FROM h_beli where kodebeli like '%$thn%'";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,11,3))+1;
				$hasil = 'LIN-'.$thn.sprintf("-%03s", $tmp);
			}
		}else{
			$hasil = 'LIN-'.$thn.'-001';
		}
		return $hasil;
	}
	
	public function MaxKodeLoc(){
		$text = "SELECT max(lokasi_code) as no FROM lokasi";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeTip(){
		$text = "SELECT max(tipe_code) as no FROM tipebarang";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeSup(){
		$text = "SELECT max(supplier_code) as no FROM supplier";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxSeqSup($id){
		$text = "SELECT max(sequence) as no FROM d_supplier where supplier_code='$id'";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 2))+1;
				$hasil = sprintf('%02s', $tmp);
			}
		}else{
			$hasil = '01';
		}
		
		return $hasil;
	}
	
	public function MaxKodeJen(){
		$text = "SELECT max(jenis_code) as no FROM jenisbarang";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeDept(){
		$text = "SELECT max(dept_code) as no FROM departemen";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeVal(){
		$text = "SELECT max(currency_code) as no FROM currency";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxBrandVal(){
		$text = "SELECT max(brand_code) as no FROM brand";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxCollectionVal(){
		//$alpha =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$text = "SELECT max(coll_code) as no FROM collection";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeSat(){
		$text = "SELECT max(unit_code) as no FROM unit";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no;
				$tmp = ((int) substr($no, 1, 3))+1;
				$hasil = sprintf('%03s', $tmp);
			}
		}else{
			$hasil = '001';
		}
		return $hasil;
	}
	
	public function MaxKodeJual(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodejual) as no FROM h_jual";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,2,5))+1;
				$hasil = 'JL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'JL'.'00001';
		}
		return $hasil;
	}
	
	public function MaxKodeTerima(){
		$th = date('y');
		$bl = date('m');
		$text = "SELECT max(kode_terima) as no FROM h_terima";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,3))+1;
				$hasil = $th.$bl.sprintf("%03s", $tmp);
			}
		}else{
			$hasil = $th.$bl.'001';
		}
		
		return $hasil;
	}
	
	public function MaxKodeKeluar(){
		$th = date('y');
		$text = "SELECT max(kode_keluar) as no FROM h_keluar";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,4,4))+1;
				$hasil = $th.'4'.sprintf("%04s", $tmp);
			}
		}else{
			$hasil = $th.'40001';
		}
		return $hasil;
	}
	
	public function PONumber($var) {
		$th = date('y');
		if($var=="Indonesia") {
			$var1 = 1;
		}
		else {
			$var1 = 2;
		}
		$text = "SELECT max(po) as no FROM h_beli WHERE po like '__$var1____'";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,4,4))+1;
				$hasil = $th.$var1.sprintf("%04s", $tmp);
			}
		}else{
			$hasil = $th.$var1.'0001';
		}
		return $hasil;
	}
	
	public function GeneratePONumber($date,$kode_supplier,$pi){
		//$th = date('Y');
		//$bl = date('m');
		$exp = explode('-',$date);
		$th = $exp[0];
		$bl = $exp[1];
	
		$text = "SELECT kode_po from supplier where supplier_code ='$kode_supplier'";
		$kode = $this->app_model->manualQuery($text);
		if ($kode->num_rows() > 0){
			foreach($kode->result() as $k){
				$supcode = $k->kode_po;
			}
		} else {
			$supcode='';
		}

		if ($supcode!=''){
			$text = "SELECT max(po) as no FROM h_beli WHERE po like 'LI-%%-$supcode-$th.$bl.___'";
			$data = $this->app_model->manualQuery($text);
			
			if($data->num_rows() > 0 ){
				foreach($data->result() as $t){
					$no = $t->no; 
					$tmp = ((int) substr($no,-3,3))+1;
					$hasil = 'LI-'.$pi.'-'.$supcode.'-'.$th.'.'.$bl.'.'.sprintf("%03s", $tmp);
				}
			}else{
				$hasil = 'LI-'.$pi.'-'.$supcode.'-'.$th.'.'.$bl.'.001';
			}
		} else {
			$hasil ='';
		}
		
		return $hasil;
	}
	
		
	//Konversi tanggal
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_str($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	
	public function ambilTgl($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[2];
		return $tgl;
	}
	
	public function ambilBln($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[1];
		$bln = $this->app_model->getBulan($tgl);
		$hasil = substr($bln,0,3);
		return $hasil;
	}
	
	public function tgl_indo($tgl){
			$jam = substr($tgl,11,10);
			$tgl = substr($tgl,0,10);
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}	
	
	public function tgl_eng($tgl){
			$jam = substr($tgl,11,10);
			$tgl = substr($tgl,0,10);
			$tanggal = substr($tgl,8,2);
			$bulan = $this->app_model->getMonth(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}

	public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}

	public function getMonth($bln){
		switch ($bln){
			case 1: 
				return "January";
				break;
			case 2:
				return "February";
				break;
			case 3:
				return "March";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "May";
				break;
			case 6:
				return "June";
				break;
			case 7:
				return "July";
				break;
			case 8:
				return "August";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "October";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "December";
				break;
		}
	} 
	
	public function hari_ini($hari){
		date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
		$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		//$hari = date("w");
		$hari_ini = $seminggu[$hari];
		return $hari_ini;
	}
	
	//query login
	public function getLoginData($usr,$psw,$loc)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw));
		$q_cek_login = $this->db->get_where('admins', array('username' => $u, 'password' => $p, 'companyarea' => $loc));
		
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
					foreach($q_cek_login->result() as $qad)
					{
						$sess_data['logged_in'] = 'aingLoginYeuh';
						$sess_data['username'] = $qad->username;
						$sess_data['nama_lengkap'] = $qad->nama_lengkap;
						$sess_data['foto'] = $qad->foto;
						$sess_data['level'] = $qad->level;
						$sess_data['companyarea'] = $qad->companyarea;
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/home');
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', '<br>Username or Password incorrect');
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function getLoginDataB($usr,$psw,$loc)
	{
		$u = mysql_real_escape_string($usr);
		$p = md5(mysql_real_escape_string($psw));
		$q_cek_login = $this->db->get_where('admins', array('username' => $u, 'password' => $p, 'companyarea' => $loc));
		$domain = base_url();
		setcookie('username', $usr, time()+3600*8, '/', $domain);
		setcookie('password', $psw, time()+3600*8, '/', $domain);
		setcookie('companyarea', $loc, time()+3600*8, '/', $domain);
		
		if(count($q_cek_login->result())>0)
		{
			foreach($q_cek_login->result() as $qck)
			{
					foreach($q_cek_login->result() as $qad)
					{
						$sess_data['logged_in'] = 'aingLoginYeuh';
						$sess_data['username'] = $qad->username;
						$sess_data['nama_lengkap'] = $qad->nama_lengkap;
						$sess_data['foto'] = $qad->foto;
						$sess_data['level'] = $qad->level;
						$sess_data['companyarea'] = $qad->companyarea;
						$this->session->set_userdata($sess_data);
					}
					header('location:'.base_url().'index.php/home');
			}
		}
		else
		{
			$this->session->set_flashdata('result_login', '<br>Username or Password incorrect');
			header('location:'.base_url().'index.php/login');
		}
	}
	
	function get_satuan() {
		$query = $this->db->get('unit');
		return $query;
	}
	function get_matauang() {
		$query = $this->db->get('currency');
		return $query;
	}
	function get_lokasi() {
		$query = $this->db->get('lokasi');
		return $query;
	}
	function get_departement() {
		$id['companyarea'] = $this->session->userdata('companyarea');
		$query = $this->db->get_where('departemen',$id);
		return $query;
	}
	function get_departement_fact() {
		$id['companyarea'] = $this->session->userdata('companyarea');
		$query = $this->db->get_where('departemen_fact',$id);
		return $query;
	}
	function get_customer() {
		$id['companyarea'] = $this->session->userdata('companyarea');
		$query = $this->db->get_where('customer',$id);
		return $query;
	}
	function get_supplier() {
		$id['companyarea'] = $this->session->userdata('companyarea');
		$query = $this->db->get_where('supplier',$id);
		return $query;
	}
	function harga_upholstery($kode_barang){	// Cotation Upholstery
		//$text = "SELECT * FROM ((select A.kode_barang,A.tgl_terakhir_beli as tgl_beli,B.currency_name,A.brg_harga from barang A left outer join currency B on B.currency_id=A.brg_currency where A.brg_supplier!='')
		//											UNION (select A.kode_barang,A.tgl_beli,B.currency_name,A.harga as brg_harga from temp_barang A left outer join currency B on B.currency_id=A.currency_id))A  where A.kode_barang='$kode_barang' order by A.tgl_beli DESC limit 1";
		$text = "select B.kode_barang,B.tgl_beli,H.currency_name,B.brg_harga,E.unit_name,E.convertion,C.average_waste,C.size_length,C.size_width,C.size_height,D.simbol as length_unit,C.size_weight,F.simbol as weight_unit,C.size_volume,G.simbol as volume_unit,I.family,C.nama_barang,J.type
						 from (select * from (				(select A.kode_barang,A.tgl_terakhir_beli as tgl_beli,A.brg_currency,A.brg_harga from barang A /* where A.brg_supplier!=''*/)
																		UNION (select A.kode_barang,A.tgl_beli,A.currency_id as brg_currency,A.harga as brg_harga from temp_barang A))A  
										where kode_barang='$kode_barang' order by A.tgl_beli DESC limit 1)B
						 LEFT OUTER JOIN barang C on C.kode_barang=B.kode_barang
						 LEFT OUTER JOIN t_unit_ukuran D on D.unit_ukuran_id=C.size_length_unit
						 LEFT OUTER JOIN `unit` E on E.unit_id=C.satuan
						 LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=C.size_weight_unit
						 LEFT OUTER JOIN t_unit_ukuran G on G.unit_ukuran_id=C.size_volume_unit
						 LEFT OUTER JOIN family I on I.family_id=C.family
						 LEFT OUTER JOIN `type` J on J.type_id=C.type
						 LEFT OUTER JOIN currency H on H.currency_id=B.brg_currency";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$harga=0;
				$hasil[0] = $t->currency_name;
				if (strpos(strtolower($t->nama_barang),'dacron')!== false OR strpos(strtolower($t->type),'dacron')!== false){
					if (($t->size_length > 0 OR $t->size_width > 0 OR $t->size_height > 0)){
					  if ($t->length_unit=='m'){
							$harga = $t->brg_harga / ($t->size_length*$t->size_width);
						} elseif ($t->length_unit=='cm'){
							$harga = $t->brg_harga / (($t->size_length*$t->size_width)/10000);
						} else {
							$harga = $t->brg_harga / (($t->size_length*$t->size_width)/1000000);
						}
					} else {
						$harga = $t->brg_harga / ($t->size_weight);
					}
				} else {
					if (strtolower($t->unit_name)=='meter' OR strtolower($t->unit_name)=='running meter' OR (strpos(strtolower($t->unit_name),'100 pcs')===false && strpos(strtolower($t->unit_name),'pcs')!==false)){
						$harga = $t->brg_harga;
						/*
						if ($t->length_unit=='m'){
							$harga = $t->brg_harga / $t->size_width / 1000000;
						} else if ($t->length_unit=='cm'){
							$harga = $t->brg_harga / $t->size_width / 100;
						} else if ($t->length_unit=='mm'){
							$harga = $t->brg_harga / $t->size_width;
						} */
						
					} else if (strpos(strtolower($t->unit_name),'strip')!==false){
						$harga = $t->brg_harga;
					} else if (strpos(strtolower($t->unit_name),'square feet')!==false){
						//if (strpos($t->unit_name,'30.48')!==false){
							$harga = $t->brg_harga;
						//}else{
						//	$harga = $t->brg_harga * $t->convertion;
						//}
					} else if (((strpos(strtolower($t->unit_name),'roll')!==false) && (strpos(strtolower($t->unit_name),'100 yds')===false))){
							if ($t->length_unit=='m'){
								$harga = $t->brg_harga / $t->size_length;
							} else if ($t->length_unit=='cm'){
								$harga = $t->brg_harga / ($t->size_length/100);
							} else if ($t->length_unit=='mm'){
								$harga = $t->brg_harga / ($t->size_length/1000);
							}
							
					} else if (strpos(strtolower($t->unit_name),'sheet')!==false &&  strpos(strtolower($t->family),'foam')!==false){
						if ($t->length_unit=='m'){
							$harga = $t->brg_harga / ($t->size_length*$t->size_width);
						} elseif ($t->length_unit=='cm'){
							$harga = $t->brg_harga / (($t->size_length*$t->size_width)/10000);
						} else {
							$harga = $t->brg_harga / (($t->size_length*$t->size_width)/1000000);
						}
					} else if (strpos(strtolower($t->unit_name),'100 yds')!==false ){
						$harga = $t->brg_harga / 91.440;
					} else if (strpos(strtolower($t->unit_name),'100 pcs')!==false){
						$harga = $t->brg_harga / 100;
					//} else if (strpos(strtolower($t->unit_name),'galon')!==false ){
					//	$harga = $t->brg_harga / 0.0243;
					} else if (strpos(strtolower($t->unit_name),'dozen')!==false && strpos(strtolower($t->family),'yarn')===false){
						$harga = $t->brg_harga / 12;
					} else if (/* strpos(strtolower($t->unit_name),'pack')!==false && */ strpos(strtolower($t->family),'yarn')!==false){
						if (strpos(strtolower($t->unit_name),'dozen')!==false){
							if ($t->length_unit=='m'){
								$harga = $t->brg_harga / 12 / $t->size_length;
							} else if ($t->length_unit=='cm'){
								$harga = $t->brg_harga / 12 / ($t->size_length/100);
							} else if ($t->length_unit=='mm'){
								$harga = $t->brg_harga / 12 / ($t->size_length/1000);
							}
						} else {
							if ($t->length_unit=='m'){
								$harga = $t->brg_harga / $t->size_length;
							} else if ($t->length_unit=='cm'){
								$harga = $t->brg_harga / ($t->size_length/100);
							} else if ($t->length_unit=='mm'){
								$harga = $t->brg_harga / ($t->size_length/1000);
							}
						}
					}
				}
				$hasil[1] = number_format($harga,8,'.','');
				$hasil[2] = $t->average_waste;
			}
		}
		else{
			$hasil[0] = '';
			$hasil[1] = 0;
			$hasil[2] = 0;
		}
		
		return $hasil;
	}
	
	public function ukuranBarang($kode){ // cotation upholstery
		$text = "SELECT A.size_length, A.size_width, A.size_height,B.simbol from barang A LEFT OUTER JOIN t_unit_ukuran B ON B.unit_ukuran_id=A.size_length_unit WHERE kode_barang='$kode'";
		$table = $this->app_model->manualQuery($text);
		
		if($table->num_rows() > 0) {
			foreach($table->result() as $t){
				$hasil[0] = $t->simbol;
				$hasil[1] = $t->size_length;
				$hasil[2] = $t->size_width;
				$hasil[3] = $t->size_height;
			}
		} else {
			$hasil[0] = '';
			$hasil[1] = 0;
			$hasil[2] = 0;
			$hasil[3] = 0;
		}
		
		return $hasil;
	}
	
	public function GenerateStockID(){	// Stock
		$loc = $this->session->userdata('companyarea');
		$th = date('Y');
		$text = "SELECT MAX(stock_id) as no FROM h_stock WHERE companyarea='$loc' and stock_id LIKE '___".$th."____'";
		$table = $this->app_model->manualQuery($text);
		if($table->num_rows() > 0) {
			foreach($table->result() as $row) {
				$no = $row->no;
				$tmp = ((int) substr($no,5,4))+1;
				$data = $th.sprintf("%04s", $tmp);
			}
		} else {
			$data = $th.'0001';
		}
		return $data;
	}
	
	public function GenerateCustomerCode(){ // Customer
		$loc = $this->session->userdata('companyarea');
		$text = "SELECT MAX(cust_code) as no FROM customer where companyarea='$loc'";
		$table = $this->app_model->manualQuery($text);
		if($table->num_rows() > 0) {
			foreach($table->result() as $row) {
				$no = $row->no;
				$tmp = ((int) $no)+1;
				$data = sprintf("%03s",$tmp);
			}
		} else {
			$data = '001';
		}
		return $data;
	}
	
	public function GenerateMaterialCode($Departement){ // Material or Barang
		$loc = $this->session->userdata('companyarea');
		$th  = date('Y');
		$bl  = date('m');
		if ($Departement=='UPHOLD'){
			$deptcode = 'UP';
		} elseif ($Departement=='RAWWD'){
			$deptcode = 'WD';
		} elseif ($Departement=='RAWVEN'){
			$deptcode = 'VN';
		} elseif ($Departement=='SANDNG'){
			$deptcode = 'SN';
		} elseif ($Departement=='RAWPAN'){
			$deptcode = 'PN';
		} elseif ($Departement=='PACKNG'){
			$deptcode = 'PK';
		} elseif ($Departement=='GLASS'){
			$deptcode = 'GL';
		} elseif ($Departement=='GILDNG'){
			$deptcode = 'GD';
		} elseif ($Departement=='FINISH'){
			$deptcode = 'FI';
		} elseif ($Departement=='ACCHRD'){
			$deptcode = 'AC';
		} elseif ($Departement=='ASSBLG'){
			$deptcode = 'AS';
		} elseif ($Departement=='ANTIK'){
			$deptcode = 'AN';
		}
		
		$text = "SELECT MAX(kode_barang) as no FROM barang where companyarea='$loc' and kode_barang LIKE 'MAT".$deptcode.$th.$bl."___'";
		$table = $this->app_model->manualQuery($text);
		
		if($table->num_rows() > 0) {
			
			foreach($table->result() as $row) {
				$no = $row->no;
				$tmp = substr($no,11,3)+1;
				$data = 'MAT'.$deptcode.$th.$bl.sprintf("%03s",$tmp);
			}
		} else {
			$data = 'MAT'.$deptcode.$th.$bl.'001';
		}
		return $data;
	}
	
	public function GeneratePIID(){
		$loc = $this->session->userdata('companyarea');
		$th  = date('Y');
		$bl  = date('m');
		
		$text = "select MAX(pi_id) as no from `pi` where pi_id like '$th-$bl-___'";
		$data = $this->app_model->manualQuery($text);
			
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,-3,3))+1;
				$hasil = $th.'-'.$bl.'-'.sprintf("%03s", $tmp);
			}
		}else{
			$hasil = $th.'-'.$bl.'-001';
		}
		return $hasil;
	}
	
	public function dir_files_name($dir_name,$search,$supplier_code,$path){
		$this->load->helper('directory'); //load directory helper
		$dir = "asset/po/".$dir_name."/";
		$map = directory_map($dir);
		$hasil ='';
		$no=1;
		$search = preg_quote($search);
		
		if (file_exists($dir)){ 			// check directory exists
			foreach ($map as $k => $v){ // get each files in directory
				if (!is_array($v)){
					if (preg_match("/$search/i",$v)){
						$hasil = $hasil.'<tr><td align="center">'.$no.'</td><td>'.$v.'</td><td align="center"><a href="'.base_url().'index.php/po/showpdf/'.$dir_name.':'.$v.'" target="_blank"><img src="'.base_url().'asset/images/browse.png" title="View"></a>  <a href="javascript:void(0)" onClick="funct_hapus(`'.$dir_name.':'.$v.':'.$supplier_code.'`);"><img src="'.base_url().'asset/images/del.png" title="Delete"></a></td></tr>';
						$no=$no+1;
					}
				} // else {
				//	print_dir($v,$path.$k.DIRECTORY_SEPARATOR);
				//}
			}
		}
		
		return $hasil;
	}
	
	public function cotation_upholstery($material_code,$comp_length,$comp_width,$comp_volume,$comp_quantity,$comp_waste){
		
		$sql_mat = "SELECT A.kode_barang,A.nama_barang,B.family,E.`type`,C.unit_name,A.average_waste,A.size_length,A.size_width,A.size_height,D.simbol FROM barang A LEFT OUTER JOIN family B ON B.family_id=A.family LEFT OUTER JOIN unit C ON C.unit_code=A.satuan LEFT OUTER JOIN t_unit_ukuran D ON D.unit_ukuran_id=A.size_length_unit LEFT OUTER JOIN `type` E ON E.type_id=A.`type` WHERE A.kode_barang='$material_code'";
		$result_mat = $this->app_model->manualQuery($sql_mat);
		$data_mat = $result_mat->row();
		
		if ($result_mat->num_rows() > 0){
			if (strpos(strtolower($data_mat->family), 'fabric') !== false || strpos(strtolower($data_mat->family), 'foam') !== false || strpos(strtolower($data_mat->family), 'leather') !== false || (strpos(strtolower($data_mat->family), 'glue') !== false && strpos(strtolower($data_mat->unit_name), 'galon') !== false)){
				if (strpos(strtolower($data_mat->family), 'foam') !== false && strpos(strtolower($data_mat->type), 'dacron') !== false && strpos(strtolower($data_mat->unit_name), 'kg') !== false && strpos(strtolower($data_mat->nama_barang), 'gulung') === false ){
					$a = $comp_volume * $comp_quantity;
				} else{
					$a = ($comp_length*$comp_width*$comp_quantity)*(1+($data_mat->average_waste/100)+($comp_waste/100));
				}
				
			}else if (strpos(strtolower($data_mat->family), 'yarn') !== false || strpos(strtolower($data_mat->family), 'webbing') !== false || strpos(strtolower($data_mat->family), 'perekat') !== false){
				$a = ($comp_length*$comp_quantity)*(1+($data_mat->average_waste/100)+($comp_waste/100));
			}else if (strpos(strtolower($data_mat->family), 'zipper') !== false){
				if (strpos(strtolower($data_mat->unit_name), 'roll') !== false || strpos(strtolower($data_mat->unit_name), 'meter') !== false){
					$a = ($comp_length*$comp_quantity)*(1+($data_mat->average_waste/100)+($comp_waste/100));
				} else {
					$a = $comp_quantity;
				}
			} else if (strpos(strtolower($data_mat->family), 'hardware') !== false) {
				if (strpos(strtolower($data_mat->unit_name), 'yds') !== false || strpos(strtolower($data_mat->unit_name), 'roll') !== false){
					$a = ($comp_length*$comp_quantity)*(1+($data_mat->average_waste/100)+($comp_waste/100));
				} else {
					$a = $comp_quantity;
				}
			}
			
			$a_cm	= $a/100;
			$a_m = $a/1000000;
			
			$hasil['average_waste'] = $data_mat->average_waste;
			$hasil['kode_barang'] = $data_mat->kode_barang;
			
			if (strpos(strtolower($data_mat->unit_name), 'square feet') !== false && strpos(strtolower($data_mat->family), 'leather') !== false){
				if (strpos(strtolower($data_mat->unit_name), '25') !== false){
				
					$sqf_25 = $a_cm/(25*25);
					$sqf_28 = '';
					$sqf_3048 = '';
				
				} else if (strpos(strtolower($data_mat->unit_name), '28') !== false){
					$sqf_25 = '';
					$sqf_28 = $a_cm/(28*28);
					$sqf_3048 = '';
				} else if (strpos(strtolower($data_mat->unit_name), '30.48') !== false){
					$sqf_25 = '';
					$sqf_28 = '';
					$sqf_3048 = $a_cm/(30.48*30.48);
				}
				
				$hasil['sqf_25'] = $sqf_25;
				$hasil['sqf_28'] = $sqf_28;
				$hasil['sqf_3048'] = $sqf_3048;
				$hasil['height'] = '';
				$hasil['width'] = '';
				
				
				$hasil['run_m140'] = '';
				$hasil['run_m150'] = '';
				$hasil['run_m160'] = '';
				
				$hasil['consum']		= $a;
				$hasil['consum_m']	= '';
				$hasil['kilo']			= '';
				
			}else {
				
				$hasil['sqf_25'] = '';
				$hasil['sqf_28'] = '';
				$hasil['sqf_3048'] = '';
				
				if (strpos(strtolower($data_mat->family), 'fabric') !== false && (strpos(strtolower($data_mat->unit_name), 'running meter') !== false || strpos(strtolower($data_mat->unit_name), 'meter') !== false || strpos(strtolower($data_mat->unit_name), 'roll') !== false)){
					$t_width=0;
					
					if ($data_mat->simbol=='m'){
						$t_width = $data_mat->size_width*1000;
					}else if ($data_mat->simbol=='cm'){
						$t_width = $data_mat->size_width*100;
					} else if ($data_mat->simbol=='mm'){
						$t_width = $data_mat->size_width;
					}
					
					if ($t_width==1400 || $t_width==1370 || $t_width==1380 || $t_width==1450){
						if (t_width==1400){
							$run_m = $a/1000000/1.4;
						} else if($t_width==1370){
							$run_m = $a/1000000/1.37;
						} else if($t_width==1380){
							$run_m = $a/1000000/1.38;
						} else {
							$run_m =$a/1000000/1.45;
						}
						
						$run_m140 = $run_m;
						$run_m150 = '';
						$run_m160 = '';
						
					} else if ($t_width==1500){
						$run_m =$a/1000000/1.5;
						
						$run_m140 = '';
						$run_m150 = $run_m;
						$run_m160 = '';
					} else if ($t_width==1600) {
						$run_m =$a/1000000/1.6;
						
						$run_m140 = '';
						$run_m150 = '';
						$run_m160 = $run_m;
					}
					
					$hasil['run_m140'] = $run_m140;
					$hasil['run_m150'] = $run_m150;
					$hasil['run_m160'] = $run_m160;
					
					$hasil['consum']		= $a;
					$hasil['consum_m']	= '';
					$hasil['kilo']			= '';
					
					$hasil['height']			= '';
					$hasil['width']			= '';
					
				} else {
				
					$hasil['run_m140'] = '';
					$hasil['run_m150'] = '';
					$hasil['run_m160'] = '';
					//$fp=fopen("dataluar.txt","w");
					//fwrite($fp,$a);
					if (strpos(strtolower($data_mat->family), 'foam') !== false && strpos(strtolower($data_mat->type), 'dacron') !== false && strpos(strtolower($data_mat->unit_name), 'kg') !== false && strpos(strtolower($data_mat->nama_barang), 'gulung') === false){
						$consum_m = '';
						$hasil['height']		= '';
						$mywidth		= '';
						$consum 	= '';
						$kilo 		= $a;
					} else if (strpos(strtolower($data_mat->family), 'hardware') !== false){
						$consum_m = '';
						$kilo 		= '';
						$mywidth		= '';
						if (strpos(strtolower($data_mat->unit_name), 'yds') !== false || strpos(strtolower($data_mat->unit_name), 'roll') !== false){
							$consum 	= $a;
						} else {
							$consum 	= '';
						}
					} else if (strpos(strtolower($data_mat->family), 'zipper') !== false) {
						$consum 	= '';
						$kilo 		= '';
						if (strpos(strtolower($data_mat->unit_name), 'roll') !== false || strpos(strtolower($data_mat->unit_name), 'meter') !== false){
							$consum_m = $a/1000;
							$mywidth=$data_mat->size_width;
						} else {
							$consum_m = $a;
							$mywidth='';
						}
					} else if (strpos(strtolower($data_mat->family), 'yarn') !== false || strpos(strtolower($data_mat->family), 'webbing') !== false || strpos(strtolower($data_mat->family), 'perekat') !== false){
						$consum 	= '';
						$consum_m = $a/1000;
						$kilo 		= '';
						if (strpos(strtolower($data_mat->family), 'webbing') !== false || strpos(strtolower($data_mat->family), 'perekat') !== false){
							$mywidth = $data_mat->size_width;
						}else{
							$mywidth='';
						}
					} else {
						$consum 	= $a;
						$consum_m = '';
						$kilo 		= '';
						$mywidth='';
					}
					
					$hasil['consum']		= $consum;
					$hasil['consum_m']	= $consum_m;
					$hasil['kilo']			= $kilo;
					$hasil['width']			= $mywidth;
					if ($kilo=='' && strpos(strtolower($data_mat->family), 'foam') !== false && strpos(strtolower($data_mat->type), 'dacron') === false){
						$hasil['height']		= $data_mat->size_height;
					} else {
						$hasil['height']		= '';
					}
				}
			
			}
		} else{
		
			$hasil['sqf_25'] 		= '';
			$hasil['sqf_28'] 		= '';
			$hasil['sqf_3048'] 	= '';
			$hasil['kode_barang'] 	= '';
			
			$hasil['run_m140'] 	= '';
			$hasil['run_m150'] 	= '';
			$hasil['run_m160'] 	= '';
			
			$hasil['consum']		= '';
			$hasil['consum_m']	= '';
			$hasil['kilo']			= '';
			$hasil['height']		= '';
			$hasil['width']		= '';
		}
		
		return $hasil;
	}
}
	
/* End of file app_model.php */
/* Location: ./application/models/app_model.php */