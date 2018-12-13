<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_proveedores/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('cotizaciones_proveedores', $datos);
        return $this->db->insert_id();
    }
}
?>