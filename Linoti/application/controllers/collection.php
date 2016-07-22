<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection extends CI_Controller {
	
	public function name()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			$d['brand']=urldecode($this->uri->segment(3));
			$brand=urldecode($this->uri->segment(3));
			$cari = $this->input->post('txt_cari');
			if(empty($cari)){
				$where = " WHERE brand.brand_name='$brand' ";
			}else{
				$where = " WHERE brand.brand_name='$brand' AND collection.coll_code LIKE '%$cari%' OR collection.coll_name LIKE '%$cari%'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "$brand";
			
			//paging
			$page=$this->uri->segment(4);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT collection.coll_code, collection.coll_brand, brand.brand_name, collection.coll_name FROM collection JOIN brand ON brand.brand_code=collection.coll_brand $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/collection/name/' . $brand;
			$config['total_rows'] = $tot_hal->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
			$config['next_link'] = 'Next &raquo;';
			$config['prev_link'] = '&laquo; Prev';
			$config['last_link'] = '<b>Last &raquo; </b>';
			$config['first_link'] = '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT collection.coll_code, collection.coll_brand, brand.brand_name, collection.coll_name FROM collection JOIN brand ON brand.brand_code=collection.coll_brand $where 
					ORDER BY coll_code ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('collection/view', $d, true);		
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

			$d['brand']=urldecode($this->uri->segment(3));
			$brand=urldecode($this->uri->segment(3));
			$d['judul']="$brand Collection";
			
			#$text0 = "SELECT brand_code FROM brand WHERE brand_name='$collection'";
			#$q = $this->app_model->manualQuery($text0);
			#$data = $q->row();
			
			$kode	= $this->app_model->MaxCollectionVal();
			
			$d['kode']		= $kode;
			$d['nama_val']	='';
			
			$text = "SELECT * FROM brand WHERE brand_name='$brand'";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('collection/form', $d, true);		
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
			
			$id = $this->uri->segment(3);
			$temp = explode(':', $id);
			
			$d['judul'] = "Collection - ".urldecode($temp[0]);
			
			
			$text = "SELECT * FROM collection WHERE coll_code='$temp[1]' AND coll_brand='$temp[2]'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['brand_code']		=$temp[2];
					$d['kode'] = $temp[1];
					$d['nama_val']	=$db->coll_name;
					$d['brand_name']	=$temp[0];
				}
			}else{
					$d['brand_code']		=$temp[2];
					$d['kode'] = '';
					$d['nama_val']	='';
					$d['brand_name']	='';
			}
						
			$d['content'] = $this->load->view('collection/form', $d, true);		
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
			$temp= explode(':', $id);
			$this->app_model->manualQuery("DELETE FROM collection WHERE coll_code='$temp[1]' AND coll_brand='$temp[2]'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/collection/name/".$temp[0]."'>";
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
				
				
				$up['coll_code']	= $this->input->post('kode');
				$up['coll_brand']	= $this->input->post('brand_code');
				$up['coll_name']	= $this->input->post('nama_val');
				
				$id['coll_code']=$this->input->post('kode');
				$id['coll_brand']=$this->input->post('brand_code');
				
				$data = $this->app_model->getSelectedData("collection",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("collection",$up,$id);
					//echo 'Update data Sukses';
				}else{
					$this->app_model->insertData("collection",$up);
					//echo 'Simpan data Sukses';
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file collection.php */
/* Location: ./application/controllers/collection.php */