<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_horarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Clientes/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('tipos_horarios');
        $this->db->order_by('tipo_horario');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/agregar_horario_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('tipos_horarios', $where);

        return $query->row_array();
    }
}

?>