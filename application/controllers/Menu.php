<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'pagination',
            'form_validation',
            'table'
        ));
        $this->load->model(array(
            'menu_model',
            'log_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function listar($pagina = 0) {
        $data['title'] = 'Listado de Menú';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();


        $per_page = 10;
        $titulo = '';
        if ($this->input->get('titulo') !== null) {
            $titulo = $this->input->get('titulo');
        }

        /*
         * inicio paginador
         */
        $total_rows = $this->menu_model->get_cantidad_pendientes($titulo);
        $config['reuse_query_string'] = TRUE;
        $config['base_url'] = '/menu/listar/';
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
        /*
         * fin paginador
         */

        $data['total_rows'] = $total_rows['cantidad'];

        $data['menues'] = $this->menu_model->gets_where_titulo_limit($titulo, $pagina, $per_page);

        foreach ($data['menues'] as $key => $value) {
            $datos = array(
                'idmenu' => $value['padre']
            );
            $data['menues'][$key]['padre'] = $this->menu_model->get_where($datos);
        }
        /*
          $data['mmenu'] = $this->menu_model->gets();
          foreach ($data['mmenu'] as $key => $value) {
          $datos = array(
          'idmenu' => $value['padre']
          );
          $data['mmenu'][$key]['padre'] = $this->menu_model->get_where($datos);
          } */

        $data['view'] = 'menu/listar';
        $this->load->view('layout/app', $data);
    }

    public function agregar() {
        $data['title'] = 'Agregar Menú';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/menu/js/agregar.js'
        );

        $data['padres'] = $this->menu_model->gets_padres_ordenados(0);
        foreach ($data['padres'] as $key => $value) {
            $data['padres'][$key]['hijos'] = $this->menu_model->gets_padres_ordenados($value['idmenu']);
        }

        $data['view'] = 'menu/agregar';
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('titulo', 'Título', 'required');
        $this->form_validation->set_rules('menu', 'Menú', 'required');
        $this->form_validation->set_rules('href', 'Link', 'required');
        $this->form_validation->set_rules('orden', 'Orden', 'required|integer');
        $this->form_validation->set_rules('padre', 'Padre', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'href' => $this->input->post('href')
            );
            $resultado = $this->menu_model->get_where($datos);

            /*
             * Compruebo si ya existe el link
             */
            if ($resultado && $datos['href'] != '#') {
                $json = array(
                    'status' => 'error',
                    'data' => '<p>El link ' . $resultado['href'] . ' ya se encuentra asociado al menú ' . $resultado['menu'] . '</p>'
                );
                echo json_encode($json);
            } else {
                $datos = array(
                    'icono' => $this->input->post('icono'),
                    'titulo' => $this->input->post('titulo'),
                    'menu' => $this->input->post('menu'),
                    'href' => $this->input->post('href'),
                    'orden' => $this->input->post('orden'),
                    'padre' => $this->input->post('padre')
                );

                if($this->input->post('visible') == 'true') {
                    $datos['visible'] = 1;
                } else {
                    $datos['visible'] = 0;
                }

                $id = $this->menu_model->set($datos);

                /*
                 * Compruebo si fue exitoso y agrego al log
                 */
                if ($id) {
                    $log = array(
                        'tabla' => 'menu',
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
