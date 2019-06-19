<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Facturacion/pedidos_ajax
     */
    public function set($datos) {
        $this->db->insert('comprobantes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Facturacion/pedido_modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('comprobantes', $where);
        return $query->row_array();
    }
    
    /*
     *  Facturacion/facturar_afip
     */
    public function update($datos, $where) {
        $this->db->update('comprobantes', $datos, $where);
        return $this->db->affected_rows();
    }
    
    public function get_ultimo_comprobante($PtoVta, $TipoComp) {
        $query = $this->db->query("SELECT max(numero_comprobante) as numero
                                    FROM
                                        comprobantes
                                    WHERE
                                        punto_de_venta = '$PtoVta' AND
                                        idtipo_comprobante = '$TipoComp' AND
                                        estado = 'P'");
        return $query->row_array();
    }
}

?>
