<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  libraries/r_session
     */
    public function obtener_menu_por_padre_para_menu($idpadre, $idperfil) {
        $query = $this->db->query("SELECT m.*, pm.idperfil 
                                    FROM
                                        (menu m
                                    INNER JOIN
                                        perfiles_menu pm
                                    ON
                                        m.idmenu = pm.idmenu AND
                                        pm.idperfil = '$idperfil')
                                    WHERE
                                        m.padre = '$idpadre'
                                    ORDER BY
                                        m.orden, m.menu" );
        return $query->result_array();
    }
    
    public function get_perfil_menu($idperfil, $menu) {
        $query = $this->db->query("SELECT * 
                                    FROM
                                        menu m,
                                        perfiles_menu pm
                                    WHERE
                                        m.href = '$menu' AND
                                        pm.idperfil = '$idperfil' AND
                                        m.idmenu = pm.idmenu");
        
        return $query->result_array();
    }

}
