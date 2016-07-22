<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_barang extends CI_Controller {
	
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

			
			$d['judul']="Import Master Barang";			
			
			$d['content'] = $this->load->view('import_barang/form', $d, true);		
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

			$d['judul']="Data Barang";
			
			$file = $_FILES['fileexcel']['tmp_name'];
			
			$data = new Spreadsheet_Excel_Reader($file);
			$hasildata = $data->rowcount($sheet_index=0);
			// default nilai 
			$sukses = 0;
			$gagal = 0;
			$arr = 0;
			$d['text'] = array();
			$departemen = 'ACCHRD';
			for ($i=2; $i<=$hasildata; $i++)
			{
				$kode_barang = $data->val($i, 1, $sheet=0);
				$kode_spc = $data->val($i, 2, $sheet=0);
				if ($kode_spc=='-'){
					$kode_spc ='';
				}
				
				$family = $data->val($i, 4, $sheet=0);
				$nama_barang_eng = $data->val($i, 5, $sheet=0);
				if ($nama_barang_eng=='-'){
					$nama_barang_eng='';
				}
				$nama_barang = $data->val($i, 6, $sheet=0);
				if ($nama_barang=='-'){
					$nama_barang='';
				}
				$merk = $data->val($i, 7, $sheet=0);
				$type = $data->val($i, 9, $sheet=0);
				$detail = $data->val($i, 10, $sheet=0);
				if ($detail=='-'){
					$detail='';
				}
				$length = $data->val($i, 11, $sheet=0);
				if ($length=='-'){
					$length='';
				}
				$width = $data->val($i, 12, $sheet=0);
				if ($width=='-'){
					$width='';
				}
				$height = $data->val($i, 13, $sheet=0);
				if ($height=='-'){
					$height='';
				}
				$length_unit = $data->val($i, 14, $sheet=0);
				$volume = $data->val($i, 15, $sheet=0);
				if ($volume=='-'){
					$volume='';
				}
				$volume_unit = $data->val($i, 16, $sheet=0);
				if ($volume_unit=='-'){
					$volume_unit='';
				}
				$weight = $data->val($i, 17, $sheet=0);
				if ($weight=='-'){
					$weight='';
				}
				$weight_unit = $data->val($i, 18, $sheet=0);
				if ($weight_unit=='-'){
					$weight_unit='';
				}
				$area = $data->val($i, 19, $sheet=0);
				if ($area=='-'){
					$area='';
				}
				$area_unit = $data->val($i, 20, $sheet=0);
				if ($area_unit=='-'){
					$area_unit='';
				}
				$density = $data->val($i, 21, $sheet=0);
				if ($density=='-'){
					$density='';
				}
				$density_unit = $data->val($i, 22, $sheet=0);
				if ($density_unit=='-'){
					$density_unit='';
				}
				$dmout = $data->val($i, 23, $sheet=0);
				$dmin = $data->val($i, 24, $sheet=0);
				$thread = $data->val($i, 25, $sheet=0);
				$material = $data->val($i, 26, $sheet=0);
				$finishing = $data->val($i, 27, $sheet=0);
				
				
				$q = "SELECT COUNT(*) AS tcek FROM barang WHERE kode_barang='$kode_barang'";
				$q_cek = $this->app_model->manualQuery($q);
				$h_cek = $q_cek->row();
				if($h_cek->tcek == 0)
				{			 
					$query = "INSERT INTO barang (kode_barang,kode_barang_spc,departemen,family,nama_barang_eng,nama_barang,merek,type,detail,size_length,size_width,size_height,size_length_unit,size_volume,size_volume_unit,size_weight,size_weight_unit,size_area,size_area_unit,size_density,size_density_unit,size_diameterin,size_diameter,size_thread,material,finishing,companyarea) VALUES ('$kode_barang','$kode_spc','$departemen','$family','$nama_barang_eng','$nama_barang', '$merk','$type','$detail','$length','$width','$height','$length_unit','$volume','$volume_unit','$weight','$weight_unit','$area','$area_unit','$density','$density_unit','$dmin','$dmout','$thread','$material','$finishing','10000')";
					$hasil = $this->app_model->manualQuery($query);
					$sukses++;
					$couth="sukses";
				} /*
				else 
				{
					$query = "UPDATE barang SET nama_barang='$deskripsi',departemen='$departemen',family='$family',type='$type',detail='$detail',satuan='$satuan',size_length='$length',size_width='$width',size_height='$height',size_density_code='$density',brg_currency='$currency',brg_harga='$harga',brg_supplier='$supplier',tgl_terakhir_beli=Str_To_Date('$tanggal','%d/%m/%Y') where kode_barang='$kode_barang' and brg_supplier='$supplier'";
					$hasil = $this->app_model->manualQuery($query);
					$gagal++;
					$couth="sudah ada";
				} */
				
				$d['text'][$arr] = "$kode_barang - $deskripsi $couth";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['update'] = $gagal;

			$d['content'] = $this->load->view('import_barang/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file import_barang.php */
/* Location: ./application/controllers/import_barang.php */