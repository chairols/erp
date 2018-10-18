<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Usuarios/login
     */
    public function get_usuario($usuario, $password) {
        $query = $this->db->query("SELECT 
                                        idusuario,
                                        usuario,
                                        nombre,
                                        apellido,
                                        email,
                                        imagen
                                    FROM
                                        usuarios
                                    WHERE
                                        usuario = '$usuario' AND
                                        password = '$password' AND
                                        estado = 'A'");
        return $query->row_array();
    }
    
    
    /*
     *  Usuarios/login
     */
    public function update($where, $idusuario) {
        $this->db->update('usuarios', $where, array('idusuario' => $idusuario));
        return $this->db->affected_rows();
    }
    
    
    /*
     *  Usuarios/login
     */
    public function get_perfil($idusuario) {
        $where = array(
            'idusuario' => $idusuario
        );
        $query = $this->db->get_where('usuarios_perfiles', $where);
        
        return $query->row_array();
    }
    
    
    /*
     *  Usuarios/listar
     */
    public function get_cantidad($codigo, $estado) {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        usuarios u,
                                        usuarios_perfiles up,
                                        perfiles p
                                    WHERE
                                        (u.usuario LIKE '%$codigo%' OR
                                        u.nombre LIKE '%$codigo%' OR
                                        u.apellido LIKE '%$codigo%' OR
                                        u.email LIKE '%$codigo%') AND
                                        u.estado = '$estado' AND
                                        u.idusuario = up.idusuario AND
                                        up.idperfil = p.idperfil");
        return $query->row_array();
    }
    
    
    /*
     *  Usuarios/listar
     */
    public function gets_limit($codigo, $pagina, $cantidad, $estado) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        usuarios u,
                                        usuarios_perfiles up,
                                        perfiles p
                                    WHERE
                                        (u.usuario LIKE '%$codigo%' OR
                                        u.nombre LIKE '%$codigo%' OR
                                        u.apellido LIKE '%$codigo%' OR
                                        u.email LIKE '%$codigo%') AND
                                        u.estado = '$estado' AND
                                        u.idusuario = up.idusuario AND
                                        up.idperfil = p.idperfil
                                    ORDER BY
                                        u.usuario
                                    LIMIT $pagina, $cantidad");
        return $query->result_array();
    }
    
    
    /*
     *  Usuarios/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('usuarios', $where);
        return $query->row_array();
    }
    
    /*
     *  Usuarios/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('usuarios', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Usuarios/agregar_ajax
     */
    public function set_perfil($datos) {
        $this->db->insert('usuarios_perfiles', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Usuarios/modificar_ajax
     */
    public function update_perfil($datos, $where) {
        $this->db->update('usuarios_perfiles', $datos, $where);
        return $this->db->affected_rows();
    }
    
    public function gets_where($where) {
        $this->db->select("nombre, apellido, idusuario");
        $this->db->from('usuarios');
        $this->db->where($where);
        $this->db->order_by("nombre, apellido");
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
