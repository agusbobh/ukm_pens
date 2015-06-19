<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends Model {

    function Data_model() {
        parent::Model();
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            $this->db->select('count(*) AS Total');
            $this->db->from('data');
            $this->db->where($parameter);
            $query = $this->db->get();
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            foreach($query->result() as $row){
              return $row->Total;
            }
        }else{
            $this->db->select('count(*) AS Total');
            $this->db->from('data');
            $query = $this->db->get();
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            foreach($query->result() as $row){
              return $row->Total;
            }
        }
    }

    function insert($data) {
        $this->db->insert('data', $data);
    }

    function delete($id) {
        $this->db->where('data_id', $id);
        $this->db->delete('data');
    }

    function deleteall() {
        $this->db->empty_table('data');
    }

    function update($id, $data) {
        $this->db->where('data_id', $id);
        $this->db->update('data', $data);
    }

    function updateall($data) {
        $this->db->update('data', $data);
    }

    function get_data($parameter) {
        /*$this->db->select('data.*, ukm.ukm_name AS UKM, user_sim.user_name AS Tujuan');
        $this->db->from('data');
        $this->db->join('ukm', 'data.ukm_id = ukm.ukm_id');
        $this->db->join('user_sim', 'data.data_to = user_sim.user_id');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;

        //return (count($query->num_rows()) > 0 ? $query : NULL);
        */
        $sql = "SELECT data.*, ukm.ukm_name AS UKM, user_sim.user_name AS Tujuan FROM data
                JOIN ukm ON data.ukm_id = ukm.ukm_id
                JOIN user_sim ON data.data_to = user_sim.user_id
                WHERE  user_sim.user_id = ".$parameter." ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_daftardata($start, $rows, $search, $id = 0) {

        if($id == 0) {
            $sql = "SELECT
                `d`.`data_id` AS ID,
                `u`.`ukm_name` AS UKM,
                `d`.`ukm_id` AS UKMid,
                `us`.`user_name` AS Nama,
                `d`.`data_file` AS File,
                `d`.`data_msg` AS Pesan,
                `d`.`data_to` AS Tujuan,
                `d`.`data_time` AS Dikirim,
                `d`.`data_status` AS StatusID,
                REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') AS Status
            FROM `data` d
            INNER JOIN `ukm` u ON (`d`.`ukm_id` = `u`.`ukm_id`)
            INNER JOIN `user_sim` us ON (`d`.`data_to` = `us`.`user_id`)
            WHERE `d`.`data_id` LIKE '%".$search."%'
                    OR `u`.`ukm_name` LIKE '%".$search."%'
                    OR `us`.`user_name` LIKE '%".$search."%'
                    OR `d`.`data_file` LIKE '%".$search."%'
                    OR `d`.`data_to` LIKE '%".$search."%'
                    OR REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') LIKE '%".$search."%'
                    OR `d`.`data_time` LIKE '%".$search."%'
            ORDER BY `d`.`data_id` LIMIT ".$start.",".$rows."";
        } else {
            $sql = "SELECT
                `d`.`data_id` AS ID,
                `u`.`ukm_name` AS UKM,
                `d`.`ukm_id` AS UKMid,
                `us`.`user_name` AS Nama,
                `d`.`data_file` AS File,
                `d`.`data_msg` AS Pesan,
                `d`.`data_to` AS Tujuan,
                `d`.`data_time` AS Dikirim,
                `d`.`data_status` AS StatusID,
                REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') AS Status
            FROM `data` d
            INNER JOIN `ukm` u ON (`d`.`ukm_id` = `u`.`ukm_id`)
            INNER JOIN `user_sim` us ON (`d`.`data_to` = `us`.`user_id`)
            WHERE `d`.`ukm_id` = ". $id ." AND (`d`.`data_id` LIKE '%".$search."%'
                    OR `u`.`ukm_name` LIKE '%".$search."%'
                    OR `us`.`user_name` LIKE '%".$search."%'
                    OR `d`.`data_file` LIKE '%".$search."%'
                    OR `d`.`data_to` LIKE '%".$search."%'
                    OR REPLACE(REPLACE(REPLACE(`d`.`data_status`,'0','Belum Dibaca'),'1','Sudah Dibaca'),'2','Dihapus') LIKE '%".$search."%'
                    OR `d`.`data_time` LIKE '%".$search."%')
            ORDER BY `d`.`data_id` LIMIT ".$start.",".$rows."";
        }


        return $this->db->query($sql);
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
