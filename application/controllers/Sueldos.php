<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sueldos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'pagination'
        ));
        $this->load->model(array(
            'sueldos_model',
            'parametros_model',
            'empleados_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar_concepto() {
        $data['title'] = 'Agregar Concepto';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/agregar_concepto.js'
        );
        $data['view'] = 'sueldos/agregar_concepto';

        $this->load->view('layout/app', $data);
    }

    public function agregar_concepto_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idsueldo_concepto', 'Número de Concepto', 'required|integer');
        $this->form_validation->set_rules('sueldo_concepto', 'Concepto', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|decimal');
        $this->form_validation->set_rules('unidad', 'Unidad', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idsueldo_concepto' => $this->input->post('idsueldo_concepto')
            );
            $concepto = $this->sueldos_model->get_where_concepto($where);

            if ($concepto) {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ya existe el concepto ' . $this->input->post('idsueldo_concepto')
                );
                echo json_encode($json);
            } else {
                $set = array(
                    'idsueldo_concepto' => $this->input->post('idsueldo_concepto'),
                    'sueldo_concepto' => $this->input->post('sueldo_concepto'),
                    'tipo' => $this->input->post('tipo'),
                    'cantidad' => $this->input->post('cantidad'),
                    'unidad' => $this->input->post('unidad')
                );

                $idsueldo_concepto = $this->sueldos_model->set_concepto($set);
                if ($idsueldo_concepto) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el concepto ' . $this->input->post('sueldo_concepto')
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo agregar el concepto'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function conceptos_listar($pagina = 0) {
        $data['title'] = 'Listado de Conceptos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'sueldos/conceptos_listar';


        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['sueldos_conceptos.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->sueldos_model->get_cantidad_conceptos_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/sueldos/conceptos_listar/';
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

        $data['conceptos'] = $this->sueldos_model->gets_where_conceptos_limit($where, $per_page, $pagina);

        $this->load->view('layout/app', $data);
    }

    public function conceptos_modificar($idsueldo_concepto = null) {
        if ($idsueldo_concepto == null) {
            redirect('/sueldos/conceptos_listar/', 'refresh');
        }
        $data['title'] = 'Modificar Concepto';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/modificar_concepto.js'
        );
        $data['view'] = 'sueldos/modificar_concepto';

        $where = array(
            'idsueldo_concepto' => $idsueldo_concepto,
            'estado' => 'A'
        );
        $data['sueldo_concepto'] = $this->sueldos_model->get_where_concepto($where);

        $this->load->view('layout/app', $data);
    }

    public function conceptos_modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idsueldo_concepto', 'Número de Concepto', 'required|integer');
        $this->form_validation->set_rules('sueldo_concepto', 'Concepto', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|decimal');
        $this->form_validation->set_rules('unidad', 'Unidad', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'sueldo_concepto' => $this->input->post('sueldo_concepto'),
                'tipo' => $this->input->post('tipo'),
                'cantidad' => $this->input->post('cantidad'),
                'unidad' => $this->input->post('unidad')
            );
            $where = array(
                'idsueldo_concepto' => $this->input->post('idsueldo_concepto')
            );
            $resultado = $this->sueldos_model->update_concepto($datos, $where);

            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el Concepto'
                );
                echo json_encode($json);
            }
        }
    }

    public function agregar() {
        $data['title'] = 'Agregar Recibo de Sueldo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'sueldos/agregar';
        
        $where = array(
            'estado' => 'A'
        );
        $data['empleados'] = $this->empleados_model->gets_where($where);

        $this->load->view('layout/app', $data);
    }
}

?>