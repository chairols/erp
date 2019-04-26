<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_de_cuentas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function gets_like($like) {
        $this->db->select("idplan_de_cuenta as id, concat_ws(' - ', idplan_de_cuenta, plan_de_cuenta) as text");
        $this->db->from('plan_de_cuentas');
        $this->db->like($like);
        $this->db->order_by('text');

        $query = $this->db->get();
        return $query->result_array();
    }
}

?>