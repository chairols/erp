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
}
