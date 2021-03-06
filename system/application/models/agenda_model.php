<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Agenda_model extends Model {

    function Agenda_model() {
        parent::Model();
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            $sql = "SELECT count(*) AS Total FROM agenda
                    WHERE  ukm_id = ".$parameter." ";
            $query = $this->db->query($sql);
            return $query;
        }else{
            $sql = "SELECT count(*) AS Total FROM agenda";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function get_subtotal($ukmid, $status) {
            $sql = "SELECT count(*) AS Total FROM agenda
                    WHERE  ukm_id = ".$ukmid." AND agenda_status = ".$status." ";
            $query = $this->db->query($sql);
            return $query;
    }

    function insert($idukm, $agenda_title, $timefrom, $timeto, $agenda_status, $agenda_teks) {
        // $this->db->insert('agenda', $data);
        $sql = "INSERT INTO agenda (AGENDA_ID, UKM_ID, AGENDA_TITLE, AGENDA_TIME, AGENDA_TIMETO, AGENDA_STATUS, AGENDA_TEXT)"
                . "VALUES(AGENDA_ID_SEQ.NEXTVAL,'".$idukm."', '".$agenda_title."', TO_DATE('".$timefrom."', 'YYYY-MM-DD HH:MI:SS'), TO_DATE('".$timeto."', 'YYYY-MM-DD HH:MI:SS') , '".$agenda_status."', '".$agenda_teks."')";
        $query = $this->db->query($sql);
        return $query;
    }

    function delete($id) {
        $sql = "UPDATE agenda SET agenda_status = '2' WHERE agenda_id = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update($idagenda, $judul, $timefrom, $timeto, $idstatus, $teks) {
        $sql = "UPDATE agenda SET agenda_title = '".$judul."', agenda_time = '".$timefrom."', agenda_timeto = '".$timeto."', agenda_status = '".$idstatus."', agenda_text = '".$teks."'  WHERE agenda_id = '".$idagenda."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_agenda($id) {
        $sql = "SELECT agenda.*, tipenotif.tipe_nama AS tipe_nama, tipenotif.tipe_teks AS teks
                FROM agenda JOIN tipenotif ON agenda.agenda_status = tipenotif.tipe_id
                WHERE ukm_id = '".$id."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_list_agenda() {
        $sql = "SELECT *  FROM agenda
                WHERE agenda_status != 0 ";
        $query = $this->db->query($sql);
        return $query;
    }

    function view_agenda(){
      $sql    = "select * from agenda join ukm on ukm.ukm_id = agenda.ukm_id where agenda_status != 0 order by agenda_time desc";         //ganti sql sesuai database
      $query = $this->db->query($sql);
      return $query;
    }

    function get_daftaragenda($idukm) {

        $sql = "SELECT
            agenda.agenda_id AS ID,
            agenda.ukm_id AS UKMid,
            ukm.ukm_name AS UKM,
            agenda.agenda_title AS Title,
            agenda.agenda_text AS Teks,
            agenda.agenda_time AS Time,
            agenda.agenda_timeto AS Timeto,
            agenda.agenda_status AS StatusID,
            REPLACE(REPLACE(REPLACE(REPLACE(agenda.agenda_status,'0','Draft'),'1','Publish'),'2','Hapus'),'3','Selesai') AS Status
        FROM agenda
        INNER JOIN ukm ON (agenda.ukm_id = ukm.ukm_id)
        WHERE agenda.ukm_id = ". $idukm ."
        ORDER BY agenda.agenda_id";

        return $this->db->query($sql);
    }

    function get_count_daftaragenda($ukm, $search) {

        $sql = "SELECT
            COUNT(*) AS Total
        FROM `agenda`
        WHERE `agenda`.`ukm_id` = ". $ukm ." AND (`agenda`.`agenda_id` LIKE '%".$search."%'
                OR `agenda`.`agenda_title` LIKE '%".$search."%'
                OR `agenda`.`agenda_text` LIKE '%".$search."%'
                OR REPLACE(REPLACE(REPLACE(REPLACE(`agenda`.`agenda_status`,'0','Draft'),'1','Publish'),'2','Hapus'),'3','Selesai') LIKE '%".$search."%'
                OR `agenda`.`agenda_time` LIKE '%".$search."%'
                OR `agenda`.`agenda_timeto` LIKE '%".$search."%')";

        return $this->db->query($sql);
    }

}

?>
