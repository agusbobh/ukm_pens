<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Controller {

    function Login() {
        parent::Controller();
        $this->load->model('user_model', '', true);
        $this->load->model('log_model', '', true);
    }

    function index() {
        if(!$this->access->is_login()){
            if($this->session->userdata('ukm_pesan')) {
                $data['error'] = $this->session->userdata('ukm_pesan');
                $this->session->unset_userdata('pesan');
                $this->load->view('login_view',$data);
            } else {
                $this->load->view('login_view');
            }
		}else{
            redirect('dashboard');
		}
    }

    /*
    // fungsi untuk login
    function dologin() {
        $this->load->library('form_validation');
        // mengambil username dan password dari text field yang ada di form login
        $rules['username']	= "trim|required|strip_tags";
        $rules['password']	= "trim|required|strip_tags";

        $this->form_validation->set_rules($rules);
        // $this->session->unset_userdata('ukm_urlke');
        // $urlke = $this->session->userdata('ukm_urlke') == NULL ? 'dashboard' : $this->session->userdata('ukm_urlke');

        if ($this->form_validation->run() == TRUE) {
            $rules['token'] = "callback_check_login";
            $this->form_validation->set_rules($rules);

            //$this->validation->set_rules('token', 'callback_check_login');
            if ($this->form_validation->run() == FALSE) {
                //Jika login gagal
                $status['status'] = 0;
                log_message('error', 'Login Gagal');
                //$status['error'] = error_string();
            } else {
                //Jika sukses
                $status['status'] = 1;
            }
        } else {
            //Jika form validasi gagal
            $status['status'] = 0;
            log_message('error', 'Validasi Gagal');
            //$status['error'] = error_string();
        }

        if($status['status'] == 1) {
            redirect('dashboard');
        } else {
            $this->load->view('login_view', $status);
        }

    }
    */

    function dologin() {
        $this->load->library('form_validation');
        // mengambil username dan password dari text field yang ada di form login
        $this->form_validation->set_rules('username', 'Username','trim|required|strip_tags');
        $this->form_validation->set_rules('password', 'Password','trim|required|strip_tags');
        $this->session->unset_userdata('ukm_urlke');
        $urlke = $this->session->userdata('ukm_urlke') == NULL ? 'dashboard' : $this->session->userdata('ukm_urlke');

        if ($this->form_validation->run() == TRUE) {
            $this->form_validation->set_rules('token', 'token', 'callback_check_login');
            if ($this->form_validation->run() == FALSE) {
                //Jika login gagal
                $status['status'] = 0;
                $status['error'] = validation_errors();
            } else {
                //Jika sukses
                $status['status'] = 1;
            }
        } else {
            //Jika form validasi gagal
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }

        if($status['status'] == 1) {
            redirect($urlke);
        } else {
            $this->load->view('login_view', $status);
        }

    }

    function check_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $login = $this->access->login($username, $password);
        if ($login == 1) {
            return TRUE;
        } else if ($login == 2) {
            $this->form_validation->set_message('check_login', 'Password yang dimasukkan salah');
            return FALSE;
        } else {
            $this->form_validation->set_message('check_login', 'Username yang dimasukkan tidak dikenal');
            return FALSE;
        }
    }

    // buat mengirimkan informasi kesalahan
    function fals() {
        $data['error'] = $this->session->userdata('ukm_pesan');
        $this->load->view('login_view', $data);
    }

    // buat logout
    function logout() {
        $datanotif = array(
            'notif_teks' => "User " . $this->session->userdata('username') . " logout",
            'notif_tipe' => "3",
            'notif_baca' => "0"
        );
        $data = array(
            'user_status' => "0",
            'user_pos' => "0"
        );
        $this->model_user->update($this->session->userdata('ukm_user_id'), $data);
        $this->model_notif->insert($datanotif);
        $this->session->sess_destroy();
        redirect('auth');
    }
    function reset() {
        // ambil value dari form
        $uname = $this->input->post('username');
        $pass1 = $this->input->post('password');
        $pass2 = $this->input->post('password2');

        $cekuser = $cekpass = FALSE;
        $pesan = "";

        $data = array(
            'user_name' => $uname
        );
        $cek = $this->model_user->reset($data);
        if(!is_null($cek)) {
            $cekuser = TRUE;
            if($pass1 == $pass2) {
                $cekpass = TRUE;
                redirect('auth');
            }
        }

        if(!$cekuser) $pesan = "Username tidak terdaftar";
        elseif(!$cekpass) $pesan = "Password tidak sama";

        $newdata = array(
            'ukm_pesan' => $pesan
        );
        $this->session->set_userdata($newdata);
        redirect('auth/fals');
    }

}
