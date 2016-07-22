<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_material extends CI_Controller {
	
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

			
			$d['judul']="Import Item Master";			
			
			$d['content'] = $this->load->view('import_material/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function import()
	{
		$cek = $this->session->userdata('logged_in');
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

			$d['judul']="Import Item Master";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$d['text'] = array();
			$code = array();
			
			for ($i=0; $i<=$hasildata; $i++)
			{
				$code[0] = $data->val($i, 1, $sheet=1);
				$code[1] = $data->val($i, 2, $sheet=1);
				$code[2] = $data->val($i, 3, $sheet=1);
				$code[3] = $data->val($i, 4, $sheet=1);
				$code[4] = $data->val($i, 5, $sheet=1);
				$code[5] = $data->val($i, 6, $sheet=1);
				$code[6] = $data->val($i, 7, $sheet=1);
				$code[7] = $data->val($i, 8, $sheet=1);
				$code[8] = $data->val($i, 9, $sheet=1);
				$code[9] = $data->val($i, 10, $sheet=1);
				$code[10] = $data->val($i, 11, $sheet=1);
				$code[11] = $data->val($i, 12, $sheet=1);
				$code[12] = $data->val($i, 13, $sheet=1);
				
				$kodelama = $data->val($i, 14, $sheet=1);
				
				$kode = implode('', $code);
				
				$q = "SELECT count(*) as tcek FROM barang WHERE kode_lama='$kodelama'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek > 0)
				{			 
					$query = "UPDATE barang SET kode_barang='$kode' WHERE kode_lama='$kodelama'";
					$hasil = $this->app_model->manualQuery($query);
				}
				
				$d['text'][$arr] = $query;
				$arr++;
			}

			$d['content'] = $this->load->view('import_material/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tes()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			require(APPPATH.'plugins/excelreader/excel_reader2.php');
			$this->load->model('app_model');
			error_reporting(E_ALL & ~E_NOTICE & E_ERROR | E_PARSE);
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			
			$code = array();
			
			$code[0] = $data->val(1, 1, $sheet=1);
			$code[1] = $data->val(1, 2, $sheet=1);
			$code[2] = $data->val(1, 3, $sheet=1);
			$code[3] = $data->val(1, 4, $sheet=1);
			$code[4] = $data->val(1, 5, $sheet=1);
			$code[5] = $data->val(1, 6, $sheet=1);
			$code[6] = $data->val(1, 7, $sheet=1);
			$code[7] = $data->val(1, 8, $sheet=1);
			$code[8] = $data->val(1, 9, $sheet=1);
			$code[9] = $data->val(1, 10, $sheet=1);
			$code[10] = $data->val(1, 11, $sheet=1);
			$code[11] = $data->val(1, 12, $sheet=1);
			$code[12] = $data->val(1, 13, $sheet=1);
			
			$kodelama = $data->val(1, 14, $sheet=1);
			
			$a = implode('',$code);
			
			echo $a.'-'.$kodelama;
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */