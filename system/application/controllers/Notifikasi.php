<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi extends MY_Controller {

    function Notifikasi() {
        parent::MY_Controller();
        $this->load->model('notif_model', '', true);
        $this->load->model('log_model', '', true);
    }

    function index() {

    }

    function hapusnotif(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hapus-id', 'Role ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('hapus-id', TRUE));
            if($id == 42) {
                $this->notif_model->updateall(array("notif_to" => $this->access->get_ukmid()),array("notif_read" => 2));

                $datalog = array(
                    'log_text' => "User " . $this->access->get_username() . " menghapus semua notifikasi yang diterimanya ",
                    'user_id' => $this->access->get_userid()
                );
                $this->log_model->insert($datalog);

                $status['status'] = 1;
                $status['pesan'] = 'Semua notifikasi berhasil dihapus';
            } else {
                $status['status'] = 0;
                $status['pesan'] = 'Anda tidak punya hak untuk menghapus Log';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function bacanotif(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bacasatu-id', 'Role ID','required|strip_tags');
        $this->form_validation->set_rules('notifid', 'Notif ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('bacasatu-id', TRUE));
            $notifid = addslashes($this->input->post('notifid', TRUE));
            if($id == 42) {
                $this->notif_model->updateall(array("notif_to" => $this->access->get_ukmid(), "notif_id" => $notifid), array("notif_read" => 1));

                $status['status'] = 1;
                $status['pesan'] = 'Notifikasi berhasil ditandai telah dibaca';
            } else {
                $status['status'] = 0;
                $status['pesan'] = 'Anda tidak punya hak untuk menandai notifikasi';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function bacasemua(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('baca-id', 'Role ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('baca-id', TRUE));
            if($id == 42) {
                $this->notif_model->updateall(array("notif_to" => $this->access->get_ukmid(), "notif_read" => 0), array("notif_read" => 1));

                $datalog = array(
                    'log_text' => "User " . $this->access->get_username() . " menandai telah dibaca semua notifikasi yang diterimanya ",
                    'user_id' => $this->access->get_userid()
                );
                $this->log_model->insert($datalog);

                $status['status'] = 1;
                $status['pesan'] = 'Semua notifikasi berhasil ditandai telah dibaca';
            } else {
                $status['status'] = 0;
                $status['pesan'] = 'Anda tidak punya hak untuk menandai notifikasi';
            }
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

}

?>
