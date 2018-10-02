<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Perfiles/listar
     */
    public function get_cantidad($code, $estado) {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        perfiles
                                    WHERE
                                        perfil LIKE '%$code%' AND
                                        estado = '$estado'");
        return $query->row_array();
    }
    /*
     *  Perfiles/listar
     */
    public function gets_limit($perfil, $pagina, $cantidad, $estado) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        perfiles
                                    WHERE
                                        perfil LIKE '%$perfil%' AND
                                        estado = '$estado' 
                                    ORDER BY
                                        perfil
                                    LIMIT $pagina, $cantidad");
        return $query->result_array();
    }
    
    /*
     *  Perfiles/agregar_ajax
     *  Perfiles/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('perfiles', $where);
        return $query->row_array();
    }
    
    
    public function borrar_todos_los_accesos_por_perfil($idperfil) {
        $this->db->delete('perfiles_menu', array('idperfil' => $idperfil));
    }
    
    public function set_perfiles_menu($datos) {
        $this->db->insert('perfiles_menu', $datos);
        return $this->db->insert_id();
    }
    
    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        perfiles
                                    WHERE
                                        estado = 'A'
                                    ORDER BY
                                        perfil");
        return $query->result_array();
    }
    
    /*
     * Perfiles/actualizar_accesos
     */
    public function get_where_perfiles_menu($where) {
        $this->db->select("*");
        $this->db->from("perfiles_menu");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     * Perfiles/actualizar_accesos
     */
    public function borrar_perfiles_menu($where) {
        $this->db->delete('perfiles_menu', $where);
    }
    
    /*
     *  Perfiles/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('perfiles', $datos);
        return $this->db->insert_id();
    }
}

?>
