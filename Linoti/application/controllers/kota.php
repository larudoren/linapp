<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kota extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			$cari = $this->input->post('txt_cari');
			$loc  = $this->session->userdata('companyarea');
			if(empty($cari)){
				$where = "WHERE A.companyarea='$loc'";
			}else{
				$where = " WHERE A.companyarea='$loc' and (A.negara_code LIKE '%$cari%' OR A.propinsi_code LIKE '%$cari%' OR A.propinsi LIKE '%$cari%') ";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']	=	"Kota";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.negara_code,A.propinsi_code,A.propinsi,B.negara FROM propinsi A LEFT OUTER JOIN negara B ON B.negara_code=A.negara_code and B.companyarea=A.companyarea $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/kota/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment'] 	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] 				=	$this->pagination->create_links();
			$d['hal'] 							= $offset;
			

			$text = "SELECT A.negara_code,A.propinsi_code,A.propinsi,B.negara FROM propinsi A LEFT OUTER JOIN negara B ON B.negara_code=A.negara_code and B.companyarea=A.companyarea $where 
					ORDER BY B.negara,A.propinsi ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('kota/view', $d, true);		
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
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			$d['judul']	=	"Tambah Negara";
			
			$d['negara_id']			= 0;
			$d['negara_code']		= '';
			$d['negara']				='';
			
			$d['content'] = $this->load->view('kota/form', $d, true);		
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
			$d['myheader'] = $myheader;
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Edit Negara";
			
			$negara_code = $this->uri->segment(3);
			$propinsi_code = $this->uri->segment(4);
			$text = "SELECT A.negara_code,A.propinsi_code,A.propinsi,B.negara FROM propinsi A LEFT OUTER JOIN negara B on B.negara_code=A.negara_code and B.companyarea=A.companyarea WHERE A.negara_code='$negara_code' and A.propinsi_code='$propinsi_code' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){

					$d['propinsi']	=	$db->propinsi;
					$d['negara']		=	$db->negara;
				}
			}else{
					
					
					$d['propinsi']	=	'';
					$d['negara']		=	'';
			}
			
			$d['negara_code']		=	$negara_code;
			$d['propinsi_code']	=	$propinsi_code;
			
			$d['content'] = $this->load->view('kota/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc  = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$kota_code = $this->uri->segment(5);
			$propinsi_code = $this->uri->segment(4);
			$this->app_model->manualQuery("DELETE FROM kota WHERE kota_code='$kota_code' and propinsi_code='$propinsi_code' and companyarea='$loc'");
			$this->edit();			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek  = $this->session->userdata('logged_in');
		$loc  = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl  = date("Y-m-d H:i:s");
		if(!empty($cek)){
				$up['propinsi_code']	= $this->input->post('propinsi_code');
				$up['kota_code']			= $this->input->post('kota_code');
				$up['kota']						= $this->input->post('kota');
				$up['editedby']				= $user;
				$up['editedtime']			= $tgl;
				
				$id['propinsi_code']	=	$this->input->post('propinsi_code');
				$id['kota_code']			=	$this->input->post('kota_code');
				$id['companyarea']		=	$loc;
				
				$data = $this->app_model->getSelectedData("kota",$id);
				if($data->num_rows()>0){
					echo 'Save Failed. Code already use';
				}else{
					$up['createdby']		= $user;
					$up['createdtime']  = $tgl;
					$up['companyarea']  = $loc;
					$this->app_model->insertData("kota",$up);	
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
			$text = "SELECT B.negara_code,A.propinsi_code,A.kota_code, A.kota
					FROM kota A
					LEFT OUTER JOIN propinsi B ON B.Propinsi_code=A.propinsi_code
					WHERE A.propinsi_code='$id' and A.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('kota/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
}

/* End of file kota.php */
/* Location: ./application/controllers/kota.php */