<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'parametros_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function administrar() {
        $data['title'] = 'Administrar Archivos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/archivos/js/administrar.js'
        );
        $data['view'] = 'archivos/administrar';
        
        $data['archivos'] = opendir("./upload/importar/");
        
        $this->load->view('layout/app', $data);
    }
    
    public function listar_archivos() {
        
        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);
        
        $data['archivos'] = opendir(".".$ruta_upload['valor_sistema']);
        
        $this->load->view('archivos/listar_archivos', $data);
        
    }
    
    public function borrar_archivo_ajax() {
        
        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);
        
        unlink(".".$ruta_upload['valor_sistema'].$this->input->post('archivo'));
        
    }
}

?>
