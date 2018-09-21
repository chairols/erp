<?php

  defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

  class Archivos_model extends CI_Model
  {

    public function __construct()
    {

        parent::__construct();

    }

    /*
     *  Cotizaciones
     */

    public function gets_ids_para_ajax( $ids )
    {

        $this->db->select( '*' );

        $this->db->from( 'archivos' );

        // $names = array('Frank', 'Todd', 'James');

        $this->db->where_in( 'idarchivo', $ids );

        // $this->db->like( $where );

        $this->db->order_by( 'fecha_creacion' );

        // $this->db->limit( $limit );

        $query = $this->db->get();

        $archivos = $query->result_array();

        echo json_encode( $archivos );

    }

    public function delete( $where )
    {

        $this->db->delete( 'archivos', $where );

    }

    public function update( $datos, $idarchivo )
    {

        $id = array( 'idarchivo' => $idarchivo );

        $this->db->update( 'archivos', $datos, $id );

    }

    public function insert( $datos )
    {

        $this->db->insert( 'archivos', $datos );

        $insert_id = $this->db->insert_id();

        return $insert_id;

    }

    public function subir_archivo( $archivo, $directorio )
    {
        $session                    = $this->session->all_userdata();

        $config[ 'upload_path' ]    = $directorio;

        $config[ 'allowed_types' ]  = '*'; //'gif|jpg|png'
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library( 'upload', $config );

        if( $this->upload->do_upload( $archivo ) )
        {

            $archivo  = $this->upload->data();

            $tipo     = substr( $archivo[ 'file_ext' ], 1 );

            $url      = '/' . $directorio . $archivo[ 'raw_name' ] . $archivo[ 'file_ext' ];

            $archivo[ 'url' ] = $url;

            $datos    = array(

                          'nombre' => $archivo[ 'raw_name' ],

                          'url' => $archivo[ 'url' ],

                          'tipo' => $tipo,

                          'fecha_creacion' => 'NOW()',

                          'creado_por' => $session[ 'SID' ]

                        );

            $archivo[ 'id' ] = $this->insert( $datos );

            return $archivo;

        }else{

            echo $this->upload->display_errors();
            return false;

        }

    }

    public function eliminar_archivo( $idarchivo )
    {

        $this->db->select( '*' );

        $this->db->from( 'archivos' );

        $this->db->where_in( 'idarchivo', array( $idarchivo ) );

        $this->db->order_by( 'fecha_creacion' );

        $query = $this->db->get();

        $archivos = $query->result_array();

        $archivo = $archivos[ 0 ];

        $this->db->delete( 'archivos', array( 'idarchivo' => $idarchivo ) );

        if( file_exists( substr( $archivo[ 'url' ], 1 ) ) )
        {

            unlink( substr( $archivo[ 'url' ], 1 ) );

            return true;

        }

        return false;

    }

 }
