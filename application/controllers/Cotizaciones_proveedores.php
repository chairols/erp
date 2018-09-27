<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'parametros_model',
            'cotizaciones_proveedores_model',
            'monedas_model',
            'archivos_model',
            'proveedores_model',
        ));

        $session = $this->session->all_userdata();
        // $this->r_session->check($session);
    }

    public function agregar()
    {

        $data['title'] = 'Agregar Cotización de Proveedor';

        $data['session'] = $this->session->all_userdata();

        $data['menu'] = $this->r_session->get_menu();

        $data['javascript'] = array(

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_agente.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_articulo.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_dropzone.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_trazabilidad.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_email.js'

                                  );

        $data['view'] = 'cotizaciones_proveedores/agregar';

        $data['fecha_vencimiento'] = strtotime( "+10 day", strtotime( date( 'Y-m-d' ) ) );

        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view( 'layout/app', $data );

    }

    public function items( $idcotizacion = null )
    {

        if( $idcotizacion == null )
        {

            redirect('/cotizaciones_proveedores/listar/', 'refresh');

        }

        // $idcotizacion = $this->input->get( 'idcotizacion' );

        $data['title'] = 'Agregar Items a Cotización';

        $data['session'] = $this->session->all_userdata();

        $data['menu'] = $this->r_session->get_menu();

        $data['javascript'] = array(

                                    '/assets/modulos/cotizaciones_proveedores/js/items.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_articulo.js',

                                    '/assets/modulos/cotizaciones_proveedores/js/agregar_trazabilidad.js',

                                  );

        $data['view'] = 'cotizaciones_proveedores/items';

        // $data['fecha_vencimiento'] = strtotime( "+10 day", strtotime( date( 'Y-m-d' ) ) );

        $data[ 'cotizacion' ] = $this->cotizaciones_proveedores_model->get_where( array( 'idcotizacion' => $idcotizacion ) );

        $data[ 'proveedor' ] = $this->proveedores_model->get_where( array( 'idproveedor' => $data[ 'cotizacion' ][ 'idproveedor' ] ) );

        $data[ 'moneda' ] = $this->monedas_model->get_where( array( 'idmoneda' => $data[ 'cotizacion' ][ 'idmoneda' ] ) );

        $this->load->view( 'layout/app', $data );

    }

    public function agregar_ajax()
    {

        // DATOS DE SESION

        $session = $this->session->all_userdata();

        // VALIDACION DE DATOS

        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required');

        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required');

        $this->form_validation->set_rules('fecha_cotizacion', 'Fecha de la Cotizacion', 'required');

        $this->form_validation->set_rules('fecha_vencimiento', 'Fecha de Vencimiento de la Cotizacion', 'required');

        $this->form_validation->set_rules('dias_vencimiento', 'Dias de Vencimiento de la Cotizacion', 'required');

        // OBTENCION DE DATOS

        $datos[ 'idproveedor' ] = $this->input->post( 'idproveedor' );

        $datos[ 'idmoneda' ] = $this->input->post( 'idmoneda' );

        $datos[ 'fecha_cotizacion' ] = implode( '-', array_reverse( explode( '/', $this->input->post( 'fecha_cotizacion' ) ) ) );

        $datos[ 'fecha_vencimiento' ] = implode( '-', array_reverse( explode( '/', $this->input->post( 'fecha_vencimiento' ) ) ) );

        $datos[ 'dias_vencimiento' ] = $this->input->post( 'dias_vencimiento' );

        $datos[ 'fecha_creacion' ] = date( 'Y-m-d' );

        $datos[ 'idcreador' ] = $session[ 'SID' ];

        if( $this->input->post( 'notas' ) )
        {

            $datos[ 'notas' ] = $this->input->post( 'notas' );

        }

        // INSERT Y OBTENCION DE ID

        $idcotizacion = $this->cotizaciones_proveedores_model->set( $datos );

        // OBTENCION DE ID DE ARCHIVOS

        if( $this->input->post( 'archivos' ) )
        {

            $idarchivos = explode( ',', $this->input->post( 'archivos' ) );

            $archivos = array();

            foreach( $idarchivos as $idarchivo )
            {

                $archivos[] = array( 'idarchivo' => $idarchivo, 'idcotizacion' => $idcotizacion );

            }

            // SI EXISTEN ARCHIVOS PARA INSERTAR Y EXISTE LA COTIZACION
            if( !empty( $archivos ) && $idcotizacion > 0 )
            {

                // INSERT DE ARCHIVOS
                $this->cotizaciones_proveedores_model->set_archivos( $archivos );

            }

        }

        $respuesta[ 'idcotizacion' ] = $idcotizacion;

        $respuesta[ 'archivos' ] = $archivos;

        echo json_encode( $respuesta );

    }

    public function nacionales($pagina = 0) {
        $data['title'] = 'Listado de Cotizaciones de Proveedores Nacionales';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones_proveedores/nacionales';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['cotizaciones.estado'] = 'A';
        $where['empresas.internacional'] = 'N';
        $where['cotizaciones.idcliente'] = 0;

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_proveedores_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cotizaciones_proveedores/nacionales/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['total_rows'] = $total_rows;
        /*
         * fin paginador
         */

        $data['cotizaciones'] = $this->cotizaciones_proveedores_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach($data['cotizaciones'] as $key => $value) {
            $where = array(
                'idcotizacion' => $value['idcotizacion']
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_proveedores_model->gets_items_where($where);
        }


        $this->load->view('layout/app', $data);
    }

    public function internacionales($pagina = 0) {
        $data['title'] = 'Listado de Cotizaciones de Proveedores Internacionales';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones_proveedores/internacionales';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['cotizaciones.estado'] = 'A';
        $where['empresas.internacional'] = 'Y';
        $where['cotizaciones.idcliente'] = 0;

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_proveedores_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cotizaciones_proveedores/internacionales/';
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close'] = '</b></a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $data['links'] = $this->pagination->create_links();
        $data['total_rows'] = $total_rows;
        /*
         * fin paginador
         */

        $data['cotizaciones'] = $this->cotizaciones_proveedores_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach($data['cotizaciones'] as $key => $value) {
            $where = array(
                'idcotizacion' => $value['idcotizacion']
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_proveedores_model->gets_items_where($where);
        }


        $this->load->view('layout/app', $data);
    }

    public function subir_archivo()
    {

        $archivo = $this->archivos_model->subir_archivo( 'archivo', 'assets/modulos/cotizaciones_proveedores/archivos/' );

        echo json_encode( $archivo );

    }

    public function eliminar_archivo()
    {

        $datos = $this->input->post();

        if( $this->archivos_model->eliminar_archivo( $datos[ 'idarchivo' ] ) )
        {

            $this->cotizaciones_proveedores_model->eliminar_archivo( $datos[ 'idarchivo' ] );

            echo json_encode( array( 'borrado' => true ) );

        }else{

            echo json_encode( array( 'borrado' => false ) );

        }

    }

}

?>
