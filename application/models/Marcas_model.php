<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Marcas/listar
     */
    public function get_cantidad($code, $estado) {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        marcas
                                    WHERE
                                        (marca LIKE '%$code%' OR
                                        nombre_corto LIKE '%$code%') AND
                                        estado = '$estado'");
        return $query->row_array();
    }
    
    
    /*
     *  Marcas/listar
     */
    public function gets_limit($marca, $pagina, $cantidad, $estado) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        marcas
                                    WHERE
                                        (marca LIKE '%$marca%' OR
                                        nombre_corto LIKE '%$marca%') AND
                                        estado = '$estado' 
                                    ORDER BY
                                        marca
                                    LIMIT $pagina, $cantidad");
        return $query->result_array();
    }
    
    /*
     *  Artículos/gets_articulos_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('marcas', $where);
        
        return $query->row_array();
    }
}

?>
