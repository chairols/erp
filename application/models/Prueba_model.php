<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    public function obtener_menu_por_padre($idpadre, $idperfil) {
        $this->db->select("menu.*, perfiles_menu.idperfil");
        $this->db->from("menu");
        $this->db->join("perfiles_menu", "menu.idmenu = perfiles_menu.idmenu AND perfiles_menu.idperfil = '$idperfil'", "left");
        $this->db->where(array("menu.padre" => $idpadre));
        $this->db->order_by("menu.orden, menu.menu");
        
        $query = $this->db->get();
        return $query->result_array();
//        $query = $this->db->query("SELECT * 
//                                    FROM
//                                        menu
//                                    WHERE
//                                        padre = '$idpadre'
//                                    ORDER BY
//                                        orden, menu" );
//        return $query->result_array();
    }
    
    public function get_where_perfiles_menu($where) {
        $this->db->select("*");
        $this->db->from("perfiles_menu");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function borrar_perfiles_menu($where) {
        $this->db->delete('perfiles_menu', $where);
    }
    
    public function update_menu($data, $where) {
        $this->db->update('menu', $data, $where);
    }

}

?>
