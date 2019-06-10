<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }
    
    /*
     *  Artículos/agregar_ajax
     * 
     *  Articulos_genericos/agregar_ajax
     * 
     *  Clientes/agregar_agente_ajax
     *  Clientes/agregar_ajax
     *  Clientes/agregar_horario_ajax
     *  Clientes/borrar_agente_ajax
     *  Clientes/borrar_horario_ajax
     *  Clientes/eliminar_sucursal_ajax
     *  Clientes/modificar_ajax
     *  Clientes/modificar_datos_impositivos_ajax
     *  Clientes/modificar_sucursal_ajax
     *  Clientes/nueva_sucursal_ajax
     * 
     *  Cotizaciones_clientes/agregar_ajax
     *  Cotizaciones_clientes/borrar_articulo_ajax
     * 
     *  Cotizaciones_proveedores/agregar_ajax
     *  Cotizaciones_proveedores/agregar_articulo_ajax
     * 
     *  Marcas/agregar_ajax
     *  Marcas/modificar_ajax
     *  
     *  Menu/agregar  -  Revisar
     * 
     *  Parametros/agregar_ajax  --  Revisar
     * 
     *  Retenciones/agregar_ajax
     *  Retenciones/agregar_item_ajax
     *  Retenciones/borrar_item
     *  Retenciones/borrar_retencion_ajax
     * 
     *  Transportes/agregar_ajax
     */
    public function set($array) {
        $this->db->insert('log', $array);
    }
    
    
    public function get_where($where) {
        $query = $this->db->get_where('log', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Log/listar
     */
    public function gets_usuarios() {
        $this->db->select("usuarios.idusuario, usuarios.nombre, usuarios.apellido");
        $this->db->from("log");
        $this->db->join("usuarios", "log.idusuario = usuarios.idusuario");
        $this->db->order_by("usuarios.nombre, usuarios.apellido");
        $this->db->group_by("usuarios.idusuario");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Log/listar
     */
    public function gets_tablas() {
        $this->db->select("*");
        $this->db->from("log");
        $this->db->order_by("log.tabla");
        $this->db->group_by("log.tabla");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Log/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->join('usuarios', 'log.idusuario = usuarios.idusuario');
        $this->db->where($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Log/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->join('usuarios', 'log.idusuario = usuarios.idusuario');
        $this->db->where($where);
        $this->db->order_by('idlog DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>