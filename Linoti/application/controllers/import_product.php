<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Import_product extends CI_Controller {
	
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

			
			$d['judul']="Import Product";			
			
			$d['content'] = $this->load->view('import_product/form', $d, true);		
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

			$d['judul']="Data Product";
			
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
				$kode_product 		= $data->val($i, 1, $sheet=0);
				$collect 					= $data->val($i, 2, $sheet=0);
				$category 				= $data->val($i, 3, $sheet=0);
				$cm_length 				= $data->val($i, 4, $sheet=0);
				$cm_width 				= $data->val($i, 5, $sheet=0);
				$cm_height 				= $data->val($i, 6, $sheet=0);
				if (!empty($cm_length)){
					$vinch_length			= $cm_length/2.54;
					$whole 			= floor($vinch_length);
					$fraction		= $vinch_length - $whole;
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
				} else {
					$temp = 0;
				}
				$inch_length			= $temp;
				if (!empty($cm_width)){
					$vinch_width			= $cm_width/2.54;
					$whole 			= floor($vinch_width);
					$fraction		= $vinch_width - $whole;
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
				} else {
					$temp = 0;
				}
				
				$inch_width				= $whole+$cfraction;
				$vinch_height			= $cm_height/2.54;
				$whole 			= floor($vinch_height);
				$fraction		= $vinch_height - $whole;
				$cfraction = 0;
				if ($fraction >= 0.121 && $fraction <= 0.374){
					$cfraction = 0.25;
				} else if ($fraction >= 0.375 && $fraction <= 0.624){
					$cfraction = 0.5;
				} else if ($fraction >= 0.625 && $fraction <= 0.874){
					$cfraction = 0.75;
				} else if ($fraction >= 0.875){
					$cfraction = 1.0;
				}
				
				$inch_height			= $whole+$cfraction;
				$weight_kg				= $data->val($i, 7, $sheet=0);
				$weight_lbs				= $weight_kg*2.204;
				$ext_qty					= $data->val($i, 8, $sheet=0);
				$ext_qty2					= $ext_qty;
				$ext_length				= $data->val($i, 9, $sheet=0);
				$whole 			= floor($ext_length/2.54);
				$fraction		= ($ext_length/2.54) - $whole;
				$cfraction = 0;
				if ($fraction >= 0.121 && $fraction <= 0.374){
					$cfraction = 0.25;
				} else if ($fraction >= 0.375 && $fraction <= 0.624){
					$cfraction = 0.5;
				} else if ($fraction >= 0.625 && $fraction <= 0.874){
					$cfraction = 0.75;
				} else if ($fraction >= 0.875){
					$cfraction = 1.0;
				}
				
				$ext_length2			= $whole+$cfraction;
				$cm_seat					= $data->val($i, 10, $sheet=0);
				$whole 			= floor($cm_seat/2.54);
				$fraction		= ($cm_seat/2.54) - $whole;
				$cfraction = 0;
				if ($fraction >= 0.121 && $fraction <= 0.374){
					$cfraction = 0.25;
				} else if ($fraction >= 0.375 && $fraction <= 0.624){
					$cfraction = 0.5;
				} else if ($fraction >= 0.625 && $fraction <= 0.874){
					$cfraction = 0.75;
				} else if ($fraction >= 0.875){
					$cfraction = 1.0;
				}
				
				$inch_seat				= $whole+$cfraction;
				$cm_clear					= $data->val($i, 11, $sheet=0);
				$whole 			= floor($cm_clear/2.54);
				$fraction		= ($cm_clear/2.54) - $whole;
				$cfraction = 0;
				if ($fraction >= 0.121 && $fraction <= 0.374){
					$cfraction = 0.25;
				} else if ($fraction >= 0.375 && $fraction <= 0.624){
					$cfraction = 0.5;
				} else if ($fraction >= 0.625 && $fraction <= 0.874){
					$cfraction = 0.75;
				} else if ($fraction >= 0.875){
					$cfraction = 1.0;
				}
				
				$inch_clear				= $whole+$cfraction;
				$vol_m3						= $data->val($i, 12, $sheet=0);
				$whole 			= floor($vol_m3*35.31);
				$vfraction		= ($vol_m3*35.31) - $whole;
				$cfraction = 0;
				if ($vfraction >= 0.121 && $vfraction <= 0.374){
					$cfraction = 0.25;
				} else if ($vfraction >= 0.375 && $vfraction <= 0.624){
					$cfraction = 0.5;
				} else if ($vfraction >= 0.625 && $vfraction <= 0.874){
					$cfraction = 0.75;
				} else if ($vfraction >= 0.875){
					$cfraction = 1.0;
				}
				$vol_cuft					= $whole+$cfraction;
				$qty_packing			= $data->val($i, 13, $sheet=0);
				$qty_box					= $data->val($i, 14, $sheet=0);
				$knock_down				= $data->val($i, 15, $sheet=0);
				$gross_kg					= $data->val($i, 16, $sheet=0);
				$gross_lbs				=	$gross_kg*2.204;
				$qty_20						= $data->val($i, 17, $sheet=0);
				$qty_40						= $data->val($i, 18, $sheet=0);
				$qty_40hc					= $data->val($i, 19, $sheet=0);
				$prod_detail			= $data->val($i, 20, $sheet=0);
				$remarks					= $data->val($i, 21, $sheet=0);
				$product_photo		= $data->val($i, 22, $sheet=0);
				
			//	$q = "SELECT COUNT(*) AS tcek FROM product WHERE product_code='$kode_product' and product_coll='$collect'";
				//$fp=fopen("dataimpprod.txt","w");
				//fwrite($fp,$q);
				//$q_cek = $this->app_model->manualQuery($q);
			//	$h_cek = $q_cek->row();
				
			//	if($h_cek->tcek > 0)
			//	{			 
					$query = "UPDATE product SET 	product_photo='$product_photo', category='$category', cm_length='$cm_length', cm_width='$cm_width', cm_height='$cm_height', 
																				inch_length='$inch_length', inch_width='$inch_width', inch_height='$inch_height', weight_kg='$weight_kg', weight_lbs='$weight_lbs', 
																				ext_qty='$ext_qty', ext_qty2='$ext_qty2', ext_length='$ext_length', ext_length2='$ext_length2', cm_seat='$cm_seat', inch_seat='$inch_seat',
																				cm_clear='$cm_clear', inch_clear='$inch_clear', vol_m3='$vol_m3', vol_cuft='$vol_cuft', qty_packing='$qty_packing', qty_box='$qty_box',
																				knock_down='$knock_down', gross_kg='$gross_kg', gross_lbs='$gross_lbs', qty_20='$qty_20', qty_40='$qty_40', qty_40hc='$qty_40hc', 
																				prod_detail='$prod_detail', remarks='$remarks', createdby='$tuser', createdtime='$tgl', editedby='$tuser', editedtime='$tgl'
										where product_code='$kode_product' and product_coll='$collect' and companyarea='$loc'";
					$hasil = $this->app_model->manualQuery($query);
					
					$sukses++;
					$couth="sukses";
				//}
				//else 
				//{
			//		$gagal++;
			//		$couth="sudah ada";
			//	} 
				
				$d['text'][$arr] = "$kode_product - $collect $couth $vol_m3 $vfraction";
				$arr++;
			}
			
			$d['sukses'] = $sukses;
			$d['gagal'] = $gagal;

			$d['content'] = $this->load->view('import_product/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file import_product.php */
/* Location: ./application/controllers/import_product.php */