<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends Model {

    function Log_model() {
        parent::Model();
        //$this->CI = get_instance();
    }

    function insert($log_id) {
        //$this->db->insert('log', $data);
        $sql = "INSERT INTO log (LOG_ID, USER_ID, LOG_TEXT, LOG_TIME)"
                . "VALUES(LOG_ID_SEQ.NEXTVAL,'".$log_id."', 'LOGIN di', SYSDATE)";
        $query = $this->db->query($sql);
        return $query;
    }

    function delete($id) {
        $this->db->where('log_id', $id);
        $this->db->delete('log');
    }

    function deleteall() {
        $this->db->empty_table('log');
    }

    function selectone($id) {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->where('log_id', $id);
        $query = $this->db->get();
        return $query;
    }

    function update($id, $data) {
        $this->db->where('log_id', $id);
        $this->db->update('log', $data);
    }

    function get_log() {
        /*$this->db->select('log.*, user_sim.user_name AS user_name');
        $this->db->from('log');
        $this->db->join('user_sim', 'log.user_id = user_sim.user_id');
        $this->db->where($parameter);
        $this->db->order_by("log_time","desc");
        $query = $this->db->get();
        //return (count($query->num_rows()) > 0 ? $query->result() : NULL);
        return $query;
        */
        $sql = "SELECT log.*,user_sim.user_name AS user_name FROM log
                JOIN user_sim ON log.user_id = user_sim.user_id
                ORDER BY log_time DESC";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            $this->db->select('count(*) AS Total');
            $this->db->from('log');
            $this->db->where($parameter);
            $query = $this->db->get();
            foreach($query->result() as $row){
              return $row->Total;
            }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
        }else{
            $this->db->select('count(*) AS Total');
            $this->db->from('log');
            $query = $this->db->get();
            foreach($query->result() as $row){
              return $row->Total;
            }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
        }
    }

    function get_notif() {
        $today = date("d-m-Y");
        $query = $this->db->query('SELECT `log`.`notif_id`,`log`.`notif_teks`,`log`.`notif_tanggal`,`logtipe`.`tipe_nama`
            FROM `log`,`logtipe`
            WHERE `log`.`notif_tipe` = `logtipe`.`tipe_id`
                AND DATE_FORMAT(`log`.`notif_tanggal`,"%d-%m-%Y") = "'. $today .'"
            ORDER BY `log`.`notif_tanggal` DESC');
        return $query;
    }

    function get_count($tanggal = null) {
        if($tanggal == null) {
            $this->db->select('count(*) as Total');
            $this->db->from('log');
            $query = $this->db->get();
            return $query;
        } else {
            $this->db->select('count(*) as Total');
            $this->db->from('log');
            $this->db->where('log_time', $tanggal);
            $query = $this->db->get();
            return $query;
        }
    }

}

?>
