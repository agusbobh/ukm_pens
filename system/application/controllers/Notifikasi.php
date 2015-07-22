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
            $notif_to = $this->access->get_ukmid();

            $log_id   = $this->access->get_userid();
            $log_teks = 'User ' . $this->access->get_username() . ' telah menghapus semua notifikasi yang diterimanya ';
            if($id == 42 OR $id == 41) {
                // $this->log_model->insert($log_id, $log_teks);
                $this->notif_model->updateall(2, $notif_to);

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
            $notif_to = $this->access->get_ukmid();

            if($id == 42 OR $id == 41) {
                $this->notif_model->update($notifid, 1, $notif_to);

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

            $notif_to = $this->access->get_ukmid();
            $log_id   = $this->access->get_userid();
            $log_teks = 'User ' . $this->access->get_username() . ' menandai telah dibaca semua notifikasi yang diterimanya.';

            if($id == 42 OR $id == 41) {
                $this->notif_model->updateall(1, $notif_to);
                //$this->log_model->insert($log_id, $log_teks);

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
