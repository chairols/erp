<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'cargos_model',
            'parametros_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Cargos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'cargos/listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->cargos_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/cargos/listar/';
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

        $data['cargos'] = $this->cargos_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Cargo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cargos/js/agregar.js'
        );
        $data['view'] = 'cargos/agregar';

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cargo', 'Cargo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'cargo' => $this->input->post('cargo')
            );

            $cargo = $this->cargos_model->get_where($where);

            if ($cargo) {  // Si el cargo ya existe
                $json = array(
                    'status' => 'error',
                    'data' => 'El cargo ' . $this->input->post('cargo') . ' ya existe'
                );
                echo json_encode($json);
            } else {  // Si no existe el cargo
                $set = array(
                    'cargo' => $this->input->post('cargo'),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );

                $resultado = $this->cargos_model->set($set);

                if ($resultado) { // Si se agregó correctamente
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el cargo ' . $this->input->post('cargo')
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'Ocurrió un error inesperado'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

}

?>