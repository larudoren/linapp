<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_json extends CI_Controller {

	public function CariNoSJ(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodebeli) as no FROM h_beli";
		$data = $this->app_model->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,5))+1;
				$hasil = 'BL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'BL'.'00001';
		}
		return $hasil;
	}
	
	public function InfoBarang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT barang.kode_barang, barang.nama_barang, unit.unit_name, departemen_fact.dept_name 
						FROM barang 
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen_fact ON departemen_fact.dept_code=barang.departemen
						WHERE barang.kode_barang='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['nama_barang'] = $t->nama_barang;
					$data['satuan'] = $t->unit_name;
					$data['departemen'] = $t->dept_name;
					echo json_encode($data);
				}
			}else{
					$data['nama_barang'] = '';
					$data['satuan'] = '';
					$data['departemen'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function GeneratePo(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$th = date('y');
			$lilo = $this->input->post('lilo');
			$bin = strtoupper($lilo);
			
			if($bin=="LOC") {
				$local = '1';
			}
			else {
				$local = '2';
			}
			
			$text = "SELECT MAX(po) as no FROM h_beli WHERE po LIKE '__".$local."____'";

			$table = $this->app_model->manualQuery($text);
			if($table->num_rows() > 0) {
				foreach($table->result() as $row) {
					$no = $row->no;
					$tmp = ((int) substr($no,4,4))+1;
					$data['hasil'] = $th.$local.sprintf("%04s", $tmp);
					$text2 = "INSERT INTO h_beli (po) VALUES ('".$data['hasil']."')";
					//$text3 = "INSERT INTO d_beli (po) VALUES ('".$data['hasil']."')";
					$this->app_model->manualQuery($text2);
					//$this->app_model->manualQuery($text3);
					echo json_encode($data);
				}
			}
			else {
				$data['hasil'] = $th.$local.'0001';
				$text2 = "INSERT INTO h_beli (po) VALUES ('".$data['hasil']."')";
				//$text3 = "INSERT INTO d_beli (po) VALUES ('".$data['hasil']."')";
				$this->app_model->manualQuery($text2);
				//$this->app_model->manualQuery($text3);
				echo json_encode($data);
			}
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoTerima()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT barang.kode_barang, barang.nama_barang, unit.unit_name, departemen_fact.dept_name
						FROM barang 
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen_fact ON departemen_fact.dept_code=barang.departemen
						WHERE barang.kode_barang='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['nama_barang'] = $t->nama_barang;
					$data['satuan'] = $t->unit_name;
					$data['departemen'] = $t->dept_name;
					echo json_encode($data);
				}
			}else{
					$data['nama_barang'] = '';
					$data['satuan'] = '';
					$data['departemen'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoSupplier()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT * FROM supplier WHERE supplier_code='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['tgl'] = $t->supplier_date;
					$data['nama'] = $t->supplier_name;
					$data['alamat'] = $t->supplier_address;
					$data['negara'] = $t->supplier_state;
					$data['telp'] = $t->supplier_phone;
					$data['fax'] = $t->supplier_fax;
					$data['mobile'] = $t->supplier_mobile;
					$data['email'] = $t->supplier_email;
					echo json_encode($data);
				}
			}else{
				$data['tgl'] = '';
				$data['nama'] = '';
				$data['alamat'] = '';
				$data['negara'] = '';
				$data['telp'] = '';
				$data['fax'] = '';
				$data['mobile'] = '';
				$data['email'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function InfoCustomer()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT A.cust_name,A.cust_phone,A.cust_fax,A.cust_mobile,A.cust_email,B.negara FROM customer A LEFT OUTER JOIN negara B ON B.negara_code=A.cust_country WHERE A.cust_code='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['nama'] = urldecode($t->cust_name);
					$data['negara'] = $t->negara;
					$data['telp'] = $t->cust_phone;
					$data['fax'] = $t->cust_fax;
					$data['mobile'] = $t->cust_mobile;
					$data['email'] = $t->cust_email;
					echo json_encode($data);
				}
			}else{
				$data['tgl'] = '';
				$data['nama'] = '';
				$data['alamat'] = '';
				$data['negara'] = '';
				$data['telp'] = '';
				$data['fax'] = '';
				$data['mobile'] = '';
				$data['email'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataBarang(){ 									// Pembelian
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$cari= $this->input->post('cari');
			/*if(empty($cari)){
				$text = "SELECT barang.kode_barang, barang.kode_lama, barang.nama_barang, unit.unit_name, departemen.dept_name
						FROM barang
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen ON departemen.dept_code=barang.departemen
						ORDER BY barang.kode_barang";
			}else{*/
				$text = "SELECT barang.kode_barang, barang.kode_lama, barang.nama_barang, unit.unit_name, departemen.dept_name
						FROM barang
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen ON departemen.dept_code=barang.departemen
						WHERE kode_barang LIKE '%$cari%' OR kode_lama LIKE '%$cari%' OR nama_barang LIKE '%$cari%'";
			//}
			$d['data'] = $this->app_model->manualQuery($text);
			//$d['data'] = $this->app_model->prepare($text);
			
			$this->load->view('data_barang',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataBarang1(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			if (!empty($this->input->get_post('q'))){
				$cari = $this->input->get_post('q');
			} else {
				$cari = '';
			}
			$text = "SELECT barang.kode_barang, barang.kode_lama, barang.nama_barang, unit.unit_name, departemen_fact.dept_name
					FROM barang
					LEFT OUTER JOIN unit ON unit.unit_code=barang.satuan
					LEFT OUTER JOIN departemen_fact ON departemen_fact.dept_code=barang.departemen
					WHERE kode_barang LIKE '%$cari%' OR kode_lama LIKE '%$cari%' OR nama_barang LIKE '%$cari%'";
			$tabel = $this->app_model->manualQuery($text);
			
			$row =$tabel->num_rows();
			$temp = 0;
			if ($row>0){
				foreach($tabel->result() as $t){
					$data[$temp]['kode_barang'] = $t->kode_barang;
					$data[$temp]['kode_lama'] = $t->kode_lama;
					$data[$temp]['nama_barang'] = $t->nama_barang;
					$data[$temp]['unit_name'] = $t->unit_name;
					$data[$temp]['dept_name'] = $t->dept_name;
					$temp++;
				}
			} else {
				$data[$temp]['kode_barang'] = '';
				$data[$temp]['kode_lama'] = '';
				$data[$temp]['nama_barang'] = '';
				$data[$temp]['unit_name'] = '';
				$data[$temp]['dept_name'] = '';
			}
			//$d['data'] = $this->app_model->manualQuery($text);
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
			//$this->load->view('data_barang',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	
	public function DataCustomer(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM customer WHERE cust_code<>'000'";
			}else{
				$text = "SELECT * FROM customer	WHERE cust_code LIKE '%$cari%' OR cust_name LIKE '%$cari%' AND cust_code<>'000'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_customer',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataIDCotation(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$product_code= $this->input->post('product_code');
			$text = "SELECT id_cotation from h_cotation where product_code='$product_code'";
			$tabel = $this->app_model->manualQuery($text);
			$row =$tabel->num_rows();
			if ($row>0){
				foreach($tabel->result() as $t){
					$hasil = $t->id_cotation;
				}
			} else {
				$hasil = '';
			}
			echo $hasil;
			//$this->load->view('data_accessories',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataTerima(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT barang.kode_barang, barang.nama_barang, unit.unit_name, departemen.dept_name
						FROM barang
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen ON departemen.dept_code=barang.departemen
						ORDER BY barang.kode_barang";
			}else{
				$text = "SELECT barang.kode_barang, barang.nama_barang, unit.unit_name, departemen.dept_name
						FROM barang
						JOIN unit ON unit.unit_code=barang.satuan
						JOIN departemen ON departemen.dept_code=barang.departemen
						WHERE kode_barang LIKE '%$cari%' OR nama_barang LIKE '%$cari%'";
			}
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('data_terima',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataPropinsi(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$negara_code= $this->input->get('kode');
			$text = "SELECT propinsi_code,propinsi from propinsi where negara_code='$negara_code' ORDER BY Propinsi";
			
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['propinsi_code'] = $t->propinsi_code;
					$data['propinsi'] = $t->propinsi;
					echo json_encode($data);
				}
			}else{
				$data['propinsi_code'] = '';
				$data['propinsi'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataKota(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$propinsi_code= $this->input->post('kode');
			$text = "SELECT kota_code,kota from kota where propinsi_code='$propinsi_code' ORDER BY Kota";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['kota_code'] = $t->kota_code;
					$data['kota'] = $t->kota;
					echo json_encode($data);
				}
			}else{
				$data['kota_code'] = '';
				$data['kota'] = '';
				echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataNegara(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$text = "SELECT negara_code,negara from negara ORDER BY negara";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['negara_code'] = $t->negara_code;
					$data['negara'] = $t->negara;
					//echo json_encode($data);
				}
			}else{
				$data['negara_code'] = '';
				$data['negara'] = '';
				//echo json_encode($data);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataMaterial(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kode = $this->input->post('kode');
			$text = "SELECT B.family FROM barang A LEFT OUTER JOIN family B on B.family_id=A.family where A.kode_barang='$kode'";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$data['family'] = $t->family;
				}
			}else{
				$data['family'] = '';
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataMaterial1(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$dept = $this->uri->segment(3);
			if (empty($dept))
				$on = "";
			else
				$on =" and E.$dept='1'";
			$kode = $this->uri->segment(4);
			if (empty($kode) OR $kode=='null')
				$tempKode = "";
			else
				$tempKode = " and A.family='$kode'";
			if ($dept=='upholstery'){
				$text = "SELECT distinct(A.kode_barang),A.nama_barang,A.family,E.family as family_name,A.average_waste,A.brg_harga,C.currency_name,C.rates,D.convertion,D.convertion_hrg,D.unit_name,A.size_length,A.size_width,A.size_height,F.simbol as length_unit,G.type as tipe,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_comp FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen LEFT OUTER JOIN currency C on c.currency_id=A.brg_currency LEFT OUTER JOIN `unit` D on D.unit_code=A.satuan LEFT OUTER JOIN family E on E.family_id=A.family $on LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=A.size_length_unit LEFT OUTER JOIN `type` G on G.type_id=A.`type` where (A.nama_barang!='' OR A.nama_barang_eng!='') and A.nama_barang like '%$q%' and B.dept_code='UPHOLD' $tempKode";
			} else if ($dept=='wood'){
				$text = "SELECT distinct(A.kode_barang),A.nama_barang,A.family,E.family as family_name,A.average_waste,A.brg_harga,C.currency_name,C.rates,D.convertion,D.convertion_hrg,D.unit_name,A.size_density as size_length,A.size_width,A.size_height,F.simbol as length_unit,G.type as tipe,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_comp FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen LEFT OUTER JOIN currency C on c.currency_id=A.brg_currency LEFT OUTER JOIN `unit` D on D.unit_code=A.satuan LEFT OUTER JOIN family E on E.family_id=A.family LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=A.size_density_unit LEFT OUTER JOIN `type` G on G.type_id=A.`type` where (A.nama_barang!='' OR A.nama_barang_eng!='') and A.nama_barang like '%$q%' and B.dept_name='Wood'";
			} else if ($dept=='glue'){
				$text = "SELECT distinct(A.kode_barang),A.nama_barang,A.family,E.family as family_name,A.average_waste,A.brg_harga,C.currency_name,C.rates,D.convertion,D.convertion_hrg,D.unit_name,A.size_density as size_length,A.size_width,A.size_height,F.simbol as length_unit,G.type as tipe,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_comp FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen LEFT OUTER JOIN currency C on c.currency_id=A.brg_currency LEFT OUTER JOIN `unit` D on D.unit_code=A.satuan LEFT OUTER JOIN family E on E.family_id=A.family LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=A.size_density_unit LEFT OUTER JOIN `type` G on G.type_id=A.`type` where (A.nama_barang!='' OR A.nama_barang_eng!='') and A.nama_barang like '%$q%' and E.family='Glue'";
			} else if ($dept=='panel'){
				$text = "SELECT distinct(A.kode_barang),A.nama_barang,A.family,E.family as family_name,A.average_waste,A.brg_harga,C.currency_name,C.rates,D.convertion,D.convertion_hrg,D.unit_name,A.size_length,A.size_width,A.size_height,F.simbol as length_unit,G.type as tipe,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_comp FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen LEFT OUTER JOIN currency C on c.currency_id=A.brg_currency LEFT OUTER JOIN `unit` D on D.unit_code=A.satuan LEFT OUTER JOIN family E on E.family_id=A.family LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=A.size_length_unit LEFT OUTER JOIN `type` G on G.type_id=A.`type` where (A.nama_barang!='' OR A.nama_barang_eng!='') and A.nama_barang like '%$q%' and B.dept_name='Panel'";
			} else if ($dept=='accessories'){
				$text = "SELECT distinct(A.kode_barang),A.nama_barang,A.family,E.family as family_name,A.average_waste,A.brg_harga,C.currency_name,C.rates,D.convertion,D.convertion_hrg,D.unit_name,A.size_length,A.size_width,A.size_height,F.simbol as length_unit,G.type as tipe,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_comp FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen LEFT OUTER JOIN currency C on c.currency_id=A.brg_currency LEFT OUTER JOIN `unit` D on D.unit_code=A.satuan LEFT OUTER JOIN family E on E.family_id=A.family LEFT OUTER JOIN t_unit_ukuran F on F.unit_ukuran_id=A.size_length_unit LEFT OUTER JOIN `type` G on G.type_id=A.`type` where (A.nama_barang!='' OR A.nama_barang_eng!='') and A.nama_barang like '%$q%' and B.dept_name LIKE '%Accessories%'";
			}
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['kode_barang'] = $t->kode_barang;
					$data[$temp]['nama_barang'] = $t->nama_barang;
					$data[$temp]['family'] = $t->family;
					$data[$temp]['family_name'] = $t->family_name;
					$data[$temp]['average_waste'] = $t->average_waste;
					$data[$temp]['brg_harga'] = $t->brg_harga;
					$data[$temp]['currency_name'] = $t->currency_name;
					$data[$temp]['size_length'] = $t->size_length;
					$data[$temp]['size_width'] = $t->size_width;
					$data[$temp]['size_height'] = $t->size_height;
					$data[$temp]['unit_name'] = $t->unit_name;
					$data[$temp]['length_unit'] = $t->length_unit;
					$data[$temp]['type'] = $t->tipe;
					$data[$temp]['rates'] = $t->rates;
					$data[$temp]['waste_log_plank'] = $t->waste_log_plank;
					$data[$temp]['waste_plank_raw'] = $t->waste_plank_raw;
					$data[$temp]['waste_raw_comp'] = $t->waste_raw_comp;
					$temp++;
				}
			}else{
				$data[0]['kode_barang'] = '';
				$data[0]['nama_barang'] = '';
				$data[0]['family'] = '';
				$data[0]['family_name'] = '';
				$data[0]['average_waste'] = '';
				$data[0]['brg_harga'] = '';
				$data[0]['currency_name'] = '';
				$data[0]['size_length'] = '';
				$data[0]['size_width'] = '';
				$data[0]['size_height'] = ''; 
				$data[0]['unit_name'] = '';
				$data[0]['length_unit'] = '';
				$data[0]['type'] = '';
				$data[0]['rates'] = '';
				$data[0]['waste_log_plank'] = '';
				$data[0]['waste_plank_raw'] = '';
				$data[0]['waste_raw_comp'] = '';
			}
			
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataFamily(){											// Barang or Material
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$dept = $this->uri->segment(3);
			$cat = $this->uri->segment(4);
			
			if (!empty($cat) && $cat!='-'){
				$textdept = "SELECT category_id from category where category like '%".ucfirst($cat)."%' and companyarea='$loc'";
			} else {
				$textdept = "SELECT category_id from category where category='' and companyarea='$loc'";
			}
			$tabelcat = $this->app_model->manualQuery($textdept);
			
			$tmprows = $tabelcat->num_rows();
			if ($tmprows>0){
				foreach($tabelcat->result() as $t){
					$tempcat =  $t->category_id;
				}
			} else{
				$tempcat = '';
			}
			$tpos = strpos($dept,",");
			if (!empty($tempcat)){
				if ($tpos !== false){
					$t_dept = explode(",",$dept);
					$where = "where departemen IN ('$t_dept') and category like '%$tempcat%' and companyarea='$loc'";
				} else {
					$where = "where departemen like '%$dept%' and category like '%$tempcat%' and companyarea='$loc'";
				}
			}else{
				if ($tpos !== false){
					$t_dept = explode(",",$dept);
					$where ="where departemen IN ('$t_dept') and companyarea='$loc'";
				} else {
					$where ="where departemen like '%$dept%' and companyarea='$loc'";
				}
			}
			
			$text = "SELECT A.family_id,A.family FROM family A $where";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['family_id'] = $t->family_id;
					$data[$temp]['family'] = $t->family;
					$temp++;
				}
			}else{
				$data[0]['family_id'] = '';
				$data[0]['family'] = '-';
			}
			
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataFamilyCot(){											// Cotation Upholstery
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
					
			$where ="where departemen like '%UPHOLD%' and upholstery='1' and companyarea='$loc'";
			
			$text = "SELECT A.family_id,A.family FROM family A $where";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['family_id'] = $t->family_id;
					$data[$temp]['family'] = $t->family;
					$temp++;
				}
			}else{
				$data[0]['family_id'] = '';
				$data[0]['family'] = '-';
			}
			
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxCustomer(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$text = "SELECT A.cust_code,A.cust_name,B.negara FROM customer A LEFT OUTER JOIN negara B ON B.negara_code=A.cust_country where A.companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['cust_code'] = $t->cust_code;
					$data[$temp]['cust_name'] = $t->cust_name;
					$data[$temp]['negara'] = $t->negara;
					$temp++;
				}
			}else{
				$data[0]['cust_code'] = '';
				$data[0]['cust_name'] = '';
				$data[0]['negara'] = '';
			}
			
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxLayer(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$dept = $this->uri->segment(3);
			$text = "SELECT A.layer_id,A.layer FROM layer A where A.companyarea='$loc' and $dept='1'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['layer_id'] = $t->layer_id;
					$data[$temp]['layer'] = $t->layer;
					$temp++;
				}
			}else{
				$data[0]['layer_id'] = '';
				$data[0]['layer'] = '';
			}
			
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxDepartemen(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$text = "SELECT A.dept_code,A.dept_name FROM departemen_fact A where A.companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data = array();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['dept_code'] = $t->dept_code;
					$data[$temp]['dept_name'] = $t->dept_name;
					$temp++;
				}
			}
			
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataType(){										// Barang or Material
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$dept = $this->uri->segment(3);
			$family = $this->uri->segment(4);
			
			$textdept = "SELECT dept_code from departemen_fact where dept_name like '%".ucfirst($dept)."%' and companyarea='$loc'";
			$tabeldept = $this->app_model->manualQuery($textdept);

			$tmprows = $tabeldept->num_rows();
			if ($tmprows>0){
				foreach($tabeldept->result() as $t){
					$tempdept =  $t->dept_code;
				}
			} else{
				$tempdept = '';
			}
			if (!empty($family)){
				$where = "where departemen like '%$tempdept%' and family='$family' and companyarea='$loc'";
			}else{
				$where = "where departemen like '%$tempdept%' and companyarea='$loc'";
			}
			//else
			//	$where ="where companyarea='$loc'";
				
			$text = "SELECT A.type_id,A.type FROM `type` A $where ";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['type_id'] = $t->type_id;
					$data[$temp]['type'] 		= $t->type;
					$temp++;
				}
			}else{
				$data[0]['type_id'] = '';
				$data[0]['type'] = '-';
			}
			
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataCategory(){							// Barang or Material
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$dept = $this->uri->segment(3);
			if ($dept!=''){
			$textdept = "SELECT dept_code from departemen_fact where dept_name like '%".ucfirst($dept)."%' and companyarea='$loc'";
			$tabeldept = $this->app_model->manualQuery($textdept);
			
			$tmprows = $tabeldept->num_rows();
			if ($tmprows>0){
				foreach($tabeldept->result() as $t){
					$tempdept =  $t->dept_code;
				}
			} else{
				$tempdept = '';
			}
			
			$where = "where departemen like '%$tempdept%' and companyarea='$loc'";
			} else {
				$where = "where companyarea='$loc'";
			}
			$text = "SELECT A.category_id,A.category FROM category A $where ";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['category_id'] = $t->category_id;
					$data[$temp]['category'] 		= $t->category;
					$temp++;
				}
			} else {
				$data[0]['category_id'] = '';
				$data[0]['category'] 		= '-';
			}
			
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataTerimaBarang(){
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$dept = $this->input->post('departemen');
			if (empty($dept)){
				$dept = '';
			}
			$cari= $this->input->post('cari');
			if (empty($cari)){
				$cari='';
				$limit = ' LIMIT 50 OFFSET 0';
			} else {
				$limit = '';
			}
			/*
			$page=$this->input->post('limit');
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT barang.kode_barang, barang.kode_lama, barang.nama_barang, unit.unit_name, departemen_fact.dept_name
					FROM barang
					LEFT OUTER JOIN unit ON unit.unit_code=barang.satuan
					LEFT OUTER JOIN departemen_fact ON departemen_fact.dept_code=barang.departemen
					WHERE departemen_fact.dept_code='$dept' and (kode_barang LIKE '%$cari%' OR kode_lama LIKE '%$cari%' OR nama_barang LIKE '%$cari%')
					ORDER BY barang.nama_barang";
			$tot_hal = $this->app_model->manualQuery($text);		
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = "javascript:halaman($page)";
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			//$config['uri_segment'] = 3;
			$config['next_link'] = 'Lanjut &raquo;';
			$config['prev_link'] = '&laquo; Kembali';
			$config['last_link'] = '<b>Terakhir &raquo; </b>';
			$config['first_link'] = '<b> &laquo; Pertama</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset; */
			
			$text = "SELECT barang.kode_barang, barang.kode_lama, barang.nama_barang, unit.unit_name, departemen_fact.dept_name
					FROM barang
					LEFT OUTER JOIN unit ON unit.unit_code=barang.satuan
					LEFT OUTER JOIN departemen_fact ON departemen_fact.dept_code=barang.departemen
					WHERE departemen_fact.dept_code='$dept' and (kode_barang LIKE '%$cari%' OR kode_lama LIKE '%$cari%' OR nama_barang LIKE '%$cari%')
					ORDER BY barang.nama_barang
					$limit";
			$d['data'] = $this->app_model->manualQuery($text);
			$this->load->view('data_barang1',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataTypeMaterial(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$tipe = $this->uri->segment(3);
			
			$textdept = "SELECT dept_code from departemen_fact where dept_name like '%".ucfirst($tipe)."%' and companyarea='$loc'";
			$tabeldept = $this->app_model->manualQuery($textdept);

			$tmprows = $tabeldept->num_rows();
			if ($tmprows>0){
				foreach($tabeldept->result() as $t){
					$tempdept =  $t->dept_code;
				}
			} else{
				$tempdept = '';
			}
			
			$where = "where departemen='$tempdept' and companyarea='$loc'";
			
			$text = "SELECT A.kode_barang,A.nama_barang FROM barang A $where ";
			$tabel = $this->app_model->manualQuery($text);
			$data = array();
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['kode_material'] = $t->kode_barang;
					$data[$temp]['nama_material'] = $t->nama_barang;
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxProduction(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$text = "SELECT * FROM production_type where companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$data = array();
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['production_id'] = $t->production_id;
					$data[$temp]['production'] = $t->production;
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxProduct(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$category = $this->uri->segment(3);
			
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			$data = array();
			$text = "SELECT count(*) as total FROM product A LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll where A.companyarea='$loc' /* and A.category='$category' */ and A.product_code like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.product_code,B.coll_name,A.product_name,A.category FROM product A LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll where A.companyarea='$loc' /* and A.category='$category' */ and A.product_code like '%$q%' limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['product_code'] = htmlentities($t->product_code);
					$data[$temp]['coll_name'] = htmlentities($t->coll_name);
					$data[$temp]['product_name'] = htmlentities($t->product_name);
					//$data[$temp]['category'] = htmlentities($t->category);
					$temp++;
				}
			}
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxAccessories(){			// Product Detail
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			$data = array();
			$text = "SELECT count(*) as total FROM barang A where A.departemen='ACCHRD' and A.companyarea='$loc' and A.nama_barang like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.kode_barang,A.nama_barang,A.kode_barang_spc,A.size_length,A.size_width,A.size_height 
							 FROM barang A 
							 where A.departemen='ACCHRD' and A.companyarea='$loc' and A.nama_barang like '%$q%' limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['kode_barang'] = $t->kode_barang;
					$data[$temp]['nama_barang'] = htmlentities($t->nama_barang);
					$data[$temp]['kode_barang_spc'] = $t->kode_barang_spc;
					$data[$temp]['length'] = $t->size_length;
					$data[$temp]['width'] = $t->size_width;
					$data[$temp]['height'] = $t->size_height;
					$temp++;
				}
			}
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxAllMaterial(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			$data = array();
			$text = "SELECT count(*) as total FROM barang A where A.companyarea='$loc' and A.nama_barang like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.kode_barang,A.nama_barang,A.kode_barang_spc,A.size_length,A.size_width,A.size_height,A.size_diameter,A.size_diameterin,B.unit_name ,C.finishing
							 FROM barang A 
							 LEFT OUTER JOIN unit B ON B.unit_code=A.satuan 
							 LEFT OUTER JOIN finishing C ON C.finishing_id=A.finishing
							 where A.companyarea='$loc' and A.nama_barang like '%$q%' limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['kode_barang'] 		= $t->kode_barang;
					$data[$temp]['nama_barang'] 		= htmlentities($t->nama_barang);
					$data[$temp]['kode_barang_spc'] = $t->kode_barang_spc;
					$data[$temp]['length'] 					= number_format($t->size_length,0);
					$data[$temp]['width'] 					= number_format($t->size_width,0);
					$data[$temp]['height'] 					= number_format($t->size_height,0);
					$data[$temp]['unit_name'] 			= $t->unit_name;
					$data[$temp]['diameter'] 				= $t->size_diameter;
					$data[$temp]['diameterin'] 				= $t->size_diameterin;
					$data[$temp]['finishing'] 			= $t->finishing;
					$temp++;
				}
			}
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxAllMaterialTurunan(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$turunan = isset($_POST['turunan']) ? strval($_POST['turunan']) : '';
			$departemen = isset($_POST['departemen']) ? strval($_POST['departemen']) : '';
			$nama_barang = isset($_POST['nama_barang']) ? strval($_POST['nama_barang']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			$data = array();
			if ($departemen!=''){
				$qdepartemen =" AND A.departemen='$departemen'";
			} else {
				$qdepartemen="";
			}
			
			if ($turunan!=''){
				$tquery = "SELECT A.nama_barang FROM barang A where A.kode_barang='$turunan' AND A.turunan=''";
				$ttabel = $this->app_model->manualQuery($tquery);
				$tq ="";
				foreach($ttabel->result() as $tr){
					if ($tr->nama_barang==$q || $q==''){
					$tq = " AND A.nama_barang like '%".$tr->nama_barang."%'";
					} 
				}
			} else{
				$tq="";
			}
			
			$tq .= " AND A.nama_barang!='$nama_barang'";
			
			$text = "SELECT count(*) as total FROM barang A where A.companyarea='$loc' and A.nama_barang like '%$q%' $tq $qdepartemen";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.kode_barang,A.nama_barang,A.kode_barang_spc,A.size_length,A.size_width,A.size_height,A.size_diameter,A.size_diameterin,B.unit_name ,C.finishing
							 FROM barang A 
							 LEFT OUTER JOIN unit B ON B.unit_code=A.satuan 
							 LEFT OUTER JOIN finishing C ON C.finishing_id=A.finishing
							 where A.companyarea='$loc' $tq $qdepartemen and A.nama_barang like '%$q%' ORDER BY A.nama_barang limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['kode_barang'] 		= $t->kode_barang;
					$data[$temp]['nama_barang'] 		= htmlentities($t->nama_barang);
					$data[$temp]['kode_barang_spc'] = $t->kode_barang_spc;
					$data[$temp]['length'] 					= number_format($t->size_length,0);
					$data[$temp]['width'] 					= number_format($t->size_width,0);
					$data[$temp]['height'] 					= number_format($t->size_height,0);
					$data[$temp]['unit_name'] 			= $t->unit_name;
					$data[$temp]['diameter'] 				= $t->size_diameter;
					$data[$temp]['diameterin'] 				= $t->size_diameterin;
					$data[$temp]['finishing'] 			= $t->finishing;
					$temp++;
				}
			}
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxAllSupplier(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			$data = array();
			
			$text = "SELECT count(*) as total FROM supplier A where A.companyarea='$loc' and A.supplier_name like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_address,A.supplier_country
							 FROM supplier A 
							 where A.companyarea='$loc' and A.supplier_name like '%$q%' limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['supplier_code'] 		= $t->supplier_code;
					$data[$temp]['supplier_name'] 		= htmlentities($t->supplier_name);
					$data[$temp]['supplier_address'] = $t->supplier_address;
					$data[$temp]['supplier_country'] 					= $t->supplier_country;
					$temp++;
				}
			}
			
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxPIAllSupplier(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
			$pi = $this->input->post('pi');
			$po_date = $this->input->post('po_date');
			$offset = ($page-1)*$rows;
			$data = array();
		
			$text = "SELECT count(*) as total FROM supplier A where A.companyarea='$loc' and A.supplier_name like '%$q%' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_barangsup R where R.kode_barang=A.kode_barang and R.tgl <= str_to_date('$po_date','%d-%m-%Y') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipo A JOIN pi B ON B.pi_id=A.pi_id where B.pi_number='$pi') K /* where supplier_code<>'' */)";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_address,A.supplier_country
							 FROM supplier A 
							 where A.companyarea='$loc' and A.supplier_name like '%$q%' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_barangsup R where R.kode_barang=A.kode_barang and R.tgl <= str_to_date('$po_date','%d-%m-%Y') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipo A JOIN pi B ON B.pi_id=A.pi_id where B.pi_number='$pi') K /* where supplier_code<>'' */) limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['supplier_code'] 		= $t->supplier_code;
					$data[$temp]['supplier_name'] 		= htmlentities($t->supplier_name);
					$data[$temp]['supplier_address'] = $t->supplier_address;
					$data[$temp]['supplier_country'] 					= $t->supplier_country;
					$temp++;
				}
			}
			
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxPISupplierBox(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
			$pi = $this->input->post('pi');
			$po_date = $this->input->post('po_date');
			$offset = ($page-1)*$rows;
			$data = array();
		
			$text = "SELECT count(*) as total FROM supplier A where A.companyarea='$loc' and A.supplier_name like '%$q%' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_boxsup R where R.product_code=C.product_code and R.tgl <= str_to_date('$po_date','%d-%m-%Y') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipobox A JOIN pi B ON B.pi_id=A.pi_id JOIN d_pi C ON C.pi_id=B.pi_id where B.pi_number='$pi') K /* where supplier_code<>'' */)";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_address,A.supplier_country
							 FROM supplier A 
							 where A.companyarea='$loc' and A.supplier_name like '%$q%' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_boxsup R where R.product_code=C.product_code and R.tgl <= str_to_date('$po_date','%d-%m-%Y') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipobox A JOIN pi B ON B.pi_id=A.pi_id JOIN d_pi C ON C.pi_id=B.pi_id where B.pi_number='$pi') K /* where supplier_code<>'' */) limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['supplier_code'] 		= $t->supplier_code;
					$data[$temp]['supplier_name'] 		= htmlentities($t->supplier_name);
					$data[$temp]['supplier_address'] = $t->supplier_address;
					$data[$temp]['supplier_country'] 					= $t->supplier_country;
					$temp++;
				}
			}
			
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxCodeSpc(){ 										// Cotation Accessories
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$fam = $this->uri->segment(3);
			$type = urldecode($this->uri->segment(4));
			/*
			if (empty($fam)){
				$where = "";
			} elseif ($fam=='Accessories') {
				$where = " AND B.family='$fam' ";
			} else {
				$where = " AND (B.family='$fam' OR B.family='Connector' OR B.family='Packing' OR B.family='Logo' OR B.family='Chemical' OR B.family='Glass' OR B.family='Hinge' OR B.family='Handle' OR B.family='Sepatu Glide' OR B.family='-') ";
			} */
			
			if (empty($type)){
				$where_type = "";
			} else {
				$where_type = " AND C.type='$type' ";
			}
			$data = array();
			//$text = "SELECT A.kode_barang_spc,A.type,A.kode_barang,A.nama_barang FROM barang A JOIN family B ON B.family_id=A.family where A.kode_barang_spc!='' and departemen='ACCHRD' and A.companyarea='$loc' and A.kode_barang_spc like '%$q%' ";
			$text = "SELECT A.kode_barang_spc,C.type,A.kode_barang,A.nama_barang,A.foto_barang,A.size_length,A.size_width,A.size_height,D.simbol as size_length_unit,A.size_diameter,E.simbol as size_diameter_unit,A.size_diameterin,F.simbol as size_diameterin_unit,G.unit_name,A.size_thread,H.finishing
							 FROM barang A 
							 JOIN family B ON B.family_id=A.family 
							 JOIN `type` C ON C.type_id=A.type 
							 LEFT OUTER JOIN t_unit_ukuran D ON D.unit_ukuran_id=A.size_length_unit
							 LEFT OUTER JOIN t_unit_ukuran E ON E.unit_ukuran_id=A.size_diameter_unit
							 LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=A.size_diameterin_unit
							 LEFT OUTER JOIN unit G ON G.unit_code=A.useper
							 LEFT OUTER JOIN finishing H ON H.finishing_id=A.finishing
							 where A.kode_barang_spc!='' and A.departemen='ACCHRD' $where_type and A.companyarea='$loc' and A.kode_barang_spc like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$size = '';
					$size1 = '';
					$data[$temp]['kode_barang_spc'] = $t->kode_barang_spc;
					$data[$temp]['type'] = $t->type;
					$data[$temp]['kode_barang'] = $t->kode_barang;
					$data[$temp]['nama_barang'] = $t->nama_barang;
					$data[$temp]['foto_barang'] = $t->foto_barang;
					if ($t->size_length!=0){
						$size = $size.'L '.number_format($t->size_length,0).' x ';
						$size1 = $size1.'L '.number_format($t->size_length,0).' ';
					}
					
					if ($t->size_width!=0){
						$size = $size.'W '.number_format($t->size_width,0).' x ';
						$size1 = $size1.'W '.number_format($t->size_width,0).' ';
					}
					
					if ($t->size_height!=0){
						$size = $size.'H '.number_format($t->size_height,0).' x ';
						$size1 = $size1.'H '.number_format($t->size_height,0).' ';
					}
					
					if ($size!=''){
						$size = substr($size,0,-3);
						if (empty($t->size_length_unit)){
							$size = $size.';  ';
							$size1 = $size1.';  ';
						} else {
							$size = $size.$t->size_length_unit.';  ';
							$size1 = $size1.$t->size_length_unit.';  ';
						}
					}
					
					if ($t->size_diameter!=0){
						$size = $size.'&#216; out   '.number_format($t->size_diameter,0).' ';
						$size1 = $size1.'Diameter out   '.number_format($t->size_diameter,0).' ';
						if (empty($t->size_diameter_unit)){
							$size = $size.';  ';
							$size1 = $size1.';  ';
						} else {
							$size = $size.$t->size_diameter_unit.';  ';
							$size1 = $size1.$t->size_diameter_unit.';  ';
						}
					}
					
					if ($t->size_diameterin!=0){
						$size = $size.'&#216; in   '.number_format($t->size_diameterin,0).' ';
						$size1 = $size1.'Diameter in   '.number_format($t->size_diameterin,0).' ';
						if (empty($t->size_diameterin_unit)){
							$size = $size.'; ';
							$size1 = $size1.'; ';
						} else {
							$size = $size.$t->size_diameterin_unit.'; ';
							$size1 = $size1.$t->size_diameterin_unit.'; ';
						}
					}
					
					if (!empty($t->size_thread)){
						$size = $size.$t->size_thread.';';
					}
					
					$data[$temp]['size'] = urldecode($size1);
					$data[$temp]['hidesize'] = urldecode($size);
					$data[$temp]['unit_name'] = $t->unit_name;
					$data[$temp]['finishing'] = $t->finishing;
					
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxType(){ 											// Cotation Accessories
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$fam = $this->uri->segment(3);
			/*
			if (empty($fam)){
				$where = "";
			} elseif ($fam=='Accessories') {
				$where = " AND C.family='$fam' ";
			} else {
				$where = " AND (C.family='$fam' OR C.family='Connector' OR B.family='Packing' OR B.family='Logo' OR B.family='Chemical' OR B.family='Glass' OR B.family='Hinge' OR B.family='Handle' OR B.family='Sepatu Glide' OR B.family='-') ";
			} */
			$data = array();
			
			$text = "select DISTINCT(A.type) from `type` A JOIN barang B ON B.type=A.type_id JOIN family C ON C.family_id=B.family where B.departemen='ACCHRD' and A.type like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['type'] = $t->type;
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxAccHrd(){							//Cotation Accessories
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
			$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
			$offset = ($page-1)*$rows;
			
			$fam = isset($_POST['fam']) ? strval($_POST['fam']) : '';
			$type = isset($_POST['type']) ? strval($_POST['type']) : '';
			/*
			if (empty($fam)){
				$where = "AND B.family='' ";
			} elseif ($fam=='Accessories') {
				$where = " AND B.family='$fam' ";
			} else {
				$where = " AND (B.family='$fam' OR B.family='Connector' OR B.family='Packing' OR B.family='Logo' OR B.family='Chemical' OR B.family='Glass' OR B.family='Hinge' OR B.family='Handle' OR B.family='Sepatu Glide' OR B.family='-') ";
			} */
			
			if (empty($type)){
				$where_type = "";
			} else {
				$where_type = " AND C.type='$type' ";
			}
			
			$data = array();
			
			$text = "SELECT count(A.kode_barang) as total 
							 FROM barang A LEFT OUTER JOIN family B ON B.family_id=A.family 
							 JOIN `type` C ON C.type_id=A.type 
							 LEFT OUTER JOIN t_unit_ukuran D ON D.unit_ukuran_id=A.size_length_unit
							 LEFT OUTER JOIN t_unit_ukuran E ON E.unit_ukuran_id=A.size_diameter_unit
							 LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=A.size_diameterin_unit
							 LEFT OUTER JOIN unit G ON G.unit_code=A.useper
							 LEFT OUTER JOIN finishing H on H.finishing_id=A.finishing
							 where A.departemen='ACCHRD' $where_type and A.companyarea='$loc' and A.nama_barang like '%$q%'";
			$tabel = $this->app_model->manualQuery($text);
			$vrow =1 ;
			foreach($tabel->result() as $tb){
				$vrow = $tb->total;
			}
			
			$text = "SELECT A.kode_barang_spc,C.type,A.kode_barang,A.nama_barang,A.foto_barang,A.size_length,A.size_width,A.size_height,D.simbol as size_length_unit,A.size_diameter,E.simbol as size_diameter_unit,A.size_diameterin,F.simbol as size_diameterin_unit,G.unit_name,A.size_thread,H.finishing
							 FROM barang A LEFT OUTER JOIN family B ON B.family_id=A.family 
							 JOIN `type` C ON C.type_id=A.type 
							 LEFT OUTER JOIN t_unit_ukuran D ON D.unit_ukuran_id=A.size_length_unit
							 LEFT OUTER JOIN t_unit_ukuran E ON E.unit_ukuran_id=A.size_diameter_unit
							 LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=A.size_diameterin_unit
							 LEFT OUTER JOIN unit G ON G.unit_code=A.useper
							 LEFT OUTER JOIN finishing H on H.finishing_id=A.finishing
							 where A.departemen='ACCHRD' $where_type and A.companyarea='$loc' and A.nama_barang like '%$q%' limit $rows OFFSET $offset";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$size = '';
					$size1 = '';
					$data[$temp]['kode_barang_spc'] = $t->kode_barang_spc;
					$data[$temp]['type'] = $t->type;
					$data[$temp]['kode_barang'] = $t->kode_barang;
					$data[$temp]['nama_barang'] = $t->nama_barang;
					$data[$temp]['foto_barang'] = $t->foto_barang;
					
					if ($t->size_length!=0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_length);
						$fraction = $t->size_length - $whole;
						if ($fraction > 0){
							$size = $size.'L '.number_format($t->size_length,1,',','.').' x ';
						} else {
							$size = $size.'L '.number_format($t->size_length,0,',','.').' x ';
						}
						$size1 = $size1.'L '.number_format($t->size_length,0).' ';
					}
					
					if ($t->size_width!=0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_width);
						$fraction = $t->size_width - $whole;
						if ($fraction > 0){
							$size = $size.'W '.number_format($t->size_width,1,',','.').' x ';
						} else {
							$size = $size.'W '.number_format($t->size_width,0,',','.').' x ';
						}
						$size1 = $size1.'W '.number_format($t->size_width,0).' ';
					}
					
					if ($t->size_height!=0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_height);
						$fraction = $t->size_height - $whole;
						if ($fraction > 0){
							$size = $size.'H '.number_format($t->size_height,1,',','.').' x ';
						} else {
							$size = $size.'H '.number_format($t->size_height,0,',','.').' x ';
						}
						$size1 = $size1.'H '.number_format($t->size_height,0).' ';
					}
					
					if ($size!=''){
						$size = substr($size,0,-3);
						if (empty($t->size_length_unit)){
							$size = $size.';  ';
							$size1 = $size1.';  ';
						} else {
							$size = $size.$t->size_length_unit.';  ';
							$size1 = $size1.$t->size_length_unit.';  ';
						}
					}
					
					if ($t->size_diameter!=0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameter);
						$fraction = $t->size_diameter - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; out   '.number_format($t->size_diameter,1).' ';
						} else {
							$size = $size.'&#216; out   '.number_format($t->size_diameter,0).' ';
						}
						$size1 = $size1.'Diameter out   '.number_format($t->size_diameter,0).' ';
						if (empty($t->size_diameter_unit)){
							$size = $size.';  ';
							$size1 = $size1.';  ';
						} else {
							$size = $size.$t->size_diameter_unit.';  ';
							$size1 = $size1.$t->size_diameter_unit.';  ';
						}
					}
					
					if ($t->size_diameterin!=0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameterin);
						$fraction = $t->size_diameterin - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,1).' ';
						} else {
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,0).' ';
						}
						$size1 = $size1.'Diameter in   '.number_format($t->size_diameterin,0).' ';
						if (empty($t->size_diameterin_unit)){
							$size = $size.'; ';
							$size1 = $size1.'; ';
						} else {
							$size = $size.$t->size_diameterin_unit.'; ';
							$size1 = $size1.$t->size_diameterin_unit.'; ';
						}
					}
					
					if (!empty($t->size_thread)){
						$size = $size.$t->size_thread.';';
					}
					
					$data[$temp]['size'] = urldecode($size1);
					$data[$temp]['hidesize'] = urldecode($size);
					$data[$temp]['unit_name'] = $t->unit_name;
					$data[$temp]['finishing'] = $t->finishing;
					
					$temp++;
				}
			}
			echo '{"total":'.$vrow.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxFinishing(){		//Cotation Accessories
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$q = isset($_POST['q']) ? strval($_POST['q']) : '';
			
			$data = array();
			
			$text = "SELECT finishing_id,finishing from finishing";
			$tabel = $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['finishing'] = $t->finishing;
					$temp++;
				}
			}
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function AmbilProduct(){			// Cotation
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$product_code= $this->input->post('kode');
			$data = array();
			
			$text = "SELECT A.product_code,B.coll_name,A.product_name
							 FROM product A 
							 LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll 
							 where A.companyarea='$loc' and A.product_code='$product_code' LIMIT 1";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['product_code'] = htmlentities($t->product_code);
					$data[$temp]['collection'] = htmlentities($t->coll_name);
					$data[$temp]['name'] = urldecode($t->product_name);
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function window_size(){
		if(isset($_POST['recordSize'])) {
			$height = $_POST['height'];
			$width = $_POST['width'];
			$_SESSION['screen_height'] = $height;
			$_SESSION['screen_width'] = $width;
			$data[0]['height'] = $height;
			$data[0]['width'] = $width;
			echo json_encode($data);
		}
	}
	
	public function ComboboxSizeBox(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$product_code = $this->input->post('product_code');
			$data = array();
			
			$text ="SELECT A.seq,A.boxnumber,A.lsize,A.wsize,A.hsize,A.kdown,A.typebox,A.lstyrofoam,A.wstyrofoam,A.hstyrofoam,A.linner,A.winner,A.hinner,A.lkarton,A.wkarton,A.hkarton,
										 A.louter,A.wouter,A.houter,A.volouter,A.remarks
							FROM cotation_packing A
							JOIN h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea
							WHERE B.product_code='$product_code' AND A.companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['seq'] = $t->seq;
					$data[$temp]['text'] = $t->boxnumber.' || '.$t->kdown.' || '.$t->typebox;
					$data[$temp]['boxnumber'] = $t->boxnumber;
					$data[$temp]['lsize'] = $t->lsize;
					$data[$temp]['wsize'] = $t->wsize;
					$data[$temp]['hsize'] = $t->hsize;
					$data[$temp]['kdown'] = $t->kdown;
					$data[$temp]['typebox'] = $t->typebox;
					$data[$temp]['lstyrofoam'] = $t->lstyrofoam;
					$data[$temp]['wstyrofoam'] = $t->wstyrofoam;
					$data[$temp]['hstyrofoam'] = $t->hstyrofoam;
					$data[$temp]['linner'] = $t->linner;
					$data[$temp]['winner'] = $t->winner;
					$data[$temp]['hinner'] = $t->hinner;
					$data[$temp]['lkarton'] = $t->lkarton;
					$data[$temp]['wkarton'] = $t->wkarton;
					$data[$temp]['hkarton'] = $t->hkarton;
					$data[$temp]['louter'] = $t->louter;
					$data[$temp]['wouter'] = $t->wouter;
					$data[$temp]['houter'] = $t->houter;
					$data[$temp]['volouter'] = $t->volouter;
					$data[$temp]['remarks'] = $t->remarks;
					$temp++;
				}
			}
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxCustomerPacking(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$data = array();
			$text = "SELECT A.cust_code,A.cust_name FROM customer A where A.companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data[0]['cust_code'] = '';
			$data[0]['cust_name'] = 'All';
			if($row>0){
				$temp=1;
				foreach($tabel->result() as $t){
					$data[$temp]['cust_code'] = $t->cust_code;
					$data[$temp]['cust_name'] = $t->cust_name;
					$temp++;
				}
			}
			echo json_encode($data);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function ComboboxTypebox(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$lshape = isset($_POST['lshape']) ? strval($_POST['lshape']) : '';
			$data = array();
			$data[0]['label'] = 'TB';
			$data[0]['value'] = 'TB';
			$data[1]['label'] = 'A1';
			$data[1]['value'] = 'A1';
			$data[2]['label'] = 'A3';
			$data[2]['value'] = 'A3';
			
			if ($lshape=='YES'){
				$data[3]['label'] = 'L Shape';
				$data[3]['value'] = 'L Shape';
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
}

/* End of file ref_json.php */
/* Location: ./application/controllers/ref_json.php */