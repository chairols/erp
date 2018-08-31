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

  public function delete( $where )
  {

      $this->db->delete( 'empresas_agentes', $where );

  }

  public function update( $datos, $idagente )
  {

      $id = array( 'idagente' => $idagente);

      $this->db->update( 'empresas_agentes', $datos, $id );

  }

  public function insert( $datos )
  {

      $this->db->insert( 'empresas_agentes', $datos );

      $insert_id = $this->db->insert_id();

      return $insert_id;

  }

}
