<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Parametros/agregar
     */
    public function gets_tipos_parametros() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        parametros_tipos
                                    WHERE
                                        estado = 'A'
                                    ORDER BY
                                        parametro_tipo");
        return $query->result_array();
    }
    
    
    /*
     *  Parametros/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('parametros', $where);
        return $query->row_array();
    }
    
    /*
     *  Parametros/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('parametros', $datos);
        return $this->db->insert_id();
    }
}

?>
