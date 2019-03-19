<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Clientes/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Clientes/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->like($where);
        $this->db->order_by('cliente');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Clientes/modificar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('clientes', $datos, $where);
        return $this->db->affected_rows();
    }

    /*
     *  Clientes/agregar_agente_ajax
     * 
     *  Cotizaciones_clientes/actualizar_cabecera_ajax
     *  Cotizaciones_clientes/agregar_ajax
     *  Cotizaciones_clientes/agregar_articulo_ajax
     *  Cotizaciones_clientes/modificar
     *  Importar/clientes
     */
    public function get_where($where) {
        $query = $this->db->get_where('clientes', $where);

        return $query->row_array();
    }

    /*
     *  Importar/clientes
     */
    public function set($datos) {
        $this->db->insert('clientes', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Importar/clientes
     */
    public function set_sucursal($datos) {
        $this->db->insert('clientes_sucursales', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Clientes/agregar_agente_ajax
     * 
     *  Importar/clientes
     */
    public function set_agente($datos) {
        $this->db->insert('clientes_agentes', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Clientes/gets_clientes_ajax
     */
    public function gets_where($where) {
        $this->db->select('idcliente as id, cliente as text');
        $this->db->from('clientes');
        $this->db->like($where);
        $this->db->order_by('cliente');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Clientes/gets_sucursales_select
     */
    public function gets_sucursales($where) {
        $this->db->select('*');
        $this->db->from('clientes_sucursales');
        $this->db->where($where);
        $this->db->order_by('sucursal');

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/agregar_horario_ajax
     */
    public function set_horario($datos) {
        $this->db->insert('clientes_horarios', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Clientes/gets_horarios_tabla
     */
    public function gets_horarios_where($where) {
        $this->db->select('*');
        $this->db->from('clientes_horarios');
        $this->db->join('tipos_horarios', 'clientes_horarios.idtipo_horario = tipos_horarios.idtipo_horario');
        $this->db->join('dias', 'clientes_horarios.iddia = dias.iddia');
        $this->db->where($where);
        $this->db->order_by('dias.iddia, clientes_horarios.desde');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/borrar_horario_ajax
     */
    public function update_horario($datos, $where) {
        $this->db->update('clientes_horarios', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Clientes/gets_agentes_tabla
     */
    public function gets_agentes_where($where) {
        $this->db->select('clientes_agentes.*, clientes_sucursales.sucursal, cargos.cargo');
        $this->db->from('clientes_agentes');
        $this->db->join('clientes_sucursales', 'clientes_agentes.idcliente_sucursal = clientes_sucursales.idcliente_sucursal');
        $this->db->join('cargos', 'clientes_agentes.idcargo = cargos.idcargo');
        $this->db->where($where);
        $this->db->order_by('clientes_agentes.idcliente_agente');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/borrar_agente_ajax
     */
    public function update_agente($datos, $where) {
        $this->db->update('clientes_agentes', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Clientes/agregar_agente_ajax
     */
    public function get_where_sucursal($where) {
        $query = $this->db->get_where('clientes_sucursales', $where);

        return $query->row_array();
    }
}

?>
