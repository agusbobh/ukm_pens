<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function Dashboard() {
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
          $dat = $this->agenda_model->get_agenda($id);
          $data['dataagenda'] = $dat->_fetch_object();
        }
        $data['welcome_message'] = "Selamat " . $waktu . ucfirst($this->access->get_username()) . ". Hari ini tanggal " . $tanggal;
        $data['datanotif'] = $this->notif_model->get_notif("notif_to", $id, "notif_read !=", 2),5);

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('dashboard_view',$data);
    }

    function logout() {
        $this->access->logout();
        redirect('login');
    }

    function notifikasi() {
        $datah['title'] = 'Notifikasi';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $id = "";
        if($this->access->get_ukmid() == 0) { $id = $this->access->get_userid();
        } else { $id = $this->access->get_ukmid(); }

        $data['datanotif'] = $this->notif_model->get_notif(array("notif_to" => $id, "notif_read !=" => 2));

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('notifikasi_view',$data);
    }

    function reminder() {
        $datah['title'] = 'Reminder';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $id = "";
        if($this->access->get_ukmid() == 0) { $id = $this->access->get_userid();
        } else { $id = $this->access->get_ukmid(); }

        $data['datanotif'] = $this->notif_model->get_notif(array("notif_from" => $id));
        $data['dataukm'] = $this->ukm_model->get_ukm(array());
        $data['datatiperem'] = $this->notif_model->get_daftartipe(array());

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('reminder_view',$data);
    }

    function laporan() {
        $datah['title'] = 'Laporan';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('laporan_view');
    }

    function log() {
        $datah['title'] = 'Log';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $d = $this->log_model->get_log();
        $data['datalog'] = $d->_fetch_object();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('log_view',$data);
    }

    function getuser() {

        // run query to get user listing
        $query = $this->user_model->get_daftaruser();
        $a = $query->_fetch_object();
        // get result after running query and put it in array

        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($counter as $temp) {
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['UKM'] = $temp->UKM;
            $record[$i]['USERNAME'] = $temp->USERNAME;
            $record[$i]['DIBUAT'] = $temp->DIBUAT;
            $record[$i]['ROLE'] = $temp->ROLE;
            $record[$i]['STATUS'] = $temp->STATUS;
            $record[$i]['OPSI'] = '<div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="dropdown">Opsi
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->USERNAME).'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->ROLE).'\', \''.addslashes($temp->DIBUAT).'\', \''.addslashes($temp->MAIL).'\')" >Edit</a></li>
                                <li><a href="#" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->USERNAME).'\', \''.addslashes($temp->ROLE).'\')" >Hapus</a></li>
                                <li><a href="#" onclick="modalpass(\''.$temp->ID.'\', \''.addslashes($temp->USERNAME).'\')" >Password</a></li>
                            </ul>
                        </div>';
            //$record[] = '<a onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->Username).'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\', \''.addslashes($temp->Dibuat).'\')" class="btn btn-info btn-xs">Edit</a>
            //             <a onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\')" class="btn btn-danger btn-xs">Hapus</a>
            //             <a onclick="modalpass(\''.$temp->ID.'\', \''.addslashes($temp->Username).')" class="btn btn-success btn-xs">Password</a>';

            //$output['aaData'][] = $record;
            $i++;
        }
        // format it to JSON, this output will be displayed in datatable
        return $record;
    }

    function user() {
        $datah['title'] = 'User';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $b = $this->user_model->get_role();
        $data['datarole'] = $b->_fetch_object();

        $c = $this->ukm_model->get_ukm();
        $data['dataukm'] = $c->_fetch_object();

        $data['record_user'] = $this->getuser();
        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('user_view',$data);
    }

    function getukm() {

        // run query to get user listing
        $query = $this->ukm_model->get_daftarukm();
        $a = $query->_fetch_object();

        // get result after running query and put it in array
        //$i = $start;
        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($counter as $temp){
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['NAMA'] = $temp->NAMA;
            $record[$i]['KONTAK'] = $temp->KONTAK;
            $record[$i]['DIBUAT'] = $temp->DIBUAT;
            $record[$i]['INFO'] = $temp->INFO;
            $record[$i]['STATUS'] = $temp->STATUS;
            $record[$i]['OPSI'] = '<div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="dropdown">Opsi
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->AKUN_USER).'\', \''.addslashes($temp->NAMA).'\', \''.addslashes($temp->KONTAK).'\', \''.addslashes($temp->DIBUAT).'\')" >Edit</a></li>
                                <li><a href="#" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->NAMA).'\')" >Hapus</a></li>
                                <li><a href="#" onclick="modalinfo(\''.$temp->ID.'\')" >Perbarui Info</a></li>
                            </ul>
                        </div>';
            //$record[] = '<a onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->Username).'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\', \''.addslashes($temp->Dibuat).'\')" class="btn btn-info btn-xs">Edit</a>
            //             <a onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\')" class="btn btn-danger btn-xs">Hapus</a>
            //             <a onclick="modalpass(\''.$temp->ID.'\', \''.addslashes($temp->Username).')" class="btn btn-success btn-xs">Password</a>';

            //$output['aaData'] = "[[" . "'" . implode("','", $record ) . "'" . "]]";
            //$output['aaData'][]= $record;

            $i++;
        }
          return $record;
    }

    function ukm() {
        $datah['title'] = 'UKM';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $c = $this->user_model->get_list_user('42');
        $data['listuser'] = $c->_fetch_object();

        $data['record_ukm'] = $this->getukm();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('ukm_view',$data);
    }

    function anggota() {
        $datah['title'] = 'Anggota';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());
        //$data['datauser'] = $this->user_model->get_user(array("user_role" => "42"));

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('anggota_view');
    }

    function getagenda() {
        // run query to get user listing
        $query = $this->agenda_model->get_daftaragenda($ukmid, $start, $rows, $search);

        // get result after running query and put it in array
        $counter = $query->result();
        $i = 0;
        $record = array();
        foreach ($counter as $temp) {
            $record = array();
            $record[] = $temp->ID;
            $record[] = $temp->Title;
            $record[] = $temp->Time;
            $record[] = $temp->Status;
            $record[] = '<button class="btn btn-xs btn-flat btn-danger" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Title).'\', \''.addslashes($temp->Time).'\')"><i class="fa fa-times"></i> Hapus</button>
                        <button class="btn btn-xs btn-flat btn-primary" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->Title).'\', \''.addslashes($temp->StatusID).'\', \''.addslashes($temp->Teks).'\', \''.addslashes($temp->Time).'\', \''.addslashes($temp->Timeto).'\')"><i class="fa fa-pencil"></i> Edit</button>
                         <button class="btn btn-xs btn-flat btn-success" onclick="modallihat(\''.addslashes($temp->Title).'\', \''.addslashes($temp->Status).'\', \''.addslashes($temp->Teks).'\', \''.addslashes($temp->Time).'\', \''.addslashes($temp->Timeto).'\')"><i class="fa fa-eye"></i> Lihat</button>';

            //$output['aaData'][] = $record;
            $i++;

        }
        // format it to JSON, this output will be displayed in datatable
        return $record;
    }

    function agenda() {
        $datah['title'] = 'Agenda';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('agenda_view');
    }

    function profil() {
        $datah['title'] = 'Profil';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $a = $this->user_model->get_user($this->access->get_userid());
        $data['datauser'] = $a->_fetch_object();

        $c = $this->user_model->get_userakses($this->access->get_roleid());
        $data['dataakses'] = $c->_fetch_object();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('profil_view',$data);
    }

    function get_databox() {
        $id = "";
        /*
        if($this->access->get_ukmid() == 0) {
          $id = $this->access->get_userid();
          $data['boxlaporan'] = $this->data_model->get_total();
        } else {
          $id = $this->access->get_ukmid();
          $data['boxlaporan'] = $this->data_model->get_total("ukm_id", $id);
        }
        */

        // data buat box
        //$data['boxukm'] = $this->ukm_model->get_total();
        //$data['boxuser'] = $this->user_model->get_total();
        //$data['boxlog'] = $this->log_model->get_total();
        //$data['boxnotif'] = $this->notif_model->get_total(array("notif_to" => $id, "notif_read !=" => 2));
        //$data['boxanggota'] = $this->anggota_model->get_total("ukm_id",$id);
        //$data['boxagenda'] = $this->agenda_model->get_total("ukm_id",$id);
        //$data['boxrem'] = $this->notif_model->get_total("notif_from",$id);
        echo json_encode($data);
    }

}

?>
