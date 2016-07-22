<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_barang extends CI_Controller {
	
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
				$sess_data['dbarang_code_cari'] = $this->input->post('code_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if(!empty($name_cari)) {
				$sess_data['dbarang_name_cari'] = $this->input->post('name_cari');
				$this->session->set_userdata($sess_data);
			}
			
			//$this->session->set_userdata($sess_data);
			
			$code_cari = $this->session->userdata('dbarang_code_cari');
			$name_cari = $this->session->userdata('dbarang_name_cari');
			
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

			
			$d['judul']="Price Material";
			
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
			
			$config['base_url'] = site_url() . '/supplier_barang/index/';
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
			

			$text = "SELECT A.kode_barang, A.kode_lama, A.foto_barang, A.nama_barang, B.unit_name, C.dept_name,A.pos_rack,A.pos_row,A.pos_column,A.kode_barang_spc, D.type, E.finishing,A.size_length, A.size_width, A.size_height, F.simbol as size_length_unit, A.size_diameter, G.simbol as size_diameter_unit,
											A.size_diameterin, H.simbol as size_diameterin_unit, A.size_density, A.size_thread, (SELECT L.supplier_name from d_barangsup K JOIN supplier L ON L.supplier_code=K.supplier_code WHERE K.kode_barang=A.kode_barang ORDER BY K.tgl DESC LIMIT 1) as supplier_name,
											(SELECT M.tgl from d_barangsup M where M.kode_barang=A.kode_barang ORDER BY M.tgl DESC LIMIT 1) as tgl, (SELECT N.harga from d_barangsup N where N.kode_barang=A.kode_barang ORDER BY N.tgl DESC LIMIT 1) as harga,
											(SELECT P.currency_name from d_barangsup O LEFT OUTER JOIN currency P ON P.currency_code=O.currency where O.kode_barang=A.kode_barang ORDER BY O.tgl DESC LIMIT 1) as currency
						FROM barang A
						LEFT OUTER JOIN unit B ON B.unit_code=A.satuan
						LEFT OUTER JOIN departemen_fact C ON C.dept_code=A.departemen and C.companyarea=A.companyarea
						LEFT OUTER JOIN `type` D ON D.type_id=A.type
						LEFT OUTER JOIN finishing E ON E.finishing_id=A.finishing
						LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=A.size_length_unit
						LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=A.size_diameter_unit
						LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=A.size_diameterin_unit
						$where
						ORDER BY A.kode_barang 
						LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			$d['content'] = $this->load->view('supplier_barang/view', $d, true);		
			
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
			
			$d['judul'] = "Price Material";
			
			$id = $this->uri->segment(3); 
			$d['hal'] = $this->uri->segment(4); 
			$this->kodebarang =$id;
			$this->session->set_userdata('kodebarang', $this->kodebarang);
			
			$text = "SELECT A.kode_barang, A.kode_barang_spc, A.nama_barang, A.foto_barang, A.size_length, A.size_width, A.size_height, B.simbol as size_length_unit, A.size_diameter, C.simbol as size_diameter_unit,
											A.size_diameterin, D.simbol as size_diameterin_unit, A.size_density, A.size_thread, E.finishing, F.unit_name
							FROM barang A
							LEFT OUTER JOIN t_unit_ukuran B ON B.unit_ukuran_id=A.size_length_unit
							LEFT OUTER JOIN t_unit_ukuran C ON C.unit_ukuran_id=A.size_diameter_unit
							LEFT OUTER JOIN t_unit_ukuran D ON D.unit_ukuran_id=A.size_diameterin_unit
							LEFT OUTER JOIN finishing E ON E.finishing_id=A.finishing
							LEFT OUTER JOIN `unit` F ON F.unit_code=A.satuan
							WHERE A.kode_barang='$id' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			
			if($data->num_rows() > 0){
				$size='';
				foreach($data->result() as $db){
					$d['kode_barang'] = $db->kode_barang;
					$d['kode_barang_spc'] 		= $db->kode_barang_spc;
					$d['nama_barang'] 			= $db->nama_barang;
					$d['foto_barang']			= $db->foto_barang;
					$d['unit_name']			= $db->unit_name;
					if ($db->size_length>0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_length);
						$fraction = $db->size_length - $whole;
						if ($fraction > 0){
							$size .= 'L '.number_format($db->size_length, 1,',','.').' x ';
						} else {
							$size .= 'L '.number_format($db->size_length, 0,',','.').' x ';
						}
					}
					
					if ($db->size_width>0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_width);
						$fraction = $db->size_width - $whole;
						if ($fraction > 0){
							$size .= 'W '.number_format($db->size_width, 1,',','.').' x ';
						} else {
							$size .= 'W '.number_format($db->size_width, 0,',','.').' x ';
						}
					}
					
					if ($db->size_height>0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_height);
						$fraction = $db->size_height - $whole;
						if ($fraction > 0){
							$size .= 'H '.number_format($db->size_height, 1,',','.').' x ';
						} else {
							$size .= 'H '.number_format($db->size_height, 0,',','.').' x ';
						}
					}
					
					if ($size!=''){
						$size = substr($size,0,-3);
						if (empty($db->size_length_unit)){
							$size .= '; ';
						} else {
							$size .= ' '.$db->size_length_unit.'; ';
						}
					}
					
					if ($db->size_diameter > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_diameter);
						$fraction = $db->size_diameter - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; out '.number_format($db->size_diameter,1,',','.');
						} else {
							$size = $size.'&#216; out '.number_format($db->size_diameter,0,',','.');
						}
						if (empty($db->size_diameter_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$db->size_diameter_unit.'; ';
						}
					}
					
					if ($db->size_diameterin > 0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_diameterin);
						$fraction = $db->size_diameterin - $whole;
						if ($fraction > 0){
							$size = $size.'&#216; in '.number_format($db->size_diameterin,1,',','.');
						} else {
							$size = $size.'&#216; in '.number_format($db->size_diameterin,0,',','.');
						}
						if (empty($db->size_diameterin_unit)){
							$size = $size.'; ';
						} else {
							$size = $size.' '.$db->size_diameterin_unit.'; ';
						}
					}
					
					if ($db->size_density>0){
						$whole = 0;
						$fraction = 0.0;
						$whole = floor($db->size_density);
						$fraction = $db->size_density - $whole;
						if ($fraction > 0){
							$size = $size.'D'.number_format($db->size_density,1,',','.').'; ';
						} else {
							$size = $size.'D'.number_format($db->size_density,0,',','.').'; ';
						}
					}
					
					if (!empty($db->size_thread)){
						$size		= $size.$db->size_thread.'; ';
					}
					$d['size'] = $size;
					$d['finishing']			= $db->finishing;
					
				}
			}else{
					$d['kode_barang'] 			= '';
					$d['kode_barang_spc']		= '';
					$d['nama_barang']			= '';
					$d['foto_barang']			= '';
					$d['size']		= '';
					$d['finishing']			= '';
					$d['unit_name']			= '';
					
			}
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('supplier_barang/form', $d, true);		
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
		
			$up['kode_barang']		= $this->input->post('kode_barang');
			$up['supplier_code']	= $this->input->post('kode_supplier');
			$up['tgl']		= $this->input->post('tgl_harga');
			$up['currency']		= $this->input->post('currency');
			$up['min_qty']	= $this->input->post('min_qty');
			$up['harga']	= $this->input->post('harga_barang');
			$up['remarks']			= $this->input->post('remarks');
			$up['editedby']			= $user;
			$up['editedtime']		= $tgl;
			
			$id['kode_barang']			= $this->input->post('kode_barang');
			$id['supplier_code']		= $this->input->post('kode_supplier');
			$id['tgl']		= $this->input->post('tgl_harga');
			$id['companyarea']		= $loc;
		
			$data = $this->app_model->getSelectedData("d_barangsup",$id);
					
			if($data->num_rows()==0){
				$up['createdby']	= $user;
				$up['createdtime']	= $tgl;
				$up['companyarea']	= $loc;
				$this->app_model->insertData("d_barangsup",$up);
				//echo 'Simpan data Sukses';		
				echo 'Save Successful';
			}else{
				
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
			$this->session->unset_userdata('dbarang_code_cari');
			$this->session->unset_userdata('dbarang_name_cari');
			redirect('supplier_barang');
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
	
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$id = $this->input->post('kode');
			$text = "SELECT A.kode_barang, A.supplier_code, B.supplier_name, A.tgl, C.currency_name as currency,  A.harga, A.remarks, A.min_qty, E.unit_name
					FROM d_barangsup A
					JOIN supplier B ON B.supplier_code=A.supplier_code
					JOIN currency C ON C.currency_code=A.currency
					JOIN barang D ON D.kode_barang=A.kode_barang
					LEFT OUTER JOIN unit E ON E.unit_code=D.satuan
					WHERE A.kode_barang='$id' and A.companyarea='$loc'
					ORDER BY A.tgl DESC";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('supplier_barang/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$kode_barang = $this->input->post('kode_barang');
			$supplier_code = $this->input->post('supplier_code');
			$tgl = $this->input->post('tgl');
			
			$text = "DELETE from d_barangsup where kode_barang='$kode_barang' and supplier_code='$supplier_code' and tgl=str_to_date('$tgl','%Y-%m-%d') and companyarea='$loc'";
		//	$fp=fopen("datadel.txt","w");
		//	fwrite($fp,$text);
			$this->app_model->manualQuery($text);
			
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file supplier_barang.php */
/* Location: ./application/controllers/supplier_barang.php */