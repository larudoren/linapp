<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessories_product extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$cari = $this->input->post('txt_cari');
			$tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			
			$where = " WHERE A.companyarea='$loc' and A.pi_number<>''";
			if(!empty($cari)){
				$where .= " AND A.pi_number LIKE '%$cari%'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Product Accessories";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.pi_number,A.seq,A.product_code,B.product_name
					FROM d_pi A
					LEFT OUTER JOIN product B ON B.product_code=A.product_code 
					LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
					LEFT OUTER JOIN brand D ON D.brand_code=C.coll_brand and D.companyarea=A.companyarea
					$where 
					ORDER BY A.product_code DESC ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/accessories_product/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['next_link'] = 'Next &raquo;';
			$config['prev_link'] = '&laquo; Prev';
			$config['last_link'] = '<b>Last &raquo; </b>';
			$config['first_link'] = '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT  A.pi_number,A.seq,A.product_code,B.product_name,C.coll_name,D.brand_name
					FROM d_pi A
					LEFT OUTER JOIN product B ON B.product_code=A.product_code 
					LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
					LEFT OUTER JOIN brand D ON D.brand_code=C.coll_brand and D.companyarea=A.companyarea
					$where 
					ORDER BY A.product_code DESC
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('accessories_product/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Product Accessories";
			
			//$kode	= $this->app_model->MaxKodeKeluar();
			$tgl	= date('Y-m-d');
			
			$d['stock_id']		= '';
			$d['tanggal']			= $tgl;
			$d['departemen']	= '';
			
			$text = "SELECT * FROM departemen_fact WHERE companyarea='$loc' and dept_code<>'000' ORDER BY dept_name";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('accessories_product/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Product Accessories";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_stock	WHERE stock_id='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['stock_id']		= $id;
					$d['tanggal']			= $db->tanggal;
					$d['departemen']	= $db->departemen;
				}
			}else{
					$d['stock_id']		=	$id;
					$d['tanggal']			=	'';
					$d['departemen']	= '';
			}
			
			$text = "SELECT * FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
		
			$d['content'] = $this->load->view('stock_opname/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul'] = "Accessories Card";
			
			$id = $this->uri->segment(3);
			$temp = explode('-', $id);
			$d['collection'] = $temp[2];
			$text = "SELECT A.pi_number,A.seq,A.product_code,B.pi_cust,C.cust_name,D.product_name,D.product_photo
							 FROM d_pi A
							 LEFT OUTER JOIN pi B ON B.pi_number=A.pi_number and B.companyarea=A.companyarea
							 LEFT OUTER JOIN customer C ON C.cust_code=B.pi_cust and C.companyarea=B.companyarea
							 LEFT OUTER JOIN product D ON D.product_code=A.product_code
							 WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]'";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$d['pi_number'] 		= $t->pi_number;
					$d['seq'] 					= $t->seq;
					$d['product_code'] 	= $t->product_code;
					$d['product_name'] 	= $t->product_name;
					$d['product_photo'] = $t->product_photo;
					$d['cust_name'] 		= $t->cust_name;
				}
			} else {
				$d['pi_number'] 		= '';
				$d['seq'] 					= '';
				$d['product_code'] 	= '';
				$d['product_name'] 	= '';
				$d['product_photo'] =	'';
				$d['cust_name']			= '';
			}
			
			$d['content'] = $this->load->view('accessories_product/detail', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus($pi_number, $seq, $kodebarang)
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			if (!empty($pi_number) && !empty($seq) && !empty($kodebarang)){ 
				$vkodebarang = explode(":",$kodebarang);
				$wherein = "";
				for ($i=0;$i<sizeof($vkodebarang);$i++){
					$wherein = $wherein."'".$vkodebarang[$i]."',";
				}
				$wherein = substr($wherein,0,-1);
			
				$this->app_model->manualQuery("DELETE FROM product_accessories WHERE pi_number='$pi_number' and seq='$seq' and companyarea='$loc' and kode_barang NOT IN ($wherein) ");
			}
			return 'Successful';			
		}else{
			header('location:'.base_url());
		}
	}
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$kode = $this->uri->segment(4);
			$this->app_model->manualQuery("DELETE FROM stock_opname WHERE stock_id='$id' AND kode_barang='$kode' and companyarea='$loc'");
			
			$this->edit();
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$vpi_number ='';
		$vseq ='';
		$vkodebarang ='';
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			
			for ($i=0;$i<$test['jml'];$i++){
				$up['quantity'] 	= $this->input->post('quantity_'.$i);
				$up['editedby'] 	= $user;
				$up['editedtime'] = $tgl;
				
				$id['pi_number']	= $this->input->post('pi_number_'.$i);
				$id['seq']				= $this->input->post('seq_'.$i);
				$id['kode_barang']= $this->input->post('kode_barang_'.$i);
				$id['companyarea']= $loc;
				
				if (empty($vpi_number)){
					$vpi_number = $this->input->post('pi_number_'.$i);
				}
				
				if (empty($vseq)){
					$vseq = $this->input->post('seq_'.$i);
				}
				
				$vkodebarang = $vkodebarang.$this->input->post('kode_barang_'.$i).':';
								
				$data = $this->app_model->getSelectedData("product_accessories",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("product_accessories",$up,$id);
				}else{
					$up['pi_number']	= $this->input->post('pi_number_'.$i);
					$up['seq']				= $this->input->post('seq_'.$i);
					$up['kode_barang']= $this->input->post('kode_barang_'.$i);
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("product_accessories",$up);
				}
			}
			
			$vkodebarang = substr($vkodebarang,0,-1);
			
			$result = $this->hapus($vpi_number, $vseq, $vkodebarang);
			//echo "Save data successful!";
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$id = $this->uri->segment(3);
			$temp = explode(':', $id);
			/*
			$text = "SELECT * FROM ((SELECT A.kode_barang, B.nama_barang,  A.quantity,'1' as ck
					FROM product_accessories A
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
					WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]' and A.companyarea='$loc' and B.departemen='ACCHRD')
					UNION (SELECT A.kode_barang,A.nama_barang, '0' as quantity,'0' as ck from barang A where A.departemen='ACCHRD' and A.companyarea='10000'))A ORDER BY A.nama_barang"; */
			$text = "SELECT * FROM ((
									SELECT A.kode_barang, B.nama_barang, B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread,  A.quantity,'1' as ck
									FROM product_accessories A
									JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
									JOIN d_pi C ON C.pi_number=A.pi_number and C.seq=A.seq and C.companyarea=A.companyarea
									WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]' and C.product_code='$temp[2]' and A.companyarea='$loc' and B.departemen='ACCHRD' and
									      A.kode_barang IN (SELECT A.kode_barang
									FROM product_detail A 
									JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
									WHERE A.product_code='$temp[2]' and B.departemen='ACCHRD' and A.companyarea='$loc'))
							UNION (
									SELECT A.kode_barang,B.nama_barang,  B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread, '0' as quantity,'0' as ck
									FROM product_detail A 
									JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
									WHERE A.product_code='$temp[2]' and B.departemen='ACCHRD' and A.companyarea='$loc' and A.kode_barang NOT IN (SELECT A.kode_barang
									FROM product_accessories A
									JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
									JOIN d_pi C ON C.pi_number=A.pi_number and C.seq=A.seq and C.companyarea=A.companyarea
									WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]' and C.product_code='$temp[2]' and A.companyarea='$loc' and B.departemen='ACCHRD') )) A ORDER BY A.nama_barang";
			$tabel= $this->app_model->manualQuery($text);
			
			$row = $tabel->num_rows();
			$data = array();
			if ($row>0){
				$tmp =0;
				foreach($tabel->result() as $t){
					$data[$tmp]['kode_barang'] = $t->kode_barang;
					$data[$tmp]['nama_barang'] = $t->nama_barang;
					$data[$tmp]['size_length'] = $t->size_length;
					$data[$tmp]['size_width'] = $t->size_width;
					$data[$tmp]['size_height'] = $t->size_height;
					$data[$tmp]['size_diameter'] = $t->size_diameter;
					$data[$tmp]['size_diameterin'] = $t->size_diameterin;
					$data[$tmp]['size_thread'] = $t->size_thread;
					$data[$tmp]['quantity'] = $t->quantity;
					$data[$tmp]['ck'] = $t->ck;
					$tmp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			//timezone_menu('UP7');
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Accessories Card";
			
			$id = $this->uri->segment(3);
			$temp = explode('-', $id);
			$text = "SELECT A.product_code, A.quantity,C.product_name,C.product_photo,D.coll_name,E.brand_name
					FROM d_pi A
					LEFT OUTER JOIN `pi` B ON B.pi_number=A.pi_number and B.companyarea=A.companyarea
					LEFT OUTER JOIN product C ON C.product_code=A.product_code
					LEFT OUTER JOIN collection D on D.coll_code=C.product_coll
					LEFT OUTER JOIN brand E ON E.brand_code=D.coll_brand
					WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['pi_number']			= $temp[0];
					//$tanggal = date_create($db->tgl_keluar);
					//$d['tgl_keluar']	= date_format($tanggal, 'F jS, Y');
					$d['product_code']	= $db->product_code;
					$d['quantity']			= $db->quantity;
					$d['product_name']	= $db->product_name;
					$d['product_photo']	= $db->product_photo;
					$d['coll_name']			= $db->coll_name;
					$d['brand_name']		= $db->brand_name;
				}
			} else {
				$d['pi_number']			= $temp[0];
				$d['product_code']	= '';
				$d['quantity']			= '';
				$d['product_name']	= '';
				$d['product_photo']	= '';
				$d['coll_name']			= '';
				$d['brand_name']		= '';
			}
			
			$text = "SELECT A.kode_barang, B.nama_barang, B.kode_barang_spc,  A.quantity, B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread,'1' as ck
					FROM product_accessories A
					LEFT OUTER JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
					WHERE A.pi_number='$temp[0]' and A.seq='$temp[1]' and A.companyarea='$loc' and B.departemen='ACCHRD'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('accessories_product/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file accessories_product.php */
/* Location: ./application/controllers/profil.php */