<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Finishing extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] 						= isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] 	= $d['myheader'];
			$this->session->set_userdata($add_session);
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE companyarea='$loc' ";
			}else{
				$where = " WHERE companyarea='$loc' and (finishing_id LIKE '%$cari%' OR finishing LIKE '%$cari%')";
			}
			
			$d['prg']			= $this->config->item('prg');
			$d['web_prg']	= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="Master Finishing";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT finishing_id FROM finishing $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/finishing/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page']			= $limit;
			$config['uri_segment'] 	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link']		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT finishing_id,finishing FROM finishing $where 
					ORDER BY finishing ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('finishing/view', $d, true);		
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

			$d['judul']			="Add Finishing";
			
			$d['kode']			= 0;
			$d['finishing']	=	'';
			
			$d['content'] = $this->load->view('finishing/form', $d, true);		
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
			
			$d['judul'] = "Edit Finishing";
			
			$id = $this->uri->segment(3);
			$text = "SELECT finishing_id,finishing FROM finishing WHERE finishing_id='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					
					$d['finishing']	=	$db->finishing;
				}
			}else{
					$d['finishing']	=	'';
			}
			$d['kode']	=	$id;		
			$d['content'] = $this->load->view('finishing/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM finishing WHERE finishing_id='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/finishing'>";			
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
				
				
				$up['finishing']	= $this->input->post('finishing');
				$up['editedby']		= $user;
				$up['editedtime']	= $tgl;
				
				$id['finishing_id']=$this->input->post('kode');
				
				$data = $this->app_model->getSelectedData("finishing",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("finishing",$up,$id);
				}else{
					$up['createdby']			= $user;
					$up['createdtime']		= $tgl;
					$up['companyarea']		= $loc;
					$this->app_model->insertData("finishing",$up);		
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file finishing.php */
/* Location: ./application/controllers/finishing.php */