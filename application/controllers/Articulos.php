<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination'
        ));
        $this->load->model(array(
            'parametros_model',
            'articulos_model',
            'marcas_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Artículos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];
        $data['per_page'] = $per_page;

        $where = $this->input->get();
        $where['articulos.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->articulos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/articulos/listar/';
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
        $data['base_url'] = $config['base_url'];
        /*
         * fin paginador
         */

        $data['articulos'] = $this->articulos_model->gets_where_limit($where, $per_page, $pagina);

        $data['view'] = 'articulos/listar';
        $this->load->view('layout/app', $data);
    }

    public function gets_articulos_ajax() {
        $where = $this->input->post();
        $articulos = $this->articulos_model->gets_where_para_ajax($where, 255);

        foreach($articulos as $key => $value) {
            $articulos[$key]['text'] = $value['text']." - ";
            $where = array(
                'idmarca' => $value['idmarca']
            );
            $resultado = $this->marcas_model->get_where($where);

            $articulos[$key]['text'] .= $resultado['marca'];
        }
        echo json_encode($articulos);
    }

    public function borrar_ajax()
    {
      $where = $this->input->post();
      $this->articulos_model->update(array('estado'=>'I'),$where['idarticulo']);
    }

    public function activar_ajax()
    {
      $where = $this->input->post();
      $this->articulos_model->update(array('estado'=>'A'),$where['idarticulo']);
    }

}

?>
