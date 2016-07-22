<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_supplier extends CI_Controller {
	
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

			
			$d['judul']="Import Master Supplier";			
			
			$d['content'] = $this->load->view('import_supplier/form', $d, true);		
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

			$d['judul']="Data Supplier";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$d['text'] = array();
			
			for ($i=2; $i<=$hasildata; $i++)
			{
				$vkode_supplier = $data->val($i, 1, $sheet=0);
				$kode_supplier = str_pad($vkode_supplier,5,"0",STR_PAD_LEFT);
				$nama_supplier = $data->val($i, 2, $sheet=0);
				$alamat = $data->val($i, 3, $sheet=0);
				$kodepos = $data->val($i, 4, $sheet=0);
				$kota = $data->val($i, 5, $sheet=0);
				//$address= urlencode($alamat);
				$provinsi = $data->val($i, 6, $sheet=0);
				$negara = $data->val($i, 7, $sheet=0);
				$telp = $data->val($i, 8, $sheet=0);
				$fax = $data->val($i, 9, $sheet=0);
				$email = $data->val($i, 10, $sheet=0);
				$website = $data->val($i, 11, $sheet=0);
				$remarks = $data->val($i, 12, $sheet=0);
				
				$q = "SELECT COUNT(*) AS tcek FROM supplier WHERE supplier_code='$kode_supplier'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek == 0)
				{			 
					$query = "INSERT INTO supplier (supplier_code,supplier_name,supplier_address,kode_pos,capital_city,supplier_state,supplier_country,supplier_phone,supplier_fax,supplier_email,supplier_website,supplier_remarks,supplier_createdby,supplier_createdtime,supplier_editedby,supplier_editedtime,companyarea) VALUES ('$kode_supplier', '$nama_supplier', '$alamat','$kodepos','$kota','$provinsi', '$negara', '$telp', '$fax', '$email','$website','$remarks','$user','$tgl','$user','$tgl','$loc')";
					$hasil = $this->app_model->manualQuery($query);
					$sukses++;
					$couth="sukses";
				}
				else 
				{
					$gagal++;
					$couth="sudah ada";
				}
				
				$d['text'][$arr] = "$kode_supplier - $nama_supplier $couth";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_supplier/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */