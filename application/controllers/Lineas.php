<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas extends CI_Controller {

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
            'lineas_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Líneas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->lineas_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/lineas/listar/';
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

        $data['lineas'] = $this->lineas_model->gets_where_limit($where, $per_page, $pagina);

        $data['view'] = 'lineas/listar';
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Línea';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/lineas/js/agregar.js'
        );

        $data['view'] = 'lineas/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('linea', 'Línea', 'required');
        $this->form_validation->set_rules('nombre_corto', 'Nombre Corto', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'linea' => $this->input->post('linea')
            );
            $resultado = $this->lineas_model->get_where($where);

            if ($resultado) { // Si ya existe la moneda
                $json = array(
                    'status' => 'error',
                    'data' => 'La línea <strong>' . $this->input->post('linea') . '</strong> ya existe.'
                );
                echo json_encode($json);
            } else {  // Si no existe la moneda, la creo
                $datos = array(
                    'linea' => $this->input->post('linea'),
                    'nombre_corto' => $this->input->post('nombre_corto'),
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s")
                );

                $id = $this->lineas_model->set($datos);

                if ($id) {
                    $log = array(
                        'tabla' => 'lineas',
                        'idtabla' => $id,
                        'texto' => 'Se agregó la línea: ' . $this->input->post('linea') .
                        '<br>Nombre Corto: ' . $this->input->post('nombre_corto'),
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );

                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => '<p>No se pudo agregar la línea.</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }
}

?>
