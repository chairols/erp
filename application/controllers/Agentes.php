<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agentes extends CI_Controller
{

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
          'agentes_model',
      ));

      $session = $this->session->all_userdata();
      // $this->r_session->check($session);
    }

    public function gets_agentes_tarjetas_ajax() {
      $where = $this->input->post();
      $data['agentes'] = $this->agentes_model->gets_where_para_ajax($where);
      $data['idsucursal'] = $_POST['idsucursal'];
      $data['idempresa'] = $_POST['idempresa'];
      // $this->load->view('layout/app', $data);
      $this->load->view('agentes/gets_agentes_tarjetas_ajax', $data);
      //
      // echo json_encode($json['html']);
    }

    // public function borrar_ajax()
    // {
    //
    //     $where = $this->input->post();
    //
    //     $this->agentes_model->delete( $where );
    //
    // }

    public function borrar_ajax()
    {

        $where = $this->input->post();

        $this->agentes_model->update( array( 'estado' => 'I' ), $where[ 'idagente' ] );

    }

    public function crear_ajax()
    {

        echo $this->agentes_model->insert( $this->input->post() );

    }

}
