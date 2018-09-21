<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination'
        ));
        $this->load->model(array(
            'parametros_model',
            'cotizaciones_model',
            'monedas_model',
            'archivos_model',
        ));

        $session = $this->session->all_userdata();
        // $this->r_session->check($session);
    }

    public function agregar_proveedor() {
        $data['title'] = 'Agregar Cotización de Proveedor';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
                                    '/assets/modulos/cotizaciones/js/agregar.js',
                                    '/assets/modulos/cotizaciones/js/agregar_agente.js',
                                    '/assets/modulos/cotizaciones/js/agregar_articulo.js',
                                    '/assets/modulos/cotizaciones/js/agregar_dropzone.js',
                                    '/assets/modulos/cotizaciones/js/agregar_trazabilidad.js',
                                    '/assets/modulos/cotizaciones/js/agregar_email.js'
                                  );
        $data['view'] =              'cotizaciones/agregar_proveedor';

        $data['fecha_vencimiento'] = strtotime("+10 day", strtotime(date('Y-m-d')));
        $data['monedas'] = $this->monedas_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function proveedores_nacionales($pagina = 0) {
        $data['title'] = 'Listado de Cotizaciones de Proveedores Nacionales';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones/proveedores_nacionales';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['cotizaciones.estado'] = 'A';
        $where['empresas.internacional'] = 'N';
        $where['cotizaciones.idcliente'] = 0;

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cotizaciones/proveedores_nacionales/';
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

        $data['cotizaciones'] = $this->cotizaciones_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach($data['cotizaciones'] as $key => $value) {
            $where = array(
                'idcotizacion' => $value['idcotizacion']
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_model->gets_items_where($where);
        }


        $this->load->view('layout/app', $data);
    }

    public function proveedores_internacionales($pagina = 0) {
        $data['title'] = 'Listado de Cotizaciones de Proveedores Internacionales';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cotizaciones/proveedores_internacionales';

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['cotizaciones.estado'] = 'A';
        $where['empresas.internacional'] = 'Y';
        $where['cotizaciones.idcliente'] = 0;

        /*
         * inicio paginador
         */
        $total_rows = $this->cotizaciones_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cotizaciones/proveedores_internacionales/';
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

        $data['cotizaciones'] = $this->cotizaciones_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach($data['cotizaciones'] as $key => $value) {
            $where = array(
                'idcotizacion' => $value['idcotizacion']
            );
            $data['cotizaciones'][$key]['items'] = $this->cotizaciones_model->gets_items_where($where);
        }


        $this->load->view('layout/app', $data);
    }

    public function subir_archivo()
    {

        $archivo = $this->archivos_model->subir_archivo( 'archivo', 'assets/modulos/cotizaciones/archivos/' );

        echo json_encode( $archivo );

    }

    public function eliminar_archivo()
    {

        $datos = $this->input->post();

        if( $this->archivos_model->eliminar_archivo( $datos[ 'idarchivo' ] ) )
        {

            $this->cotizaciones_model->eliminar_archivo( $datos[ 'idarchivo' ] );

            echo json_encode( array( 'borrado' => true ) );

        }else{

            echo json_encode( array( 'borrado' => false ) );

        }

    }

}

?>