<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access {

    var $user;
    //var $CI;
    function Access() {
        $this->CI = & get_instance();

        $this->CI->load->helper('cookie');
        //$this->CI->load->model('model_notif');
        //$this->CI->load->model('user_mo del');

        $this->user_model = & $this->CI->user_model;
        $this->log_model = & $this->CI->log_model;
    }

    /**
     * proses login
     * 0 = username tak ada
     * 1 = sukses
     * 2 = password salah
     * @param unknown_type $username
     * @param unknown_type $password
     * @return boolean
     */
    function login($username, $password) {
        $query = $this->user_model->get_login_info($username);
        $pre = $query->_fetch_object();
        $result = empty($pre[0]) ? FALSE : $pre[0];
        //var_dump($result);
        //echo $result->USER_PASS;
        //die();
        if ($result) {
            $password = sha1($password);
            if ($password == $result->PASSWORD) {
                    $this->CI->session->set_userdata('ukm_user_id', $result->USER_ID);
                    $this->CI->session->set_userdata('ukm_username', $result->USERNAME);
                    $this->CI->session->set_userdata('ukm_role', $result->ROLENAME);
                    $this->CI->session->set_userdata('ukm_usermail', $result->EMAIL);
                    $this->CI->session->set_userdata('ukm_role_id', $result->USER_ROLE);
                    $this->CI->session->set_userdata('ukm_ukmid', $result->UKM_ID);
                    $this->CI->session->set_userdata('ukm_name', $result->UKM_NAME);

                    $data = array(
                        'user_status' => "1",
                    );
                    $datalog = array(
                        'log_text' => "User " . $result->USERNAME . " LOGIN di SIM UKM",
                        'user_id' => $result->USER_ID
                    );

                    $log_id = $result->USER_ID;
                    $log_teks = 'Akun User ' . $result->USERNAME . ' telah LOGIN di SIM UKM';
                    //$this->user_model->update($result->USER_ID, $data);
                    $this->user_model->update_status($result->USER_ID, 1);
                    $this->log_model->insert($log_id, $log_teks);

                    return 1;
            } else {
                return 2;
            }
        }
        return 0;
    }

    /**
     * cek apakah sudah login
     * @return boolean
     */
    function is_login() {
        $check = $this->CI->session->userdata('ukm_user_id');
        if(!empty($check)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    function cek_akses($kode_menu) {
        $role_cookie = $this->CI->session->userdata('ukm_role_id');
        if ($this->user_model->get_akses($kode_menu, $role_cookie) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function cek_akses_level($kode_menu, $role) {
        if ($this->user_model->get_akses($kode_menu, $role) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_username() {
        return $this->CI->session->userdata('ukm_username');
    }

    function get_usermail() {
        return $this->CI->session->userdata('ukm_usermail');
    }

    function get_role() {
        return $this->CI->session->userdata('ukm_role');
    }

    function get_roleid() {
        return $this->CI->session->userdata('ukm_role_id');
    }

    function get_userid() {
        return $this->CI->session->userdata('ukm_user_id');
    }

    function get_ukmid() {
        return $this->CI->session->userdata('ukm_ukmid');
    }

    function get_ukmname() {
        return $this->CI->session->userdata('ukm_name');
    }

    /**
     * logout
     */
    function logout() {
        $datalog = array(
            'log_text' => "User " . $this->get_username() . " LOGOUT di SIM UKM",
            'user_id' => $this->get_userid()
        );
        $log_id = $this->get_userid();
        $log_teks = 'Akun User ' . $this->get_username() . ' telah LOGOUT di SIM UKM';

        $this->user_model->update_status($this->get_userid(), 0);
        $this->log_model->insert($log_id, $log_teks);

        $this->CI->session->unset_userdata('ukm_user_id');
        $this->CI->session->unset_userdata('ukm_username');
        $this->CI->session->unset_userdata('ukm_role');
        $this->CI->session->unset_userdata('ukm_usermail');
        $this->CI->session->unset_userdata('ukm_role_id');
        $this->CI->session->unset_userdata('ukm_urlke');
        $this->CI->session->unset_userdata('ukm_pesan');
        $this->CI->session->unset_userdata('ukm_ukmid');
    }

}
