<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importar/clientes
     */
    public function get_where($where) {
        $query = $this->db->get_where('clientes', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importar/clientes
     */
    public function set($datos) {
        $this->db->insert('clientes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importar/clientes
     */
    public function set_sucursal($datos) {
        $this->db->insert('clientes_sucursales', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importar/clientes
     */
    public function set_agente($datos) {
        $this->db->insert('clientes_agentes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Clientes/gets_clientes_ajax
     */
    public function gets_where($where) {
        $this->db->select('idcliente as id, cliente as text');
        $this->db->from('clientes');
        $this->db->like($where);
        $this->db->order_by('cliente');

        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
