<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		/*
		$this->load->helper('cookie');
		if ($_cookie['username']!='' && $_cookie['password']!='' && $_cookie['companyarea']!='')
			$this->app_model->getLoginDataB($_cookie['username'],$_cookie['password'],$_cookie['companyarea']); */
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$add_session['myheader'] = '';
			$this->session->set_userdata($add_session);
			$d['prg']= $this->config->item('prg');
			$d['web_prg']		= $this->config->item('web_prg');
			
			$d['nama_program']		= $this->config->item('nama_program');
			$d['instansi']				= $this->config->item('instansi');
			$d['usaha']						= $this->config->item('usaha');
			$d['alamat_instansi']	= $this->config->item('alamat_instansi');
			
			$d['judul']	=	"Welcome";

			$d['content']	= $this->load->view('content',$d,true);
			$d['mymenu']	= 'Research';
			//$d['myheader']	= '';
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function logout(){
		$cek = $this->session->userdata('logged_in');
		if(empty($cek))
		{
			header('location:'.base_url().'index.php/login');
		}else{
			$this->session->sess_destroy();
			header('location:'.base_url().'index.php/login');
		}
	}
	
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */