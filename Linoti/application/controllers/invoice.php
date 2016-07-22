<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE A.pi_status='OPEN' ";
			}else{
				$where = " WHERE A.pi_status='OPEN' AND A.pi_number LIKE '%$cari%' OR B.cust_name LIKE '%$cari%'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Purchase Invoice";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.pi_number, A.pi_dateorder, B.cust_name, B.cust_country as cust_state, B.cust_phone, A.pi_id FROM pi A JOIN customer B ON B.cust_code=A.pi_cust  $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/invoice/index/';
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
			

			$text = "SELECT A.pi_number, A.pi_dateorder, B.cust_name, B.cust_country as cust_state, B.cust_phone, A.pi_id, A.judul FROM pi A LEFT OUTER JOIN customer B ON B.cust_code=A.pi_cust  $where 
					ORDER BY A.pi_dateorder DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('invoice/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = $myheader;
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Purchase Invoice";
			
			$d['pi_number']	= '';
			$d['tgl_order']	= '';
			$d['pi_id']	= '';
			$d['cust_code']	= '';
			//$d['judul']	= '';
			
			$d['content'] = $this->load->view('invoice/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = $myheader;
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Purchase Invoice";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM pi WHERE pi_id='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['pi_id']	= $id;
					$d['pi_number']	= $db->pi_number;
					$d['tgl_order']	= $db->pi_dateorder;
					$d['cust_code']	= $db->pi_cust;
					//$d['judul']	= $db->judul;
				}
			}else{
					$d['pi_id']	= '';
					$d['pi_number']	= '';
					$d['tgl_order']	= '';
					$d['cust_code']	= '';
					//$d['judul']	= '';
			}
						
			$d['content'] = $this->load->view('invoice/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM pi WHERE pi_id='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_pi WHERE pi_id='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_pipo WHERE pi_id='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_pipobox WHERE pi_id='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/invoice'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tutup(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){	
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("UPDATE pi SET pi_status='CLOSED' WHERE pi_id='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/invoice'>";	
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){	
		
			if (empty($this->input->post('pi_id'))){
				$pi_id = $this->app_model->GeneratePIID();
			} else {
				$pi_id = $this->input->post('pi_id');
			}
			
			$up['pi_id']		= $pi_id;
			$up['pi_number']	= $this->input->post('pi_number');
			$up['pi_dateorder']	= $this->input->post('tgl_order');
			$up['pi_cust']		= $this->input->post('cust_code');
			
			$up['editedby']		= $user;
			$up['editedtime']	= $tgl;
			
			$id['pi_id']		=	$pi_id;
			$id['companyarea']	=	$loc;
			
			$data = $this->app_model->getSelectedData("pi",$id);
			if($data->num_rows()>0){
				$this->app_model->updateData("pi",$up,$id);
			}else{
				$up['pi_status']	= "OPEN";
				$up['createdby']	= $user;
				$up['createdtime']	= $tgl;
				$up['companyarea']		= $loc;
				$this->app_model->insertData("pi",$up);
				echo "Save Successful!";
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function simpan_customer(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){	
			$cust_code = $this->app_model->GenerateCustomerCode();
			$up['cust_code'] 		= $cust_code;
			$up['cust_name']		= $this->input->post('NewCustomerName');
			$up['createdby'] 		= $user;
			$up['createdtime']	= $tgl;
			$up['editedby'] 		= $user;
			$up['editedtime']		= $tgl;
			$up['companyarea']	= $loc;
			
			$id['cust_name'] = $this->input->post('NewCustomerName');
			$id['companyarea'] = $loc;
			
			$data = $this->app_model->getSelectedData("customer",$id);
			if ($data->num_rows()>0){
				echo "Sorry, Customer Name already exists";
			} else {
				$this->app_model->insertData("customer",$up);
				echo "Save Successful";
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function simpan_detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){	
			$test['jml'] = $this->input->post('nArray');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					
					$text = "SELECT MAX(seq) as Seq from d_pi where pi_id='".$this->input->post('pi_id_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}
				else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				$up['pi_id'] 			= $this->input->post('pi_id_'.$i);
				$up['product_code'] 			= $this->input->post('product_code_'.$i);
				$up['quantity'] 			= $this->input->post('quantity_'.$i);
				$up['prod_type'] 			= $this->input->post('production_'.$i);
				$up['prod_vendor'] 			= $this->input->post('vendor_'.$i);
				$up['top'] 			= $this->input->post('top_'.$i);
				$up['frame'] 			= $this->input->post('frame_'.$i);
				$up['drawer'] 			= $this->input->post('drawer_'.$i);
				$up['door'] 			= $this->input->post('door_'.$i);
				$up['side'] 			= $this->input->post('side_'.$i);
				$up['feet'] 			= $this->input->post('feet_'.$i);
				$up['linen'] 			= $this->input->post('linen_'.$i);
				$up['inside'] 			= $this->input->post('inside_'.$i);
				$up['back'] 			= $this->input->post('back_'.$i);
				$up['shelve'] 			= $this->input->post('shelve_'.$i);
				$up['finish'] 			= $this->input->post('finish_'.$i);
				$up['note'] 			= $this->input->post('note_'.$i);
				$up['remarks'] 			= $this->input->post('remarks_'.$i);
				$up['outside'] 			= $this->input->post('outside_'.$i);
				$up['back_rest'] 			= $this->input->post('back_rest_'.$i);
				$up['seat_base'] 			= $this->input->post('seat_base_'.$i);
				$up['seat_cushion'] 			= $this->input->post('seat_cushion_'.$i);
				$up['amrest'] 			= $this->input->post('amrest_'.$i);
				$up['cushion'] 			= $this->input->post('cushion_'.$i);
				$up['piping'] 			= $this->input->post('piping_'.$i);
				$up['customize'] 			= $this->input->post('customize_'.$i);
				$up['description'] 			= $this->input->post('description_'.$i);
				$up['kdown'] 			= $this->input->post('kdown_'.$i);
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['pi_id'] 			= $this->input->post('pi_id_'.$i);
				$id['product_code'] 		= $this->input->post('product_code_'.$i);
				$id['seq'] 		= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("d_pi",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("d_pi",$up,$id);
				}else{
					$up['seq'] 			= $Seq;
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("d_pi",$up);
				}
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function detail()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)) {
			$d['myheader'] = $myheader;
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Detail Invoice";
			$pi_id = $this->uri->segment(3);
			$pi = $this->uri->segment(4);
			$d['pi_number'] = $pi;
			$d['pi_id'] = $pi_id;
			
			$text = "SELECT A.pi_number, A.pi_dateorder, B.cust_name, B.cust_country as cust_state, B.cust_phone FROM pi A JOIN customer B ON B.cust_code=A.pi_cust  WHERE A.pi_id='$pi_id'";
			$tabel = $this->app_model->manualQuery($text);
		
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$d['pi_number'] = $t->pi_number;
					$d['pi_dateorder'] = $t->pi_dateorder;
					$d['cust_name'] = $t->cust_name;
					$d['cust_state'] = $t->cust_state;
					$d['cust_phone'] = $t->cust_phone;
				}
			} else {
				$d['pi_number'] = '';
				$d['pi_dateorder'] = '';
				$d['cust_name'] = '';
				$d['cust_state'] = '';
				$d['cust_phone'] = '';
			}
			
			$text2= "SELECT * FROM brand ORDER BY brand_name";
			$d['brand'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('invoice/detail', $d, true);		
			$this->load->view('home',$d);
		} else {
			header('location:'.base_url());
		} 
	}
	
	public function DataDetail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)) {
			$pi_id = $this->input->post('pi_id');
			//$category = $this->input->post('brandtype');
			$text="SELECT A.*,B.product_name,C.coll_name from d_pi A JOIN product B ON B.product_code=A.product_code LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll where A.pi_id='$pi_id' and B.companyarea='$loc'";
			
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data = array();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['pi_id'] = $t->pi_id;
					$data[$temp]['seq'] = $t->seq;
					$data[$temp]['product_code'] = $t->product_code;
					$data[$temp]['product_coll'] = $t->coll_name;
					$data[$temp]['product_name'] = $t->product_name;
					$data[$temp]['quantity'] = $t->quantity;
					$data[$temp]['production'] = $t->prod_type;
					$data[$temp]['vendor'] = $t->prod_vendor;
					$data[$temp]['top'] = $t->top;
					$data[$temp]['frame'] = $t->frame;
					$data[$temp]['drawer'] = $t->drawer;
					$data[$temp]['door'] = $t->door;
					$data[$temp]['side'] = $t->side;
					$data[$temp]['feet'] = $t->feet;
					$data[$temp]['linen'] = $t->linen;
					$data[$temp]['inside'] = $t->inside;
					$data[$temp]['back'] = $t->back;
					$data[$temp]['shelve'] = $t->shelve;
					$data[$temp]['finish'] = $t->finish;
					$data[$temp]['note'] = $t->note;
					$data[$temp]['remarks'] = $t->remarks;
					$data[$temp]['outside'] = $t->outside;
					$data[$temp]['back_rest'] = $t->back_rest;
					$data[$temp]['seat_base'] = $t->seat_base;
					$data[$temp]['seat_cushion'] = $t->seat_cushion;
					$data[$temp]['amrest'] = $t->amrest;
					$data[$temp]['cushion'] = $t->cushion;
					$data[$temp]['piping'] = $t->piping;
					$data[$temp]['customize'] = $t->customize;
					$data[$temp]['description'] = $t->description;
					$data[$temp]['kdown'] = $t->kdown;
					$temp++;
				}
			}
			echo json_encode($data);
		} else {
			header('location:'.base_url());
		} 
	}
	
	public function hapus_detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$pi_id = $this->input->post('pi_id');
			$product_code = $this->input->post('product_code');
			$seq = $this->input->post('seq');
			$this->app_model->manualQuery("DELETE FROM d_pi WHERE pi_id='$pi_id' and product_code='$product_code' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_pipo WHERE pi_id='$pi_id' and product_code='$product_code' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_pipobox WHERE pi_id='$pi_id' and seq_pi='$seq' and companyarea='$loc'");
			echo "Delete Successful!";
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataAccessories(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)) {
			//$id = $this->uri->segment(3);
			$id = $this->uri->segment(3);
			$pi_id = $this->uri->segment(4);
			$product_code = $this->uri->segment(5);
			$product_seq = $this->uri->segment(6);
			$text = "SELECT * from d_pipo where pi_id='$pi_id' AND product_code='$product_code' AND product_seq='$product_seq'";
			$tabel1= $this->app_model->manualQuery($text);
			$row1 = $tabel1->num_rows();
			if ($row1 > 0){
				$text = "SELECT A.id_cotation,A.seq,A.material,  D.nama_barang, A.quantity,F.unit_name,A.currency,A.harga,A.production_cost,A.acc_hard, D.kode_barang_spc, G.type, D.foto_barang, 
												R.finishing,D.size_length,D.size_width,D.size_height,H.simbol as size_length_unit,D.size_diameter,I.simbol as size_diameter_unit,D.size_diameterin,
												J.simbol as size_diameterin_unit,D.size_thread, (SELECT count(*) FROM d_pipo K where K.kode_barang=A.material and K.pi_id='$pi_id' and K.product_code=B.product_code and K.product_seq='$product_seq') as mycheck
						FROM cotation_accessories A
						JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
						JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
						LEFT OUTER JOIN `unit` F ON F.unit_code=D.useper
						JOIN `type` G ON G.type_id=D.type
						LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=D.size_length_unit
						LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=D.size_diameter_unit
						LEFT OUTER JOIN t_unit_ukuran J ON J.unit_ukuran_id=D.size_diameterin_unit
						LEFT OUTER JOIN finishing R ON R.finishing_id=D.finishing
						WHERE A.id_cotation='$id' and A.companyarea='$loc' 
						ORDER BY D.nama_barang";
			} else {
				$text = "SELECT A.id_cotation,A.seq,A.material,  D.nama_barang, A.quantity,F.unit_name,A.currency,A.harga,A.production_cost,A.acc_hard, D.kode_barang_spc, G.type, D.foto_barang, R.finishing,D.size_length,D.size_width,D.size_height,H.simbol as size_length_unit,D.size_diameter,I.simbol as size_diameter_unit,D.size_diameterin,J.simbol as size_diameterin_unit,D.size_thread, '0' as mycheck
						FROM cotation_accessories A
						JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
						JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
						LEFT OUTER JOIN `unit` F ON F.unit_code=D.useper
						JOIN `type` G ON G.type_id=D.type
						LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=D.size_length_unit
						LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=D.size_diameter_unit
						LEFT OUTER JOIN t_unit_ukuran J ON J.unit_ukuran_id=D.size_diameterin_unit
						LEFT OUTER JOIN finishing R ON R.finishing_id=D.finishing
						WHERE A.id_cotation='$id' and A.companyarea='$loc' 
						ORDER BY D.nama_barang";
			}
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$TotalRp=0;
			$TotalUsd=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$size = '';
					$data[$temp]['id_cotation'] 			= $t->id_cotation;
					$data[$temp]['numberrec'] 			= ($temp+1).'.';
					$data[$temp]['seq'] 							= $t->seq;
					$data[$temp]['mycheck'] 							= $t->mycheck;
					$data[$temp]['accessories_type'] 	= $t->nama_barang;
					$data[$temp]['acc_hard'] 					= $t->acc_hard;
					$data[$temp]['code'] 							= $t->kode_barang_spc;
					$data[$temp]['hidefoto'] 					= $t->foto_barang;
					$data[$temp]['hidekodebarang'] 		= $t->material;
					$data[$temp]['hidenamabarang'] 		= $t->nama_barang;
					$data[$temp]['hideunit'] 					= $t->unit_name;
					$data[$temp]['finishing'] 				= $t->finishing;
					$data[$temp]['type'] 							= $t->type;
					$data[$temp]['hidebarang'] 		= $t->material;
					$data[$temp]['quantity'] 			= $t->quantity; 
					$data[$temp]['currency'] 			= $t->currency; 
					$data[$temp]['brg_harga'] 		= $t->harga; 
					$data[$temp]['production_cost'] 	= $t->production_cost;
					
					if ($t->size_length > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_length);
						$fraction = $t->size_length - $whole;
						if ($fraction > 0){
							$size = $size.'L '.number_format($t->size_length,1,',','.').' x ';
						} else {
							$size = $size.'L '.number_format($t->size_length,0,',','.').' x ';
						}
					}
					
					if ($t->size_width > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_width);
						$fraction = $t->size_width - $whole;
						if ($fraction > 0){
							$size = $size.'W '.number_format($t->size_width,1,',','.').' x ';
						} else {
							$size = $size.'W '.number_format($t->size_width,0,',','.').' x ';
						}
					}
					
					if ($t->size_height > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_height);
						$fraction = $t->size_height - $whole;
						if ($fraction > 0){
							$size = $size.'H '.number_format($t->size_height,1,',','.').' x ';
						} else {
							$size = $size.'H '.number_format($t->size_height,0,',','.').' x ';
						}
					}
					
					if ($size!=''){
						$size = substr($size,0,-3);
						if (empty($t->size_length_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_length_unit.'; ';
						}
					}
					
					if ($t->size_diameter > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameter);
						$fraction = $t->size_diameter - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; out   '.number_format($t->size_diameter,1,',','.');
						} else {
							$size = $size.'&#216; out   '.number_format($t->size_diameter,0,',','.');
						}
						if (empty($t->size_diameter_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_diameter_unit.'; ';
						}
					}
					
					if ($t->size_diameterin > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameterin);
						$fraction = $t->size_diameterin - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,1,',','.');
						} else {
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,0,',','.');
						}
						if (empty($t->size_diameterin_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_diameterin_unit.'; ';
						}
					}
					
					if ($t->size_thread!=''){
						$size = $size.$t->size_thread.'; ';
					}
					
					$data[$temp]['hidesize'] = urldecode($size);
					
					if ($t->currency=='Rp'){
						$TotalRp 	= $TotalRp + $t->production_cost;
					} else {
						$TotalUsd = $TotalUsd + $t->production_cost;
					}
						
					$temp++;
				}
			} 
			$dataFooter[0]['production_cost'] 	= $TotalRp;
			$dataFooter[0]['currency'] 					= 'Rp';
			$dataFooter[0]['accessories_type'] 	= 'TOTAL';
			$dataFooter[1]['production_cost'] 	= $TotalUsd;
			$dataFooter[1]['currency'] 					= '$';
			//echo json_encode($data);
			echo '{"total":'.$row.',"rows":'.json_encode($data).',"footer":'.json_encode($dataFooter).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataBox(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			$pi_id = $this->uri->segment(4);
			$seq = $this->uri->segment(5);
			$kdown = $this->uri->segment(6);
			
			if ($kdown==''){
				$kdown='NO';
			}
			
			$text = "SELECT * from d_pipobox where pi_id='$pi_id'";
			$tabel1= $this->app_model->manualQuery($text);
			$row1 = $tabel1->num_rows();
			if ($row1 > 0){
				$text="SELECT A.id_cotation,A.seq,A.boxnumber,A.lsize,A.wsize,A.hsize,A.kdown,A.typebox,A.lstyrofoam,A.wstyrofoam,A.hstyrofoam,A.linner,A.winner,A.hinner,A.lkarton,A.wkarton,A.hkarton,
											A.louter,A.wouter,A.houter,A.volouter,A.remarks,A.qtybox,(SELECT count(*) FROM d_pipobox K where K.pi_id='$pi_id' and K.seq_pi='$seq' and K.seq_cot=A.seq and K.companyarea=A.companyarea) as mycheck
							 FROM cotation_packing A
							 JOIN h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea
							 WHERE A.id_cotation='$id' and A.kdown='$kdown' and A.companyarea='$loc'
							 ORDER BY A.boxnumber";
			} else {
				$text="SELECT A.id_cotation,A.seq,A.boxnumber,A.lsize,A.wsize,A.hsize,A.kdown,A.typebox,A.lstyrofoam,A.wstyrofoam,A.hstyrofoam,A.linner,A.winner,A.hinner,A.lkarton,A.wkarton,A.hkarton,
											A.louter,A.wouter,A.houter,A.volouter,A.remarks,A.qtybox,'0' as mycheck
							 FROM cotation_packing A
							 JOIN h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea
							 WHERE A.id_cotation='$id' and A.kdown='$kdown' and A.companyarea='$loc'
							 ORDER BY A.boxnumber";
			}
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] 			= $t->id_cotation;
					$data[$temp]['numberrec'] 			= ($temp+1).'.';
					$data[$temp]['seq'] 							= $t->seq;
					$data[$temp]['mycheck'] 					= $t->mycheck;
					$data[$temp]['boxnumber'] 				= $t->boxnumber;
					$data[$temp]['lsize'] 				= $t->lsize;
					$data[$temp]['wsize'] 				= $t->wsize;
					$data[$temp]['hsize'] 				= $t->hsize;
					$data[$temp]['kdown'] 				= $t->kdown;
					$data[$temp]['typebox'] 				= $t->typebox;
					$data[$temp]['lstyrofoam'] 				= $t->lstyrofoam;
					$data[$temp]['wstyrofoam'] 				= $t->wstyrofoam;
					$data[$temp]['hstyrofoam'] 				= $t->hstyrofoam;
					$data[$temp]['linner'] 				= $t->linner;
					$data[$temp]['winner'] 				= $t->winner;
					$data[$temp]['hinner'] 				= $t->hinner;
					$data[$temp]['lkarton'] 				= $t->lkarton;
					$data[$temp]['wkarton'] 				= $t->wkarton;
					$data[$temp]['hkarton'] 				= $t->hkarton;
					$data[$temp]['louter'] 				= $t->louter;
					$data[$temp]['wouter'] 				= $t->wouter;
					$data[$temp]['houter'] 				= $t->houter;
					$data[$temp]['volouter'] 				= $t->volouter;
					$data[$temp]['remarks'] 				= $t->remarks;
					$data[$temp]['qtybox'] 				= $t->qtybox;
					$temp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function AccSet(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){	
			$test['jml'] = $this->input->post('nArray');
			for ($i=0;$i<$test['jml'];$i++){
				if ($i==0 && $test['jml']>0){
					$this->app_model->manualQuery("DELETE FROM d_pipo WHERE pi_id='".$this->input->post('pi_id_'.$i)."' AND product_code='".$this->input->post('product_code_'.$i)."' AND product_seq='".$this->input->post('product_seq_'.$i)."' AND companyarea='$loc'");
				} 
				
					$up['pi_id'] 					= $this->input->post('pi_id_'.$i);
					$up['kode_barang'] 		= $this->input->post('hidekodebarang_'.$i);
					$up['product_code'] 	= $this->input->post('product_code_'.$i);
					$up['product_seq'] 	= $this->input->post('product_seq_'.$i);
					$up['editedby'] 			= $user;
					$up['editedtime'] 		= $tgl;
					
					$id['pi_id'] 				= $this->input->post('pi_id_'.$i);
					$id['kode_barang'] 	= $this->input->post('hidekodebarang_'.$i);;
					$id['product_code'] 	= $this->input->post('product_code_'.$i);;
					$id['product_seq'] 	= $this->input->post('product_seq_'.$i);;
					$id['companyarea'] 	= $loc;
					
					$data = $this->app_model->getSelectedData("d_pipo",$id);
					if($data->num_rows()>0){
						$this->app_model->updateData("d_pipo",$up,$id);
					}else{
						//$up['seq'] 			= $Seq;
						$up['createdby'] 				= $user;
						$up['createdtime'] 			= $tgl;
						$up['companyarea'] 			= $loc;
						$this->app_model->insertData("d_pipo",$up);
					}
				
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function BoxSet(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){	
			$test['jml'] = $this->input->post('nArray');
			if ($test['jml']>0){
				for ($i=0;$i<$test['jml'];$i++){
					if ($i==0 && $test['jml']>0){
						$this->app_model->manualQuery("DELETE FROM d_pipobox WHERE pi_id='".$this->input->post('pi_id_'.$i)."' AND seq_pi='".$this->input->post('seq_pi_'.$i)."' AND companyarea='$loc'");
					}
					
					$up['pi_id'] = $this->input->post('pi_id_'.$i);
					$up['seq_pi'] = $this->input->post('seq_pi_'.$i);
					$up['seq_cot'] = $this->input->post('seq_'.$i);
					$up['editedby'] 			= $user;
					$up['editedtime'] 		= $tgl;
					
					$id['pi_id'] = $this->input->post('pi_id_'.$i);
					$id['seq_pi'] = $this->input->post('seq_pi_'.$i);
					$id['seq_cot'] = $this->input->post('seq_'.$i);
					$id['companyarea'] 	= $loc;
					
					$data = $this->app_model->getSelectedData("d_pipobox",$id);
					if($data->num_rows()>0){
						$this->app_model->updateData("d_pipobox",$up,$id);
					}else{
						$up['createdby'] 				= $user;
						$up['createdtime'] 			= $tgl;
						$up['companyarea'] 			= $loc;
						$this->app_model->insertData("d_pipobox",$up);
					}
				}
			}else{
				$this->app_model->manualQuery("DELETE FROM d_pipobox WHERE pi_id='".$this->input->post('pi_id_'.$i)."' AND companyarea='$loc'");
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function CreateAllPOPI(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		$pi = $this->input->post('pi');
		$date = $this->input->post('date');
		$pi_id = $this->input->post('pi_id');
		
		if(!empty($cek)){
			if ($pi!=''){
				$text = "SELECT pi_cust FROM `pi` WHERE pi_number='$pi' and pi_id='$pi_id'";
				$datacust = $this->app_model->manualQuery($text);
				$customer_code ='';
				foreach ($datacust->result() as $dc){
					$customer_code = $dc->pi_cust;
				}
				
				$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_address,A.supplier_country
								 FROM supplier A 
								 where A.companyarea='$loc' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_barangsup R where R.kode_barang=A.kode_barang and R.tgl <= str_to_date('$date','%Y-%m-%d') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipo A JOIN pi B ON B.pi_id=A.pi_id where B.pi_number='$pi' AND B.pi_id='$pi_id') K /* where supplier_code<>'' */) ";
				$tabel = $this->app_model->manualQuery($text);
				$row = $tabel->num_rows();
				
				$jml=0;
				if($row > 0){
					foreach ($tabel->result() as $sup){
						//Create Nomor PO for each supplier
						$po = $this->app_model->GeneratePONumber($date,$sup->supplier_code,$pi);
						
						$uc['po']	= $po;
						$uc['tglbeli']				= $date;
						$uc['kode_supplier']	= $sup->supplier_code;
						$uc['pi']							= $pi;
						
						$uc['username']				= $this->session->userdata('username');
						$uc['editedby']				= $user;
						$uc['editedtime']			= $tgl;
						
						$query1 = "	SELECT DISTINCT(A.kode_barang),A.nama_barang,D.currency,D.harga,D.min_qty,A.turunan,A.size_length as length_item,A.size_width as width_item,GA.unit_name,E.product_code,E.seq,
															A.size_height as height_item, G.nama_barang as nama_turunan, G.size_length as length_master, G.size_width as width_master, G.size_height as height_master,
															(SELECT SUM(L.quantity*O.quantity)
															 FROM barang K
															 JOIN cotation_accessories L ON L.material=K.kode_barang
															 JOIN h_cotation M ON M.id_cotation=L.id_cotation 
															 JOIN d_pi O ON O.product_code=M.product_code
															 JOIN `pi` P ON P.pi_id=O.pi_id
															 WHERE P.pi_number='$pi' AND P.pi_id='$pi_id' AND K.kode_barang=A.kode_barang AND O.seq=E.seq
															) as quantity
												FROM barang A
												JOIN cotation_accessories B ON B.material=A.kode_barang
												JOIN h_cotation C ON C.id_cotation=B.id_cotation
												JOIN d_pi E ON E.product_code=C.product_code
												JOIN `pi` F ON F.pi_id=E.pi_id
												LEFT OUTER JOIN d_barangsup D ON D.kode_barang=A.kode_barang AND D.tgl=(SELECT tgl from d_barangsup DA where DA.supplier_code='".$sup->supplier_code."' and DA.kode_barang=A.kode_barang and DA.tgl <= F.pi_dateorder ORDER BY DA.tgl DESC LIMIT 1)
												LEFT OUTER JOIN barang G ON G.kode_barang=A.turunan AND G.companyarea=A.companyarea
												LEFT OUTER JOIN `unit` GA ON GA.unit_code=A.satuan
												WHERE F.pi_number='$pi' AND F.pi_id='$pi_id' AND D.supplier_code='".$sup->supplier_code."' AND A.kode_barang IN (SELECT kode_barang from d_pipo R where R.pi_id=E.pi_id and R.product_code=E.product_code and R.product_seq=E.seq)

												ORDER BY A.kode_barang";
						$datappi = $this->app_model->manualQuery($query1);
						$row1 = $datappi->num_rows();
						
						$temp=0;
						//$jml=0;
						
						if ($row1 > 0){
							foreach($datappi->result() as $dp){
								
								$textin = "SELECT A.* FROM d_beli A LEFT OUTER JOIN h_beli B ON B.po=A.po AND B.companyarea=A.companyarea LEFT OUTER JOIN `pi` C ON C.pi_number=B.pi AND C.pi_id=B.pi_id WHERE A.kode_barang='".$dp->kode_barang."' AND B.pi='$pi' AND C.pi_id='".$pi_id."' AND A.po='$po' AND A.companyarea='$loc'";
								$datapo = $this->app_model->manualQuery($textin);
								$ada = $datapo->num_rows();
								if ($datapo->num_rows() > 0){ // selalu tidak masuk disini
									//if ($po=='LI-VF38160502-AMF-11.05.001'){
									//	$fp=fopen("datadalampo.txt","w");
									//	fwrite($fp,'Didalam sini');
									//}
										//$textalreadycount = "SELECT A.* FROM d_beli A LEFT OUTER JOIN h_beli B ON B.po=A.po AND B.companyarea=A.companyarea LEFT OUTER JOIN `pi` C ON C.pi_number=B.pi AND C.pi_id=B.pi_id WHERE A.kode_barang='".$dp->kode_barang."' AND B.pi='$pi' AND C.pi_id='".$pi_id."'";
									 $databeli = $datapo->row();
										if($dp->turunan!=''){
											if ($dp->width_item==$dp->width_master && $dp->height_item==$dp->height_master){
												$tmpquantity = Ceil(($dp->length_item/$dp->length_master)*$dp->quantity); 
											} elseif ($dp->width_master>=($dp->width_item*2) && strpos(strtolower($dp->nama_barang),'canvas') !== false) {
												$tmpquantity = (($dp->length_item*$dp->width_item)/1000000*$dp->quantity)/($dp->width_item/1000*2);
											} else {
												$tmpquantity = Ceil(((($dp->length_item*$dp->width_item)/1000000)/(($dp->length_master*$dp->width_master)/1000000))*$dp->quantity);
											}
										} else {
											//if (strpos(strtolower($dp->unit_name),'meter') !== false){
											//	$tmpquantity = Ceil($dp->quantity);
											//}else {
												$tmpquantity = $dp->quantity;
											//}
										}
										$array_seq = explode(',',$databeli->count_for_seq);
										if (!in_array($dp->seq,$array_seq)){
											
											//Insert
											
											$ud['jmlbeli'] 			= Ceil($tmpquantity+$databeli->jmlbeli);
											$ud['count_for_seq'] 		= $databeli->count_for_seq.','.$dp->seq;
											//$ud['createdby'] 		= $user;
											//$ud['createdtime'] 	= $tgl;
											$ud['editedby'] 		= $user;
											$ud['editedtime'] 	= $tgl;
											
											$id['po'] 					= $databeli->po;
											$id['kode_barang'] 	= $databeli->kode_barang;
											$id['currency'] 		= $databeli->currency;
											$id['companyarea'] 	= $loc;
											$id['idbeli'] 	= $databeli->idbeli;
											
											$this->app_model->updateData("d_beli",$ud,$id);
											//$temp++;
										}
								} else {
									if($dp->turunan!=''){
										if ($dp->width_item==$dp->width_master && $dp->height_item==$dp->height_master){
											$tquantity = Ceil(($dp->length_item/$dp->length_master)*$dp->quantity);
										} elseif ($dp->width_master>=($dp->width_item*2) && strpos(strtolower($dp->nama_barang),'canvas') !== false) {
											$tquantity = (($dp->length_item*$dp->width_item)/1000000*$dp->quantity)/($dp->width_item/1000*2);
										} else {
											$tquantity = Ceil(((($dp->length_item*$dp->width_item)/1000000)/(($dp->length_master*$dp->width_master)/1000000))*$dp->quantity);
										}
									} else {
										//if (strpos(strtolower($dp->unit_name),'meter') !== false){
										//	$tquantity = Ceil($dp->quantity);
										//} else {
											$tquantity = $dp->quantity;
										//}
									}
									//Insert
									$ud['po'] 					= $po;
									$ud['kode_barang'] 	= $dp->kode_barang;
									$ud['jmlbeli'] 			= $tquantity;
									$ud['currency'] 		= $dp->currency;
									$ud['count_for_seq'] 		= ','.$dp->seq;
									$ud['hargabeli'] 		= $dp->harga;
									$ud['createdby'] 		= $user;
									$ud['createdtime'] 	= $tgl;
									$ud['editedby'] 		= $user;
									$ud['editedtime'] 	= $tgl;
									$ud['companyarea'] 	= $loc;
									
									$this->app_model->insertData("d_beli",$ud);
									
									if($temp==0){
										$uc['createdby']		= $user;
										$uc['createdtime']	= $tgl;
										$uc['companyarea']	= $loc;
										$uc['pi_id']	= $pi_id;
										$this->app_model->insertData("h_beli",$uc);
										$jml++;
									}
									
								}
								$temp++;
							} 
						}
					}
					if ($jml > 0){
						echo 'Create PO Successful!';
					} else {
						echo 'Create PO Failed!';
					}
				} else {
					echo "Create PO Failed, your PI Detail may be empty or you not set accessories yet";
				}
			} else {
				echo 'Please input your PI Number before Create PO!';
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function CreatePOBox(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		$pi = $this->input->post('pi');
		$pi_id = $this->input->post('pi_id');
		$date = $this->input->post('date');
		
		if(!empty($cek)){
			if ($pi!=''){
				$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_address,A.supplier_country
								 FROM supplier A 
								 where A.companyarea='$loc' and A.supplier_code IN (SELECT DISTINCT(supplier_code) FROM (SELECT A.*,(SELECT R.supplier_code from d_boxsup R where R.product_code=C.product_code and R.tgl <= str_to_date('$date','%Y-%m-%d') ORDER BY R.tgl DESC LIMIT 1) as supplier_code from d_pipobox A JOIN pi B ON B.pi_id=A.pi_id JOIN d_pi C ON C.pi_id=B.pi_id where B.pi_number='$pi' AND B.pi_id='$pi_id') K /* where supplier_code<>'' */) ";
				$tabel = $this->app_model->manualQuery($text);
				$row = $tabel->num_rows();
				
				$jml=0;
				if($row > 0){
					$tpo = '';
					foreach ($tabel->result() as $sup){
						//Create Nomor PO for each supplier
						$po = $this->app_model->GeneratePONumber($date,$sup->supplier_code,$pi);
						
						$uc['po']	= $po;
						$uc['tglbeli']				= $date;
						$uc['kode_supplier']	= $sup->supplier_code;
						$uc['pi']							= $pi;
						$uc['username']				= $this->session->userdata('username');
						$uc['editedby']				= $user;
						$uc['editedtime']			= $tgl;
						
						$query1 = "SELECT A.product_code,F.cm_length,F.cm_width,F.cm_height,E.boxnumber,E.kdown,E.typebox,E.remarks_packing,E.lstyrofoam,E.wstyrofoam,E.hstyrofoam,E.linner,E.winner,
															E.seq,E.hinner,E.lkarton,E.wkarton,E.hkarton,E.louter,E.wouter,E.houter,E.volouter,E.remarks,(A.quantity*E.qtybox/E.qtyperbox) as qty_box,
															(SELECT K.tgl FROM d_boxsup K WHERE K.product_code=A.product_code AND K.companyarea=A.companyarea AND K.boxnumber=E.boxnumber AND K.kdown=E.kdown AND K.typebox=E.typebox AND K.supplier_code='".$sup->supplier_code."' ORDER BY K.tgl DESC LIMIT 1) as tglhrg,
															(SELECT L.currency FROM d_boxsup L WHERE L.product_code=A.product_code AND L.companyarea=A.companyarea AND L.boxnumber=E.boxnumber AND L.kdown=E.kdown AND L.typebox=E.typebox  AND L.tgl=tglhrg AND L.supplier_code='".$sup->supplier_code."' ORDER BY L.tgl DESC LIMIT 1) as currency,
															(SELECT N.harga FROM d_boxsup N WHERE N.product_code=A.product_code AND N.companyarea=A.companyarea AND N.boxnumber=E.boxnumber AND N.kdown=E.kdown AND N.typebox=E.typebox AND N.tgl=tglhrg AND N.supplier_code='".$sup->supplier_code."') as harga
											 FROM d_pi A
											 JOIN `pi` B ON B.pi_id=A.pi_id AND B.companyarea=A.companyarea
											 JOIN d_pipobox C ON C.pi_id=A.pi_id AND C.seq_pi=A.seq
											 JOIN h_cotation D ON D.product_code=A.product_code
											 JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=C.seq_cot
											 LEFT OUTER JOIN product F ON F.product_code=A.product_code
											 WHERE B.pi_number='$pi' AND B.pi_id='$pi_id';";
						
						$datappi = $this->app_model->manualQuery($query1);
						$row1 = $datappi->num_rows();
						//$fp=fopen("datapobox.txt","w");
						//fwrite($fp,$query1);
						$temp=0;
						if ($row1 > 0){
							foreach($datappi->result() as $dp){
								$textin = "SELECT A.product_code FROM d_belibox A LEFT OUTER JOIN h_beli B ON B.po=A.po AND B.companyarea=A.companyarea LEFT OUTER JOIN `pi` C ON C.pi_number=B.pi AND C.pi_id=B.pi_id WHERE A.product_code='".$dp->product_code."' AND A.seq_cot='".$dp->seq."' AND B.pi='$pi' AND C.pi_id='".$pi_id."'";
								$datapo = $this->app_model->manualQuery($textin);
								$ada = $datapo->num_rows();
								
								if ($ada>0){
									
								} else {
									$ud['po'] 					= $po;
									$ud['product_code'] = $dp->product_code;
									$ud['qtybox'] 			= $dp->qty_box;
									$ud['seq_cot'] 			= $dp->seq;
									$ud['currency'] 			= $dp->currency;
									$ud['hrgbox'] 			= $dp->harga;
									$ud['hrgdate'] 				= $dp->tglhrg;
									$ud['createdby'] 		= $user;
									$ud['createdtime'] 	= $tgl;
									$ud['editedby'] 		= $user;
									$ud['editedtime'] 	= $tgl;
									$ud['companyarea'] 	= $loc;
									
									$this->app_model->insertData("d_belibox",$ud);
									$temp++;
								}
							}
							
							if($temp>0){
								$uc['createdby']		= $user;
								$uc['createdtime']	= $tgl;
								$uc['pi_id']	= $pi_id;
								$uc['companyarea']	= $loc;
								$this->app_model->insertData("h_beli",$uc);
								$tpo .= $po.':';
								$jml++;
							} 
						}
					}
					if ($jml > 0){
						echo 'Create Box PO Successful!,'.substr($tpo,0,-1);
					} else {
						echo 'Create Box PO Failed!,';
					}
				} else {
					echo "Create Box PO Failed, your PI Detail may be empty or you not set box yet or you not set supplier box for the product";
				}
				//$fp=fopen("datapobox.txt","w");
				//fwrite($fp,$text);
				//echo "Create PO";
			} else {
				echo 'Please input your PI Number before Create Box PO!,';
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak_boxpo(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$pos = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Box PO";
			
			$text = "SELECT A.tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,D.cust_name,A.kode_supplier
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN `pi` C ON C.pi_number=A.`pi` AND C.companyarea=A.companyarea
						LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust
						WHERE A.po='$pos'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db) {
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['tanggalbeli']	= $db->tglbeli;
					$d['customer']	= $db->cust_name;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= $db->supplier_address;
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					$d['po']	= $db->po;
					$d['pi']	= $db->pi;
				}
				if (!is_dir('asset/po/'.$db->supplier_name)) {
					mkdir('asset/po/'.$db->supplier_name, 0755, true);
				}
			} else {
				$d['kode_beli']		=$id;
				$d['tanggalbeli']	='';
				$d['customer']	='';
				$d['supplier']	='';
				$d['alamat']	='';
				$d['phone']	='';
				$d['fax']	='';
				$d['po']	='';
				$d['pi']	='';
			}
			/*
			$text ="SELECT A.product_code,A.qtybox,D.currency_name,A.hrgbox,C.boxnumber,E.cm_length,E.cm_width,E.cm_height,C.kdown,C.typebox,C.remarks,C.lstyrofoam,C.wstyrofoam,C.hstyrofoam,
										 C.linner,C.winner,C.hinner,C.lkarton,C.wkarton,C.hkarton,C.louter,C.wouter,C.houter,C.volouter
							FROM d_belibox A
							JOIN h_cotation B ON B.product_code=A.product_code
							JOIN cotation_packing C ON C.id_cotation=B.id_cotation AND C.seq=A.seq_cot AND C.companyarea=B.companyarea
							LEFT OUTER JOIN currency D ON D.currency_code=A.currency
							JOIN product E ON E.product_code=A.product_code AND E.companyarea=A.companyarea
							WHERE A.po='$pos' AND A.companyarea='$loc'
							ORDER BY A.product_code,C.boxnumber";
			*/
			$text ="SELECT DISTINCT(A.product_code),A.po,B.product_photo,C.coll_name,B.product_name,B.cm_length,B.cm_width,B.cm_height,A.companyarea
							FROM d_belibox A
							LEFT OUTER JOIN product B ON B.product_code=A.product_code AND B.companyarea=A.companyarea
							LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
							WHERE A.po='$pos' AND A.companyarea='$loc'";
			$d['data'] = $this->app_model->manualQuery($text);
			$text ="SELECT E.boxnumber
							FROM d_belibox A
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
              LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
              LEFT OUTER JOIN currency F ON F.currency_code=A.currency
							WHERE A.po='$pos' AND A.companyarea='$loc'";
			//$d['datadetail']= $this->app_model->manualQuery($text);
			$databox = $this->app_model->manualQuery($text);
			//$fp=fopen("databox1.txt","w");
			//fwrite($fp,$text);
			$row = $databox->num_rows();
			$d['box1'] = 0;
			$d['box2'] = 0;
			$d['box3'] = 0;
			
			if($row>0){
				foreach($databox->result() as $bx){
					if ($bx->boxnumber=='BOX 1'){
						if ($d['box1']==0){
							$d['box1']=1;
						}
					}else if($bx->boxnumber=='BOX 2'){
						if ($d['box2']==0){
							$d['box2']=1;
						}
					} else if ($bx->boxnumber=='BOX 3'){
						if ($d['box3']==0){
							$d['box3']=1;
						}
					}
				}
			}
			
			
			if ($type=='email'){
				$this->load->view('invoice/cetakemail',$d);
			} else {
				$this->load->view('invoice/cetak',$d);
			}
		}else{
			header('location:'.base_url());
		}
	}
}

/* End of file invoice.php */
/* Location: ./application/controllers/invoice.php */