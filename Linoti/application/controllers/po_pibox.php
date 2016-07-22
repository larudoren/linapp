<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po_pibox extends CI_Controller {
	/*
	function __construct()
	{
			parent::__construct();
			$this->load->helper('exportpdf_helper');     
	}
	*/
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
			
			$where = " WHERE A.companyarea='$loc' and A.pi<>'' and A.po IN (SELECT K.po FROM d_belibox K WHERE K.companyarea=A.companyarea)";
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

			
			$d['judul']="PO Box";
			
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
			
			$config['base_url'] 		= site_url() . '/po_pibox/index/';
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
			

			$text = "SELECT A.po, A.tglbeli, B.supplier_name, D.cust_name, C.pi_number,A.print_warning,A.print_front,A.print_symbol,A.tglload FROM h_beli A LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier LEFT OUTER JOIN pi C ON C.pi_number=A.pi AND C.pi_id=A.pi_id LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust $where 
					ORDER BY A.tglbeli DESC 
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('po_pibox/view', $d, true);		
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
			
			//$kode	= $this->app_model->MaxKodeTerima();
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
			
			$d['judul'] = "PO Box";
			
			$id = $this->uri->segment(3);
			if (empty($id)){
				$id = $this->session->userdata('mypopibox');
			}
			
			$this->session->unset_userdata('mypopibox');
			
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
									
			$d['content'] = $this->load->view('po_pibox/form', $d, true);		
			$this->load->view('home',$d);
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
			$idbeli = $this->input->post('idbeli');
			$packingremarks = $this->input->post('packingremarks');
			$boxremarks = $this->input->post('boxremarks');
			$kode = $this->input->post('updatepo');
			$qty = $this->input->post('updateqty');
			
			$head = site_url('po_pibox/edit/'.$kode);
			
			$text = "UPDATE d_belibox SET remarks_packing='$packingremarks', remarks='$boxremarks', qtybox='$qty', editedby='$user', editedtime='$tgl' WHERE idbeli='$idbeli' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
			echo "Update Successful!";
			echo "<meta http-equiv='refresh' content='0; url=".$head."'>";
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
			$this->app_model->manualQuery("DELETE FROM d_belibox WHERE po='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM h_beli WHERE po='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/po_pibox'>";			
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
			$add_session['mypopibox'] = $po;
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
			/*
			$text ="SELECT E.boxnumber
							FROM d_belibox A
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
              LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
              LEFT OUTER JOIN currency F ON F.currency_code=A.currency
							WHERE A.po='$id' AND A.companyarea='$loc'";
			
			$databox = $this->app_model->manualQuery($text);
			$row = $databox->num_rows();
			$d['box1'] = 0;
			$d['box2'] = 0;
			$d['box3'] = 0;
			
			if($row>0){
				foreach($databox->result() as $bx){
					if ($bx->boxnumber=='BOX 1'){
						if ($d['box1']==0){
							$d['box1']=1;
						}
					}else if($bx->boxnumber=='BOX 2'){
						if ($d['box2']==0){
							$d['box2']=1;
						}
					} else if ($bx->boxnumber=='BOX 3'){
						if ($d['box3']==0){
							$d['box3']=1;
						}
					}
				}
			} */
			
			$text = "SELECT A.idbeli,A.product_code,G.product_photo,H.coll_name,G.product_name,E.boxnumber, E.kdown, E.remarks_packing, E.remarks, E.lstyrofoam, E.wstyrofoam, E.hstyrofoam, E.linner, E.winner, E.hinner, E.lkarton, E.wkarton, E.hkarton, E.louter,E.wouter, 
														E.houter, E.volouter, A.qtybox, E.qtyperbox,E.typebox, F.currency_name, A.hrgbox, DATE_FORMAT(A.hrgdate,'%d-%b-%y') as hrgdate,A.remarks as poremarks,A.po
										 FROM d_belibox A
										 JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
										 JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
										 LEFT OUTER JOIN currency F ON F.currency_code=A.currency
										 LEFT OUTER JOIN product G ON G.product_code=A.product_code AND G.companyarea=A.companyarea
										 LEFT OUTER JOIN collection H ON H.coll_code=G.product_coll
										 WHERE A.po='$id' AND A.companyarea='$loc' ORDER BY A.product_code,E.boxnumber";
			
			$d['data']= $this->app_model->manualQuery($text); 
			
			$data = $this->app_model->manualQuery($text); 
			$all_idbeli='';
			if($data->num_rows() > 0){
				foreach($data->result() as $db) {
					$all_idbeli .= $db->idbeli.',';
				}
			}
			$d['all_idbeli'] = substr($all_idbeli,0,-1);
			$this->load->view('po_pibox/detail',$d);
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
			
			
			$id = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$d['saveas'] = $this->uri->segment(5);
			
			
			$text = "SELECT DATE_FORMAT(A.tglbeli,'%d %M %Y') as tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,D.cust_name,A.kode_supplier,DATE_FORMAT(A.tglload,'%d-%b-%y') as tglload
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN `pi` C ON C.pi_number=A.`pi` AND C.companyarea=A.companyarea
						LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust
						WHERE A.po='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db) {
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['tanggalbeli']	= $db->tglbeli;
					$d['customer']	= $db->cust_name;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= $db->supplier_address;
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					$d['po']	= $db->po;
					$d['pi']	= $db->pi;
					$d['tglload']	= $db->tglload;
				}
				if (!is_dir('asset/po/'.$db->supplier_name)) {
					mkdir('asset/po/'.$db->supplier_name, 0755, true);
				}
			} else {
				$d['kode_beli']		=$id;
				$d['tanggalbeli']	='';
				$d['customer']	='';
				$d['supplier']	='';
				$d['alamat']	='';
				$d['phone']	='';
				$d['fax']	='';
				$d['po']	='';
				$d['pi']	='';
				$d['tglload']	='';
			}
			
			$text ="SELECT DISTINCT(A.product_code),A.po,B.product_photo,C.coll_name,B.product_name,B.cm_length,B.cm_width,B.cm_height,A.companyarea
							FROM d_belibox A
							LEFT OUTER JOIN product B ON B.product_code=A.product_code AND B.companyarea=A.companyarea
							LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
							WHERE A.po='$id' AND A.companyarea='$loc'";
			$d['data'] = $this->app_model->manualQuery($text);
			$fp=fopen("databox.txt","w");
			fwrite($fp,$text);
			$text ="SELECT E.boxnumber
							FROM d_belibox A
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
              LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
              LEFT OUTER JOIN currency F ON F.currency_code=A.currency
							WHERE A.po='$id' AND A.companyarea='$loc'";
			//$d['datadetail']= $this->app_model->manualQuery($text);
			$databox = $this->app_model->manualQuery($text);
			
			$row = $databox->num_rows();
			$d['box1'] = 0;
			$d['box2'] = 0;
			$d['box3'] = 0;
			
			if($row>0){
				foreach($databox->result() as $bx){
					if ($bx->boxnumber=='BOX 1'){
						if ($d['box1']==0){
							$d['box1']=1;
						}
					}else if($bx->boxnumber=='BOX 2'){
						if ($d['box2']==0){
							$d['box2']=1;
						}
					} else if ($bx->boxnumber=='BOX 3'){
						if ($d['box3']==0){
							$d['box3']=1;
						}
					}
				}
			}
			
			if ($type=='email'){
				$text ="SELECT G.product_photo,A.product_code,G.product_name,A.qtybox,E.linner,E.winner,E.hinner,E.typebox,E.kdown,H.print_warning,H.print_front,H.print_symbol,F.currency_name,A.hrgbox,E.boxnumber,E.remarks_packing,A.remarks
								FROM d_belibox A
								LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
								LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
								LEFT OUTER JOIN currency F ON F.currency_code=A.currency
								LEFT OUTER JOIN product G ON G.product_code=A.product_code and G.companyarea=A.companyarea
								JOIN h_beli H ON H.po=A.po AND H.companyarea=A.companyarea
								WHERE A.po='$id' AND A.companyarea='$loc'";
				$d['data'] = $this->app_model->manualQuery($text);
				$this->load->view('po_pibox/cetakemail',$d);
			} else {
				$this->load->view('po_pibox/cetak',$d);
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function update_printing() {
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		
		if(!empty($cek)){
			$po = $this->input->post('UpdatePO');
			$warning = $this->input->post('warning');
			$front = $this->input->post('front');
			$symbol = $this->input->post('symbol');
			$tglload = $this->input->post('tglload');
			
			$head = site_url('po_pibox');
			
			$text = "UPDATE h_beli SET print_warning='$warning', print_front='$front', print_symbol='$symbol',tglload=str_to_date('$tglload','%Y-%m-%d'), editedby='$user', editedtime='$tgl' WHERE po='$po' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
			echo 'Update Successful!';
			echo "<meta http-equiv='refresh' content='0; url=".$head."'>";
		}
		else {
			header('location:'.base_url());
		}
	}
	
	/* Tambahan datatopdf */
	function pdf()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$tanggal = date('Y-m-d');
		$tanggalp = date('d M Y');
		
		if(!empty($cek)){
			
			$id = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$idbeli = $this->uri->segment(5);
			//$idbeli = substr($idbeli,1,-1);
			//$idbeliin = explode('-',$idbeli,0);
			$idbeli = str_replace("-","','",$idbeli);
			$d['saveas'] = $this->uri->segment(6);
			if ($d['saveas']=='saveas'){
				$saveas = TRUE;
			} else {
				$saveas = FALSE;
			}
			
			$text = "SELECT DATE_FORMAT(A.tglbeli,'%d %b %Y') as tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,D.cust_name,A.kode_supplier,DATE_FORMAT(A.tglload,'%d-%b-%y') as tglload
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN `pi` C ON C.pi_number=A.`pi` AND C.companyarea=A.companyarea
						LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust
						WHERE A.po='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db) {
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['tanggalbeli']	= $db->tglbeli;
					$d['customer']	= $db->cust_name;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= $db->supplier_address;
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					$d['po']	= $db->po;
					$d['pi']	= $db->pi;
					$d['tglload']	= $db->tglload;
				}
				if (!is_dir('asset/po/'.$db->supplier_name)) {
					mkdir('asset/po/'.$db->supplier_name, 0755, true);
				}
			} else {
				$d['kode_beli']		=$id;
				$d['tanggalbeli']	='';
				$d['customer']	='';
				$d['supplier']	='';
				$d['alamat']	='';
				$d['phone']	='';
				$d['fax']	='';
				$d['po']	='';
				$d['pi']	='';
				$d['tglload']	='';
			}
			
			$text ="SELECT DISTINCT(A.product_code),A.po,B.product_photo,C.coll_name,B.product_name,B.cm_length,B.cm_width,B.cm_height,A.companyarea
							FROM d_belibox A
							LEFT OUTER JOIN product B ON B.product_code=A.product_code AND B.companyarea=A.companyarea
							LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
							WHERE A.po='$id' AND A.companyarea='$loc' AND A.idbeli IN ('$idbeli')
							ORDER BY A.product_code";
			$d['data'] = $this->app_model->manualQuery($text);
			$text ="SELECT E.boxnumber,E.lshape
							FROM d_belibox A
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
              LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
              LEFT OUTER JOIN currency F ON F.currency_code=A.currency
							WHERE A.po='$id' AND A.companyarea='$loc'";
			$databox = $this->app_model->manualQuery($text);
			
			$row = $databox->num_rows();
			$d['box1'] = 0;
			$d['box2'] = 0;
			$d['box3'] = 0;
			$d['lshape1'] = 0;
			$d['lshape2'] = 0;
			$d['lshape3'] = 0;
			
			if($row>0){
				foreach($databox->result() as $bx){
					if ($bx->boxnumber=='BOX 1'){
						if ($d['box1']==0){
							$d['box1']=1;
						}
						if ($bx->lshape=='YES'){
							if ($d['lshape1']==0){
								$d['lshape1'] = 1;
							}
						}
					}else if($bx->boxnumber=='BOX 2'){
						if ($d['box2']==0){
							$d['box2']=1;
						}
						if ($bx->lshape=='YES'){
							if ($d['lshape2']==0){
								$d['lshape2'] = 1;
							}
						}
					} else if ($bx->boxnumber=='BOX 3'){
						if ($d['box3']==0){
							$d['box3']=1;
						}
						if ($bx->lshape=='YES'){
							if ($d['lshape3']==0){
								$d['lshape3'] = 1;
							}
						}
					}
				}
			}
			
			// load dompdf
			$this->load->helper('dompdf');
			//load content html
			if ($type=='email'){
				$text ="SELECT G.product_photo,A.product_code,G.product_name,A.qtybox,E.linner,E.winner,E.hinner,E.typebox,E.kdown,H.print_warning,H.print_front,H.print_symbol,F.currency_name,A.hrgbox,E.boxnumber,E.remarks_packing,A.remarks
								FROM d_belibox A
								LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
								LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
								LEFT OUTER JOIN currency F ON F.currency_code=A.currency
								LEFT OUTER JOIN product G ON G.product_code=A.product_code and G.companyarea=A.companyarea
								JOIN h_beli H ON H.po=A.po AND H.companyarea=A.companyarea
								WHERE A.po='$id' AND A.companyarea='$loc' AND A.idbeli IN ('$idbeli')
								ORDER BY A.product_code";
				$d['data'] = $this->app_model->manualQuery($text);
				$d['printdate'] = $tanggalp;
				$html = $this->load->view('po_pibox/email', $d, true);
				// create pdf using dompdf
				$filename = $id.'_'.$tanggal.'_email';
			} else if( $type=='draft'){
				$d['printdate'] = $tanggalp;
				$html = $this->load->view('po_pibox/cetak1', $d, true);
				$filename = $id.'_'.$tanggal;
			} else {
				$d['printdate'] = $tanggalp;
				$html = $this->load->view('po_pibox/cetak4', $d, true);
				$filename = $id.'_'.$tanggal;
			}
			
			$paper = 'A4';
			$orientation = 'landscape';
			pdf_create($html, $filename, $paper, $orientation, TRUE, $saveas, $d['supplier']);
			
			
		}else{
			header('location:'.base_url());
		}
	}
	
	function myfpdf(){
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$tanggal = date('Y-m-d');
		$tanggalp = date('d M Y');
		
		if(!empty($cek)){
			$id = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$d['saveas'] = $this->uri->segment(5);
			if ($d['saveas']=='saveas'){
				$saveas = TRUE;
			} else {
				$saveas = FALSE;
			}
			
			$text = "SELECT DATE_FORMAT(A.tglbeli,'%d %b %Y') as tglbeli, B.supplier_name, B.supplier_address, B.supplier_phone, B.supplier_fax, A.po,A.pi,D.cust_name,A.kode_supplier,DATE_FORMAT(A.tglload,'%d-%b-%y') as tglload
						FROM h_beli A
						LEFT OUTER JOIN supplier B ON B.supplier_code=A.kode_supplier
						LEFT OUTER JOIN `pi` C ON C.pi_number=A.`pi` AND C.companyarea=A.companyarea
						LEFT OUTER JOIN customer D ON D.cust_code=C.pi_cust
						WHERE A.po='$id'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db) {
					$d['tgl_beli']	= $this->app_model->tgl_indo($db->tglbeli);
					$d['tanggalbeli']	= $db->tglbeli;
					$d['customer']	= $db->cust_name;
					$d['supplier']	= $db->supplier_name;
					$d['alamat']	= $db->supplier_address;
					$d['phone']	= $db->supplier_phone;
					$d['fax']	= $db->supplier_fax;
					$d['po']	= $db->po;
					$d['pi']	= $db->pi;
					$d['tglload']	= $db->tglload;
				}
				if (!is_dir('asset/po/'.$db->supplier_name)) {
					mkdir('asset/po/'.$db->supplier_name, 0755, true);
				}
			} else {
				$d['kode_beli']		=$id;
				$d['tanggalbeli']	='';
				$d['customer']	='';
				$d['supplier']	='';
				$d['alamat']	='';
				$d['phone']	='';
				$d['fax']	='';
				$d['po']	='';
				$d['pi']	='';
				$d['tglload']	='';
			}
			
			$text ="SELECT DISTINCT(A.product_code),A.po,B.product_photo,C.coll_name,B.product_name,B.cm_length,B.cm_width,B.cm_height,A.companyarea
							FROM d_belibox A
							LEFT OUTER JOIN product B ON B.product_code=A.product_code AND B.companyarea=A.companyarea
							LEFT OUTER JOIN collection C ON C.coll_code=B.product_coll
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
							WHERE A.po='$id' AND A.companyarea='$loc'
							ORDER BY A.product_code";
			$d['data'] = $this->app_model->manualQuery($text);
			$text ="SELECT E.boxnumber,E.lshape
							FROM d_belibox A
							LEFT OUTER JOIN h_cotation D ON D.product_code=A.product_code AND D.companyarea=A.companyarea
              LEFT OUTER JOIN cotation_packing E ON E.id_cotation=D.id_cotation AND E.seq=A.seq_cot AND E.companyarea=D.companyarea
              LEFT OUTER JOIN currency F ON F.currency_code=A.currency
							WHERE A.po='$id' AND A.companyarea='$loc'";
			$databox = $this->app_model->manualQuery($text);
			
			$row = $databox->num_rows();
			$d['box1'] = 0;
			$d['box2'] = 0;
			$d['box3'] = 0;
			$d['lshape'] = 0;
			
			if($row>0){
				foreach($databox->result() as $bx){
					if ($bx->boxnumber=='BOX 1'){
						if ($d['box1']==0){
							$d['box1']=1;
						}
						if ($bx->lshape=='YES'){
							if ($d['lshape']==0){
								$d['lshape'] = 1;
							}
						}
					}else if($bx->boxnumber=='BOX 2'){
						if ($d['box2']==0){
							$d['box2']=1;
						}
					} else if ($bx->boxnumber=='BOX 3'){
						if ($d['box3']==0){
							$d['box3']=1;
						}
					}
				}
			}
			
			//define('FPDF_FONTPATH',$this->config->item('fonts_path'));

			// Load view “pdf_report” untuk menampilkan hasilnya
			$this->load->view('po_pibox/cetak3', $d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file po_pibox.php */
/* Location: ./application/controllers/po_pibox.php */