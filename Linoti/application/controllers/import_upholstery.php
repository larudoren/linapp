<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_upholstery extends CI_Controller {
	
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

			
			$d['judul']="Import Cotation Upholstery";			
			$d['id_cotation']=$id_cotation;
			$d['content'] = $this->load->view('import_upholstery/form', $d, true);		
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
			$cot_id = $this->uri->segment(3);
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			$d['judul']="Data Upholstery";
			
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
				
				$vkode_product = $data->val($i, 1, $sheet=0);
				$textcot = "SELECT id_cotation from h_cotation where product_code='$vkode_product'";
				$cot_cek = $this->app_model->manualQuery($textcot);
				$cot_h = $cot_cek->row();
				//$fp=fopen("importuphol.txt","w");
				//fwrite($fp,'Id Cotation : '.$cot_h->id_cotation.';  Cot : '.$cot_id);
				if (!empty($cot_h->id_cotation) && $cot_id == $cot_h->id_cotation){
				
					$vid_cotation = $cot_h->id_cotation;
					//$seq = $data->val($i, 2, $sheet=0);
					$komponen1 = $data->val($i, 2, $sheet=0);
					$komponen2 = $data->val($i, 3, $sheet=0);
					$komponen3 = $data->val($i, 4, $sheet=0);
					$material = $data->val($i, 6, $sheet=0);
					$comp_waste = $data->val($i, 7, $sheet=0);
					$harga_cek = $this->app_model->harga_upholstery($material);
					$harga = $harga_cek[1];
					$currency = $harga_cek[0];
					
					
					
					$textfam = "Select family from barang where kode_barang='$material'";
					$fam_cek = $this->app_model->manualQuery($textfam);
					$fam_h = $fam_cek->row();
					
					$family = $fam_h->family;
					
					$length = $data->val($i, 8, $sheet=0);
					$width = $data->val($i, 9, $sheet=0);
					
					$volume = $data->val($i, 10, $sheet=0);
					
					$quantity = $data->val($i, 11, $sheet=0);
					
					$datacot = $this->app_model->cotation_upholstery($material,$length,$width,$volume,$quantity,$comp_waste);
					
					$q = "SELECT COUNT(*) AS tcek FROM cotation_upholstery WHERE id_cotation='$vid_cotation' and komponen1='$komponen1' and komponen2='$komponen2' and komponen3='$komponen3' and material_family='$family' and material='$material'";
					$q_cek = $this->app_model->manualQuery($q);
					$h_cek = $q_cek->row();
					if($h_cek->tcek == 0 && $komponen1!='' && $datacot['kode_barang']!='')
					{			 
						$seq_sql = "SELECT MAX(seq)+1 as seq FROM cotation_upholstery where id_cotation='$vid_cotation'";
						$seq_cek = $this->app_model->manualQuery($seq_sql);
						$seq_h = $seq_cek->row();
						
						$query = "INSERT INTO cotation_upholstery (id_cotation,seq,komponen1,komponen2,komponen3,material_family,material,length,width,height,volume,quantity,average_waste,special_waste,consumption,harga_mat,sqf25,sqf28,sqf3048,run_m140,run_m150,run_m160,kilo,consumption_m,createdby,createdtime,editedby,editedtime,companyarea) VALUES ('$vid_cotation', '".$seq_h->seq."', '$komponen1','$komponen2','$komponen3','$family', '$material', '$length', '$width', '".$datacot['height']."','$volume','$quantity','".$datacot['average_waste']."','$comp_waste','".$datacot['consum']."','$harga','".$datacot['sqf_25']."','".$datacot['sqf_28']."','".$datacot['sqf_3048']."','".$datacot['run_m140']."','".$datacot['run_m150']."','".$datacot['run_m160']."','".$datacot['kilo']."','".$datacot['consum_m']."','$user','$tgl','$user','$tgl','$loc')";
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
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_upholstery/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file import_upholstery.php */
/* Location: ./application/controllers/import_upholstery.php */