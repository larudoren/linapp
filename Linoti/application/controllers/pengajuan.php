<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){			
			$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
			$add_session['myheader'] = $d['myheader'];
			$this->session->set_userdata($add_session);
			
			$d['prg']							= $this->config->item('prg');
			$d['web_prg']					= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');

			
			$d['judul']						=	"Form Pengajuan";
			
			
			
			
			$d['content'] = $this->load->view('pengajuan/view', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function pengajuan_barang() {
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$this->load->view('pengajuan/pengajuan');
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tes() {
		$this->load->view('pengajuan/pengajuan');
	}
}

/* End of file pengajuan.php */
/* Location: ./application/controllers/pengajuan.php */