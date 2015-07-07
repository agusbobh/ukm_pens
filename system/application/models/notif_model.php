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
        // $this->db->where($parameter);
        // $this->db->update('notifikasi', $data);
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function selectone($id) {
        $this->db->select('*');
        $this->db->from('notifikasi');
        $this->db->where('notifikasi_id', $id);
        $query = $this->db->get();
        return $query;
    }

    function update($notifid, $notif_read, $notif_to) {
        // $this->db->where('notifikasi_id', $id);
        // $this->db->update('notifikasi', $data);
        $sql = "UPDATE notifikasi SET notif_read = '".$notif_read."' WHERE notif_to = '".$notif_to."' AND notif_id = '".$notifid."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            // $this->db->select('count(*) AS Total');
            // $this->db->from('notifikasi');
            // $this->db->where($parameter);
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM notifikasi
                    WHERE  ukm_id = ".$parameter." AND notif_read != 2";
            $query = $this->db->query($sql);
            return $query;
        }else{
            // $this->db->select('count(*) AS Total');
            // $this->db->from('notifikasi');
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM notifikasi";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function get_daftartipe() {
        /*$this->db->select('*');
        $this->db->from('tipenotif');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        // return (count($query->num_rows()) > 0 ? $query->result() : NULL);

        */

        $sql = "SELECT * FROM tipenotif";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_notif($id) {
        /*
        $this->db->select('notifikasi.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks, ukm.ukm_name AS ukm_name, user_sim.user_name AS user_name');
        $this->db->from('notifikasi');
        $this->db->join('tipenotif', 'notifikasi.notif_tipe = tipenotif.tipe_id');
        $this->db->join('ukm', 'notifikasi.ukm_id = ukm.ukm_id');
        $this->db->join('user_sim', 'notifikasi.user_id = user_sim.user_id');
        $this->db->where($parameter);
        $this->db->limit($limit);
        $this->db->order_by("notif_time","desc");
        $query = $this->db->get();
        */
        //return (count($query->num_rows()) > 0 ? $query->result() : NULL);

        $sql = "SELECT notifikasi.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks, ukm.ukm_name AS ukm_name, user_sim.user_name AS user_name
                FROM notifikasi
                JOIN tipenotif ON notifikasi.notif_tipe = tipenotif.tipe_id
                JOIN ukm ON notifikasi.ukm_id = ukm.ukm_id
                JOIN user_sim ON notifikasi.user_id = user_sim.user_id
                WHERE (notifikasi.notif_to = '".$id."' AND notif_read != '2' )
                ORDER BY notif_time DESC ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_reminder($id) {
        $sql = "SELECT notifikasi.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks, ukm.ukm_name AS ukm_name, user_sim.user_name AS user_name
                FROM notifikasi
                JOIN tipenotif ON notifikasi.notif_tipe = tipenotif.tipe_id
                JOIN ukm ON notifikasi.ukm_id = ukm.ukm_id
                JOIN user_sim ON notifikasi.user_id = user_sim.user_id
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
