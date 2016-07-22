<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotation extends CI_Controller {
	
	var $kodebarang;
	public $dataFooterGlobal ='';
/*
	function __construct() {
        parent::__construct();
       // $this->dataFooter = '';
    }
	 */
	 
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
			//$this->kodebarang ='';
			//$this->session->set_userdata('kodebarang', $this->kodebarang);
			if(empty($cari)){
				$cari = $this->session->userdata('cari');
				if(empty($cari)) {
					$where = "WHERE A.companyarea='$loc' ";
				} else {
					$where = "WHERE A.companyarea='$loc' and (A.product_code LIKE '%$cari%' OR A.collection LIKE '%$cari%' or A.name LIKE '%$cari%' OR A.finishing LIKE '%$cari%') ";
				}
				
			}else{
				$sess_data['cari'] = $this->input->post("txt_cari");
				$this->session->set_userdata($sess_data);
				$cari = $this->session->userdata('cari');
				$where = "WHERE A.companyarea='$loc' and (A.product_code LIKE '%$cari%' OR A.collection LIKE '%$cari%' or A.name LIKE '%$cari%' OR A.finishing LIKE '%$cari%') ";
				
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Data Cotation";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.id_cotation
						FROM h_cotation A
						$where";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/cotation/index/';
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
			

			$text = "SELECT A.id_cotation, A.product_code, A.collection, A.name, A.finishing
						FROM h_cotation A
						$where
						ORDER BY A.product_code 
						LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('cotation/view', $d, true);		
			if (($tot_hal->num_rows() - $offset) < 15){
				$d['mymenu'] = 'Research';
			}
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = $myheader;
			$this->kodebarang ='';
			$this->session->set_userdata('kodebarang', $this->kodebarang);
			$this->load->model('app_model');
			$d['hal'] = $this->uri->segment(5);
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Add Cotation";
			
			$d['id_cotation']		= '';
			$d['product_code']	= '';
			$d['collection']		= '';
			$d['name']					= '';
			$d['finishing']			= '';
			$d['status']				= '1';
			
			$text = "SELECT dept_code,dept_name FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT distinct(A.kode_barang),A.nama_barang FROM barang A LEFT OUTER JOIN departemen_fact B on B.dept_code=A.departemen where (A.nama_barang!='' OR A.nama_barang_eng!='') and B.dept_code='UPHOLD'";
			$d['l_material'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT family_id,family FROM family";
			$d['l_fam'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('cotation/form', $d, true);		
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
			
			$d['judul'] = "Edit Cotation";
			
			$id = $this->uri->segment(3); 
			$finishing = $this->uri->segment(4); 
			$d['hal'] = $this->uri->segment(5);
			$this->kodebarang =$id;
			$this->session->set_userdata('kodebarang', $this->kodebarang);
	
			$text = "SELECT * FROM h_cotation
					WHERE id_cotation='$id' and finishing='$finishing' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['id_cotation'] 		= $id;
					$d['product_code'] 		= $db->product_code;
					$d['collection'] 			= $db->collection;
					$d['name']		= $db->name;
					$d['finishing']		= $finishing;
				}
			}else{
					$d['id_cotation'] 		= '';
					$d['product_code'] 		= '';
					$d['collection'] 			= '';
					$d['name']		= '';
					$d['finishing']		= '';
			}
			
			$d['status']		= '2';
			
			$text = "SELECT material_id,material FROM material";
			$d['l_material'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT finishing_id,finishing FROM finishing";
			$d['l_finishing'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('cotation/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM h_cotation WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_upholstery WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_wood WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_panel WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_accessories WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_assembling WHERE id_cotation='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM cotation_sanding_amplas WHERE id_cotation='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/cotation'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_cotation()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id_cotation = $this->input->post('id_cotation');
			$seq = $this->input->post('seq');
			$seq_det = $this->input->post('seq_det');
			$type = $this->input->post('type');
			if (empty($seq_det) || $seq_det=='0'){
				$temp = "";
			} else {
				$temp = " and seq_det='$seq_det'";
			}
			$this->app_model->manualQuery("DELETE FROM cotation_".$type." WHERE id_cotation='$id_cotation' and seq='$seq' $temp and companyarea='$loc'");
			echo "Delete Successful!";			
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
		$tgl_id = date("Ym");
			
		if(!empty($cek)){
			$v_id_cotation = $this->input->post('id_cotation');
			
			if (empty($v_id_cotation))
			{
				$text = "SELECT max(id_cotation) as no FROM h_cotation A where A.companyarea='$loc' and A.id_cotation like '".$tgl_id."___' order by A.id_cotation DESC limit 1";
				$tabel = $this->app_model->manualQuery($text);
				$row = $tabel->num_rows();
				if($row>0){
					//$t = $tabel->result();
					foreach($tabel->result() as $t) {
						$vNum = ((int) substr($t->no,-3))+1;
					}
				}else{
					$vNum = 1;
				}
				$id_cotation = $tgl_id.STR_PAD($vNum,3,'0',STR_PAD_LEFT);
			}else
				$id_cotation = $v_id_cotation;
			
			$up['id_cotation']		= $id_cotation;
			$up['product_code']		= $this->input->post('product_code');
			$up['collection']			= $this->input->post('collection');
			$up['name']						= $this->input->post('name');
			$up['finishing']			= $this->input->post('finishing');
			$up['editedby']				= $user;
			$up['editedtime']			= $tgl;
			
			$id['id_cotation']		= $id_cotation;
			$id['product_code']		= $this->input->post('product_code');
			$id['finishing']			= $this->input->post('finishing');
			$id['companyarea']		= $loc;
			
			$data = $this->app_model->getSelectedData("h_cotation",$id);
					
			if($data->num_rows()>0){
				$this->app_model->updateData("h_cotation",$up,$id);
				echo 'Update Successful!';
			}else{
				$up['createdby']		= $user;
				$up['createdtime']	= $tgl;
				$up['companyarea']	= $loc;
				$this->app_model->insertData("h_cotation",$up);
				echo 'Save Successful!';		
			}
				
		}else{
			header('location:'.base_url());
		}
	
	}
	
	public function simpan_uphold(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$tgl_id = date("Ym");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				
				if (empty($this->input->post('seq_'.$i))){
					
					$text = "SELECT MAX(seq) as Seq from cotation_upholstery where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}
				else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				$up['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$up['seq'] 							= $Seq;
				$up['komponen1'] 				= urlencode($this->input->post('komponen1_'.$i));
				$up['komponen2']				= urlencode($this->input->post('komponen2_'.$i));
				$up['komponen3'] 				= $this->input->post('komponen3_'.$i);
				$up['material_family'] 	= $this->input->post('family_id_'.$i);
				$up['material'] 				= $this->input->post('kode_barang_'.$i);
				$up['length'] 					= $this->input->post('length_'.$i);
				$up['width'] 						= $this->input->post('width_'.$i);
				$up['height'] 					= $this->input->post('height_'.$i);
				$up['inpieces'] 				= $this->input->post('inpieces_'.$i);
				$up['volume'] 					= $this->input->post('volume_'.$i);
				$up['quantity'] 					= $this->input->post('quantity_'.$i);
				$up['average_waste'] 		= $this->input->post('mat_waste_'.$i);
				$up['special_waste'] 		= $this->input->post('comp_waste_'.$i);
				$up['h_comp_waste'] 		= $this->input->post('h_comp_waste_'.$i);
				$up['consumption'] 			= $this->input->post('consumption_'.$i);
				$up['consumption_m'] 			= $this->input->post('consumption_m_'.$i);
				$up['sqf25'] 						= $this->input->post('sqf25_'.$i);
				$up['sqf28'] 						= $this->input->post('sqf28_'.$i);
				$up['sqf3048'] 					= $this->input->post('sqf3048_'.$i);
				$up['run_m140'] 				= $this->input->post('runningmeter140_'.$i);
				$up['run_m150'] 				= $this->input->post('runningmeter150_'.$i);
				$up['run_m160'] 				= $this->input->post('runningmeter160_'.$i);
				$up['run_mm47'] 				= $this->input->post('runningmeter047_'.$i);
				$up['run_mm50'] 				= $this->input->post('runningmeter050_'.$i);
				$up['run_mm57'] 				= $this->input->post('runningmeter057_'.$i);
				$up['kilo'] 						= $this->input->post('kilo_'.$i);
				$up['pieces'] 					= $this->input->post('pieces_'.$i);
				$up['harga_mat'] 				= $this->input->post('harga_mat_'.$i);
				$up['currency'] 				= $this->input->post('currency_'.$i);
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_upholstery",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_upholstery",$up,$id);
					//echo 'Update data Sukses';
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_upholstery",$up);
					//echo 'Simpan data Sukses';
				}
				echo 'Save Successful!';
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan_wood(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$tgl_id = date("Ym");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_wood where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				
				
				$up['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$up['seq'] 							= $Seq;
				$up['module'] 					= $this->input->post('comp_module_'.$i);
				$up['komponen1']				= urlencode($this->input->post('comp_name1_'.$i));
				$up['komponen2'] 				= urlencode($this->input->post('comp_name2_'.$i));
				$up['material'] 				= $this->input->post('wood_type_'.$i);
				$up['length_all'] 			= $this->input->post('length_'.$i);
				$up['length_tenonl'] 		= $this->input->post('length_left_'.$i);
				$up['length_comp'] 			= $this->input->post('length_center_'.$i);
				$up['length_tenonr'] 		= $this->input->post('length_right_'.$i);
				$up['tenon_glue'] 			= $this->input->post('length_glue_'.$i);
				$up['width'] 						= $this->input->post('width_'.$i);
				$up['height'] 					= $this->input->post('height_'.$i);
				$up['quantity'] 				= $this->input->post('quantity_'.$i);
				$up['shape_waste'] 			= $this->input->post('shape_waste_'.$i);
				$up['raw_length'] 			= $this->input->post('raw_length_'.$i);
				$up['raw_width'] 				= $this->input->post('raw_width_'.$i);
				$up['raw_height'] 			= $this->input->post('raw_height_'.$i);
				$up['vol_raw'] 					= $this->input->post('vol_raw_'.$i);
				$up['vol_finished'] 		= $this->input->post('vol_finished_'.$i);
				$up['waste_log_plank'] 	= $this->input->post('waste_log_plank_'.$i);
				$up['waste_plank_raw'] 	= $this->input->post('waste_plank_raw_'.$i);
				$up['waste_raw_finished'] 	= $this->input->post('waste_raw_comp_'.$i);
				$up['cost_log_usd'] 				= $this->input->post('cost_log_usd_'.$i);
				$up['cost_log_idr'] 				= $this->input->post('cost_log_idr_'.$i);
				$up['cost_plank_usd'] 			= $this->input->post('cost_plank_usd_'.$i);
				$up['cost_plank_idr'] 			= $this->input->post('cost_plank_idr_'.$i);
				$up['cost_raw_usd'] 				= $this->input->post('cost_raw_usd_'.$i);
				$up['cost_raw_idr'] 				= $this->input->post('cost_raw_idr_'.$i);
				$up['cost_finished_usd'] 		= $this->input->post('cost_finish_usd_'.$i);
				$up['cost_finished_idr'] 		= $this->input->post('cost_finish_idr_'.$i);
				$up['production_cost'] 			= $this->input->post('production_cost_'.$i);
				$up['currency'] 						= $this->input->post('currency_'.$i);
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_wood",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_wood",$up,$id);
					//echo 'Update data Sukses';
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_wood",$up);
					//echo 'Simpan data Sukses';
				}
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan_panel(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$tgl_id = date("Ym");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_panel where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
					$Seq_det = 0;
				}else{
					$Seq = $this->input->post('seq_'.$i);
					if (empty($this->input->post('seq_det_'.$i)) && $this->input->post('seq_det_'.$i)!='0'){
						$text = "SELECT MAX(seq_det) as Seq_det from cotation_panel where id_cotation='".$this->input->post('id_cotation_'.$i)."' and seq='$Seq' and companyarea='$loc'";
						$tabel = $this->app_model->manualQuery($text);
						
						$row = $tabel->num_rows();
						if($row>0){
							$vSeq_det = 0;
							foreach($tabel->result() as $t){
								$vSeq_det = $t->Seq_det;
							}
							$Seq_det = $vSeq_det + 1;
						}else{
							$Seq_det = 1;
						}
					} else {
						$Seq_det = $this->input->post('seq_det_'.$i);
					}
				}
				
				$up['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$up['seq'] 							= $Seq;
				$up['seq_det'] 					= $Seq_det;
				$up['module'] 					= $this->input->post('comp_module_'.$i);
				$up['komponen1']				= urlencode($this->input->post('comp_name1_'.$i));
				$up['komponen2'] 				= urlencode($this->input->post('comp_name2_'.$i));
				$up['material'] 				= $this->input->post('panel_type_'.$i);
				$up['length'] 					= $this->input->post('length_'.$i);
				$up['width'] 						= $this->input->post('width_'.$i);
				$up['height'] 					= $this->input->post('height_'.$i);
				$up['quantity'] 				= $this->input->post('quantity_'.$i);
				$up['shape_waste'] 			= $this->input->post('shape_waste_'.$i);
				$up['raw_length'] 			= $this->input->post('raw_length_'.$i);
				$up['raw_width'] 				= $this->input->post('raw_width_'.$i);
				$up['raw_height'] 			= $this->input->post('raw_height_'.$i);
				$up['faces_a'] 					= $this->input->post('faces_a_'.$i);
				$up['faces_a_amount'] 	= $this->input->post('faces_a_amount_'.$i);
				$up['type_material_a'] 	= $this->input->post('type_material_a_'.$i);
				$up['faces_a_total'] 		= $this->input->post('faces_a_total_'.$i);
				$up['faces_b'] 					= $this->input->post('faces_b_'.$i);
				$up['faces_b_amount'] 	= $this->input->post('faces_b_amount_'.$i);
				$up['type_material_b'] 	= $this->input->post('type_material_b_'.$i);
				$up['faces_b_total'] 	= $this->input->post('faces_b_total_'.$i);
				$up['area_panel_q_w'] 	= $this->input->post('area_panel_total_'.$i);
				$up['finished_area_panel'] 	= $this->input->post('finished_area_panel_'.$i);
				$up['area_panel_quantity'] 	= $this->input->post('area_panel_'.$i);
				$up['raw_cost'] 				= $this->input->post('raw_cost_'.$i);
				$up['production_cost'] 	= $this->input->post('production_cost_'.$i);
	
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['seq_det'] 					= $Seq_det;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_panel",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_panel",$up,$id);
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_panel",$up);
				}
				
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan_accessories(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$tgl_id = date("Ym");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_accessories where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				
				$up['id_cotation'] 		= $this->input->post('id_cotation_'.$i);
				$up['seq'] 						= $Seq;
				$up['acc_hard'] 			= urlencode($this->input->post('acc_hard_'.$i));
				$up['material'] 			= $this->input->post('accessories_type_'.$i);
				$up['hidesize'] 					= $this->input->post('hidesize_'.$i);
				$up['finishing'] 			= $this->input->post('finishing_'.$i);
				$up['quantity'] 			= $this->input->post('quantity_'.$i);
				$up['unit'] 					= $this->input->post('unit_'.$i);
	
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_accessories",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_accessories",$up,$id);
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_accessories",$up);
				}
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan_assembling(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			if ($this->input->post('indoortype_0')==''){
				$temp = " and asstype!='".$this->input->post('asstype_0')."'";
			} else {
				$temp = " and indoortype!='".$this->input->post('indoortype_0')."'";
			}
			$textdel = "DELETE FROM cotation_assembling where id_cotation='".$this->input->post('id_cotation_0')."' $temp and companyarea='$loc'";
			$this->app_model->manualQuery($textdel);
			
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_assembling where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				$up['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$up['seq'] 							= $Seq;
				$up['comp_name1'] 			= urlencode($this->input->post('comp_name1_'.$i));
				$up['comp_name2'] 			= urlencode($this->input->post('comp_name2_'.$i));
				$up['supplier'] 				= $this->input->post('supplier_'.$i);
				$up['quantity'] 				= $this->input->post('quantity_'.$i);
				$up['harga'] 						= $this->input->post('harga_'.$i);
				$up['tanggal'] 					= date_format(date_create_from_format("d/m/Y",$this->input->post('date_'.$i)),"Y-m-d");
				$up['asstype'] 					= $this->input->post('asstype_'.$i);
				$up['indoortype'] 			= $this->input->post('indoortype_'.$i);
	
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_assembling",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_assembling",$up,$id);
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_assembling",$up);
				}
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	public function simpan_sanding() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_sanding_amplas where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				$up['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$up['seq'] 							= $Seq;
				$up['kode_barang'] 			= $this->input->post('hardware_'.$i);
				$up['estimate_area'] 		= $this->input->post('estimate_'.$i);
				$up['quantity'] 				= $this->input->post('quantity_'.$i);
	
				$up['editedby'] 				= $user;
				$up['editedtime'] 			= $tgl;
				
				$id['id_cotation'] 			= $this->input->post('id_cotation_'.$i);
				$id['seq'] 							= $Seq;
				$id['companyarea'] 			= $loc;
				
				$data = $this->app_model->getSelectedData("cotation_sanding_amplas",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("cotation_sanding_amplas",$up,$id);
				}else{
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("cotation_sanding_amplas",$up);
				}
				
			}
		}else{
				header('location:'.base_url());
		}
	}
	
	
	public function clear () {
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$this->session->unset_userdata('cari');
			redirect('cotation');
		}else{
				header('location:'.base_url());
		}
	}
	
	public function supplier() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$vkodebarang = $this->session->userdata('kodebarang');
		if(!empty($cek)){
			$text ="SELECT A.kode_barang,C.supplier_name,D.currency_name,A.hargabeli,DATE_FORMAT(B.tglbeli,'%d-%m-%Y') as tglbeli 
					FROM d_beli A 
					LEFT OUTER JOIN h_beli B on B.companyarea=A.companyarea and B.po=A.po 
					LEFT OUTER JOIN supplier C on C.companyarea=B.companyarea and C.supplier_code=B.kode_supplier 
					LEFT OUTER JOIN currency D on D.currency_code=A.currency 
					where A.kode_barang='$vkodebarang' and A.companyarea='$loc'
					ORDER BY B.tglbeli DESC";
			$d['data'] = $this->app_model->manualQuery($text);
			$text ="SELECT A.kode_barang,B.supplier_name 
					FROM barang A supplier B on B.companyarea=A.companyarea and B.supplier_code=A.supplier_code 
					LEFT OUTER JOIN ";

			/*
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_barang'] 	= $db->kode_barang;
					$d['supplier'] 		= $db->supplier_name;
					$d['currency'] 		= $db->currency_name;
					$d['harga'] 		= $db->hargabeli;
					$d['tanggal'] 		= $db->tglbeli;
				}
			}else{
				$d['kode_barang'] 	= '';
				$d['supplier'] 		= '';
				$d['currency'] 		= '';
				$d['harga'] 		= '';
				$d['tanggal'] 		= '';
			} */
			
			$this->load->view('barang/view_supplier', $d);
		}else{	
			header('location:'.base_url());
		}
	}
	
	public function setData($array){
		$this->dataFooter = $array;
	}
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$dataFooter = array();
			$id = $this->uri->segment(3);
			$text = "SELECT A.id_cotation,A.seq, A.komponen1, A.komponen2, A.komponen3,A.material_family, C.family,A.material,  D.nama_barang, A.length, A.width, A.height,A.volume,A.inpieces, A.currency, A.average_waste, A.special_waste,A.quantity,E.`type` as tipe,F.unit_name,A.consumption,A.consumption_m,A.sqf25,A.sqf28,A.sqf3048,A.run_m140,A.run_m150,A.run_m160,A.run_mm47,A.run_mm50,A.run_mm57,A.kilo,A.pieces,A.harga_mat,G.simbol as unit_ukuran,A.h_comp_waste,D.ppn
					FROM cotation_upholstery A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					LEFT OUTER JOIN family C ON C.family_id=A.material_family
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `type` E ON E.type_id=D.`type`
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.satuan
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=D.size_length_unit
					WHERE A.id_cotation='$id' and A.companyarea='$loc' 
					ORDER BY A.komponen1,A.komponen2,A.komponen3,C.family,D.nama_barang";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data = array();
			
			$temp=0;
			if($row>0){
				$tempStr	= '';
				$tempFooter = 0;
				$sqf25		= 0;
				$sqf28		= 0;
				$sqf3048	= 0;
				$run_m140 = 0;
				$run_m150 = 0;
				$run_m160 = 0;
				$run_mm47 = 0;
				$run_mm50	= 0;
				$run_mm57	= 0;
				$kilo			= 0;
				$pieces		= 0;
				
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] = $t->id_cotation;
					$data[$temp]['seq'] 				= $t->seq;
					$data[$temp]['komponen1'] 	= htmlentities($t->komponen1);
					$data[$temp]['komponen2'] 	= urldecode($t->komponen2);
					$data[$temp]['komponen3'] 	= urldecode($t->komponen3);
					$data[$temp]['family_id'] 	= $t->family;
					$data[$temp]['hidden_family'] = $t->family;
					$data[$temp]['hidden_name'] 	= $t->nama_barang;
					$data[$temp]['material_family'] = $t->material_family;
					$data[$temp]['material'] 				= $t->material;
					$data[$temp]['kode_barang'] 		= $t->nama_barang;
					
					if ($t->length==0){
						$data[$temp]['length'] 				= '';
					} else {
						$data[$temp]['length'] 				= $t->length;
					}
					
					if ($t->width==0){
						$data[$temp]['width'] 				= '';
					} else {
						$data[$temp]['width'] 				= $t->width;
					}
					
					if ($t->height==0)
						$data[$temp]['height'] 			= '';
					else
						$data[$temp]['height'] 			= $t->height;
					
					$data[$temp]['length_unit'] 	= $t->unit_ukuran;
					
					if ($t->volume==0){
						$data[$temp]['volume'] 			= '';
					} else {
						$data[$temp]['volume'] 			= $t->volume;
					}
					
					if ($t->inpieces==0){
						$data[$temp]['inpieces'] 		= '';
					} else {
						$data[$temp]['inpieces'] 		= $t->inpieces;
					}
					
					if ($t->average_waste==0){
						$data[$temp]['mat_waste'] 	= '';
					} else {
						$data[$temp]['mat_waste'] 	= $t->average_waste;
					}
					
					if (empty($t->h_comp_waste)){
						$data[$temp]['comp_waste'] 	= '';
					} else {
						$data[$temp]['comp_waste'] 	= $t->special_waste;
					}
					
					$data[$temp]['hidden_comp_waste'] 		= $t->h_comp_waste;
					$data[$temp]['brg_harga'] 		= $t->harga_mat;
					$data[$temp]['quantity'] 			= $t->quantity;
					$data[$temp]['currency'] 			= $t->currency;
					
					if ($t->consumption==0){
						$data[$temp]['consumption'] 		= '';
						$data[$temp]['consumption_m2'] 	= '';
					} else {
						$data[$temp]['consumption'] 		= $t->consumption;
						$data[$temp]['consumption_m2'] 	= $t->consumption/1000000;
					}
					
					if ($t->consumption_m==0){
						$data[$temp]['consumption_m'] = '';
					} else {
						$data[$temp]['consumption_m'] = $t->consumption_m;
					}
					
					$data[$temp]['type'] 						= $t->tipe;
					$data[$temp]['unit_name'] 			= $t->unit_name;
					
					if ($t->sqf25==0){
						$data[$temp]['sqf25'] 				= '';
					}else{
						$data[$temp]['sqf25'] 				= $t->sqf25;
					}
					
					if ($t->sqf28==0){
						$data[$temp]['sqf28'] 				= '';
					} else {
						$data[$temp]['sqf28'] 				= $t->sqf28;
					}
					
					if ($t->sqf3048==0){
						$data[$temp]['sqf3048'] 			= '';
					} else {
						$data[$temp]['sqf3048'] 			= $t->sqf3048;
					}
					
					if ($t->run_m140==0){
						$data[$temp]['runningmeter140'] 	= '';
					} else {
						$data[$temp]['runningmeter140'] 	= $t->run_m140;
					}
					
					if ($t->run_m150==0){
						$data[$temp]['runningmeter150'] 	= '';
					} else {
						$data[$temp]['runningmeter150'] 	= $t->run_m150;
					}
					
					if ($t->run_m160==0){
						$data[$temp]['runningmeter160'] 	= '';
					} else {
						$data[$temp]['runningmeter160'] 	= $t->run_m160;
					}
					
					if ($t->run_mm47==0){
						$data[$temp]['runningmeter047'] 	= '';
					} else {
						$data[$temp]['runningmeter047'] 	= $t->run_mm47;
					}
					
					if ($t->run_mm50==0){
						$data[$temp]['runningmeter050'] 	= '';
					} else {
						$data[$temp]['runningmeter050'] 	= $t->run_mm50;
					}
					
					if ($t->run_mm57==0){
						$data[$temp]['runningmeter057'] 	= '';
					} else {
						$data[$temp]['runningmeter057'] 	= $t->run_mm57;
					}
					
					if ($t->kilo==0){
						$data[$temp]['kilo'] 							= '';
					} else {
						$data[$temp]['kilo'] 							= $t->kilo;
					}
					
					if ($t->pieces==0){
						$data[$temp]['pieces'] 						= '';
					} else {
						$data[$temp]['pieces'] 						= $t->pieces;
					}
					
					$data[$temp]['editable'] 					= '1';
					/*
					if (strpos($tempStr,$t->nama_barang)!==false){
					} else {
						$dataFooter[$tempFooter]['kode_barang'] = $t->nama_barang;
						$dataFooter[$tempFooter]['family'] = $t->family;
						$dataFooter[$tempFooter]['ppn'] = $t->ppn;
						$tempStr .= ' '.$t->nama_barang;
						$textSum = "SELECT SUM(A.consumption_m) as consumption_m,SUM(A.consumption) as consumption,SUM(A.sqf25) as sqf25,SUM(A.sqf28) as sqf28,SUM(A.sqf3048) as sqf3048,SUM(A.run_m140) as run_m140,SUM(A.run_m150) as run_m150,SUM(A.run_m160) as run_m160,SUM(A.run_mm47) as run_mm47,SUM(A.run_mm50) as run_mm50,SUM(A.run_mm57) as run_mm57,SUM(A.kilo) as kilo,SUM(A.inpieces) as pieces,AVG(A.harga_mat) as harga, A.currency
												FROM cotation_upholstery A WHERE id_cotation='".$t->id_cotation."' and material='".$t->material."'";
						$tabelSum= $this->app_model->manualQuery($textSum);
						foreach($tabelSum->result() as $sum){
							$dataFooter[$tempFooter]['consumption_m'] 	= round($sum->consumption_m,6);
							$dataFooter[$tempFooter]['sqf25'] 					= Ceil($sum->sqf25);
							$dataFooter[$tempFooter]['sqf28'] 					= Ceil($sum->sqf28);
							$dataFooter[$tempFooter]['sqf3048'] 				= Ceil($sum->sqf3048);
							$dataFooter[$tempFooter]['runningmeter140'] 	= round($sum->run_m140,6);
							$dataFooter[$tempFooter]['runningmeter150'] 	= round($sum->run_m150,6);
							$dataFooter[$tempFooter]['runningmeter160'] 	= round($sum->run_m160,6);
							$dataFooter[$tempFooter]['runningmeter047'] 	= Ceil($sum->run_mm47);
							$dataFooter[$tempFooter]['runningmeter050'] 	= Ceil($sum->run_mm50);
							$dataFooter[$tempFooter]['runningmeter057'] 	= Ceil($sum->run_mm57);
							$dataFooter[$tempFooter]['kilo'] 							= round($sum->kilo,6);
							$dataFooter[$tempFooter]['pieces'] 						= Ceil($sum->pieces);
							$dataFooter[$tempFooter]['brg_harga'] 				= $sum->harga;
							$dataFooter[$tempFooter]['currency'] 					= $sum->currency;
							if (($sum->consumption_m + $sum->sqf25 + $sum->sqf28 + $sum->sqf3048 + $sum->run_m140 + $sum->run_m150 + $sum->run_m160 + $sum->run_mm47 + $sum->run_mm50 + $sum->run_mm57 + $sum->kilo + $sum->pieces)==0){
								$cons_m2 = round($sum->consumption/1000000,6);
							} else {
								$cons_m2 = 0;
							}
							$dataFooter[$tempFooter]['consumption_m2'] 	= $cons_m2;
							//if ($sum->currency=='Rp')
								$dataFooter[$tempFooter]['cost'] 	= number_format(round($cons_m2 + round($sum->consumption_m,6) + Ceil($sum->sqf25) + Ceil($sum->sqf28) + Ceil($sum->sqf3048) + round($sum->run_m140,6) + round($sum->run_m150,6) + round($sum->run_m160,6) + round($sum->run_mm47,6) + round($sum->run_mm50,6) + round($sum->run_mm57,6) + round($sum->kilo,6) + ceil($sum->pieces),6) * $sum->harga,0,'.',',');
							//else
							//	$dataFooter[$tempFooter]['cost'] 	= number_format(Ceil($cons_m2 + $sum->consumption_m + $sum->sqf25 + $sum->sqf28 + $sum->sqf3048 + $sum->run_m140 + $sum->run_m150 + $sum->run_m160 + $sum->run_mm47 + $sum->run_mm50 + $sum->run_mm57 + $sum->kilo + $sum->pieces) * $sum->harga,0,'.',',');
							//array_push($this->dataFooterGlobal,$dataFooter[$tempFooter]['sqf25'],$dataFooter[$tempFooter]['sqf28'],$dataFooter[$tempFooter]['sqf3048'],$dataFooter[$tempFooter]['runningmeter140'],$dataFooter[$tempFooter]['runningmeter150'],$dataFooter[$tempFooter]['runningmeter160'],$dataFooter[$tempFooter]['runningmeter047'],$dataFooter[$tempFooter]['runningmeter050'],$dataFooter[$tempFooter]['runningmeter057'],$dataFooter[$tempFooter]['kilo'],$dataFooter[$tempFooter]['pieces']);
						}
						$tempFooter++;
					} */
					$temp++;
				} 
			}
			$mydataFooter = ' '.json_encode($dataFooter);
			$this->session->set_userdata('dataFooterUpholstery',$mydataFooter);
			//echo '{"total":'.$row.',"rows":'.json_encode($data).',"footer":'.json_encode($dataFooter).'}';
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataWood()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$this->dataFooter ='';
			$id = $this->uri->segment(3);
			$text = "SELECT A.id_cotation,A.seq, A.module, A.komponen1, A.komponen2, A.material,  D.nama_barang, A.length_all as length, A.length_tenonl, A.length_comp, A.length_tenonr,A.tenon_glue, A.width, A.height, A.shape_waste, A.faces_a,A.faces_a_amount, A.faces_b,A.faces_b_amount, A.faces_c,A.faces_c_amount, A.faces_d,A.faces_d_amount, A.faces_e,A.faces_e_amount, A.faces_f,A.faces_f_amount,A.waste_log_plank,A.waste_plank_raw,A.waste_raw_finished,A.quantity,E.`type` as tipe,F.unit_name,A.currency,A.raw_length,A.raw_width,A.raw_height,A.vol_raw,A.vol_finished,A.cost_log_usd,A.cost_log_idr,A.cost_plank_usd,A.cost_plank_idr,A.cost_raw_usd,A.cost_raw_idr,A.cost_finished_usd,A.cost_finished_idr,A.faces_a_total,A.faces_b_total,A.faces_c_total,A.faces_d_total,A.faces_e_total,A.faces_f_total,G.nama_barang as nama_glue,H.layer as layer_a,I.layer as layer_b,J.layer as layer_c,K.layer as layer_d,L.layer as layer_e,M.layer as layer_f,A.production_cost
					FROM cotation_wood A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `type` E ON E.type_id=D.`type`
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.satuan
					LEFT OUTER JOIN barang G ON G.kode_barang=A.tenon_glue and G.companyarea=A.companyarea
					LEFT OUTER JOIN layer H ON H.layer_id=A.faces_a
					LEFT OUTER JOIN layer I ON I.layer_id=A.faces_b
					LEFT OUTER JOIN layer J ON J.layer_id=A.faces_c
					LEFT OUTER JOIN layer K ON K.layer_id=A.faces_d
					LEFT OUTER JOIN layer L ON L.layer_id=A.faces_e
					LEFT OUTER JOIN layer M ON M.layer_id=A.faces_f
					WHERE A.id_cotation='$id' and A.companyarea='$loc' 
					ORDER BY A.module,A.komponen1,A.komponen2";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data = array();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] 	= $t->id_cotation;
					$data[$temp]['seq'] 					= $t->seq;
					$data[$temp]['comp_module'] 	= $t->module;
					$data[$temp]['comp_name1'] 		= $t->komponen1;
					$data[$temp]['comp_name2'] 		= $t->komponen2;
					$data[$temp]['wood_type'] 		= $t->nama_barang;
					$data[$temp]['hidebarang'] 		= $t->material;
					$data[$temp]['length'] 				= $t->length;
					$data[$temp]['length_left'] 	= $t->length_tenonl;
					$data[$temp]['length_center'] = $t->length_comp;
					$data[$temp]['length_right'] 	= $t->length_tenonr;
					$data[$temp]['length_glue'] 	= $t->nama_glue;
					$data[$temp]['hideglue'] 			= $t->tenon_glue;
					$data[$temp]['hidea'] 			= $t->faces_a;
					$data[$temp]['hideb'] 			= $t->faces_b;
					$data[$temp]['hidec'] 			= $t->faces_c;
					$data[$temp]['hided'] 			= $t->faces_d;
					$data[$temp]['hidee'] 			= $t->faces_e;
					$data[$temp]['hidef'] 			= $t->faces_f;
					$data[$temp]['width'] 				= $t->width;
					$data[$temp]['height'] 				= $t->height; 
					$data[$temp]['quantity'] 			= $t->quantity; 
					$data[$temp]['shape_waste'] 	= $t->shape_waste; 
					$data[$temp]['raw_length'] 		= $t->raw_length; 
					$data[$temp]['raw_width'] 		= $t->raw_width; 
					$data[$temp]['raw_height'] 		= $t->raw_height; 
					$data[$temp]['vol_raw'] 			= $t->vol_raw; 
					$data[$temp]['vol_finished'] 	= $t->vol_finished; 
					$data[$temp]['total_vol_raw'] = $t->vol_raw * $t->quantity; 
					$data[$temp]['total_vol_finished'] 	= $t->vol_finished * $t->quantity; 
					$data[$temp]['faces_a'] 						= $t->layer_a; 
					$data[$temp]['faces_a_amount'] 			= $t->faces_a_amount; 
					$data[$temp]['faces_b'] 						= $t->layer_b; 
					$data[$temp]['faces_b_amount'] 			= $t->faces_b_amount; 
					$data[$temp]['faces_c'] 						= $t->layer_c; 
					$data[$temp]['faces_c_amount'] 			= $t->faces_c_amount; 
					$data[$temp]['faces_d'] 						= $t->layer_d; 
					$data[$temp]['faces_d_amount'] 			= $t->faces_d_amount; 
					$data[$temp]['faces_e'] 						= $t->layer_e; 
					$data[$temp]['faces_e_amount'] 			= $t->faces_e_amount; 
					$data[$temp]['faces_f'] 						= $t->layer_f; 
					$data[$temp]['faces_f_amount'] 	= $t->faces_f_amount; 
					$data[$temp]['faces_a_total'] 	= $t->faces_a_total; 
					$data[$temp]['faces_b_total'] 	= $t->faces_b_total; 
					$data[$temp]['faces_c_total'] 	= $t->faces_c_total; 
					$data[$temp]['faces_d_total'] 	= $t->faces_d_total; 
					$data[$temp]['faces_e_total'] 	= $t->faces_e_total; 
					$data[$temp]['faces_f_total'] 	= $t->faces_f_total; 
					$data[$temp]['waste_log_plank'] = $t->waste_log_plank; 
					$data[$temp]['waste_plank_raw'] = $t->waste_plank_raw; 
					$data[$temp]['waste_raw_comp'] 	= $t->waste_raw_finished; 
					$data[$temp]['cost_log_usd'] 		= $t->cost_log_usd; 
					$data[$temp]['cost_log_usd'] 		= $t->cost_log_idr; 
					$data[$temp]['cost_plank_usd'] 	= $t->cost_plank_usd; 
					$data[$temp]['cost_plank_idr'] 	= $t->cost_plank_idr; 
					$data[$temp]['cost_raw_usd'] 		= $t->cost_raw_usd; 
					$data[$temp]['cost_raw_idr'] 		= $t->cost_raw_idr; 
					$data[$temp]['cost_finish_usd'] 	= $t->cost_finished_usd; 
					$data[$temp]['cost_finish_idr'] 	= $t->cost_finished_idr;
					$data[$temp]['production_cost'] 	= $t->production_cost;
					$temp++;
				} 
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataPanel(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$text = "SELECT A.id_cotation,A.seq,A.seq_det, A.module, A.komponen1, A.komponen2, A.material,  D.nama_barang, A.length, A.width, A.height,
											A.shape_waste, A.faces_a,A.faces_a_amount, A.faces_b,A.faces_b_amount, A.quantity,F.unit_name,A.currency,A.raw_length,A.raw_width,A.raw_height,H.layer as layer_a,
											I.layer as layer_b,A.type_material_a,A.type_material_b,J.nama_barang as type_material_a_nama,K.nama_barang as type_material_b_nama,A.raw_cost,A.faces_a_total,
											A.faces_b_total,A.area_panel_quantity,A.area_panel_q_w,A.finished_area_panel
					FROM cotation_panel A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `type` E ON E.type_id=D.`type`
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.satuan
					LEFT OUTER JOIN layer H ON H.layer_id=A.faces_a
					LEFT OUTER JOIN layer I ON I.layer_id=A.faces_b
					LEFT OUTER JOIN barang J on J.kode_barang=A.type_material_a AND J.companyarea=A.companyarea
					LEFT OUTER JOIN barang K on K.kode_barang=A.type_material_b AND K.companyarea=A.companyarea
					WHERE A.id_cotation='$id' and A.companyarea='$loc' 
					ORDER BY A.module,A.komponen1,A.komponen2,A.seq_det";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$data = array();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] 	= $t->id_cotation;
					$data[$temp]['seq'] 					= $t->seq;
					$data[$temp]['seq_det'] 			= $t->seq_det;
					$data[$temp]['comp_module'] 	= $t->module;
					$data[$temp]['comp_name1'] 		= $t->komponen1;
					$data[$temp]['comp_name2'] 		= $t->komponen2;
					$data[$temp]['panel_type'] 		= $t->nama_barang;
					$data[$temp]['hidebarang'] 		= $t->material;
					$data[$temp]['hidetype_material_a'] 		= $t->type_material_a;
					$data[$temp]['hidetype_material_b'] 		= $t->type_material_b;
					$data[$temp]['type_material_a'] 		= $t->type_material_a_nama;
					$data[$temp]['type_material_b'] 		= $t->type_material_b_nama;
					$data[$temp]['length'] 				= $t->length;
					if ($t->faces_a!=0){
						$data[$temp]['hidea'] 			= $t->faces_a;
					} else {
						$data[$temp]['hidea'] 			= '';
					}
					if ($t->faces_b!=0){
						$data[$temp]['hideb'] 			= $t->faces_b;
					} else {
						$data[$temp]['hideb'] 			= '';
					}
					$data[$temp]['width'] 				= $t->width;
					$data[$temp]['height'] 				= $t->height; 
					$data[$temp]['quantity'] 			= $t->quantity; 
					$data[$temp]['shape_waste'] 	= $t->shape_waste; 
					$data[$temp]['raw_length'] 		= $t->raw_length; 
					$data[$temp]['raw_width'] 		= $t->raw_width; 
					$data[$temp]['raw_height'] 		= $t->raw_height; 
					$data[$temp]['raw_cost'] 			= $t->raw_cost; 
					$data[$temp]['faces_a_total'] = $t->faces_a_total; 
					$data[$temp]['faces_b_total'] = $t->faces_b_total; 
					$data[$temp]['area_panel'] 		= $t->area_panel_quantity; 
					$data[$temp]['area_panel_total'] 			= $t->area_panel_q_w; 
					$data[$temp]['finished_area_panel'] 	= $t->finished_area_panel; 
					$data[$temp]['production_cost'] 			= number_format(($t->raw_cost*$t->area_panel_q_w),0,'.',','); 
					$data[$temp]['faces_a'] 							= $t->layer_a; 
					if ($t->faces_a_amount!=0){
						$data[$temp]['faces_a_amount'] 	= $t->faces_a_amount; 
					} else {
						$data[$temp]['faces_a_amount'] 	= ''; 
					}
					$data[$temp]['faces_b'] 					= $t->layer_b; 
					if ($t->faces_b_amount!=0){
						$data[$temp]['faces_b_amount'] 	= $t->faces_b_amount; 
					}else {
						$data[$temp]['faces_b_amount'] 	= ''; 
					}
					$temp++;
				} 
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataAccessories(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			$text = "SELECT A.id_cotation,A.seq,A.material,  D.nama_barang, A.quantity,F.unit_name,A.currency,A.harga,A.production_cost,A.acc_hard, D.kode_barang_spc, G.type, D.foto_barang, K.finishing,D.size_length,D.size_width,D.size_height,H.simbol as size_length_unit,D.size_diameter,I.simbol as size_diameter_unit,D.size_diameterin,J.simbol as size_diameterin_unit,D.size_thread
					FROM cotation_accessories A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.useper
					JOIN `type` G ON G.type_id=D.type
					LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=D.size_length_unit
					LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=D.size_diameter_unit
					LEFT OUTER JOIN t_unit_ukuran J ON J.unit_ukuran_id=D.size_diameterin_unit
					LEFT OUTER JOIN finishing K ON K.finishing_id=D.finishing
					WHERE A.id_cotation='$id' and A.companyarea='$loc' 
					ORDER BY D.nama_barang";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$TotalRp=0;
			$TotalUsd=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$size = '';
					$data[$temp]['id_cotation'] 			= $t->id_cotation;
					$data[$temp]['seq'] 							= $t->seq;
					$data[$temp]['accessories_type'] 	= $t->nama_barang;
					$data[$temp]['acc_hard'] 					= $t->acc_hard;
					$data[$temp]['code'] 							= $t->kode_barang_spc;
					$data[$temp]['hidefoto'] 					= $t->foto_barang;
					$data[$temp]['hidekodebarang'] 		= $t->material;
					$data[$temp]['hidenamabarang'] 		= $t->nama_barang;
					$data[$temp]['hideunit'] 					= $t->unit_name;
					$data[$temp]['hidefinishing'] 				= $t->finishing;
					$data[$temp]['type'] 							= $t->type;
					$data[$temp]['hidebarang'] 		= $t->material;
					$data[$temp]['quantity'] 			= $t->quantity; 
					$data[$temp]['currency'] 			= $t->currency; 
					$data[$temp]['brg_harga'] 		= $t->harga; 
					$data[$temp]['production_cost'] 	= $t->production_cost;
					
					if ($t->size_length > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_length);
						$fraction = $t->size_length - $whole;
						if ($fraction > 0){
							$size = $size.'L '.number_format($t->size_length,1,',','.').' x ';
						} else {
							$size = $size.'L '.number_format($t->size_length,0,',','.').' x ';
						}
					}
					
					if ($t->size_width > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_width);
						$fraction = $t->size_width - $whole;
						if ($fraction > 0){
							$size = $size.'W '.number_format($t->size_width,1,',','.').' x ';
						} else {
							$size = $size.'W '.number_format($t->size_width,0,',','.').' x ';
						}
					}
					
					if ($t->size_height > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_height);
						$fraction = $t->size_height - $whole;
						if ($fraction > 0){
							$size = $size.'H '.number_format($t->size_height,1,',','.').' x ';
						} else {
							$size = $size.'H '.number_format($t->size_height,0,',','.').' x ';
						}
					}
					
					if ($size!=''){
						$size = substr($size,0,-3);
						if (empty($t->size_length_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_length_unit.'; ';
						}
					}
					
					if ($t->size_diameter > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameter);
						$fraction = $t->size_diameter - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; out   '.number_format($t->size_diameter,1,',','.');
						} else {
							$size = $size.'&#216; out   '.number_format($t->size_diameter,0,',','.');
						}
						if (empty($t->size_diameter_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_diameter_unit.'; ';
						}
					}
					
					if ($t->size_diameterin > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($t->size_diameterin);
						$fraction = $t->size_diameterin - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,1,',','.');
						} else {
							$size = $size.'&#216; in   '.number_format($t->size_diameterin,0,',','.');
						}
						if (empty($t->size_diameterin_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$t->size_diameterin_unit.'; ';
						}
					}
					
					if ($t->size_thread!=''){
						$size = $size.$t->size_thread.'; ';
					}
					
					$data[$temp]['hidesize'] = urldecode($size);
					
					if ($t->currency=='Rp'){
						$TotalRp 	= $TotalRp + $t->production_cost;
					} else {
						$TotalUsd = $TotalUsd + $t->production_cost;
					}
						
					$temp++;
				}
			} 
			$dataFooter[0]['production_cost'] 	= $TotalRp;
			$dataFooter[0]['currency'] 					= 'Rp';
			$dataFooter[0]['accessories_type'] 	= 'TOTAL';
			$dataFooter[1]['production_cost'] 	= $TotalUsd;
			$dataFooter[1]['currency'] 					= '$';
			//echo json_encode($data);
			echo '{"total":'.$row.',"rows":'.json_encode($data).',"footer":'.json_encode($dataFooter).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataAssembling(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			$asstype = $this->input->post('asstype');
			$indoortype = $this->input->post('indoortype');
			if ($asstype=='Indoor'){
				if ($indoortype=='Harian' || $indoortype=='Borongan'){
					$where = "and A.asstype='$asstype' and A.indoortype='$indoortype'";
				} else {
					$where = "and A.asstype='$asstype' and A.indoortype='$indoortype'";
				}
			} else {
				$where = " and A.asstype='$asstype'";
			}
			$text = "SELECT A.id_cotation,A.seq,A.comp_name1,A.comp_name2,A.asstype,A.indoortype,  A.quantity, A.supplier,A.harga,date_format(A.tanggal,'%d/%m/%Y') as tanggal,A.supplier
					FROM cotation_assembling A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					WHERE A.id_cotation='$id' and A.companyarea='$loc'  $where
					ORDER BY A.comp_name1,A.comp_name2";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$TotalRp=0;
			$TotalUsd=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] 	= $t->id_cotation;
					$data[$temp]['seq'] 					= $t->seq;
					$data[$temp]['comp_name1'] 		= $t->comp_name1;
					$data[$temp]['comp_name2'] 		= $t->comp_name2;
					$data[$temp]['asstype'] 			= $t->asstype; 
					$data[$temp]['indoortype'] 		= $t->indoortype; 
					$data[$temp]['price'] 				= number_format($t->harga,0,'.',','); 
					$data[$temp]['date'] 					= $t->tanggal; 
					$data[$temp]['supplier'] 			= $t->supplier; 
					$data[$temp]['quantity'] 			= $t->quantity; 
					//$data[$temp]['production_cost'] 	= $t->production_cost;
					/*
					if ($t->currency=='Rp'){
						$TotalRp = $TotalRp + $t->production_cost;
					} else {
						$TotalUsd = $TotalUsd + $t->production_cost;
					}
						*/
					$temp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataSandingAmplas(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			$text ="SELECT A.id_cotation,A.seq,A.kode_barang,A.estimate_area,  A.quantity, (A.estimate_area*A.quantity) as total,C.nama_barang
					FROM cotation_sanding_amplas A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					JOIN barang C on C.kode_barang=A.kode_barang and C.companyarea=A.companyarea
					WHERE A.id_cotation='$id' and A.companyarea='$loc'
					ORDER BY C.nama_barang";
			$tabel	= $this->app_model->manualQuery($text);
			$row 		= $tabel->num_rows();
			
			$temp=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] = $t->id_cotation;
					$data[$temp]['seq'] 				= $t->seq;
					$data[$temp]['hardware'] 		= $t->nama_barang;
					$data[$temp]['hidebarang'] 	= $t->kode_barang;
					$data[$temp]['estimate'] 		= $t->estimate_area;
					$data[$temp]['quantity'] 		= $t->quantity;
					$data[$temp]['total'] 			= $t->total;
					$temp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataWoodSandingAmplas(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			$text ="SELECT D.type,SUM((A.length_all*A.width*A.quantity*2)+(A.length_all*A.height*A.quantity*2)+(A.height*A.width*A.quantity*2)) as total
					FROM cotation_wood A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					JOIN barang C on C.kode_barang=A.material and C.companyarea=A.companyarea
					JOIN `type` D on D.type_id=C.type
					WHERE A.id_cotation='$id' and A.companyarea='$loc'
					GROUP BY D.type";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$data = array();
			if($row>0){
				foreach($tabel->result() as $t){
					$data[$temp]['wood_type'] 	= $t->type;
					$data[$temp]['total_area'] 	= number_format($t->total/1000000,3);
					$temp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataVeneerSandingAmplas(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		if(!empty($cek)) {
			$id = $this->uri->segment(3);
			/*
			$text ="SELECT C.nama_barang,SUM((A.length*A.width*A.quantity*(A.faces_a_amount+A.faces_b_amount))) as total
					FROM cotation_panel A
					LEFT OUTER JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					LEFT OUTER JOIN barang C on C.kode_barang=A.type_material_a and C.companyarea=A.companyarea
					WHERE A.id_cotation='$id' and C.nama_barang!='' and A.companyarea='$loc'
					GROUP BY C.nama_barang"; */
			$text0 = "SELECT A.kode_barang,A.nama_barang,A.faces,A.faces_amount,A.faces_total FROM (
												(SELECT A.kode_barang,A.nama_barang,B.faces_a as faces,B.faces_a_amount as faces_amount,B.faces_a_total as faces_total 
												from barang A
												JOIN cotation_panel B ON B.type_material_a=A.kode_barang and B.companyarea=A.companyarea
												where B.id_cotation='$id' and B.companyarea='$loc') 
							UNION ALL (SELECT A.kode_barang,A.nama_barang,B.faces_b as faces,B.faces_b_amount as faces_amount,B.faces_b_total as faces_total 
												from barang A
												JOIN cotation_panel B ON B.type_material_b=A.kode_barang and B.companyarea=A.companyarea
												where B.id_cotation='$id' and B.companyarea='$loc')) A 
							LEFT OUTER JOIN layer C ON C.layer_id=A.faces
							Where C.layer='Veneer'";
			$tabel0= $this->app_model->manualQuery($text0);
			$row0 = $tabel0->num_rows();
			$text = "SELECT A.kode_barang,A.nama_barang,A.faces,A.faces_amount,SUM(A.faces_total) as total FROM (
												(SELECT A.kode_barang,A.nama_barang,B.faces_a as faces,B.faces_a_amount as faces_amount,B.faces_a_total as faces_total 
												from barang A
												JOIN cotation_panel B ON B.type_material_a=A.kode_barang and B.companyarea=A.companyarea
												where B.id_cotation='$id' and B.companyarea='$loc') 
							UNION ALL (SELECT A.kode_barang,A.nama_barang,B.faces_b as faces,B.faces_b_amount as faces_amount,B.faces_b_total as faces_total 
												from barang A
												JOIN cotation_panel B ON B.type_material_b=A.kode_barang and B.companyarea=A.companyarea
												where B.id_cotation='$id' and B.companyarea='$loc')) A 
							LEFT OUTER JOIN layer C ON C.layer_id=A.faces
							Where C.layer='Veneer'";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			$temp=0;
			$data = array();
			if($row0>0){
				foreach($tabel->result() as $t){
					$data[$temp]['veneer_type'] = $t->nama_barang;
					$data[$temp]['total_area'] 	= number_format($t->total/1000000,3);
					$temp++;
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).'}';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataDetailSum(){
		$dataFooter = $this->session->userdata('dataFooterUpholstery');
		echo $dataFooter;
	} 
	
	public function detail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)) {
			$d['myheader'] = $myheader;
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Data Cotation";
			$id = $this->uri->segment(3);
			$d['hal'] = $this->uri->segment(6);
			
			$text = "SELECT A.id_cotation,A.product_code, A.collection, A.name, A.finishing,B.product_photo,B.cm_length,B.cm_width,B.cm_height
							 FROM h_cotation A
							 LEFT OUTER JOIN product B ON B.product_code=A.product_code and B.companyarea=A.companyarea
							 where A.id_cotation='$id'";
			$d['id_cotation'] = $id;
			$d['data'] = $this->app_model->manualQuery($text);
			/*
			$size_data = $this->app_model->manualQuery($text);
			
			$row = $size_data->num_rows();
			if ($row>0){
				foreach($size_data->result() as $sz){
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($sz->cm_length);
					$fraction = $sz->cm_length - $whole;
					if ($fraction>0){
						$d['cm_length'] = $sz->cm_length;
					}else{
						$d['cm_length'] = floor($sz->cm_length);
					}
					
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($sz->cm_width);
					$fraction = $sz->cm_width - $whole;
					if ($fraction>0){
						$d['cm_width'] = $sz->cm_width;
					}else{
						$d['cm_width'] = floor($sz->cm_width);
					}
					
					$whole = 0;
					$fraction = 0.0;
					$whole = floor($sz->cm_height);
					$fraction = $sz->cm_height - $whole;
					if ($fraction>0){
						$d['cm_height'] = $sz->cm_height;
					}else{
						$d['cm_height'] = floor($sz->cm_height);
					}
				}
			} else {
				$d['cm_length'] ='';
				$d['cm_width'] ='';
				$d['cm_height'] ='';
			}
			*/
			$text2= "SELECT * FROM brand ORDER BY brand_name";
			$d['brand'] = $this->app_model->manualQuery($text2);
			
			$text = "SELECT A.view,B.textchild FROM otorisasicotation A left outer join cotationsource B on B.cotationid=A.cotationid and B.companyarea=A.companyarea where A.OPERATORID='$user'";
			$d['l_cotation'] = $this->app_model->manualQuery($text);
			
			$text ="SELECT A.asstype,A.indoortype from cotation_assembling A where A.id_cotation='$id' and A.companyarea='$loc' LIMIT 1";
			$d['l_assm'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT SUM((A.length_all*A.width*A.quantity*2)+(A.length_all*A.height*A.quantity*2)+(A.height*A.width*A.quantity*2)) as total FROM cotation_wood A where A.id_cotation='$id' and A.companyarea='$loc'";
			$d['t_wood'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT SUM(A.length*A.width*A.quantity*2) as total FROM cotation_panel A where A.id_cotation='$id' and A.companyarea='$loc'";
			$d['t_panel'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('cotation/detail', $d, true);		
			$this->load->view('home',$d);
		} else {
			header('location:'.base_url());
		}
	}
	
	public function view_image(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)) {
			$d['imageurl'] = base_url('asset/images/Upholdtsery.png');
			$this->load->view('cotation/view_image', $d);
		} else {
			header('location:'.base_url());
		}
	}
	
	function harga_cotation(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)) {
			$kode = $this->input->post('kode');
			$type = $this->input->post('type');
			if ($type=='upholstery'){
				$hasil = $this->app_model->harga_upholstery($kode);
			} else if ($type=='wood'){
				$hasil = $this->app_model->harga_wood($kode);
			}
			
			$data[0]['currency'] = $hasil[0];
			$data[0]['harga'] 	= $hasil[1];
			$data[0]['mat_waste'] 	= $hasil[2];
			echo json_encode($data);
		} else {
			header('location:'.base_url());
		}
		
	}
	
	function ukuranBarang(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)) {
			$kode = $this->input->post('kode');
			$type = $this->input->post('type');
			if ($type=='fabric'){
				$hasil = $this->app_model->ukuranBarang($kode);
			}
			
			$data[0]['length_unit'] = $hasil[0];
			$data[0]['size_length'] = $hasil[1];
			$data[0]['size_width'] = $hasil[2];
			$data[0]['size_height'] = $hasil[3];
			
			echo json_encode($data);
		} else {
			header('location:'.base_url());
		}
	}
	
	public function print_upholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$this->kodebarang ='';
			$this->session->set_userdata('kodebarang', $this->kodebarang);
			$this->load->model('app_model');
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Print Upholstery";
			
			$id = $this->uri->segment(3);
			$kode_barang = $this->uri->segment(4);
			
			$kode_barang = str_replace("-","','",$kode_barang);
			$kode_barang = substr($kode_barang,0,-3);
			
			$text = "SELECT A.id_cotation,A.product_code, A.collection, A.name, A.finishing
							 FROM h_cotation A
							 where A.id_cotation='$id'";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				foreach($tabel->result() as $t){
					$d['product_code'] = $t->product_code;
					$d['collection'] = $t->collection;
					$d['name'] = $t->name;
					$d['finishing'] = $t->finishing;
				}
			}else{
				$d['product_code'] = '';
				$d['collection'] = '';
				$d['name'] = '';
				$d['finishing'] = '';
			}
			$text = "SELECT A.id_cotation,A.seq, A.komponen1, A.komponen2, A.komponen3,A.material_family, C.family,A.material,  D.nama_barang, A.length, A.width, A.height,A.volume,A.inpieces, A.average_waste, A.special_waste,A.quantity,E.`type` as tipe,F.unit_name
					FROM cotation_upholstery A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					LEFT OUTER JOIN family C ON C.family_id=A.material_family
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `type` E ON E.type_id=D.`type`
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.satuan
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=D.size_length_unit
					WHERE A.id_cotation='$id' and A.companyarea='$loc' and A.seq IN ('$kode_barang')
					ORDER BY A.komponen1,A.komponen2,A.komponen3";
			$d['data']= $this->app_model->manualQuery($text);
			
			$this->load->view('cotation/print_upholstery',$d);
		}else{
			header('location:'.base_url());
		}
		
	}
	
	public function getDataPrint_Upholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$this->session->unset_userdata('up_dataprint_cotation_id');
			$this->session->unset_userdata('up_dataprint_data');
			
			$add_session['up_dataprint_cotation_id'] = $this->input->post('id_cotation');
			$this->session->set_userdata($add_session);
			
			$test['jml'] = $this->input->post('nArray');
			$data = array();
			for ($i=0;$i<$test['jml'];$i++){
				$data[$i]['nama_barang'] 			= $this->input->post('kode_barang_'.$i);
				$data[$i]['family'] 					= $this->input->post('family_'.$i);
				$data[$i]['brg_harga'] 					= $this->input->post('brg_harga_'.$i);
				$data[$i]['consumption_m'] 		= $this->input->post('consumption_m_'.$i);
				$data[$i]['sqf25'] 						= $this->input->post('sqf25_'.$i);
				$data[$i]['sqf28'] 						= $this->input->post('sqf28_'.$i);
				$data[$i]['sqf3048'] 					= $this->input->post('sqf3048_'.$i);
				$data[$i]['runningmeter140'] 	= $this->input->post('runningmeter140_'.$i);
				$data[$i]['runningmeter150'] 	= $this->input->post('runningmeter150_'.$i);
				$data[$i]['runningmeter160'] 	= $this->input->post('runningmeter160_'.$i);
				$data[$i]['runningmeter047'] 	= $this->input->post('runningmeter047_'.$i);
				$data[$i]['runningmeter050'] 	= $this->input->post('runningmeter050_'.$i);
				$data[$i]['runningmeter057'] 	= $this->input->post('runningmeter057_'.$i);
				$data[$i]['kilo'] 						= $this->input->post('kilo_'.$i);
				$data[$i]['ppn'] 						= $this->input->post('ppn_'.$i);
				$data[$i]['pieces'] 					= $this->input->post('pieces_'.$i);
				$data[$i]['consumption_m2'] 	= $this->input->post('consumption_m2_'.$i);
				$data[$i]['cost'] 						= $this->input->post('cost_'.$i);
			}
			
			$add_session['up_dataprint_data'] = $data;
			$this->session->set_userdata($add_session);
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function printCost_upholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$id_cotation = $this->session->userdata('up_dataprint_cotation_id');
		$data = $this->session->userdata('up_dataprint_data');
		
		if(!empty($cek)){
			
			
			if ($id_cotation==$this->uri->segment(3)){
				
				$text = "SELECT product_code, collection, name, finishing from h_cotation where id_cotation='".$id_cotation."'";
				$tabel= $this->app_model->manualQuery($text);
				$row = $tabel->num_rows();
				if($row>0){
					foreach($tabel->result() as $t){
						$d['product_code'] = $t->product_code;
						$d['collection'] = $t->collection;
						$d['name'] = $t->name;
						$d['finishing'] = $t->finishing;
					}
				}else{
					$d['product_code'] = '';
					$d['collection'] = '';
					$d['name'] = '';
					$d['finishing'] = '';
				}
				/*
				$test['jml'] = $this->input->post('nArray');
				$data = array();
				for ($i=0;$i<$test['jml'];$i++){
					$data[$i]['nama_barang'] 			= $this->input->post('kode_barang_'.$i);
					$data[$i]['consumption_m'] 		= $this->input->post('consumption_m_'.$i);
					$data[$i]['sqf25'] 						= $this->input->post('sqf25_'.$i);
					$data[$i]['sqf28'] 						= $this->input->post('sqf28_'.$i);
					$data[$i]['sqf3048'] 					= $this->input->post('sqf3048_'.$i);
					$data[$i]['runningmeter140'] 	= $this->input->post('runningmeter140_'.$i);
					$data[$i]['runningmeter150'] 	= $this->input->post('runningmeter150_'.$i);
					$data[$i]['runningmeter160'] 	= $this->input->post('runningmeter160_'.$i);
					$data[$i]['runningmeter047'] 	= $this->input->post('runningmeter047_'.$i);
					$data[$i]['runningmeter050'] 	= $this->input->post('runningmeter050_'.$i);
					$data[$i]['runningmeter057'] 	= $this->input->post('runningmeter057_'.$i);
					$data[$i]['kilo'] 						= $this->input->post('kilo_'.$i);
					$data[$i]['pieces'] 					= $this->input->post('pieces_'.$i);
					$data[$i]['consumption_m2'] 	= $this->input->post('consumption_m2_'.$i);
					$data[$i]['cost'] 						= $this->input->post('cost_'.$i);
				} */
				$d['data'] = $data;
				$this->load->view('cotation/printcost_upholstery',$d);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function showAccessories(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$d['kode_brg']			= '';
			$d['kode_brg_spc']		= '';
			$d['nama_brg']			= '';
			$d['nama_brg_en']		= '';
			$d['foto_brg']			= '';
			$d['family']			= '';
			$d['merek']				= '';
			$d['type']				= '';
			$d['detail']			= '';
			$d['satuan']			= '';
			$d['average_waste']			= '';
			$d['size_length']		= '';
			$d['size_width']		= '';
			$d['size_height']		= '';
			$d['size_length_unit']	= '';
			$d['size_weight']		= '';
			$d['size_weight_unit']	= '';
			$d['size_volume']		= '';
			$d['size_volume_unit']	= '';
			$d['size_area']			= '';
			$d['size_area_unit']	= '';
			$d['size_density']		= '';
			$d['size_density_unit']	= '';
			$d['size_density_code']	= '';
			$d['size_diameter']		= '';
			$d['size_diameter_unit']	= '';
			$d['size_diameterin']		= '';
			$d['size_diameterin_unit']	= '';
			$d['size_thread']	= '';
			$d['material']			= '';
			$d['finishing']			= '';
			$d['status']			= '1';
			$d['departemen'] 		= '';	
			$d['price']			= '';
			$d['currency']			= '';
			$d['psecure']			= '';
			$d['waste_log_plank']		= '';
			$d['waste_plank_raw']		= '';
			$d['waste_raw_comp']		= '';
			$d['rack']		= '';
			$d['row']		= '';
			$d['column']		= '';
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$text = "SELECT dept_code,dept_name FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_satuan'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_useper'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT family_id,family FROM family where departemen like '%ACCHRD%'";
			$d['l_fam'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT category_id,category FROM category";
			$d['l_category'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT type_id,`type` FROM type where departemen like '%ACCHRD%'";
			$d['l_type'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT merk_id,merk FROM merk";
			$d['l_merk'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_ukuran_id,`type`,unit_ukuran,simbol,ss_symbol FROM t_unit_ukuran";
			$d['l_ukuran'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT material_id,material FROM material";
			$d['l_material'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT finishing_id,finishing FROM finishing";
			$d['l_finishing'] = $this->app_model->manualQuery($text);
			
			
			$this->load->view('cotation/form_barang',$d);
		}else{	
			header('location:'.base_url());
		}
	}
	
	
	public function showUpholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$d['id_cotation'] = $id;
			$this->load->view('cotation/form_import_upholstery',$d);
		}else{	
			header('location:'.base_url());
		}
	}
	
	public function showImportAcc(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$d['id_cotation'] = $id;
			$this->load->view('cotation/form_import_accessories',$d);
		}else{	
			header('location:'.base_url());
		}
	}
	/*
	public function showResultUpholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$d['id_cotation'] = $id;
			$this->load->view('cotation/view_import_upholstery',$d);
		}else{	
			header('location:'.base_url());
		}
	} */
	
	/*
	public function import_upholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){
			require(APPPATH.'plugins/excelreader/excel_reader2.php');
			$this->load->model('app_model');
			error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			$cot_id = $this->uri->segment(3);
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Data Upholstery";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$this_product_code='';
			$d['text'] = array();
			
			for ($i=4; $i<=$hasildata; $i++){
				$vkode_product = $data->val($i, 1, $sheet=0);
				$textcot = "SELECT id_cotation from h_cotation where product_code='$vkode_product'";
				$cot_cek = $this->app_model->manualQuery($textcot);
				$cot_h = $cot_cek->row();
				
				if (!empty($cot_h->id_cotation) && $cot_id == $cot_h->id_cotation){
					
					if(empty($this_product_code)){
						$this_product_code=$vkode_product;
					}
					$vid_cotation = $cot_h->id_cotation;
					$komponen1 = $data->val($i, 2, $sheet=0);
					$komponen2 = $data->val($i, 3, $sheet=0);
					$komponen3 = $data->val($i, 4, $sheet=0);
					$material = $data->val($i, 6, $sheet=0);
					$comp_waste = $data->val($i, 7, $sheet=0);
					$harga_cek = $this->app_model->harga_upholstery($material);
					$harga = $harga_cek[1];
					$currency = $harga_cek[0];
					
					
					
					$textfam = "Select family from barang where kode_barang='$material'";
					$fam_cek = $this->app_model->manualQuery($textfam);
					$fam_h = $fam_cek->row();
					
					$family = $fam_h->family;
					
					$length = $data->val($i, 8, $sheet=0);
					$width = $data->val($i, 9, $sheet=0);
					
					$volume = $data->val($i, 10, $sheet=0);
					
					$quantity = $data->val($i, 11, $sheet=0);
					
					$datacot = $this->app_model->cotation_upholstery($material,$length,$width,$volume,$quantity,$comp_waste);
					
					$q = "SELECT COUNT(*) AS tcek FROM cotation_upholstery WHERE id_cotation='$vid_cotation' and komponen1='$komponen1' and komponen2='$komponen2' and komponen3='$komponen3' and material_family='$family' and material='$material'";
					$q_cek = $this->app_model->manualQuery($q);
					$h_cek = $q_cek->row();
					
					if($h_cek->tcek == 0 && $komponen1!='' && $datacot['kode_barang']!=''){
						$seq_sql = "SELECT MAX(seq)+1 as seq FROM cotation_upholstery where id_cotation='$vid_cotation'";
						$seq_cek = $this->app_model->manualQuery($seq_sql);
						$seq_h = $seq_cek->row();
						
						if (empty($seq_h->seq)){
							$seq=1;
						}else{
							$seq=$seq_h->seq;
						}
						
						$query = "INSERT INTO cotation_upholstery (id_cotation,seq,komponen1,komponen2,komponen3,material_family,material,length,width,height,volume,quantity,average_waste,special_waste,consumption,harga_mat,sqf25,sqf28,sqf3048,run_m140,run_m150,run_m160,kilo,consumption_m,createdby,createdtime,editedby,editedtime,companyarea) VALUES ('$vid_cotation', '".$seq."', '$komponen1','$komponen2','$komponen3','$family', '$material', '$length', '$width', '".$datacot['height']."','$volume','$quantity','".$datacot['average_waste']."','$comp_waste','".$datacot['consum']."','$harga','".$datacot['sqf_25']."','".$datacot['sqf_28']."','".$datacot['sqf_3048']."','".$datacot['run_m140']."','".$datacot['run_m150']."','".$datacot['run_m160']."','".$datacot['kilo']."','".$datacot['consum_m']."','$user','$tgl','$user','$tgl','$loc')";
						$hasil = $this->app_model->manualQuery($query);
						$sukses++;
						$couth="sukses";
					} else {
						$gagal++;
						$couth="sudah ada";
					}
					
					$d['text'][$arr] = "$kode_supplier - $nama_supplier $couth";
					$arr++;
				}
				
				$d['sukses'] = $sukses;
				$d['gagal'] = $gagal;
			}
			
			//$d['content'] = $this->load->view('cotation/detail', $d, true);	
			//$this->load->view('home',$d);
			redirect('cotation/detail/'.$vid_cotation.'/'.$this_product_code.'/-/0');
		}else{	
			header('location:'.base_url());
		}
	}
	
	*/
	
	public function import_upholstery(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){
			$status = "";
			$msg = "";
			$file_element_name = 'userfile';
			
			$config['upload_path'] = './asset/temp_upload/';
			$config['allowed_types'] = '*';
			$config['max_size'] = 1024 * 12;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = ''.$this->input->post('userfile');
			
			$this->load->library('upload', $config);
			
			if ($this->upload->do_upload('fileexcel')){
				$dataup=$this->upload->data();
				$status = "success";
				//$msg = "File successfully uploaded";
			} else{
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			}
			
			if ($status != 'error'){
				
				require(APPPATH.'plugins/excelreader/excel_reader2.php');
				$this->load->model('app_model');
				error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
				
				$d['prg']= $this->config->item('prg');
				$d['web_prg']= $this->config->item('web_prg');
				$cot_id = $this->input->post('id_cotation');
				$d['nama_program']= $this->config->item('nama_program');
				$d['instansi']= $this->config->item('instansi');
				$d['usaha']= $this->config->item('usaha');
				$d['alamat_instansi']= $this->config->item('alamat_instansi');

				$d['judul']="Data Upholstery";
				
				$file =  $config['upload_path'].$dataup['file_name'];
				
				$data = new Spreadsheet_Excel_Reader($file);
				$hasildata = $data->rowcount($sheet_index=0);
				// default nilai 
				$sukses = 0;
				$gagal = 0;
				$arr = 0;
				$this_product_code='';
				$d['text'] = array();
				
				for ($i=4; $i<=$hasildata; $i++){
					$vkode_product = $data->val($i, 1, $sheet=0);
					$textcot = "SELECT id_cotation from h_cotation where product_code='$vkode_product'";
					$cot_cek = $this->app_model->manualQuery($textcot);
					$cot_h = $cot_cek->row();
					
					if (!empty($cot_h->id_cotation) && $cot_id == $cot_h->id_cotation){
						
						if(empty($this_product_code)){
							$this_product_code=$vkode_product;
						}
						$vid_cotation = $cot_h->id_cotation;
						$komponen1 = $data->val($i, 2, $sheet=0);
						$komponen2 = $data->val($i, 3, $sheet=0);
						$komponen3 = $data->val($i, 4, $sheet=0);
						$material = $data->val($i, 6, $sheet=0);
						$comp_waste = $data->val($i, 7, $sheet=0);
						$harga_cek = $this->app_model->harga_upholstery($material);
						$harga = $harga_cek[1];
						$currency = $harga_cek[0];
						
						
						
						$textfam = "Select family from barang where kode_barang='$material'";
						$fam_cek = $this->app_model->manualQuery($textfam);
						$fam_h = $fam_cek->row();
						
						$family = $fam_h->family;
						
						$length = $data->val($i, 8, $sheet=0);
						$width = $data->val($i, 9, $sheet=0);
						
						$volume = $data->val($i, 10, $sheet=0);
						
						$quantity = $data->val($i, 11, $sheet=0);
						
						$datacot = $this->app_model->cotation_upholstery($material,$length,$width,$volume,$quantity,$comp_waste);
						
						if ($width=='' && $datacot['width']!=''){
							$width = $datacot['width'];
						}
						
						$q = "SELECT COUNT(*) AS tcek FROM cotation_upholstery WHERE id_cotation='$vid_cotation' and komponen1='$komponen1' and komponen2='$komponen2' and komponen3='$komponen3' and material_family='$family' and material='$material'";
						$q_cek = $this->app_model->manualQuery($q);
						$h_cek = $q_cek->row();
						
						if($h_cek->tcek == 0 && $komponen1!='' && $datacot['kode_barang']!=''){
							$seq_sql = "SELECT MAX(seq)+1 as seq FROM cotation_upholstery where id_cotation='$vid_cotation'";
							$seq_cek = $this->app_model->manualQuery($seq_sql);
							$seq_h = $seq_cek->row();
							
							if (empty($seq_h->seq)){
								$seq=1;
							}else{
								$seq=$seq_h->seq;
							}
							
							$query = "INSERT INTO cotation_upholstery (id_cotation,seq,komponen1,komponen2,komponen3,material_family,material,length,width,height,volume,quantity,average_waste,special_waste,consumption,harga_mat,sqf25,sqf28,sqf3048,run_m140,run_m150,run_m160,kilo,consumption_m,createdby,createdtime,editedby,editedtime,companyarea) VALUES ('$vid_cotation', '".$seq."', '$komponen1','$komponen2','$komponen3','$family', '$material', '$length', '$width', '".$datacot['height']."','$volume','$quantity','".$datacot['average_waste']."','$comp_waste','".$datacot['consum']."','$harga','".$datacot['sqf_25']."','".$datacot['sqf_28']."','".$datacot['sqf_3048']."','".$datacot['run_m140']."','".$datacot['run_m150']."','".$datacot['run_m160']."','".$datacot['kilo']."','".$datacot['consum_m']."','$user','$tgl','$user','$tgl','$loc')";
							$hasil = $this->app_model->manualQuery($query);
							$sukses++;
							$couth="sukses";
						} else {
							$gagal++;
							$couth="sudah ada";
						}
						
						$d['text'][$arr] = "$kode_supplier - $nama_supplier $couth";
						$arr++;
					}
					
					$d['sukses'] = $sukses;
					$d['gagal'] = $gagal;
				}
				
				unlink($dataup['full_path']);
			}
			
			echo json_encode(array('status' => $status, 'msg' => $msg));
		}else{	
			header('location:'.base_url());
		}
	}
	
	public function import_accessories(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){
			
			$status = "";
			$msg = "";
			$file_element_name = 'userfile';
			
			$config['upload_path'] = './asset/temp_upload/';
			$config['allowed_types'] = '*';
			$config['max_size'] = 1024 * 12;
			$config['encrypt_name'] = TRUE;
			$config['file_name'] = ''.$this->input->post('userfile');
			
			$this->load->library('upload', $config);
			/*
			if (!$this->upload->do_upload($file_element_name))
			{
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			}
			else
			{
				$dataup = $this->upload->data();
				$status = "success";
				//$msg = "File successfully uploaded";
			}
			*/
			if ($this->upload->do_upload('fileexcel')){
				$dataup=$this->upload->data();
				$status = "success";
				//$msg = "File successfully uploaded";
			} else{
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			}
			
			if ($status != 'error'){
				require(APPPATH.'plugins/excelreader/excel_reader2.php');
				$this->load->model('app_model');
				error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
				
				$d['prg']= $this->config->item('prg');
				$d['web_prg']= $this->config->item('web_prg');
				$cot_id = $this->input->post('id_cotation');
				$d['nama_program']= $this->config->item('nama_program');
				$d['instansi']= $this->config->item('instansi');
				$d['usaha']= $this->config->item('usaha');
				$d['alamat_instansi']= $this->config->item('alamat_instansi');

				$d['judul']="Data Accessories";
				
				$file = $config['upload_path'].$dataup['file_name'];
				
				$data = new Spreadsheet_Excel_Reader($file);
				$hasildata = $data->rowcount($sheet_index=0);
				// default nilai 
				$sukses = 0;
				$gagal = 0;
				$arr = 0;
				$this_product_code='';
				$d['text'] = array();
				
				for ($i=4; $i<=$hasildata; $i++){
					
					$vkode_product = $data->val($i, 1, $sheet=0);
					$textcot = "SELECT id_cotation from h_cotation where product_code='$vkode_product'";
					$cot_cek = $this->app_model->manualQuery($textcot);
					$cot_h = $cot_cek->row();
					if (!empty($cot_h->id_cotation) && $cot_id == $cot_h->id_cotation){
						
						if(empty($this_product_code)){
							$this_product_code=$vkode_product;
						}
						$vid_cotation = $cot_h->id_cotation;
						$useby = $data->val($i, 2, $sheet=0);
						$material = $data->val($i, 4, $sheet=0);
						//$harga_cek = $this->app_model->harga_upholstery($material);
						//$harga = $harga_cek[1];
						//$currency = $harga_cek[0];
						
						
						
						//$textfam = "Select family from barang where kode_barang='$material'";
						//$fam_cek = $this->app_model->manualQuery($textfam);
						//$fam_h = $fam_cek->row();
						
						//$family = $fam_h->family;
						
						//$length = $data->val($i, 8, $sheet=0);
						//$width = $data->val($i, 9, $sheet=0);
						
						//$volume = $data->val($i, 10, $sheet=0);
						
						$quantity = $data->val($i, 5, $sheet=0);
						
						//$datacot = $this->app_model->cotation_upholstery($material,$length,$width,$volume,$quantity,$comp_waste);
						
						$q = "SELECT COUNT(*) AS tcek FROM cotation_accessories WHERE id_cotation='$vid_cotation' and material='$material' and companyarea='$loc'";
						$q_cek = $this->app_model->manualQuery($q);
						$h_cek = $q_cek->row();
						
						if($h_cek->tcek == 0 && $useby!=''){
							$seq_sql = "SELECT MAX(seq)+1 as seq FROM cotation_accessories where id_cotation='$vid_cotation' and companyarea='$loc'";
							$seq_cek = $this->app_model->manualQuery($seq_sql);
							$seq_h = $seq_cek->row();
							
							if (empty($seq_h->seq)){
								$seq=1;
							} else{
								$seq=$seq_h->seq;
							}
							
							$query = "INSERT INTO cotation_accessories (id_cotation,seq,acc_hard,material,quantity,createdby,createdtime,editedby,editedtime,companyarea) VALUES ('$vid_cotation', '".$seq."', '$useby','$material', '$quantity','$user','$tgl','$user','$tgl','$loc')";
							$hasil = $this->app_model->manualQuery($query);
							$sukses++;
							$couth="sukses";
						} else {
							$gagal++;
							$couth="sudah ada";
						}
						
						$d['text'][$arr] = "$kode_supplier - $nama_supplier $couth";
						$arr++;
					}
					
					//$d['sukses'] = $sukses;
					//$d['gagal'] = $gagal;
				} 
				if ($sukses>0){
					$status = "success";
					$msg = "File successfully uploaded";
				}else{
					$status = "failed";
					$msg = "File not successful upload";
				}
				unlink($dataup['full_path']);
			} 
			
			
			//$d['content'] = $this->load->view('cotation/detail', $d, true);	
			//$this->load->view('home',$d);
			//redirect('cotation/detail/'.$vid_cotation.'/'.$this_product_code.'/-/0');
			echo json_encode(array('status' => $status, 'msg' => $msg));
		}else{	
			header('location:'.base_url());
		}
	}
	
	public function print_accessories(){
		//ini_set("mbstring.internal_encoding","UTF-8");
		//ini_set("mbstring.func_overload",7);
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$kode_barang_ass = $this->uri->segment(4);
			$kode_barang_fit = $this->uri->segment(5);
			$kode_barang_assfit = $this->uri->segment(6);
			
			if (!empty($kode_barang_ass)){
				$kode_barang_ass = str_replace("-","','",$kode_barang_ass);
				$kode_barang_ass = substr($kode_barang_ass,0,-3);
			}
			if (!empty($kode_barang_fit)){
				$kode_barang_fit = str_replace("-","','",$kode_barang_fit);
				$kode_barang_fit = substr($kode_barang_fit,0,-3);
			}
			if (!empty($kode_barang_assfit)){
				$kode_barang_assfit = str_replace("-","','",$kode_barang_assfit);
				$kode_barang_assfit = substr($kode_barang_assfit,0,-3);
			}
			
			$d['page_title'] = "Accessories Card";
			$text = "SELECT A.product_code, A.collection,A.name,A.finishing,B.product_photo,A.finishing
					FROM h_cotation A
					LEFT OUTER JOIN product B ON B.product_code=A.product_code
					WHERE A.id_cotation='$id' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['product_code']	= $db->product_code;
					$d['product_name']	= $db->name;
					$d['product_photo']	= $db->product_photo;
					$d['coll_name']			= $db->collection;
					$d['finishing']			= $db->finishing;
				}
			} else {
				$d['product_code']	= '';
				$d['product_name']	= '';
				$d['product_photo']	= '';
				$d['coll_name']			= '';
				$d['finishing']			= '';
			}
			
			$text = "SELECT A.material, B.nama_barang, B.kode_barang_spc,  A.quantity, B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread,'1' as ck, D.finishing, C.unit_name
					FROM cotation_accessories A
					JOIN barang B ON B.kode_barang=A.material and B.companyarea=A.companyarea
					LEFT OUTER JOIN unit C on C.unit_code=B.useper
					LEFT OUTER JOIN finishing D ON D.finishing_id=B.finishing
					WHERE A.id_cotation='$id' and A.acc_hard='Assembling+Fitting' and A.companyarea='$loc' and B.departemen='ACCHRD' and A.material IN ('$kode_barang_assfit')
					ORDER BY B.nama_barang";
			$d['data_assfit']= $this->app_model->manualQuery($text);
			
			$text = "SELECT A.material, B.nama_barang, B.kode_barang_spc,  A.quantity, B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread,'1' as ck, D.finishing, C.unit_name
					FROM cotation_accessories A
					JOIN barang B ON B.kode_barang=A.material and B.companyarea=A.companyarea
					LEFT OUTER JOIN unit C on C.unit_code=B.useper
					LEFT OUTER JOIN finishing D ON D.finishing_id=B.finishing
					WHERE A.id_cotation='$id' and A.acc_hard='Fitting' and A.companyarea='$loc' and B.departemen='ACCHRD' and A.material IN ('$kode_barang_fit')
					ORDER BY B.nama_barang";
			$d['data_fit']= $this->app_model->manualQuery($text);
			
			$text = "SELECT A.material, B.nama_barang, B.kode_barang_spc,  A.quantity, B.size_length, B.size_width, B.size_height, B.size_diameter, B.size_diameterin, B.size_thread,'1' as ck, D.finishing, C.unit_name
					FROM cotation_accessories A
					JOIN barang B ON B.kode_barang=A.material and B.companyarea=A.companyarea
					LEFT OUTER JOIN unit C on C.unit_code=B.useper
					LEFT OUTER JOIN finishing D ON D.finishing_id=B.finishing
					WHERE A.id_cotation='$id' and A.acc_hard='Assembling' and A.companyarea='$loc' and B.departemen='ACCHRD' and A.material IN ('$kode_barang_ass')
					ORDER BY B.nama_barang";
			$d['data_ass']= $this->app_model->manualQuery($text);
			
			$this->load->view('cotation/print_accessories',$d);
		}else{	
			header('location:'.base_url());
		}
	}
	
	
	
	## *** Cotation Packing *** ##
	
	public function simpan_packing(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		$tgl_id = date("Ym");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					$text = "SELECT MAX(seq) as Seq from cotation_packing where id_cotation='".$this->input->post('id_cotation_'.$i)."' and companyarea='$loc'";
					$tabel = $this->app_model->manualQuery($text);
					
					$row = $tabel->num_rows();
					if($row>0){
						$vSeq = 0;
						foreach($tabel->result() as $t){
							$vSeq = $t->Seq;
						}
						$Seq = $vSeq + 1;
					}else{
						$Seq = 1;
					}
				}else{
					$Seq = $this->input->post('seq_'.$i);
				}
				
				$up['id_cotation'] = $this->input->post('id_cotation_'.$i);
				$up['seq'] 				 = $Seq;
				$up['boxnumber'] 	 = $this->input->post('boxnumber_'.$i);
				$up['customer'] 	 = $this->input->post('customer_'.$i);
				$up['lshape'] 	 = $this->input->post('lshape_'.$i);
				$up['lsize'] 			 = $this->input->post('lsize_'.$i);
				$up['wsize'] 			 = $this->input->post('wsize_'.$i);
				$up['hsize']			 = $this->input->post('hsize_'.$i);
				$up['asize']			 = $this->input->post('asize_'.$i);
				$up['bsize']			 = $this->input->post('bsize_'.$i);
				$up['kdown'] 			 = $this->input->post('kdown_'.$i);
				$up['typebox'] 		 = $this->input->post('typebox_'.$i);
				$up['lstyrofoam']  = $this->input->post('lstyrofoam_'.$i);
				$up['wstyrofoam']  = $this->input->post('wstyrofoam_'.$i);
				$up['hstyrofoam']  = $this->input->post('hstyrofoam_'.$i);
				$up['linner'] 		 = $this->input->post('linner_'.$i);
				$up['winner'] 		 = $this->input->post('winner_'.$i);
				$up['hinner'] 		 = $this->input->post('hinner_'.$i);
				$up['lkarton']		 = $this->input->post('lkarton_'.$i);
				$up['wkarton'] 		 = $this->input->post('wkarton_'.$i);
				$up['hkarton'] 		 = $this->input->post('hkarton_'.$i);
				$up['louter'] 		 = $this->input->post('louter_'.$i);
				$up['wouter'] 		 = $this->input->post('wouter_'.$i);
				$up['houter'] 		 = $this->input->post('houter_'.$i);
				$up['volouter'] 	 = $this->input->post('volouter_'.$i);
				$up['weight'] 	 = $this->input->post('boxweight_'.$i);
				$up['qtybox'] 		 = $this->input->post('qtybox_'.$i);
				if ($this->input->post('qtyperbox_'.$i)==0 || $this->input->post('qtyperbox_'.$i)==''){
					$up['qtyperbox'] 		 = 1;
				} else {
					$up['qtyperbox'] 		 = $this->input->post('qtyperbox_'.$i);
				}
				$up['remarks_packing']		 = $this->input->post('packingremarks_'.$i);
				$up['remarks']		 = $this->input->post('boxremarks_'.$i);
				$up['editedby']		 = $user;
				$up['editedtime']  = $tgl;
				
				$text = "SELECT id_cotation FROM cotation_packing WHERE id_cotation='".$this->input->post('id_cotation_'.$i)."' AND companyarea='$loc' AND boxnumber='".$this->input->post('boxnumber_'.$i)."' AND kdown='".$this->input->post('kdown_'.$i)."' AND typebox='".$this->input->post('typebox_'.$i)."' AND customer='".$this->input->post('customer_'.$i)."' AND seq!='$Seq'";
				$tabel = $this->app_model->manualQuery($text);
				$row = $tabel->num_rows();
				if ($row>0){
				} else {
					$id['id_cotation'] = $this->input->post('id_cotation_'.$i);
					$id['seq']				 = $Seq;
					$id['companyarea'] = $loc;
					
					$data = $this->app_model->getSelectedData("cotation_packing",$id);
						
					if($data->num_rows()>0){
						$this->app_model->updateData("cotation_packing",$up,$id);
						echo 'Update Successful!';
					}else{
						$up['createdby']		= $user;
						$up['createdtime']	= $tgl;
						$up['companyarea']	= $loc;
						$this->app_model->insertData("cotation_packing",$up);
						echo 'Save Successful!';		
					}
				}
			}
		} else {
			header('location:'.base_url());
		}
	}
	
	public function DataPacking(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$dataFooter = array();
			//$datatemp = array();
			$id = $this->uri->segment(3);
			$text = "SELECT A.*,B.cust_name FROM cotation_packing A LEFT OUTER JOIN customer B ON B.cust_code=A.customer WHERE A.id_cotation='$id' and A.companyarea='$loc'";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			$data = array();
			//$tempbox="";
			//$temptypebox="";
			
			if($row>0){
				$tmpStr="";
				
				foreach($tabel->result() as $t){
					$data[$temp]['id_cotation'] 	= $t->id_cotation;
					$data[$temp]['seq'] 					= $t->seq;
					$data[$temp]['boxnumber'] 		= $t->boxnumber;
					
					if (empty($t->customer)){
						$data[$temp]['customer'] = 'All';
						if (strpos($tmpStr,'All')===false){
							//if ($tmpStr==""){
								$tmpStr .= 'All,';
							//}else{
							//	$tmpStr .= ',All';
							//}
							
						}
					}else{
						$data[$temp]['customer'] = $t->cust_name;
						if (strpos($tmpStr,$t->cust_name)===false){
							//if ($tmpStr==""){
							//	$tmpStr .= $t->cust_name;
							//}else{
								$tmpStr .= $t->cust_name.',';
							//}
							
						}
					}
					
					//$data[$temp]['customer'] 				= $t->customer;
					$data[$temp]['lshape'] 				= $t->lshape;
					$data[$temp]['lsize'] 				= $t->lsize;
					$data[$temp]['wsize'] 				= $t->wsize;
					$data[$temp]['hsize'] 				= $t->hsize;
					$data[$temp]['hsize'] 				= $t->hsize;
					$data[$temp]['asize'] 				= $t->asize;
					$data[$temp]['bsize'] 				= $t->bsize;
					$data[$temp]['kdown'] 				= $t->kdown;
					$data[$temp]['typebox'] 			= $t->typebox;
					$data[$temp]['lstyrofoam'] 		= $t->lstyrofoam;
					$data[$temp]['wstyrofoam'] 		= $t->wstyrofoam;
					$data[$temp]['hstyrofoam'] 		= $t->hstyrofoam;
					$data[$temp]['linner'] 				= $t->linner;
					$data[$temp]['winner'] 				= $t->winner;
					$data[$temp]['hinner'] 				= $t->hinner;
					$data[$temp]['lkarton'] 			= $t->lkarton;
					$data[$temp]['wkarton'] 			= $t->wkarton;
					$data[$temp]['hkarton'] 			= $t->hkarton;
					$data[$temp]['louter'] 				= $t->louter;
					$data[$temp]['wouter'] 				= $t->wouter;
					$data[$temp]['houter'] 				= $t->houter;
					$data[$temp]['volouter'] 			= $t->volouter;
					$data[$temp]['boxweight'] 			= $t->weight;
					$data[$temp]['qtybox'] 				= $t->qtybox;
					$data[$temp]['qtyperbox'] 				= $t->qtyperbox;
					$data[$temp]['packingremarks'] 			= $t->remarks_packing;
					$data[$temp]['boxremarks'] 			= $t->remarks;
					$temp++;
				}
				
				if ($row >= 2){
					$tmpCust = explode(",",$tmpStr);
					//if (sizeof($tmpCust))
					
					$counterFt=0;
					foreach($tmpCust as $cust){
						//$fp=fopen("datapacking.txt","a");
						//fwrite($fp,$cust.'
						//');
						$counter=0;
						$totalVol=0;
						//$test=1;
						if (!empty($cust)){
							foreach ($data as $key => $dt){
								//$fp=fopen("datapacking.txt","w");
								//fwrite($fp,$test);
								
								if ($cust==$dt['customer']){
									$totalVol = $totalVol + ($dt['volouter']*$dt['qtybox']);
									$counter++;
								}
								//$test++;
							}
							//$fp=fopen("datapacking.txt","a");
							//fwrite($fp,'Disini : '.$cust.'
							//'.$counter.'
							//'.$counterFt);
							if($counter>=2){
								
								$dataFooter[$counterFt]['volouter'] = $totalVol;
								$dataFooter[$counterFt]['lsize'] = '';
								$dataFooter[$counterFt]['wsize'] = '';
								$dataFooter[$counterFt]['hsize'] = '';
								$dataFooter[$counterFt]['lstyrofoam'] = '';
								$dataFooter[$counterFt]['wstyrofoam'] = '';
								$dataFooter[$counterFt]['hstyrofoam'] = '';
								$dataFooter[$counterFt]['linner'] = '';
								$dataFooter[$counterFt]['winner'] = '';
								$dataFooter[$counterFt]['hinner'] = '';
								$dataFooter[$counterFt]['asize'] = '';
								$dataFooter[$counterFt]['bsize'] = '';
								$dataFooter[$counterFt]['lkarton'] = '';
								$dataFooter[$counterFt]['wkarton'] = '';
								$dataFooter[$counterFt]['hkarton'] = '';
								$dataFooter[$counterFt]['louter'] = '';
								$dataFooter[$counterFt]['wouter'] = '';
								$dataFooter[$counterFt]['houter'] = '';
								$dataFooter[$counterFt]['boxremarks'] = '<- : Total Volume '.$cust;
								$counterFt++;
							}
						}
					}
				}
				// foreach($data{$temp}){}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($data).',"footer":'.json_encode($dataFooter).'}';
			
		} else {
			header('location:'.base_url());
		}
	}
	
	public function Calculation_Component(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$dataFooter = array();
			$id = isset($_REQUEST['id_cotation']) ? $_REQUEST['id_cotation'] : '';
			$seq = isset($_REQUEST['pesan']) ? $_REQUEST['pesan'] : '';
			
			$seq = str_replace("-","','",$seq);
			$seq = substr($seq,0,-3);
			
			$text = "SELECT A.id_cotation,A.seq, A.komponen1, A.komponen2, A.komponen3,A.material_family, C.family,A.material,  D.nama_barang, A.length, A.width, A.height,A.volume,A.inpieces, A.average_waste, A.special_waste,A.quantity,E.`type` as tipe,F.unit_name,A.consumption,A.consumption_m,A.sqf25,A.sqf28,A.sqf3048,A.run_m140,A.run_m150,A.run_m160,A.run_mm47,A.run_mm50,A.run_mm57,A.kilo,A.pieces,A.harga_mat,G.simbol as unit_ukuran,A.h_comp_waste,D.ppn
					FROM cotation_upholstery A
					JOIN h_cotation B ON B.id_cotation=A.id_cotation and B.companyarea=A.companyarea
					LEFT OUTER JOIN family C ON C.family_id=A.material_family
					JOIN barang D ON D.kode_barang=A.material AND D.companyarea=A.companyarea
					LEFT OUTER JOIN `type` E ON E.type_id=D.`type`
					LEFT OUTER JOIN `unit` F ON F.unit_code=D.satuan
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=D.size_length_unit
					WHERE A.id_cotation='$id' and A.companyarea='$loc' AND A.seq IN ('$seq')
					ORDER BY C.family,D.nama_barang";
			$tabel= $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			
			$temp=0;
			if($row>0){
				$tempStr	= '';
				
				foreach($tabel->result() as $t){
					if (strpos($tempStr,$t->nama_barang)!==false){
					} else {
						$dataFooter[$temp]['kode_barang'] = $t->nama_barang;
						$dataFooter[$temp]['family'] = $t->family;
						$dataFooter[$temp]['ppn'] = $t->ppn;
						$tempStr .= ' '.$t->nama_barang;
						$textSum = "SELECT SUM(A.consumption_m) as consumption_m,SUM(A.consumption) as consumption,SUM(A.sqf25) as sqf25,SUM(A.sqf28) as sqf28,SUM(A.sqf3048) as sqf3048,SUM(A.run_m140) as run_m140,SUM(A.run_m150) as run_m150,SUM(A.run_m160) as run_m160,SUM(A.run_mm47) as run_mm47,SUM(A.run_mm50) as run_mm50,SUM(A.run_mm57) as run_mm57,SUM(A.kilo) as kilo,SUM(A.inpieces) as pieces,AVG(A.harga_mat) as harga, SUM(A.quantity) AS pcs, A.currency
												FROM cotation_upholstery A WHERE id_cotation='".$t->id_cotation."' and material='".$t->material."' AND A.seq IN ('$seq')";
						$tabelSum= $this->app_model->manualQuery($textSum);
						foreach($tabelSum->result() as $sum){
							$dataFooter[$temp]['consumption_m'] 	= round($sum->consumption_m,6);
							$dataFooter[$temp]['sqf25'] 					= Ceil($sum->sqf25);
							$dataFooter[$temp]['sqf28'] 					= Ceil($sum->sqf28);
							$dataFooter[$temp]['sqf3048'] 				= Ceil($sum->sqf3048);
							$dataFooter[$temp]['runningmeter140'] 	= round($sum->run_m140,6);
							$dataFooter[$temp]['runningmeter150'] 	= round($sum->run_m150,6);
							$dataFooter[$temp]['runningmeter160'] 	= round($sum->run_m160,6);
							$dataFooter[$temp]['runningmeter047'] 	= Ceil($sum->run_mm47);
							$dataFooter[$temp]['runningmeter050'] 	= Ceil($sum->run_mm50);
							$dataFooter[$temp]['runningmeter057'] 	= Ceil($sum->run_mm57);
							$dataFooter[$temp]['kilo'] 							= round($sum->kilo,6);
							$dataFooter[$temp]['pieces'] 						= Ceil($sum->pieces);
							$dataFooter[$temp]['brg_harga'] 				= $sum->harga;
							$dataFooter[$temp]['currency'] 					= $sum->currency;
							if (($sum->consumption_m + $sum->sqf25 + $sum->sqf28 + $sum->sqf3048 + $sum->run_m140 + $sum->run_m150 + $sum->run_m160 + $sum->run_mm47 + $sum->run_mm50 + $sum->run_mm57 + $sum->kilo + $sum->pieces)==0){
								$cons_m2 = round($sum->consumption/1000000,6);
							} else {
								$cons_m2 = 0;
							}
							$dataFooter[$temp]['consumption_m2'] 	= $cons_m2;
							if (($t->family=='Zipper' && $t->nama_barang!='Zipper') || $t->family=='Connector'){
								if ($cons_m2==0 && $sum->consumption_m==0){
									$dataFooter[$temp]['pieces'] = $sum->pcs;
								}
							}
							//if ($sum->currency=='Rp')
								$dataFooter[$temp]['cost'] 	= number_format(round($cons_m2 + round($sum->consumption_m,6) + Ceil($sum->sqf25) + Ceil($sum->sqf28) + Ceil($sum->sqf3048) + round($sum->run_m140,6) + round($sum->run_m150,6) + round($sum->run_m160,6) + round($sum->run_mm47,6) + round($sum->run_mm50,6) + round($sum->run_mm57,6) + round($sum->kilo,6) + ceil($dataFooter[$temp]['pieces']),6) * $sum->harga,0,'.',',');
							//else
							//	$dataFooter[$tempFooter]['cost'] 	= number_format(Ceil($cons_m2 + $sum->consumption_m + $sum->sqf25 + $sum->sqf28 + $sum->sqf3048 + $sum->run_m140 + $sum->run_m150 + $sum->run_m160 + $sum->run_mm47 + $sum->run_mm50 + $sum->run_mm57 + $sum->kilo + $sum->pieces) * $sum->harga,0,'.',',');
							//array_push($this->dataFooterGlobal,$dataFooter[$tempFooter]['sqf25'],$dataFooter[$tempFooter]['sqf28'],$dataFooter[$tempFooter]['sqf3048'],$dataFooter[$tempFooter]['runningmeter140'],$dataFooter[$tempFooter]['runningmeter150'],$dataFooter[$tempFooter]['runningmeter160'],$dataFooter[$tempFooter]['runningmeter047'],$dataFooter[$tempFooter]['runningmeter050'],$dataFooter[$tempFooter]['runningmeter057'],$dataFooter[$tempFooter]['kilo'],$dataFooter[$tempFooter]['pieces']);
						}
						$temp++;
					}
				}
			}
			echo '{"total":'.$row.',"rows":'.json_encode($dataFooter).'}';
		} else {
			header('location:'.base_url());
		}
	}
	
}

/* End of file cotation.php */
/* Location: ./application/controllers/cotation.php */