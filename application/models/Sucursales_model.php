<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class sucursales_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

    }

    /*
     * Clientes/nueva_sucursal_ajax
     */
    public function set( $datos )
    {

        $this->db->insert( 'clientes_sucursales', $datos );

        return $this->db->insert_id();

    }

    /*
     *  Cotizaciones
     */
    public function gets_where_para_ajax( $where, $limit = 100 )
    {

        $this->db->select( '*' );

        $this->db->from( 'empresas_sucursales' );

        $this->db->like( $where );

        $this->db->order_by( 'sucursal' );

        $this->db->limit( $limit );

        $query = $this->db->get();

        return $query->result_array();

    }

    /*
     *  Clientes/modificar
     */
    public function gets_where( $where, $limit = 100 )
    {

        $this->db->select( '*' );

        $this->db->from( 'clientes_sucursales' );

        $this->db->like( $where );

        $this->db->order_by( 'sucursal' );

        $this->db->limit( $limit );

        $query = $this->db->get();

        return $query->result_array();

    }

    /*
     *
     */
    public function get_where( $where )
    {

        $query = $this->db->get_where( 'clientes_sucursales', $where );

        return $query->row_array();

    }

    /*
     *  Clientes/modificar_sucursal_ajax
     *
     *  Clientes/eliminar_sucursal_ajax
     */
    public function update( $datos, $where )
    {

        $this->db->update( 'clientes_sucursales', $datos, $where);

        return $this->db->affected_rows();

    }

}
