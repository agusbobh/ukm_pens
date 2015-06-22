<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reminder extends MY_Controller {

    function Reminder() {
        parent::MY_Controller();
        $this->load->model('user_model', '', true);
        $this->load->model('log_model', '', true);
        $this->load->model('notif_model', '', true);
    }

    function index() {
        $datah['title']='User';
        $datah['menu_user'] = TRUE;

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('user_view',$data);
    }

    function baru() {
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('rem-ukm', 'UKM','required|strip_tags');
        $this->form_validation->set_rules('rem-teks', 'Teks','required|strip_tags');
        //$this->form_validation->set_rules('rem-tipe', 'Teks','required|strip_tags');

        if($this->form_validation->run() == TRUE){
                $iduser = $this->access->get_userid();
                $idukm = addslashes($this->input->post('rem-ukm', TRUE));
                $teks = addslashes($this->input->post('rem-teks', TRUE));
                $idtipe = addslashes($this->input->post('rem-tipe', TRUE));


                $this->notif_model->insert($iduser, $idukm, $teks, $idtipe);

                $status['status'] = 1;
                $status['error'] = '';
        }else{
            $status['status'] = 0;
            $status['error'] = validation_errors();
        }

        echo json_encode($status);
    }

}

?>
