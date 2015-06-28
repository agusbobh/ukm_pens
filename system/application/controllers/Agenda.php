<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agenda extends MY_Controller {

    public function Agenda() {
        parent::MY_Controller();
        $this->load->model('ukm_model', '', true);
        $this->load->model('log_model', '', true);
        $this->load->model('agenda_model', '', true);
    }

    public function index() {

    }

    function tambah(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tambah-judul', 'Judul','trim|required|strip_tags|min_length[5]');
        $this->form_validation->set_rules('tambah-teks', 'Deskripsi','trim|required|strip_tags');
        $this->form_validation->set_rules('tambah-time', 'Waktu','trim|required|strip_tags');
        //$this->form_validation->set_rules('tambah-timeto', 'Waktu Akhir','trim|required|strip_tags');
        $this->form_validation->set_rules('tambah-status', 'Status','required|strip_tags');

        if($this->form_validation->run() == TRUE){

            $string = addslashes($this->input->post('tambah-time', TRUE));
            $pemisah = strrpos($string, ' sampai ');
            $timeto = trim(substr($string, $pemisah + 7));
            $timefrom = trim(substr($string, 0, $pemisah));

            $data = array(
                'agenda_title' => addslashes($this->input->post('tambah-judul', TRUE)),
                'agenda_text' => addslashes($this->input->post('tambah-teks', TRUE)),
                'agenda_time' => $timefrom,
                'agenda_timeto' => $timeto,
                'agenda_status' => addslashes($this->input->post('tambah-status', TRUE)),
                'ukm_id' => $this->access->get_ukmid()
            );

            $this->agenda_model->insert($data);

            $status['status'] = 1;
            $status['pesan'] = 'Agenda baru berhasil ditambahkan';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function edit(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('edit-judul', 'Judul','trim|required|strip_tags|min_length[5]');
        $this->form_validation->set_rules('edit-status', 'Status','required|strip_tags');
        $this->form_validation->set_rules('edit-teks', 'Deskripsi','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-time', 'Waktu Awal','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-id', 'Agenda ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){

            $string = addslashes($this->input->post('edit-time', TRUE));
            $pemisah = strrpos($string, ' sampai ');
            $timeto = trim(substr($string, $pemisah + 7));
            $timefrom = trim(substr($string, 0, $pemisah));

            $judul = addslashes($this->input->post('edit-judul', TRUE));
            $teks = addslashes($this->input->post('edit-teks', TRUE));
            $idstatus = addslashes($this->input->post('edit-status', TRUE));
            $idagenda = addslashes($this->input->post('edit-id', TRUE));

            $data = array(
                'agenda_title' => $judul,
                'agenda_text' => $teks,
                'agenda_time' => $timefrom,
                'agenda_timeto' => $timeto,
                'agenda_status' => $idstatus
            );

            $this->agenda_model->update($idagenda,$data);

            $status['status'] = 1;
            $status['pesan'] = "Perubahan pada Agenda berhasil disimpan";

        }else{
          $status['status'] = 0;
          $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapus(){
      $this->load->library('form_validation');
      $this->form_validation->set_rules('hapus-id', 'User ID','required|strip_tags');

      if($this->form_validation->run() == TRUE){
        $id = addslashes($this->input->post('hapus-id', TRUE));
        $this->agenda_model->update($id,array("agenda_status" => 2));

        $status['status'] = 1;
        $status['pesan'] = 'Agenda "' . addslashes($this->input->post('hapus-uname', TRUE)) . '" berhasil dihapus';
      }else{
        $status['status'] = 0;
        $status['pesan'] = validation_errors();
      }

      echo json_encode($status);
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
        $rows = 6;
        if (isset($_GET['iDisplayLength'])) {
            $rows = intval($_GET['iDisplayLength']);
            if ($rows < 5 || $rows > 500) {
                $rows = 6;
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

    public function get_databox() {
        $ukmid = $this->access->get_ukmid();
        // data buat box
        
        $dat = $this->agenda_model->get_subtotal($ukmid, 2);
        $data['boxsemua'] = $dat->_fetch_object();
        $dat = $this->agenda_model->get_subtotal($ukmid, 0);
        $data['boxdraft'] = $dat->_fetch_object();
        $dat = $this->agenda_model->get_subtotal($ukmid, 1);
        $data['boxpublish'] = $dat->_fetch_object();
        $dat = $this->agenda_model->get_subtotal($ukmid, 3);
        $data['boxselesai'] = $dat->_fetch_object();

        echo json_encode($data);
    }

}

?>
