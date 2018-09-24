<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'form_validation',
            'session',
            'r_session',
            'pagination'
        ));
        $this->load->model(array(
            'usuarios_model',
            'perfiles_model',
            'log_model'
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
                    'imagen' => $usuario['imagen'],
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

    public function listar($pagina = 0) {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        $data['title'] = 'Listar Usuarios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();

        $per_page = 10;
        $codigo = '';
        if ($this->input->get('codigo') !== null) {
            $codigo = $this->input->get('codigo');
        }
        /*
         * inicio paginador
         */
        $total_rows = $this->usuarios_model->get_cantidad($codigo, 'A');
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/usuarios/listar/';
        $config['total_rows'] = $total_rows['cantidad'];
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
        $data['total_rows'] = $total_rows['cantidad'];
        /*
         * fin paginador
         */

        $data['usuarios'] = $this->usuarios_model->gets_limit($codigo, $pagina, $config['per_page'], 'A');

        $data['view'] = 'usuarios/listar';
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
        $data['title'] = 'Agregar Usuario';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/usuarios/js/agregar.js'
        );
        $data['view'] = 'usuarios/agregar';

        $data['perfiles'] = $this->perfiles_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repetir Contraseña', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('idperfil', 'Perfil', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'usuario' => $this->input->post('usuario')
            );
            $resultado = $this->usuarios_model->get_where($datos);

            if ($resultado) {  //  Si el usuario ya existe
                $json = array(
                    'status' => 'error',
                    'data' => 'El usuario <strong>' . $this->input->post('usuario') . '</strong> ya existe.'
                );
                echo json_encode($json);
            } else {
                $datos = $this->input->post();
                unset($datos['password2']);
                unset($datos['idperfil']);
                $datos['password'] = sha1($datos['password']);
                $datos['estado'] = 'A';
                $datos['fecha_creacion'] = date("Y-m-d H:i:s");
                $datos['idcreador'] = $session['SID'];

                $id = $this->usuarios_model->set($datos);

                /*
                 * Compruebo si fue exitoso y agrego al log
                 */
                if ($id) {
                    $dat = array(
                        'idusuario' => $id,
                        'idperfil' => $this->input->post('idperfil')
                    );
                    $this->usuarios_model->set_perfil($dat);

                    $log = array(
                        'tabla' => 'usuarios',
                        'idtabla' => $id,
                        'texto' => 'Se agregó el usuario: ' . $datos['usuario'] . '<br>' .
                        'Password: ' . $this->input->post('password') . '<br>' .
                        'Nombre: ' . $datos['nombre'] . '<br>' .
                        'Apellido: ' . $datos['apellido'] . '<br>' .
                        'Email: ' . $datos['email'] . '<br>' .
                        'Teléfono: ' . $datos['telefono'] . '<br>' .
                        'ID de Perfil: ' . $this->input->post('idperfil'),
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
                        'data' => '<p>No se pudo agregar el usuario.</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function perfil() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
        $data['title'] = 'Mi Perfil';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/usuarios/js/perfil.js'
        );

        $datos = array(
            'idusuario' => $session['SID']
        );
        $data['perfil'] = $this->usuarios_model->get_where($datos);

        $data['view'] = 'usuarios/perfil';
        $this->load->view('layout/app', $data);
    }

    public function perfil_ajax() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono')
            );

            $password = $this->input->post('password');
            $nuevopass = $this->input->post('nuevopass');
            $nuevopassconf = $this->input->post('nuevopassconf');

            if (strlen($nuevopass) > 0 && $nuevopass == $nuevopassconf) {
                $usuario = $this->usuarios_model->get_usuario($this->input->post('usuario'), sha1($this->input->post('password')));
                $perfil = $this->usuarios_model->get_perfil($usuario['idusuario']);
                if ($usuario) {
                    $datos['password'] = sha1($nuevopass);

                    $this->usuarios_model->update($datos, $session['SID']);

                    $json = array(
                        'status' => 'ok'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'La contraseña ingresada es incorrecta'
                    );
                    echo json_encode($json);
                }
            } else {
                $this->usuarios_model->update($datos, $session['SID']);

                $usuario = $this->usuarios_model->get_usuario($this->input->post('usuario'), sha1($this->input->post('password')));
                $perfil = $this->usuarios_model->get_perfil($usuario['idusuario']);

                $json = array(
                    'status' => 'ok'
                );
                echo json_encode($json);
            }
        }
    }

    public function actualizar_foto() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        $config['upload_path'] = './upload/usuarios/perfil/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            //var_dump($error);
            show_404();
        } else {
            $data = $this->upload->data();
            $datos = array(
                'imagen' => '/upload/usuarios/perfil/' . $data['file_name']
            );
            $this->usuarios_model->update($datos, $session['SID']);
        }
    }

    public function modificar($idusuario = null) {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
        if ($idusuario == null) {
            redirect('/usuarios/listar/', 'refresh');
        }
        $data['title'] = 'Modificar Usuario';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/usuarios/js/modificar.js'
        );
        $data['view'] = 'usuarios/modificar';

        $where = array(
            'idusuario' => $idusuario
        );
        $data['usuario'] = $this->usuarios_model->get_where($where);

        $data['perfil_usuario'] = $this->usuarios_model->get_perfil($data['usuario']['idusuario']);

        $data['perfiles'] = $this->perfiles_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        $this->form_validation->set_rules('idusuario', 'ID del Usuario', 'required|integer');
        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        if (strlen($this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Contraseña', 'required');
        }
        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('idperfil', 'Perfil', 'required|integer');
        
        
        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'usuario' => $this->input->post('usuario'),
                'nombre' => $this->input->post('nombre'),
                'apellido' => $this->input->post('apellido'),
                'email' => $this->input->post('email')
            );
            if (strlen($this->input->post('password'))) {
                $datos['password'] = sha1($this->input->post('password'));
            }
            $flag = 0;
            $resultado = $this->usuarios_model->update($datos, $this->input->post('idusuario'));
            
            if ($resultado) {
                $flag = 1;
            }

            $datos = array(
                'idperfil' => $this->input->post('idperfil')
            );
            $where = array(
                'idusuario' => $this->input->post('idusuario')
            );
            $resultado = $this->usuarios_model->update_perfil($datos, $where);
            
            if ($resultado) {
                $flag = 1;
            }

            if ($flag) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'El perfil se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el perfil'
                );
                echo json_encode($json);
            }
        }
    }

}

?>