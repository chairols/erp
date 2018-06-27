<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'importaciones_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }
    
    public function agregar() {
        $data['title'] = 'Agregar Importación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'importaciones/agregar';
        
        $this->form_validation->set_rules('empresa', 'Empresa', 'required');
        $this->form_validation->set_rules('fecha_pedido', 'Fecha de Pedido', 'required');
        
        if($this->form_validation->run() == FALSE) {
            
        } else {
            $datos = array(
                'idproveedor' => $this->input->post('empresa'),
                'fecha_pedido' => $this->formatear_fecha($this->input->post('fecha_pedido')),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $data['session']['SID']
            );
            
            $id = $this->importaciones_model->set($datos);
            
            if($id) {
                redirect('/importaciones/agregar_items/'.$id.'/', 'refresh');
            }
        }
        
        $this->load->view('layout/app', $data);
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
