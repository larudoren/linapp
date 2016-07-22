<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		$mymenu = $this->session->userdata('mymenu');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$d['mymenu'] = isset($_REQUEST['mymenu']) ? $_REQUEST['mymenu'] : $mymenu;
			$add_session['myheader'] 	= $d['myheader'];
			$add_session['mymenu'] 		= $d['mymenu'];
			
			$this->session->set_userdata($add_session);
			
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE companyarea='$loc' ";
			}else{
				$where = " WHERE companyarea='$loc' and (brand_code LIKE '%$cari%' OR brand_name LIKE '%$cari%') ";
			} 
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Research";
			
			//paging
			
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT * FROM brand $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/brand/index/';
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
			
			

			$text = "SELECT * FROM brand $where 
					ORDER BY brand_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT * FROM collection";
			$d['l_collection'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT * from type_product";
			$d['l_type'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('brand/view', $d, true);		
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

			$d['judul']="brand";
			
			$kode	= $this->app_model->MaxBrandVal();
			
			$d['kode']		= $kode;
			$d['nama_val']	='';
			
			$d['content'] = $this->load->view('brand/form', $d, true);		
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
			
			$d['judul'] = "Brand";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM brand WHERE brand_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode']		=$id;
					$d['nama_val']	=$db->brand_name;
				}
			}else{
					$d['kode']		=$id;
					$d['nama_val']	='';
			}
						
			$d['content'] = $this->load->view('brand/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM brand WHERE brand_code='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM collection WHERE coll_brand='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/brand'>";			
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
				
				
				$up['brand_code']	= $this->input->post('kode');
				$up['brand_name']	= $this->input->post('nama_val');
				$up['editedby']		= $user;
				$up['editedtime']	= $tgl;
				
				$id['brand_code']	= $this->input->post('kode');
				$id['companyarea']	= $loc;
				
				$data = $this->app_model->getSelectedData("brand",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("brand",$up,$id);
					//echo 'Update data Sukses';
				}else{
					$up['createdby']	= $user;
					$up['createdtime']	= $tgl;
					$up['companyarea']	= $loc;
					$this->app_model->insertData("brand",$up);
					//echo 'Simpan data Sukses';
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file brand.php */
/* Location: ./application/controllers/brand.php */