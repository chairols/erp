<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class sucursales_model extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

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
