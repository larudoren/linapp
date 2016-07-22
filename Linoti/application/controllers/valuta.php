<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Valuta extends CI_Controller {
	
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
				$where = ' ';
			}else{
				$where = " WHERE currency_code LIKE '%$cari%' OR currency_name LIKE '%$cari%'";
			}
			
			$d['prg']			= $this->config->item('prg');
			$d['web_prg']	= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="Rates";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM currency $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/valuta/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment']	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT * FROM currency $where 
					ORDER BY currency_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('valuta/view', $d, true);		
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

			$d['judul']="Add Rates";
			
			$kode	= $this->app_model->MaxKodeVal();
			
			$d['kode']			= $kode;
			$d['nama_val']	=	'';
			$d['rates_val']	=	'';
			
			$d['content'] = $this->load->view('valuta/form', $d, true);		
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
			$d['myheader'] 	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Edit Rates";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM currency WHERE currency_code='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode']			=	$id;
					$d['nama_val']	=	$db->currency_name;
					$d['rates_val']	=	$db->rates;
				}
			}else{
					$d['kode']			=	$id;
					$d['nama_val']	=	'';
					$d['rates_val']	=	'';
			}
						
			$d['content'] = $this->load->view('valuta/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM currency WHERE currency_code='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/valuta'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek 	= $this->session->userdata('logged_in');
		$user	= $this->session->userdata('username');
		$loc	= $this->session->userdata('companyarea');
		$tgl	= date("Y-m-d H:i:s");
		if(!empty($cek)){
				
				
				$up['currency_code']	= $this->input->post('kode');
				$up['currency_name']	= $this->input->post('nama_val');
				$up['rates']					= $this->input->post('rates_val');
				$up['companyarea']		= $loc;
				$up['editedby']				= $user;
				$up['editedtime']			= $tgl;
				
				$id['currency_code']=$this->input->post('kode');
				
				$data = $this->app_model->getSelectedData("currency",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("currency",$up,$id);
				}else{
					$up['createdby']		= $user;
					$up['createdtime']	= $tgl;
					$up['companyarea']	= $loc;
					$this->app_model->insertData("currency",$up);
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file valuta.php */
/* Location: ./application/controllers/valuta.php */