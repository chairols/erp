<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provincias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function gets() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        provincias
                                    ORDER BY
                                        provincia");
        return $query->result_array();
    }
    
    /*
     *  Retenciones/agregar
     */
    public function gets_order_by($order_by) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        provincias
                                    ORDER BY
                                        $order_by");
        return $query->result_array();
    }
    
    /*
     *  Clientes/modificar_sucursal_ajax
     * 
     *  Proveedores/agregar_ajax
     *  
     *  Provincias/get_provincia_ajax
     * 
     */
    public function get_where($where) {
        $query = $this->db->get_where('provincias', $where);
        return $query->row_array();
    }
    
    /*
     *  Jurisdicciones/actualizar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('provincias', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>
