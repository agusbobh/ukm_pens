<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ukm_model extends Model {

    function Ukm_model() {
        parent::Model();
    }

    function get_total() {
        /*if(!empty($parameter)){
            $this->db->select('count(*) AS Total');
            $this->db->from('ukm');
            $this->db->where($parameter);
            $query = $this->db->get();
            foreach($query->result() as $row){
              return $row->Total;
            }
        }else{
            $this->db->select('count(*) AS Total');
            $this->db->from('ukm');
            $query = $this->db->get();
            foreach($query->result() as $row){
              return $row->Total;
            }
        }*/
        if(!empty($id)){
          $sql = "SELECT COUNT(*) AS Total FROM ukm";
          $query = $this->db->query($sql);
          return $query->row();
        }else{
          $sql = "SELECT COUNT(*) AS Total FROM ukm";
          $query = $this->db->query($sql);
          foreach($query as $row){
            return $row->Total;
          }
        }

    }

    function insert($user_id, $ukm_name, $ukm_kontak) {
        //$this->db->insert('ukm', $data);
        $sql = "INSERT INTO ukm (UKM_ID, USER_ID, UKM_NAME, UKM_CREATED, UKM_STATUS, UKM_INFO, UKM_CONTACT)"
                . "VALUES(UKM_ID_SEQ.NEXTVAL,'".$user_id."', '".$ukm_name."', SYSDATE, '1' , '-', '".$ukm_kontak."')";
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

    function update($id, $data) {
        $this->db->where('ukm_id', $id);
        $this->db->update('ukm', $data);
        //$sql = "UPDATE ukm SET ukm_id = ".$data." WHERE ukm_id = ".$id." "
        //$query = $this->db->query($sql);
        //return $query;
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
        $sql = "SELECT * FROM ukm";
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
            REPLACE(REPLACE(ukm.ukm_status,'0','Nonaktif'),'1','Aktif') AS Status
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
