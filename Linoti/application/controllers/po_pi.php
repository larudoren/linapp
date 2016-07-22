<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po_pi extends CI_Controller {
	
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
			
			$where = " WHERE A.companyarea='$loc' and A.pi<>'' and A.po IN (SELECT K.po FROM d_beli K WHERE K.companyarea=A.companyarea)";
			if(!empty($cari)){
				$where .= " AND B.supplier_name LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND A.tglbeli='$tgl'";
			}
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="PO";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.po,A.tglbeli FROM h_beli A JOIN supplier B ON B.supplier_code=A.kode_supplier $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/po_pi/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment']	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT A.po, A.tglbeli, B.supplier_name,A.tgldeadline FROM h_beli A JOIN supplier B ON B.supplier_code=A.kode_supplier $where 
					ORDER BY A.tglbeli DESC, A.pi_id DESC
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
	
			$d['content'] = $this->load->view('po_pi/view', $d, true);		
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
			$d['myheader'] 				= $myheader;
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			$d['judul']="PO";
			
			$tgl	= date('d-m-Y');
			
			$d['tglbeli']	= $tgl;
			$d['kode_supplier']		= '';
			$d['pi']					= '';
			$d['po']					= '';
			$d['fstatus']					= 'Add';
			
			$text = "SELECT * FROM supplier";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('po_pi/form', $d, true);		
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
			$d['myheader'] 				= $myheader;
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] = "PO";
			
			$id = $this->uri->segment(3);
			if (empty($id)){
				$id = $this->session->userdata('mypopi');
			}
			
			$this->session->unset_userdata('mypopi');
			
			$text = "SELECT A.tglbeli, A.po, A.pi, A.kode_supplier,B.supplier_name FROM h_beli A JOIN supplier B ON B.supplier_code=A.kode_supplier WHERE A.po='$id' and A.companyarea";
			
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['tglbeli']	= $this->app_model->tgl_str($db->tglbeli);
					$d['po']					= $db->po;
					$d['pi']					= $db->pi;
					$d['kode_supplier']					= $db->kode_supplier;
					$d['supplier_name']					= $db->supplier_name;
				}
			}else{
					$d['tglbeli']	= '';
					$d['po']					= '';
					$d['pi']					= '';
					$d['kode_supplier']	= '';
					$d['supplier_name']		= '';
			}
			$d['fstatus'] = 'Edit';
			$d['no_edit'] = 'readonly="readonly"';
									
			$d['content'] = $this->load->view('po_pi/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function update_deadline() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
			$po = $this->input->post('UpdatePO');
			$tgldeadline = $this->input->post('tgldeadline');
			
			$head = site_url('po_pi');
			
			$text = "UPDATE h_beli SET tgldeadline=str_to_date('$tgldeadline','%Y-%m-%d'),editedby='$user',editedtime='$tgl' WHERE po='$po' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
			echo "Update Successful!";
		}
		else {
			header('location:'.base_url());
		}
	}
	
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			
			$this->app_model->manualQuery("DELETE FROM d_beli WHERE po='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM h_beli WHERE po='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/po_pi'>";			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			
			$po = $this->uri->segment(3);
			$kode_barang = $this->uri->segment(4);
			$add_session['mypopi'] = $po;
			$jml = $this->app_model->manualQuery("SELECT count(*) as jml from d_beli where po='$po'");
			$jum;
			foreach($jml->result() as $rs){
				$jum = $rs->jml;
			}
			if ($jum > 1){
				$this->app_model->manualQuery("DELETE FROM d_beli WHERE po='$po' AND kode_barang='$kode_barang' and companyarea='$loc'");
			}
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
				//$up['po']= $this->input->post('po');
				//$po = $up['po'];
				/*
				$qq = "SELECT * from h_beli WHERE po='$po' and companyarea='$loc'";
				$qu = $this->app_model->manualQuery($qq);
				$qo = $qu->row(); */
				
				if (!empty($this->input->post('po'))){
					$po = urldecode($this->input->post('po'));
				} else {
					$po = $this->app_model->GeneratePONumber($this->input->post('tglbeli'),$this->input->post('kode_supplier'));
				}
				
				$text = "SELECT pi_cust FROM `pi` WHERE pi_number='".$this->input->post('pi')."'";
				$datacust = $this->app_model->manualQuery($text);
				$customer_code ='';
				foreach ($datacust->result() as $dc){
					$customer_code = $dc->pi_cust;
				}
				
				if ($po!=''){
					$uc['po']	= $po;
					$uc['tglbeli']				= $this->app_model->tgl_sql($this->input->post('tglbeli'));
					$uc['kode_supplier']	= $this->input->post('kode_supplier');
					$uc['pi']							= $this->input->post('pi');
					$uc['kode_customer']	= $customer_code;
					$uc['username']				= $this->session->userdata('username');
					$uc['editedby']				= $user;
					$uc['editedtime']			= $tgl;
					
					
					$id['po']	= $po;
					$id['kode_supplier']	= $this->input->post('supplier');
					$id['pi']	= $this->input->post('pi');
					$id['companyarea']	= $loc;
					
					$data = $this->app_model->getSelectedData("h_beli",$id);
					if ($datacust->num_rows()>0){
						if($data->num_rows()>0){
							$this->app_model->updateData("h_beli",$uc,$id);
							echo 'Update data Sukses';
						} else {
							//$query = "SELECT d_beli.kode_barang, d_beli.jmlbeli, d_beli.qty_order, d_beli.currency, d_beli.hargabeli, d_beli.status, d_beli.remarks
							//		FROM h_beli
							//		JOIN d_beli ON d_beli.po=h_beli.po and d_beli.companyarea=h_beli.companyarea
							//		WHERE h_beli.po='$po' and h_beli.companyarea='$loc'";
							
							$query1 = " SELECT A.product_code, A.quantity,B.pi_id FROM d_pi A JOIN `pi` B ON B.pi_id=A.pi_id WHERE B.pi_number='".$uc['pi']."'";
							$datapi = $this->app_model->manualQuery($query1);
							$temp=0;
							$jml=0;
							$tkode_barang='';
							foreach($datapi->result() as $dp){
								$query = "SELECT A.kode_barang,B.quantity,D.currency,D.harga
													FROM barang A 
													JOIN cotation_accessories B ON B.material=A.kode_barang 
													JOIN h_cotation C ON C.id_cotation=B.id_cotation 
													JOIN d_barangsup D ON D.kode_barang=A.kode_barang
													WHERE C.product_code='".$dp->product_code."' and D.supplier_code='".$uc['kode_supplier']."' AND A.kode_barang IN (SELECT kode_barang from d_pipo where pi_id='".$dp->pi_id."' and product_code='".$dp->product_code."')";
								
								
								$insert = $this->app_model->manualQuery($query);
								foreach($insert->result() as $dq) {
									$jmlbeli = $dq->quantity * $dp->quantity;
									
									if (strpos($tkode_barang,$dq->kode_barang) === false){
										$ud['po'] 					= $po;
										$ud['kode_barang'] 	= $dq->kode_barang;
										$ud['jmlbeli'] 			= $jmlbeli;
										$ud['currency'] 		= $dq->currency;
										$ud['hargabeli'] 		= $dq->harga;
										$ud['createdby'] 		= $user;
										$ud['createdtime'] 	= $tgl;
										$ud['editedby'] 		= $user;
										$ud['editedtime'] 	= $tgl;
										$ud['companyarea'] 	= $loc;
										
										$this->app_model->insertData("d_beli",$ud);
										
										$tkode_barang = $tkode_barang.$dq->kode_barang.',';
									} else {
										$qupdate = "UPDATE d_beli SET jmlbeli=jmlbeli+$jmlbeli WHERE po='$po' and kode_barang='".$dq->kode_barang."'";
										$this->app_model->manualQuery($qupdate);
									}
									
									$jml++;
									
									/*
									$ud['kode_terima'] 	= $uc['kode_terima'];
									$ud['kode_barang'] 	= $dq->kode_barang;
									$ud['jml_terima'] 	= $dq->qty_order;
									$ud['currency'] 		= $dq->currency;
									$ud['harga_terima'] = $dq->hargabeli;
									$ud['status'] 			= $dq->status;
									$ud['remarks'] 			= $dq->remarks;
									$ud['createdby'] 		= $user;
									$ud['createdtime'] 	= $tgl;
									$ud['editedby'] 		= $user;
									$ud['editedtime'] 	= $tgl;
									$ud['companyarea'] 	= $loc;
									
									$this->app_model->insertData("d_terima",$ud);
									*/
								}
							}
							if ($jml>0){
								$uc['createdby']		= $user;
								$uc['createdtime']	= $tgl;
								$uc['companyarea']	= $loc;
								$this->app_model->insertData("h_beli",$uc);
								echo 'Save Successfull!,'.$po;;
							} else {
								echo 'Failed Save!';
							}
						}
					}
				} else {
					echo 'Failed Save! PO is empty or not created!';
				}
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
			$text = "SELECT A.po, B.kode_barang, B.kode_barang_spc, B.nama_barang, IF(B.turunan!='',K.unit_name,C.unit_name) as unit_name, D.currency_name, A.jmlbeli, A.hargabeli, A.qty_order, A.datein, A.qty_in, A.remarks, A.temp_stock,
											E.finishing,B.size_length,B.size_width,B.size_height,F.simbol as size_length_unit,B.size_diameter,G.simbol as size_diameter_unit,B.size_diameterin,H.simbol as size_diameterin_unit,
											B.size_thread,B.size_density, I.simbol as size_density_unit,L.unit_name as useper,
											(SELECT R.min_qty FROM d_barangsup R WHERE R.kode_barang=A.kode_barang ORDER BY R.tgl DESC LIMIT 1) as min_qty
					FROM d_beli A
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
					LEFT OUTER JOIN unit C ON C.unit_code=B.satuan				
					JOIN currency D ON D.currency_code=A.currency
					LEFT OUTER JOIN finishing E ON E.finishing_id=B.finishing
					LEFT OUTER JOIN t_unit_ukuran F ON F.unit_ukuran_id=B.size_length_unit
					LEFT OUTER JOIN t_unit_ukuran G ON G.unit_ukuran_id=B.size_diameter_unit
					LEFT OUTER JOIN t_unit_ukuran H ON H.unit_ukuran_id=B.size_diameterin_unit
					LEFT OUTER JOIN t_unit_ukuran I ON I.unit_ukuran_id=B.size_density_unit
					LEFT OUTER JOIN barang J ON J.kode_barang=B.turunan and J.companyarea=B.companyarea
					LEFT OUTER JOIN unit K ON K.unit_code=J.satuan
					LEFT OUTER JOIN unit L ON L.unit_code=B.useper
					WHERE A.po='$id' and A.companyarea='$loc'";
			
			$d['data']= $this->app_model->manualQuery($text);
			
			$this->load->view('po_pi/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			$this->load->helper('text');
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Faktur Penerimaan";
			
			/*
			$id = $this->uri->segment(3);
			$text = "SELECT h_terima.kode_terima, h_terima.tgl_terima, supplier.supplier_name, supplier.supplier_address, supplier.supplier_phone, supplier.supplier_fax, h_terima.po
						FROM h_terima
						LEFT OUTER JOIN supplier ON supplier.supplier_code=h_terima.supplier and supplier.companyarea=h_terima.companyarea
						WHERE h_terima.kode_terima='$id' and h_terima.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				$d['kode_beli']	= $id;
				foreach($data->result() as $db) {
					$d['kode_terima']	= $id;
					$d['tgl_terima']	= $this->app_model->tgl_indo($db->tgl_terima);
					$d['tanggalterima']	= $db->tgl_terima;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= urldecode($db->supplier_address);
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					$d['mobile']	= $db->supplier_mobile;
					$d['po']	= $db->po;
				}
			}else{
					$d['kode_terima']		=$id;
					$d['tgl_terima']	='';
					$d['tanggalterima']	='';
					$d['supplier']	='';
					$d['alamat']	='';
					$d['phone']	='';
					$d['fax']	='';
					$d['mobile']	='';
					$d['po']	='';
			}
			
			$text = "SELECT d_terima.kode_terima, d_terima.kode_barang, barang.kode_barang_spc, barang.nama_barang, unit.unit_name, d_terima.harga_terima, d_terima.jml_terima, d_terima.status, d_terima.remarks
					FROM d_terima
					JOIN barang ON d_terima.kode_barang=barang.kode_barang and barang.companyarea=d_terima.companyarea
					JOIN unit ON unit.unit_code=barang.satuan
					JOIN currency ON currency.currency_code=d_terima.currency
					WHERE d_terima.kode_terima='$id' and d_terima.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
			*/
			
			
			$id = $this->uri->segment(3);
			$d['saveas'] = $this->uri->segment(4);
			$text = "SELECT A.tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,D.cust_name,A.kode_supplier,A.tgldeadline
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN `pi` C ON C.pi_id=A.pi_id AND C.companyarea=A.companyarea
						LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust
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
					$d['tgldeadline']	= $this->app_model->tgl_indo($db->tgldeadline);
					if($db->tgldeadline=='0000-00-00'){
						$d['tgldeadline']	= '-';
					}
					
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
					$d['tanggalbeli']	='';
					$d['customer']	='';
					$d['supplier']	='';
					$d['alamat']	='';
					$d['phone']	='';
					$d['fax']	='';
					$d['tgldeadline']	='';
					$d['po']	='';
					$d['pi']	='';
			}
			
			$text = "SELECT A.kode_barang, B.kode_barang_spc, B.nama_barang, IF(B.turunan!='',O.unit_name,C.unit_name) as unit_name, A.status, A.jmlbeli, A.remarks,A.qty_order,A.temp_stock,
											B.size_length, B.size_width, B.size_height, E.simbol as size_length_unit, B.size_weight, F.simbol as size_weight_unit, B.size_volume ,G.simbol as size_volume_unit,
											B.size_area, H.simbol as size_area_unit, B.size_density, I.simbol as size_density_unit, B.size_diameter, J.simbol as size_diameter_unit, B.size_diameterin,
											K.simbol as size_diameterin_unit, B.size_thread, L.finishing, M.merk ,A.hargabeli /* (SELECT R.harga FROM d_barangsup R WHERE R.kode_barang=A.kode_barang and R.tgl <= str_to_date('".$d['tanggalbeli']."','%Y-%m-%d') ORDER BY R.tgl DESC LIMIT 1) as hargabeli */,
											(SELECT S.min_qty FROM d_barangsup S WHERE S.kode_barang=A.kode_barang and S.tgl <= str_to_date('".$d['tanggalbeli']."','%Y-%m-%d') ORDER BY S.tgl DESC LIMIT 1) as min_qty, 
											/* (SELECT U.currency_name FROM d_barangsup T LEFT OUTER JOIN currency U ON U.currency_code=T.currency WHERE T.kode_barang=A.kode_barang and T.tgl <= str_to_date('".$d['tanggalbeli']."','%Y-%m-%d') ORDER BY T.tgl DESC LIMIT 1) as currency_name */
											D.currency_name,P.unit_name as useper
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
					LEFT OUTER JOIN barang N ON N.kode_barang=B.turunan AND N.companyarea=B.companyarea
					LEFT OUTER JOIN unit O ON O.unit_code=N.satuan
					LEFT OUTER JOIN unit P ON P.unit_code=B.useper
					WHERE A.po='$id'";

			$d['data']= $this->app_model->manualQuery($text);
			
			$this->load->view('po_pi/cetak',$d);
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
			$po = $this->input->post('UpdatePO');
			$kode_barang = $this->input->post('UpdateKodeBarang');
			$qty_order = $this->input->post('UpdateQtyOrder');
			$datein = $this->input->post('UpdateDateIn');
			$qty_in = $this->input->post('UpdateQtyIn');
			$remarks = $this->input->post('UpdateRemarks');
			$stock = $this->input->post('UpdateStock');
			
			$head = site_url('po_pi/edit/'.$po);
			
			$text = "UPDATE d_beli SET qty_order='$qty_order', editedby='$user', editedtime='$tgl', datein=str_to_date('$datein','%Y-%m-%d'), qty_in='$qty_in', remarks='$remarks', temp_stock='$stock' WHERE po='$po' AND kode_barang='$kode_barang' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
			echo "<meta http-equiv='refresh' content='0; url=".$head."'>";
		}
		else {
			header('location:'.base_url());
		}
	}
	
}

/* End of file po_pi.php */
/* Location: ./application/controllers/po_pi.php */