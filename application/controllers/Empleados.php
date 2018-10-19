<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'calificaciones_model',
            'usuarios_model',
            'empleados_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Empleado';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/empleados/js/agregar.js'
        );
        $data['view'] = 'empleados/agregar';

        $where = array(
            'padre' => 0,
            'estado' => 'A'
        );
        $data['calificaciones'] = $this->calificaciones_model->gets_where($where);

        $where = array(
            'estado' => 'A'
        );
        $data['usuarios'] = $this->usuarios_model->gets_where($where);

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('legajo', 'Legajo', 'required|integer');
        $this->form_validation->set_rules('fecha_ingreso', 'Fecha de Ingreso', 'required');
        $this->form_validation->set_rules('idcalificacion', 'Calificacion', 'required|integer');
        $this->form_validation->set_rules('idusuario', 'Usuario de Sistema', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idempleado' => $this->input->post('legajo')
            );
            $resultado = $this->empleados_model->get_where($where);
            if ($resultado) {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ya existe el legajo ' . $this->input->post('legajo')
                );
                echo json_encode($json);
            } else {
                $set = array(
                    'idempleado' => $this->input->post('legajo'),
                    'nombre' => $this->input->post('nombre'),
                    'apellido' => $this->input->post('apellido'),
                    'fecha_ingreso' => $this->formatear_fecha($this->input->post('fecha_ingreso')),
                    'idcalificacion' => $this->input->post('idcalificacion'),
                    'idusuario' => $this->input->post('idusuario')
                );
                $resultado = $this->empleados_model->set($set);
                if ($resultado) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó correctamente'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo crear el Empleado'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function get_proximo_legajo_input_ajax() {

        $where = array();
        $data['legajo'] = $this->empleados_model->get_max_legajo_where($where);

        if ($data['legajo']['idempleado']) {
            $data['legajo'] = $data['legajo']['idempleado'] + 1;
        } else {
            $data['legajo'] = 1;
        }

        $this->load->view('empleados/get_proximo_legajo_input_ajax', $data);
    }

    public function gets_options_select() {
        $where = array(
            'padre' => $this->input->post('idpadre'),
            'estado' => 'A'
        );
        $data['id'] = $this->input->post('id');
        $data['calificaciones'] = $this->calificaciones_model->gets_where($where);

        $this->load->view('empleados/gets_options_select', $data);
    }

    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 6, 4);
        $aux .= '-';
        $aux .= substr($fecha, 3, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }

    private function formatear_fecha_para_mostrar($fecha) {
        $aux = '';
        $aux .= substr($fecha, 8, 2);
        $aux .= '/';
        $aux .= substr($fecha, 5, 2);
        $aux .= '/';
        $aux .= substr($fecha, 0, 4);

        return $aux;
    }

}

?>