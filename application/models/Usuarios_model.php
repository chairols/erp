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
                                        email
                                    FROM
                                        usuarios
                                    WHERE
                                        usuario = '$usuario' AND
                                        password = '$password'");
        return $query->row_array();
    }
    
    
    /*
     *  Usuarios/login
     */
    public function update($where, $idusuario) {
        $this->db->update('usuarios', $where, array('idusuario' => $idusuario));
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
}
