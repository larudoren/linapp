<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_box extends CI_Controller {
	
	var $product_code;
	var $product_name;
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
			//$unit_cari = $this->input->post('unit_cari');
			//$d['unit_cari'] = $unit_cari;
			//$type_cari = $this->input->post('type_cari');
			//$d['type_cari'] = $type_cari;
			//$finish_cari = $this->input->post('finish_cari');
			//$d['finish_cari'] = $finish_cari;
			$name_cari = $this->input->post('name_cari');
			//$d['name_cari'] = $name_cari;
			//$dept_cari = $this->input->post('dept_cari');
			//$d['dept_cari'] = $dept_cari;
			$loc  = $this->session->userdata('companyarea');
			$this->product_code ='';
			$this->session->set_userdata('sup_product_code',$this->product_code);
			
		
			if (!empty($code_cari)){
				$sess_data['dproduct_code_cari'] = $this->input->post('code_cari');
				$this->session->set_userdata($sess_data);
			}
			
			if(!empty($name_cari)) {
				$sess_data['dproduct_name_cari'] = $this->input->post('name_cari');
				$this->session->set_userdata($sess_data);
			}
			
			//$this->session->set_userdata($sess_data);
			
			$code_cari = $this->session->userdata('dproduct_code_cari');
			$name_cari = $this->session->userdata('dproduct_name_cari');
			
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
			
			$where = "WHERE A.companyarea='$loc' and A.product_code LIKE '%$code_cari%' and A.product_name LIKE '%$name_cari%'";
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Price Box";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.product_code, A.product_name, A.product_photo, A.category, B.coll_name
						FROM product A
						LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll
						$where";		
			$tot_hal = $this->app_model->manualQuery($text);		
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/supplier_box/index/';
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
			

			$text = "SELECT A.product_code, A.product_name, A.product_photo, A.category, B.coll_name,
										 (SELECT D.supplier_name FROM d_boxsup C JOIN supplier D ON D.supplier_code=C.supplier_code WHERE C.product_code=A.product_code ORDER BY C.tgl DESC LIMIT 1) as supplier_name,
										 (SELECT E.tgl from d_boxsup E where E.product_code=A.product_code ORDER BY E.tgl DESC LIMIT 1) as tglhrg,
										 (SELECT F.harga from d_boxsup F where F.product_code=A.product_code AND F.boxnumber='BOX 1' AND F.tgl=tglhrg ORDER BY F.tgl DESC LIMIT 1) as hargabox1,
										 (SELECT G.harga from d_boxsup G where G.product_code=A.product_code AND G.boxnumber='BOX 2' AND G.tgl=tglhrg ORDER BY G.tgl DESC LIMIT 1) as hargabox2,
										 (SELECT H.harga from d_boxsup H where H.product_code=A.product_code AND H.boxnumber='BOX 3' AND H.tgl=tglhrg ORDER BY H.tgl DESC LIMIT 1) as hargabox3,
										 (SELECT J.currency_name FROM d_boxsup I JOIN currency J ON J.currency_code=I.currency WHERE I.product_code=A.product_code AND I.tgl=tglhrg ORDER BY I.tgl DESC LIMIT 1) as currency
						FROM product A
						LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll
						$where
						ORDER BY A.product_code 
						LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			$d['content'] = $this->load->view('supplier_box/view', $d, true);		
			
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
			
			$d['judul'] = "Price Box";
			
			$id = $this->uri->segment(3); 
			$d['hal'] = $this->uri->segment(4); 
			$this->product_code =$id;
			$this->session->set_userdata('product_code', $this->product_code);
			
			$text = "SELECT A.product_code, A.product_name, A.product_photo, A.category, B.coll_name
							FROM product A
							LEFT OUTER JOIN collection B ON B.coll_code=A.product_coll
							WHERE A.product_code='$id' and A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			
			if($data->num_rows() > 0){
				$size='';
				foreach($data->result() as $db){
					$d['product_code'] = $db->product_code;
					$d['product_name'] 			= $db->product_name;
					$d['product_photo']			= $db->product_photo;
					$d['category']			= $db->category;
					$d['coll_name']			= $db->coll_name;
					
				}
			}else{
					$d['product_code'] 			= '';
					$d['product_name']			= '';
					$d['product_photo']			= '';
					$d['category']		= '';
					$d['coll_name']			= '';
					
			}
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('supplier_box/form', $d, true);		
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
			$text = "SELECT A.boxnumber,A.lsize,A.wsize,A.hsize,A.kdown,A.typebox,A.lstyrofoam,A.wstyrofoam,A.hstyrofoam,A.linner,A.winner,A.hinner,A.lkarton,A.wkarton,A.hkarton,
											A.louter,A.wouter,A.houter,A.volouter
							 FROM cotation_packing A 
							JOIN h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea 
							WHERE B.product_code='".$this->input->post('product_code')."' AND A.seq='".$this->input->post('size_box')."' AND A.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if ($data->num_rows()>0){
				foreach($data->result() as $dt){
					$up['boxnumber'] = $dt->boxnumber;
					$up['lsize'] = $dt->lsize;
					$up['wsize'] = $dt->wsize;
					$up['hsize'] = $dt->hsize;
					$up['kdown'] = $dt->kdown;
					$up['typebox'] = $dt->typebox;
					$up['lstyrofoam'] = $dt->lstyrofoam;
					$up['wstyrofoam'] = $dt->wstyrofoam;
					$up['hstyrofoam'] = $dt->hstyrofoam;
					$up['linner'] = $dt->linner;
					$up['winner'] = $dt->winner;
					$up['hinner'] = $dt->hinner;
					$up['lkarton'] = $dt->lkarton;
					$up['wkarton'] = $dt->wkarton;
					$up['hkarton'] = $dt->hkarton;
					$up['louter'] = $dt->louter;
					$up['wouter'] = $dt->wouter;
					$up['houter'] = $dt->houter;
					$up['volouter'] = $dt->volouter;
				}
			}
			
			$up['product_code']		= $this->input->post('product_code');
			$up['supplier_code']	= $this->input->post('kode_supplier');
			$up['tgl']		= $this->input->post('tgl_harga');
			$up['currency']		= $this->input->post('currency');
			$up['min_qty']	= $this->input->post('min_qty');
			$up['harga']	= $this->input->post('harga_barang');
			$up['remarks']			= $this->input->post('remarks');
			$up['editedby']			= $user;
			$up['editedtime']		= $tgl;
			
			$id['product_code']			= $this->input->post('product_code');
			$id['supplier_code']		= $this->input->post('kode_supplier');
			$id['boxnumber']		= $up['boxnumber'];
			$id['kdown']		= $up['kdown'];
			$id['typebox']		= $up['typebox'];
			$id['tgl']		= $this->input->post('tgl_harga');
			$id['companyarea']		= $loc;
		
			$data = $this->app_model->getSelectedData("d_boxsup",$id);
					
			if($data->num_rows()==0){
				$up['createdby']	= $user;
				$up['createdtime']	= $tgl;
				$up['companyarea']	= $loc;
				$this->app_model->insertData("d_boxsup",$up);
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
			$this->session->unset_userdata('dproduct_code_cari');
			$this->session->unset_userdata('dproduct_name_cari');
			redirect('supplier_box');
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
			$text = "SELECT A.product_code, A.supplier_code, B.supplier_name, A.tgl, C.currency_name as currency,  A.harga, A.remarks, A.min_qty,A.boxnumber,A.lsize,A.wsize,A.hsize,
											A.kdown,A.typebox,A.lstyrofoam,A.wstyrofoam,A.hstyrofoam,A.linner,A.winner,A.hinner,A.lkarton,A.wkarton,A.hkarton,A.louter,A.wouter,A.houter,A.volouter,
											D.cm_length,D.cm_width,D.cm_height
					FROM d_boxsup A
					JOIN supplier B ON B.supplier_code=A.supplier_code
					JOIN currency C ON C.currency_code=A.currency
					LEFT OUTER JOIN product D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
					WHERE A.product_code='$id' and A.companyarea='$loc'
					ORDER BY A.tgl DESC";
			$d['data']= $this->app_model->manualQuery($text);

			$this->load->view('supplier_box/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$product_code = $this->input->post('product_code');
			$supplier_code = $this->input->post('supplier_code');
			$tgl = $this->input->post('tgl');
			
			$text = "DELETE from d_boxsup where product_code='$product_code' and supplier_code='$supplier_code' and tgl=str_to_date('$tgl','%Y-%m-%d') and companyarea='$loc'";
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