<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departemen extends CI_Controller {
	
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
				$where = "WHERE companyarea='$loc' and dept_code<>'000'";
			}else{
				$where = " WHERE companyarea='$loc' and (dept_code LIKE '%$cari%' OR dept_name LIKE '%$cari%') AND dept_code<>'000'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Department";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM departemen_fact $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/departemen/index/';
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
			

			$text = "SELECT * FROM departemen_fact $where 
					ORDER BY dept_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('departemen/view', $d, true);		
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

			$d['judul']="Add Department";
			
			$kode	= $this->app_model->MaxKodeDept();
			
			$d['kode']		= $kode;
			$d['nama_dept']	='';
			
			$d['content'] = $this->load->view('departemen/form', $d, true);		
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
			
			$d['judul'] = "Edit Department";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM departemen_fact WHERE dept_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode']		=$id;
					$d['nama_dept']	=$db->dept_name;
				}
			}else{
					$d['kode']		=$id;
					$d['nama_dept']	='';
			}
						
			$d['content'] = $this->load->view('departemen/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM departemen_fact WHERE dept_code='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/departemen'>";			
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
				
				
				$up['dept_code']	= $this->input->post('kode');
				$up['dept_name']	= $this->input->post('nama_dept');
				$up['editedby']		= $user;
				$up['editedtime']	= $tgl;
				
				$id['dept_code']=$this->input->post('kode');
				$id['companyarea']=$loc;
				
				$data = $this->app_model->getSelectedData("departemen_fact",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("departemen_fact",$up,$id);
				}else{
					$up['createdby']	= $user;
					$up['createdtime']  = $tgl;
					$up['companyarea']  = $loc;
					$this->app_model->insertData("departemen_fact",$up);
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file departemen.php */
/* Location: ./application/controllers/departemen.php */