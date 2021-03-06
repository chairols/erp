<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Marcas/listar
     */

    public function get_cantidad($code, $estado) {
        $query = $this->db->query("SELECT COUNT(*) as cantidad
                                    FROM
                                        marcas
                                    WHERE
                                        (marca LIKE '%$code%' OR
                                        nombre_corto LIKE '%$code%') AND
                                        estado = '$estado'");
        return $query->row_array();
    }

    /*
     *  Marcas/listar
     */

    public function gets_limit($marca, $pagina, $cantidad, $estado) {
        $query = $this->db->query("SELECT *
                                    FROM
                                        marcas
                                    WHERE
                                        (marca LIKE '%$marca%' OR
                                        nombre_corto LIKE '%$marca%') AND
                                        estado = '$estado' 
                                    ORDER BY
                                        marca
                                    LIMIT $pagina, $cantidad");
        return $query->result_array();
    }

    /*
     *  Artículos/agregar_ajax
     *  Artículos/agregar_full_ajax
     *  Articulos/borrar_articulo_ajax
     *  Artículos/gets_articulos_ajax
     *  Artículos/get_where_json
     *  Artículos/modificar
     * 
     *  Cotizaciones_proveedores/agregar_articulo_ajax
     *  Cotizaciones_proveedores/listar
     *  Cotizaciones_proveedores/listar_articulos_tabla_ajax
     * 
     *  Importaciones/modificar_item
     * 
     *  Marcas/agregar_ajax
     *  Marcas/borrar_ajax
     *  Marcas/modificar
     */

    public function get_where($where) {
        $query = $this->db->get_where('marcas', $where);

        return $query->row_array();
    }

    /*
     *  Marcas/gets_marcas_ajax
     */

    public function gets_where_ajax($where) {
        $this->db->select('idmarca as id, marca as text');
        $this->db->from('marcas');
        $this->db->like($where);
        $this->db->order_by('marca');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Listas_de_precios/asociar_marcas
     *  Listas_de_precios/nueva_comparacion
     */

    public function gets() {
        $this->db->select('*');
        $this->db->from('marcas');
        $this->db->order_by('marca');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Marcas/agregar_ajax
     */

    public function set($datos) {
        $this->db->insert('marcas', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Marcas/modificar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('marcas', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Articulos/listar
     *  
     *  Marcas/gets_marcas_ajax
     */
    public function gets_where($where) {
        $query = $this->db->get_where('marcas', $where);
        return $query->result_array();
    }

}

?>
