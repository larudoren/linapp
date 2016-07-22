<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rename_file extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']						=	"Rename File";			
			
			$d['content'] 				= $this->load->view('rename_file/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function myrename()
	{
		$cek 	= $this->session->userdata('logged_in');
		$loc 	= $this->session->userdata('companyarea');
		$user = $this->session->userdata('username');
		$tgl 	= date("Y-m-d H:i:s");
		if(!empty($cek)){
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			$d['judul']="Rename Files";
	
			$sukses = 0;
			$gagal 	= 0;
			$arr 		= 0;
			$d['text'] = array();
			$mydir = 'C:/xampp/htdocs/ChakraNaga/asset/product_photo';
			if ($handle = opendir($mydir)) {
				while (false !== ($fileName = readdir($handle))) {
						if (substr("$fileName", 0, 1) != "."){
							$pos = strrpos($fileName," ");
							if ($pos !== false){
								$newName = str_replace(" ","_",$fileName);
								rename($mydir.'/'.$fileName, $mydir.'/'.$newName);
								$d['text'][$arr] = "$fileName - $newName";
								$arr++;
							}
						}
				}
				closedir($handle);
			}
			

			$d['content'] = $this->load->view('rename_file/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
}

/* End of file rename_file.php */
/* Location: ./application/controllers/rename_file.php */