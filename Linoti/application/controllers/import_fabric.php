<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_fabric extends CI_Controller {
	
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

			
			$d['judul']="Data Import";			
			
			$d['content'] = $this->load->view('import_fabric/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function konversi_cm($cmsize){
		$whole = floor($cmsize);
		$fraction = $cmsize - $whole;
		$cfraction = 0;
		if ($fraction >= 0.121 && $fraction <= 0.37){
			$cfraction = 0.25;
		} else if ($fraction >= 0.375 && $fraction <= 0.624){
			$cfraction = 0.5;
		} else if ($fraction >= 0.625 && $fraction <= 0.874){
			$cfraction = 0.75;
		} else if ($fraction >= 0.875){
			$cfraction = 1.0;
		}
		$temp = $whole+$cfraction;
		return $temp;
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

			$d['judul']="Data Import";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$tuser='purchasing';
			$d['text'] = array();
			
			for ($i=2; $i<=$hasildata; $i++)
			{
				$nama_barang 		= $data->val($i, 1, $sheet=0);	
				$kode_barang = $this->app_model->GenerateMaterialCode('UPHOLD');
				$query = "INSERT INTO barang (kode_barang, nama_barang, nama_barang_eng, departemen, family, satuan, createdby, createdtime, editedby, editedtime, companyarea) VALUES('$kode_barang','$nama_barang','$nama_barang','UPHOLD','3','006','root','$tgl','root','$tgl','10000')";
				$hasil = $this->app_model->manualQuery($query);
					
					$sukses++;
					$couth="sukses";
				
				$d['text'][$arr] = "$kode_barang - $nama_barang";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_fabric/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file import_fabric.php */
/* Location: ./application/controllers/import_fabric.php */