<?php

class Oracle extends MY_Controller {

    function Oracle() {
          parent::MY_Controller();
          $this->load->model('user_model', '', true);
          $this->load->model('log_model', '', true);
          $this->load->model('ukm_model', '', true);
          $this->load->model('data_model', '', true);
          $this->load->model('notif_model', '', true);
          $this->load->model('anggota_model', '', true);
          $this->load->model('agenda_model', '', true);
    }

    function index() {
      $datah['title'] = 'Dashboard';
      $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

      // memberikan salam ke user yg login
      $datestring = "%H:%i:%s";
      $tglstring = "%d-%m-%Y";
      $waktu = '';
      $jam = mdate($datestring, now());
      $tanggal = mdate($tglstring, now());
      if ($jam < 4) {
          $waktu = "Dini Hari ";
      } else if ($jam < 11) {
          $waktu = "Pagi ";
      } else if ($jam < 15) {
          $waktu = "Siang ";
      } else if ($jam < 18) {
          $waktu = "Sore ";
      } else if ($jam < 24) {
          $waktu = "Malam ";
      }

      $id = "";
      if($this->access->get_ukmid() == 0) {
        $id = $this->access->get_userid();
      } else {
        $id = $this->access->get_ukmid();
        $data['dataagenda'] = $this->agenda_model->get_agenda(array("ukm_id" => $id),5);
      }
      $data['welcome_message'] = "Selamat " . $waktu . ucfirst($this->access->get_username()) . ". Hari ini tanggal " . $tanggal;
      $data['datanotif'] = $this->notif_model->get_notif(array("notif_to" => $id, "notif_read !=" => 2),5);

      // generate view
      $this->load->view('header_view',$datah);
      $this->load->view('dashboard_view',$data);

        if(!empty($data))
          echo "Connected!"."\n";
        else
          echo "Closed"."\n";
        var_dump($data);
    }
}
?>
