<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	
	public function name()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			//$d['collection']=urldecode($this->uri->segment(3));
			//$d['brand']=urldecode($this->uri->segment(4));
			//$collection=urldecode($this->uri->segment(3));
			/*
			$cari = $this->input->post('txt_cari');
			if (!empty($this->input->post('code_cari'))){
				$code_cari = $_POST['code_cari'];
			} else if (urldecode($this->uri->segment(3))=='PR') {
				$code_cari = 'PR';
			}
			
			if (!empty($this->input->post('coll_cari'))){
				$coll_cari = $_POST['coll_cari'];
			} else {
				$coll_cari = 'PR';
			}
			
			if (!empty($this->input->post('type_cari'))){
				$type_cari = $_POST['type_cari'];
			} else {
				$type_cari = 'PR';
			}
			
			if (!empty($this->input->post('category_cari'))){
				$category_cari = $_POST['category_cari'];
			} else {
				$category_cari = 'PR';
			} */
			
			$code_cari = $this->input->post('code_cari');
			$coll_cari = $this->input->post('coll_cari');
			$type_cari = $this->input->post('type_cari');
			$category_cari = $this->input->post('category_cari');
			/*
			$code_cari = isset($this->input->post('code_cari')) ? $this->input->post('code_cari') : 'PR';
			$coll_cari = isset($this->input->post('coll_cari')) ? $this->input->post('coll_cari') : 'PR';
			$type_cari = isset($this->input->post('type_cari')) ? $this->input->post('type_cari') : 'PR';
			$category_cari = isset($this->input->post('category_cari')) ? $this->input->post('category_cari') : 'PR'; */
			
			if (empty($code_cari)){
				$code_cari = 'PR';
				$vcode_cari ='';
				$tmp_code_cari = urldecode($this->uri->segment(3));
				if ($tmp_code_cari!='PR' && !empty($this->uri->segment(3))){
					$code_cari = $tmp_code_cari;
					$vcode_cari = $tmp_code_cari;
				}
			} else {
				$vcode_cari =  $code_cari;
			}
			
			if (empty($coll_cari)){
				$coll_cari = 'PR';
				$vcoll_cari = '';
				$tmp_coll_cari = urldecode($this->uri->segment(4));
				if ($tmp_coll_cari!='PR' && !empty($this->uri->segment(4))){
					$coll_cari = $tmp_coll_cari;
					$vcoll_cari = $tmp_coll_cari;
				}
			} else {
				$vcoll_cari = $coll_cari;
			}
			
			if (empty($type_cari)){
				$type_cari = 'PR';
				$vtype_cari = '';
				$tmp_type_cari = urldecode($this->uri->segment(5));
				if ($tmp_type_cari!='PR' && !empty($this->uri->segment(5))){
					$type_cari = $tmp_type_cari;
					$vtype_cari = $tmp_type_cari;
				}
			} else {
				$vtype_cari = $type_cari;
			}
			
			if (empty($category_cari)){
				$category_cari = 'PR';
				$vcategory_cari = '';
				$tmp_category_cari = urldecode($this->uri->segment(6));
				if ($tmp_category_cari!='PR' && !empty($this->uri->segment(6))){
					$category_cari = $tmp_category_cari;
					$vcategory_cari = $tmp_category_cari;
				}
			} else {
				$vcategory_cari = $category_cari;
			}
			
			/*
			if (empty($code_cari) && empty($coll_cari) && empty($type_cari) && empty($category_cari)){
				$code_cari = urldecode($this->uri->segment(3));
				$coll_cari = urldecode($this->uri->segment(4));
				$type_cari = urldecode($this->uri->segment(5));
				$category_cari = urldecode($this->uri->segment(6));
			} */
			/*
			if ($code_cari=='PR'){
				$vcode_cari = '';
			} else {
				$vcode_cari = $code_cari;
			}
			
			if ($coll_cari=='PR'){
				$vcoll_cari = '';
			} else {
				$vcoll_cari = $coll_cari;
			}
			
			if ($type_cari=='PR'){
				$vtype_cari = '';
			} else {
				$vtype_cari = $type_cari;
			}
			
			if ($category_cari=='PR'){
				$vcategory_cari ='';
			} else {
				$vcategory_cari = $category_cari;
			}
	
			if ($code_cari!=urldecode($this->uri->segment(3))){
				$code_cari = urldecode($this->uri->segment(3));
				$vcode_cari = $code_cari;
			}
			
			if ($coll_cari != urldecode($this->uri->segment(4))){
				$coll_cari = urldecode($this->uri->segment(4));
				$vcoll_cari = $coll_cari;
			}
			
			if ($type_cari != urldecode($this->uri->segment(5))) {
				$type_cari = urldecode($this->uri->segment(5));
				$vtype_cari = $type_cari;
			}
			
			if ($category_cari != urldecode($this->uri->segment(6))){
				$category_cari = urldecode($this->uri->segment(6));
				$vcategory_cari = $category_cari;
			} */
			
			$d['code_cari'] = $code_cari;
			$d['coll_cari'] = $coll_cari;
			$d['type_cari'] = $type_cari;
			$d['category_cari'] = $category_cari;
			
			//if(empty($cari)){
			//	$where = " WHERE B.coll_name='$collection' ";
			//}else{
			if ($vtype_cari=='Table' || $vtype_cari=='Dining Table' || $vtype_cari=='Chair' || $vtype_cari=='Stool'){
				$mytype = " AND C.type_product='$vtype_cari' ";
			//}elseif($vtype_cari=='Dining Table'){
			}else{
				$mytype = " AND C.type_product LIKE '%$vtype_cari%'";
			}
				$where = " WHERE B.coll_name LIKE '%$vcoll_cari%' AND A.product_code LIKE '%$vcode_cari%' $mytype AND A.category LIKE '%$vcategory_cari%'";
			//}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Product";
			
			//paging
			$page=$this->uri->segment(7);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.product_code, A.product_coll, B.coll_name, A.product_name FROM product A JOIN collection B ON B.coll_code=A.product_coll JOIN type_product C ON C.type_product_id=A.type_product_id $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/product/name/'.$code_cari.'/'.$coll_cari.'/'.$type_cari.'/'.$category_cari.'/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment'] 	= 7;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT A.product_code, A.product_coll, B.coll_name, A.product_name, A.product_photo FROM product A JOIN collection B ON B.coll_code=A.product_coll JOIN type_product C ON C.type_product_id=A.type_product_id $where 
					ORDER BY A.product_code ASC 
					LIMIT $limit OFFSET $offset";
			
			$d['data'] = $this->app_model->manualQuery($text);
			
			if (($tot_hal->num_rows() - $offset) < 15){
				$d['mymenu'] = 'Research';
			}
			
			$d['content'] = $this->load->view('product/view', $d, true);		
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
			$d['myheader'] 	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['code_cari'] = htmlentities($this->uri->segment(3));
			$d['coll_cari'] = htmlentities($this->uri->segment(4));
			$d['type_cari'] = urldecode($this->uri->segment(5));
			$d['category_cari'] = htmlentities($this->uri->segment(6));
			$d['hal'] = htmlentities($this->uri->segment(7));
			
			$d['collection']=urldecode($this->uri->segment(3));
			//$d['brand_name']=urldecode($this->uri->segment(4));
			$collection=urldecode($this->uri->segment(4));
			$d['judul']					= "Add Product";
			
			$d['kode']					= '';
			$d['nama_val']			=	'';
			$d['product_photo']	=	'';
			$d['category']			= $d['category_cari'];
			$d['cm_length']			= '';
			$d['cm_width']			= '';
			$d['cm_height']			= '';
			$d['inch_length']		= '';
			$d['inch_width']		= '';
			$d['inch_height']		=	'';
			$d['weight_kg']			= '';
			$d['weight_lbs']		= '';
			$d['vol_m3']				=	'';
			$d['vol_cuft']			= '';
			$d['qty_packing']		= '';
			$d['qty_perbox']		=	'';
			$d['knock_down']		= '';
			$d['gross_kg']			= '';
			$d['gross_lbs']			= '';
			$d['qty_20']				= '';
			$d['qty_40']				= '';
			$d['qty_40hc']			= '';
			$d['prod_detail']		= '';
			$d['ext_qty']				= '';
			$d['ext_qty2']			= '';
			$d['ext_length']		= '';
			$d['ext_length2']		= '';
			$d['cm_seat_w']				= '';
			$d['cm_seat_d']				= '';
			$d['cm_seat_h']				= '';
			$d['inch_seat_w']			= '';
			$d['inch_seat_d']			= '';
			$d['inch_seat_h']			= '';
			$d['cm_clear']			= '';
			$d['inch_clear']		= '';
			$d['cm_arm']			= '';
			$d['inch_arm']			= '';
			$d['remarks']				= '';
			
			$text = "SELECT A.coll_code,A.coll_name FROM collection A WHERE coll_name='$collection'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['coll_code']	=	$db->coll_code;
					$d['coll_name'] = $db->coll_name;
				}
			} else {
				$d['coll_code']		=	'';
				$d['coll_name'] 	= '';
			}
			
			$text = "SELECT A.type_product_id FROM type_product A WHERE type_product='".$d['type_cari']."'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['type_product_id']	=	$db->type_product_id;
				}
			} else {
				$d['type_product_id']	=	'';
			}
			
			$d['content'] = $this->load->view('product/form', $d, true);		
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
			
			$id = $this->uri->segment(3);
			$temp = explode(':', $id);
			
			$d['judul'] = "Edit Collection - ".urldecode($temp[1]);
			$d['code_cari'] = htmlentities($temp[3]);
			$d['coll_cari'] = htmlentities($temp[4]);
			$d['type_cari'] = htmlentities($temp[5]);
			$d['category_cari'] = htmlentities($temp[6]);
			$d['hal'] = htmlentities($temp[7]);
			$d['collection'] = urldecode($temp[0]);
			$text = "SELECT * FROM product WHERE product_code='$temp[1]' AND product_coll='$temp[2]'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['coll_code']		=$temp[2];
					$d['kode'] = $temp[1];
					$d['nama_val']			=	htmlentities($db->product_name);
					$d['coll_name']			=	urldecode($temp[0]);
					//$d['brand_name']		=	$temp[3];
					$d['product_photo']	=	$db->product_photo;
					$d['category']			= $db->category;
					$d['cm_length']			= $db->cm_length;
					$d['cm_width']			= $db->cm_width;
					$d['cm_height']			= $db->cm_height;
					$d['inch_length']		= $db->inch_length;
					$d['inch_width']		= $db->inch_width;
					$d['inch_height']		= $db->inch_height;
					$d['weight_kg']			= $db->weight_kg;
					$d['weight_lbs']		= $db->weight_lbs;
					$d['vol_m3']				= $db->vol_m3;
					$d['vol_cuft']			= $db->vol_cuft;
					$d['qty_packing']		= $db->qty_packing;
					$d['qty_perbox']		= $db->qty_box;
					$d['knock_down']		= $db->knock_down;
					$d['gross_kg']			= $db->gross_kg;
					$d['gross_lbs']			= $db->gross_lbs;
					
					if ($db->qty_20!=0){
						$d['qty_20']			= $db->qty_20;
					} else{
						$d['qty_20']			= '';
					}
					
					if ($db->qty_40!=0){
						$d['qty_40']			= $db->qty_40;
					} else{
						$d['qty_40']			= '';
					}
					
					if ($db->qty_40hc!=0){
						$d['qty_40hc']		= $db->qty_40hc;
					} else {
						$d['qty_40hc']		= '';
					}
					
					$d['prod_detail']		= $db->prod_detail;
					$d['ext_qty']				= $db->ext_qty;
					$d['ext_qty2']			= $db->ext_qty2;
					$d['ext_length']		= $db->ext_length;
					$d['ext_length2']		= $db->ext_length2;
					$d['cm_seat_w']				= $db->cm_seat_w;
					$d['cm_seat_d']				= $db->cm_seat_d;
					$d['cm_seat_h']				= $db->cm_seat_h;
					$d['inch_seat_w']			= $db->inch_seat_w;
					$d['inch_seat_d']			= $db->inch_seat_d;
					$d['inch_seat_h']			= $db->inch_seat_h;
					$d['cm_clear']			= $db->cm_clear;
					$d['inch_clear']		= $db->inch_clear;
					$d['cm_arm']			= $db->cm_arm;
					$d['inch_arm']			= $db->inch_arm;
					$d['remarks']				= $db->remarks;
					$d['type_product_id']				= $db->type_product_id;
				}
			}
						
			$d['content'] = $this->load->view('product/form', $d, true);		
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
			$temp= explode(':', $id);
			$this->app_model->manualQuery("DELETE FROM product WHERE product_code='$temp[1]' AND product_coll='$temp[2]' AND companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM product_detail WHERE product_code='$temp[1]' AND companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/product/name/".$temp[3]."/$temp[4]/$temp[5]/$temp[6]/$temp[7]'>";
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$temp= explode(':', $id);
			$this->app_model->manualQuery("DELETE FROM product_detail WHERE product_code='$temp[1]' AND seq='$temp[2]'");
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
			$config['upload_path'] = './asset/product_photo/';
			$config['allowed_types'] = 'bmp|jpg|jpeg|png';
			$config['max_size'] = '0';
			$config['max_width'] = '0';
			$config['max_height'] = '0';	
			$config['file_name'] = ''.$this->input->post('nama_val').'_'.$this->input->post('kode');	
			
			
		  $config['maintain_ratio'] = TRUE;					
		  $config['overwrite'] = TRUE;				
			$this->load->library('upload', $config);	
			
			if($this->upload->do_upload('foto_brg')){
				$tp=$this->upload->data();
				$res = $tp['full_path'];
				$ori = $tp['file_name'];
				$up['product_photo']		= $ori; 
				
				$this->image_lib->clear();
				$config1['image_library'] = 'gd2';
				$config1['source_image'] = $config['upload_path'].$ori;
				$config1['maintain_ratio'] = TRUE;
				$config1['overwrite'] = TRUE;
				$config1['create_thumb'] = FALSE;
				$config1['thumb_marker'] = '';
				if ($tp['image_width'] > 400){
					$config1['width'] = 400;
				} else {
					$config1['width'] = $tp['image_width'];
				}
				if ($tp['image_height']>600){
					$config1['height'] = 600;
				} else {
					$config1['height'] = $tp['image_height'];
				}
				$config1['quality'] = '100%';
				$config1['new_image'] = $config['upload_path'].$ori;
				//$dim = (intval($tp["image_width"]) / intval($tp["image_height"])) - ($config1['width'] / $config1['height']);
				//$config1['master_dim'] = ($dim > 0)? "height" : "width";
				//$config1['master_dim']  = 'height';
				$this->load->library('image_lib', $config1);
				$this->image_lib->initialize($config1);
				if (!$this->image_lib->resize()){
					echo $this->image_lib->display_errors();
				}		
			}
				
				
				$up['product_name']	= $this->input->post('nama_val');
				$up['category']			= $this->input->post('category');
				$up['cm_length']		= $this->input->post('cm_length');
				$up['cm_width']			= $this->input->post('cm_width');
				$up['cm_height']		= $this->input->post('cm_height');
				$up['inch_length']	= $this->input->post('inch_length');
				$up['inch_width']		= $this->input->post('inch_width');
				$up['inch_height']	= $this->input->post('inch_height');
				$up['weight_kg']		= $this->input->post('weight_kg');
				$up['weight_lbs']		= $this->input->post('weight_lbs');
				$up['vol_m3']				= $this->input->post('vol_m3');
				$up['vol_cuft']			= $this->input->post('vol_cuft');
				$up['qty_packing']	= $this->input->post('qty_packing');
				$up['qty_box']			= $this->input->post('qty_perbox');
				$up['knock_down']		= $this->input->post('knock_down');
				$up['gross_kg']			= $this->input->post('gross_kg');
				$up['gross_lbs']		= $this->input->post('gross_lbs');
				$up['qty_20']				= $this->input->post('qty_20');
				$up['qty_40']				= $this->input->post('qty_40');
				$up['qty_40hc']			= $this->input->post('qty_40hc');
				$up['prod_detail']	= $this->input->post('prod_detail');
				$up['ext_qty']			= $this->input->post('ext_qty');
				$up['ext_qty2']			= $this->input->post('ext_qty2');
				$up['ext_length']		= $this->input->post('ext_length');
				$up['ext_length2']	= $this->input->post('ext_length2');
				$up['cm_seat_w']			= $this->input->post('cm_seat_w');
				$up['cm_seat_d']			= $this->input->post('cm_seat_d');
				$up['cm_seat_h']			= $this->input->post('cm_seat_h');
				$up['inch_seat_w']		= $this->input->post('inch_seat_w');
				$up['inch_seat_d']		= $this->input->post('inch_seat_d');
				$up['inch_seat_h']		= $this->input->post('inch_seat_h');
				$up['cm_clear']			= $this->input->post('cm_clear');
				$up['inch_clear']		= $this->input->post('inch_clear');
				$up['cm_arm']		= $this->input->post('cm_arm');
				$up['inch_arm']		= $this->input->post('inch_arm');
				$up['remarks']			= $this->input->post('remarks');
				$up['type_product_id']			= $this->input->post('type_product_id');
				$up['companyarea']	= $loc;
				$up['editedby']			= $user;
				$up['editedtime']		= $tgl;
				
				
				$id['product_code']	=	$this->input->post('kode');
				$id['product_coll']	=	$this->input->post('coll_code');
				//$id['companyarea']	=	$loc;
				
				$data = $this->app_model->getSelectedData("product",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("product",$up,$id);
					//echo 'Update data Sukses';
				}else{
					$up['product_code']	= $this->input->post('kode');
					$up['product_coll']	= $this->input->post('coll_code');
					$up['createdby']		= $user;
					$up['createdtime']	= $tgl;
					
					$this->app_model->insertData("product",$up);
					//echo 'Simpan data Sukses';
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function simpan_detail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){
			$test['jml'] = $this->input->post('nArray');
			$this->load->model('app_model');
			for ($i=0;$i<$test['jml'];$i++){
				if (empty($this->input->post('seq_'.$i))){
					
					$text = "SELECT MAX(seq) as Seq from product_detail where product_code='".$this->input->post('product_code_'.$i)."' and companyarea='$loc'";
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
				
				$up['kode_barang']	= $this->input->post('kode_barang_'.$i);
				$up['editedby']			= $user;
				$up['editedtime']		= $tgl;
				
				$id['product_code']	=	$this->input->post('product_code_'.$i);
				$id['seq']					=	$Seq;
				$id['companyarea']	=	$loc;
				
				$data = $this->app_model->getSelectedData("product_detail",$id);
				
				if($data->num_rows()>0){
					$this->app_model->updateData("product_detail",$up,$id);
					
				}else{
					$up['product_code']	=	$this->input->post('product_code_'.$i);
					$up['seq']					=	$Seq;
					$up['createdby'] 				= $user;
					$up['createdtime'] 			= $tgl;
					$up['companyarea'] 			= $loc;
					$this->app_model->insertData("product_detail",$up);
					
				}
			}
			echo 'Save Successful!';
		}else{
			header('location:'.base_url());
		}
	}
	
	public function DataDetail(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		
		if(!empty($cek)){
			$product_code = $this->input->post('product_code');
			$data = array();
			$text = "SELECT A.product_code,A.seq,A.kode_barang,B.nama_barang 
							 FROM product_detail A 
							 JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea 
							 WHERE A.product_code='$product_code' and A.companyarea='$loc'";
			$tabel = $this->app_model->manualQuery($text);
			$row = $tabel->num_rows();
			if($row>0){
				$temp=0;
				foreach($tabel->result() as $db){
					$data[$temp]['product_code']	= $db->product_code;
					$data[$temp]['sequence'] 			= $db->seq;
					$data[$temp]['hidebarang'] 		= $db->kode_barang;
					$data[$temp]['accessories'] 	= $db->nama_barang;
					$temp++;
				}
			}
			echo json_encode($data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Print Product";
			
			$product_code = $this->uri->segment(3);
			$coll_code 		= $this->uri->segment(4);
			$d['product_code'] 	= $product_code;
			$d['coll_code'] 		= $coll_code;
			$text = "SELECT coll_name from collection where coll_code='$coll_code'";
			$data = $this->app_model->manualQuery($text);
			if ($data->num_rows() > 0){
				foreach($data->result() as $dt){
					$d['coll_name'] = $dt->coll_name;
				}
			} else {
				$d['coll_name'] = '';
			}
			
			$text = "SELECT * FROM product where product_code='$product_code' and product_coll='$coll_code' and companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('product/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)) {
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$id = $this->uri->segment(3);
			$temp = explode(':', $id);
			$d['judul']="Detail Accessories - ".urldecode($temp[1]);
			
			//$d['brand']	= htmlentities($temp[3]);
			$d['code_cari'] = htmlentities($temp[3]);
			$d['coll_cari'] = htmlentities($temp[4]);
			$d['type_cari'] = htmlentities($temp[5]);
			$d['category_cari'] = htmlentities($temp[6]);
			$d['hal'] = htmlentities($temp[7]);
			$text = "SELECT A.product_code, A.product_name, A.product_coll, A.category, A.product_photo,B.coll_name FROM product A JOIN collection B ON B.coll_code=A.product_coll WHERE A.product_code='$temp[1]'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['product_code'] 	= $db->product_code;
					$d['product_name'] 	= htmlentities($db->product_name);
					$d['product_coll'] 	= $db->product_coll;
					$d['category']		  = $db->category;
					$d['product_photo'] = $db->product_photo;
					$d['coll_name']			= htmlentities($db->coll_name);
				}
			} else {
				$d['product_code'] 	= '';
				$d['product_name'] 	= '';
				$d['product_coll'] 	= '';
				$d['category']		  = '';
				$d['product_photo'] = '';
				$d['coll_name']			= '';
			}
			//$d['data'] = $this->app_model->manualQuery($text);
			
			//$text2= "SELECT * FROM brand ORDER BY brand_name";
			//$d['brand'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('product/detail', $d, true);		
			$this->load->view('home',$d);
		} else {
			header('location:'.base_url());
		} 
	}
	
}

/* End of file product.php */
/* Location: ./application/controllers/product.php */