<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'provincias_model',
            'tipos_responsables_model',
            'transportes_model',
            'parametros_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Transporte';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/vendors/timepicker/bootstrap-timepicker.min.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/timepicker/bootstrap-timepicker.min.js',
            '/assets/modulos/transportes/js/agregar.js'
        );
        $data['view'] = 'transportes/agregar';

        $data['provincias'] = $this->provincias_model->gets();
        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('transporte', 'Transporte', 'required');
        $this->form_validation->set_rules('direccion', 'Dirección', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'transporte' => $this->input->post('transporte'),
                'direccion' => $this->input->post('direccion'),
                'codigo_postal' => $this->input->post('codigo_postal'),
                'localidad' => $this->input->post('localidad'),
                'idprovincia' => $this->input->post('idprovincia'),
                'telefono' => $this->input->post('telefono'),
                'idtipo_responsable' => $this->input->post('idtipo_responsable'),
                'cuit' => str_replace("-", "", $this->input->post('cuit')),
                'horario_desde' => $this->input->post('horario_desde'),
                'horario_hasta' => $this->input->post('horario_hasta'),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->transportes_model->set($set);
            if ($id) {
                $log = array(
                    'tabla' => 'transportes',
                    'idtabla' => $id,
                    'texto' => "<h2><strong>Se cre&oacute; el transporte: " . $this->input->post('transporte') . "</strong></h2>

<p><strong>Dirección: </strong>" . $this->input->post('direccion') . "<br />
<strong>Código Postal: </strong>" . $this->input->post('codigo_postal') . "<br />
<strong>Localidad: </strong>" . $this->input->post('localidad') . "<br />
<strong>ID Provincia: </strong>" . $this->input->post('provincia') . "<br />
<strong>Teléfono: </strong>" . $this->input->post('telefono') . "<br />
<strong>ID Tipo de Resposabilidad: </strong>" . $this->input->post('idtipo_responsable') . "<br />
<strong>C&oacute;digo Postal: </strong>" . $set['codigopostal'] . "<br />
<strong>CUIT: </strong>" . $this->input->post('cuit') . "<br />
<strong>Horario Desde: </strong>" . $this->input->post('horario_desde') . "<br />
<strong>Horario Hasta: </strong>" . $this->input->post('horario_hasta') . "<br />
<strong>Observaciones: </strong>" . $this->input->post('observaciones') . "<br /></p>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'add'
                );
                $this->log_model->set($log);
                
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el transporte correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el transporte'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Transportes';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'transportes/listar';
        
        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['transportes.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->transportes_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/transportes/listar/';
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

        $data['transportes'] = $this->transportes_model->gets_where_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

}

?>