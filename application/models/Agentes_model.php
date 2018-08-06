<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class agentes_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
  }

  /*
   *  Cotizaciones
   */
  public function gets_where_para_ajax($where, $limit=100)
  {
    $this->db->select('*');
    $this->db->from('empresas_agentes');
    $this->db->like($where);
    $this->db->order_by('agente');
    $this->db->limit($limit);

    $query = $this->db->get();
    return $query->result_array();
  }

}
