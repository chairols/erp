<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Monedas extends CI_Controller {

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
            'monedas_model',
            'log_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function listar($pagina = 0) {
        $data['title'] = 'Listado de Monedas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['monedas.estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->monedas_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/monedas/listar/';
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

        $data['monedas'] = $this->monedas_model->gets_where_limit($where, $per_page, $pagina);

        $data['view'] = 'monedas/listar';
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Moneda';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/monedas/js/agregar.js'
        );

        $data['view'] = 'monedas/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('moneda', 'Moneda', 'required');
        $this->form_validation->set_rules('simbolo', 'Símbolo', 'required');
        $this->form_validation->set_rules('codigo_afip', 'Código AFIP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'moneda' => $this->input->post('moneda')
            );
            $resultado = $this->monedas_model->get_where($where);

            if ($resultado) { // Si ya existe la moneda
                $json = array(
                    'status' => 'error',
                    'data' => 'La moneda <strong>' . $this->input->post('moneda') . '</strong> ya existe.'
                );
                echo json_encode($json);
            } else {  // Si no existe la moneda, la creo
                $datos = array(
                    'moneda' => $this->input->post('moneda'),
                    'simbolo' => $this->input->post('simbolo'),
                    'codigo_afip' => $this->input->post('codigo_afip'),
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s")
                );

                $id = $this->monedas_model->set($datos);

                if ($id) {
                    $log = array(
                        'tabla' => 'monedas',
                        'idtabla' => $id,
                        'texto' => 'Se agregó la moneda: ' . $this->input->post('moneda') .
                        '<br>Símbolo: ' . $this->input->post('simbolo') .
                        '<br>Código de AFIP: ' . $this->input->post('simbolo'),
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
                        'data' => '<p>No se pudo agregar la moneda.</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function modificar($idmoneda = null) {
        $data['title'] = 'Modificar Moneda';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/monedas/js/modificar.js'
        );

        if ($idmoneda == null) {
            redirect('/monedas/listar/', 'refresh');
        }

        $datos = array(
            'idmoneda' => $idmoneda
        );
        $data['moneda'] = $this->monedas_model->get_where($datos);

        $data['view'] = 'monedas/modificar';
        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idmoneda', 'Identificador de Moneda', 'required|integer');
        $this->form_validation->set_rules('moneda', 'Moneda', 'required');
        $this->form_validation->set_rules('simbolo', 'Símbolo', 'required');
        $this->form_validation->set_rules('codigo_afip', 'Código AFIP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'moneda' => $this->input->post('moneda'),
                'simbolo' => $this->input->post('simbolo'),
                'codigo_afip' => $this->input->post('codigo_afip'),
                'actualizado_por' => $session['SID'],
                'fecha_modificacion' => date("Y-m-d H:i:s")
            );

            $afectado = $this->monedas_model->update($datos, $this->input->post('idmoneda'));

            if ($afectado) {
                $log = array(
                    'tabla' => 'monedas',
                    'idtabla' => $this->input->post('idmoneda'),
                    'texto' => 'Se modificó la moneda: ' . $this->input->post('moneda') .
                    '<br>Símbolo: ' . $this->input->post('simbolo') .
                    '<br>Código de AFIP: ' . $this->input->post('simbolo'),
                    'idusuario' => $session['SID'],
                    'tipo' => 'edit'
                );

                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>No se pudo actualizar la moneda.</p>'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function historial() {
        $data['title'] = 'Histórico de Monedas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            'https://www.gstatic.com/charts/loader.js',
            '/assets/modulos/monedas/js/historial.js'
        );
        $data['view'] = 'monedas/historial';
        
        
        $data['historial'] = array();
        
        $this->form_validation->set_rules('moneda', 'Moneda', 'required');
        $this->form_validation->set_rules('desde', 'Fecha Desde', 'required');
        $this->form_validation->set_rules('hasta', 'Fecha Hasta', 'required');
        
        if($this->form_validation->run() == FALSE) {

        } else {
            $data['historial'] = $this->monedas_model->gets_historial($this->input->post('moneda'), $this->formatear_fecha($this->input->post('desde')), $this->formatear_fecha($this->input->post('hasta')));
        }
        
        $data['monedas'] = $this->monedas_model->gets();
        
        $this->load->view('layout/app', $data);
    }
    
    public function historial_ajax_grafico() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('moneda', 'Moneda', 'required');
        $this->form_validation->set_rules('desde', 'Fecha Desde', 'required');
        $this->form_validation->set_rules('hasta', 'Fecha Hasta', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idmoneda' => $this->input->post('moneda')
            );
            $data['moneda'] = $this->monedas_model->get_where($datos);
            $data['historial'] = $this->monedas_model->gets_historial($this->input->post('moneda'), $this->formatear_fecha($this->input->post('desde')), $this->formatear_fecha($this->input->post('hasta')));
            
            
            $this->load->view('monedas/historial_ajax_grafico', $data);
        }
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
}

?>
