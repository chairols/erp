<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
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

        $data['archivos'] = opendir("." . $ruta_upload['valor_sistema']);

        $this->load->view('archivos/listar_archivos', $data);
    }

    public function borrar_archivo_ajax() {

        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        unlink("." . $ruta_upload['valor_sistema'] . $this->input->post('archivo'));
    }

    public function agregar_ajax() {
        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        $config['upload_path'] = "." . $ruta_upload['valor_sistema'];
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('archivo')) {
            $error = array('error' => $this->upload->display_errors());
            
            show_404();
        } else {
            $data = $this->upload->data();
            /* $datos = array(
              'imagen' => '/upload/usuarios/perfil/' . $data['file_name']
              );
              $this->usuarios_model->update($datos, $session['SID']); */
            var_dump($data);
        }
    }

    public function extraer() {
        $this->form_validation->set_rules('archivo', 'Archivo', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'identificador' => 'ruta_upload',
                'estado' => 'A'
            );
            $ruta_upload = $this->parametros_model->get_where($where);
            
            $ruta_archivo = getcwd().$ruta_upload['valor_sistema'].$this->input->post('archivo');
            
            $res = shell_exec("unzip ".$ruta_archivo);
            
            var_dump($res);
        }
        
        
        
    }
}

?>
