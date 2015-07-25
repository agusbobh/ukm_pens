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
        //$data['datanotif'] = $this->notif_model->get_notif("notif_to", $id, "notif_read !=", 2),5);
        $f = $this->notif_model->get_notif($id);
        $data['datanotif'] = $f->_fetch_object();

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

        //$data['datanotif'] = $this->notif_model->get_notif(array("notif_to" => $id, "notif_read !=" => 2));
        $dat = $this->notif_model->get_notif($id);
        $data['datanotif'] = $dat->_fetch_object();

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

        //$data['datanotif'] = $this->notif_model->get_notif(array("notif_from" => $id));

        $dab = $this->notif_model->get_reminder($id);
        $data['datareminder'] = $dab->_fetch_object();

        $dah = $this->ukm_model->get_ukm();
        $data['dataukm'] = $dah->_fetch_object();

        $dat = $this->notif_model->get_daftartipe();
        $data['datatiperem'] = $dat->_fetch_object();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('reminder_view',$data);
    }

    function getdata() {
        $this->load->library('Json_encode');

        // run query to get user listing
        $idu = $this->access->get_ukmid();
        $query = $this->data_model->get_daftardata($idu);
        $a= $query->_fetch_object();
        // get result after running query and put it in array
        //$i = $start;
        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($a as $temp) {
            $shap = $temp->STATUS != 2 ? "" : "disabled";
            $sund = $temp->STATUS == 2 ? "" : "disabled";
            $tambahan = "";
            if($this->access->get_roleid() != 40) {
                $tambahan = '<button class="btn btn-xs btn-flat btn-info '. $shap .'" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILES).'\', \''.addslashes($temp->PESAN).'\')"><i class="fa fa-pencil"></i> Edit</button>';
            }

            $record[] = array();
            $record[$i]['NO'] = $i+1;
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['UKM'] = $temp->UKM;
            $record[$i]['PESAN'] = $temp->PESAN;
            $record[$i]['DIKIRIM'] = $temp->DIKIRIM;
            $record[$i]['NAMA'] = $temp->NAMA;
            $record[$i]['STATUS'] = $temp->STATUS;
            if($this->access->get_roleid() != 41) {
                if($this->access->get_roleid() == 42){
                $record[$i]['OPSI'] = '<button class="btn btn-xs btn-flat btn-danger '. $shap .'" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILES).'\')"><i class="fa fa-times"></i> Hapus</button>
                        '. $tambahan .'';
                }else{
                  $record[$i]['OPSI'] = '<button class="btn btn-xs btn-flat btn-danger '. $shap .'" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILES).'\')"><i class="fa fa-times"></i> Hapus</button>
                          <button class="btn btn-xs btn-flat btn-warning '. $sund .'" onclick="modalundo(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILES).'\')"><i class="fa fa-undo"></i> Restore Dokumen</button>';
                }
            } else {
                $url = site_url() . "/data/download/" . $temp->ID;
                $record[$i]['OPSI'] = '<a class="btn btn-xs btn-flat btn-success" target="_blank" href="'. $url .'">
                                <i class="fa fa-download"></i> Download
                            </a>';
            }
            //$record[] = '<a onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->Username).'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\', \''.addslashes($temp->Dibuat).'\')" class="btn btn-info btn-xs">Edit</a>
            //             <a onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->Nama).'\', \''.addslashes($temp->Role).'\')" class="btn btn-danger btn-xs">Hapus</a>
            //             <a onclick="modalpass(\''.$temp->ID.'\', \''.addslashes($temp->Username).')" class="btn btn-success btn-xs">Password</a>';

            //$output['aaData'][] = $record;
            $i++;
        }

        // var_dump($record);
        // die();
        // format it to JSON, this output will be displayed in datatable
        //echo json_encode($output);
        return $record;
    }

    function laporan() {
        $datah['title'] = 'Laporan';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $data['record_laporan'] = $this->getdata();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('laporan_view',$data);
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
            $record[$i]['NO'] = $i+1;
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
                                <li><a href="#" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes(trim($temp->USERNAME)).'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->ROLE).'\', \''.addslashes($temp->DIBUAT).'\', \''.addslashes($temp->MAIL).'\');return false;" >Edit</a></li>
                                <li><a href="#" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes(trim($temp->USERNAME)).'\', \''.addslashes($temp->ROLE).'\');return false;" >Hapus</a></li>
                                <li><a href="#" onclick="modalpass(\''.$temp->ID.'\', \''.addslashes(trim($temp->USERNAME)).'\');return false;" >Password</a></li>
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
            $record[$i]['NO'] = $i+1;
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['NAMA'] = $temp->NAMA;
            $record[$i]['KONTAK'] = $temp->KONTAK;
            $record[$i]['DIBUAT'] = $temp->DIBUAT;
            $record[$i]['INFO'] = $temp->INFO;
            $record[$i]['STATUS'] = $temp->STATUS;
            $record[$i]['PEMBINA'] = $temp->PEMBINA;
            $record[$i]['OPSI'] = '<div class="btn-group">
                            <button type="button" class="btn btn-info btn-xs btn-flat" data-toggle="dropdown">Opsi
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->AKUN_USER).'\', \''.addslashes(trim($temp->NAMA)).'\', \''.addslashes($temp->KONTAK).'\', \''.addslashes($temp->DIBUAT).'\');return false;" >Edit</a></li>
                                <li><a href="#" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes(trim($temp->NAMA)).'\');return false;" >Hapus</a></li>
                                <li><a href="#" onclick="modalinfo(\''.$temp->ID.'\');return false;" >Perbarui Info</a></li>
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

        $d = $this->user_model->get_list_pegawai();
        $data['listpegawai'] = $d->_fetch_object();

        $data['record_ukm'] = $this->getukm();

        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('ukm_view',$data);
    }

    function getanggota() {
        // run query to get user listing

        $idukm = $this->access->get_ukmid();
        $query = $this->anggota_model->get_daftaranggota($idukm);
        $a = $query->_fetch_object();
        // get result after running query and put it in array
        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($a as $temp) {
            $record[] = array();
            $record[$i]['NO'] = $i+1;
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['NAMA'] = $temp->NAMA;
            $record[$i]['STATUS'] = $temp->STATUS;
            $record[$i]['JABATAN'] = $temp->JABATAN;
            $record[$i]['OPSI'] = '<button class="btn btn-xs btn-flat btn-danger" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->NAMA).'\', \''.addslashes($temp->JABATAN).'\')"><i class="fa fa-times"></i> Hapus</button>
                        <button class="btn btn-xs btn-flat btn-primary" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->NAMA).'\', \''.addslashes($temp->STATUS).'\', \''.addslashes($temp->JABATAN).'\')"><i class="fa fa-pencil"></i> Edit</button>';
            //$output['aaData'][] = $record;
            $i++;

        }
        // format it to JSON, this output will be displayed in datatable
        return $record;
    }

    function anggota() {
        $datah['title'] = 'Anggota';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());
        //$data['datauser'] = $this->user_model->get_user("42");
        $data['record_anggota'] = $this->getanggota();
        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('anggota_view',$data);
    }

    function getagenda() {
        // run query to get user listing

        $idukm = $this->access->get_ukmid();
        $query = $this->agenda_model->get_daftaragenda($idukm);
        $a = $query->_fetch_object();
        // get result after running query and put it in array
        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($a as $temp) {
            $record[] = array();
            $record[$i]['NO'] = $i+1;
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['TITLE'] = $temp->TITLE;
            $record[$i]['TIME'] = $temp->TIME;
            $record[$i]['STATUS'] = $temp->STATUS;
            $record[$i]['OPSI'] = '<button class="btn btn-xs btn-flat btn-danger" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->TITLE).'\', \''.addslashes($temp->TIME).'\')"><i class="fa fa-times"></i> Hapus</button>
                        <button class="btn btn-xs btn-flat btn-primary" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->TITLE).'\', \''.addslashes($temp->STATUSID).'\', \''.addslashes($temp->TEKS).'\', \''.addslashes($temp->TIME).'\', \''.addslashes($temp->TIMETO).'\')"><i class="fa fa-pencil"></i> Edit</button>
                         <button class="btn btn-xs btn-flat btn-success" onclick="modallihat(\''.addslashes($temp->TITLE).'\', \''.addslashes($temp->STATUS).'\', \''.addslashes($temp->TEKS).'\', \''.addslashes($temp->TIME).'\', \''.addslashes($temp->TIMETO).'\')"><i class="fa fa-eye"></i> Lihat</button>';

            //$output['aaData'][] = $record;
            $i++;

        }
        // format it to JSON, this output will be displayed in datatable
        return $record;
    }

    function agenda() {
        $datah['title'] = 'Agenda';
        $datah['menu'] = $this->user_model->get_menu($this->access->get_roleid());

        $data['record_agenda'] = $this->getagenda();
        // generate view
        $this->load->view('header_view',$datah);
        $this->load->view('agenda_view',$data);
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
        $id = $this->access->get_ukmid();
        $dat = $this->data_model->get_total($id);
        $data['boxlaporan'] = $dat->_fetch_object();

        // data buat box
        $dat = $this->ukm_model->get_total($id);
        $data['boxukm'] = $dat->_fetch_object();

        $dat = $this->user_model->get_total($id);
        $data['boxuser'] = $dat->_fetch_object();

        $dat = $this->log_model->get_total($id);
        $data['boxlog'] = $dat->_fetch_object();

        $dat = $this->notif_model->get_total($id);
        $data['boxnotif'] = $dat->_fetch_object();

        $dat = $this->anggota_model->get_total($id);
        $data['boxanggota'] = $dat->_fetch_object();

        $dat = $this->agenda_model->get_total($id);
        $data['boxagenda'] = $dat->_fetch_object();

        $dat = $this->notif_model->get_total_reminder();
        $data['boxrem'] = $dat->_fetch_object();
        echo json_encode($data);
    }

}

?>
