<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ukm_model extends Model {

    function Ukm_model() {
        parent::Model();
    }

    function get_total() {
        if(!empty($parameter)){
            // $this->db->select('count(*) AS Total');
            // $this->db->from('ukm');
            // $this->db->where($parameter);
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            $sql = "SELECT count(*) AS Total FROM ukm
                    WHERE  ukm_id = ".$parameter." ";
            $query = $this->db->query($sql);
            return $query;
        }else{
            // $this->db->select('count(*) AS Total');
            // $this->db->from('ukm');
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            $sql = "SELECT count(*) AS Total FROM user_sim";
            $query = $this->db->query($sql);
            return $query;
        }

    }

    function search($keyword) {
        $sql = "SELECT * FROM pegawai WHERE nama LIKE '%".$keyword."%'";
        $query = $this->db->query($sql);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        return $report;
    }

    function insert($user_id, $ukm_name, $ukm_kontak, $ukm_pembina) {
        //$this->db->insert('ukm', $data);
        $sql = "INSERT INTO ukm (UKM_ID, USER_ID, UKM_NAME, UKM_CREATED, UKM_STATUS, UKM_INFO, UKM_CONTACT, UKM_PEMBINA)"
                . "VALUES(UKM_ID_SEQ.NEXTVAL,'".$user_id."', '".$ukm_name."', SYSDATE, '1' , '-', '".$ukm_kontak."', '".$ukm_pembina."')";
        $query = $this->db->query($sql);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        return $report;
    }

    function delete($id) {
        //$this->db->where('ukm_id', $id);
        //$this->db->delete('ukm');
        $sql = "DELETE FROM ukm WHERE ukm_id = ".$id." ";
        $query = $this->db->query($sql);

        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        return $report;
    }

    function update($idukm, $nama, $iduser, $kontak, $pembina) {
        $sql = "UPDATE ukm SET ukm_name = '".$nama."', user_id = '".$iduser."', ukm_contact = '".$kontak."', ukm_pembina = '".$pembina."'  WHERE ukm_id = '".$idukm."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_info($id, $teks) {
        $sql = "UPDATE ukm SET ukm_info = '".$teks."' WHERE ukm_id = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function cek($field,$value) {
        /*$this->db->select('*');
        $this->db->from('ukm');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        */
        $sql = "SELECT * FROM ukm WHERE ".$field." = '".$value."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_ukm() {
        /*$this->db->select('*');
        $this->db->from('ukm');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        */
        //return ( $query->num_rows > 0 ? $query : 0 );
        $sql = "SELECT * FROM ukm ORDER BY ukm_name ASC";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_daftarukm() {

        $sql = "SELECT
            ukm.ukm_id AS ID,
            ukm.ukm_name AS Nama,
            ukm.user_id AS Akun_User,
            ukm.ukm_contact AS Kontak,
            ukm.ukm_created AS Dibuat,
            ukm.ukm_info AS Info,
            REPLACE(REPLACE(ukm.ukm_status,'0','Nonaktif'),'1','Aktif') AS Status,
            ukm.ukm_pembina AS Pembina
        FROM ukm
        ORDER BY ukm.ukm_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_count_daftarukm($search) {

        $sql = "SELECT
            COUNT(*) AS Total
        FROM `ukm` ";

        $query = $this->db->query($sql);
        //untuk ->row
        foreach ($query->result() as $row)
        {
           return $row->Total;
        }

        //return $query->row()->Total;
    }

}

?>
