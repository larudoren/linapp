<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_beli extends CI_Controller {
	
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

			
			$d['judul']="Rekap Pembelian Barang";
			
			$text = "SELECT * FROM supplier ";
			$d['l_supp'] = $this->app_model->manualQuery($text);
			
			$d['content'] = $this->load->view('rekap_beli/form', $d, true);		
			$this->load->view('home',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$tgl1 = $this->app_model->tgl_sql($this->input->post('tgl1'));
			$tgl2 = $this->app_model->tgl_sql($this->input->post('tgl2'));
			
			$text = "SELECT h_beli.kodebeli, h_beli.tglbeli, supplier.supplier_name, d_beli.kode_barang, d_beli.jmlbeli, d_beli.hargabeli, barang.nama_barang, unit.unit_name, d_beli.status, currency.currency_name, supplier.supplier_name
					FROM h_beli
					JOIN d_beli ON h_beli.kodebeli=d_beli.kodebeli
					JOIN barang ON barang.kode_barang=d_beli.kode_barang
					JOIN supplier ON supplier.supplier_code=h_beli.kode_supplier
					JOIN unit ON unit.unit_code=barang.satuan
					JOIN currency ON currency.currency_code=barang.matauang
					$where
					ORDER BY h_beli.kodebeli ASC";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/view',$d);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			
			$d['prg']= $this->config->item('prg');
			$d['web_prg']= $this->config->item('web_prg');
			
			$d['nama_program']= $this->config->item('nama_program');
			$d['instansi']= $this->config->item('instansi');
			$d['usaha']= $this->config->item('usaha');
			$d['alamat_instansi']= $this->config->item('alamat_instansi');
			$d['judul']="Laporan Pembelian Barang";
			
			$pilih = $this->uri->segment(3);
		
			if($pilih=='all'){
				$where = ' ';
				$d['filter'] = 'Semua Data';
			}elseif($pilih=='tgl'){
				$tgl1 = $this->app_model->tgl_sql($this->uri->segment(4));
				$tgl2 = $this->app_model->tgl_sql($this->uri->segment(5));
				
				$where = " WHERE h_beli.tglbeli BETWEEN '$tgl1' AND '$tgl2'";
				$d['filter'] = 'Tanggal '.$this->app_model->tgl_indo($tgl1).' s.d '.$this->app_model->tgl_indo($tgl2);
			}elseif($pilih=='supplier'){
				$supplier = $this->uri->segment(4);
				$where = " WHERE h_beli.kode_supplier='$supplier'";	
				$d['filter'] = 'Supplier '.$supplier;
			}else{
				$kode = $this->uri->segment(4);
				$where = " WHERE d_beli.kode_barang='$kode'";
				$d['filter'] = 'Kode Barang '.$kode;
			}
			
			$text = "SELECT h_beli.kodebeli, h_beli.tglbeli, h_beli.kode_supplier, supplier.supplier_name, d_beli.kode_barang, d_beli.jmlbeli, d_beli.hargabeli, barang.nama_barang, unit.unit_name, supplier.supplier_name
					FROM h_beli 
					JOIN d_beli ON h_beli.kodebeli=d_beli.kodebeli
					JOIN barang ON d_beli.kode_barang=barang.kode_barang
					JOIN supplier ON supplier.supplier_code=h_beli.kode_supplier
					JOIN unit ON unit.unit_code=barang.satuan
					$where
					ORDER BY h_beli.kodebeli ASC ";
			$d['data'] = $this->app_model->manualQuery($text);
			
			$this->load->view('lap_beli/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

}

/* End of file profil.php */
/* Location: ./application/controllers/profil.php */