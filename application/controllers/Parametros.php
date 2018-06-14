<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation',
            'table'
        ));
        $this->load->model(array(
            'parametros_model',
            'log_model'
        ));
        
        $session = $this->session->all_userdata();
        //$this->r_session->check($session);
    }

    function usuario() {
        $data['title'] = 'Listado de Empresas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('parametros/usuario');
        $this->load->view('layout/footer');
    }
    
    public function agregar() {
        $data['title'] = 'Agregar Parámetro';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/parametros/js/agregar.js'
        );
        
        $data['tipos'] = $this->parametros_model->gets_tipos_parametros();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('parametros/agregar');
        $this->load->view('layout/footer');
    }

    
    public function agregar_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('parametro', 'Parámetro', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo de Parámetro', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'parametro' => $this->input->post('parametro'),
                'idparametro_tipo' => $this->input->post('tipo'),
                'estado' => 'A'
            );
            $resultado = $this->parametros_model->get_where($datos);
            
            /*
             * Compruebo si ya existe el link
             */
            if ($resultado) {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>El Parámetro <strong>' . $resultado['parametro'] . '</strong> ya existe. </p>'
                );
                echo json_encode($json);
            } else {
                $datos = array(
                    'parametro' => $this->input->post('parametro'),
                    'idparametro_tipo' => $this->input->post('tipo')
                );
                
                $id = $this->parametros_model->set($datos);
                
                /*
                 * Compruebo si fue exitoso y agrego al log
                 */
                if ($id) {
                    $log = array(
                        'tabla' => 'parametros',
                        'idtabla' => $id,
                        'texto' => $this->table->generate(array($datos)),
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
                        'data' => '<p>No se pudo agregar el menú.</p>'
                    );
                    echo json_encode($json);
                }
            }
            
        }
    }
}

?>
