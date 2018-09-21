<?php

  defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

  class Archivos extends CI_Controller
  {

      public function __construct()
      {

          parent::__construct();

          $this->load->helper( array( 'url', 'html', 'form' ) );

          $this->load->library( array( 'session', 'r_session', 'pagination' ) );

          $this->load->model( array( 'parametros_model', 'archivos_model' ) );

          $session = $this->session->all_userdata();
          // $this->r_session->check($session);
      }

      public function gets_archivos_ajax( $ids )
      {

          return $this->archivos_model->gets_ids_para_ajax( $ids );

          // echo json_encode( $archivos );

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

          $this->archivos_model->update( array( 'estado' => 'I' ), $where[ 'idagente' ] );

      }

      public function crear_ajax()
      {

          echo $this->archivos_model->insert( $this->input->post() );

      }

      public function subir_archivo()
      {

          $archivo = $this->archivos_model->subir_archivo( 'archivo', 'assets/modulos/archivos/' );

          echo json_encode( $archivo );

      }

      public function eliminar_archivo()
      {

          $datos = $this->input->post();

          if( $this->archivos_model->eliminar_archivo( $datos[ 'idarchivo' ] ) )
          {

              echo json_encode( array( 'borrado' => true ) );

          }else{

              echo json_encode( array( 'borrado' => false ) );

          }

      }

  }
