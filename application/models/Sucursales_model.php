<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sucursales_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
  }

  /*
   *  Cotizaciones
   */
  public function gets_where_para_ajax($where, $limit)
  {
    $this->db->select('idsucursal as id, nombre as text');
    $this->db->from('sucursales');
    $this->db->like($where);
    $this->db->order_by('sucursal');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

}
