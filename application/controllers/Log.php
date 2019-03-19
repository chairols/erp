<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination'
        ));
        $this->load->model(array(
            'log_model',
            'parametros_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listar Logs';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'log/listar';
        
        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];
        
        $where = array();
        if($this->input->get('idusuario') != "") {
            $where['usuarios.idusuario'] = $this->input->get('idusuario');
        }
        if($this->input->get('idtabla') != "") {
            $where['log.tabla'] = $this->input->get('idtabla');
        }
        
        if($this->input->get('idtabla') == '') {
            unset($where['log.tabla']);
        }
        /*
         * inicio paginador
         */
        $total_rows = $this->log_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/log/listar/';
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
        
        $data['registros'] = $this->log_model->gets_where_limit($where, $per_page, $pagina);
        
        $data['usuarios'] = $this->log_model->gets_usuarios();
        $data['tablas'] = $this->log_model->gets_tablas();

        $this->load->view('layout/app', $data);
    }

}

?>