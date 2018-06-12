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
}

?>