<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE A.companyarea='$loc' ";
			}else{
				$where = " WHERE A.companyarea='$loc' and (A.supplier_code LIKE '%$cari%' OR A.supplier_name LIKE '%$cari%')";
			}
			
			$d['prg']			= $this->config->item('prg');
			$d['web_prg']	= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']	=	"Supplier";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.supplier_code FROM supplier A $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/supplier/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment'] 	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT A.supplier_code,A.supplier_name,A.supplier_phone,A.supplier_fax,A.supplier_website,A.supplier_remarks,A.supplier_country,A.supplier_state,A.capital_city FROM supplier A $where 
					ORDER BY A.supplier_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('supplier/view', $d, true);		
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
			$d['myheader'] 	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			$d['judul']	=	"Add Supplier";
			
			//$kode	= $this->app_model->MaxKodeSup();
			//$seq	= $this->app_model->MaxSeqSup($kode);
			
			$d['kode']			= '';
			$d['nama_supp']	= '';
			$d['alamat']		= '';
			$d['kodepos']		= '';
			$d['kota']			= '';
			$d['propinsi']	= '';
			$d['negara']		= '';
			$d['telp']			= '';
			$d['fax']				= '';
			$d['email']			= '';
			$d['website']		= '';
			$d['remarks']		= '';
			$d['status']		= '1';
			$d['kode_po']		= '0';
			
			//$text ="SELECT negara_code,negara FROM negara ORDER BY negara";
			//$d['l_negara'] = $this->app_model->manualQuery($text);
			
			//$text ="SELECT propinsi_code,propinsi FROM propinsi ORDER BY propinsi";
			//$d['l_propinsi'] = $this->app_model->manualQuery($text);
			
			//$text ="SELECT kota_code,kota FROM kota ORDER BY kota";
			//$d['l_kota'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('supplier/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] 	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Edit Supplier";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM supplier WHERE supplier_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					
					$d['nama_supp']	=	$db->supplier_name;
					$d['alamat']		=	$db->supplier_address;
					$d['kodepos']		=	$db->kode_pos;
					$d['kota']			=	$db->capital_city;
					$d['propinsi']	=	$db->supplier_state;
					$d['negara']		=	$db->supplier_country;
					$d['telp']			=	$db->supplier_phone;
					$d['fax']				=	$db->supplier_fax;
					$d['email']			=	$db->supplier_email;
					$d['website']		=	$db->supplier_website;
					$d['remarks']		=	$db->supplier_remarks;
					$d['kode_po']		=	$db->kode_po;
				}
			}else{
					$d['nama_supp']	= '';
					$d['alamat']		= '';
					$d['kodepos']		= '';
					$d['kota']			= '';
					$d['propinsi']	= '';
					$d['negara']		= '';
					$d['telp']			= '';
					$d['fax']				= '';
					$d['email']			= '';
					$d['website']		= '';
					$d['remarks']		= '';
					$d['kode_po']		= '';
			}
			
			$d['kode']			=	$id;
			$d['status']		=	'2';		
			
			//$text ="SELECT negara_code,negara FROM negara ORDER BY negara";
			//$d['l_negara'] = $this->app_model->manualQuery($text);	

			//$text ="SELECT propinsi_code,propinsi FROM propinsi ORDER BY propinsi";
			//$d['l_propinsi'] = $this->app_model->manualQuery($text);			
			
			//$text ="SELECT kota_code,kota FROM kota ORDER BY kota";
			//$d['l_kota'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('supplier/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM supplier WHERE supplier_code='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM d_supplier WHERE supplier_code='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/supplier'>";			
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
			$this->app_model->manualQuery("DELETE FROM d_supplier WHERE supplier_code='$id' AND sequence='$kode' and companyarea='$loc'");
			
			$this->edit();
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		$user = $this->session->userdata('username');
		$loc = $this->session->userdata('companyarea');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
				
				if (empty($this->input->post('kode'))){
					$kode	= $this->app_model->MaxKodeSup();
				}else {
					$kode	= $this->input->post('kode');
				}
				$up['supplier_code']				= $kode;
				$up['supplier_name']				= $this->input->post('nama_supp');
				$up['supplier_address']			= $this->input->post('alamat');
				$up['supplier_country']			= $this->input->post('negara');
				$up['supplier_state']				= $this->input->post('propinsi');
				$up['capital_city']					= $this->input->post('kota');
				$up['supplier_phone']				= $this->input->post('telp');
				$up['supplier_fax']					= $this->input->post('fax');
				$up['supplier_website']			= $this->input->post('website');
				$up['supplier_remarks']			= $this->input->post('remarks');
				$up['supplier_email']				= $this->input->post('email');
				$up['kode_po']							= $this->input->post('kode_po');
				$up['supplier_editedby']		= $user;
				$up['supplier_editedtime']	= $tgl;
				
				$ud['supplier_code'] 		= $kode;
				if ($this->input->post('sequence')<>'')
					{$ud['sequence'] 			= $this->input->post('sequence');}
				else
					{$ud['sequence'] 			= $this->app_model->MaxSeqSup($kode);}
				$ud['name'] 						= $this->input->post('name');
				$ud['position'] 				= $this->input->post('position');
				$ud['mobile1'] 					= $this->input->post('mobile1');
				$ud['mobile2'] 					= $this->input->post('mobile2');
				$ud['mobile3'] 					= $this->input->post('mobile3');
				$ud['email1'] 					= $this->input->post('email1');
				$ud['email2'] 					= $this->input->post('email2');
				$ud['email3'] 					= $this->input->post('email3');
				$ud['remarks'] 					= $this->input->post('remarkscontact');
				$ud['editedby'] 				= $user;
				$ud['editedtime'] 			= $tgl;
				
				$id['supplier_code']		=	$kode;
				$id['companyarea']			=	$loc;
				
				$id_d['supplier_code']	=	$kode;
				$id_d['sequence']				=	$this->input->post('sequence');
				$id_d['companyarea']		=	$loc;
				
				$data = $this->app_model->getSelectedData("supplier",$id);
				
				
				$id_po['supplier_code !='] = $kode;
				$id_po['kode_po'] = $this->input->post('kode_po');
				$id_po['companyarea']		=	$loc;
				
				$datapo = $this->app_model->getSelectedData("supplier",$id_po);
				
				if ($datapo->num_rows() > 0){
					echo 'Supplier PO Code : '.$this->input->post('kode_po').' already used by other Supplier!';
				}else {
					if($data->num_rows()>0){
						$this->app_model->updateData("supplier",$up,$id);
						$data = $this->app_model->getSelectedData("d_supplier",$id_d);
						
						if($data->num_rows()>0){
							$this->app_model->updateData("d_supplier",$ud,$id_d);
						}
						else{
							if (trim($this->input->post('name'))<>'')
							{
								$ud['createdby'] 		= $user;
								$ud['createdtime'] 	= $tgl;
								$ud['companyarea'] 	= $loc;
								$this->app_model->insertData("d_supplier",$ud);
							}
						} 
					}else{
						$up['supplier_createdby'] 	= $user;
						$up['supplier_createdtime'] = $tgl;
						$up['companyarea'] 					= $loc;
						$this->app_model->insertData("supplier",$up);
						
						if (trim($this->input->post('name'))<>'')
						{
							$ud['createdby'] 		= $user;
							$ud['createdtime'] 	= $tgl;
							$ud['companyarea'] 	= $loc;
							$this->app_model->insertData("d_supplier",$ud);
						} 
					} 
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$id = $this->input->post('kode');
			$text = "SELECT A.supplier_code, A.sequence, A.name, A.position,  A.mobile1, A.mobile2, A.mobile3,  A.email1, A.email2, A.email3, A.remarks
					FROM d_supplier A
					WHERE A.supplier_code='$id' and A.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('supplier/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file supplier.php */
/* Location: ./application/controllers/supplier.php */