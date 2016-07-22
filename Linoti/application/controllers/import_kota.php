<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_kota extends CI_Controller {
	
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

			
			$d['judul']="Import Kota";			
			
			$d['content'] = $this->load->view('import_kota/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function import()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl = date("Y-m-d H:i:s");
		if(!empty($cek)){
			require(APPPATH.'plugins/excelreader/excel_reader2.php');
			$this->load->model('app_model');
			error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Data Kota";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$d['text'] = array();
			
			for ($i=4; $i<=$hasildata; $i++)
			{
				$kode_kota = $data->val($i, 1, $sheet=0);
				$kode_negara = $data->val($i, 2, $sheet=0);
				$kota = $data->val($i, 3, $sheet=0);
				
				$q = "SELECT COUNT(*) AS tcek FROM kota WHERE negara_id='$kode_negara' and kota_id='$kode_kota'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek == 0)
				{			 
					$query = "INSERT INTO kota VALUES ('$kode_kota','$kode_negara','$kota', '$user', '$tgl', '$user', '$tgl', '$loc','')";
					$hasil = $this->app_model->manualQuery($query);
					$sukses++;
					$couth="sukses";
				}
				else 
				{
					$gagal++;
					$couth="sudah ada";
				}
				
				$d['text'][$arr] = "$kode_negara - $deskripsi $couth";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_kota/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */