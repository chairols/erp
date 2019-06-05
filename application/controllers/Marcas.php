<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation'
        ));
        $this->load->model(array(
            'marcas_model',
            'log_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        $data['title'] = 'Listado de Marcas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = 10;
        $marca = '';
        if ($this->input->get('marca') !== null) {
            $marca = $this->input->get('marca');
        }
        /*
         * inicio paginador
         */
        $total_rows = $this->marcas_model->get_cantidad($marca, 'A');
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/marcas/listar/';
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

        $data['marcas'] = $this->marcas_model->gets_limit($marca, $pagina, $config['per_page'], 'A');

        $data['view'] = 'marcas/listar';
        $this->load->view('layout/app', $data);
    }

    public function gets_marcas_ajax() {
        $where = $this->input->post();
        echo json_encode($this->marcas_model->gets_where($where));
    }

    public function agregar() {
        $data['title'] = 'Agregar Marca';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/vendors/colorpicker/bootstrap-colorpicker.min.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/colorpicker/bootstrap-colorpicker.min.js',
            '/assets/modulos/marcas/js/agregar.js'
        );
        $data['view'] = 'marcas/agregar';


        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('marca', 'Marca', 'required');
        $this->form_validation->set_rules('nombre_corto', 'Nombre Corto', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'marca' => $this->input->post('marca'),
                'estado' => 'A'
            );
            $resultado = $this->marcas_model->get_where($where);
            if ($resultado) {  // Si la marca ya existe
                $json = array(
                    'status' => 'error',
                    'data' => 'La marca ' . $this->input->post('marca') . ' ya existe'
                );
                echo json_encode($json);
            } else {  // Si la marca no existe
                $datos = array(
                    'marca' => $this->input->post('marca'),
                    'nombre_corto' => $this->input->post('nombre_corto'),
                    'color_fondo' => $this->input->post('color_fondo'),
                    'color_letra' => $this->input->post('color_letra'),
                    'fecha_creacion' => date("Y-m-d H:i:s")
                );
                $id = $this->marcas_model->set($datos);
                if ($id) {  // Si la marca se creó
                    $log = array(
                        'tabla' => 'marcas',
                        'idtabla' => $id,
                        'texto' => "<h2><strong>Se agregó la marca: " . $this->input->post('marca') . "</strong></h2>
                    <p><strong>ID Marca: </strong>" . $id . "<br />
                    <strong>Nombre corto: </strong>" . $this->input->post('nombre_corto') . "<br />
                    <strong>Color de Fondo: </strong>" . $this->input->post('color_fondo') . "<br />
                    <strong>Color de Letra: </strong>" . $this->input->post('color_letra'),
                        'idusuario' => $session['SID'],
                        'tipo' => 'add'
                    );

                    $this->log_model->set($log);

                    $json = array(
                        'status' => 'ok',
                        'data' => 'La marca ' . $this->input->post('marca') . ' se creó correctamente'
                    );
                    echo json_encode($json);
                } else {  // Si la marca no se pudo crear
                    $json = array(
                        'status' => 'error',
                        'data' => 'La marca ' . $this->input->post('marca') . ' no se pudo crear'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

}

?>
