<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
	
	public function index()
	{
		$cek 			= $this->session->userdata('logged_in');
		$loc 			= $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = "WHERE companyarea='$loc' and cust_code<>'000'";
			}else{
				$where = " WHERE companyarea='$loc' and (cust_code LIKE '%$cari%' OR cust_name LIKE '%$cari%') AND cust_code<>'000'";
			}
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="Customer";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM customer $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/customer/index/';
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
			

			$text = "SELECT * FROM customer $where 
					ORDER BY cust_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('customer/view', $d, true);		
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

			$d['judul']="Tambah Customer";
			
			$d['kode']			=	'';
			$d['nama_cust']	=	'';
			$d['name_code']	=	'';
			$d['alamat']		=	'';
			$d['negara']		=	'';
			$d['telp']			=	'';
			$d['fax']				=	'';
			$d['mobile']		=	'';
			$d['email']			=	'';
			$d['status']		=	'1';
			
			$d['content'] = $this->load->view('customer/form', $d, true);		
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
			$d['myheader']	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Edit Customer";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM customer WHERE cust_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode']			=	$id;
					$d['nama_cust']	=	$db->cust_name;
					$d['name_code']	=	$db->name_code;
					$d['alamat']		=	$db->cust_address;
					$d['negara']		=	$db->cust_country;
					$d['telp']			=	$db->cust_phone;
					$d['fax']				=	$db->cust_fax;
					$d['mobile']		=	$db->cust_mobile;
					$d['email']			=	$db->cust_email;
				}
			}else{
					$d['kode']			=	$id;
					$d['nama_cust']	=	'';
					$d['name_code']	=	'';
					$d['alamat']		=	'';
					$d['negara']		=	'';
					$d['telp']			=	'';
					$d['fax']				=	'';
					$d['mobile']		=	'';
					$d['email']			=	'';
			}
					
			$d['status']		='2';
			$d['content'] = $this->load->view('customer/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM customer WHERE cust_code='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/customer'>";			
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
		if(!empty($cek)){
				$kode="";
				if ($this->input->post('kode')=='0'){
					$text = "SELECT MAX(cust_code) as maks from customer";
					$data = $this->app_model->manualQuery($text);
					foreach($data->result() as $dt){
						$kode = $dt->maks + 1;
					}
				}else{
					$kode=$this->input->post('kode');
				}
				
				$up['cust_code']		= $kode;
				$up['cust_name']		= $this->input->post('nama_cust');
				$up['name_code']		= $this->input->post('name_code');
				$up['cust_address']	= $this->input->post('alamat');
				$up['cust_country']		= $this->input->post('negara');
				$up['cust_phone']		= $this->input->post('telp');
				$up['cust_fax']			= $this->input->post('fax');
				$up['cust_mobile']	= $this->input->post('mobile');
				$up['cust_email']		= $this->input->post('email');
				$up['editedby']			= $user;
				$up['editedtime']		= $tgl;
				
				$id['cust_code']	=$kode;
				$id['companyarea']	=$loc;
				
				$data = $this->app_model->getSelectedData("customer",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("customer",$up,$id);
				}else{
					$up['createdby']		= $user;
					$up['createdtime']	= $tgl;
					$up['companyarea']	= $loc;
					$this->app_model->insertData("customer",$up);		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */