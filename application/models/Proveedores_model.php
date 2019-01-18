<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_proveedores/listar
     *  Cotizaciones_proveedores/modificar
     * 
     *  Importaciones/pedido_pdf
     * 
     *  Importar/proveedores
     * 
     *  Preordenes/generar_orden_ajax
     * 
     *  Proveedores/checkCUIT_ajax
     * 
     */
    public function get_where($where)
    {

        $query = $this->db->get_where( 'proveedores', $where );

        return $query->row_array();

    }

    /*
     *  Importar/proveedores
     * 
     *  Proveedores/agregar_ajax
     */

    public function set($datos) {
        $this->db->insert('proveedores', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Cotizaciones_proveedores/actualizar_cabecera_ajax
     * 
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

    /*
     *  Proveedores/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('proveedores');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Proveedores/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('proveedores');
        $this->db->like($where);
        $this->db->order_by('proveedor');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Proveedores/modificar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('proveedores', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>
