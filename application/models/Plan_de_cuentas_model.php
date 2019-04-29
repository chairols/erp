<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_de_cuentas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Plan_de_cuentas/gets_cuentas_json
     */
    public function gets_like($like) {
        $this->db->select("idplan_de_cuenta as id, concat_ws(' - ', idplan_de_cuenta, plan_de_cuenta) as text");
        $this->db->from('plan_de_cuentas');
        $this->db->like($like);
        $this->db->order_by('text');

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Plan_de_cuentas/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('plan_de_cuentas', $where);
        return $query->row_array();
    }
    
    /*
     *  Plan_de_cuentas/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('plan_de_cuentas', $datos);
        return $this->db->affected_rows();
    }
    
    /*
     * 
     */
    public function gets_where($where) {
        $query = $this->db->get_where('plan_de_cuentas', $where);
        return $query->result_array();
    }
    
}

?>