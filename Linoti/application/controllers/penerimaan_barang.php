<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan_barang extends CI_Controller {
	
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
			
			$where = " WHERE A.companyarea='$loc' and A.kode_terima<>''";
			if(!empty($cari)){
				$where .= " AND A.kode_terima LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND A.tgl_terima='$tgl'";
			}
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']="Receiving Goods";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.* FROM h_terima A $where ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/penerimaan_barang/index/';
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
			

			$text = "SELECT A.*,B.supplier_name FROM h_terima A LEFT OUTER JOIN supplier B ON B.supplier_code=A.supplier $where 
					ORDER BY A.tgl_terima DESC 
					LIMIT $limit OFFSET $offset";
			
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('penerimaan_barang/view', $d, true);		
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

			$d['judul']="Receiving Goods";
			
			//$kode	= $this->app_model->MaxKodeTerima();
			$tgl	= date('d-m-Y');
			
			$d['kode_terima']	= '';
			$d['tgl_terima']	= $tgl;
			$d['departemen']	= '';
			$d['supplier']		= '';
			$d['po']					= '';
			$d['remarks']			= '';
			
			$text = "SELECT * FROM supplier";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('penerimaan_barang/form', $d, true);		
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
			
			$d['judul'] = "Receiving Goods";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_terima WHERE kode_terima='$id' and companyarea";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_terima']	= $id;
					$d['tgl_terima']	= $this->app_model->tgl_str($db->tgl_terima);
					$d['po']					= $db->po;
					$d['remarks']			= $db->remarks;
				}
			}else{
					$d['kode_terima']	= $id;
					$d['tgl_terima']	= '';
					$d['po']					= '';
					$d['remarks']			= '';
			}
			
			$d['no_edit'] = 'readonly="readonly"';
									
			$d['content'] = $this->load->view('penerimaan_barang/form', $d, true);		
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
			$jml = $this->input->post('UpdateQtyReceive');
			$kode = $this->input->post('UpdateKodeTerima');
			$brg  = $this->input->post('UpdateKodeBarang');
			$remarks  = $this->input->post('UpdateRemarks');
			
			$head = site_url('penerimaan_barang/edit/'.$kode);
			
			$text = "UPDATE d_terima SET jml_terima='$jml',remarks='$remarks',editedby='$user',editedtime='$tgl' WHERE kode_terima='$kode' AND kode_barang='$brg' and companyarea='$loc'";
			$this->app_model->manualQuery($text);
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
			$this->app_model->manualQuery("DELETE FROM d_terima WHERE kode_terima='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM h_terima WHERE kode_terima='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/penerimaan_barang'>";			
		}else{
			header('location:'.base_url());
		}
	}
	public function hapus_detail()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$id = $this->uri->segment(3);
			$kode = $this->uri->segment(4);
			$this->app_model->manualQuery("DELETE FROM d_terima WHERE kode_terima='$id' AND kode_barang='$kode' and companyarea='$loc'");
			
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
				$up['po']= $this->input->post('po');
				$po = $up['po'];
				
				if (empty($this->input->post('kode_terima'))){
					$kode	= $this->app_model->MaxKodeTerima();
				} else {
					$kode = $this->input->post('kode_terima');
				}
				
				$qq = "SELECT * from h_beli WHERE po='$po' and companyarea='$loc'";

				$qu = $this->app_model->manualQuery($qq);
				$qo='';
				foreach($qu->result() as $tr){
					$qo = $tr->kode_supplier;
				}
				
				if ($qo!=''){
					$uc['kode_terima']	= $kode;
					$uc['tgl_terima']		= $this->app_model->tgl_sql($this->input->post('tgl'));
					$uc['supplier']			= $qo;
					$uc['po']						= $this->input->post('po');
					$uc['remarks']			= $this->input->post('remarks');
					$uc['username']			= $user;
					$uc['editedby']			= $user;
					$uc['editedtime']		= $tgl;
					
					
					$id['kode_terima']	= $kode;
					$id['companyarea']	= $loc;
					
					$data = $this->app_model->getSelectedData("h_terima",$id);
					if($data->num_rows()>0){
						$this->app_model->updateData("h_terima",$uc,$id);
						//echo 'Update data Sukses';
					} else {
						$query = "SELECT B.kode_barang, B.qty_order, B.currency, B.hargabeli, B.status, B.remarks, (SELECT SUM(R.jml_terima) as jml FROM d_terima R JOIN h_terima S ON S.kode_terima=R.kode_terima WHERE R.kode_barang=b.kode_barang and S.po='$po') as jml
								FROM h_beli A
								JOIN d_beli B ON B.po=A.po and B.companyarea=A.companyarea
								WHERE A.po='$po' and A.companyarea='$loc'";
						
						$insert = $this->app_model->manualQuery($query);
						$jml_order=0;
						$jml_sudah=0;
						foreach($insert->result() as $dq) {
							$ud['kode_terima'] 	= $uc['kode_terima'];
							$ud['kode_barang'] 	= $dq->kode_barang;
							$ud['jml_terima'] 	= $dq->qty_order-$dq->jml;
							$ud['currency'] 		= $dq->currency;
							$ud['harga_terima'] = $dq->hargabeli;
							$ud['status'] 			= $dq->status;
							$ud['remarks'] 			= $dq->remarks;
							$ud['createdby'] 		= $user;
							$ud['createdtime'] 	= $tgl;
							$ud['editedby'] 		= $user;
							$ud['editedtime'] 	= $tgl;
							$ud['companyarea'] 	= $loc;
							
							if ($dq->qty_order > 0){
								//if (!empty($dq->jml) && $dq->jml < $dq->qty_order){
									$this->app_model->insertData("d_terima",$ud);
									$jml_order++;
								//} else {
								//	$jml_sudah++;
								//}
							}
						}
						if ($jml_order > 0){
							$uc['createdby']		= $user;
							$uc['createdtime']	= $tgl;
							$uc['companyarea']	= $loc;
							$this->app_model->insertData("h_terima",$uc);
							echo 'Save Successful!,'.$kode;
						} else {
							//if ($jml_sudah > 0){
								echo 'Failed Save! This could be caused by the PO items already received AND/OR Quantity Order is Zero of Value!';
							//} else {
							//	echo 'Failed Save! Quantity Order is Zero for this PO!';
							//}
						}
					}
				} else {
					echo 'Failed Save! Po. No not exists! ';
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
			$text = "SELECT A.kode_terima, A.kode_barang, B.kode_barang_spc, B.nama_barang, B.nama_barang,  C.unit_name, D.currency_name, A.jml_terima, A.harga_terima, B.size_length, B.size_width,
											B.size_height, E.simbol as size_length_unit, B.size_weight, F.simbol as size_weight_unit, B.size_volume, G.simbol as size_volume_unit, B.size_area, H.simbol as size_area_unit,
											B.size_density, I.simbol as size_density_unit, B.size_diameter, J.simbol as size_diameter_unit, B.size_diameterin, K.simbol as size_diameterin_unit, B.size_thread,
											L.finishing, A.remarks, (SELECT SUM(R.jml_terima) as jml FROM d_terima R JOIN h_terima S ON S.kode_terima=R.kode_terima WHERE S.po=AA.po and R.kode_barang=A.kode_barang and R.kode_terima!='$id') as jml,
											(SELECT T.qty_order FROM d_beli T WHERE T.po=AA.po and T.kode_barang=A.kode_barang) as qty_order
					FROM d_terima A
					JOIN h_terima AA ON AA.kode_terima=A.kode_terima
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
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
					WHERE A.kode_terima='$id' and A.companyarea='$loc'";
			
			$d['data']= $this->app_model->manualQuery($text);
			
			$this->load->view('penerimaan_barang/detail',$d);
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
			
			$text = "SELECT A.kode_terima, A.kode_barang, B.kode_barang_spc, B.nama_barang, C.unit_name, A.harga_terima, A.jml_terima, A.status, A.remarks, B.size_length, B.size_width,
											B.size_height, E.simbol as size_length_unit, B.size_weight, F.simbol as size_weight_unit, B.size_volume, G.simbol as size_volume_unit, B.size_area, H.simbol as size_area_unit,
											B.size_density, I.simbol as size_density_unit, B.size_diameter, J.simbol as size_diameter_unit, B.size_diameterin, K.simbol as size_diameterin_unit, B.size_thread,
											L.finishing
					FROM d_terima A
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
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
					WHERE A.kode_terima='$id' and A.companyarea='$loc'";
					
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('penerimaan_barang/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file penerimaan_barang.php */
/* Location: ./application/controllers/penerimaan_barang.php */