<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

    function User() {
        parent::MY_Controller();
        $this->load->model('user_model', '', true);
        $this->load->model('log_model', '', true);
    }

    function index() {

    }

    function tambahuser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tambah-email', 'Email','trim|required|strip_tags|valid_email');
        $this->form_validation->set_rules('tambah-ukm', 'UKM','trim|required|strip_tags');
        $this->form_validation->set_rules('tambah-role', 'Role','required|strip_tags');
        $this->form_validation->set_rules('tambah-username', 'Username','trim|required|strip_tags|min_length[3]|callback_cek_uname');
        $this->form_validation->set_rules('tambah-pass', 'Password','trim|required|strip_tags|matches[tambah-passconf]|min_length[5]');
        $this->form_validation->set_rules('tambah-passconf', 'Konfirmasi Password','trim|required|strip_tags');

        $ukm_id    = addslashes($this->input->post('tambah-ukm', TRUE));
        $user_name = addslashes($this->input->post('tambah-username', TRUE));
        $user_mail = addslashes($this->input->post('tambah-email', TRUE));
        $user_pass = sha1(addslashes($this->input->post('tambah-pass', TRUE)));
        $user_role = addslashes($this->input->post('tambah-role', TRUE));

        if($this->form_validation->run() == TRUE){
            $this->user_model->insert($ukm_id, $user_name, $user_mail, $user_pass, $user_role);
            $status['status'] = 1;
            $status['pesan'] = 'User baru berhasil dibuat';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function edituser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edit-email', 'Email','trim|required|strip_tags|valid_email');
        $this->form_validation->set_rules('edit-ukm', 'UKM','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-role', 'Role','required|strip_tags');
        $this->form_validation->set_rules('edit-username', 'Username','trim|required|strip_tags|min_length[3]');
        $this->form_validation->set_rules('edit-id', 'User ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){

          $idukm = addslashes($this->input->post('edit-ukm', TRUE));
          $iduser = addslashes($this->input->post('edit-id', TRUE));
          $idrole = addslashes($this->input->post('edit-role', TRUE));
          $username = addslashes($this->input->post('edit-username', TRUE));
          $email = addslashes($this->input->post('edit-email', TRUE));
          $tempuname = addslashes($this->input->post('edit-tempuname', TRUE));

          if($username != $tempuname) {
              $this->form_validation->set_rules('edit-username', 'Username','callback_cek_uname');
              if ($this->form_validation->run() == FALSE) {
                  $status['status'] = 0;
                  $status['pesan'] = validation_errors();
              } else {
                  $this->user_model->update($iduser,$username, $email, $idrole, $idukm);

                  $status['status'] = 1;
                  $status['pesan'] = "Perubahan pada user " . $tempuname . " berhasil disimpan";

                  if($iduser == $this->access->get_userid()) {
                      $this->session->set_userdata('ukm_username', $username);
                      $this->session->set_userdata('ukm_usermail', $email);
                      $this->session->set_userdata('ukm_role_id', $idrole);
                  }

              }
          } else {
              $this->user_model->update($iduser, $email, $idrole, $idukm);

              $status['status'] = 1;
              $status['pesan'] = "Perubahan pada user " . $tempuname . " berhasil disimpan";

              if($iduser == $this->access->get_userid()) {
                $this->session->set_userdata('ukm_usermail', $email);
                $this->session->set_userdata('ukm_role_id', $idrole);
              }
          }
        }else{
          $status['status'] = 0;
          $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapususer(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('hapus-id', 'User ID','required|strip_tags');

      if($this->form_validation->run() == TRUE){
        $id = addslashes($this->input->post('hapus-id', TRUE));
        $this->user_model->delete($id);

        $status['status'] = 1;
        $status['pesan'] = 'User ' . addslashes($this->input->post('hapus-uname', TRUE)) . ' berhasil dihapus';
      }else{
        $status['status'] = 0;
        $status['pesan'] = validation_errors();
      }

      echo json_encode($status);
    }

    function gantipassword(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pass-baru', 'Password Baru','trim|required|strip_tags|matches[pass-conf]|min_length[5]');
        $this->form_validation->set_rules('pass-conf', 'Konfirmasi Password Baru','trim|required|strip_tags');

        if($this->form_validation->run() == TRUE){
                $passbaru = addslashes($this->input->post('pass-baru', TRUE));
                $iduser = addslashes($this->input->post('pass-id', TRUE));

                $this->user_model->update_pass($iduser,sha1($passbaru));
                $status['status'] = 1;
                $status['pesan'] = 'Password user ' . addslashes($this->input->post('pass-name', TRUE)) . ' berhasil diubah';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function cek_uname($str) {
        $c_nama = $this->user_model->cek('USER_NAME',$str);

        if($c_nama->num_rows() > 0){
            $this->form_validation->set_message('cek_uname', 'Username sudah digunakan, silakan coba yang lain !!');
            return FALSE;
        } else {
            return TRUE;
        }
    }



    /**
     * fungsi tambahan
     *
     *
     */
    function get_start() {
        $start = 0;
        if (isset($_GET['iDisplayStart'])) {
            $start = intval($_GET['iDisplayStart']);

            if ($start < 0)
                $start = 0;
        }

        return $start;
    }

    function get_rows() {
        $rows = 10;
        if (isset($_GET['iDisplayLength'])) {
            $rows = intval($_GET['iDisplayLength']);
            if ($rows < 5 || $rows > 500) {
                $rows = 10;
            }
        }

        return $rows;
    }

    function get_sort_dir() {
        $sort_dir = "ASC";
        $sdir = strip_tags($_GET['sSortDir_0']);
        if (isset($sdir)) {
            if ($sdir != "asc") {
                $sort_dir = "DESC";
            }
        }

        return $sort_dir;
    }

}

?>
