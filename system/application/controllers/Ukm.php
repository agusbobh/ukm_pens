<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ukm extends MY_Controller {

    function UKM() {
        parent::MY_Controller();
        $this->load->model('user_model', '', true);
        $this->load->model('ukm_model', '', true);
    }

    function index() {

    }

    function tambahukm(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tambah-kontak', 'Kontak','trim|required|strip_tags');
        $this->form_validation->set_rules('tambah-user', 'User','strip_tags');
        $this->form_validation->set_rules('tambah-nama', 'Nama UKM','trim|required|strip_tags|min_length[3]|callback_cek_uname');

        $user_id    = addslashes($this->input->post('tambah-user', TRUE));
        $ukm_name   = addslashes($this->input->post('tambah-nama', TRUE));
        $ukm_info  = 'Kosong';
        $ukm_kontak  = addslashes($this->input->post('tambah-kontak', TRUE));


        if($this->form_validation->run() == TRUE){
            $this->ukm_model->insert($user_id, $ukm_name, $ukm_kontak);
            $status['status'] = 1;
            $status['pesan'] = 'UKM baru berhasil dibuat';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function editukm(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edit-kontak', 'Kontak','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-nama', 'Nama UKM','required|strip_tags');
        $this->form_validation->set_rules('edit-user', 'User','required|strip_tags');
        $this->form_validation->set_rules('edit-id', 'UKM ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){

          $idukm = addslashes($this->input->post('edit-id', TRUE));
          $iduser = addslashes($this->input->post('edit-user', TRUE));
          $nama = addslashes($this->input->post('edit-nama', TRUE));
          $kontak = addslashes($this->input->post('edit-kontak', TRUE));
          $tempnama = addslashes($this->input->post('edit-tempnama', TRUE));

          if($nama != $tempnama) {
              $this->form_validation->set_rules('edit-nama', 'Nama UKM','callback_cek_uname');
              if ($this->form_validation->run() == FALSE) {
                  $status['status'] = 0;
                  $status['pesan'] = validation_errors();
              } else {
                  if($iduser == 0) {
                      $data = array(
                        'UKM_NAME' => $nama,
                        'UKM_CONTACT' => $kontak
                      );
                  } else {
                      $data = array(
                        'UKM_NAME' => $nama,
                        'USER_ID' => $iduser,
                        'UKM_CONTACT' => $kontak
                      );
                  }


                  $this->ukm_model->update($idukm,$data);

                  $status['status'] = 1;
                  $status['pesan'] = "Perubahan pada UKM " . $tempnama . " berhasil disimpan";
              }
          } else {
              if($iduser == 0) {
                  $data = array(
                    'UKM_CONTACT' => $kontak
                  );
              } else {
                  $data = array(
                    'USER_ID' => $iduser,
                    'UKM_CONTACT' => $kontak
                  );
              }

              $this->ukm_model->update($idukm,$data);

              $status['status'] = 1;
              $status['pesan'] = "Perubahan pada UKM " . $tempnama . " berhasil disimpan";
          }
        }else{
          $status['status'] = 0;
          $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapusukm(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hapus-id', 'UKM ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('hapus-id', TRUE));
            $this->ukm_model->delete($id);

            $status['status'] = 1;
            $status['pesan'] = 'UKM ' . addslashes($this->input->post('hapus-nama', TRUE)) . ' berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function updateinfo(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('info-id', 'UKM ID','required|strip_tags');
        $this->form_validation->set_rules('info-teks', 'Info Teks','required|strip_tags|trim|max_length[100]');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('info-id', TRUE));
            $teks = addslashes($this->input->post('info-teks', TRUE));

            $this->ukm_model->update($id,array('ukm_info' => $teks));

            $status['status'] = 1;
            $status['pesan'] = 'Info UKM berhasil diperbarui';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function cek_uname($str) {
        $c_nama = $this->ukm_model->cek('UKM_NAME', $str);

        if($c_nama->num_rows() > 0){
            $this->form_validation->set_message('cek_uname', 'Nama UKM sudah digunakan, silakan coba yang lain !!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function getukm() {
        $this->load->library('Json_encode');
        //$sEcho;
        //$iTotal;
        // variable initialization
        $search = "";
        $start = 0;
        $rows = 10;

        // get search value (if any)
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $search = $_GET['sSearch'];
        }

        // limit
        $start = $this->get_start();
        $rows = $this->get_rows();

        // run query to get user listing
        $query = $this->ukm_model->get_daftarukm($start, $rows, $search);
        $iFilteredTotal = $query->num_rows();
        $iTotal = $this->ukm_model->get_count_daftarukm($search);

        $output = array(
            "sEcho" => intval(isset($_GET['sEcho'])),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );

        // get result after running query and put it in array
        $i = $start;
        $counter = $query->result();
        foreach ($counter as $temp){
            $record = array();
            $record[] = $temp->ID;
            $record[] = $temp->Nama;
            $record[] = $temp->Kontak;
            $record[] = $temp->Dibuat;
            $record[] = $temp->Info;
            $record[] = $temp->Status;
            $record[] = '<div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="dropdown">Opsi
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->User).'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Kontak).'\', \''.addslashes($temp->Dibuat).'\')" >Edit</a></li>
                                <li><a href="#" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Nama).'\')" >Hapus</a></li>
                                <li><a href="#" onclick="modalinfo(\''.$temp->ID.'\')" >Perbarui Info</a></li>
                            </ul>
                        </div>';
            //$record[] = '<a onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->Username).'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\', \''.addslashes($temp->Dibuat).'\')" class="btn btn-info btn-xs">Edit</a>
            //             <a onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\')" class="btn btn-danger btn-xs">Hapus</a>
            //             <a onclick="modalpass(\''.$temp->ID.'\', \''.addslashes($temp->Username).')" class="btn btn-success btn-xs">Password</a>';

            //$output['aaData'] = "[[" . "'" . implode("','", $record ) . "'" . "]]";
            //$output['aaData'][]= $record;
        }
        // format it to JSON, this output will be displayed in datatable
          return $record;
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