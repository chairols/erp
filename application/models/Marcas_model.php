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
     *  Artículos/gets_articulos_ajax
     * 
     *  Importaciones/modificar_item
     */
    public function get_where($where) {
        $query = $this->db->get_where('marcas', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Marcas/gets_marcas_ajax
     */
    public function gets_where($where)
    {
      $this->db->select('idmarca as id, marca as text');
      $this->db->from('marcas');
      $this->db->like($where);
      $this->db->order_by('marca');

      $query = $this->db->get();
      return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     */
    public function gets() {
      $this->db->select('*');
      $this->db->from('marcas');
      $this->db->order_by('marca');

      $query = $this->db->get();
      return $query->result_array();
    }
}

?>
