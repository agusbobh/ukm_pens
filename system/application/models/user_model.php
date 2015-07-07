<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends Model {

    function User_model() {
        parent::Model();
    }

    function get_login_info($username) {
        $sql = "SELECT user_sim.user_id, user_sim.user_name, user_sim.user_pass, user_sim.user_role, user_sim.user_mail, user_sim.ukm_id, role.role_name AS rolename, ukm.ukm_name AS ukm_name
            FROM user_sim
            INNER JOIN role ON user_sim.user_role = role.role_id
            INNER JOIN ukm ON ukm.ukm_id = ukm.ukm_id
            WHERE user_sim.user_name = '" .$username. "' ";


        /*
        $query = $this->db->query('SELECT
            user_sim.user_id, user_sim.user_name, user_sim.user_pass, user_sim.user_role, user_sim.user_mail, user_sim.ukm_id, role.role_name AS rolename
            FROM user_sim
            INNER JOIN role ON user_sim.user_role = role.role_id
            WHERE user_sim.user_name = "' . $username . '"
            ');

        */

        $query = $this->db->query($sql);
        return $query;
        // if($query->num_rows() > 0){
        //     return $query->row();
        // }else{
        //     return FALSE;
        // }


        //return ($query->num_rows() > 0) ? $query->row() : FALSE;
        //return $query;
    }

    function get_menu($role) {
    		$sql = "SELECT user_menu.* FROM user_akses INNER JOIN user_menu
    				ON user_akses.akses_menu = user_menu.akses_menu WHERE
    				user_akses.role_id='".$role."' AND user_menu.menu_tipe= '0'
                    ORDER BY user_menu.menu_urutan";
    		$query= $this->db->query($sql);

    		$menu = '';
    		$menu_child = '';

            $pre[] = $query->_fetch_object();
            $result = $pre[0];

            if($result){
    			foreach ($result as $parent){

    				$li_parent='';

    				$sql = "SELECT user_menu.* FROM user_akses INNER JOIN user_menu
    						ON user_akses.akses_menu = user_menu.akses_menu WHERE
    						user_akses.role_id='".$role."' AND user_menu.menu_tipe='1' AND user_menu.menu_parent='".$parent->AKSES_MENU."'
    						ORDER BY user_menu.menu_urutan";

                    $result_child = $this->db->query($sql);

    				if($result_child->num_rows() > 0){
    				    $li_parent='class="treeview"';
    					$menu_child='<ul class="treeview-menu">';
    					foreach ($result_child as $child){
                $urlchild = "dashboard".$child->MENU_URL;
    						$menu_child = $menu_child.'<li><a href="'.site_url($urlchild).'"><i class="'.$child->MENU_ICON.'"></i> '.$child->MENU_NAMA.'</a></li>';
    					}
    					$menu_child = $menu_child.'</ul>';
    				}

            $urlparent = "dashboard".$parent->MENU_URL;
    				$menu = $menu.'
                                <li '.$li_parent.' id="li-'.$parent->AKSES_MENU.'">
                                    <a href="'.site_url($urlparent).'">
                                        <i class="'.$parent->MENU_ICON.'"></i> <span>'.$parent->MENU_NAMA.'</span>
                                        '.$menu_child.'
                                    </a>
                                </li>';

                }
    		}
    		return $menu;

    }

    function get_total($parameter) {
        if(!empty($parameter)){
            // $this->db->select('count(*) AS Total');
            // $this->db->from('user_sim');
            // $this->db->where($parameter);
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM user_sim
                    WHERE  user_id = ".$parameter." ";
            $query = $this->db->query($sql);
            return $query;
        }else{
            // $this->db->select('count(*) AS Total');
            // $this->db->from('user_sim');
            // $query = $this->db->get();
            // foreach($query->result() as $row){
            //   return $row->Total;
            // }
            //return (count($query->row_array()) > 0 ? $query->row()->Total : 0);
            $sql = "SELECT count(*) AS Total FROM user_sim ";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    function get_role() {
      $query = $this->db->query("SELECT * FROM role");
      return $query;
    }

    function cek($field, $value) {
        /*$this->db->select('*');
        $this->db->from('user_sim');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        */
        $sql = "SELECT * FROM user_sim WHERE ".$field." = '".$value."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function insert($ukm_id, $user_name, $user_mail, $user_pass, $user_role) {
        //$this->db->insert('user_sim', $data);
        $sql = "INSERT INTO user_sim (user_id, ukm_id, user_name, user_mail, user_pass, user_status, user_created, user_role)"
                . "VALUES(USER_ID_SEQ.NEXTVAL,'".$ukm_id."', '".$user_name."', '".$user_mail."', '".$user_pass."', '1', SYSDATE, '".$user_role."')";
        $query = $this->db->query($sql);
        return $query;
    }

    function delete($id) {
        /*
        $this->db->where('user_id', $id);
        $this->db->delete('user_sim');
        */
        $sql = "DELETE FROM user_sim WHERE user_id = ".$id." ";
        $query = $this->db->query($sql);
        return $query;
    }

    function reset($data) {
      $query = $this->db->query("SELECT * FROM user_sim WHERE .'$data'");
      return $query;
      /*
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($data);
        $query = $this->db->get();
        return $query;
      */
    }

    function update($iduser, $username, $email, $idrole, $idukm ) {
        // $this->db->where('user_id', $id);
        // $this->db->update('user_sim', $data);
        $sql = "UPDATE user_sim SET user_name =  '".$username."', user_mail = '".$email."', user_role = '".$idrole."', ukm_id = '".$idukm."' WHERE user_id = '".$iduser."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_pass($iduser, $passbaru) {
        // $this->db->where('user_id', $id);
        // $this->db->update('user_sim', $data);
        $sql = "UPDATE user_sim SET user_pass = '".$passbaru."' WHERE user_id = '".$iduser."' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function update_status($id, $status){
          $sql = "UPDATE user_sim SET user_status = ".$status." WHERE user_id = ".$id." ";
          $query = $this->db->query($sql);
          return $query;
    }

    function get_user($parameter) {
        /*$this->db->select('user_sim.*, role.role_name AS Role, ukm.ukm_name AS UKM');
        $this->db->from('user_sim');
        $this->db->join('role', 'user_sim.user_role = role.role_id');
        $this->db->join('ukm', 'user_sim.ukm_id = ukm.ukm_id');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        */

        $sql = "SELECT user_sim.*, role.role_name AS Role, ukm.ukm_name AS UKM FROM user_sim
                JOIN role ON user_sim.user_role = role.role_id
                LEFT JOIN ukm ON user_sim.ukm_id = ukm.ukm_id
                WHERE  user_sim.user_id = ".$parameter." ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_list_user($parameter) {
        $sql = "SELECT user_sim.*, role.role_name AS Role FROM user_sim
                JOIN role ON user_sim.user_role = role.role_id
                WHERE  user_sim.user_role = ".$parameter." ";
        $query = $this->db->query($sql);
        return $query;
    }

    function get_userakses($parameter) {
        /*$this->db->select('user_akses.*, role.role_name AS Role');
        $this->db->from('user_akses');
        $this->db->join('role', 'user_akses.role_id = role.role_id');
        $this->db->where($parameter);
        $query = $this->db->get();
        return $query;
        */
        $query = $this->db->query("SELECT user_akses.*, role.role_name AS Role FROM user_akses
                  JOIN role ON user_akses.role_id = role.role_id
                  WHERE role.role_id = '".$parameter."'  ");
        return $query;
    }

    function get_daftaruser() {

        $sql = "SELECT
            user_sim.user_id AS ID,
            user_sim.user_name AS Username,
            ukm.ukm_name AS UKM,
            user_sim.user_created AS Dibuat,
            user_sim.user_mail AS Mail,
            role.role_name AS Role,
            REPLACE(REPLACE(user_sim.user_status,'0', 'Nonaktif'),'1','Aktif') AS Status
        FROM user_sim
        INNER JOIN role ON user_sim.user_role = role.role_id
        INNER JOIN ukm ON user_sim.ukm_id = ukm.ukm_id
        ORDER BY user_sim.user_created ";

        $query = $this->db->query($sql);
        return $query;
    }

    function get_count_daftaruser($search) {

        $sql = "SELECT
            COUNT(*) AS Total
        FROM `user_sim` ";

        return $this->db->query($sql);
    }

}

?>
