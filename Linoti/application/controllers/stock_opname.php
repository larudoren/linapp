<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_opname extends CI_Controller {
	
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
			
			$where = " WHERE A.companyarea='$loc' and A.stock_id<>''";
			if(!empty($cari)){
				$where .= " AND A.stock_id LIKE '%$cari%'";
			}
			if(!empty($tgl)){
				$where .= " AND A.tanggal='$tgl'";
			}
			
			$d['prg']			= $this->config->item('prg');
			$d['web_prg']	= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']						=	"Stock Opname";
			
			//paging
			$page=$this->uri->segment(3);
			$limit=$this->config->item('limit_data');
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;
			
			$text = "SELECT A.stock_id,A.tanggal,A.departemen
					FROM h_stock A
					LEFT OUTER JOIN departemen_fact B ON B.dept_code=A.departemen and B.companyarea=A.companyarea
					$where 
					ORDER BY A.tanggal DESC ";		
			$tot_hal = $this->app_model->manualQuery($text);		
			
			$d['tot_hal'] = $tot_hal->num_rows();
			
			$config['base_url'] 		= site_url() . '/stock_opname/index/';
			$config['total_rows'] 	= $tot_hal->num_rows();
			$config['per_page'] 		= $limit;
			$config['uri_segment'] 	= 3;
			$config['next_link'] 		= 'Next &raquo;';
			$config['prev_link'] 		= '&laquo; Prev';
			$config['last_link'] 		= '<b>Last &raquo; </b>';
			$config['first_link'] 	= '<b> &laquo; First</b>';
			$this->pagination->initialize($config);
			$d["paginator"] =$this->pagination->create_links();
			$d['hal'] = $offset;
			

			$text = "SELECT A.stock_id,A.tanggal,B.dept_name
					FROM h_stock A
					LEFT OUTER JOIN departemen_fact B ON B.dept_code=A.departemen and B.companyarea=A.companyarea
					$where 
					ORDER BY A.tanggal DESC
					LIMIT $limit OFFSET $offset";
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$d['content'] = $this->load->view('stock_opname/view', $d, true);		
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

			$d['judul']						=	"Stock Opname";
			
			
			$tgl	= date('Y-m-d');
			
			$d['stock_id']	= '';
			$d['tanggal']		= $tgl;
			$d['departemen']= '';
			
			$text = "SELECT * FROM departemen_fact WHERE companyarea='$loc' and dept_code<>'000' ORDER BY dept_name";
			$d['l_dept'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('stock_opname/form', $d, true);		
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
			$d['myheader'] 	= $myheader;
			$d['prg']				= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul'] 					= "Stock Opname";
			
			$id = $this->uri->segment(3);
			$text = "SELECT * FROM h_stock	WHERE stock_id='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['stock_id']		= $id;
					$d['tanggal']			= $db->tanggal;
					$d['departemen']	= $db->departemen;
				}
			}else{
					$d['stock_id']		=	$id;
					$d['tanggal']			=	'';
					$d['departemen']	= '';
			}
			
			$text = "SELECT * FROM departemen_fact where companyarea='$loc'";
			$d['l_dept'] = $this->app_model->manualQuery($text);
		
			$d['content'] = $this->load->view('stock_opname/form', $d, true);		
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
			/*
			$text = "SELECT A.kode_barang FROM stock_opname A WHERE A.stock_id='$id' and companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				
			}*/
			$this->app_model->manualQuery("DELETE FROM h_stock WHERE stock_id='$id' and companyarea='$loc'");
			$this->app_model->manualQuery("DELETE FROM stock_opname WHERE stock_id='$id' and companyarea='$loc'");
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/stock_opname'>";			
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
			$this->app_model->manualQuery("DELETE FROM stock_opname WHERE stock_id='$id' AND kode_barang='$kode' and companyarea='$loc'");
			
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
			if (empty($this->input->post('stock_id')))
			{
				$stock_id = $this->app_model->GenerateStockID();
				$stock_id = 'LIN'.$stock_id;
			} else {
				$stock_id = $this->input->post('stock_id');
			}
			
			$up['stock_id']		= $stock_id;
			$up['tanggal']		= $this->input->post('tanggal');
			$up['departemen']	= $this->input->post('departemen');
			$up['editedby']		= $user;
			$up['editedtime']	= $tgl;
			
			$ud['stock_id'] 		= $stock_id;
			$ud['kode_barang'] 	= $this->input->post('kode_brg');
			$ud['quantity'] 		= $this->input->post('jml');
			$ud['qtypm'] 		= $this->input->post('jmlpm');
			$ud['pl_mn'] 		= $this->input->post('minus');
			$ud['remarks'] 			= $this->input->post('remarks');
			$ud['editedby'] 		= $user;
			$ud['editedtime'] 	= $tgl;
			
			$id['stock_id'] 		= $stock_id;
			$id['companyarea'] 	= $loc;
			
			$id_d['stock_id'] 		= $stock_id;
			$id_d['kode_barang'] 	= $this->input->post('kode_brg');
			$id_d['companyarea'] 	= $loc;
			
			$data = $this->app_model->getSelectedData("h_stock",$id);
			if($data->num_rows()>0){
				$this->app_model->updateData("h_stock",$up,$id);
				$data = $this->app_model->getSelectedData("stock_opname",$id_d);
				if($data->num_rows()>0){
					$thasil = $this->app_model->updateData("stock_opname",$ud,$id_d);
					
				}else{
					$ud['createdby'] 		= $user;
					$ud['createdtime'] 	= $tgl;
					$ud['companyarea'] 	= $loc;
					$thasil = $this->app_model->insertData("stock_opname",$ud);
				}
			}else{
				$up['createdby'] 		= $user;
				$up['createdtime'] 	= $tgl;
				$up['companyarea'] 	= $loc;
				$thasil = $this->app_model->insertData("h_stock",$up);
				$ud['createdby'] = $user;
				$ud['createdtime'] = $tgl;
				$ud['companyarea'] = $loc;
				$this->app_model->insertData("stock_opname",$ud);
					
			}
			$ud_barang['stock'] = $this->input->post('jml');
			$id_brg['kode_barang'] = $this->input->post('kode_brg');
			$id_brg['companyarea'] = $loc;
			
			$this->app_model->updateData("barang",$ud_barang,$id_brg);
			
			
			echo $thasil.','.$stock_id;
			
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
			$text = "SELECT A.stock_id, A.kode_barang,B.kode_barang_spc, B.nama_barang,  A.quantity, A.remarks, C.unit_name, A.remarks
					FROM stock_opname A
					JOIN barang B ON B.kode_barang=A.kode_barang and B.companyarea=A.companyarea
					JOIN unit C ON B.satuan=C.unit_code
					WHERE A.stock_id='$id' and A.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
			$this->load->view('stock_opname/detail',$d);
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
			$text = "SELECT h_keluar.kode_keluar, h_keluar.tgl_keluar, departemen.dept_name, h_keluar.pi, customer.cust_name, h_keluar.receiver
					FROM h_keluar
					JOIN departemen ON departemen.dept_code=h_keluar.departemen and departemen.companyarea=h_keluar.companyarea
					JOIN customer ON customer.cust_code=h_keluar.customer and customer.companyarea=h_keluar.companyarea
					WHERE h_keluar.kode_keluar='$id' and h_keluar.companyarea='$loc'";
			$data = $this->app_model->manualQuery($text);
			if($data->num_rows() > 0){
				foreach($data->result() as $db){
					$d['kode_keluar']	= $id;
					$tanggal = date_create($db->tgl_keluar);
					$d['tgl_keluar']	= date_format($tanggal, 'F jS, Y');
					$d['departemen']	= $db->dept_name;
					$d['pi']					= $db->pi;
					$d['customer']		= $db->cust_name;
					$d['receiver']		= $db->receiver;
				}
			}else{
					$d['kode_keluar']	= $id;
					$d['tgl_keluar']	= '';
					$d['departemen']	= '';
					$d['pi']					= '';
					$d['customer']		= '';
					$d['receiver']		= '';
			}
			
			$text = "SELECT d_keluar.kode_keluar, d_keluar.kode_barang, barang.nama_barang,  unit.unit_name, d_keluar.jml_keluar, d_keluar.remarks
					FROM d_keluar 
					JOIN barang ON d_keluar.kode_barang=barang.kode_barang and barang.companyarea=d_keluar.companyarea
					JOIN unit ON barang.satuan=unit.unit_code
					WHERE d_keluar.kode_keluar='$id' and d_keluar.companyarea='$loc'";
			$d['data']= $this->app_model->manualQuery($text);
									
			$this->load->view('stock_opname/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file stock_opname.php */
/* Location: ./application/controllers/stock_opname.php */