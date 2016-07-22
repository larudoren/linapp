<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_beli extends CI_Controller {
	
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');

			
			$d['judul']="Laporan Pembelian Barang";
			
			$text = "SELECT * FROM supplier where companyarea='$loc' ORDER BY supplier_name";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$text2 = "SELECT * FROM departemen WHERE companyarea='$loc' and dept_code<>'000'";
			$d['l_dept'] = $this->app_model->manualQuery($text2);
			
			$d['content'] = $this->load->view('lap_beli/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$kode = $this->input->post('kode');
			$tgl1 = $this->app_model->tgl_sql($this->input->post('tgl1'));
			$tgl2 = $this->app_model->tgl_sql($this->input->post('tgl2'));
			$supplier = $this->input->post('supplier');
			$departemen = $this->input->post('departemen');
			$pilih = $this->input->post('pilih');
			
			if($pilih=='supplier'){
				$where = " h_beli.kode_supplier='$supplier' AND";	
			}elseif($pilih=='departemen'){
				$where = " barang.departemen='$departemen' AND";
			}else{
				$where = " d_beli.kode_barang='$kode' AND";
			}
			
			$text = "SELECT h_beli.po, h_beli.tglbeli, supplier.supplier_name, d_beli.kode_barang, d_beli.jmlbeli, d_beli.hargabeli, barang.nama_barang, unit.unit_name, d_beli.status, currency.currency_name, supplier.supplier_name
					FROM h_beli
					JOIN d_beli ON h_beli.po=d_beli.po and d_beli.companyarea=h_beli.companyarea
					JOIN barang ON barang.kode_barang=d_beli.kode_barang and barang.companyarea=d_beli.companyarea
					JOIN supplier ON supplier.supplier_code=h_beli.kode_supplier and supplier.companyarea=h_beli.companyarea
					JOIN unit ON unit.unit_code=barang.satuan
					JOIN currency ON currency.currency_code=d_beli.currency
					WHERE $where h_beli.companyarea='$loc' and h_beli.tglbeli BETWEEN '$tgl1' AND '$tgl2'
					ORDER BY h_beli.po ASC";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['judul']="Laporan Pembelian Barang";
			
			$pilih = $this->uri->segment(3);
			$supplier = $this->uri->segment(4);
			$kode = $this->uri->segment(4);
			$departemen = $this->uri->segment(4);
			$tgl1 = $this->app_model->tgl_sql($this->uri->segment(6));
			$tgl2 = $this->app_model->tgl_sql($this->uri->segment(8));
			
					
			if($pilih=='supplier'){
				$where = " h_beli.kode_supplier='$supplier' AND";	
			}elseif($pilih=='departemen'){
				$where = " barang.departemen='$departemen' AND";
			}elseif($pilih=='kode'){
				$where = " d_beli.kode_barang='$kode' AND";
			}
			
			$text = "SELECT h_beli.po, h_beli.tglbeli, supplier.supplier_name, d_beli.kode_barang, d_beli.jmlbeli, d_beli.hargabeli, barang.nama_barang, unit.unit_name, d_beli.status, currency.currency_name, supplier.supplier_name
					FROM h_beli
					JOIN d_beli ON h_beli.po=d_beli.po and d_beli.companyarea=h_beli.companyarea
					JOIN barang ON barang.kode_barang=d_beli.kode_barang and barang.companyarea=d_beli.companyarea
					JOIN supplier ON supplier.supplier_code=h_beli.kode_supplier and supplier.companyarea=h_beli.companyarea
					JOIN unit ON unit.unit_code=barang.satuan
					JOIN currency ON currency.currency_code=d_beli.currency
					WHERE $where h_beli.companyarea='$loc' and h_beli.tglbeli BETWEEN '$tgl1' AND '$tgl2'
					ORDER BY h_beli.po ASC";
			
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */