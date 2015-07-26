<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notif_model extends Model {

    function Notif_model() {
        parent::Model();
        //$this->CI = get_instance();
    }

    function insert($iduser, $idukm, $teks, $idtipe) {
        //$this->db->insert('notifikasi', $data);

        $sql = "INSERT INTO notifikasi (notif_id, user_id, ukm_id, notif_activity, notif_time, notif_read, notif_from, notif_to, notif_tipe)"
                . "VALUES(NOTIF_ID_SEQ.NEXTVAL,'".$iduser."', '".$idukm."', '".$teks."', SYSDATE , '0' ,'".$iduser."', '".$idukm."', '".$idtipe."')";
        $query = $this->db->query($sql);
        return $query;
    }

    function insert_notif($iduser, $idukm, $teks) {
        //$this->db->insert('notifikasi', $data);

        $sql = "INSERT INTO notifikasi (notif_id, user_id, ukm_id, notif_activity, notif_time, notif_read, notif_from, notif_to, notif_tipe)"
                . "VALUES(NOTIF_ID_SEQ.NEXTVAL,'".$iduser."', '".$idukm."', '".$teks."', SYSDATE , '0' ,'".$iduser."', '21', '1')";
        $query = $this->db->query($sql);
        return $query;
    }

    function delete($id) {
        $this->db->where('notifikasi_id', $id);
        $this->db->delete('notifikasi');
    }

    function deleteall() {
        $this->db->empty_table('notifikasi');
    }

    function updateall($notif_read, $notif_to) {
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function updateall_manajemen($notif_read, $notif_to_man) {
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to_man."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update($notifid, $notif_read, $notif_to) {
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to."' AND notif_id = '".$notifid."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_notif_manajemen($notifid, $notif_read, $notif_to_man) {
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to_man."' AND notif_id = '".$notifid."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            $sql = "SELECT count(*) AS Total FROM notifikasi
                    WHERE  ukm_id = ".$parameter." AND notif_read != 2";
            $query = $this->db->query($sql);
            return $query;
        }else{
            $sql = "SELECT count(*) AS Total FROM notifikasi";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function get_total_reminder() {
            $sql = "SELECT count(*) AS Total FROM notifikasi
                    WHERE  notif_from = 21 AND notif_read != 2";
            $query = $this->db->query($sql);
            return $query;
    }

    function get_daftartipe() {
        $sql = "SELECT * FROM tipenotif";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_notif($id) {
        $sql = "SELECT notifikasi.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks, ukm.ukm_name AS ukm_name, pegawai.username AS username
                FROM notifikasi
                JOIN tipenotif ON notifikasi.notif_tipe = tipenotif.tipe_id
                JOIN ukm ON notifikasi.ukm_id = ukm.ukm_id
                JOIN user_sim ON notifikasi.user_id = user_sim.user_id

                JOIN pegawai ON pegawai.nomor = user_sim.user_id

                WHERE (notifikasi.notif_to = '".$id."' AND notif_read != '2' )
                ORDER BY notif_time DESC ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_reminder($id) {
        $sql = "SELECT notifikasi.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks, ukm.ukm_name AS ukm_name, pegawai.username AS username
                FROM notifikasi
                JOIN tipenotif ON notifikasi.notif_tipe = tipenotif.tipe_id
                JOIN ukm ON notifikasi.ukm_id = ukm.ukm_id
                JOIN user_sim ON notifikasi.user_id = user_sim.user_id

                JOIN pegawai ON pegawai.nomor = user_sim.user_id

                WHERE notifikasi.notif_from = '".$id."'
                ORDER BY notif_time DESC ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_count($tanggal = null) {
        if($tanggal == null) {
            $this->db->select('count(*) as Total');
            $this->db->from('notifikasi');
            $query = $this->db->get();
            return $query;
        } else {
            $this->db->select('count(*) as Total');
            $this->db->from('notifikasi');
            $this->db->where('notifikasi_time', $tanggal);
            $query = $this->db->get();
            return $query;
        }
    }

}

?>
