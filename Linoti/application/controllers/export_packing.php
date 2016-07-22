<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export_packing extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Export Packing";			
			
			$d['content'] = $this->load->view('export_packing/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function export()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$tanggal = date('Y-m-d');
		$tanggalp = date('d M Y');
		
		error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
		
		if(!empty($cek)){
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Data Barang";
			
			$kode = $this->uri->segment(3);
			
			$kode = str_replace(' ','',$kode);
			
			if (!empty($kode)){
				$where = " AND B.product_code='$kode'";
			}else{
				$where = "";
			}
			
			$text = "SELECT DISTINCT(B.product_code),C.product_name,C.product_photo,C.cm_length,C.cm_width,C.cm_height,D.coll_name,A.companyarea FROM  cotation_packing A LEFT OUTER JOIN h_cotation B ON B.id_cotation=A.id_cotation AND B.companyarea=A.companyarea LEFT OUTER JOIN product C ON C.product_code=B.product_code LEFT OUTER JOIN collection D ON D.coll_code=C.product_coll WHERE A.companyarea='$loc' $where";
			
			$d['data'] = $this->app_model->manualQuery($text);
			
			
			$this->load->view('export_packing/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file export_packing.php */
/* Location: ./application/controllers/export_packing.php */