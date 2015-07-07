<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anggota_model extends Model {

    function Anggota_model() {
        parent::Model();
    }

    function get_total($parameter) {
        if(!empty($parameter)){
            // $this->db->select('count(*) AS Total');
            // $this->db->from('anggota');
            // $this->db->where($parameter);
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM anggota
                    WHERE  ukm_id = ".$parameter." ";
            $query = $this->db->query($sql);
            return $query;
        }else{
            // $this->db->select('count(*) AS Total');
            // $this->db->from('anggota');
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM anggota";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function get_subtotal($ukmid, $status) {
            $sql = "SELECT count(*) AS Total FROM anggota
                    WHERE  ukm_id = ".$ukmid." AND anggota_status = ".$status." ";
            $query = $this->db->query($sql);
            return $query;
    }

    function get_totaljabatan($ukmid, $status) {
            $sql = "SELECT count(*) AS Total FROM anggota
                    WHERE  ukm_id = ".$ukmid." AND anggota_level= ".$status." ";
            $query = $this->db->query($sql);
            return $query;
    }

    function insert($anggota_ukm, $anggota_name, $anggota_level) {
        // $this->db->insert('anggota', $data);
        $sql = "INSERT INTO anggota (ANGGOTA_ID, UKM_ID, ANGGOTA_NAME, ANGGOTA_STATUS, ANGGOTA_LEVEL)"
                . "VALUES(ANGGOTA_ID_SEQ.NEXTVAL,'".$anggota_ukm."', '".$anggota_name."','1','".$anggota_level."')";
        $query = $this->db->query($sql);

        return $query;
    }

    function delete($id) {
        // $this->db->where('anggota_id', $id);
        // $this->db->delete('anggota');
        $sql = "DELETE FROM anggota WHERE anggota_id = ".$id." ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update($idanggota, $nama, $idstatus, $idlevel) {
        // $this->db->where('anggota_id', $id);
        // $this->db->update('anggota', $data);
        $sql = "UPDATE anggota SET anggota_name = '".$nama."', anggota_status = '".$idstatus."', anggota_level = '".$idlevel."'  WHERE anggota_id = '".$idanggota."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_anggota($id = 0) {
        if($id == 0) {
            $this->db->select('*');
            $this->db->from('anggota');
            $query = $this->db->get();
            return $query;
        } else {
            $this->db->select('*');
            $this->db->from('anggota');
            $this->db->where('anggota_id',$id);
            $query = $this->db->get();
            return $query->row();
        }

    }

    function get_daftaranggota($idukm) {

        $sql = "SELECT
            anggota.anggota_id AS ID,
            anggota.ukm_id AS UKMid,
            ukm.ukm_name AS UKM,
            anggota.anggota_name AS Nama,
            anggota.anggota_status AS StatusID,
            anggota.anggota_level AS LevelID,
            REPLACE(REPLACE(REPLACE(anggota.anggota_level,'10','Anggota'),'11','Pengurus'),'12','Ketua') AS Jabatan,
            REPLACE(REPLACE(anggota.anggota_status,'0','Nonaktif'),'1','Aktif') AS Status
        FROM anggota
        INNER JOIN ukm ON (anggota.ukm_id = ukm.ukm_id)
        WHERE anggota.ukm_id = ". $idukm ."
        ORDER BY anggota.anggota_id ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_count_daftaranggota($ukm, $search) {

        $sql = "SELECT
            COUNT(*) AS Total
        FROM `anggota`
        INNER JOIN `ukm` ON (`anggota`.`ukm_id` = `ukm`.`ukm_id`)
        WHERE `anggota`.`ukm_id` = ". $ukm ." AND (`anggota`.`anggota_id` LIKE '%".$search."%'
                OR `anggota`.`anggota_name` LIKE '%".$search."%'
                OR REPLACE(REPLACE(`anggota`.`anggota_status`,'0','Nonaktif'),'1','Aktif') LIKE '%".$search."%'
                OR REPLACE(REPLACE(REPLACE(`anggota`.`anggota_level`,'10','Anggota'),'11','Pengurus'),'12','Ketua') LIKE '%".$search."%')";

        return $this->db->query($sql);
    }

}

?>
