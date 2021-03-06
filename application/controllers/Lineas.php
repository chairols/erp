<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas extends CI_Controller {

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
            'lineas_model',
            'log_model'
        ));
        $this->load->helper(array(
            'url'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Líneas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/lineas/js/listar.js'
        );

        $per_page = $this->parametros_model->get_valor_parametro_por_usuario('per_page', $data['session']['SID']);
        $per_page = $per_page['valor'];

        $where = $this->input->get();
        $where['estado'] = 'A';

        /*
         * inicio paginador
         */
        $total_rows = $this->lineas_model->get_cantidad_where($where);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/lineas/listar/';
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

        $data['lineas'] = $this->lineas_model->gets_where_limit($where, $per_page, $pagina);

        $data['view'] = 'lineas/listar';
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Línea';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/lineas/js/agregar.js'
        );

        $data['view'] = 'lineas/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('linea', 'Línea', 'required');
        $this->form_validation->set_rules('nombre_corto', 'Nombre Corto', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'linea' => $this->input->post('linea')
            );
            $resultado = $this->lineas_model->get_where($where);

            if ($resultado) { // Si ya existe la moneda
                $json = array(
                    'status' => 'error',
                    'data' => 'La línea <strong>' . $this->input->post('linea') . '</strong> ya existe.'
                );
                echo json_encode($json);
            } else {  // Si no existe la moneda, la creo
                $datos = array(
                    'linea' => $this->input->post('linea'),
                    'nombre_corto' => $this->input->post('nombre_corto'),
                    'idcreador' => $session['SID'],
                    'fecha_creacion' => date("Y-m-d H:i:s")
                );

                $id = $this->lineas_model->set($datos);

                if ($id) {
                    $log = array(
                        'tabla' => 'lineas',
                        'idtabla' => $id,
                        'texto' => 'Se agregó la línea: ' . $this->input->post('linea') .
                        '<br>Nombre Corto: ' . $this->input->post('nombre_corto'),
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
                        'data' => '<p>No se pudo agregar la línea.</p>'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function gets_lineas_ajax() {
        $where = $this->input->post();
        $lineas = $this->lineas_model->gets_where_para_ajax($where);

        echo json_encode($lineas);
    }

    public function modificar($idlinea = null) {
        $session = $this->session->all_userdata();
        if ($idlinea == null) {
            redirect('/lineas/listar/', 'refresh');
        }

        $data['title'] = 'Modificar Línea';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/lineas/js/modificar.js'
        );

        $where = array(
            'idlinea' => $idlinea,
            'estado' => 'A'
        );
        $data['linea'] = $this->lineas_model->get_where($where);

        $data['view'] = 'lineas/modificar';
        $this->load->view('layout/app', $data);
    }

    public function modificar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idlinea', 'ID de Línea', 'required|integer');
        $this->form_validation->set_rules('linea', 'Línea', 'required');
        $this->form_validation->set_rules('nombre_corto', 'Nombre Corto', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'linea' => $this->input->post('linea'),
                'nombre_corto' => $this->input->post('nombre_corto')
            );
            $where = array(
                'idlinea' => $this->input->post('idlinea')
            );
            $resultado = $this->lineas_model->update($datos, $where);

            if ($resultado) {
                $log = array(
                    'tabla' => 'lineas',
                    'idtabla' => $this->input->post('idlinea'),
                    'texto' => 'Se modificó la línea: ' . $this->input->post('linea') . '<br />
                    <p><strong>ID Linea: </strong>'.$this->input->post('idlinea').'<br />
                    <strong>Nombre Corto: </strong>' . $this->input->post('nombre_corto').'</p>',
                    'idusuario' => $session['SID'],
                    'tipo' => 'edit'
                );
                $this->log_model->set($log);
                
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se actualizó el artículo'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo actualizar el artículo'
                );
                echo json_encode($json);
            }
        }
    }
    
    public function borrar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idlinea', 'ID Línea', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'estado' => 'I'
            );
            $where = array(
                'idlinea' => $this->input->post('idlinea')
            );
            $resultado = $this->lineas_model->update($datos, $where);
            if ($resultado) {
                $where = array(
                    'idlinea' => $this->input->post('idlinea')
                );
                $linea = $this->lineas_model->get_where($where);
                
                $log = array(
                    'tabla' => 'lineas',
                    'idtabla' => $this->input->post('idlinea'),
                    'texto' => "<h2><strong>Se borró la línea (Borrado lógico): </strong>".$linea['linea']."</h2>",
                    'idusuario' => $session['SID'],
                    'tipo' => 'del'
                );
                $this->log_model->set($log);

                $json = array(
                    'status' => 'ok',
                    'data' => 'Se borró correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo borrar la retención.'
                );
                echo json_encode($json);
            }
        }
    }
}

?>
