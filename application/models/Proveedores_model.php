<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importaciones/pedido_pdf
     * 
     *  Importar/proveedores
     */

    public function get_where($where)
    {

        $query = $this->db->get_where( 'proveedores', $where );

        return $query->row_array();

    }

    /*
     *  Importar/proveedores
     */

    public function set($datos) {
        $this->db->insert('proveedores', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Proveedores/gets_proveedores_ajax
     */
    public function gets_where($where) {
        $this->db->select('idproveedor as id, proveedor as text');
        $this->db->from('proveedores');
        $this->db->like($where);
        $this->db->order_by('proveedor');

        $query = $this->db->get();
        return $query->result_array();
    }

}

?>
