<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends CI_Controller {
	var $menuitem = 'pengguna';
	public function index()
	{
		$cek = $this->session->userdata('logged_in');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$nView = $this->app_model->myaccess($this->menuitem);
			if ($nView=='1'){
				$d['myheader'] = isset($_REQUEST['myheader']) ? $_REQUEST['myheader'] : $myheader;
				$add_session['myheader'] = $d['myheader'];
				$this->session->set_userdata($add_session);
				//$fp=fopen("dataaccord.txt","w");
				//fwrite($fp,$d['myheader']);
				$cari = $this->input->post('txt_cari');
				$d['accordtitle'] = 'Master';
				$d['idmenu'] = 'pengguna';
				$companyarea = $this->session->userdata("companyarea");
				if(empty($cari)){
					$where = " WHERE companyarea = '$companyarea'";
				}else{
					$where = " WHERE companyarea = '$companyarea' AND (username LIKE '%$cari%' OR nama_lengkap LIKE '%$cari%')";
				}
				
				$d['prg']= $this->config->item('prg');
				$d['web_prg']= $this->config->item('web_prg');
				
				$d['nama_program']= $this->config->item('nama_program');
				$d['instansi']= $this->config->item('instansi');
				$d['usaha']= $this->config->item('usaha');
				$d['alamat_instansi']= $this->config->item('alamat_instansi');

				
				$d['judul']="User";
				
				//paging
				$page=$this->uri->segment(3);
				$limit=$this->config->item('limit_data');
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;
				
				$text = "SELECT username FROM admins $where ";		
				$tot_hal = $this->app_model->manualQuery($text);		
				
				$d['tot_hal'] = $tot_hal->num_rows();
				
				$config['base_url'] = site_url() . '/pengguna/index/';
				$config['total_rows'] = $tot_hal->num_rows();
				$config['per_page'] = $limit;
				$config['uri_segment'] = 3;
				$config['next_link'] = 'Next &raquo;';
				$config['prev_link'] = '&laquo; Prev';
				$config['last_link'] = '<b>Last &raquo; </b>';
				$config['first_link'] = '<b> &laquo; First</b>';
				$this->pagination->initialize($config);
				$d["paginator"] =$this->pagination->create_links();
				$d['hal'] = $offset;
				

				$text = "SELECT username,nama_lengkap,level FROM admins $where 
						ORDER BY level ASC 
						LIMIT $limit OFFSET $offset";
				$d['data'] = $this->app_model->manualQuery($text);
				
				
				$d['content'] = $this->load->view('pengguna/view', $d, true);		
				$this->load->view('home',$d);
			} else{
				header('location:'.base_url().'index.php/home');
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function tambah()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$nView = $this->app_model->myaccess($this->menuitem);
			if ($nView=='1'){
				$d['prg']= $this->config->item('prg');
				$d['web_prg']= $this->config->item('web_prg');
				$d['myheader'] = $myheader;
				$d['nama_program']= $this->config->item('nama_program');
				$d['instansi']= $this->config->item('instansi');
				$d['usaha']= $this->config->item('usaha');
				$d['alamat_instansi']= $this->config->item('alamat_instansi');

				$d['judul']="Add User";
				
				$d['pusername']		='';
				$d['pnama_lengkap']	='';
				$d['pwd']			='';
				$d['level']			='';
				$d['status']		='1';
				
				$text = "SELECT * FROM level";
				$d['l_level'] = $this->app_model->manualQuery($text);
				
				$text = "SELECT * FROM menusource where INDEXCHILD='1' and companyarea='$loc' and status='1' order by menuid";
				$d['l_menu_h'] = $this->app_model->manualQuery($text);
				
				$text = "SELECT a.*,b.`view` FROM menusource a left join otorisasi b on b.companyarea=a.companyarea and b.menuid=a.menuid and b.OPERATORID='' where a.INDEXCHILD!='1' and a.status='1' and a.companyarea='$loc'";
				$d['l_menu_d'] = $this->app_model->manualQuery($text);
				
				$text ="SELECT a.*,b.`view` FROM cotationsource a left join otorisasicotation b on b.companyarea=a.companyarea and b.cotationid=a.cotationid and b.OPERATORID='' where a.companyarea='$loc'";
				$d['l_cotation_d'] = $this->app_model->manualQuery($text);
				
				$d['content'] = $this->load->view('pengguna/form', $d, true);		
				$this->load->view('home',$d);
			}else{
				header('location:'.base_url().'index.php/home');
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function edit()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		$myheader = $this->session->userdata('myheader');
		if(!empty($cek)){
			$nView = $this->app_model->myaccess($this->menuitem);
			if ($nView=='1'){
				$d['myheader'] = $myheader;
				$d['prg']= $this->config->item('prg');
				$d['web_prg']= $this->config->item('web_prg');
				
				$d['nama_program']= $this->config->item('nama_program');
				$d['instansi']= $this->config->item('instansi');
				$d['usaha']= $this->config->item('usaha');
				$d['alamat_instansi']= $this->config->item('alamat_instansi');
				
				$d['judul'] = "Edit User";
				
				$id = $this->uri->segment(3);
				$text = "SELECT * FROM admins WHERE username='$id' and companyarea='$loc'";
				$data = $this->app_model->manualQuery($text);
				if($data->num_rows() > 0){
					foreach($data->result() as $db){
						$d['pusername']		=$id;
						$d['pnama_lengkap']	=$db->nama_lengkap;
						$d['pwd']	='';
						$d['level']			=$db->level;
					}
				}else{
						$d['username']		=$id;
						$d['pnama_lengkap']	='';
						$d['pwd']	='';
						$d['level']			='';
				}
				$d['status']			='2';
				$text = "SELECT * FROM level";
				$d['l_level'] = $this->app_model->manualQuery($text);
				
				$text = "SELECT * FROM menusource where INDEXCHILD='1' and companyarea='$loc' and status='1' order by menuid";
				$d['l_menu_h'] = $this->app_model->manualQuery($text);
				
				$text = "SELECT a.*,b.`view` FROM menusource a left join otorisasi b on b.companyarea=a.companyarea and b.menuid=a.menuid and b.OPERATORID='$id' where a.INDEXCHILD!='1' and a.status='1' and a.companyarea='$loc'";
				$d['l_menu_d'] = $this->app_model->manualQuery($text);
				
				$text ="SELECT a.*,b.`view` FROM cotationsource a left join otorisasicotation b on b.companyarea=a.companyarea and b.cotationid=a.cotationid and b.OPERATORID='$id' where a.companyarea='$loc'";
				$d['l_cotation_d'] = $this->app_model->manualQuery($text);
				//$text = "SELECT * FROM otoritas where username='".strtoupper($id)."'";
				//$d['l_menu_o'] = $this->app_model->manualQuery($text);
										
				$d['content'] = $this->load->view('pengguna/form', $d, true);		
				$this->load->view('home',$d);
			}else{
				header('location:'.base_url().'index.php/home');
			}
		}else{
			header('location:'.base_url());
		}
	}
	
	public function hapus()
	{
		$cek = $this->session->userdata('logged_in');
		$loc = $this->session->userdata('companyarea');
		if(!empty($cek)){			
			$nView = $this->app_model->myaccess($this->menuitem);
			if ($nView=='1'){
				$id = $this->uri->segment(3);
				$this->app_model->manualQuery("DELETE FROM admins WHERE username='$id' and companyarea='$loc'");
				$this->app_model->manualQuery("DELETE FROM otorisasi WHERE OPERATORID='$id' and companyarea='$loc'");
				$this->app_model->manualQuery("DELETE FROM otorisasicotation WHERE OPERATORID='$id' and companyarea='$loc'");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/pengguna'>";	
			}else{
				header('location:'.base_url().'index.php/home');
			}			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function simpan()
	{
		
		$cek  = $this->session->userdata('logged_in');
		$loc  = $this->session->userdata('companyarea');
		$tuser = $this->session->userdata('username');
		$tgl  = date("Y-m-d H:i:s");
		if(!empty($cek)){
			$nView = $this->app_model->myaccess($this->menuitem);
			if ($nView=='1'){
				$pwd 	= $this->input->post('pwd');
				$nama 	= $this->input->post('pnama_lengkap');
				$level	= $this->input->post('level');
				$user	= preg_replace('/[^a-zA-Z0-9]/','',$this->input->post('pusername'));
				
				$text = "SELECT MENUID FROM menusource where INDEXCHILD!='1' and companyarea='$loc'";
				$data = $this->app_model->manualQuery($text);
				$jml = $data->num_rows();
				
				foreach($data->result() as $db){
					//if (empty($this->input->post($db->MENUID)))
					//	$myisi=0;
					//else
					//	$myisi=$this->input->post($db->MENUID);
					if (empty($this->input->post('menu_'.$db->MENUID)))
						{$up_d[$db->MENUID] = 0;}
					else
						{$up_d[$db->MENUID] = 1;}
				}
				
				$text = "SELECT COTATIONID FROM cotationsource where companyarea='$loc'";
				$data = $this->app_model->manualQuery($text);
				foreach($data->result() as $db){
					if (empty($this->input->post('cotation_'.$db->COTATIONID)))
						{$up_c[$db->COTATIONID] = 0;}
					else
						{$up_c[$db->COTATIONID] = 1;}
						
				}
				
				
				//if ($this->uri->segment(2)!='edit'){
				//	$up['username']		= $user;
				//}
				$up['nama_lengkap']	= $nama;
				//$up['password']		= md5($pwd);
				$up['level']		= $level;
				$up['editedby']		= $tuser;
				$up['editedtime']	= $tgl;
				
				$id['username']		=$user;
				$id['companyarea']	=$loc;
				
				$id_o['OPERATORID']		=$user;
				$id_o['COMPANYAREA']	=$loc;
				
				$data = $this->app_model->getSelectedData("admins",$id);
				if($data->num_rows()>0){
					if(empty($pwd)){
						$this->app_model->updateData("admins",$up,$id);
					}else{
						$up['password']		= md5($pwd);
						$this->app_model->updateData("admins",$up,$id);
					}
					$data = $this->app_model->getSelectedData("otorisasi",$id_o);
					
					if($data->num_rows()>0){
						foreach ($data->result() as $u){
							$this->app_model->manualQuery("UPDATE otorisasi SET `VIEW`='".$up_d[$u->MENUID]."',EDITEDBY='$tuser',EDITEDTIME='$tgl' Where OPERATORID='".strtoupper($user)."' and companyarea='$loc' and menuid='".$u->MENUID."'");
						}
						$text = "SELECT A.MENUID FROM menusource A where A.INDEXCHILD!='1' and A.companyarea='$loc' and A.MENUID NOT IN (SELECT MENUID FROM otorisasi B where B.COMPANYAREA=A.COMPANYAREA and B.OPERATORID='$user')";
						$data1 = $this->app_model->manualQuery($text);
						foreach($data1->result() as $in){
							$myquery = "INSERT INTO otorisasi (OPERATORID,COMPANYAREA,MENUID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->MENUID."','".$up_d[$in->MENUID]."','$tuser','$tgl','$tuser','$tgl')";
							$this->db->query($myquery); 
						}
					}
					else{
						$text = "SELECT MENUID FROM menusource where INDEXCHILD!='1' and companyarea='$loc'";
						$data1 = $this->app_model->manualQuery($text);
						foreach($data1->result() as $in){
							$myquery = "INSERT INTO otorisasi (OPERATORID,COMPANYAREA,MENUID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->MENUID."','".$up_d[$in->MENUID]."','$tuser','$tgl','$tuser','$tgl')";
							$this->db->query($myquery); 
							
						}
					} 
					$data = $this->app_model->getSelectedData("otorisasicotation",$id_o);
					if($data->num_rows()>0){
						foreach ($data->result() as $u){
							$this->app_model->manualQuery("UPDATE otorisasicotation SET `VIEW`='".$up_c[$u->COTATIONID]."',EDITEDBY='$tuser',EDITEDTIME='$tgl' Where OPERATORID='".strtoupper($user)."' and companyarea='$loc' and cotationid='".$u->COTATIONID."'");
						}
						$text = "SELECT A.COTATIONID FROM cotationsource A where A.companyarea='$loc' and A.COTATIONID NOT IN (SELECT COTATIONID FROM otorisasicotation B where B.COMPANYAREA=A.COMPANYAREA and B.OPERATORID='$user')";
						$data1 = $this->app_model->manualQuery($text);
						foreach($data1->result() as $in){
							$myquery = "INSERT INTO otorisasicotation (OPERATORID,COMPANYAREA,COTATIONID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->COTATIONID."','".$up_c[$in->COTATIONID]."','$tuser','$tgl','$tuser','$tgl')";
							$this->db->query($myquery); 
						}
					} else {
						$text = "SELECT COTATIONID FROM cotationsource where companyarea='$loc'";
						$data1 = $this->app_model->manualQuery($text);
						foreach($data1->result() as $in){
							$myquery = "INSERT INTO otorisasicotation (OPERATORID,COMPANYAREA,COTATIONID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->COTATIONID."','".$up_c[$in->COTATIONID]."','$tuser','$tgl','$tuser','$tgl')";
							$this->db->query($myquery); 
							
						}
					}
					
					//echo 'Update data Sukses';
				}else{
					$up['username']		= $user;
					$up['password']		= md5($pwd);
					$up['companyarea']	= $loc;
					$up['createdby']	= $tuser;
					$up['createdtime']	= $tgl;
					$this->app_model->insertData("admins",$up);
					$text = "SELECT * FROM menusource where INDEXCHILD!='1' and companyarea='$loc'";
					$data = $this->app_model->manualQuery($text);
					
					foreach($data->result() as $in){
						$this->app_model->manualQuery("INSERT INTO otorisasi (OPERATORID,COMPANYAREA,MENUID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->MENUID."','".$up_d[$in->MENUID]."','$tuser','$tgl','$tuser','$tgl')"); 
					} 
					
					$text = "SELECT * FROM cotationsource where companyarea='$loc'";
					$data = $this->app_model->manualQuery($text);
					
					foreach($data->result() as $in){
						$this->app_model->manualQuery("INSERT INTO otorisasicotation (OPERATORID,COMPANYAREA,COTATIONID,`VIEW`,CREATEDBY,CREATEDTIME,EDITEDBY,EDITEDTIME) values('$user','$loc','".$in->COTATIONID."','".$up_c[$in->COTATIONID]."','$tuser','$tgl','$tuser','$tgl')"); 
					}
					//echo 'Simpan data Sukses';		
				}
			}else{
				header('location:'.base_url().'index.php/home');
			}
		}else{
				header('location:'.base_url());
		}
	
	}
	
}

/* End of file pengguna.php */
/* Location: ./application/controllers/pengguna.php */