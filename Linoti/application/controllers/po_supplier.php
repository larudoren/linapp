<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po_supplier extends CI_Controller {
	
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
				$where = " WHERE companyarea='$loc' and (supplier_name LIKE '%$cari%')";
			}
			
			$d['prg']			= $this->config->item('prg');
			$d['web_prg']	= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="PO Supplier";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT supplier_code FROM supplier $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/po_supplier/index/';
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
			

			$text = "SELECT supplier_code,supplier_name,kode_po FROM supplier $where 
					ORDER BY supplier_name ASC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('po_supplier/view', $d, true);		
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
			
			$d['judul'] = "PO Supplier";
			
			$id = $this->uri->segment(3);
			$text = "SELECT supplier_code,kode_po FROM supplier WHERE supplier_code='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					
					$d['kode']	=	$db->kode_po;
					$d['supplier_code']	=	$db->supplier_code;
				}
			}else{
					$d['kode']	=	'';
					$d['supplier_code']	=	'';
			}
			//$d['kode']	=	$id;		
			$d['content'] = $this->load->view('po_supplier/form', $d, true);		
			$this->load->view('home',$d);
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
				
				
				$up['kode_po']	= $this->input->post('kode');
				$up['supplier_editedby']		= $user;
				$up['supplier_editedtime']	= $tgl;
				
				$id['supplier_code']=$this->input->post('supplier_code');
				$id['companyarea']=$loc;
				
				$data = $this->app_model->getSelectedData("supplier",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("supplier",$up,$id);	
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file po_supplier.php */
/* Location: ./application/controllers/po_supplier.php */