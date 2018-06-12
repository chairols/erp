<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function listar($pagina = 0) {
        $data['title'] = 'Listado de Menú';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = '';
        
        
        $per_page = 10;
        $titulo = '';
        if($this->input->get('titulo') !== null) {
            $titulo = $this->input->get('titulo');
        }
        
        /*
         * inicio paginador
         */
        $total_rows = $this->menu_model->get_cantidad_pendientes($titulo);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/menu/listar/';
        $config['total_rows'] = $total_rows['cantidad'];
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
        /*
         * fin paginador
         */
        
        $data['total_rows'] = $total_rows['cantidad'];
        
        $data['menues'] = $this->menu_model->gets_where_titulo_limit($titulo, $pagina, $per_page);
        
        foreach($data['menues'] as $key => $value) {
            $datos = array(
                'idmenu' => $value['padre']
            );
            $data['menues'][$key]['padre'] = $this->menu_model->get_where($datos);
        }
        /*
        $data['mmenu'] = $this->menu_model->gets();
        foreach ($data['mmenu'] as $key => $value) {
            $datos = array(
                'idmenu' => $value['padre']
            );
            $data['mmenu'][$key]['padre'] = $this->menu_model->get_where($datos);
        }*/
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('menu/listar');
        $this->load->view('layout/footer');
    }

}

?>
