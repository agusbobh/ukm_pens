<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MY_Controller {

    function Data() {
        parent::MY_Controller();
        $this->load->model('user_model', '', true);
        $this->load->model('data_model', '', true);
        $this->load->model('ukm_model', '', true);
        $this->load->model('log_model', '', true);
        $this->load->model('notif_model', '', true);
    }

    function index() {

    }

    function doupload(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'doc|docx|rtf|xls|xlsx|pdf';
        $config['max_size']             = 10000;
        $config['file_ext_tolower']     = TRUE;

        $this->load->library('upload', $config);
        $this->load->library('form_validation');

        //$this->form_validation->set_rules('baru-attachment', 'File Laporan','trim|required|strip_tags');
        $this->form_validation->set_rules('baru-pesan', 'Pesan','trim|required|strip_tags');

        if($this->form_validation->run() == TRUE){
            if (!$this->upload->do_upload('baru-attachment')) {
                $status['status'] = 0;
                $status['pesan'] = $this->upload->display_errors();
            } else {
                $data = array(
                    'ukm_id' => $this->access->get_ukmid(),
                    'data_file' => $this->upload->data('file_name'),
                    'data_msg' => addslashes($this->input->post('baru-pesan', TRUE)),
                    'data_from' => $this->access->get_ukmid()
                );

                $dataukm = $this->ukm_model->get_ukm(array("ukm_id" =>$this->access->get_ukmid()))->row();

                $datanotif = array(
                    'ukm_id' => $this->access->get_ukmid(),
                    'user_id' => $this->access->get_userid(),
                    'notif_activity' => "User " . $this->access->get_username() . " dari UKM " . $dataukm->UKM_NAME . " mengirimkan laporan",
                    'notif_from' => $this->access->get_userid(),
                    'notif_to' => 2,
                    'notif_tipe' => 1
                );

                $this->notif_model->insert($datanotif);
                $this->data_model->insert($data);

                $status['status'] = 1;
                $status['pesan'] = 'Laporan berhasil dikirim';
            }
            @unlink($_FILES['baru-attachment']);
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function editdata(){
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'doc|docx|rtf|xls|xlsx|pdf';
        $config['max_size']             = 10000;
        $config['file_ext_tolower']     = TRUE;

        $this->load->library('upload', $config);
        $this->load->library('form_validation');

        //$this->form_validation->set_rules('baru-attachment', 'File Laporan','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-pesan', 'Pesan','trim|required|strip_tags');
        $this->form_validation->set_rules('edit-id', 'Data ID','trim|required|strip_tags');
        $id = addslashes($this->input->post('edit-id', TRUE));

        if($this->form_validation->run() == TRUE){
            if($_FILES['edit-attachment']['size'] == 0) {
                $data = array(
                    'data_msg' => addslashes($this->input->post('edit-pesan', TRUE))
                );

                $this->data_model->update($id,$data);

                $status['status'] = 1;
                $status['pesan'] = 'Data laporan baru berhasil disimpan';
            } else {
                $query = $this->data_model->get_data(array("data_id" => $id))->row();
                $dpath = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $query->DATA_FILE;
                $this->deleteFiles($dpath);

                if (!$this->upload->do_upload('edit-attachment')) {
                    $status['status'] = 0;
                    $status['pesan'] = $this->upload->display_errors();
                } else {
                    $data = array(
                        'data_file' => $this->upload->data('file_name'),
                        'data_msg' => addslashes($this->input->post('edit-pesan', TRUE))
                    );

                    $this->data_model->update($id,$data);

                    $status['status'] = 1;
                    $status['pesan'] = 'Data laporan beserta file laporan baru berhasil disimpan';
                }
                @unlink($_FILES['edit-attachment']);
            }

        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function deleteFiles($path){
        $files = glob($path); // get all file names
        foreach($files as $file){ // iterate files
            if(file_exists($file)) {
                unlink($file) or die('Gagal menghapus: ' . $path); // delete file
                //echo $file.'file deleted';
            }
        }
    }

    function hapusdata(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('hapus-id', 'Data ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('hapus-id', TRUE));
            $opfile = addslashes($this->input->post('hapus-file', TRUE));
            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';

            if($opfile == "hapusfile") {
                $data = $this->data_model->get_data(array("data_id" => $id))->row();
                $dpath = $path . $data->DATA_FILE;
                $this->deleteFiles($dpath);
                $this->data_model->delete($id);
                $pesan = 'Data ' . addslashes($this->input->post('hapus-nama', TRUE)) . ' beserta filenya ';
            } else {
                $pesan = 'Data ' . addslashes($this->input->post('hapus-nama', TRUE)) . ' ';
                $this->data_model->update($id,array("data_status" => "2"));
            }

            $datalog = array(
                'log_text' => "User " . $this->access->get_username() . " menghapus " . $pesan,
                'user_id' => $this->access->get_userid()
            );
            $this->log_model->insert($datalog);

            $status['status'] = 1;
            $status['pesan'] = $pesan . 'berhasil dihapus';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function hapusemua(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('semua-id', 'Role ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('semua-id', TRUE));
            $opfile = addslashes($this->input->post('semua-file', TRUE));
            $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';

            if($id == 40) {
                if($opfile == "hapusfile") {
                    $data = $this->data_model->get_data(array("data_id" => $id))->row();
                    $dpath = $path . "*";
                    $this->deleteFiles($dpath);
                    $this->data_model->deleteall();
                    $pesan = 'Semua data laporan beserta filenya';
                } else {
                    $pesan = 'Semua data laporan ';
                    $this->data_model->updateall(array("data_status" => "2"));
                }

                $datalog = array(
                    'log_text' => "User " . $this->access->get_username() . " menghapus " . $pesan,
                    'user_id' => $this->access->get_userid()
                );
                $this->log_model->insert($datalog);

                $status['status'] = 1;
                $status['pesan'] = $pesan . 'berhasil dihapus';
            } else {
                $status['status'] = 0;
                $status['pesan'] = "Anda tidak bisa mempunyai hak akses untuk menghapus file";
            }

        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function undodata(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('undo-id', 'Data ID','required|strip_tags');

        if($this->form_validation->run() == TRUE){
            $id = addslashes($this->input->post('undo-id', TRUE));
            $nama = addslashes($this->input->post('undo-nama', TRUE));
            $this->data_model->update($id,array("data_status" => "1"));

            $datalog = array(
                'log_text' => "User " . $this->access->get_username() . " mengembalikan data " . $nama,
                'user_id' => $this->access->get_userid()
            );
            $this->log_model->insert($datalog);

            $status['status'] = 1;
            $status['pesan'] = 'Data ' . $nama . ' berhasil dikembalikan';
        }else{
            $status['status'] = 0;
            $status['pesan'] = validation_errors();
        }

        echo json_encode($status);
    }

    function download($id){
        $this->load->helper('download');
        $data = $this->data_model->get_data(array("data_id" => $id))->row();
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $data->DATA_FILE;
        force_download($path, NULL);
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

    function getdata() {
        $this->load->library('Json_encode');

        // run query to get user listing
        $idu = $this->access->get_ukmid();
        $query = $this->data_model->get_daftardata($idu);

        // get result after running query and put it in array
        //$i = $start;
        $counter = $a;
        $i = 0;
        $record = array();
        foreach ($counter as $temp) {
            $shap = $temp->StatusID != 2 ? "" : "disabled";
            $sund = $temp->StatusID == 2 ? "" : "disabled";
            $tambahan = "";
            if($this->access->get_ukmid() != 0) {
                $tambahan = '<button class="btn btn-xs btn-flat btn-info '. $shap .'" onclick="modaledit(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILE).'\', \''.addslashes($temp->PESAN).'\')"><i class="fa fa-pencil"></i> Edit</button>';
            }

            $record = array();
            $record[$i]['ID'] = $temp->ID;
            $record[$i]['UKM'] = $temp->UKM;
            $record[$i]['PESAN'] = $temp->PESAN;
            $record[$i]['DIKIRIM'] = $temp->DIKIRIM;
            $record[$i]['NAMA'] = $temp->NAMA;
            $record[$i]['STATUS'] = $temp->STATUS;
            if($this->access->get_roleid() != 41) {
                $record[$i]['OPSI'] = '<button class="btn btn-xs btn-flat btn-danger '. $shap .'" onclick="modalhapus(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILE).'\')"><i class="fa fa-times"></i> Hapus</button>
                        <button class="btn btn-xs btn-flat btn-warning '. $sund .'" onclick="modalundo(\''.$temp->ID.'\', \''.addslashes($temp->UKM).'\', \''.addslashes($temp->FILE).'\')"><i class="fa fa-undo"></i> Undo</button>
                        '. $tambahan .'';
            } else {
                $url = site_url() . "data/download/" . $temp->ID;
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
        // format it to JSON, this output will be displayed in datatable
        //echo json_encode($output);
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
