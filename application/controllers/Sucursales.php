<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->library(array(
        'session',
        'r_session',
        'pagination'
    ));
    $this->load->model(array(
        'parametros_model',
        'empresas_model',
        'sucursales_model',
    ));

    $session = $this->session->all_userdata();
    // $this->r_session->check($session);
  }

  public function gets_sucusales_ajax() {
    $where = $this->input->post();
    $sucursales = $this->sucursales_model->gets_where_para_ajax($where, 100);
    // foreach($sucursales as $key => $value) {
    //     $sucursales[$key]['text'] = $value['text']." - ";
    //     $where = array(
    //         'idmarca' => $value['idmarca']
    //     );
    //     $resultado = $this->marcas_model->get_where($where);
    //
    //     $sucursales[$key]['text'] .= $resultado['marca'];
    // }
    echo json_encode($sucursales);
  }

}
