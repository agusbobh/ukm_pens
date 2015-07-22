<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends Model {

    function Data_model() {
        parent::Model();
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            // $this->db->select('count(*) AS Total');
            // $this->db->from('data');
            // $this->db->where('ukm_id',$parameter);
            // $query = $this->db->get();
            // //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }

            $sql = "SELECT count(*) AS Total FROM data
                    WHERE  ukm_id = ".$parameter." ";
            $query = $this->db->query($sql);
            return $query;
        }else{
            // $this->db->select('count(*) AS Total');
            // $this->db->from('data');
            // $query = $this->db->get();
            // //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            $sql = "SELECT count(*) AS Total FROM data ";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function insert($idukm, $data_laporan, $data_msg) {
        // $this->db->insert('data', $data);
        $sql = "INSERT INTO data (DATA_ID, UKM_ID, DATA_FILE_LAPORAN, DATA_MSG, DATA_FROM, DATA_TO, DATA_TIME, DATA_STATUS)"
                . "VALUES(DATA_ID_SEQ.NEXTVAL,'".$idukm."', '".$data_laporan."', '".$data_msg."', '".$idukm."' , '21', SYSDATE, '0')";
        $query = $this->db->query($sql);
        return $query;
    }

    function delete($id) {
        $this->db->where('data_id', $id);
        $this->db->delete('data');
    }

    function deleteall() {
        $this->db->empty_table('data');
    }

    function update($id, $data_file, $data_msg) {
        // $this->db->where('data_id', $id);
        // $this->db->update('data', $data);
        $sql = "UPDATE data SET DATA_FILE_LAPORAN = '".$data_file."', DATA_MSG = '".$data_msg."' "
              ."WHERE DATA_ID = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_status_file($id) {
        $sql = "UPDATE data SET DATA_STATUS ='2' "
              ."WHERE DATA_ID = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_status_allfile($id) {
        $sql = "UPDATE data SET DATA_STATUS ='2' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_info($id, $data_msg) {
        // $this->db->update('data', $data);
        $sql = "UPDATE data SET DATA_MSG = '".$data_msg."' "
              ."WHERE DATA_ID = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_data($parameter) {
        $sql = "SELECT * from data where DATA_ID = $parameter";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_daftardata($idu) {

        if($idu == 0) {
            $sql = "SELECT
                data.data_id AS ID,
                ukm.ukm_name AS UKM,
                data.ukm_id AS UKMid,
                user_sim.user_name AS Nama,
                data.data_file_laporan AS Files,
                data.data_msg AS Pesan,
                data.data_to AS Tujuan,
                data.data_time AS Dikirim,
                REPLACE(REPLACE(REPLACE(data.data_status,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') AS Status
            FROM data
            INNER JOIN ukm ON (data.ukm_id = ukm.ukm_id)
            INNER JOIN user_sim ON (data.data_to = user_sim.user_id)
            ORDER BY data.data_id";
        } else {
            $sql = "SELECT
                data.data_id AS ID,
                ukm.ukm_name AS UKM,
                data.ukm_id AS UKMid,
                user_sim.user_name AS Nama,
                data.data_file_laporan AS Files,
                data.data_msg AS Pesan,
                data.data_to AS Tujuan,
                data.data_time AS Dikirim,
                REPLACE(REPLACE(REPLACE(data.data_status,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') AS Status
            FROM data
            INNER JOIN ukm ON (data.ukm_id = ukm.ukm_id)
            INNER JOIN user_sim ON (data.data_to = user_sim.user_id)
            WHERE data.ukm_id = ". $idu ."
            ORDER BY data.data_id";
        }

        $query = $this->db->query($sql);
        return $query;
    }

    function get_count_daftardata($search, $id = 0) {

        if($id == 0) {
            $sql = "SELECT COUNT(*) AS Total
            FROM `data` d
            INNER JOIN `ukm` u ON (`d`.`ukm_id` = `u`.`ukm_id`)
            INNER JOIN `user_sim` us ON (`d`.`data_to` = `us`.`user_id`)
            WHERE `d`.`data_id` LIKE '%".$search."%'
                    OR `u`.`ukm_name` LIKE '%".$search."%'
                    OR `us`.`user_name` LIKE '%".$search."%'
                    OR `d`.`data_file` LIKE '%".$search."%'
                    OR `d`.`data_to` LIKE '%".$search."%'
                    OR REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') LIKE '%".$search."%'
                    OR `d`.`data_time` LIKE '%".$search."%'";
        } else {
            $sql = "SELECT COUNT(*) AS Total
            FROM `data` d
            INNER JOIN `ukm` u ON (`d`.`ukm_id` = `u`.`ukm_id`)
            INNER JOIN `user_sim` us ON (`d`.`data_to` = `us`.`user_id`)
            WHERE `d`.`ukm_id` = ". $id ." AND (`d`.`data_id` LIKE '%".$search."%'
                    OR `u`.`ukm_name` LIKE '%".$search."%'
                    OR `us`.`user_name` LIKE '%".$search."%'
                    OR `d`.`data_file` LIKE '%".$search."%'
                    OR `d`.`data_to` LIKE '%".$search."%'
                    OR REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') LIKE '%".$search."%'
                    OR `d`.`data_time` LIKE '%".$search."%')";
        }


        return $this->db->query($sql);
    }

}

?>
