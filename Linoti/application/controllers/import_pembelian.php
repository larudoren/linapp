<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_pembelian extends CI_Controller {
	
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

			
			$d['judul']="Import Transaksi Pembelian";			
			
			$d['content'] = $this->load->view('import_pembelian/form', $d, true);		
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

			$d['judul']="Import Transaksi Pembelian";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$d['text'] = array();
			
			$po = $data->val(3, 2, $sheet=0);
			$tgl= $data->val(3, 3, $sheet=0);
			$sup= $data->val(3, 4, $sheet=0);
			$cus= $data->val(3, 5, $sheet=0);
			$use= $this->session->userdata('nama_lengkap');
			
			$text = "INSERT INTO h_beli VALUES ('$tgl', '$sup', '$cus', '$po', '$use')";
			$ttex = $this->app_model->manualQuery($text);
			
			for ($i=6; $i<=$hasildata; $i++)
			{
				$kode_barang = $data->val($i, 2, $sheet=0);
				$jml_beli = $data->val($i, 3, $sheet=0);
				$harga_beli = $data->val($i, 4, $sheet=0);
				$status = $data->val($i, 5, $sheet=0);
				$remarks = $data->val($i, 6, $sheet=0);
				$currency = $data->val($i, 7, $sheet=0);
				
				$q = "SELECT COUNT(*) AS tcek FROM d_beli WHERE kode_barang='$kode_barang' AND po='$po'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek == 0)
				{			 
					$query = "INSERT INTO d_beli VALUES ('', '$po', '$kode_barang', '$jml_beli', '$currency', '$harga_beli', '$status', '$remarks')";
					$hasil = $this->app_model->manualQuery($query);
					$sukses++;
					$couth="sukses";
				}
				else 
				{
					$gagal++;
					$couth="sudah ada";
				}
				
				$d['text'][$arr] = "$kode_barang $couth";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_pembelian/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */