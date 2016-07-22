<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_customer extends CI_Controller {
	
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

			
			$d['judul']="Import Master Customer";			
			
			$d['content'] = $this->load->view('import_customer/form', $d, true);		
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

			$d['judul']="Data Customer";
			
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
				$kode_customer = $data->val($i, 3, $sheet=0);
				$tgl_mulai = $data->val($i, 4, $sheet=0);
				$nama_customer = $data->val($i, 5, $sheet=0);
				$names = urlencode($nama_customer);
				$alamat = $data->val($i, 6, $sheet=0);
				$negara = $data->val($i, 7, $sheet=0);
				$telp = $data->val($i, 8, $sheet=0);
				$fax = $data->val($i, 9, $sheet=0);
				$mobile = $data->val($i, 10, $sheet=0);
				$email = $data->val($i, 11, $sheet=0);
				
				$q = "SELECT COUNT(*) AS tcek FROM customer WHERE cust_code='$kode_customer'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek == 0)
				{			 
					$query = "INSERT INTO customer VALUES ('$kode_customer', '$tgl_mulai', '$names', '$alamat', '$negara', '$telp', '$fax', '$mobile', '$email')";
					$hasil = $this->app_model->manualQuery($query);
					$sukses++;
					$couth="sukses";
				}
				else 
				{
					$gagal++;
					$couth="sudah ada";
				}
				
				$d['text'][$arr] = "$kode_customer - $nama_customer $couth";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_customer/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */