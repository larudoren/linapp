<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_barang extends CI_Controller {
	
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

			
			$d['judul']="Item Stock Report";
			
			$d['l_dept']=$this->app_model->get_departement_fact();
			
			
			$d['content'] = $this->load->view('lap_barang/form', $d, true);
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
		if(!empty($cek)){
			//$tgl1 = $this->input->post('tgl1');
			//$tgl2 = $this->input->post('tgl2');
			$pilih = $this->input->post('pilih');
			$departemen = $this->input->post('departemen');
			$mat_group = $this->input->post('mat_group');
			$kode = $this->input->post('kode');
			
			if($pilih=='departemen'){
				$where = " WHERE A.departemen='$departemen' and A.companyarea='$loc'";
			}else if($pilih=='group'){
				$where = " WHERE A.kode_barang LIKE '%$mat_group%' and A.companyarea='$loc'";
			} else if($pilih=='kode'){
				$where = " WHERE A.kode_barang='$kode' and A.companyarea='$loc'";
			} else {
				$where = " WHERE A.companyarea='$loc'";
			}
			
			$text = "SELECT A.kode_barang, A.nama_barang, B.unit_name, C.dept_name
					FROM barang A
					LEFT OUTER JOIN unit B ON B.unit_code=A.satuan
					LEFT OUTER JOIN departemen_fact C ON C.dept_code=A.departemen and C.companyarea=A.companyarea
					$where
					ORDER BY A.kode_barang ASC";
			$d['data'] = $this->app_model->manualQuery($text);
			
			//$d['tgl1'] = $tgl1;
			//$d['tgl2'] = $tgl2;
			
			$this->load->view('lap_barang/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
		if(!empty($cek)){
			$pilih = $this->uri->segment(3);
			$kode = $this->uri->segment(4);
			$departemen = $this->uri->segment(4);
			$group = $this->uri->segment(4);
			//$tgl1 = $this->uri->segment(5);
			//$tgl2 = $this->uri->segment(6);
			
			if($pilih=='departemen'){
				$where = " WHERE A.departemen='$departemen' and A.companyarea='$loc'";
			}else if($pilih=='group'){
				$where = " WHERE A.kode_barang LIKE '%$group%' and A.companyarea='$loc'";
			} else{
				$where = " WHERE A.kode_barang='$kode' and A.companyarea='$loc'";
			}
			

			$text = "SELECT A.kode_barang, A.nama_barang, B.unit_name, C.dept_name
					FROM barang A
					LEFT OUTER JOIN unit B ON B.unit_code=A.satuan
					LEFT OUTER JOIN departemen_fact C ON C.dept_code=A.departemen and C.companyarea=A.companyarea
					$where
					ORDER BY A.kode_barang ASC";
			$d['data'] = $this->app_model->manualQuery($text);
			
			//$d['tgl1'] = $tgl1;
			//$d['tgl2'] = $tgl2;
			
			$this->load->view('lap_barang/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */