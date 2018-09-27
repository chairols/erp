<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Padrones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Padrones/jurisdiccion_901
     */

    public function set($datos) {
        $this->db->insert('padrones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Retenciones/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('padrones', $where);
        return $query->row_array();
    }
}

?>
