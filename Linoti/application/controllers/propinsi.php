<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Propinsi extends CI_Controller {
	
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
				$where = "WHERE companyarea='$loc'";
			}else{
				$where = " WHERE companyarea='$loc' and (negara_code LIKE '%$cari%' OR negara LIKE '%$cari%') ";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Propinsi";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT negara_id,negara_code,negara FROM negara $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/propinsi/index/';
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
			

			$text = "SELECT negara_id,negara_code,negara FROM negara $where 
					ORDER BY negara ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('propinsi/view', $d, true);		
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

			$d['judul']="Tambah Negara";
			
			//$kode	= $this->app_model->MaxKodeDept();
			
			$d['negara_id']		= 0;
			$d['negara_code']		= '';
			$d['negara']	='';
			
			$d['content'] = $this->load->view('propinsi/form', $d, true);		
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
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Tambah Propinsi";
			
			$id = $this->uri->segment(3);
			$text = "SELECT negara_id,negara_code,negara FROM negara WHERE negara_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['negara_code']	=$db->negara_code;
					$d['negara']		=$db->negara;
				}
			}else{
					
					$d['negara_code']	='';
					$d['negara']		='';
			}
			$d['negara_id']		=$id;
			
			$d['content'] = $this->load->view('propinsi/form', $d, true);		
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
			$negara_code = $this->uri->segment(3);
			$propinsi_code = $this->uri->segment(4);
			$this->app_model->manualQuery("DELETE FROM propinsi WHERE negara_code='$negara_code' and propinsi_code='$propinsi_code' and companyarea='$loc'");
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
				$up['negara_code']	= $this->input->post('negara_code');
				$up['propinsi_code']	= $this->input->post('propinsi_code');
				$up['propinsi']	= $this->input->post('propinsi');
				$up['editedby']		= $user;
				$up['editedtime']	= $tgl;
				
				$id['negara_code']=$this->input->post('negara_code');
				$id['propinsi_code']=$this->input->post('propinsi_code');
				$id['companyarea']=$loc;
				
				$data = $this->app_model->getSelectedData("propinsi",$id);
				if($data->num_rows()>0){
					echo 'Simpan data Gagal. Kode sudah digunakan.';
				}else{
					$up['createdby']	= $user;
					$up['createdtime']  = $tgl;
					$up['companyarea']  = $loc;
					$this->app_model->insertData("propinsi",$up);
					echo 'Simpan data Sukses';		
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
			$text = "SELECT A.negara_code, A.propinsi_code, A.propinsi
					FROM propinsi A
					WHERE A.negara_code='$id' and A.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('propinsi/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */