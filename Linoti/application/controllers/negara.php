<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Negara extends CI_Controller {
	
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
				$where = " WHERE companyarea='$loc' and (negara_id LIKE '%$cari%' OR negara LIKE '%$cari%') ";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Negara";
			
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
			
			$config['base_url'] = site_url() . '/negara/index/';
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 3;
			$config['next_link'] = 'Lanjut &raquo;';
			$config['prev_link'] = '&laquo; Kembali';
			$config['last_link'] = '<b>Terakhir &raquo; </b>';
			$config['first_link'] = '<b> &laquo; Pertama</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT negara_id,negara_code,negara FROM negara $where 
					ORDER BY negara ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('negara/view', $d, true);		
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
			
			$d['content'] = $this->load->view('negara/form', $d, true);		
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
			
			$d['judul'] = "Edit Negara";
			
			$id = $this->uri->segment(3);
			$text = "SELECT negara_id,negara_code,negara FROM negara WHERE negara_id='$id' and companyarea='$loc'";
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
			
			$d['content'] = $this->load->view('negara/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$loc  = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$this->app_model->manualQuery("DELETE FROM negara WHERE negara_id='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/negara'>";			
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
				
				
				$up['negara_id']	= $this->input->post('negara_id');
				$up['negara_code']	= $this->input->post('negara_code');
				$up['negara']	= $this->input->post('negara');
				$up['editedby']		= $user;
				$up['editedtime']	= $tgl;
				
				$id['negara_id']=$this->input->post('negara_id');
				$id['companyarea']=$loc;
				
				$data = $this->app_model->getSelectedData("negara",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("negara",$up,$id);
					echo 'Update data Sukses';
				}else{
					$up['createdby']	= $user;
					$up['createdtime']  = $tgl;
					$up['companyarea']  = $loc;
					$this->app_model->insertData("negara",$up);
					echo 'Simpan data Sukses';		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */