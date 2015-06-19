<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
	function MY_Controller(){
		parent::CI_Controller();
		if(!$this->access->is_login()){
			// di redirect ke bagian login
			 $newdata = array(
                 'ukm_pesan' => "Anda harus login untuk mengakses halaman tersebut",
                 'ukm_urlke' => current_url()
             );
             $this->session->set_userdata($newdata);
			redirect('login');
		}
	}

	function is_login(){
		return $this->access->is_login();
	}

	function cek_akses($kode_menu){
		if(!$this->access->cek_akses($kode_menu)){
			redirect('login');
		}
	}
}
