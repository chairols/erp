<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monedas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Monedas/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('monedas');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Monedas/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('monedas');
        $this->db->like($where);
        $this->db->order_by('moneda');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Cotizaciones_proveedores/actualizar_cabecera_ajax
     *  Cotizaciones_proveedores/listar
     *  Cotizaciones_proveedores/modificar
     * 
     *  Importaciones/pedido_pdf
     * 
     *  Monedas/agregar_ajax
     *  Monedas/modificar
     * 
     *  Preordenes/listar
     * 
     *  Proveedores/agregar_ajax
     * 
     */
    public function get_where($where) {
        $query = $this->db->get_where('monedas', $where);
        return $query->row_array();
    }

    /*
     *  Cotizaciones_proveedores/agregar
     * 
     *  Importaciones/agregar
     * 
     *  Listas_de_precios/asociar_generico
     */
    public function gets() {
      $query = $this->db->query("SELECT * 
                                    FROM 
                                        monedas 
                                    WHERE 
                                        estado = 'A' 
                                    ORDER BY 
                                        moneda");
      return $query->result_array();
    }

    /*
     *  Monedas/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('monedas', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Monedas/modificar_ajax
     */
    public function update($where, $idmoneda) {
        $this->db->update('monedas', $where, array('idmoneda' => $idmoneda));
        return $this->db->affected_rows();
    }
    
    /*
     *  Crontab/monedas
     */
    public function get_where_monedas_historial($where) {
        $query = $this->db->get_where('monedas_historial', $where);
        return $query->row_array();
    }
    
    /*
     *  Crontab/monedas
     */
    public function set_monedas_historial($datos) {
        $this->db->insert('monedas_historial', $datos);
        return $this->db->insert_id();
    }
    
    public function get_ultima_cotizacion_por_monedas($idmoneda) {
        $query = $this->db->query("SELECT * 
                                    FROM 
                                        monedas_historial mh, 
                                        monedas m
                                    WHERE 
                                        mh.fecha = (SELECT MAX(fecha) FROM monedas_historial) AND
                                        mh.idmoneda = '$idmoneda' AND
                                        m.idmoneda = mh.idmoneda");
        return $query->row_array();
    }
    
    public function gets_historial($idmoneda, $desde, $hasta) {
        $query = $this->db->query("SELECT mh.*, m.moneda
                                    FROM
                                        monedas_historial mh, 
                                        monedas m 
                                    WHERE
                                        mh.idmoneda = m.idmoneda AND
                                        m.idmoneda = '$idmoneda' AND
                                        mh.fecha BETWEEN '$desde' AND '$hasta'
                                    ORDER BY
                                        mh.fecha");
        return $query->result_array();
    }
}

?>
