<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }
    
    /*
     *  Articulos_genericos/agregar_ajax
     * 
     *  Cotizaciones_proveedores/agregar_articulo_ajax
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
    public function get_cantidad_where($where, $like) {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->join('usuarios', 'log.idusuario = usuarios.idusuario');
        $this->db->where($where);
        $this->db->like($like);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Log/listar
     */
    public function gets_where_limit($where, $like, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->join('usuarios', 'log.idusuario = usuarios.idusuario');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('idlog DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>