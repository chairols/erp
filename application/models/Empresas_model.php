<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    /*
     *  Empresas/todas
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Empresas/todas
     */
    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->join('empresas_tipos', 'empresas.idempresa_tipo = empresas_tipos.idempresa_tipo');
        $this->db->like($where);
        $this->db->order_by('empresa');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
    */
    public function gets_where($where)
    {
      $this->db->select('idempresa as id, empresa as text');
      $this->db->from('empresas');
      $this->db->like($where);
      $this->db->order_by('empresa');

      $query = $this->db->get();
      return $query->result_array();
    }
    
    
    /*
     *  Importaciones/agregar_items
     * 
     *  Listas_de_precios/asociar_generico
     */
    public function get_where($where) {
        $query = $this->db->get_where('empresas', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importar/clientes
     */
    public function update($datos, $where) {
        $this->db->update('empresas', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Importar/clientes
     */
    public function set($datos) {
        $this->db->insert('empresas', $datos);
        return $this->db->insert_id();
    }
}

?>
