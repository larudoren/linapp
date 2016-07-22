<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {
	
	var $kodebarang;
	var $namabarang;
	/*
	public function __construct() {
        parent::__construct();
        $this->kodebarang = '';
    } */
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			$code_cari = $this->input->post('code_cari');
			//$d['code_cari'] = $code_cari;
			$unit_cari = $this->input->post('unit_cari');
			//$d['unit_cari'] = $unit_cari;
			$type_cari = $this->input->post('type_cari');
			//$d['type_cari'] = $type_cari;
			$finish_cari = $this->input->post('finish_cari');
			//$d['finish_cari'] = $finish_cari;
			$name_cari = $this->input->post('name_cari');
			//$d['name_cari'] = $name_cari;
			$dept_cari = $this->input->post('dept_cari');
			//$d['dept_cari'] = $dept_cari;
			$loc  = $this->session->userdata('companyarea');
			$this->kodebarang ='';
			$this->session->set_userdata('kodebarang',$this->kodebarang);
			
		
			if (!empty($code_cari)){
				$sess_data['barang_code_cari'] = $this->input->post('code_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if (!empty($unit_cari)){
				$sess_data['barang_unit_cari'] = $this->input->post('unit_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if (!empty($type_cari)){
				$sess_data['barang_type_cari'] = $this->input->post('type_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if (!empty($finish_cari)){
				$sess_data['barang_finish_cari'] = $this->input->post('finish_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if(!empty($name_cari)) {
				$sess_data['barang_name_cari'] = $this->input->post('name_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if (!empty($dept_cari)){
				$sess_data['barang_dept_cari'] = $this->input->post('dept_cari');
				$this->session->set_userdata($sess_data);
			} 
			
			//$this->session->set_userdata($sess_data);
			
			$code_cari = $this->session->userdata('barang_code_cari');
			$unit_cari = $this->session->userdata('barang_unit_cari');
			$type_cari = $this->session->userdata('barang_type_cari');
			$finish_cari = $this->session->userdata('barang_finish_cari');
			$name_cari = $this->session->userdata('barang_name_cari');
			$dept_cari = $this->session->userdata('barang_dept_cari');
			
			if (empty($type_cari)){
				$where_type = "";
			} else {
				$where_type = " AND D.type LIKE '%$type_cari%' ";
			}
			
			if (empty($finish_cari)){
				$where_finish = "";
			} else {
				$where_finish = " AND E.finishing LIKE '%$finish_cari%' ";
			}
			
			$where = "WHERE A.companyarea='$loc' and A.kode_barang_spc LIKE '%$code_cari%' and A.nama_barang LIKE '%$name_cari%' and C.dept_name LIKE '%$dept_cari%' AND B.unit_name LIKE '%$unit_cari%' $where_type $where_finish ";
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Data Material";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.kode_barang, A.kode_lama, A.foto_barang, A.nama_barang, B.unit_name, C.dept_name, D.type, E.finishing
						FROM barang A
						LEFT OUTER JOIN unit B ON B.unit_code=A.satuan
						LEFT OUTER JOIN departemen_fact C ON C.dept_code=A.departemen and C.companyarea=A.companyarea
						LEFT OUTER JOIN `type` D ON D.type_id=A.type
						LEFT OUTER JOIN finishing E ON E.finishing_id=A.finishing
						$where";		
			$tot_hal = $this->app_model->manualQuery($text);		
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/barang/index/';
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
			

			$text = "SELECT A.kode_barang, A.kode_lama, A.foto_barang, A.nama_barang, B.unit_name, C.dept_name,A.pos_rack,A.pos_row,A.pos_column,A.kode_barang_spc, D.type, E.finishing
						FROM barang A
						LEFT OUTER JOIN unit B ON B.unit_code=A.satuan
						LEFT OUTER JOIN departemen_fact C ON C.dept_code=A.departemen and C.companyarea=A.companyarea
						LEFT OUTER JOIN `type` D ON D.type_id=A.type
						LEFT OUTER JOIN finishing E ON E.finishing_id=A.finishing
						$where
						ORDER BY A.kode_barang 
						LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			$d['content'] = $this->load->view('barang/view', $d, true);		
			
			if (($tot_hal->num_rows() - $offset) < 15){
				$d['mymenu'] = 'Research';
			}
			
			$this->output->set_header("HTTP/1.0 200 OK");
			$this->output->set_header("HTTP/1.1 200 OK");
			$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
			$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
			
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
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Input Material";
			
			$d['kode_brg']			= '';
			$d['kode_brg_spc']		= '';
			$d['nama_brg']			= '';
			$d['nama_brg_en']		= '';
			$d['foto_brg']			= '';
			$d['category']			= '';
			$d['family']			= '';
			$d['merek']				= '';
			$d['type']				= '';
			$d['detail']			= '';
			$d['satuan']			= '';
			$d['useper']			= '';
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
			$d['min_qty']		= '';
			$d['turunan']		= '';
			$d['nama_turunan']		= '';
			$d['ppn']		= '';
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$text = "SELECT dept_code,dept_name FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_satuan'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_useper'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT family_id,family FROM family";
			$d['l_fam'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT category_id,category FROM category";
			$d['l_category'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT type_id,`type` FROM type";
			$d['l_type'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT merk_id,merk FROM merk";
			$d['l_merk'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_ukuran_id,`type`,unit_ukuran,simbol,ss_symbol FROM t_unit_ukuran";
			$d['l_ukuran'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT material_id,material FROM material";
			$d['l_material'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT finishing_id,finishing FROM finishing";
			$d['l_finishing'] = $this->app_model->manualQuery($text);
			$d['content'] = $this->load->view('barang/form', $d, true);		
			
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
			
			$d['judul'] = "Edit Material";
			
			$id = $this->uri->segment(3); 
			$d['hal'] = $this->uri->segment(4); 
			$this->kodebarang =$id;
			$this->session->set_userdata('kodebarang', $this->kodebarang);
			
			/*
			$text = "SELECT barang.kode_barang, barang.nama_barang, unit.unit_name, departemen.dept_name
					FROM barang
					JOIN unit ON unit.unit_code=barang.satuan
					JOIN departemen ON departemen.dept_code=barang.departemen
					WHERE barang.kode_barang='$id'"; */
			$text = "SELECT A.*,(SELECT B.nama_barang FROM barang B WHERE B.kode_barang=A.turunan AND B.companyarea=A.companyarea) as nama_turunan FROM barang A
					WHERE A.kode_barang='$id' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					//$d['kode_brg'] = $id;
					$d['kode_brg_spc'] 		= $db->kode_barang_spc;
					$d['nama_brg'] 			= $db->nama_barang;
					$d['departemen']		= $db->departemen;
					$d['nama_brg_en']		= $db->nama_barang_eng;
					$d['foto_brg']			= $db->foto_barang;
					if ($db->family==0)
						$d['family']			= '';
					else
						$d['family']			= $db->family;
					if ($db->merek==0)
						$d['merk']				= '';
					else
						$d['merk']				= $db->merek;
					if ($db->type==0)
						$d['type']				= '';
					else
						$d['type']				= $db->type;
					if ($db->category==0)
						$d['category']	= '';
					else
						$d['category']			= $db->category;
					$d['detail']			= $db->detail;
					$d['satuan']			= $db->satuan;
					$d['useper']			= $db->useper;
					$d['average_waste']			= $db->average_waste;
					if ($db->size_length==0)
						$d['size_length'] = '';
					else
						$d['size_length']		= $db->size_length;
					if ($db->size_width==0)
						$d['size_width'] = '';
					else
						$d['size_width']		= $db->size_width;
					if ($db->size_height==0)
						$d['size_height'] = '';
					else
						$d['size_height']		= $db->size_height;
					$d['size_length_unit']	= $db->size_length_unit;
					if ($db->size_weight==0)
						$d['size_weight'] = '';
					else
						$d['size_weight']		= $db->size_weight;
					$d['size_weight_unit']	= $db->size_weight_unit;
					if ($db->size_volume==0)
						$d['size_volume'] = '';
					else
						$d['size_volume']		= $db->size_volume;
					$d['size_volume_unit']	= $db->size_volume_unit;
					if ($db->size_area==0)
						$d['size_area'] = '';
					else
						$d['size_area']			= $db->size_area;
					$d['size_area_unit']	= $db->size_area_unit;
					if ($db->size_density==0)
						$d['size_density'] = '';
					else
						$d['size_density']		= $db->size_density;
					$d['size_density_unit']	= $db->size_density_unit;
					$d['size_density_code']	= $db->size_density_code;
					if ($db->size_diameter==0)
						$d['size_diameter'] = '';
					else
						$d['size_diameter']		= $db->size_diameter;
					$d['size_diameter_unit']	= $db->size_diameter_unit;
					if ($db->size_diameterin==0)
						$d['size_diameterin'] = '';
					else
						$d['size_diameterin']		= $db->size_diameterin;
					$d['size_diameterin_unit']	= $db->size_diameterin_unit;
					$d['size_thread']		= $db->size_thread;
					$d['material']			= $db->material;
					$d['finishing']			= $db->finishing;
					$d['price']			= $db->brg_harga;
					$d['currency']			= $db->brg_currency;
					$d['psecure']			= $db->brg_harga_secure;
					$d['waste_log_plank']		= $db->waste_log_plank;
					$d['waste_plank_raw']		= $db->waste_plank_raw;
					$d['waste_raw_comp']		= $db->waste_raw_comp;
					$d['rack']		= $db->pos_rack;
					$d['row']		= $db->pos_row;
					$d['column']		= $db->pos_column;
					$d['turunan']		= $db->turunan;
					$d['nama_turunan']		= $db->nama_turunan;
					$d['ppn']		= $db->ppn;
					if ($db->min_qty==0){
						$d['min_qty'] = '';
					} else {
						$d['min_qty'] = $db->min_qty;
					}
					
				}
			}else{
					//$d['kode_brg'] 			= $id;
					$d['kode_brg_spc']		= '';
					$d['nama_brg']			= '';
					$d['nama_brg_en']		= '';
					$d['foto_brg']			= '';
					$d['category']			= '';
					$d['family']			= '';
					$d['merek']				= '';
					$d['type']				= '';
					$d['detail']			= '';
					$d['satuan']			= '';
					$d['useper']			= '';
					$d['average_waste']			='';
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
					$d['size_diameter']		= '';
					$d['size_diameter_unit']	= '';
					$d['size_diameterin']		= '';
					$d['size_diameterin_unit']	= '';
					$d['size_thread']		= '';
					$d['material']			= '';
					$d['finishing']			= '';
					$d['price']			= '';
					$d['currency']			= '';
					$d['psecure']			= '';
					$d['waste_log_plank']		= '';
					$d['waste_plank_raw']		= '';
					$d['waste_raw_comp']		= '';
					$d['rack']		= '';
					$d['row']		= '';
					$d['column']		= '';
					$d['min_qty']		= '';
					$d['turunan']		= '';
					$d['ppn']		= '';
					
			}
			
			$d['status']		= '2';
			
			$d['kode_brg'] = $id;
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$text = "SELECT dept_code,dept_name FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_satuan'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_code,unit_name FROM unit";
			$d['l_useper'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT family_id,family FROM family";
			$d['l_fam'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT category_id,category FROM category";
			$d['l_category'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT type_id,`type` FROM type";
			$d['l_type'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT merk_id,merk FROM merk";
			$d['l_merk'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT unit_ukuran_id,`type`,unit_ukuran,simbol,ss_symbol FROM t_unit_ukuran";
			$d['l_ukuran'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT material_id,material FROM material";
			$d['l_material'] = $this->app_model->manualQuery($text);
			
			$text = "SELECT finishing_id,finishing FROM finishing";
			$d['l_finishing'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('barang/form', $d, true);		
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
			$hal = $this->uri->segment(4);
			$text = "SELECT * from barang where kode_barang='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if ($data->num_rows() > 0){
				$foto ='';
				foreach ($data->result() as $db){
					if (!empty($db->foto_barang)){
						$foto = $db->foto_barang;
					}
				}
				if ($foto!=''){
					unlink("./asset/foto_produk/" .$foto);
				}
				$this->app_model->manualQuery("DELETE FROM barang WHERE kode_barang='$id' and companyarea='$loc'");
			}
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/index/$hal'>";			
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
			if (empty($this->input->post('kode_brg'))){
				$kode_barang = $this->app_model->GenerateMaterialCode($this->input->post('departemen'));
			} else {
				$kode_barang = $this->input->post('kode_brg');
			}
			$config['upload_path'] = './asset/foto_produk/';
			$config['allowed_types'] = 'gif|bmp|jpg|jpeg|png';
			$config['max_size'] = '0';
			$config['max_width'] = '0';
			$config['max_height'] = '0';	
			$config['file_name'] = ''.$this->input->post('nama_brg').'_'.$kode_barang;	
			
			
		  $config['maintain_ratio'] = TRUE;					
		  $config['overwrite'] = TRUE;				
			$this->load->library('upload', $config);	
			
			if($this->upload->do_upload('foto_brg')){
				
				$tp=$this->upload->data();
				$res = $tp['full_path'];
				$ori = $tp['file_name'];
				$up['foto_barang']		= $ori; 

				$this->image_lib->clear();
				$config1['image_library'] = 'gd2';
				$config1['source_image'] = $config['upload_path'].$ori;
				$config1['maintain_ratio'] = TRUE;
				$config1['overwrite'] = TRUE;
				$config1['create_thumb'] = TRUE;
				$config1['thumb_marker'] = '';
				$config1['width'] = 750;
				$config1['height'] = 500;
				$config1['quality'] = '100%';
				$config1['new_image'] = $config['upload_path'].$ori;
				//$config1['master_dim']  = 'height';
				$this->load->library('image_lib', $config1);
				$this->image_lib->initialize($config1);
				if (!$this->image_lib->resize()){
					echo $this->image_lib->display_errors();
				}				
			}
			
			
			/*
			 if ( ! $this->image_lib->resize())
              {
                  //echo $uploaddata['full_path'];
                  $fp=fopen("resizeku.txt","w");
									fwrite($fp,$this->image_lib->display_errors());
              } */
							/*
			else{
				$error = $this->upload->display_errors();
				echo  $error;
			}*/
			
			
			
			$up['kode_barang']		= $kode_barang;
			$up['kode_barang_spc']	= $this->input->post('kode_spc');
			$up['nama_barang']		= $this->input->post('nama_brg');
			$up['departemen']		= $this->input->post('departemen');
			$up['nama_barang_eng']	= $this->input->post('nama_brg_en');
			$up['category']			= $this->input->post('category');
			$up['family']			= $this->input->post('family');
			$up['merek']			= $this->input->post('merk');
			$up['type']			= $this->input->post('combo_type');
			$up['detail']			= $this->input->post('detail');
			$up['satuan']			= $this->input->post('satuan');
			$up['useper']			= $this->input->post('useper');
			$up['average_waste']			= $this->input->post('average_waste');
			$up['size_length']		= $this->input->post('size_length');
			$up['size_width']		= $this->input->post('size_width');
			$up['size_height']		= $this->input->post('size_height');
			$up['size_length_unit']	= $this->input->post('size_length_unit');
			$up['size_weight']		= $this->input->post('size_weight');
			$up['size_weight_unit']	= $this->input->post('size_weight_unit');
			$up['size_volume']		= $this->input->post('size_volume');
			$up['size_volume_unit']	= $this->input->post('size_volume_unit');
			$up['size_area']		= $this->input->post('size_area');
			$up['size_area_unit']	= $this->input->post('size_area_unit');
			$up['size_density']		= $this->input->post('size_density');
			$up['size_density_unit']	= $this->input->post('size_density_unit');
			$up['size_diameter']		= $this->input->post('size_diameter');
			$up['size_diameter_unit']	= $this->input->post('size_diameter_unit');
			$up['size_diameterin']		= $this->input->post('size_diameterin');
			$up['size_diameterin_unit']	= $this->input->post('size_diameterin_unit');
			$up['size_thread']		= $this->input->post('size_thread');
			//$up['berat']			= $this->input->post('berat');
			$up['brg_harga']		= $this->input->post('price');
			$up['brg_harga_secure']		= $this->input->post('psecure');
			$up['waste_log_plank']		= $this->input->post('waste_log_plank');
			$up['waste_plank_raw']		= $this->input->post('waste_plank_raw');
			$up['waste_raw_comp']		= $this->input->post('waste_raw_comp');
			$up['brg_currency']		= $this->input->post('currency');
			$up['material']			= $this->input->post('material');
			$up['finishing']		= $this->input->post('finishing');
			$up['pos_rack']		= $this->input->post('rack');
			$up['pos_row']		= $this->input->post('row');
			$up['pos_column']		= $this->input->post('column');
			$up['min_qty']		= $this->input->post('min_qty');
			$up['turunan']		= $this->input->post('turunan');
			$up['ppn']		= $this->input->post('ppn');
			$up['editedby']			= $user;
			$up['editedtime']		= $tgl;
			
			$id['kode_barang']		= $kode_barang;
			$id['companyarea']		= $loc;
			
			$data = $this->app_model->getSelectedData("barang",$id);
					
			if($data->num_rows()>0){
				$this->app_model->updateData("barang",$up,$id);
				//echo 'Update data Sukses';
			}else{
				$up['createdby']	= $user;
				$up['createdtime']	= $tgl;
				$up['companyarea']	= $loc;
				$this->app_model->insertData("barang",$up);
				//echo 'Simpan data Sukses';		
				echo 'Save Successful,'.$kode_barang;
			}
				
		}else{
			header('location:'.base_url());
		}
	
	}
	
	function foto()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Data Barang";
			$d['id'] = $this->uri->segment(3);
			$d['content'] = $this->load->view('barang/foto', $d, true);		
			$this->load->view('home',$d);				
		}else{
				header('location:'.base_url());
		}
	}
	
	public function simpan_foto($foto,$id)
	{
		
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$config['upload_path'] = './asset/foto_produk/';
			$config['allowed_types'] = 'bmp|jpg|jpeg|png';
			$config['max_size'] = '0';
			$config['max_width'] = '0';
			$config['max_height'] = '0';	
			$config['create_thumb'] = TRUE;
		   	$config['maintain_ratio'] = TRUE;					
			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('foto_barang')){
				
				$tp=$this->upload->data();
				$res = $tp['full_path'];
				$ori = $tp['file_name'];
				
				$id['kode_barang']	= $id;
				
				$up['foto_barang']		= $ori;
				
				$data = $this->app_model->getSelectedData("barang",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("barang",$up,$id);
				}
				redirect('/barang');
			}else{
				$error = $this->upload->display_errors();
				echo  $error;
			}
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function clear () {
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$this->session->unset_userdata('barang_code_cari');
			$this->session->unset_userdata('barang_unit_cari');
			$this->session->unset_userdata('barang_type_cari');
			$this->session->unset_userdata('barang_finish_cari');
			$this->session->unset_userdata('barang_name_cari');
			$this->session->unset_userdata('barang_dept_cari');
			redirect('barang');
		}else{
				header('location:'.base_url());
		}
	}
	
	public function supplier() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$vkodebarang = $this->session->userdata('kodebarang');
		if(!empty($cek)){
			$text ="SELECT A.kode_barang,C.supplier_name,D.currency_name,A.harga,DATE_FORMAT(A.tgl,'%Y-%m-%d') as tglbeli 
					FROM d_barangsup A 
					JOIN barang B on B.companyarea=A.companyarea and B.kode_barang=A.kode_barang 
					LEFT OUTER JOIN supplier C on C.companyarea=A.companyarea and C.supplier_code=A.supplier_code 
					LEFT OUTER JOIN currency D on D.currency_code=A.currency 
					where A.kode_barang='$vkodebarang' and A.companyarea='$loc'
					ORDER BY A.tgl DESC";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			//$text ="SELECT A.kode_barang,B.supplier_name 
			//		FROM barang A supplier B on B.companyarea=A.companyarea and B.supplier_code=A.supplier_code 
			//		LEFT OUTER JOIN ";
			
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
	
}

/* End of file barang.php */
/* Location: ./application/controllers/barang.php */