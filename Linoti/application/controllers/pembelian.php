<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
		
			$cari = $this->input->post('txt_cari');
			$tgl = $this->app_model->tgl_sql($this->input->post('cari_tgl'));
			
			$where = " WHERE A.po<>'' AND A.companyarea='$loc'";
			if(!empty($cari)){
				$where .= " AND A.po LIKE '%$cari%' OR A.kode_supplier LIKE '%$cari%'";
			} else {
				
			}
			if(!empty($tgl)){
				$where .= " AND A.tglbeli='$tgl'";
			} else {
				
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			//$d['instansi']= $this->config->item('instansi_linoti');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Purchase";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.*,B.supplier_name,C.cust_name FROM h_beli A LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier and B.companyarea=A.companyarea LEFT OUTER JOIN customer C ON C.cust_code=A.kode_customer and C.companyarea=A.companyarea $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/pembelian/index/';
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
			

			$text = "SELECT A.*,B.supplier_name,C.cust_name FROM h_beli A LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier and B.companyarea=A.companyarea LEFT OUTER JOIN customer C ON C.cust_code=A.kode_customer and C.companyarea=A.companyarea $where 
					ORDER BY A.tglbeli DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('pembelian/view', $d, true);		
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

			$d['judul']="Add Purchase";
			
			$tgl	= date('d-m-Y');
			
			$d['po']	='';
			$d['tgl_beli']	= $tgl;
			$d['departemen']= '';
			$d['supplier']	='';
			$d['customer']	='';
			$d['currency']	='';
			$d['pi']	='';
			
			$text = "SELECT * FROM supplier ORDER BY supplier_name ASC";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$text3 = "SELECT * FROM customer WHERE cust_code <>'000' ORDER BY cust_name ASC";
			$d['l_cust'] = $this->app_model->manualQuery($text3);
			
			$d['content'] = $this->load->view('pembelian/form', $d, true);		
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
			
			$d['judul'] = "Edit Purchase";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_beli WHERE po='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['po']	= urldecode($id);
					$d['tgl_beli']	= $this->app_model->tgl_str($db->tglbeli);
					$d['supplier']	= $db->kode_supplier;
					$d['customer']	= $db->kode_customer;
					$d['pi']	= $db->pi;
				}
			}else{
					$d['po']	=$id;
					$d['tgl_beli']	='';
					$d['supplier']	='';
					$d['customer']	='';
					$d['pi']	='';
			}
			
			$text = "SELECT * FROM supplier";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM currency";
			$d['l_curr'] = $this->app_model->manualQuery($text2);
			
			$text3 = "SELECT * FROM customer WHERE cust_code<>'000'";
			$d['l_cust'] = $this->app_model->manualQuery($text3);
			
			$d['edit'] = "edit";
									
			$d['content'] = $this->load->view('pembelian/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM d_beli WHERE po='$id'");
			$this->app_model->manualQuery("DELETE FROM h_beli WHERE po='$id'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pembelian'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$kode = $this->uri->segment(4);
			$text = "DELETE FROM d_beli WHERE po='$id' AND kode_barang='$kode'";
			$this->app_model->manualQuery($text);
			$this->edit();
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
				if (!empty($this->input->post('po'))){
					$po = urldecode($this->input->post('po'));
				} else {
					$po = $this->app_model->GeneratePONumber($this->input->post('tgl'),$this->input->post('supplier'));
				}
				
				if ($po!=''){
					$up['tglbeli']			= $this->app_model->tgl_sql($this->input->post('tgl'));
					$up['kode_supplier']= $this->input->post('supplier');
					$up['kode_customer']= $this->input->post('customer');
					$up['po']						= $po;
					$up['username']			= $this->session->userdata('username');
					$up['editedby']			= $user;
					$up['editedtime']		= $tgl;
					
					$ud['po'] 					= $po;
					$ud['kode_barang'] 	= $this->input->post('kode_brg');
					$ud['jmlbeli'] 			= $this->input->post('jml');
					$ud['currency'] 		= $this->input->post('currency');
					$ud['hargabeli'] 		= $this->input->post('harga');
					$ud['status'] 			= $this->input->post('status');
					$ud['remarks'] 			= $this->input->post('remarks');
					$ud['editedby']			= $user;
					$ud['editedtime']		= $tgl;
					
					$id['po']						= $po;
					$id['companyarea']	= $loc;
					
					$id_d['po']					= $po;
					$id_d['kode_barang']= $this->input->post('kode_brg');
					$id_d['companyarea']= $loc;
					
					$data = $this->app_model->getSelectedData("h_beli",$id);
					if($data->num_rows()>0){
						//$id['kode_supplier'] = $this->input->post('supplier');
						//$id['kode_customer'] = $this->input->post('customer');
						$ckdata = $this->app_model->getSelectedData("h_beli",$id);
						//if ($ckdata->num_rows() > 0){
							$this->app_model->updateData("h_beli",$up,$id);
						//}
							$data = $this->app_model->getSelectedData("d_beli",$id_d);
							if($data->num_rows()>0){
								$this->app_model->updateData("d_beli",$ud,$id_d);
							}else{
								$ud['createdby']= $user;
								$ud['createdtime']= $tgl;
								$ud['companyarea']= $loc;
								$this->app_model->insertData("d_beli",$ud);
							}
						echo 'Save Successful,'.$po;
					}else{
						$up['createdby']= $user;
						$up['createdtime']= $tgl;
						$up['companyarea']= $loc;
						$ud['createdby']= $user;
						$ud['createdtime']= $tgl;
						$ud['companyarea']= $loc;
						$this->app_model->insertData("h_beli",$up);
						$this->app_model->insertData("d_beli",$ud);
						echo 'Save Successful,'.$po;		
					}
				} else {
					echo 'Save Failed,'.$po;
				}
		}else{
				header('location:'.base_url());
		}
	
	}
	
	public function DataDetail()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$id = urldecode($this->input->post('kode'));
			$text = "SELECT A.po, A.kode_barang, B.kode_barang_spc, B.nama_barang, B.nama_barang,  C.unit_name, E.dept_name, A.jmlbeli, D.currency_name, A.hargabeli,
											A.qty_order,B.min_qty,A.remarks,F.finishing,B.size_length,B.size_width,B.size_height, G.simbol as size_length_unit, B.size_weight, H.simbol as size_weight_unit,
											B.size_area, I.simbol as size_area_unit, B.size_diameter, J.simbol as size_diameter_unit, B.size_diameterin, K.simbol as size_diameterin_unit, B.thread
					FROM d_beli A
					JOIN barang  B ON A.kode_barang=B.kode_barang
					JOIN unit C ON B.satuan=C.unit_code
					JOIN currency D ON D.currency_code=A.currency
					LEFT OUTER JOIN departemen_fact E ON E.dept_code=B.departemen
					LEFT OUTER JOIN finishing F ON F.finishing_id=B.finishing
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=B.size_length_unit
					LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=B.size_weight_unit
					LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=B.size_area_unit
					LEFT OUTER JOIN t_unit_ukuran J ON J.unit_ukuran_id=B.size_diameter_unit
					LEFT OUTER JOIN t_unit_ukuran K ON K.unit_ukuran_id=B.size_diameterin_unit
					WHERE A.po='$id'";
			
			$d['data']= $this->app_model->manualQuery($text);
			$this->load->view('pembelian/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function update_item() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
			$jml = $this->input->post('qty_order');
			$temp = explode('/', $this->input->post('kode'));
			$kode = $temp[0];
			$brg  = $temp[1];
			
			$head = site_url('pembelian/edit/'.$kode);
			
			$text = "UPDATE d_beli SET qty_order='$jml',editedby='$user',editedtime='$tgl' WHERE po='$kode' AND kode_barang='$brg' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
			echo "<meta http-equiv='refresh' content='0; url=".$head."'>";
		}
		else {
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Faktur Pembelian";
			
			$id = $this->uri->segment(3);
			$d['saveas'] = $this->uri->segment(4);
			$text = "SELECT A.tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,C.cust_name
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN customer C ON C.cust_code=A.kode_customer
						WHERE A.po='$id'";
			
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				$d['kode_beli']	= $id;
				foreach($data->result() as $db) {
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['tanggalbeli']	= $db->tglbeli;
					$d['customer']	= $db->cust_name;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= $db->supplier_address;
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					//$d['mobile']	= $db->supplier_mobile;
					$d['po']	= $db->po;
					$d['pi']	= $db->pi;
				}
				if ($d['saveas']=='saveas'){
					if (!is_dir('asset/po/'.$db->supplier_name)) {
						mkdir('asset/po/'.$db->supplier_name, 0755, true);
					}
				}
			}else{
					$d['kode_beli']		=$id;
					$d['tgl_beli']	='';
					$d['customer']	='';
					$d['supplier']	='';
					$d['alamat']	='';
					$d['phone']	='';
					$d['fax']	='';
					//$d['mobile']	='';
					$d['po']	='';
					$d['pi']	='';
			}
			
			$text = "SELECT A.kode_barang, B.kode_barang_spc, B.nama_barang, C.unit_name, A.status, D.currency_name, A.hargabeli, A.jmlbeli, A.remarks,A.qty_order, B.min_qty,
											B.size_length, B.size_width, B.size_height, E.simbol as size_length_unit, B.size_weight, F.simbol as size_weight_unit, B.size_volume ,G.simbol as size_volume_unit,
											B.size_area, H.simbol as size_area_unit, B.size_density, I.simbol as size_density_unit, B.size_diameter, J.simbol as size_diameter_unit, B.size_diameterin,
											K.simbol as size_diameterin_unit, B.size_thread, L.finishing, M.merk
					FROM d_beli A
					JOIN barang B ON A.kode_barang=B.kode_barang
					JOIN unit C ON C.unit_code=B.satuan
					JOIN currency D ON D.currency_code=A.currency
					LEFT OUTER JOIN t_unit_ukuran E ON E.unit_ukuran_id=B.size_length_unit
					LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=B.size_weight_unit
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=B.size_volume_unit
					LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=B.size_area_unit
					LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=B.size_density_unit
					LEFT OUTER JOIN t_unit_ukuran J ON J.unit_ukuran_id=B.size_diameter_unit
					LEFT OUTER JOIN t_unit_ukuran K ON K.unit_ukuran_id=B.size_diameterin_unit
					LEFT OUTER JOIN finishing L ON L.finishing_id=B.finishing
					LEFT OUTER JOIN merk M ON M.merk_id=B.merek
					WHERE A.po='$id'";

			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('pembelian/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function clear() {
		$cek = $this->session->userdata('logged_in');
		if($cek) {
			$this->session->unset_userdata('cari');
			redirect('pembelian');
		} else {
			header('location:'.base_url());
		}
	}
	
}

/* End of file pembelian.php */
/* Location: ./application/controllers/pembelian.php */