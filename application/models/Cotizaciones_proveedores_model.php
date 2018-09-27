<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_proveedores/agregar
     */
    public function set( $datos )
    {

        $this->db->insert( 'cotizaciones_proveedores', $datos );

        return $this->db->insert_id();

    }

    /*
     *  Cotizaciones_proveedores/agregar
     */
    public function set_archivos( $registros )
    {

        $this->db->insert_batch( 'cotizaciones_proveedores_archivos', $registros );

    }

    public function get_where( $where )
    {

        $query = $this->db->get_where( 'cotizaciones_proveedores', $where );

        return $query->row_array();

    }

    /*
     *  Cotizaciones/internacionales
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('cotizaciones_proveedores');
        $this->db->join('proveedores', 'cotizaciones_proveedores.idproveedor = proveedores.idproveedor');
        $this->db->join('monedas', 'cotizaciones_proveedores.idmoneda = monedas.idmoneda');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Cotizaciones/internacionales
     */
    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('*, CONCAT(monedas.simbolo, " ", cotizaciones_proveedores.total) as total_formateado');
        $this->db->from('cotizaciones_proveedores');
        $this->db->join('proveedores', 'cotizaciones_proveedores.idempresa = proveedores.idempresa');
        $this->db->join('monedas', 'cotizaciones_proveedores.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        $this->db->order_by('idcotizacion DESC');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Cotizaciones/internacionales
     */
    public function gets_items_where($where) {
        $this->db->select('*');
        $this->db->from('cotizaciones_proveedores_items');
        $this->db->join('articulos', 'cotizaciones_proveedores_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function gets_archivos_ajax( $where )
    {

        $this->db->select( '*' );

        $this->db->from( 'cotizaciones_proveedores_archivos' );

        $this->db->join( 'archivos', 'cotizaciones_proveedores_archivos.idarchivo = archivos.idarchivo' );

        $this->db->like($where);

        $query = $this->db->get();

        $archivos = $query->result_array();

        echo json_encode( $archivos );

    }

    public function eliminar_archivo( $id )
    {

        $idarchivo    = array( 'idarchivo' => $id );

        $this->db->delete( 'cotizaciones_proveedores_archivos', $idarchivo );

    }
}

?>
