<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengeluaran_barang extends CI_Controller {
	
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
			
			$where = " WHERE h_keluar.companyarea='$loc' and h_keluar.kode_keluar<>''";
			if(!empty($cari)){
				$where .= " AND h_keluar.kode_keluar LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND h_keluar.tgl_keluar='$tgl'";
			}
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Pengeluaran Barang";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT h_keluar.kode_keluar, h_keluar.tgl_keluar, departemen_fact.dept_name, h_keluar.pi, customer.cust_name
					FROM h_keluar
					JOIN departemen_fact ON departemen_fact.dept_code=h_keluar.departemen and departemen_fact.companyarea=h_keluar.companyarea
					JOIN customer ON customer.cust_code=h_keluar.customer and customer.companyarea=h_keluar.companyarea
					$where 
					ORDER BY h_keluar.tgl_keluar DESC ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] = site_url() . '/pengeluaran_barang/index/';
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
			

			$text = "SELECT h_keluar.kode_keluar, h_keluar.tgl_keluar, departemen_fact.dept_name, h_keluar.pi, customer.cust_name
					FROM h_keluar
					JOIN departemen_fact ON departemen_fact.dept_code=h_keluar.departemen and departemen_fact.companyarea=h_keluar.companyarea
					JOIN customer ON customer.cust_code=h_keluar.customer and customer.companyarea=h_keluar.companyarea
					$where 
					ORDER BY h_keluar.tgl_keluar DESC
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('pengeluaran_barang/view', $d, true);		
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
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Pengeluaran Barang";
			
			//$kode	= $this->app_model->MaxKodeKeluar();
			$tgl	= date('Y-m-d');
			
			$d['kode_keluar']	= '';
			$d['tgl_keluar']	= $tgl;
			$d['departemen']= $this->app_model->get_departement();
			$d['pi']= '';
			$d['customer']= $this->app_model->get_customer();
			$d['receiver']	= '';
			
			$text = "SELECT * FROM departemen_fact WHERE companyarea='$loc' and dept_code<>'000' ORDER BY dept_name";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM customer WHERE companyarea='$loc' and cust_code<>'000' ORDER BY cust_name";
			$d['l_cust'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('pengeluaran_barang/form', $d, true);		
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
			
			$d['judul'] = "Pengeluaran Barang";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_keluar	WHERE kode_keluar='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_keluar']	= $id;
					$d['tgl_keluar']	= $db->tgl_keluar;
					$d['departemen']	= $db->departemen;
					$d['pi']			= $db->pi;
					$d['customer']		= $db->customer;
					$d['receiver']		= $db->receiver;
				}
			}else{
					$d['kode_keluar']		=$id;
					$d['tgl_keluar']	='';
					$d['departemen']	= '';
					$d['pi']			= '';
					$d['customer']		= '';
					$d['receiver']		= '';
			}
			
			$text = "SELECT * FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM customer where companyarea='$loc'";
			$d['l_cust'] = $this->app_model->manualQuery($text2);
									
			$d['content'] = $this->load->view('pengeluaran_barang/form', $d, true);		
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
			$this->app_model->manualQuery("DELETE FROM d_keluar WHERE kode_keluar='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM h_keluar WHERE kode_keluar='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pengeluaran_barang'>";			
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
			$this->app_model->manualQuery("DELETE FROM d_keluar WHERE kode_keluar='$id' AND kode_barang='$kode' and companyarea='$loc'");
			
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
			$awal = date('Y-m-01');
			$sekarang = date('Y-m-d');
			$kode_brg = $this->input->post('nama_brg');
			$stok = $this->app_model->CariLiveStock($kode_brg, $awal, $sekarang);
			$jml = $this->input->post('jml');
			
			if($stok >= $jml){	
				if (empty($this->input->post('kode_keluar'))){
					$kode	= $this->app_model->MaxKodeKeluar();
				} else {
					$kode = $this->input->post('kode_keluar');
				}
				
				$up['kode_keluar']		= $kode;
				$up['tgl_keluar']		= $this->input->post('tgl');
				$up['departemen']		= $this->input->post('departemen');
				$up['pi']		= $this->input->post('pi');
				$up['customer']		= $this->input->post('customer');
				$up['receiver']		= $this->input->post('receiver');
				$up['username']= $this->session->userdata('username');
				$up['editedby']= $user;
				$up['editedtime']= $tgl;
				
				$ud['kode_keluar'] = $this->input->post('kode_keluar');
				$ud['kode_barang'] = $this->input->post('nama_brg');
				$ud['jml_keluar'] = $this->input->post('jml');
				$ud['remarks'] = $this->input->post('remarks');
				$ud['editedby'] = $user;
				$ud['editedtime'] = $tgl;
				
				$id['kode_keluar']=$this->input->post('kode_keluar');
				$id['companyarea']=$loc;
				
				$id_d['kode_keluar']=$this->input->post('kode_keluar');
				$id_d['kode_barang']=$this->input->post('nama_brg');
				$id_d['companyarea']=$loc;
				
				$data = $this->app_model->getSelectedData("h_keluar",$id);
				if($data->num_rows()>0){
					$this->app_model->updateData("h_keluar",$up,$id);
						$data = $this->app_model->getSelectedData("d_keluar",$id_d);
						if($data->num_rows()>0){
							$this->app_model->updateData("d_keluar",$ud,$id_d);
						}else{
							$ud['createdby'] = $user;
							$ud['createdtime'] = $tgl;
							$ud['companyarea'] = $loc;
							$this->app_model->insertData("d_keluar",$ud);
						}
					//echo 'Update data Sukses';
				}else{
					$up['createdby'] = $user;
					$up['createdtime'] = $tgl;
					$up['companyarea'] = $loc;
					$this->app_model->insertData("h_keluar",$up);
					$ud['createdby'] = $user;
					$ud['createdtime'] = $tgl;
					$ud['companyarea'] = $loc;
					$this->app_model->insertData("d_keluar",$ud);
					//echo 'Simpan data Sukses';		
				}
			}else{
				echo "Sorry, Stock not available for request. Current stock <b style='color:red'>".$stok."</b>";
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
			$text = "SELECT A.kode_keluar, A.kode_barang, B.kode_barang_spc, B.nama_barang,  C.unit_name, A.jml_keluar /*, cost_keluar.harga */
					FROM d_keluar A
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
					JOIN unit C ON C.unit_code=B.satuan
					/* JOIN cost_keluar D ON D.kode_barang=B.kode_barang and D.companyarea=B.companyarea */
					WHERE A.kode_keluar='$id' and A.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
			$this->load->view('pengeluaran_barang/detail',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			timezone_menu('UP7');
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			
			$d['judul'] = "Faktur Pengeluaran";
			
			$id = $this->uri->segment(3);
			$text = "SELECT h_keluar.kode_keluar, h_keluar.tgl_keluar, departemen_fact.dept_name, h_keluar.pi, customer.cust_name, h_keluar.receiver
					FROM h_keluar
					JOIN departemen_fact ON departemen_fact.dept_code=h_keluar.departemen and departemen_fact.companyarea=h_keluar.companyarea
					JOIN customer ON customer.cust_code=h_keluar.customer and customer.companyarea=h_keluar.companyarea
					WHERE h_keluar.kode_keluar='$id' and h_keluar.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_keluar']	= $id;
					$tanggal = date_create($db->tgl_keluar);
					$d['tgl_keluar']	= date_format($tanggal, 'F jS, Y');
					$d['departemen']	= $db->dept_name;
					$d['pi']	= $db->pi;
					$d['customer']	= $db->cust_name;
					$d['receiver']	= $db->receiver;
				}
			}else{
					$d['kode_keluar']	= $id;
					$d['tgl_keluar']	= '';
					$d['departemen']	= '';
					$d['pi']	= '';
					$d['customer']	= '';
					$d['receiver']	= '';
			}
			
			$text = "SELECT d_keluar.kode_keluar, d_keluar.kode_barang, barang.nama_barang,  unit.unit_name, d_keluar.jml_keluar, d_keluar.remarks
					FROM d_keluar 
					JOIN barang ON d_keluar.kode_barang=barang.kode_barang and barang.companyarea=d_keluar.companyarea
					JOIN unit ON barang.satuan=unit.unit_code
					WHERE d_keluar.kode_keluar='$id' and d_keluar.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('pengeluaran_barang/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file pengeluaran_barang.php */
/* Location: ./application/controllers/pengeluaran_barang.php */