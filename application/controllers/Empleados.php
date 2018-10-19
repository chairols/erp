<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
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

    public function get_proximo_legajo_input_ajax() {
        
        $where = array();
        $data['legajo'] = $this->empleados_model->get_max_legajo_where($where);
        
        if($data['legajo']['idempleado']) {
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
}

?>