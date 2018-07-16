<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_genericos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination'
        ));
        $this->load->model(array(
            'parametros_model',
            'articulos_genericos_model',
            'articulos_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function finalizados($pagina = 0) {
        $data['title'] = 'Listado de Artículos Genéricos Finalizados';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado_relacion'] = 'F';

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_genericos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos_genericos/finalizados/';
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

        $data['articulos'] = $this->articulos_genericos_model->get_cantidad_where_limit($where, $per_page, $pagina);
        foreach($data['articulos'] as $key => $value) {
            $data['articulos'][$key]['stock'] = $this->articulos_model->get_sum_stock_por_idarticulo_generico($value['idarticulo_generico']);
            $datos = array(
                'articulos.idarticulo_generico' => $value['idarticulo_generico'],
                'articulos.estado' => 'A'
            );
            $data['articulos'][$key]['articulos'] = $this->articulos_model->gets_where($datos);
        }

        $data['view'] = 'articulos_genericos/finalizados';
        $this->load->view('layout/app', $data);
    }
}

?>