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
    
    
    /*
     *  libraries/r_session
     */
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
    
    /*
     *  Menu/listar
     */
    public function get_cantidad_pendientes($titulo) {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        menu
                                    WHERE
                                        titulo LIKE '%$titulo%' OR
                                        menu LIKE '%$titulo%'");
        
        return $query->row_array();
    }
    
    
    /*
     *  Menu/listar
     */
    public function gets_where_titulo_limit($titulo, $pagina, $cantidad_por_pagina) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        menu
                                    WHERE
                                        titulo LIKE '%$titulo%' OR
                                        menu LIKE '%$titulo%'
                                    ORDER BY
                                        titulo
                                    LIMIT $pagina, $cantidad_por_pagina");
        return $query->result_array();
    }
    
    
    /*
     *  Menu/listar
     */
    public function gets() {
        $query = $this->db->query("SELECT *
                    FROM
                        menu");
        return $query->result_array();
                    
    }
    
    /*
     *  Menu/listar
     */
    public function get_where($where) {
        $query = $this->db->get_where('menu', $where);
        
        return $query->row_array();
    }
    
    
    /*
     *  Menu/agregar
     */
    public function gets_padres_ordenados($idpadre) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        menu
                                    WHERE
                                        padre = '$idpadre' AND
                                        visible = '1'
                                    ORDER BY
                                        orden");
        return $query->result_array();              
    }
    
    
    /*
     *  Menu/agregar
     */
    public function set($datos) {
        $this->db->insert('menu', $datos);
        return $this->db->insert_id();
    }

}
