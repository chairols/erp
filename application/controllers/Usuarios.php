<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'form_validation',
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'usuarios_model'
        ));
        $this->load->helper(array(
            'url'
        ));
    }

    public function login() {

        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');


        if ($this->form_validation->run() == FALSE) {

        } else {
            $usuario = $this->usuarios_model->get_usuario($this->input->post('usuario'), sha1($this->input->post('password')));
            if (!empty($usuario)) {
                $perfil = $this->usuarios_model->get_perfil($usuario['idusuario']);
                
                $datos = array(
                    'SID' => $usuario['idusuario'],
                    'usuario' => $usuario['usuario'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'correo' => $usuario['email'],
                    'perfil' => $perfil['idperfil']
                );
                $this->session->set_userdata($datos);
                
                $datos = array(
                    'ultimo_acceso' => date("Y-m-d H:i:s")
                );
                $this->usuarios_model->update($datos, $usuario['idusuario']);
                
                redirect('/dashboard/', 'refresh');
            }
        }

        $data['title'] = "Login de Usuarios";
        $session = $this->session->all_userdata();
        if (!empty($session['SID'])) {
            redirect('/dashboard/', 'refresh');
        } else {
            $this->load->view('usuarios/login', $data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/usuarios/login/', 'refresh');
    }

    public function listar() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
        $data['title'] = 'Listar Usuarios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = '';
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('usuarios/listar');
        $this->load->view('layout/footer');
    }
}